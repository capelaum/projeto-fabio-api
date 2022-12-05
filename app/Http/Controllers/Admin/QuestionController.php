<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Http\Resources\Admin\QuestionCollection;
use App\Http\Resources\Admin\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $questions = Question::query();

        $questions
            ->when($request->search,
                fn($query, $search) => $query->where('title', 'like', "%{$search}%"))
            ->when($request->active,
                fn($query, $approved) => $query->where('is_active', $approved))
            ->when($request->year,
                fn($query, $year) => $query->where('year', $year))
            ->when($request->category,
                fn($query, $category) => $query->where('category_id', $category))
            ->when($request->discipline,
                fn($query, $discipline) => $query->where('discipline_id', $discipline))
            ->when(
                $request->subject,
                fn($query, $subject) => $query->whereHas(
                    'subjects',
                    fn($query) => $query->where('subject_id', $subject)
                )
            );

        $activeCount = (clone $questions)->where('is_active', true)->count();
        $inactiveCount = (clone $questions)->where('is_active', false)->count();

        $questions->orderBy('updated_at', 'desc');

        $questions = $questions->paginate(12);

        return response()->json([
            'questions' => new QuestionCollection($questions),
            'meta' => [
                'activeCount' => $activeCount,
                'inactiveCount' => $inactiveCount,
                'total' => $questions->total(),
                'currentPage' => $questions->currentPage(),
                'lastPage' => $questions->lastPage(),
                'perPage' => $questions->perPage(),
                'from' => $questions->firstItem(),
                'to' => $questions->lastItem(),
            ],
            'links' => [
                'first' => $questions->url(1),
                'last' => $questions->url($questions->lastPage()),
                'prev' => $questions->previousPageUrl(),
                'next' => $questions->nextPageUrl(),
            ],
        ]);
    }

    /**
     * @param Question $question
     * @return QuestionResource
     */
    public function show(Question $question): QuestionResource
    {
        return new QuestionResource($question);
    }

    /**
     * @param StoreQuestionRequest $request
     * @return JsonResponse
     */
    public function store(StoreQuestionRequest $request): JsonResponse
    {
        $question = Question::create($request->validated());

        $question->subjects()->sync($request->subjects);

        $this->createAlternatives($request, $question);
        $this->createLinks($request, $question);

        return response()->json([
            'message' => 'Questão cadastrada com sucesso!',
            'question' => new QuestionResource($question)
        ], 201);
    }

    /**
     * @param UpdateQuestionRequest $request
     * @param Question $question
     * @return JsonResponse
     */
    public function update(UpdateQuestionRequest $request, Question $question): JsonResponse
    {
        $question->update($request->validated());

        $question->subjects()->sync($request->subjects);
        $question->alternatives()->delete();
        $question->links()->delete();

        $this->createAlternatives($request, $question);
        $this->createLinks($request, $question);

        return response()->json([
            'message' => 'Questão atualizada com sucesso!',
            'question' => new QuestionResource($question)
        ], 200);
    }

    /**
     * @param Question $question
     * @return JsonResponse
     */
    public function destroy(Question $question): JsonResponse
    {
        $question->delete();

        return response()->json([
            'message' => 'Questão excluída com sucesso!'
        ], 200);
    }

    /**
     * @param UpdateQuestionRequest|StoreQuestionRequest $request
     * @param Question $question
     * @return void
     */
    public function createAlternatives(
        UpdateQuestionRequest|StoreQuestionRequest $request,
        Question $question
    ): void {
        $alternatives = [];

        foreach ($request->alternatives as $alternative) {
            $alternatives[] = [
                'letter' => $alternative['letter'],
                'content' => $alternative['content'],
                'is_correct' => $alternative['is_correct'],
                'question_id' => $question->id
            ];
        }

        $question->alternatives()->createMany($alternatives);
    }

    /**
     * @param UpdateQuestionRequest|StoreQuestionRequest $request
     * @param Question $question
     * @return void
     */
    public function createLinks(
        UpdateQuestionRequest|StoreQuestionRequest $request,
        Question $question
    ): void {
        if (!empty($request->links)) {
            $links = [];

            foreach ($request->links as $link) {
                $links[] = [
                    'title' => $link['title'],
                    'url' => $link['url'],
                    'type' => $link['type'],
                    'question_id' => $question->id
                ];
            }

            $question->links()->createMany($links);
        }
    }

    public function years()
    {
        // get unique years, sort descending and turn into array of numbers
        $years = Question::select('year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->get()
            ->pluck('year')
            ->map(fn($year) => (string)$year);

        return response()->json($years);
    }
}

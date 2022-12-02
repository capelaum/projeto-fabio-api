<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Resources\Admin\QuestionCollection;
use App\Http\Resources\Admin\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @param Request $request
     * @return QuestionCollection
     */
    public function index(Request $request): QuestionCollection
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

        $questions = $questions->paginate(12);

        return new QuestionCollection($questions);
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

        return response()->json([
            'message' => 'Questão cadastrada com sucesso!',
            'question' => new QuestionResource($question)
        ], 201);
    }
}

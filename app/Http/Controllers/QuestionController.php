<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionCollection;
use App\Models\Question;
use App\Models\User;
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
            ->where('is_active', true)
            ->when($request->search,
                fn($query, $search) => $query->where('title', 'like', "%{$search}%"))
            ->when($request->category,
                fn($query, $category) => $query->where('category_id', $category))
            ->when($request->year,
                fn($query, $year) => $query->where('year', $year))
            ->when($request->discipline,
                fn($query, $discipline) => $query->where('discipline_id', $discipline))
            ->when(
                $request->subject,
                fn($query, $subject) => $subject === 'none'
                    ? $query->doesntHave('subjects')
                    : $query->whereHas('subjects', fn($query) => $query->where('id', $subject)
                    )
            )
            ->when($request->answer && $request->user,
                function ($query, $answer) use ($request) {
                    if ($request->answer === 'isNotAnswered') {
                        $query->whereDoesntHave('answeredQuestions',
                            fn($query) => $query->where('user_id', $request->user));
                    } else {
                        $query->whereHas('answeredQuestions',
                            fn($query) => $query->where('user_id', $request->user));

                        if ($request->answer === 'isCorrect') {
                            $query->whereHas('answeredQuestions',
                                fn($query) => $query->where('is_correct', true));
                        }

                        if ($request->answer === 'isWrong') {
                            $query->whereHas('answeredQuestions',
                                fn($query) => $query->where('is_correct', false));
                        }
                    }
                }
            );

        $questions->orderBy('title');

        $questions = $questions->paginate(5);

        return response()->json([
            'questions' => new QuestionCollection($questions),
            'meta' => [
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
}

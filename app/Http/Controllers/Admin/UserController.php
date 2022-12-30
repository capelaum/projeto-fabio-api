<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\AnsweredQuestionCollection;
use App\Http\Resources\Admin\UserCollection;
use App\Http\Resources\Admin\UserSingleResource;
use App\Models\AnsweredQuestion;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $users = User::query();

        $users->when($request->search, fn($query, $search) => $query->where('name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%"));

        $answeredQuestionsCount = (clone $users)->whereHas('answeredQuestions')->count();

        $users->orderBy('name', 'asc');

        $users = $users->paginate(12);

        return response()->json([
            'users' => new UserCollection($users),
            'meta' => [
                'answeredQuestionsCount' => $answeredQuestionsCount,
                'total' => $users->total(),
                'currentPage' => $users->currentPage(),
                'lastPage' => $users->lastPage(),
                'perPage' => $users->perPage(),
                'from' => $users->firstItem(),
                'to' => $users->lastItem(),
            ],
            'links' => [
                'first' => $users->url(1),
                'last' => $users->url($users->lastPage()),
                'prev' => $users->previousPageUrl(),
                'next' => $users->nextPageUrl(),
            ]
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     */
    public function answers(Request $request, User $user): JsonResponse
    {
        $userAnsweredQuestions = AnsweredQuestion::query();

        $userAnsweredQuestions
            ->where('user_id', $user->id)
            ->when($request->search,
                fn($query, $search) => $query->whereHas('question',
                    fn($query) => $query->where('title', 'like', "%{$search}%")
                )
            );

        $correctCount = (clone $userAnsweredQuestions)->where('is_correct', true)->count();
        $wrongCount = (clone $userAnsweredQuestions)->where('is_correct', false)->count();

        $userAnsweredQuestions->orderBy('updated_at', 'desc');

        $userAnsweredQuestions = $userAnsweredQuestions->paginate(12);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatarUrl' => $user->avatar_url,
                'answeredQuestions' => new AnsweredQuestionCollection($userAnsweredQuestions),
            ],
            'meta' => [
                'correctCount' => $correctCount,
                'wrongCount' => $wrongCount,
                'total' => $userAnsweredQuestions->total(),
                'currentPage' => $userAnsweredQuestions->currentPage(),
                'lastPage' => $userAnsweredQuestions->lastPage(),
                'perPage' => $userAnsweredQuestions->perPage(),
                'from' => $userAnsweredQuestions->firstItem(),
                'to' => $userAnsweredQuestions->lastItem(),
            ],
            'links' => [
                'first' => $userAnsweredQuestions->url(1),
                'last' => $userAnsweredQuestions->url($userAnsweredQuestions->lastPage()),
                'prev' => $userAnsweredQuestions->previousPageUrl(),
                'next' => $userAnsweredQuestions->nextPageUrl(),
            ]
        ]);
    }
}

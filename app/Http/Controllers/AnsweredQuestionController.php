<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnsweredQuestionRequest;
use App\Http\Requests\UpdateAnsweredQuestionRequest;
use App\Http\Resources\AnsweredQuestionCollection;
use App\Models\AnsweredQuestion;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnsweredQuestionController extends Controller
{
    /**
     * @return AnsweredQuestionCollection
     */
    public function index(): AnsweredQuestionCollection
    {
        $answeredQuestions = auth()->user()->answeredQuestions;

        return new AnsweredQuestionCollection($answeredQuestions);
    }

    /**
     * @param StoreAnsweredQuestionRequest $request
     * @return JsonResponse
     */
    public function store(StoreAnsweredQuestionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $answeredQuestion = AnsweredQuestion::create($data);

        return response()->json([
            'message' => 'Resposta salva com sucesso!',
            'answeredQuestion' => $answeredQuestion
        ], 201);
    }

    /**
     * @param UpdateAnsweredQuestionRequest $request
     * @param Question $answeredQuestion
     * @return JsonResponse
     */
    public function update(UpdateAnsweredQuestionRequest $request, Question $answeredQuestion): JsonResponse
    {
        $answeredQuestion = AnsweredQuestion::where('user_id', auth()->user()->id)
            ->where('question_id', $answeredQuestion->id);

        if(!$answeredQuestion) {
            return response()->json([
                'message' => 'Resposta não encontrada!'
            ], 404);
        }

        $answeredQuestion->update($request->validated());

        return response()->json([
            'message' => 'Resposta atualizada com sucesso!',
            'answeredQuestion' => $answeredQuestion
        ], 200);
    }
}

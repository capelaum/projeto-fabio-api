<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnsweredQuestionRequest;
use App\Http\Requests\UpdateAnsweredQuestionRequest;
use App\Models\AnsweredQuestion;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnsweredQuestionController extends Controller
{
    /**
     * @param StoreAnsweredQuestionRequest $request
     * @return JsonResponse
     */
    public function store(StoreAnsweredQuestionRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $answeredQuestion = AnsweredQuestion::create($data);

        return response()->json([
            'message' => 'Resposta salva com sucesso!',
            'answeredQuestion' => $answeredQuestion
        ], 201);
    }

    public function update(UpdateAnsweredQuestionRequest $request, Question $question)
    {
        $answeredQuestion = AnsweredQuestion::where('user_id', auth()->id())
            ->where('question_id', $question->id)
            ->first();

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

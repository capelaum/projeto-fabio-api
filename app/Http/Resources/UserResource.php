<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatarUrl' => $this->avatar_url,
            'isAdmin' => $this->is_admin,
            'answeredQuestions' => $this->answeredQuestions->map(function ($answeredQuestion) {
                return [
                    'id' => $answeredQuestion->question->id,
                    'alternativeIdSelected' => $answeredQuestion->alternative_id,
                    'isCorrect' => $answeredQuestion->is_correct,
                    'answeredAt' => date('d/m/Y', strtotime($answeredQuestion->updated_at))
                ];
            }),
            'createdAt' => date('d/m/Y', strtotime($this->created_at)),
            'updatedAt' => date('d/m/Y', strtotime($this->updated_at))
        ];
    }
}

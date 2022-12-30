<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSingleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
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
                    'question' => [
                        'id' => $answeredQuestion->question->id,
                        'content' => $answeredQuestion->question->content,
                        'year' => $answeredQuestion->question->year,
                        'discipline' => [
                            'id' => $answeredQuestion->question->discipline->id,
                            'name' => $answeredQuestion->question->discipline->name,
                        ],
                        'category' => [
                            'id' => $answeredQuestion->question->category->id,
                            'name' => $answeredQuestion->question->category->name,
                        ],
                        'subjects' => $answeredQuestion->question->subjects->map(function ($subject) {
                            return [
                                'id' => $subject->id,
                                'name' => $subject->name,
                            ];
                        }),
                    ],
                    'isCorrect' => $answeredQuestion->is_correct,
                    'createdAt' => date('d/m/Y', strtotime($answeredQuestion->created_at)),
                    'updatedAt' => date('d/m/Y', strtotime($answeredQuestion->updated_at))
                ];
            }),
            'createdAt' => date('d/m/Y', strtotime($this->created_at)),
            'updatedAt' => date('d/m/Y', strtotime($this->updated_at))
        ];
    }
}

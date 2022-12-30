<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'answeredQuestions' => [
                'count' => $this->answeredQuestions->count(),
                'correctCount' => $this->answeredQuestions->where('is_correct', true)->count(),
                'wrongCount' => $this->answeredQuestions->where('is_correct', false)->count(),
            ],
            'createdAt' => date('d/m/Y', strtotime($this->created_at)),
            'updatedAt' => date('d/m/Y', strtotime($this->updated_at))
        ];
    }
}

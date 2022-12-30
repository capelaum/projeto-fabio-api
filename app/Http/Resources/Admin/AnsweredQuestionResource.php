<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnsweredQuestionResource extends JsonResource
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
            'id' => $this->question->id,
            'title' => $this->question->title,
            'year' => $this->question->year,
            'discipline' => [
                'id' => $this->question->discipline->id,
                'name' => $this->question->discipline->name,
            ],
            'category' => [
                'id' => $this->question->category->id,
                'name' => $this->question->category->name,
            ],
            'subjects' => $this->question->subjects->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'name' => $subject->name,
                ];
            }),
            'isCorrect' => $this->is_correct,
            'createdAt' => date('d/m/Y', strtotime($this->created_at)),
            'updatedAt' => date('d/m/Y', strtotime($this->updated_at))
        ];
    }
}

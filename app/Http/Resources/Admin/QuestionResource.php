<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'discipline' => [
                'id' => $this->discipline->id,
                'name' => $this->discipline->name,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'subjects' => $this->subjects->map(function ($subject) {
                return [
                    'id' => $subject->id,
                    'name' => $subject->name,
                ];
            }),
            'alternatives' => $this->alternatives->map(function ($alternative) {
                return [
                    'id' => $alternative->id,
                    'content' => $alternative->content,
                    'letter' => $alternative->letter,
                    'is_correct' => $alternative->is_correct,
                ];
            }),
            'title' => $this->title,
            'content' => $this->content,
            'year' => $this->year,
            'imageUrl' => $this->image_url,
            'isActive' => $this->is_active,
            'createdAt' => date('d/m/Y', strtotime($this->created_at)),
            'updatedAt' => date('d/m/Y', strtotime($this->updated_at))
        ];
    }
}

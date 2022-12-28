<?php

namespace App\Http\Resources;

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
                    'isCorrect' => $alternative->is_correct,
                ];
            }),
            'links' => $this->links->map(function ($link) {
                return [
                    'id' => $link->id,
                    'title' => $link->title,
                    'url' => $link->url,
                    'type' => $link->type,
                ];
            }),
            'title' => $this->title,
            'content' => $this->content,
            'year' => $this->year,
            'isActive' => $this->is_active,
        ];
    }
}

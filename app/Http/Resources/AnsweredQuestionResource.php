<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnsweredQuestionResource extends JsonResource
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
            'id' => $this->question->id,
            'alternativeIdSelected' => $this->alternative_id,
            'isCorrect' => $this->is_correct,
            'answeredAt' => date('d/m/Y', strtotime($this->updated_at))
        ];
    }
}

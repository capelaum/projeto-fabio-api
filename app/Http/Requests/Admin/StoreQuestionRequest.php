<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id' => 'required|integer|exists:categories,id',
            'discipline_id' => 'required|integer|exists:disciplines,id',
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:3',
            'year' => 'required|integer|min:1700|max:' . date('Y'),
            'subjects' => 'nullable|array',
            'subjects.*' => 'nullable|integer|exists:subjects,id',
            'image' => 'nullable|file|mimes:jpeg,jpeg,png,svg,webp|max:4096',
            'is_active' => 'required|boolean',
            'links' => 'nullable|array',
            'links.*.title' => 'required|string|min:3|max:255',
            'links.*.url' => 'required|string|min:3|max:1000',
            'links.*.type' => 'required|string|min:3|max:255|in:Geral,Youtube',
            'alternatives' => [
                'required',
                'array',
                'min:2',
                'max:5',
                function ($attribute, $value, $fail) {
                    $corrects = 0;
                    $letters = [];

                    foreach ($value as $alternative) {
                        if ($alternative['is_correct']) {
                            $corrects++;
                        }

                        $letters[] = $alternative['letter'];
                    }

                    if ($corrects !== 1) {
                        $fail('O campo alternativas deve conter apenas 1 alternativa correta.');
                    }

                    if(count($value) === 2 && $letters !== ['A', 'B']) {
                        $fail('Questão com 2 alternativas deve conter apenas as letras A e B.');
                    }

                    if(count($value) === 3 && $letters !== ['A', 'B', 'C']) {
                        $fail('Questão com 3 alternativas deve conter apenas as letras A, B e C.');
                    }

                    if(count($value) === 4 && $letters !== ['A', 'B', 'C', 'D']) {
                        $fail('Questão com 4 alternativas deve conter apenas as letras A, B, C e D.');
                    }

                    if(count($value) === 5 && $letters !== ['A', 'B', 'C', 'D', 'E']) {
                        $fail('Questão com 5 alternativas deve conter apenas as letras A, B, C, D e E.');
                    }
                },
            ],
            'alternatives.*.content' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'alternatives.*.is_correct' => 'required|boolean',
            'alternatives.*.letter' => [
                'required',
                'string',
                'size:1',
                'in:A,B,C,D,E',
            ],
        ];
    }
}

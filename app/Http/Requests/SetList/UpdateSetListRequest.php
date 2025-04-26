<?php

namespace App\Http\Requests\SetList;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSetListRequest extends FormRequest
{
    /**
     * Визначає, чи має користувач дозвіл на виконання цього запиту.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('update', $this->route('setList'));
    }

    /**
     * Отримує правила валідації, які застосовуються до запиту.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('set_lists')
                    ->where('band_id', $this->band_id)
                    ->ignore($this->route('setList')->id),
            ],
            'band_id' => [
                'required',
                'ulid',
                'exists:bands,id',
                // Перевірка, чи є користувач лідером цього гурту
                function ($attribute, $value, $fail) {
                    if (! auth()->user()->bands()->where('band_id', $value)->wherePivot('is_leader', true)->exists()) {
                        $fail(__('setlist.not_leader'));
                    }
                },
            ],
            'performed_at' => ['nullable', 'date'],
        ];
    }
}

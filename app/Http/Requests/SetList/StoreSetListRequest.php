<?php

namespace App\Http\Requests\SetList;

use App\Models\SetList;
use Illuminate\Foundation\Http\FormRequest;

class StoreSetListRequest extends FormRequest
{
    /**
     * Визначає, чи має користувач дозвіл на виконання цього запиту.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create', SetList::class);
    }

    /**
     * Отримує правила валідації, які застосовуються до запиту.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
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
            'performed_at' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }
}

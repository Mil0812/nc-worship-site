<?php

namespace App\Http\Requests\Band;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * @property string $name
 * @property UploadedFile|null $image
 */
class UpdateBandRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user !== null && ($user->isAdmin() || $this->band->users()->where('user_id', $user->id)->wherePivot('is_leader', true)->exists());
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:30', Rule::unique('bands')->ignore($this->band->id)],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ];
    }
}

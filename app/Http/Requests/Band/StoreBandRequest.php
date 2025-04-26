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
class StoreBandRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();

        return $user !== null && ($user->isAdmin() || $user->isGroupMember());
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:30', Rule::unique('bands')],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ];
    }
}

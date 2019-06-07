<?php

namespace App\Http\Requests\User;

use App\Components\Permission;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property User $user
 */
class UserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $unique = '|unique:users,email' . ($this->user ? ',' . $this->user->id : '');

        return [
            'name'         => 'required|string|min:3|max:255',
            'email'        => 'required|string|email|max:255' . $unique,
            'permission.*' => ['required', 'string', Rule::in(Permission::all())],
        ];
    }
}
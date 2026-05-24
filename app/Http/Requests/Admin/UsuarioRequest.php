<?php

namespace App\Http\Requests\Admin;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $id = $this->route('usuario')?->id;
        $creating = $this->isMethod('POST');

        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', Rule::unique('users', 'email')->ignore($id)],
            'empresa_id' => ['required', 'integer', Rule::exists('empresas', 'id')],
            'role'       => ['required', Rule::enum(UserRole::class)],
            'password'   => $creating
                ? ['required', Password::defaults()]
                : ['nullable', Password::defaults()],
        ];
    }
}

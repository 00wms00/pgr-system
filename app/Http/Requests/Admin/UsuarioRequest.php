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
        return true;
    }

    public function rules(): array
    {
        $usuario = $this->route('usuario'); // null no create
        $isEdit  = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name'       => ['required', 'string', 'max:255'],
            'email'      => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($usuario?->id),
            ],
            'password'   => $isEdit
                ? ['nullable', 'confirmed', Password::min(8)]
                : ['required', 'confirmed', Password::min(8)],
            'role'       => ['required', Rule::enum(UserRole::class)],
            'empresa_id' => ['required', 'exists:empresas,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'       => 'nome',
            'email'      => 'e-mail',
            'password'   => 'senha',
            'role'       => 'perfil',
            'empresa_id' => 'empresa',
        ];
    }
}

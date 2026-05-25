<?php

namespace App\Http\Requests;

use App\Enums\TipoRegistro;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateResponsavelTecnicoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome'            => ['required', 'string', 'max:255'],
            'formacao'        => ['required', 'string', 'max:255'],
            'especializacao'  => ['nullable', 'string', 'max:255'],
            'tipo_registro'   => ['required', new Enum(TipoRegistro::class)],
            'numero_registro' => ['required', 'string', 'max:30'],
            'uf_registro'     => ['nullable', 'string', 'size:2'],
            'numero_art_rrt'  => ['nullable', 'string', 'max:50'],
            'data_art_rrt'    => ['nullable', 'date'],
            'email'           => ['nullable', 'email', 'max:255'],
            'telefone'        => ['nullable', 'string', 'max:20'],
        ];
    }
}

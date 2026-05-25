<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmpresaElaboradoraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // autorização gerenciada pela Policy via authorizeResource
    }

    public function rules(): array
    {
        $empresaId = $this->route('empresa_elaboradora')?->id;

        return [
            // ── Obrigatórios ────────────────────────────────────────────────
            'razao_social'              => ['required', 'string', 'max:255'],
            'cnpj'                      => [
                'required',
                'string',
                'max:18',
                Rule::unique('empresas_elaboradoras', 'cnpj')->ignore($empresaId),
            ],

            // ── Opcionais — empresa ─────────────────────────────────────────
            'nome_fantasia'             => ['nullable', 'string', 'max:255'],
            'cnae_principal'            => ['nullable', 'string', 'max:20'],
            'cnae_descricao'            => ['nullable', 'string', 'max:255'],
            'logradouro'                => ['nullable', 'string', 'max:255'],
            'numero'                    => ['nullable', 'string', 'max:20'],
            'complemento'               => ['nullable', 'string', 'max:100'],
            'bairro'                    => ['nullable', 'string', 'max:100'],
            'cidade'                    => ['nullable', 'string', 'max:100'],
            'uf'                        => ['nullable', 'string', 'size:2'],
            'cep'                       => ['nullable', 'string', 'max:9'],
            'telefone'                  => ['nullable', 'string', 'max:20'],
            'email'                     => ['nullable', 'email', 'max:255'],
            'site'                      => ['nullable', 'url', 'max:255'],

            // ── Opcionais — responsável técnico ─────────────────────────────
            'responsavel_nome'          => ['nullable', 'string', 'max:255'],
            'responsavel_formacao'      => ['nullable', 'string', 'max:255'],
            'responsavel_especializacao'=> ['nullable', 'string', 'max:255'],
            'responsavel_registro_tipo' => ['nullable', 'string', 'max:20'],
            'responsavel_registro_numero'=> ['nullable', 'string', 'max:50'],
            'responsavel_rnp'           => ['nullable', 'string', 'max:30'],
            'responsavel_cpf'           => ['nullable', 'string', 'max:14'],
            'responsavel_nit'           => ['nullable', 'string', 'max:20'],
            'responsavel_cargo'         => ['nullable', 'string', 'max:255'],
            'ativo'                     => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'razao_social.required'  => 'A razão social é obrigatória.',
            'cnpj.required'          => 'O CNPJ é obrigatório.',
            'cnpj.unique'            => 'Este CNPJ já está cadastrado.',
            'email.email'            => 'Informe um e-mail válido.',
            'site.url'               => 'Informe uma URL válida (ex: https://empresa.com.br).',
            'uf.size'                => 'Informe a UF com 2 letras (ex: SP).',
        ];
    }
}

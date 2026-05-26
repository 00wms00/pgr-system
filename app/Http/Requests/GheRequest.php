<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GheRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'setor_id'            => ['required', 'exists:setores,id'],
            'codigo'              => ['required', 'string', 'max:20'],
            'nome'                => ['required', 'string', 'max:255'],
            'qtd_funcionarios'    => ['nullable', 'integer', 'min:0', 'max:99999'],
            'descricao_atividades'=> ['nullable', 'string', 'max:5000'],
            'descricao_ambiente'  => ['nullable', 'string', 'max:5000'],
            'ativo'               => ['boolean'],

            // CBOs — array de objetos {codigo, descricao}
            'cbos'                => ['nullable', 'array', 'max:50'],
            'cbos.*.codigo'       => ['required_with:cbos.*', 'string', 'max:10'],
            'cbos.*.descricao'    => ['required_with:cbos.*', 'string', 'max:200'],

            // Cargos — array de strings
            'cargos'              => ['nullable', 'array', 'max:100'],
            'cargos.*'            => ['required_with:cargos', 'string', 'max:150'],
        ];
    }

    public function attributes(): array
    {
        return [
            'setor_id'            => 'setor',
            'codigo'              => 'código',
            'nome'                => 'nome',
            'qtd_funcionarios'    => 'quantidade de funcionários',
            'descricao_atividades'=> 'descrição das atividades',
            'descricao_ambiente'  => 'descrição do ambiente',
            'cbos.*.codigo'       => 'código CBO',
            'cbos.*.descricao'    => 'descrição CBO',
            'cargos.*'            => 'cargo/função',
        ];
    }
}

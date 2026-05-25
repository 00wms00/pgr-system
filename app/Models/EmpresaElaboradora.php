<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpresaElaboradora extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'empresas_elaboradoras';

    protected $fillable = [
        'razao_social',
        'nome_fantasia',
        'cnpj',
        'cnae_principal',
        'cnae_descricao',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'cep',
        'telefone',
        'email',
        'site',
        // Responsável técnico
        'responsavel_nome',
        'responsavel_formacao',
        'responsavel_especializacao',
        'responsavel_registro_tipo',  // CREA, CRBio, etc.
        'responsavel_registro_numero',
        'responsavel_rnp',
        'responsavel_cpf',
        'responsavel_nit',
        'responsavel_cargo',          // Engenheiro de Segurança, Técnico de Segurança
        'ativo',
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];

    // ── Relacionamentos ──────────────────────────────────────────────────────

    /**
     * Uma empresa elaboradora pode elaborar PGRs de várias empresas contratantes.
     */
    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'empresa_elaboradora_id');
    }

    // ── Accessors ────────────────────────────────────────────────────────────

    public function getCnpjFormatadoAttribute(): string
    {
        $cnpj = preg_replace('/\D/', '', $this->cnpj ?? '');
        if (strlen($cnpj) === 14) {
            return sprintf(
                '%s.%s.%s/%s-%s',
                substr($cnpj, 0, 2),
                substr($cnpj, 2, 3),
                substr($cnpj, 5, 3),
                substr($cnpj, 8, 4),
                substr($cnpj, 12, 2)
            );
        }
        return $this->cnpj ?? '';
    }

    public function getEnderecoCompletoAttribute(): string
    {
        return implode(', ', array_filter([
            $this->logradouro,
            $this->numero,
            $this->complemento,
            $this->bairro,
            $this->cidade . ' - ' . $this->uf,
            'CEP ' . $this->cep,
        ]));
    }
}

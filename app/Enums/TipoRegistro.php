<?php

namespace App\Enums;

enum TipoRegistro: string
{
    case CREA = 'CREA';
    case CRQ  = 'CRQ';
    case RNP  = 'RNP';
    case MTE  = 'MTE';
    case CFQ  = 'CFQ';
    case CFTA = 'CFTA';

    public function label(): string
    {
        return match($this) {
            self::CREA => 'CREA — Conselho Regional de Engenharia e Agronomia',
            self::CRQ  => 'CRQ — Conselho Regional de Química',
            self::RNP  => 'RNP — Registro Nacional de Profissionais (MTE)',
            self::MTE  => 'MTE — Ministério do Trabalho e Emprego',
            self::CFQ  => 'CFQ — Conselho Federal de Química',
            self::CFTA => 'CFTA — Conselho Federal de Técnicos Agrícolas',
        };
    }

    public static function options(): array
    {
        return array_map(
            fn($case) => ['value' => $case->value, 'label' => $case->label()],
            self::cases()
        );
    }
}

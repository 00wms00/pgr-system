// app/Enums/UserRole.php
<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin   = 'admin';
    case Gestor  = 'gestor';
    case Usuario = 'usuario';

    public function label(): string
    {
        return match($this) {
            self::Admin   => 'Administrador',
            self::Gestor  => 'Gestor',
            self::Usuario => 'Usuário',
        };
    }

    public function canWrite(): bool
    {
        return in_array($this, [self::Admin, self::Gestor]);
    }
}
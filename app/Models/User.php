<?php

namespace App\Models;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'empresa_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => UserRole::class,
        ];
    }

    // ----------------------------------------------------------------
    // Relacionamentos
    // ----------------------------------------------------------------

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    // ----------------------------------------------------------------
    // Helpers de role
    // ----------------------------------------------------------------

    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isGestor(): bool
    {
        return $this->role === UserRole::Gestor;
    }

    public function canWrite(): bool
    {
        return $this->role?->canWrite() ?? false;
    }
}

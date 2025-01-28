<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_judge',
        'is_reception',
        'is_dashboard',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'evaluation') {
            return $this->is_judge;
        }

        if ($panel->getId() === 'attendance') {
            return $this->is_reception;
        }

        if ($panel->getId() === 'admin') {
            return $this->is_admin;
        }

        return true;

    }
     public function is_admin():bool
     {
         return ($this->email == "admin@mkc.pt");
     }
    public function getInfoAttribute()
    {
        return "Utilizador: " . $this->email . " Password: 12345678";
    }

    public function judge()
    {
        return $this->hasOne(Judge::class, 'user_id'); // Certifique-se de que 'user_id' é a chave estrangeira na tabela 'judges'
    }

    public function isJudge(): bool
    {
        return $this->is_judge; // Supondo que `is_judge` seja o campo booleano.
    }
}

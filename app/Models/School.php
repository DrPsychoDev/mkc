<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'photo',
        'name',
    ];

    /**
     * Relacionamento com o modelo Participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * Relacionamento com o modelo Judge.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function judges()
    {
        return $this->hasMany(Judge::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'identification',
        'question',
        'memory',
        'division_id',
        'tatami_id',
    ];

    /**
     * Relacionamento com o modelo Division.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    /**
     * Relacionamento com o modelo Evaluation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
    /**
     * Relacionamento com o modelo Tatami.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tatami()
    {
        return $this->belongsTo(Tatami::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'photo',
        'name',
        'birthday',
        'school_id',
        'division_id',
        'is_present',
        'has_dropped_out',
        'absence_reason',
        'dropout_reason',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'birthday' => 'date',
    ];

    /**
     * Relação com a escola (School).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Relação com a divisão (Division).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function division()
    {
        return $this->belongsTo(Division::class);
    }
    // Define o relacionamento com Evaluation
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    // Accessor para calcular a soma das avaliações
    public function getTotalEvaluationAttribute()
    {
        return $this->evaluations()->sum('evaluation') ?? 0;
    }

    // Accessor para verificar se já iniciou a prova
    public function getHasStartedAttribute(): bool
    {
        return $this->evaluations()->whereNotNull('evaluation')->exists();
    }

    // Accessor para verificar se já concluiu a prova
    public function getHasCompletedAttribute(): bool
    {
        $totalQuestions = \App\Models\Question::count();
        $answeredQuestions = $this->evaluations()
            ->whereNotNull('evaluation')
            ->count();

        return $totalQuestions > 0 && $answeredQuestions === $totalQuestions;
    }

    // Accessor para o status
    public function getStatusAttribute(): int
    {
        $totalQuestions = \App\Models\Question::count();
        $answeredQuestions = $this->evaluations()
            ->whereNotNull('evaluation')
            ->count();

        if ($answeredQuestions === 0) {
            return 0; // Não começou
        } elseif ($answeredQuestions < $totalQuestions) {
            return 1; // Já iniciou
        } else {
            return 2; // Já concluiu
        }
    }

    public function getShortNameAttribute(): string
    {
        $nameParts = explode(' ', trim($this->name));

        // Pega o primeiro e o último nome
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[count($nameParts) - 1] ?? '';

        // Monta o email no formato solicitado
        return $firstName . ' ' . $lastName;
    }

}

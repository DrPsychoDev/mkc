<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    /**
     * Os campos que podem ser preenchidos em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'participant_id',
        'school_id',
        'division_id',
        'tatami_id',
        'question_id',
        'judge_id',
        'evaluation',
        'evaluated_at',
    ];

    protected static function booted():void
    {
        static::saving(function ($evaluation) {
            if (!is_null($evaluation->evaluation)) {
                $evaluation->evaluated_at = now();
            }
        });
    }

    /**
     * Relacionamento com o modelo Participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
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
     * Relacionamento com o modelo Question.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function judge()
    {
        return $this->belongsTo(Judge::class);
    }
    // Accessor para a soma das avaliações por participante
    public function getTotalEvaluationsForParticipantAttribute()
    {
        return self::where('participant_id', $this->participant_id)
            ->sum('evaluation') ?? 0;
    }

    public function getIsEvaluationReadyAttribute()
    {
        $participants = Participant::count();
        $questions = Question::count();

        return $participants * $questions;
    }

    /**
    * Acessor para obter a divisão do participante.
    */
    public function getPhotoAttribute()
    {
        // Certifique-se de que a relação com o participante está definida
        return $this->participant->photo ?? null;
    }

    /**
     * Acessor para obter a divisão do participante.
     */
    public function getDivisionAttribute()
    {
        return $this->participant->division->name ?? null;
    }

    /**
     * Verifica se o participante respondeu a todas as perguntas.
     */
    public function getIsEvaluationDoneAttribute(): bool
    {
        // Total de perguntas que o participante deveria responder
        $totalQuestions = \App\Models\Question::count();

        // Total de perguntas respondidas (evaluation não é null)
        $answeredQuestions = self::where('participant_id', $this->participant_id)
            ->whereNotNull('evaluation')
            ->distinct('question_id')
            ->count('question_id');

        // Se o número de perguntas respondidas é igual ao total de perguntas, retorna true
        return $totalQuestions === $answeredQuestions;
    }

    public static function startEvaluations()
    {
        // Carrega todos os participantes com suas divisions
        $participants = Participant::where('is_present', 1)->where('has_dropped_out', 0)->get();

        foreach ($participants as $participant) {
            if (!$participant->division_id) {
                continue; // Ignora participantes sem division atribuída
            }

            // Obtém as perguntas relacionadas ao escalão do participante
            $questions = Question::where('division_id', $participant->division_id)->get();

            // Obtém os juízes responsáveis pelo escalão do participante
            $judges = Judge::whereHas('divisions', function ($query) use ($participant) {
                $query->where('divisions.id', $participant->division_id);
            })->get();

            foreach ($questions as $question) {
                foreach ($judges as $judge) {
                    if ($question->tatami_id !== $judge->tatami_id) {
                        continue; // Pula para o próximo juiz
                    }

                    if ($judge->is_substitute){
                        continue; // Pula para o próximo juiz
                    }

                    // Evita duplicar avaliações já existentes
                    Evaluation::updateOrCreate(
                        [
                            'participant_id' => $participant->id,
                            'division_id' => $participant->division_id,
                            'school_id' => $participant->school_id,
                            'question_id' => $question->id,
                            'tatami_id' => $question->tatami_id,
                            'judge_id' => $judge->id,
                        ],
                        [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }
    }
}

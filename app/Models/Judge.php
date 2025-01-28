<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Judge extends Model
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
        'school_id',
        'user_id',
        'tatami_id',
        'is_substitute',
        'email',
        'password'
    ];

    /**
     * Relacionamento com o modelo School.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function getAccessAttribute()
    {
      return $this->user->info;
    }
    /**
     * Relacionamento com o modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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

    /**
     * Relacionamento com o modelo Division (tabela pivot).
     */
    public function divisions()
    {
        return $this->belongsToMany(Division::class, 'division_judge')
            ->withTimestamps();
    }

    public static function generateEmail(string $fullName): string
    {
        $nameParts = explode(' ', trim($fullName));

        // Pega o primeiro e o último nome
        $firstName = $nameParts[0] ?? '';
        $lastName = $nameParts[count($nameParts) - 1] ?? '';

        // Monta o email no formato solicitado
        return strtolower($firstName . '.' . $lastName . '@mkc.pt');
    }

    public static function createFilamentUsersFromJudges()
    {
        // Iterar sobre todos os juízes
        $judges = Judge::all();

        foreach ($judges as $judge) {
            // Verificar se o juiz já possui um usuário associado

            if ( !is_null($judge->user_id)) {
                continue; // Ignora se já existe
            }

            // Criar um novo usuário baseado no juiz
            $user = User::create([
                'name' => $judge->name,
                'email' => $judge->email,
                'password' => Hash::make($judge->password), // Define uma senha padrão
                'is_judge' => 1,
                'is_admin' => 0,
                'is_reception' => 0,
                'is_dashboard' => 0,
            ]);

            // Associar o user_id ao juiz
            $judge->user_id = $user->id;
            $judge->save();
        }
    }
}

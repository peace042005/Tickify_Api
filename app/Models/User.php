<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property int $role_id
 * @property Role $role
 * @property string $name
 * @property string $prenom
 * @property string $email
 * @property string $telephone
 * @property string $email_verified_at
 * @property string $password
 * @property string $photo_profile
 * @property string $sexe
 * @property string|null $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property string $date_naissance
 * @property Ticket[] $tickets
 * @property Evenement[] $evenements
 * @property bool $isUtilisateur
 * @property bool $isAdministrateur
 */
class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'name',
        'prenom',
        'sexe',
        'email',
        'password',
        'telephone',
        'photo_profile',
        'date_naissance',
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
            'date_naissance' => 'date',
        ];
    }

    /**
     * Get all of the tickets for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Get all of the evenements for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evenements()
    {
        return $this->hasMany(Evenement::class);
    }

    /**
     * Get the role of the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if the user is an Utilisateur
     *
     * @return bool
     */
    public function isUtilisateur()
    {
        return $this->role && $this->role->id === 1;
    }

    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdministrateur()
    {
        return $this->role && $this->role->id === 2;
    }
}

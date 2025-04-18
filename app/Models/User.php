<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
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

    /**
     * This function returns the full name of the connected user
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    /**
     * This function returns the short name of the connected user
     * @return string
     */
    public function getShortNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name[0] . '.';
    }

    /**
     * Retrieve the school of the user
     */

    public function schools() {
        return $this->belongsToMany(School::class, 'users_schools')->withPivot('role');
    }

    public function knowledgeTests()
    {
        return $this->hasMany(KnowledgeTest::class);
    }

    public function school() {
        // Retourne la première école liée, utile pour les cas où un user a une seule école
        return $this->schools()->first();
    }


    public function completedTasks()
    {
        return $this->belongsToMany(CommunalTask::class, 'communal_task_user')
            ->withPivot('comment', 'completed_at')
            ->withTimestamps();
    }


    public function userSchool()
    {
        return $this->hasOne(UserSchool::class)->where('school_id', currentSchoolId()); // ou la l
    }





}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CommunalTask extends Model
{
    protected $fillable = ['title', 'description'];
    public function completedBy()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('comment', 'completed_at')
            ->withTimestamps();
    }
}

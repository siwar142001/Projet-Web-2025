<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeTest extends Model
{
    protected $fillable = ['user_id', 'language'];

    public function questions()
    {
        return $this->hasMany(KnowledgeQuestion::class);
    }
}

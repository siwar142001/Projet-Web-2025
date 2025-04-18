<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KnowledgeQuestion extends Model
{
    protected $fillable = ['knowledge_test_id', 'question', 'choices', 'bonne_reponse'];

    protected $casts = [
        'choices' => 'array',
    ];

    public function test()
    {
        return $this->belongsTo(KnowledgeTest::class);
    }
}

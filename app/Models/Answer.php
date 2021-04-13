<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Votable;

class Answer extends Model
{
    use HasFactory, Votable;

    protected $fillable = [
        'body',
        'user_id',
        'topic_id'
    ];

    protected $appends = ['votes_sum'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

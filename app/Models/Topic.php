<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Traits\Votable;

class Topic extends Model
{
    use HasFactory, Votable;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at' => 'datetime:Y-m-d H:i',
    ];

    protected $appends = ['answers_count', 'votes_sum'];

    public function answers()
    {
        return $this->hasMany(Answer::class)->with('user');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAnswersCountAttribute()
    {
        return $this->answers->count();
    }
}

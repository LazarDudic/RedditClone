<?php
namespace App\Traits;

use App\Models\Vote;

trait Votable
{
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function getVotesSumAttribute()
    {
        return $this->votes()->sum('vote');
    }
}

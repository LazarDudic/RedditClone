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
        return (int) $this->votes()->sum('vote');
    }
}

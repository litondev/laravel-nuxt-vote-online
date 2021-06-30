<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Select extends Model
{
    protected $guarded = ['id'];

    public function vote(){
    	return $this->belongsTo(Vote::class);
    }

    public function user_votes(){
    	return $this->hasMany(UserVote::class);
    }
}

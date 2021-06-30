<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVote extends Model
{
    protected $guarded = ['id'];

    public function select(){
    	return $this->belongsTo(Select::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}

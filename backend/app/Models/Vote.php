<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $guarded = ['id'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function selectes(){
    	return $this->hasMany(Select::class);
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\RequestTrait;

class ProfilUpdateRequest extends FormRequest
{
    use RequestTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
   		return [
   			"username" => "required",
   			"email" => "required|email|unique:users,email,".auth()->user()->id,
   			"password" => "nullable|min:8",
   			"password_confirm" => "required|min:8"
   		];
    }
}

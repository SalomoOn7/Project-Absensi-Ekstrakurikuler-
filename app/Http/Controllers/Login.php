<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class Login extends Controller
{
    public function rules() : array{
      return[
         'username' => ['required', 'string'],
        'password' => ['required', 'string'],
      ];
    }
    public function authenticate() : void{
      if (! Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
        throw ValidationException::withMessages([
          'username' => __('Username atau Password Salah'),
        ]);
      }
    }
}

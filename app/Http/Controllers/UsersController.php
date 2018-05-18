<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{

  public function show(User $user)
  {
//    dd($user->toArray());
    return view('users.show',compact('user'));
  }

}

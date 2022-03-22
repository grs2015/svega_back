<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{
    public function user(Request $request) {

        $user = $request->user();

        return $this->showOne($user, Response::HTTP_OK);
    }


}

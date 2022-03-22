<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class RegisteredUserController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $isTrashed = $request->query('trashed');

        if ($isTrashed === '1') {

            if (User::onlyTrashed()->count()) {
                $users = User::onlyTrashed()->get();
                return $this->showAll($users, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
            }
        } else {
            $users = User::all();
        }

        return $this->showAll($users, Response::HTTP_OK);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $userData = $request->validated();
        $userData['password'] = \Hash::make('password');

        $user = User::create($userData);

        return $this->showOne($user, Response::HTTP_CREATED);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->fill($request->validated());

        if ($user->isClean()) {
            return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->save();

        return $this->showOne($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return response()->json(['message' => 'This user cannot be deleted!'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->delete();

        return $this->showOne($user, Response::HTTP_OK);
    }

    public function restore(Request $request) {

        $restoredArr = explode(",", $request->query('ids'));

        User::onlyTrashed()->whereIn('id', $restoredArr)->restore();

        if (User::onlyTrashed()->count()) {
            $users = User::onlyTrashed()->get();
            return $this->showAll($users, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

    public function delete(Request $request) {

        $restoredArr = explode(",", $request->query('ids'));

        $usersDeletion = User::onlyTrashed()->whereIn('id', $restoredArr)->get();
        $usersDeletion->each(function($item) {
            $item->forceDelete();
        });

        if (User::onlyTrashed()->count()) {
            $users = User::onlyTrashed()->get();
            return $this->showAll($users, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }
}

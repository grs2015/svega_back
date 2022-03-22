<?php

namespace App\Http\Controllers\Main;

use App\Models\Main;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class MainActivityController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Main $main)
    {
        $activities = $main->activities;
        // $activities = Activity::all();

        return $this->showAll($activities, Response::HTTP_OK);
    }

    public function show(Main $main, Activity $activity)
    {
        $activity = $main->activities()->findOrFail($activity->id);

        return $this->showOne($activity, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ActivityRequest $request, Main $main)
    {
        if ($request->user()->cannot('create', Activity::class)) {
            return response()->json(['error' => 'This action is unauthorized.', 'code' => 403], Response::HTTP_FORBIDDEN);
        }

        $activityData = $request->safe()->except(['tag', 'image']);
        $activityData['main_id'] = $main->id;

        $activity = Activity::create($activityData);

        if ($request->has('tag')) {
            $tagID = $request->input('tag');
            $activity->tags()->sync($tagID);
        }

        return $this->showOne($activity, Response::HTTP_CREATED);
    }
}

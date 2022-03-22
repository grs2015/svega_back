<?php

namespace App\Http\Controllers\Activity;

use App\Models\Tag;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class ActivityTagController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Activity $activity)
    {
        $tags = $activity->tags;

        return $this->showAll($tags, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity, Tag $tag)
    {
        $activity->tags()->syncWithoutDetaching([$tag->id]);

        $tags = $activity->tags;

        return $this->showAll($tags, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity, Tag $tag)
    {
        if (!$activity->tags()->find($tag->id)) {
            return $this->errorResponse('The specified Tag is not a Tag of this Activity', Response::HTTP_NOT_FOUND);
        }

        $activity->tags()->detach($tag->id);

        $tags = $activity->tags;

        return $this->showAll($tags, Response::HTTP_OK);
    }
}

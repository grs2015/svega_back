<?php

namespace App\Http\Controllers\Activity;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActivityRequest;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ActivityController extends ApiController
{
    public function __construct()
    {
        //NOTE - Later switch on the policy check!
        $this->authorizeResource(Activity::class, 'activity');
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
            if (Activity::onlyTrashed()->count()) {
                $activities = Activity::onlyTrashed()->get();
                return $this->showAll($activities, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
            }
        } else {
            $activities = Activity::all();
        }

        return $this->showAll($activities, Response::HTTP_OK);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        return $this->showOne($activity, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActivityRequest $request, Activity $activity)
    {
        //NOTE - Пока что без image
        $activity->fill($request->safe()->except(['image', 'tag']));

        if ($request->has('deletedImage')) {
            $deletedImage = $request->deletedImage;
            try {
                Storage::disk('public')->delete($deletedImage);
            } catch(\Exception $e) {
                throw $e;
            }
            $activity['image'] = '';
            $activity->save();
            return $this->showOne($activity, Response::HTTP_OK);
        }

        if ($request->hasFile('image')) {
            try {
                Storage::disk('public')->delete($activity->image);
            } catch (\Exception $e) {
                throw $e;
            }

            $file = $request->file('image');
            $fileName = $file->store('img/activities', 'public');
            $activity['image'] = $fileName;
        }

        if (!$request->section_type_1) {
            $this->plainText($activity, 'section_description_1', $request->section_description_1);
        } else {
            $this->listText($activity, 'section_description_1', $request->section_description_1);
        }

        if (!$request->section_type_2) {
            $this->plainText($activity, 'section_description_2', $request->section_description_2);
        } else {
            $this->listText($activity, 'section_description_2', $request->section_description_2);
        }

        if (!$request->section_type_3) {
            $this->plainText($activity, 'section_description_3', $request->section_description_3);
        } else {
            $this->listText($activity, 'section_description_3', $request->section_description_3);
        }

        if ($request->has('tag')) {
            $tagID = $request->input('tag');
            $activity->tags()->sync($tagID);
        }

        // if ($activity->isClean()) {
        //     return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $activity->save();

        return $this->showOne($activity, Response::HTTP_OK);
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return $this->showOne($activity, Response::HTTP_OK);
    }

    protected function plainText(Activity $activity, $attribute, $fieldTable) {
        //NOTE - Замена тройных <br> на два <br>. Одинарный <br> не затрагивается
        $editedDescription = str_replace('<br>', PHP_EOL, (preg_replace('/(<br\s*?\/?>){2,}/i', '<br><br>', str_replace(PHP_EOL, '<br>', $fieldTable))));
        $activity[$attribute] = $editedDescription;

    }

    protected function listText(Activity $activity, $attribute, $fieldTable) {
        //NOTE - Замена любых <br> на один <br>.
        $editedDescription = str_replace('<br>', PHP_EOL, (preg_replace('/(<br\s*?\/?>){1,}/i', '<br>', str_replace(PHP_EOL, '<br>', $fieldTable))));
        $activity[$attribute] = $editedDescription;

    }

    public function restore(Request $request) {

        if ($request->user()->cannot('restore', Activity::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        Activity::onlyTrashed()->whereIn('id', $restoredArr)->restore();

        if (Activity::onlyTrashed()->count()) {
            $activities = Activity::onlyTrashed()->get();
            return $this->showAll($activities, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

    public function delete(Request $request) {

        if ($request->user()->cannot('forceDelete', Activity::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        $activitiesDeletion = Activity::onlyTrashed()->whereIn('id', $restoredArr)->get();
        $activitiesDeletion->each(function($item) {
            $item->tags()->detach();
            $item->forceDelete();
        });

        if (Activity::onlyTrashed()->count()) {
            $activities = Activity::onlyTrashed()->get();
            return $this->showAll($activities, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }
}

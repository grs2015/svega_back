<?php

namespace App\Http\Controllers\Tag;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TagController extends ApiController
{
    // public function __construct()
    // {
    //     $this->authorizeResource(Tag::class, 'tag');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $isTrashed = $request->query('trashed');

        if ($isTrashed === '1') {

            if (Tag::onlyTrashed()->count()) {
                $tags = Tag::onlyTrashed()->get();
                return $this->showAll($tags, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
            }
        } else {
            $tags = Tag::with('activities')->get();
        }
        return $this->showAll($tags, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|unique:tags',
        ]);

        $newTag = Tag::create($request->all());

        return $this->showOne($newTag, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return $this->showOne($tag, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', Rule::unique('tags')->ignore($tag->id)],
            'progress' => 'integer|nullable'
        ]);

        $tag->fill($validator->validated()) ;

        // if ($tag->isClean()) {
        //     return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $tag->save();

        return $this->showOne($tag, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return $this->showOne($tag, Response::HTTP_OK);
    }

    public function restore(Request $request) {

        if ($request->user()->cannot('restore', Tag::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        Tag::onlyTrashed()->whereIn('id', $restoredArr)->restore();

        if (Tag::onlyTrashed()->count()) {
            $tags = Tag::onlyTrashed()->get();
            return $this->showAll($tags, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

    public function delete(Request $request) {

        if ($request->user()->cannot('forceDelete', Tag::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = collect(explode(",", $request->query('ids')));


        $tagsDeletion = Tag::onlyTrashed()->whereIn('id', $restoredArr)->get();
        $tagsDeletion->each(function($item) {
            $item->activities()->detach();
            $item->forceDelete();
        });

        if (Tag::onlyTrashed()->count()) {
            $tags = Tag::onlyTrashed()->get();
            return $this->showAll($tags, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }
}

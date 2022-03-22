<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog;
use App\Filters\BlogFilter;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Blog::class, 'blog');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogFilter $filters, Request $request)
    {
        $isTrashed = $request->query('trashed');

        if ($isTrashed === '1') {
            if (Blog::onlyTrashed()->count()) {
                $blogs = Blog::onlyTrashed()->get();
                return $this->showAll($blogs, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
            }
        } else {
            $blogs = \Cache::remember(
                $this->cacheResponse(),
                $this->cacheTime(),
                function() use ($filters){
                    return Blog::with('categories')->filter($filters)->get();
            });
        }
        // $blogs = Blog::filter($filters)->get();

        return $this->showAll($blogs, Response::HTTP_OK, true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        // $blog = $blog->with('categories')->get()->first();

        return $this->showOne($blog, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->fill($request->safe()->only(['title', 'description', 'description_full', 'date']));

        if ($request->has('deletedImage')) {
            $deletedImage = $request->deletedImage;
            try {
                Storage::disk('public')->delete($deletedImage);
            } catch (\Exception $e) {
                throw $e;
            }
            if (isset($blog['images'])) {
                $imagesAttached = collect(explode(",", $blog['images']));
                $fileNames = $imagesAttached->filter(function($value, $key) use ($deletedImage) {
                    return $value != $deletedImage;
                })->values();
                $fileNamesDB = $fileNames->implode(',');
                $blog['images'] = $fileNamesDB;
            }

            $blog->save();
            return $this->showOne($blog, Response::HTTP_OK);
        }

        if ($request->has('images')) {
            try {
                $namesArr = explode(",", $blog->images);
                Storage::disk('public')->delete($namesArr);
            } catch (\Exception $e) {
                throw $e;
            }

            $files = $request->allFiles('images');
            $fileNames = collect([]);
            collect($files['images'])->each(function($item) use ($fileNames) {
                $fileNames->push($item->store('img/news', 'public'));
            });

            $fileNamesDB = $fileNames->implode(',');
            $blog->images = $fileNamesDB;
        }

        if ($request->has('category')) {
            $catID = $request->input('category');
            $blog->categories()->sync($catID);
        }

        if ($blog->isClean()) {
            return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $blog->save();

        return $this->showOne($blog, Response::HTTP_OK);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return $this->showOne($blog, Response::HTTP_OK);
    }

    public function restore(Request $request) {

        if ($request->user()->cannot('restore', Blog::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        Blog::onlyTrashed()->whereIn('id', $restoredArr)->restore();

        if (Blog::onlyTrashed()->count()) {
            $blogs = Blog::onlyTrashed()->get();
            return $this->showAll($blogs, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

    public function delete(Request $request) {

        if ($request->user()->cannot('forceDelete', Blog::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        $blogsDeletion = Blog::onlyTrashed()->whereIn('id', $restoredArr)->get();
        $blogsDeletion->each(function($item) {
            $item->categories()->detach();
            $item->forceDelete();
        });

        if (Blog::onlyTrashed()->count()) {
            $blogs = Blog::onlyTrashed()->get();
            return $this->showAll($blogs, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

}

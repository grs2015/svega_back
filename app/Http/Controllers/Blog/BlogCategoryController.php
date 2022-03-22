<?php

namespace App\Http\Controllers\Blog;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class BlogCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Blog $blog)
    {
        $categories = $blog->categories;

        return $this->showAll($categories, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog, Category $category)
    {
        $blog->categories()->syncWithoutDetaching([$category->id]);

        $categories = $blog->categories;

        return $this->showAll($categories, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog, Category $category)
    {
        if (!$blog->categories()->find($category->id)) {
            return $this->errorResponse('The specified Category is not a Category of this Blog', Response::HTTP_NOT_FOUND);
        }

        $blog->categories()->detach($category->id);

        $categories = $blog->categories;

        return $this->showAll($categories, Response::HTTP_OK);
    }
}

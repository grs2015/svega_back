<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
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

            if (Category::onlyTrashed()->count()) {
                $cats = Category::onlyTrashed()->get();
                return $this->showAll($cats, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
            }
        } else {
            $categories = Category::all();
        }

        return $this->showAll($categories, Response::HTTP_OK);
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
            'title' => 'required|string|unique:categories',
            'color' => 'string'
        ]);

        $newCategory = Category::create($request->all());

        return $this->showOne($newCategory, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $this->showOne($category, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', Rule::unique('categories')->ignore($category->id)],
            'color' => 'string',
            'icon' => 'string'
        ]);

        $category->fill($validator->validated()) ;

        if ($category->isClean()) {
            return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->save();

        return $this->showOne($category, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->showOne($category, Response::HTTP_OK);
    }

    public function restore(Request $request) {

        if ($request->user()->cannot('restore', Category::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        Category::onlyTrashed()->whereIn('id', $restoredArr)->restore();

        if (Category::onlyTrashed()->count()) {
            $cats = Category::onlyTrashed()->get();
            return $this->showAll($cats, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

    public function delete(Request $request) {

        if ($request->user()->cannot('forceDelete', Category::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        $categoriesDeletion = Category::onlyTrashed()->whereIn('id', $restoredArr)->get();
        $categoriesDeletion->each(function($item) {
            $item->blogs()->detach();
            $item->forceDelete();
        });

        if (Category::onlyTrashed()->count()) {
            $cats = Category::onlyTrashed()->get();
            return $this->showAll($cats, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

}

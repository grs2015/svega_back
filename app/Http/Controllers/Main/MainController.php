<?php

namespace App\Http\Controllers\Main;

use App\Models\Main;
use Illuminate\Http\Request;
use App\Http\Requests\MainRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class MainController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('show');
        $this->authorizeResource(Main::class, 'main');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $main = Main::all();

        return $this->showAll($main, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Main $main)
    {
        $main = $main->withCount('blogs')->find($main->id);

        return $this->showOne($main, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MainRequest $request, Main $main)
    {
        $main->fill($request->safe()->except(['main_image', 'parallax_images']));

        if ($request->has('deletedImage')) {
            $deletedImage = $request->deletedImage;
            try {
                Storage::disk('public')->delete($deletedImage);
            } catch(\Exception $e) {
                throw $e;
            }
            $main['main_image'] = '';
            $main->save();
            return $this->showOne($main, Response::HTTP_OK);
        }

        if ($request->has('deletedParallaxImage')) {
            $deletedParallaxImage = $request->deletedParallaxImage;
            try {
                Storage::disk('public')->delete($deletedParallaxImage);
            } catch (\Exception $e) {
                throw $e;
            }
            if (isset($main['parallax_images'])) {
                $imagesAttached = collect(explode(",", $main['parallax_images']));
                $fileNames = $imagesAttached->filter(function($value, $key) use ($deletedParallaxImage) {
                    return $value != $deletedParallaxImage;
                })->values();
                $fileNamesDB = $fileNames->implode(',');
                $main['parallax_images'] = $fileNamesDB;
            }

            $main->save();
            return $this->showOne($main, Response::HTTP_OK);
        }

        if ($request->hasFile('main_image')) {
            try {
                Storage::disk('public')->delete($main->main_image);
            } catch (\Exception $e) {
                throw $e;
            }

            $file = $request->file('main_image');
            $fileName = $file->store('img/mainpage', 'public');
            $main['main_image'] = $fileName;
        }

        if ($request->has('parallax_images')) {
            try {
                $namesArr = explode(",", $main->parallax_images);
                Storage::disk('public')->delete($namesArr);
            } catch (\Exception $e) {
                throw $e;
            }

            $files = $request->allFiles('parallax_images');
            $fileNames = collect([]);
            collect($files['parallax_images'])->each(function($item) use ($fileNames) {
                $fileNames->push($item->store('img/mainpage/parallax', 'public'));
            });

            $fileNamesDB = $fileNames->implode(',');
            $main->parallax_images = $fileNamesDB;
        }



        if ($main->isClean()) {
            return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $main->save();

        return $this->showOne($main, Response::HTTP_OK);
    }




}

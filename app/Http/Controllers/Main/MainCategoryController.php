<?php

namespace App\Http\Controllers\Main;

use App\Models\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class MainCategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Main $main)
    {
        $categories = $main->blogs()->with('categories')->get()
            ->pluck('categories')->collapse()->sortBy('id')->unique('id')->values();

        return $this->showAll($categories, Response::HTTP_OK);
    }
}

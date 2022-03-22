<?php

namespace App\Http\Controllers\Main;

use App\Models\Main;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class MainTagController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Main $main)
    {
        $tags = $main->activities()->with('tags')->get()
            ->pluck('tags')->collapse()->sortBy('id')->unique('id')->values();

        return $this->showAll($tags, Response::HTTP_OK);
    }
}

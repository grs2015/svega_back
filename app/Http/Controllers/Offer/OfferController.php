<?php

namespace App\Http\Controllers\Offer;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Requests\OfferRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use Symfony\Component\HttpFoundation\Response;

class OfferController extends ApiController
{
    public function __construct()
    {
        $this->authorizeResource(Offer::class, 'offer');
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
            if (Offer::onlyTrashed()->count()) {
                $offers = Offer::onlyTrashed()->get();
                return $this->showAll($offers, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
            }
        } else {
            $offers = Offer::all();
        }

        return $this->showAll($offers, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Offer $offer)
    {
        return $this->showOne($offer, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OfferRequest $request, Offer $offer)
    {
        $offer->fill($request->validated());

        // if ($offer->isClean()) {
        //     return response()->json(['message' => 'You need to specify difference values to update'], Response::HTTP_UNPROCESSABLE_ENTITY);
        // }

        $offer->save();

        return $this->showOne($offer, Response::HTTP_OK);
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();

        return $this->showOne($offer, Response::HTTP_OK);
    }

    public function restore(Request $request) {

        if ($request->user()->cannot('restore', Offer::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        Offer::onlyTrashed()->whereIn('id', $restoredArr)->restore();

        if (Offer::onlyTrashed()->count()) {
            $offers = Offer::onlyTrashed()->get();
            return $this->showAll($offers, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

    public function delete(Request $request) {

        if ($request->user()->cannot('forceDelete', Offer::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        $offerDeletion = Offer::onlyTrashed()->whereIn('id', $restoredArr)->get();
        $offerDeletion->each(function($item) {
            $item->forceDelete();
        });

        if (Offer::onlyTrashed()->count()) {
            $offers = Offer::onlyTrashed()->get();
            return $this->showAll($offers, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

}

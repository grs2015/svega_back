<?php

namespace App\Http\Controllers\Contact;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends ApiController
{
    public function __construct()
    {
        //NOTE - Later switch on the policy check!
        $this->authorizeResource(Contact::class, 'contact');
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

            if (Contact::onlyTrashed()->count()) {
                $contacts = Contact::onlyTrashed()->get();
                return $this->showAll($contacts, Response::HTTP_OK);
            } else {
                return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
            }
        } else {
            $contacts = Contact::all();

            if ($contacts->isEmpty()) {
                return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
            }
        }

        return $this->showAll($contacts, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return $this->showOne($contact, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string',
            'manager' => 'required|string',
            'confirm' => 'required|boolean',
            'date' => 'required|string'
        ]);

        $contact->fill($validator->validated());

        $contact->save();

        return $this->showOne($contact, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return $this->showOne($contact, Response::HTTP_OK);
    }

    public function restore(Request $request) {

        if ($request->user()->cannot('restore', Contact::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        Contact::onlyTrashed()->whereIn('id', $restoredArr)->restore();

        if (Contact::onlyTrashed()->count()) {
            $contacts = Contact::onlyTrashed()->get();
            return $this->showAll($contacts, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }

    public function delete(Request $request) {

        if ($request->user()->cannot('forceDelete', Contact::class)) {
            return response()->json(['message' => 'This action is unauthorized.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $restoredArr = explode(",", $request->query('ids'));

        $contactsDeletion = Contact::onlyTrashed()->whereIn('id', $restoredArr)->get();
        $contactsDeletion->each(function($item) {
            $item->forceDelete();
        });

        if (Contact::onlyTrashed()->count()) {
            $contacts = Contact::onlyTrashed()->get();
            return $this->showAll($contacts, Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'No entries!'], Response::HTTP_OK);
        }
    }
}

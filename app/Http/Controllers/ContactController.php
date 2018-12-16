<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Http\Resources\Contact\ContactResource;
use App\Model\Client;
use App\Model\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(['contacts'=>Contact::getAllContacts()], Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ContactRequest $request
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $new_contact = Contact::create($request->all());

        return response(['createdContact'=> $new_contact], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return response(['contact'=> new ContactResource($contact)], Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Contact $contact)
    {
        try {
            $contact->update($request->all());

            return response(['updatedContact'=> $contact], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response(['errors'=> 'There is some error with DB'], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Contact $contact
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}

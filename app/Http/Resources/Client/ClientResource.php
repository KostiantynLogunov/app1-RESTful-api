<?php

namespace App\Http\Resources\Client;

use App\Model\Contact;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'email' => $this->email,
            'contacts' => Contact::select('id', 'client_id', 'address', 'postcode')->where('client_id', $this->id)->get()
        ];
    }
}

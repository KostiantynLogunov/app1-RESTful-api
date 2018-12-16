<?php

namespace App\Http\Resources\Contact;

use App\Model\Client;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'client_id' => $this->client_id,
            'address' => $this->address,
            'postcode' => $this->postcode,
            'client' => Client::select('id', 'first_name', 'email')->where('id', $this->client_id)->get(),
        ];
    }
}

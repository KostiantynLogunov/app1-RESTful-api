<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == "POST")
            return [
                'client_id' => 'required|integer',
                'address' => 'required|string',
                'postcode' => 'required|string',
            ];

        if ($this->method() == "PUT")
            return [
                'address' => 'required|string',
                'postcode' => 'required|string',
            ];
    }
}

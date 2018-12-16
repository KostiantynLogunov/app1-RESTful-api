<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
                'first_name'=>'required|string|min:3|max:20',
                'email'=>'required|unique:clients|email|max:50',
            ];

        if ($this->method() == "PUT")
            return [
                'first_name'=>'required|string|min:3|max:20',
                'email'=>'required|email|max:50',
            ];
    }
}

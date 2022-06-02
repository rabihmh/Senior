<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class servicesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "service_title"=>'required|max:100',
            "service_cat"=>'required',
            "service_subcat"=>'required',
            "service_desc"=>'required|max:1000',
            "service_duration"=>'required',
            "service_price"=>'required|numeric'
        ];
    }
    public function messages()
    {
        return [
            'service_title.required'=>'Service title required',
            'service_title.max'=>'Service title to long',
            'service_cat.required'=>'Service category required',
            'service_subcat.required'=>'Service Subcategory required',
            'service_desc.required'=>'Service Description required',
            'service_desc.max'=>'Service Description to long',
            'service_duration.required'=>'Service duration required',
            'service_price.required'=>'Service price required',
            'service_price.numeric'=>'The price should be numbers only',
        ];

    }
}

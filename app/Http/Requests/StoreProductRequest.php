<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        return [
            'name' => ['required', 'max:70'],
            'description' => ['required'],
            'price' => ['required'],
            'stock' => ['required'],
            'image' => ['required'],
            'categorie_id' => ['max:255'],
        ];
    }
}

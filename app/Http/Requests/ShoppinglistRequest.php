<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShoppinglistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "ingredient.name" => "required|string|max:50",
            'slist.quantity' => 'decimal:0,2|between:1, 99999999',
            'slist.unit_id' => 'required|integer',
        ];
    }
}

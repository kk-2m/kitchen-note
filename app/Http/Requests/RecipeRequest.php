<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'recipe.title' => 'required|string|max:100',
            'recipe.number' => 'required|integer|between:0,255',
            'recipe.cooking_time' => 'required|integer|between:1,2147483647',
            'recipe.cooking_time_unit' => 'required|integer|between:1, 6',
            "ingredient.*.name" => "required|string|max:50",
            "ingredient.*.ingredient_category_id" => "required|integer",
            "ingredient_recipe.*.quantity" => "required|integer|between:0, 2147483647",
            "ingredient_recipe.*.unit_id" => "required|integer",
            "procedure.*.body" => "required|string|max:200",
        ];
        // for ($i=1; $i<=30; $i++){
        //         $rules += array("ingredient.name{$i}" => "required|string|max:50");
        //         $rules += array("ingredient.ingredient_category_id{$i}" => "required|integer");
        //         $rules += array("procedure.body{$i}" => "required|string|max:200");
        //         $rules += array("ingredient_recipe.quantity{$i}" => "required|integer|between:0, 2147483647");
        //         $rules += array("ingredient_recipe.unit_id{$i}" => "required|integer");
        // }
        return $rules;
    }
}

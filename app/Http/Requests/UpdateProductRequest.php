<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => ['string', 'in:draft,published,trash'],
            'url' => ['string', 'url'],
            'creator' => ['string'],
            'product_name' => ['string'],
            'quantity' => ['string'],
            'brands' => ['string'],
            'categories' => ['string'],
            'labels' => ['string'],
            'cities' => ['string'],
            'purchase_places' => ['string'],
            'stores' => ['string'],
            'ingredients_text' => ['string'],
            'traces' => ['string'],
            'serving_size' => ['string'],
            'serving_quantity' => ['numeric'],
            'nutriscore_score' => ['numeric'],
            'nutriscore_grade' => ['string'],
            'main_category' => ['string'],
            'image_url' => ['string', 'url'],
        ];
    }
}

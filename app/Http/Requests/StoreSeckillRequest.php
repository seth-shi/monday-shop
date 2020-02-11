<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StoreSeckillRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'product_id' => 'required|exists:products,id',
            'number' => 'required|integer|min:1',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
        ];
    }
}

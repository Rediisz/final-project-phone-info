<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'Title'     => ['required','string','max:255'],
            'Intro'     => ['nullable','string'],
            'Details'   => ['required','string'],
            'Details2'  => ['nullable','string'],
            'Details3'  => ['nullable','string'],
            'Brand_ID'  => ['required','integer','exists:brand,ID'],
            'Mobile_ID' => [
                'required','integer',
                Rule::exists('mobile_info','ID')->where(fn($q) =>
                    $q->where('Brand_ID', $this->input('Brand_ID'))
                ),
            ],
            'cover'     => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'images.*'  => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ];
    }
}

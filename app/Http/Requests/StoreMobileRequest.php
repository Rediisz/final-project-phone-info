<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMobileRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'Brand_ID'     => ['required','exists:brand,ID'],
            'Model'        => ['required','string','max:150'],
            'LaunchDate'   => ['nullable','date'],
            'OS'           => ['nullable','string','max:120'],
            'Processor'    => ['nullable','string','max:150'],
            'RAM_GB'       => ['nullable','integer','min:0','max:65535'],
            'ScreenSize_in'=> ['nullable','numeric','min:0','max:20'],
            'Display'      => ['nullable','string','max:120'],
            'FrontCamera'  => ['nullable','string','max:150'],
            'BackCamera'   => ['nullable','string','max:150'],
            'Battery_mAh'  => ['nullable','integer','min:0','max:20000'],
            'Network'      => ['nullable','string','max:60'],
            'Material'     => ['nullable','string','max:120'],
            'Weight_g'     => ['nullable','integer','min:0','max:20000'],
            'Price'        => ['nullable','numeric','min:0'],

            // ไฟล์รูป
            'cover'        => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'images'       => ['nullable','array','max:10'],
            'images.*'     => ['image','mimes:jpg,jpeg,png,webp','max:4096'],
        ];
    }
}

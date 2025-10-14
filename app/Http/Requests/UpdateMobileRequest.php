<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMobileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Map ชื่อฟิลด์เดิมจากฟอร์ม -> ชื่อคอลัมน์จริง + จัดการ boolean
     */
    protected function prepareForValidation(): void
    {
        // map old -> new
        $map = [
            'Resolution'     => 'Display_Resolution',
            'RefreshRate_Hz' => 'Display_RefreshRate',
            'Charging_W'     => 'Charging_Wired_Watt',
            'WiFi'           => 'Wifi_Std',
            'USB'            => 'USB_Type',
            'Dimensions_mm'  => 'Dimensions',
            'Colors'         => 'ColorOptions',
        ];

        $merged = [];
        foreach ($map as $old => $new) {
            if ($this->filled($old) && !$this->filled($new)) {
                $merged[$new] = $this->input($old);
            }
        }

        // checkbox -> 0/1 (ถ้าไม่ได้ส่งมาจะไม่ merge เพื่อไม่ override ค่าเดิม)
        foreach ([
            'Expandable','NFC','Infrared','eSIM','Jack35',
            'Stereo_Speakers','Dolby_Atmos','Face_Unlock','GPS'
        ] as $b) {
            if ($this->has($b)) {
                $merged[$b] = in_array($this->input($b), ['1','on',1,true], true) ? 1 : 0;
            }
        }

        $this->merge($merged);
    }

    public function rules(): array
    {
        return [
            // คีย์หลัก
            'Brand_ID'       => ['required','exists:brand,ID'],
            'Model'          => ['required','string','max:150'],

            // กลุ่มชื่อ/รุ่น/สี/ซีรีส์/วาไรแอนต์
            'FullName'       => ['nullable','string','max:100'],
            'Series'         => ['nullable','string','max:100'],
            'Variant'        => ['nullable','string','max:100'],
            'ColorOptions'   => ['nullable','string','max:200'],

            // กายภาพ/กันน้ำ/วัสดุ
            'Weight_g'       => ['nullable','integer','min:0','max:20000'],
            'IP_Rating'      => ['nullable','string','max:20'],
            'Dimensions'     => ['nullable','string','max:50'],
            'Material'       => ['nullable','string','max:100'],

            // หน่วยความจำ/แรม
            'RAM_GB'         => ['nullable','integer','min:0','max:65535'],
            'RAM_Type'       => ['nullable','string','max:20'],
            'Storage_GB'     => ['nullable','integer','min:0','max:65535'],
            'Storage_Type'   => ['nullable','string','max:20'],
            'Expandable'     => ['nullable','boolean'],

            // วันวางขาย/สถานะ/ราคา/สกุล
            'LaunchDate'     => ['nullable','date'],
            'Availability'   => ['nullable','string','max:30'],
            'Price'          => ['nullable','numeric','min:0'],
            'LaunchPrice'    => ['nullable','numeric','min:0'],
            'Currency'       => ['nullable','string','max:3'],

            // จอภาพ
            'ScreenSize_in'        => ['nullable','numeric','min:0','max:20'],
            'Display'              => ['nullable','string','max:255'],
            'Display_Type'         => ['nullable','string','max:60'],
            'Display_Resolution'   => ['nullable','string','max:30'],
            'Display_RefreshRate'  => ['nullable','integer','min:0','max:1000'],
            'Display_Brightness'   => ['nullable','integer','min:0','max:10000'],
            'Display_Protection'   => ['nullable','string','max:80'],

            // ระบบ/OS
            'OS'               => ['nullable','string','max:50'],
            'UI_Skin'          => ['nullable','string','max:50'],
            'OS_Version'       => ['nullable','string','max:50'],
            'OS_Updates_Years' => ['nullable','integer','min:0','max:20'],

            // เครือข่าย/การเชื่อมต่อ
            'Network'    => ['nullable','string','max:255'],
            'Wifi_Std'   => ['nullable','string','max:20'],
            'Bluetooth'  => ['nullable','string','max:10'],
            'NFC'        => ['nullable','boolean'],
            'GPS'        => ['nullable','boolean'],
            'Infrared'   => ['nullable','boolean'],
            'USB_Type'   => ['nullable','string','max:30'],
            'Sim_Type'   => ['nullable','string','max:40'],
            'eSIM'       => ['nullable','boolean'],
            'Jack35'     => ['nullable','boolean'],
            'Stereo_Speakers' => ['nullable','boolean'],
            'Dolby_Atmos'     => ['nullable','boolean'],

            // ปลดล็อก
            'Fingerprint_Type' => ['nullable','string','max:30'],
            'Face_Unlock'      => ['nullable','boolean'],

            // กล้อง/วิดีโอ
            'FrontCamera'            => ['nullable','string','max:50'],
            'FrontCamera_Features'   => ['nullable','string'],
            'BackCamera'             => ['nullable','string','max:50'],
            'RearCamera_Features'    => ['nullable','string'],
            'Video_Recording'        => ['nullable','string','max:100'],

            // ชิป/กราฟิก
            'Processor'  => ['nullable','string','max:100'],
            'GPU'        => ['nullable','string','max:80'],

            // แบต/ชาร์จ
            'Battery_mAh'            => ['nullable','integer','min:0','max:100000'],
            'Battery_Type'           => ['nullable','string','max:20'],
            'Charging_Wired_Watt'    => ['nullable','integer','min:0','max:1000'],
            'Charging_Wireless_Watt' => ['nullable','integer','min:0','max:1000'],
            'Charging_Reverse_Watt'  => ['nullable','integer','min:0','max:1000'],

            // อื่น ๆ
            'Sensors'    => ['nullable','string'],
            'Features'   => ['nullable','string'],

            // ไฟล์รูป
            'cover'            => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'images'           => ['nullable','array','max:10'],
            'images.*'         => ['image','mimes:jpg,jpeg,png,webp','max:4096'],

            // ลบรูป
            'remove_image_ids'   => ['nullable','array'],
            'remove_image_ids.*' => ['integer','exists:mobile_img,ID'],
        ];
    }
}

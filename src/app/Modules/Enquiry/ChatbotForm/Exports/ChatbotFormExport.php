<?php

namespace App\Modules\Enquiry\ChatbotForm\Exports;

use App\Modules\Enquiry\ChatbotForm\Models\ChatbotForm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ChatbotFormExport implements FromCollection,WithHeadings,WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'id',
            'name',
            'email',
            'phone',
            'ip_address',
            'country',
            'latitude',
            'longitude',
            'browser',
            'is_mobile',
            'visit_question',
            'admission_question',
            'contact_question',
            'multiple_choice_query',
            'school_course_question',
            'course_location_question',
            'course_standard_question',
            'final_callback_question',
            'schedule_callback_question',
            'status',
            'page_url',
            'created_at',
        ];
    }
    public function map($data): array
    {
         return[
            $data->id,
            $data->name,
            $data->email,
            $data->phone,
            $data->ip_address,
            $data->country,
            $data->latitude,
            $data->longitude,
            $data->browser,
            $data->is_mobile,
            $data->visit_question,
            $data->admission_question,
            $data->contact_question,
            $data->multiple_choice_query,
            $data->school_course_question,
            $data->course_location_question,
            $data->course_standard_question,
            $data->final_callback_question,
            $data->schedule_callback_question,
            $data->status,
            $data->page_url,
            $data->created_at,
         ];
    }
    public function collection()
    {
        return ChatbotForm::all();
    }
}

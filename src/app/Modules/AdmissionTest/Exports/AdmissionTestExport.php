<?php

namespace App\Modules\AdmissionTest\Exports;

use App\Modules\AdmissionTest\Models\AdmissionTest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdmissionTestExport implements FromCollection,WithHeadings,WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'id',
            'name',
            'email',
            'school_name',
            'class',
            'father_name',
            'father_phone',
            'father_email',
            'mother_name',
            'mother_phone',
            'mother_email',
            'program',
            'address',
            'mode',
            'exam_center',
            'exam_date',
            'payment_status',
            'razorpay_order_id',
            'razorpay_payment_id',
            'created_at',
        ];
    }
    public function map($data): array
    {
         return[
            $data->id,
            $data->name,
            $data->email,
            $data->school_name,
            $data->class->value ?? 'N/A',
            $data->father_name,
            $data->father_phone,
            $data->father_email,
            $data->mother_name,
            $data->mother_phone,
            $data->mother_email,
            $data->program,
            $data->address,
            $data->mode->value ?? 'N/A',
            $data->exam_center,
            $data->exam_date,
            $data->payment_status->value ?? 'N/A',
            $data->razorpay_order_id,
            $data->razorpay_payment_id,
            $data->created_at,
         ];
    }
    public function collection()
    {
        return AdmissionTest::get();
    }
}

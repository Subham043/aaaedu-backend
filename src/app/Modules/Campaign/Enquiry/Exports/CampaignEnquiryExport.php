<?php

namespace App\Modules\Campaign\Enquiry\Exports;

use App\Modules\Campaign\Enquiry\Models\Enquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CampaignEnquiryExport implements FromCollection,WithHeadings,WithMapping
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
            'campaign',
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
            $data->campaign->name,
            $data->created_at,
         ];
    }
    public function collection()
    {
        return Enquiry::with('campaign')->whereHas('campaign')->latest()->get();
    }
}

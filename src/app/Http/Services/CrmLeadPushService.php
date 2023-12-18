<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class CrmLeadPushService
{

    protected function get_lead_channel_id($lead_channel): int
    {
        switch ($lead_channel) {
            case 'Bangalore':
                # code...
                return 1;
                break;
            case 'Mysore':
                # code...
                return 7;
                break;
            default:
                # code...
                return 1;
                break;
        }
    }

    protected function get_course_id($course): int
    {
        switch ($course) {
            case 'Vijaynagar':
                # code...
                return 1;
                break;
            case 'Uttarahalli':
                # code...
                return 5;
                break;
            case 'Ullal Main Road':
                # code...
                return 6;
                break;
            case 'Srirangapatna':
                # code...
                return 7;
                break;
            default:
                # code...
                return 1;
                break;
        }
    }

    public function push_lead(string $name, string $email, string $phone, string $lead_channel, string $course): bool
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => config('services.extraedge.url'),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n    \"AuthToken\": \"".config('services.extraedge.authtoken')."\",\n    \"Source\": \"".config('services.extraedge.source')."\",\n    \"FirstName\": \"".$name."\",\n    \"Email\": \"".$email."\",\n    \"MobileNumber\": \"".$phone."\",\n    \"LeadName\": \"ThirdParty\",\n    \"leadCampaign\": \"ThirdParty\",\n    \"LeadSource\": \"20\",\n    \"LeadChannel\": \"".$this->get_lead_channel_id($lead_channel)."\",\n    \"Course\": \"".$this->get_course_id($course)."\",\n    \"Center\": \"1\"\n}\n",
            CURLOPT_HTTPHEADER => [
                "Accept: application/json",
                "Content-Type: application/json"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return true;
        }
    }

}

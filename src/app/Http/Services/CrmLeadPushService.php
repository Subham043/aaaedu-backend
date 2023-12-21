<?php

namespace App\Http\Services;

class CrmLeadPushService
{

    protected function get_lead_channel_id($lead_channel): int
    {
        $data = strtolower($lead_channel);
        switch ($data) {
            case 'bangalore':
                # code...
                return 1;
                break;
            case 'mysore':
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
        $data = strtolower($course);
        switch ($data) {
            case 'vijaynagar':
                # code...
                return 1;
                break;
            case 'uttarahalli':
                # code...
                return 5;
                break;
            case 'ullal main road':
                # code...
                return 6;
                break;
            case 'srirangapatna':
                # code...
                return 7;
                break;
            default:
                # code...
                return 5;
                break;
        }
    }

    protected function get_center_id($center): int
    {
        $data = strtolower($center);
        switch ($data) {
            case 'integrated jee batch residential':
                # code...
                return 1;
                break;
            case 'integrated neet batch residential':
                # code...
                return 6;
                break;
            case 'integrated jee batch days scholar':
                # code...
                return 7;
                break;
            case 'integrated neet batch days scholar':
                # code...
                return 8;
                break;
            case 'integrated cet batch residential':
                # code...
                return 9;
                break;
            case 'integrated cet batch days scholar':
                # code...
                return 10;
                break;
            case 'jee repeaters':
                # code...
                return 11;
                break;
            case 'neet repeaters':
                # code...
                return 12;
                break;
            case 'class foundation 8 course':
                # code...
                return 13;
                break;
            case 'class foundation 9 course':
                # code...
                return 14;
                break;
            case 'class foundation 10 course':
                # code...
                return 15;
                break;
            case 'class 9 board batch':
                # code...
                return 16;
                break;
            case 'board tuitions 9 icse':
                # code...
                return 17;
                break;
            case 'class 10 board batch':
                # code...
                return 18;
                break;
            case 'board tuitions 10 icse':
                # code...
                return 19;
                break;
            default:
                # code...
                return 1;
                break;
        }
    }

    public function push_lead(string $name, string $email, string $phone, string $lead_channel, string $course, string $center): bool
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
            CURLOPT_POSTFIELDS => "{\n    \"AuthToken\": \"".config('services.extraedge.authtoken')."\",\n    \"Source\": \"".config('services.extraedge.source')."\",\n    \"FirstName\": \"".$name."\",\n    \"Email\": \"".$email."\",\n    \"MobileNumber\": \"".$phone."\",\n    \"LeadName\": \"ThirdParty\",\n    \"leadCampaign\": \"ThirdParty\",\n    \"LeadSource\": \"20\",\n    \"LeadChannel\": \"".$this->get_lead_channel_id($lead_channel)."\",\n    \"Course\": \"".$this->get_course_id($course)."\",\n    \"Center\": \"".$this->get_center_id($center)."\"\n}\n",
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

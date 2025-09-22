<?php

namespace App\Modules\AdmissionTest\Mails;

use App\Enums\ExamMode;
use App\Modules\AdmissionTest\Models\AdmissionTest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class SendUserAdmissionTestEnquiryEmail extends Mailable
{
    use Queueable, SerializesModels;

    private AdmissionTest $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AdmissionTest $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mailObj = $this->subject(config('app.name').' - Admission Test Registration')->view('emails.registration_enquiry')->with([
            'data' => $this->data
        ]);

        if($this->data->mode ==  ExamMode::OFFLINE){
            $fileName = str()->uuid();
            $data = [
                'admissionTest' => $this->data
            ];
            $pdf = Pdf::setOption([
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
            ])->setPaper('a4', 'potrait')->loadView('pdf.hall_ticket', $data);
            $pdf->save(storage_path('app/public/reports/'.$fileName.'.pdf'));

            $mailObj->attach(storage_path('app/public/reports/'.$fileName.'.pdf'));
        }


        return $mailObj;
    }
}

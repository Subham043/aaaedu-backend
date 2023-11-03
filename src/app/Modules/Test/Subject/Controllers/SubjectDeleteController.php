<?php

namespace App\Modules\Test\Subject\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Subject\Services\SubjectService;

class SubjectDeleteController extends Controller
{
    private $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->middleware('permission:delete tests', ['only' => ['get']]);
        $this->subjectService = $subjectService;
    }

    public function get($test_id, $id){
        $subject = $this->subjectService->getByTestIdAndId($test_id, $id);

        try {
            //code...
            $this->subjectService->delete(
                $subject
            );
            return redirect()->back()->with('success_status', 'Test Subject deleted successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_status', 'Something went wrong. Please try again');
        }
    }

}

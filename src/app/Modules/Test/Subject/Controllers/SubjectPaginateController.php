<?php

namespace App\Modules\Test\Subject\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\Subject\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectPaginateController extends Controller
{
    private $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->middleware('permission:list tests', ['only' => ['get']]);
        $this->subjectService = $subjectService;
    }

    public function get(Request $request, $test_id){
        $data = $this->subjectService->paginate($request->total ?? 10, $test_id);
        return view('admin.pages.test.subject.paginate', compact(['data', 'test_id']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}

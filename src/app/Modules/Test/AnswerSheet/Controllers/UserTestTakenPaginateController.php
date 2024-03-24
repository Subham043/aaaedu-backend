<?php

namespace App\Modules\Test\AnswerSheet\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Test\AnswerSheet\Resources\UserTestTakenCollection;
use App\Modules\Test\AnswerSheet\Services\AnswerSheetService;
use Illuminate\Http\Request;

class UserTestTakenPaginateController extends Controller
{
    private $testTakenService;

    public function __construct(AnswerSheetService $testTakenService)
    {
        $this->testTakenService = $testTakenService;
    }

    public function get(Request $request){
        $data = $this->testTakenService->paginate_main($request->total ?? 10);
        return UserTestTakenCollection::collection($data);
    }

}
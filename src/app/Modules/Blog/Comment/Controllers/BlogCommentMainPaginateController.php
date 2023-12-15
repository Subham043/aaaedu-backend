<?php

namespace App\Modules\Blog\Comment\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Blog\Comment\Services\CommentService;
use Illuminate\Http\Request;

class BlogCommentMainPaginateController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->middleware('permission:list blogs', ['only' => ['get']]);
        $this->commentService = $commentService;
    }

    public function get(Request $request){
        $data = $this->commentService->admin_main_paginate($request->total ?? 10);
        return view('admin.pages.blog.comment.main_paginate', compact(['data']))
            ->with('search', $request->query('filter')['search'] ?? '');
    }

}

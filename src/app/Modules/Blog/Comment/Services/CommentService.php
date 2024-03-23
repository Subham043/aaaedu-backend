<?php

namespace App\Modules\Blog\Comment\Services;

use App\Modules\Blog\Comment\Models\Comment;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class CommentService
{

    public function all(Int $blog_id): Collection
    {
        return Comment::where('blog_id', $blog_id)->get();
    }

    public function paginate(Int $total = 10, Int $blog_id): LengthAwarePaginator
    {
        $query = Comment::where('blog_id', $blog_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function admin_main_paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Comment::with('blog')->wherehas('blog')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new MainCommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10, Int $blog_id): LengthAwarePaginator
    {
        $query = Comment::where('blog_id', $blog_id)->where('is_approved', true)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Comment|null
    {
        return Comment::findOrFail($id);
    }

    public function getByBlogIdAndId(Int $blog_id, Int $id): Comment|null
    {
        return Comment::where('blog_id', $blog_id)->findOrFail($id);
    }

    public function create(array $data): Comment
    {
        $blog_comment = Comment::create($data);
        if(auth()->check()){
            $blog_comment->user_id = auth()->user()->id;
            $blog_comment->save();
        }
        return $blog_comment;
    }

    public function update(array $data, Comment $blog_comment): Comment
    {
        $blog_comment->update($data);
        return $blog_comment;
    }

    public function delete(Comment $blog_comment): bool|null
    {
        return $blog_comment->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->orWhere('comment', 'LIKE', '%' . $value . '%');
        });
    }
}

class MainCommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->orWhere('comment', 'LIKE', '%' . $value . '%');
        });
    }
}
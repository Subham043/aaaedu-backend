<?php

namespace App\Modules\Course\Branch\Services;

use App\Modules\Course\Branch\Models\Branch;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class BranchService
{

    public function all(): Collection
    {
        return Branch::all();
    }

    public function main_all(): Collection
    {
        return Branch::with([
            'courses',
        ])->where('is_active', true)->get();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Branch::where('is_active', true);
        return QueryBuilder::for($query)
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Branch::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Branch|null
    {
        return Branch::findOrFail($id);
    }

    public function getBySlug(String $slug): Branch|null
    {
        return Branch::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function create(array $data): Branch
    {
        $course = Branch::create($data);
        $course->user_id = auth()->user()->id;
        $course->save();
        return $course;
    }

    public function update(array $data, Branch $course): Branch
    {
        $course->update($data);
        return $course;
    }

    public function delete(Branch $course): bool|null
    {
        return $course->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('slug', 'LIKE', '%' . $value . '%');
        });
    }
}
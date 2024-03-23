<?php

namespace App\Modules\Test\Subject\Services;

use App\Modules\Test\Subject\Models\Subject;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class SubjectService
{

    public function all(Int $test_id): Collection
    {
        return Subject::with('test')->where('test_id', $test_id)->get();
    }

    public function paginate(Int $total = 10, Int $test_id): LengthAwarePaginator
    {
        $query = Subject::with('test')->where('test_id', $test_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Subject|null
    {
        return Subject::with('test')->findOrFail($id);
    }

    public function getByTestIdAndId(Int $test_id, Int $id): Subject|null
    {
        return Subject::with('test')->where('test_id', $test_id)->findOrFail($id);
    }

    public function create(array $data): Subject
    {
        $test_subject = Subject::create($data);
        return $test_subject;
    }

    public function update(array $data, Subject $test_subject): Subject
    {
        $test_subject->update($data);
        return $test_subject;
    }

    public function delete(Subject $test_subject): bool|null
    {
        return $test_subject->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('name', 'LIKE', '%' . $value . '%');
    }
}
<?php

namespace App\Modules\JobOpening\JobOpening\Services;

use App\Modules\JobOpening\JobOpening\Models\JobOpening;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class JobOpeningService
{

    public function all(): Collection
    {
        return JobOpening::all();
    }

    public function all_main(): Collection
    {
        return JobOpening::where('is_active', true)->get();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = JobOpening::where('is_active', true);
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
        $query = JobOpening::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): JobOpening|null
    {
        return JobOpening::findOrFail($id);
    }

    public function create(array $data): JobOpening
    {
        $job = JobOpening::create($data);
        $job->user_id = auth()->user()->id;
        $job->save();
        return $job;
    }

    public function update(array $data, JobOpening $job): JobOpening
    {
        $job->update($data);
        return $job;
    }

    public function delete(JobOpening $job): bool|null
    {
        return $job->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('description_unfiltered', 'LIKE', '%' . $value . '%');
        });
    }
}
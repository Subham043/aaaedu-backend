<?php

namespace App\Modules\Enquiry\CourseRequestForm\Services;

use App\Modules\Enquiry\CourseRequestForm\Models\CourseRequestForm;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class CourseRequestFormService
{

    public function all(): Collection
    {
        return CourseRequestForm::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = CourseRequestForm::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): CourseRequestForm|null
    {
        return CourseRequestForm::findOrFail($id);
    }

    public function create(array $data): CourseRequestForm
    {
        return CourseRequestForm::create($data);
    }

    public function update(array $data, CourseRequestForm $courseRequestForm): CourseRequestForm
    {
        $courseRequestForm->update($data);
        return $courseRequestForm;
    }

    public function delete(CourseRequestForm $courseRequestForm): bool|null
    {
        return $courseRequestForm->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%');
        });
    }
}
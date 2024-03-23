<?php

namespace App\Modules\Enquiry\ScholarForm\Services;

use App\Modules\Enquiry\ScholarForm\Models\ScholarForm;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ScholarFormService
{

    public function all(): Collection
    {
        return ScholarForm::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = ScholarForm::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ScholarForm|null
    {
        return ScholarForm::findOrFail($id);
    }

    public function create(array $data): ScholarForm
    {
        return ScholarForm::create($data);
    }

    public function update(array $data, ScholarForm $contactForm): ScholarForm
    {
        $contactForm->update($data);
        return $contactForm;
    }

    public function delete(ScholarForm $contactForm): bool|null
    {
        return $contactForm->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('branch', 'LIKE', '%' . $value . '%')
            ->orWhere('course', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%');
        });
    }
}
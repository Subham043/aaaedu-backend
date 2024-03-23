<?php

namespace App\Modules\Enquiry\SubscriptionForm\Services;

use App\Modules\Enquiry\SubscriptionForm\Models\SubscriptionForm;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class SubscriptionFormService
{

    public function all(): Collection
    {
        return SubscriptionForm::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = SubscriptionForm::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): SubscriptionForm|null
    {
        return SubscriptionForm::findOrFail($id);
    }

    public function create(array $data): SubscriptionForm
    {
        return SubscriptionForm::create($data);
    }

    public function update(array $data, SubscriptionForm $contactForm): SubscriptionForm
    {
        $contactForm->update($data);
        return $contactForm;
    }

    public function delete(SubscriptionForm $contactForm): bool|null
    {
        return $contactForm->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('email', 'LIKE', '%' . $value . '%');
    }
}
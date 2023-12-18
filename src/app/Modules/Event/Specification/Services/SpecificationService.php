<?php

namespace App\Modules\Event\Specification\Services;

use App\Modules\Event\Specification\Models\Specification;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class SpecificationService
{

    public function all(Int $event_id): Collection
    {
        return Specification::with('event')->where('event_id', $event_id)->get();
    }

    public function paginate(Int $total = 10, Int $event_id): LengthAwarePaginator
    {
        $query = Specification::with('event')->where('event_id', $event_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Specification|null
    {
        return Specification::with('event')->findOrFail($id);
    }

    public function getByEventIdAndId(Int $event_id, Int $id): Specification|null
    {
        return Specification::with('event')->where('event_id', $event_id)->findOrFail($id);
    }

    public function create(array $data): Specification
    {
        $event_specification = Specification::create($data);
        return $event_specification;
    }

    public function update(array $data, Specification $event_specification): Specification
    {
        $event_specification->update($data);
        return $event_specification;
    }

    public function delete(Specification $event_specification): bool|null
    {
        return $event_specification->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('title', 'LIKE', '%' . $value . '%')
            ->orWhere('description', 'LIKE', '%' . $value . '%');
        });
    }
}

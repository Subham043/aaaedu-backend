<?php

namespace App\Modules\ExpertTip\Services;

use App\Modules\ExpertTip\Models\ExpertTip;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ExpertTipService
{

    public function all(): Collection
    {
        return ExpertTip::all();
    }

    public function all_main(): Collection
    {
        return ExpertTip::where('is_active', true)->get();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = ExpertTip::where('is_active', true);
        return QueryBuilder::for($query)
                ->defaultSort('id')
                ->allowedSorts('id', 'name', 'published_on')
                ->allowedFilters([
                    'is_popular',
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = ExpertTip::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    'is_popular',
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ExpertTip|null
    {
        return ExpertTip::findOrFail($id);
    }

    public function getBySlug(String $slug): ExpertTip|null
    {
        return ExpertTip::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function getPrev(Int $id): ExpertTip|null
    {
        return ExpertTip::where('id', '<', $id)
        ->where('is_active', true)
        ->orderBy('id','desc')
        ->first();
    }

    public function getNext(Int $id): ExpertTip|null
    {
        return ExpertTip::where('id', '>', $id)
        ->where('is_active', true)
        ->orderBy('id','desc')
        ->first();
    }

    public function create(array $data): ExpertTip
    {
        $expert_tip = ExpertTip::create($data);
        $expert_tip->user_id = auth()->user()->id;
        $expert_tip->save();
        return $expert_tip;
    }

    public function update(array $data, ExpertTip $expert_tip): ExpertTip
    {
        $expert_tip->update($data);
        return $expert_tip;
    }

    public function delete(ExpertTip $expert_tip): bool|null
    {
        return $expert_tip->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('slug', 'LIKE', '%' . $value . '%')
            ->orWhere('heading', 'LIKE', '%' . $value . '%')
            ->orWhere('description_unfiltered', 'LIKE', '%' . $value . '%');
        });
    }
}

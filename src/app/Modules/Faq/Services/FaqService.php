<?php

namespace App\Modules\Faq\Services;

use App\Modules\Faq\Models\Faq;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class FaqService
{

    public function all(): Collection
    {
        return Faq::all();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Faq::where('is_active', true);
        return QueryBuilder::for($query)
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    'is_popular',
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Faq::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    'is_popular',
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Faq|null
    {
        return Faq::findOrFail($id);
    }

    public function create(array $data): Faq
    {
        $faq = Faq::create($data);
        $faq->user_id = auth()->user()->id;
        $faq->save();
        return $faq;
    }

    public function update(array $data, Faq $faq): Faq
    {
        $faq->update($data);
        return $faq;
    }

    public function delete(Faq $faq): bool|null
    {
        return $faq->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('question', 'LIKE', '%' . $value . '%')
            ->orWhere('answer_unfiltered', 'LIKE', '%' . $value . '%');
        });
    }
}

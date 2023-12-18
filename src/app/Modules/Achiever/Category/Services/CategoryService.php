<?php

namespace App\Modules\Achiever\Category\Services;

use App\Modules\Achiever\Category\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class CategoryService
{

    public function all(): Collection
    {
        return Category::all();
    }

    public function allMain(): Collection
    {
        return Category::where('is_active', true)->get();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Category::where('is_active', true);
        return QueryBuilder::for($query)
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Category::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Category|null
    {
        return Category::findOrFail($id);
    }

    public function getBySlug(String $slug): Category|null
    {
        return Category::where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function create(array $data): Category
    {
        $category = Category::create($data);
        $category->user_id = auth()->user()->id;
        $category->save();
        return $category;
    }

    public function update(array $data, Category $category): Category
    {
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): bool|null
    {
        return $category->delete();
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
            ->orWhere('description', 'LIKE', '%' . $value . '%');
        });
    }
}

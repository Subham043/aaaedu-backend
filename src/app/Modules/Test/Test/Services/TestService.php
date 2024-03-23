<?php

namespace App\Modules\Test\Test\Services;

use App\Http\Services\FileService;
use App\Modules\Test\Test\Models\Test;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class TestService
{

    public function all(): Collection
    {
        return Test::all();
    }

    public function all_main(): Collection
    {
        return Test::where('is_active', true)->get();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Test::with('test_taken')->where('is_active', true);
        return QueryBuilder::for($query)
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                    AllowedFilter::callback('has_status', function (Builder $query, $value) {
                        $query->whereHas('test_taken', function($q) use($value) {
                            $q->where('test_status', $value);
                        });
                    }),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Test::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Test|null
    {
        return Test::findOrFail($id);
    }

    public function getBySlug(String $slug): Test|null
    {
        return Test::with('test_taken')->where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function create(array $data): Test
    {
        $event = Test::create($data);
        $event->user_id = auth()->user()->id;
        $event->save();
        return $event;
    }

    public function update(array $data, Test $event): Test
    {
        $event->update($data);
        return $event;
    }

    public function saveImage(Test $event): Test
    {
        $this->deleteImage($event);
        $image = (new FileService)->save_file('image', (new Test)->image_path);
        return $this->update([
            'image' => $image,
        ], $event);
    }

    public function delete(Test $event): bool|null
    {
        $this->deleteImage($event);
        return $event->delete();
    }

    public function deleteImage(Test $event): void
    {
        if($event->image){
            $path = str_replace("storage","app/public",$event->image);
            (new FileService)->delete_file($path);
        }
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('slug', 'LIKE', '%' . $value . '%')
            ->orWhere('description_unfiltered', 'LIKE', '%' . $value . '%');
        });
    }
}
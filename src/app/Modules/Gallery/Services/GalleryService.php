<?php

namespace App\Modules\Gallery\Services;

use App\Http\Services\FileService;
use App\Modules\Gallery\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class GalleryService
{

    public function all(): Collection
    {
        return Gallery::all();
    }

    public function main_all(): Collection
    {
        return Gallery::where('is_active', true)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Gallery::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Gallery::where('is_active', true)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Gallery|null
    {
        return Gallery::findOrFail($id);
    }

    public function create(array $data): Gallery
    {
        $testimonial = Gallery::create($data);
        $testimonial->user_id = auth()->user()->id;
        $testimonial->save();
        return $testimonial;
    }

    public function update(array $data, Gallery $testimonial): Gallery
    {
        $testimonial->update($data);
        return $testimonial;
    }

    public function saveImage(Gallery $testimonial): Gallery
    {
        $this->deleteImage($testimonial);
        $image = (new FileService)->save_file('image', (new Gallery)->image_path);
        return $this->update([
            'image' => $image,
        ], $testimonial);
    }

    public function delete(Gallery $testimonial): bool|null
    {
        return $testimonial->delete();
    }

    public function deleteImage(Gallery $testimonial): void
    {
        if($testimonial->image){
            $path = str_replace("storage","app/public",$testimonial->image);
            (new FileService)->delete_file($path);
        }
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

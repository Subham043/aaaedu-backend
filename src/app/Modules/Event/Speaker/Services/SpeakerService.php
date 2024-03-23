<?php

namespace App\Modules\Event\Speaker\Services;

use App\Http\Services\FileService;
use App\Modules\Event\Speaker\Models\Speaker;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class SpeakerService
{

    public function all(): Collection
    {
        return Speaker::all();
    }

    public function main_all(): Collection
    {
        return Speaker::get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Speaker::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Speaker|null
    {
        return Speaker::findOrFail($id);
    }

    public function create(array $data): Speaker
    {
        $speaker = Speaker::create($data);
        return $speaker;
    }

    public function update(array $data, Speaker $speaker): Speaker
    {
        $speaker->update($data);
        return $speaker;
    }

    public function saveImage(Speaker $speaker): Speaker
    {
        $this->deleteImage($speaker);
        $image = (new FileService)->save_file('image', (new Speaker)->image_path);
        return $this->update([
            'image' => $image,
        ], $speaker);
    }

    public function delete(Speaker $speaker): bool|null
    {
        return $speaker->delete();
    }

    public function deleteImage(Speaker $speaker): void
    {
        if($speaker->image){
            $path = str_replace("storage","app/public",$speaker->image);
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
            ->orWhere('designation', 'LIKE', '%' . $value . '%')
            ->orWhere('qualification', 'LIKE', '%' . $value . '%');
        });
    }
}
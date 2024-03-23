<?php

namespace App\Modules\Event\Event\Services;

use App\Http\Services\FileService;
use App\Modules\Event\Event\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class EventService
{

    public function all(): Collection
    {
        return Event::with([
            'speakers',
            'specifications',
        ])->get();
    }

    public function all_main(): Collection
    {
        return Event::with([
            'speakers',
            'specifications',
        ])->where('is_active', true)->get();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Event::with([
            'speakers',
            'specifications',
        ])->where('is_active', true);
        return QueryBuilder::for($query)
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Event::with([
            'speakers',
            'specifications',
        ])->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Event|null
    {
        return Event::with([
            'speakers',
            'specifications',
        ])->findOrFail($id);
    }

    public function getBySlug(String $slug): Event|null
    {
        return Event::with([
            'speakers',
            'specifications',
        ])->where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function create(array $data): Event
    {
        $event = Event::create($data);
        $event->user_id = auth()->user()->id;
        $event->save();
        return $event;
    }

    public function update(array $data, Event $event): Event
    {
        $event->update($data);
        return $event;
    }

    public function saveImage(Event $event): Event
    {
        $this->deleteImage($event);
        $image = (new FileService)->save_file('image', (new Event)->image_path);
        return $this->update([
            'image' => $image,
        ], $event);
    }

    public function delete(Event $event): bool|null
    {
        $this->deleteImage($event);
        return $event->delete();
    }

    public function deleteImage(Event $event): void
    {
        if($event->image){
            $path = str_replace("storage","app/public",$event->image);
            (new FileService)->delete_file($path);
        }
    }

    public function save_speakers(Event $event, array $data): Event
    {
        $event->speakers()->sync($data);
        return $event;
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
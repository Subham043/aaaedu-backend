<?php

namespace App\Modules\Campaign\Campaign\Services;

use App\Http\Services\FileService;
use App\Modules\Campaign\Campaign\Models\Campaign;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class CampaignService
{

    public function all(): Collection
    {
        return Campaign::with([
            'testimonials',
            'achievers',
        ])->get();
    }

    public function all_main(): Collection
    {
        return Campaign::with([
            'testimonials',
            'achievers',
        ])->where('is_active', true)->get();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Campaign::with([
            'testimonials',
            'achievers',
        ])->where('is_active', true);
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
        $query = Campaign::with([
            'testimonials',
            'achievers',
        ])->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Campaign|null
    {
        return Campaign::with([
            'testimonials',
            'achievers',
        ])->findOrFail($id);
    }

    public function getBySlug(String $slug): Campaign|null
    {
        return Campaign::with([
            'testimonials',
            'achievers',
        ])->where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function create(array $data): Campaign
    {
        $campaign = Campaign::create($data);
        $campaign->user_id = auth()->user()->id;
        $campaign->save();
        return $campaign;
    }

    public function update(array $data, Campaign $campaign): Campaign
    {
        $campaign->update($data);
        return $campaign;
    }

    public function saveImage(Campaign $campaign): Campaign
    {
        $this->deleteImage($campaign);
        $image = (new FileService)->save_file('image', (new Campaign)->image_path);
        return $this->update([
            'image' => $image,
        ], $campaign);
    }

    public function delete(Campaign $campaign): bool|null
    {
        $this->deleteImage($campaign);
        return $campaign->delete();
    }

    public function deleteImage(Campaign $campaign): void
    {
        if($campaign->image){
            $path = str_replace("storage","app/public",$campaign->image);
            (new FileService)->delete_file($path);
        }
    }

    public function save_testimonials(Campaign $campaign, array $data): Campaign
    {
        $campaign->testimonials()->sync($data);
        return $campaign;
    }

    public function save_achievers(Campaign $campaign, array $data): Campaign
    {
        $campaign->achievers()->sync($data);
        return $campaign;
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

<?php

namespace App\Modules\Campaign\Enquiry\Services;

use App\Modules\Campaign\Enquiry\Models\Enquiry;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class EnquiryService
{

    public function all(Int $campaign_id): Collection
    {
        return Enquiry::with('campaign')->where('campaign_id', $campaign_id)->get();
    }

    public function paginate(Int $total = 10, Int $campaign_id): LengthAwarePaginator
    {
        $query = Enquiry::with('campaign')->where('campaign_id', $campaign_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function admin_main_paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Enquiry::with('campaign')->whereHas('campaign')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CampaignCommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Enquiry|null
    {
        return Enquiry::with('campaign')->findOrFail($id);
    }

    public function getByCampaignIdAndId(Int $campaign_id, Int $id): Enquiry|null
    {
        return Enquiry::with('campaign')->where('campaign_id', $campaign_id)->findOrFail($id);
    }

    public function create(array $data): Enquiry
    {
        $campaign_enquiry = Enquiry::create($data);
        return $campaign_enquiry;
    }

    public function update(array $data, Enquiry $campaign_enquiry): Enquiry
    {
        $campaign_enquiry->update($data);
        return $campaign_enquiry;
    }

    public function delete(Enquiry $campaign_enquiry): bool|null
    {
        return $campaign_enquiry->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%');
        });
    }
}

class CampaignCommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%');
        });
    }
}

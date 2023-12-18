<?php

namespace App\Modules\JobOpening\JobEnquiry\Services;

use App\Http\Services\FileService;
use App\Modules\JobOpening\JobEnquiry\Models\JobEnquiry;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class JobEnquiryService
{

    public function all(Int $job_id): Collection
    {
        return JobEnquiry::where('job_id', $job_id)->get();
    }

    public function paginate(Int $total = 10, Int $job_id): LengthAwarePaginator
    {
        $query = JobEnquiry::where('job_id', $job_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function admin_main_paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = JobEnquiry::with('job')->wherehas('job')->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new MainCommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10, Int $job_id): LengthAwarePaginator
    {
        $query = JobEnquiry::where('job_id', $job_id)->where('is_approved', true)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): JobEnquiry|null
    {
        return JobEnquiry::findOrFail($id);
    }

    public function getByBlogIdAndId(Int $job_id, Int $id): JobEnquiry|null
    {
        return JobEnquiry::where('job_id', $job_id)->findOrFail($id);
    }

    public function create(array $data): JobEnquiry
    {
        $job_enquiry = JobEnquiry::create($data);
        return $job_enquiry;
    }

    public function update(array $data, JobEnquiry $job_enquiry): JobEnquiry
    {
        $job_enquiry->update($data);
        return $job_enquiry;
    }

    public function saveCv(JobEnquiry $jobEnquiry): JobEnquiry
    {
        $this->deleteImage($jobEnquiry);
        $cv = (new FileService)->save_file('cv', (new JobEnquiry)->cv_path);
        return $this->update([
            'cv' => $cv,
        ], $jobEnquiry);
    }

    public function delete(JobEnquiry $job_enquiry): bool|null
    {
        return $job_enquiry->delete();
    }

    public function deleteImage(JobEnquiry $jobEnquiry): void
    {
        if($jobEnquiry->cv){
            $path = str_replace("storage","app/public",$jobEnquiry->cv);
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
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%');
        });
    }
}

class MainCommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%');
        });
    }
}

<?php

namespace App\Modules\TeamMember\Staff\Services;

use App\Http\Services\FileService;
use App\Modules\TeamMember\Staff\Models\Staff;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\AllowedFilter;

class StaffService
{

    public function all(): Collection
    {
        return Staff::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Staff::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Staff::where('is_active', true)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Staff|null
    {
        return Staff::findOrFail($id);
    }

    public function create(array $data): Staff
    {
        $staff = Staff::create($data);
        $staff->user_id = auth()->user()->id;
        $staff->save();
        return $staff;
    }

    public function update(array $data, Staff $staff): Staff
    {
        $staff->update($data);
        return $staff;
    }

    public function saveImage(Staff $staff): Staff
    {
        $this->deleteImage($staff);
        $image = (new FileService)->save_file('image', (new Staff)->image_path);
        return $this->update([
            'image' => $image,
        ], $staff);
    }

    public function delete(Staff $staff): bool|null
    {
        $this->deleteImage($staff);
        return $staff->delete();
    }

    public function deleteImage(Staff $staff): void
    {
        if($staff->image){
            $path = str_replace("storage","app/public",$staff->image);
            (new FileService)->delete_file($path);
        }
    }

    public function main_all(): Collection
    {
        return Staff::where('is_active', true)->get();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('designation', 'LIKE', '%' . $value . '%');
        });
    }
}

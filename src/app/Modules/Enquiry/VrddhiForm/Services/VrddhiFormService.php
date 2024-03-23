<?php

namespace App\Modules\Enquiry\VrddhiForm\Services;

use App\Http\Services\FileService;
use App\Modules\Enquiry\VrddhiForm\Models\VrddhiForm;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class VrddhiFormService
{

    public function all(): Collection
    {
        return VrddhiForm::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = VrddhiForm::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): VrddhiForm|null
    {
        return VrddhiForm::findOrFail($id);
    }

    public function create(array $data): VrddhiForm
    {
        return VrddhiForm::create($data);
    }

    public function update(array $data, VrddhiForm $vrddhi): VrddhiForm
    {
        $vrddhi->update($data);
        return $vrddhi;
    }

    public function saveImage(VrddhiForm $vrddhi): VrddhiForm
    {
        $this->deleteImage($vrddhi);
        $card = (new FileService)->save_file('card', (new VrddhiForm)->image_path);
        return $this->update([
            'card' => $card,
        ], $vrddhi);
    }

    public function delete(VrddhiForm $vrddhi): bool|null
    {
        $this->deleteImage($vrddhi);
        return $vrddhi->delete();
    }

    public function deleteImage(VrddhiForm $vrddhi): void
    {
        if($vrddhi->card){
            $path = str_replace("storage","app/public",$vrddhi->card);
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
            ->orWhere('school_name', 'LIKE', '%' . $value . '%')
            ->orWhere('class', 'LIKE', '%' . $value . '%')
            ->orWhere('father_name', 'LIKE', '%' . $value . '%')
            ->orWhere('father_email', 'LIKE', '%' . $value . '%')
            ->orWhere('father_phone', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_name', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_email', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_phone', 'LIKE', '%' . $value . '%')
            ->orWhere('syllabus', 'LIKE', '%' . $value . '%')
            ->orWhere('phone', 'LIKE', '%' . $value . '%');
        });
    }
}
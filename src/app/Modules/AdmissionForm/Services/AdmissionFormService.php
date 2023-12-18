<?php

namespace App\Modules\AdmissionForm\Services;

use App\Enums\AdmissionEnum;
use App\Http\Services\FileService;
use App\Modules\AdmissionForm\Models\AdmissionForm;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class AdmissionFormService
{

    public function all(): Collection
    {
        return AdmissionForm::all();
    }

    public function paginatePuc(Int $total = 10): LengthAwarePaginator
    {
        $query = AdmissionForm::where('admission_for', AdmissionEnum::PUC)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateNotPuc(Int $total = 10): LengthAwarePaginator
    {
        $query = AdmissionForm::where('admission_for', AdmissionEnum::NOT_PUC)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): AdmissionForm|null
    {
        return AdmissionForm::findOrFail($id);
    }

    public function create(array $data): AdmissionForm
    {
        return AdmissionForm::create($data);
    }

    public function update(array $data, AdmissionForm $admission): AdmissionForm
    {
        $admission->update($data);
        return $admission;
    }

    public function saveImage(AdmissionForm $admission): AdmissionForm
    {
        $this->deleteImage($admission);
        $marks = (new FileService)->save_file('marks', (new AdmissionForm)->image_path);
        return $this->update([
            'marks' => $marks,
        ], $admission);
    }

    public function delete(AdmissionForm $admission): bool|null
    {
        $this->deleteImage($admission);
        return $admission->delete();
    }

    public function deleteImage(AdmissionForm $admission): void
    {
        if($admission->marks){
            $path = str_replace("storage","app/public",$admission->marks);
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
            ->orWhere('father_occupation', 'LIKE', '%' . $value . '%')
            ->orWhere('father_phone', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_name', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_occupation', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_phone', 'LIKE', '%' . $value . '%')
            ->orWhere('center', 'LIKE', '%' . $value . '%')
            ->orWhere('aadhar', 'LIKE', '%' . $value . '%')
            ->orWhere('address', 'LIKE', '%' . $value . '%')
            ->orWhere('percentage', 'LIKE', '%' . $value . '%')
            ->orWhere('batch', 'LIKE', '%' . $value . '%');
        });
    }
}

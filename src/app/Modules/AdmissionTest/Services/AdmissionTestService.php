<?php

namespace App\Modules\AdmissionTest\Services;

use App\Enums\PaymentStatus;
use App\Http\Services\FileService;
use App\Modules\AdmissionTest\Models\AdmissionTest;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class AdmissionTestService
{

    public function all(): Collection
    {
        return AdmissionTest::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = AdmissionTest::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): AdmissionTest|null
    {
        return AdmissionTest::findOrFail($id);
    }

    public function getByUserId(Int $user_id): AdmissionTest|null
    {
        return AdmissionTest::where('user_id', $user_id)->first();
    }

    public function findByEmail(String $email): AdmissionTest|null
    {
        return AdmissionTest::where('email', $email)->first();
    }

    public function create(array $data): AdmissionTest
    {
        return AdmissionTest::create($data);
    }

    public function update(array $data, AdmissionTest $admission): AdmissionTest
    {
        $admission->update($data);
        return $admission;
    }

    public function saveImage(AdmissionTest $admission): AdmissionTest
    {
        $this->deleteImage($admission);
        $image = (new FileService)->save_file('image', (new AdmissionTest)->image_path);
        return $this->update([
            'image' => $image,
        ], $admission);
    }

    public function delete(AdmissionTest $admission): bool|null
    {
        $this->deleteImage($admission);
        return $admission->delete();
    }

    public function deleteImage(AdmissionTest $admission): void
    {
        if($admission->image){
            $path = str_replace("storage","app/public",$admission->image);
            (new FileService)->delete_file($path);
        }
    }

    public function verify_payment(array $data): AdmissionTest
    {
        $enrollmentForm = AdmissionTest::where('razorpay_order_id', $data['razorpay_order_id'])->firstOrFail();
        $enrollmentForm->razorpay_payment_id = $data['razorpay_payment_id'];
        $enrollmentForm->razorpay_signature = $data['razorpay_signature'];
        $enrollmentForm->payment_status = PaymentStatus::PAID;
        $enrollmentForm->save();
        return $enrollmentForm;
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%')
            ->orWhere('school_name', 'LIKE', '%' . $value . '%')
            ->orWhere('class', 'LIKE', '%' . $value . '%')
            ->orWhere('father_name', 'LIKE', '%' . $value . '%')
            ->orWhere('father_email', 'LIKE', '%' . $value . '%')
            ->orWhere('father_phone', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_name', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_email', 'LIKE', '%' . $value . '%')
            ->orWhere('mother_phone', 'LIKE', '%' . $value . '%')
            ->orWhere('mode', 'LIKE', '%' . $value . '%')
            ->orWhere('exam_center', 'LIKE', '%' . $value . '%')
            ->orWhere('razorpay_order_id', 'LIKE', '%' . $value . '%')
            ->orWhere('receipt', 'LIKE', '%' . $value . '%');
        });
    }
}

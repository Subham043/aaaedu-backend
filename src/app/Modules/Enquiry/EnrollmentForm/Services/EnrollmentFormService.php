<?php

namespace App\Modules\Enquiry\EnrollmentForm\Services;

use App\Enums\PaymentStatus;
use App\Modules\Enquiry\EnrollmentForm\Models\EnrollmentForm;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class EnrollmentFormService
{

    public function all(): Collection
    {
        return EnrollmentForm::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = EnrollmentForm::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): EnrollmentForm|null
    {
        return EnrollmentForm::findOrFail($id);
    }

    public function create(array $data): EnrollmentForm
    {
        return EnrollmentForm::create($data);
    }

    public function update(array $data, EnrollmentForm $enrollmentForm): EnrollmentForm
    {
        $enrollmentForm->update($data);
        return $enrollmentForm;
    }

    public function delete(EnrollmentForm $enrollmentForm): bool|null
    {
        return $enrollmentForm->delete();
    }

    public function verify_payment(array $data): EnrollmentForm
    {
        $enrollmentForm = EnrollmentForm::where('razorpay_order_id', $data['razorpay_order_id'])->firstOrFail();
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
            ->orWhere('phone', 'LIKE', '%' . $value . '%')
            ->orWhere('email', 'LIKE', '%' . $value . '%');
        });
    }
}
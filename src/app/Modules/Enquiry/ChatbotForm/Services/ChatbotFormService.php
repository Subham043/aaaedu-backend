<?php

namespace App\Modules\Enquiry\ChatbotForm\Services;

use App\Modules\Enquiry\ChatbotForm\Models\ChatbotForm;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class ChatbotFormService
{

    public function all(): Collection
    {
        return ChatbotForm::all();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = ChatbotForm::latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): ChatbotForm|null
    {
        return ChatbotForm::findOrFail($id);
    }

    public function getByLeadId(Int $lead_id): ChatbotForm|null
    {
        return ChatbotForm::where('lead_id', $lead_id)->firstOrFail();
    }

    public function create(array $data): ChatbotForm
    {
        return ChatbotForm::create($data);
    }

    public function update(array $data, ChatbotForm $courseRequestForm): ChatbotForm
    {
        $courseRequestForm->update($data);
        return $courseRequestForm;
    }

    public function delete(ChatbotForm $courseRequestForm): bool|null
    {
        return $courseRequestForm->delete();
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

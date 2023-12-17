<?php

namespace App\Modules\Test\Questionarie\Services;

use App\Modules\Test\Questionarie\Models\Questionarie;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class QuestionarieService
{

    public function all(Int $quiz_id): Collection
    {
        return Questionarie::with(['quiz'])->where('quiz_id', $quiz_id)->get();
    }

    public function paginate(Int $total = 10, Int $quiz_id): LengthAwarePaginator
    {
        $query = Questionarie::with(['quiz'])->where('quiz_id', $quiz_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Questionarie|null
    {
        return Questionarie::with(['quiz'])->findOrFail($id);
    }

    public function getByQuizIdAndId(Int $quiz_id, Int $id): Questionarie|null
    {
        return Questionarie::with(['quiz'])->where('quiz_id', $quiz_id)->findOrFail($id);
    }

    public function create(array $data): Questionarie
    {
        $test_quiz = Questionarie::create($data);
        return $test_quiz;
    }

    public function update(array $data, Questionarie $test_quiz): Questionarie
    {
        $test_quiz->update($data);
        return $test_quiz;
    }

    public function delete(Questionarie $test_quiz): bool|null
    {
        return $test_quiz->delete();
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('question_unfiltered', 'LIKE', '%' . $value . '%')
        ->orWhere('answer_1_unfiltered', 'LIKE', '%' . $value . '%')
        ->orWhere('answer_3_unfiltered', 'LIKE', '%' . $value . '%')
        ->orWhere('answer_4_unfiltered', 'LIKE', '%' . $value . '%')
        ->orWhere('answer_2_unfiltered', 'LIKE', '%' . $value . '%');
    }
}

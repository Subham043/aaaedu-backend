<?php

namespace App\Modules\Test\Quiz\Services;

use App\Modules\Test\Quiz\Models\Quiz;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class QuizService
{

    public function all(Int $test_id): Collection
    {
        return Quiz::with(['test', 'subject'])->where('test_id', $test_id)->get();
    }

    public function paginate(Int $total = 10, Int $test_id): LengthAwarePaginator
    {
        $query = Quiz::with(['test', 'subject'])->where('test_id', $test_id)->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Quiz|null
    {
        return Quiz::with(['test', 'subject'])->findOrFail($id);
    }

    public function getByTestIdAndId(Int $test_id, Int $id): Quiz|null
    {
        return Quiz::with(['test', 'subject'])->where('test_id', $test_id)->findOrFail($id);
    }

    public function create(array $data): Quiz
    {
        $test_quiz = Quiz::create($data);
        return $test_quiz;
    }

    public function update(array $data, Quiz $test_quiz): Quiz
    {
        $test_quiz->update($data);
        return $test_quiz;
    }

    public function delete(Quiz $test_quiz): bool|null
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

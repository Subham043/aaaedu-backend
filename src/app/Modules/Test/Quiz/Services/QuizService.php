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

    public function all_main_grouped_by_subjects(Int $test_id): Collection
    {
        return Quiz::with(['test', 'subject'])->where('test_id', $test_id)->orderBy('subject_id', 'ASC')->get();
    }

    public function count_main_grouped_by_subjects(Int $test_id): int
    {
        return Quiz::where('test_id', $test_id)->orderBy('subject_id', 'ASC')->count();
    }

    public function total_score_main(Int $test_id): int
    {
        return Quiz::where('test_id', $test_id)->orderBy('subject_id', 'ASC')->sum('mark');
    }

    public function total_score_main_grouped_by_subjects(Int $test_id): Collection
    {
        return Quiz::selectRaw('sum(mark), subject_id')->with('subject')->where('test_id', $test_id)->groupBy('subject_id')->get();
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

    public function getCurrentQuizByTestId(Int $test_id): Quiz
    {
        return Quiz::with(['test', 'subject'])->where('test_id', $test_id)->firstOrFail();
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
        $query->where('difficulty', 'LIKE', '%' . $value . '%')
        ->orWhere('duration', 'LIKE', '%' . $value . '%')
        ->orWhere('mark', 'LIKE', '%' . $value . '%');
    }
}

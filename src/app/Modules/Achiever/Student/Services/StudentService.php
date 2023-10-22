<?php

namespace App\Modules\Achiever\Student\Services;

use App\Http\Services\FileService;
use App\Modules\Achiever\Student\Models\Student;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class StudentService
{

    public function all(): Collection
    {
        return Student::with([
            'categories' => function($q){
                $q->where('is_active', true);
            },
        ])->get();
    }

    public function main_all(): Collection
    {
        return Student::with([
            'categories' => function($q){
                $q->where('is_active', true);
            },
        ])->where('is_active', true)->get();
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Student::with([
            'categories' => function($q){
                $q->where('is_active', true);
            },
        ])->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $queryOrder = 'CASE WHEN `rank` = "qualified" THEN 3 ';
        $queryOrder .= 'WHEN `rank` = "Qualified" THEN 2 ';
        $queryOrder .= 'ELSE 1 END';

        $query = Student::with([
            'categories' => function($q){
                $q->where('is_active', true);
            },
        ])
        ->orderByRaw($queryOrder)
        ->orderByRaw('LENGTH(`rank`) ASC')
        ->orderBy('rank', 'ASC');
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::callback('has_categories', function (Builder $query, $value) {
                        $query->whereHas('categories', function($q) use($value) {
                            $q->where('is_active', true)->where(function($qr) use($value){
                                // $qr->where('category_id', $value);
                                $qr->where('slug', $value);
                            });
                        });
                    }),
                    AllowedFilter::custom('search', new CommonFilter),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Student|null
    {
        return Student::findOrFail($id);
    }

    public function create(array $data): Student
    {
        $student = Student::create($data);
        $student->user_id = auth()->user()->id;
        $student->save();
        return $student;
    }

    public function update(array $data, Student $student): Student
    {
        $student->update($data);
        return $student;
    }

    public function saveImage(Student $student): Student
    {
        $this->deleteImage($student);
        $image = (new FileService)->save_file('image', (new Student)->image_path);
        return $this->update([
            'image' => $image,
        ], $student);
    }

    public function delete(Student $student): bool|null
    {
        return $student->delete();
    }

    public function deleteImage(Student $student): void
    {
        if($student->image){
            $path = str_replace("storage","app/public",$student->image);
            (new FileService)->delete_file($path);
        }
    }

    public function save_categories(Student $student, array $data): Student
    {
        $student->categories()->sync($data);
        return $student;
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where('name', 'LIKE', '%' . $value . '%')
        ->orWhere('rank', 'LIKE', '%' . $value . '%')
        ->orWhere('college', 'LIKE', '%' . $value . '%');
    }
}

<?php

namespace App\Modules\Course\Course\Services;

use App\Http\Services\FileService;
use App\Modules\Course\Course\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;

class CourseService
{

    public function all(): Collection
    {
        return Course::with([
            'branches',
        ])->get();
    }

    public function all_main(): Collection
    {
        return Course::with([
            'branches',
        ])->where('is_active', true)->get();
    }

    public function paginateMain(Int $total = 10): LengthAwarePaginator
    {
        $query = Course::with([
            'branches',
        ])->where('is_active', true);
        return QueryBuilder::for($query)
                ->defaultSort('id')
                ->allowedSorts('id', 'name')
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function paginate(Int $total = 10): LengthAwarePaginator
    {
        $query = Course::with([
            'branches',
            'branch_details',
        ])->latest();
        return QueryBuilder::for($query)
                ->allowedFilters([
                    AllowedFilter::custom('search', new CommonFilter, null, false),
                ])
                ->paginate($total)
                ->appends(request()->query());
    }

    public function getById(Int $id): Course|null
    {
        return Course::with([
            'branches',
            'branch_details',
        ])->findOrFail($id);
    }

    public function getBySlug(String $slug): Course|null
    {
        return Course::with([
            'branch_details',
        ])->where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function getBySlugAndBranchDetail(String $course_slug, String $branch_slug): Course|null
    {
        return Course::with([
            'branch_details' => function($query) use($branch_slug){
                $query->whereHas('branch', function($q) use($branch_slug) {
                    $q->with([
                        'testimonials',
                        'achievers',
                        'staffs',
                    ])->where('slug', $branch_slug)->where('is_active', true);
                });
            },
        ])->where('slug', $course_slug)->where('is_active', true)->whereHas('branch_details', function($q) use($branch_slug) {
            $q->whereHas('branch', function($qr) use($branch_slug) {
                $qr->where('slug', $branch_slug)->where('is_active', true);
            });
        })->firstOrFail();
    }

    public function create(array $data): Course
    {
        $course = Course::create($data);
        $course->user_id = auth()->user()->id;
        $course->save();
        return $course;
    }

    public function update(array $data, Course $course): Course
    {
        $course->update($data);
        return $course;
    }

    public function saveImage(Course $course): Course
    {
        $this->deleteImage($course);
        $image = (new FileService)->save_file('image', (new Course)->image_path);
        return $this->update([
            'image' => $image,
        ], $course);
    }

    public function delete(Course $course): bool|null
    {
        $this->deleteImage($course);
        return $course->delete();
    }

    public function deleteImage(Course $course): void
    {
        if($course->image){
            $path = str_replace("storage","app/public",$course->image);
            (new FileService)->delete_file($path);
        }
    }

    public function save_branches(Course $course, array $data): Course
    {
        $course->branches()->sync($data);
        return $course;
    }

}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        $query->where(function($q) use($value){
            $q->where('name', 'LIKE', '%' . $value . '%')
            ->orWhere('slug', 'LIKE', '%' . $value . '%')
            ->orWhere('description_unfiltered', 'LIKE', '%' . $value . '%');
        });
    }
}
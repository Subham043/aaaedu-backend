<?php

namespace App\Modules\AboutPage\Main\Services;

use App\Http\Services\FileService;
use App\Modules\AboutPage\Main\Models\Main;

class MainService
{

    public function getById(Int $id): Main|null
    {
        return Main::where('id', $id)->first();
    }

    public function getBySlug(String $slug): Main|null
    {
        return Main::where('page', $slug)->first();
    }

    public function createOrUpdate(array $data, string $slug): Main
    {
        $main = Main::updateOrCreate(
            ['page' => $slug],
            [...$data]
        );

        $main->user_id = auth()->user()->id;
        $main->save();

        return $main;
    }

    public function saveImage(Main $main): Main
    {
        $this->deleteImage($main);
        $image = (new FileService)->save_file('image', (new Main)->image_path);
        $main->update([
            'image' => $image,
        ]);
        return $main;
    }

    public function saveCounterImage(Main $main): Main
    {
        $this->deleteCounterImage($main);
        $image = (new FileService)->save_file('counter_image', (new Main)->image_path);
        $main->update([
            'counter_image' => $image,
        ]);
        return $main;
    }

    public function deleteImage(Main $main): void
    {
        if($main->image){
            $path = str_replace("storage","app/public",$main->image);
            (new FileService)->delete_file($path);
        }
    }

    public function deleteCounterImage(Main $main): void
    {
        if($main->counter_image){
            $path = str_replace("storage","app/public",$main->counter_image);
            (new FileService)->delete_file($path);
        }
    }

}

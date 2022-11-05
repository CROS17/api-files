<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        $filepath = storage_path('file-users');


        return [
            //
            'url' => $this->faker->imageUrl(100, 100)
        ];
    }
}

<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Travel',
                'description' => 'Travel description'
            ],
            [
                'name' => 'Music',
                'description' => 'Music description'
            ],
            [
                'name' => 'Food',
                'description' => 'Food description'
            ],
            [
                'name' => 'Design',
                'description' => 'Design description'
            ],
            [
                'name' => 'Fitness',
                'description' => 'Fitness description'
            ],
            [
                'name' => 'Economics',
                'description' => 'Economics description'
            ],
        ];

        foreach ($categories as $category) {
            $newCategory = new Category();

            $newCategory->fill($category);
            $newCategory->save();
        }

    }
}

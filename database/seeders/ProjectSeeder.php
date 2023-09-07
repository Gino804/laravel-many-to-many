<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Type;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {

        $type_ids = Type::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            $project = new Project();
            $project->type_id = Arr::random($type_ids);
            $project->title = $faker->text(20);
            $project->slug = Str::slug($project->title, '-');
            $project->description = $faker->paragraphs(5, true);
            //$project->image = Storage::putFile('project_images', $faker->image(storage_path('app/public/project_images'), 250, 250));
            $project->save();
        }
    }
}

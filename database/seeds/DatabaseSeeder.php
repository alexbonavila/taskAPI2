<?php

use App\Tag;
use App\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        // $this->call(UserTableSeeder::class);
        $faker = Faker\Factory::create();
        $this->seedTasks($faker);
        $this->seedTags($faker);
        $this->seedTaskTag($faker);
        Model::reguard();
    }
    /**
     * @param Faker $faker
     */
    private function seedTasks($faker)
    {

        foreach (range(0,100) as $item) {
            $task = new Task();
            $task->name = $faker->sentence();
            $task->done = $faker->boolean();
            $task->priority = $faker->randomDigit();
            $task->save();
        }
    }
    private function seedTags($faker)
    {
        foreach (range(0,100) as $item) {
            $tag = new Tag();
            $tag->title = $faker->word;
            //$tag->prova = $faker->boolean();
            $tag->save();
        }
    }

    private function seedTaskTag($faker)
    {
        foreach (range(0,100) as $item)
        {
            DB::table('task_tag')->insert([
                'task_id' => $faker->randomDigit,
                'tag_id' => $faker->randomDigit
            ]);
        }
    }

}

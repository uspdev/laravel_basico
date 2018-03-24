<?php

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
        echo "Creating 10 users...\n";
        factory(App\User::class, 10)->create();

        echo "Creating 10 authors...\n";
        factory(App\Author::class, 10)->create();

        echo "Creating 36 posts related to random authors...\n";
        factory(App\Post::class, 36)->create();

        echo "Creating 67 comments related to random posts...\n";
        factory(App\Comment::class, 67)->create();
    }
}

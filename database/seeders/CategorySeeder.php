<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `categories` (`id`, `title`, `title_meta`, `slug`, `description`, `status`, `priority`, `parent_category_id`) VALUES
            (1, 'Technology', 'Technology', 'technology', 'tech description', 'awaiting review', 1, NULL),
            (2, 'Sports', 'Sports', 'sports', 'sports description (edited)', 'awaiting review', 2, NULL),
            (3, 'Gaming', 'Gaming', 'gaming', 'gaming description', 'awaiting review', 4, NULL),
            (4, 'Fashion', 'Fashion', 'fashion', 'fashion description', 'awaiting review', 5, NULL),
            (5, 'Fitness', 'Fitness', 'fitness', 'fitness description', 'awaiting review', 3, NULL),
            (6, 'Pet', 'Pet', 'pet', 'pet description', 'awaiting review', 6, NULL),
            (7, 'Business', 'Business', 'business', 'business description', 'awaiting review', 7, NULL),
            (8, 'DIY', 'DIY', 'diy', 'diy description', 'awaiting review', 10, NULL),
            (9, 'Lifestyle', 'Lifestyle', 'lifestyle', 'lifestyle description', 'awaiting review', 9, NULL),
            (10, 'Music', 'Music', 'music', 'music description', 'awaiting review', 8, NULL),
            (11, 'Front-end development', 'Front-end development', 'front-end-development', 'front-end description', 'awaiting review', 11, 1),
            (12, 'Back-end development', 'Back-end development', 'back-end-development', 'back-end description', 'awaiting review', 12, 1),
            (13, 'PHP', 'PHP', 'php', 'php category', 'awaiting review', 100, 12),
            (14, 'Java', 'Java', 'java', 'Java description', 'awaiting review', 100, 12),
            (15, 'Ruby', 'Ruby', 'ruby', 'Ruby category', 'awaiting review', 100, 12),
            (16, 'Laravel', 'Laravel', 'laravel', 'laravel frameowrk category', 'awaiting review', 100, 13),
            (17, 'Symfony', 'Symfony', 'symfony', 'Symfony framework category', 'awaiting review', 100, 13),
            (18, 'Queued Jobs', 'Queued Jobs', 'queued-jobs', 'queued jobs category description', 'awaiting review', 100, 16),
            (19, 'Run queue worker', 'Run queue worker', 'run-queue-worker', 'running queue worker description', 'awaiting review', 100, 18);
        ");
    }
}

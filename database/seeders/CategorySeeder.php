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
            INSERT INTO `categories` (`title`, `title_meta`, `slug`, `description`, `status`, `priority`, `parent_category_id`) VALUES
            ('Uncategorized', 'Uncategorized', 'uncategorized', 'Uncategorized description', 'awaiting review', 1, NULL),
            ('Technology', 'Technology', 'technology', 'tech description', 'awaiting review', 1, NULL),
            ('Sports', 'Sports', 'sports', 'sports description (edited)', 'awaiting review', 2, NULL),
            ('Gaming', 'Gaming', 'gaming', 'gaming description', 'awaiting review', 4, NULL),
            ('Fashion', 'Fashion', 'fashion', 'fashion description', 'awaiting review', 5, NULL),
            ('Fitness', 'Fitness', 'fitness', 'fitness description', 'awaiting review', 3, NULL),
            ('Pet', 'Pet', 'pet', 'pet description', 'awaiting review', 6, NULL),
            ('Business', 'Business', 'business', 'business description', 'awaiting review', 7, NULL),
            ('DIY', 'DIY', 'diy', 'diy description', 'awaiting review', 10, NULL),
            ('Lifestyle', 'Lifestyle', 'lifestyle', 'lifestyle description', 'awaiting review', 9, NULL),
            ('Music', 'Music', 'music', 'music description', 'awaiting review', 8, NULL),
            ('Front-end development', 'Front-end development', 'front-end-development', 'front-end description', 'awaiting review', 11, 2),
            ('Back-end development', 'Back-end development', 'back-end-development', 'back-end description', 'awaiting review', 12, 2),
            ('PHP', 'PHP', 'php', 'php category', 'awaiting review', 100, 12),
            ('Java', 'Java', 'java', 'Java description', 'awaiting review', 100, 12),
            ('Ruby', 'Ruby', 'ruby', 'Ruby category', 'awaiting review', 100, 12),
            ('Laravel', 'Laravel', 'laravel', 'laravel frameowrk category', 'awaiting review', 100, 13),
            ('Symfony', 'Symfony', 'symfony', 'Symfony framework category', 'awaiting review', 100, 13),
            ('Queued Jobs', 'Queued Jobs', 'queued-jobs', 'queued jobs category description', 'awaiting review', 100, 16),
            ('Run queue worker', 'Run queue worker', 'run-queue-worker', 'running queue worker description', 'awaiting review', 100, 18);
        ");
    }
}

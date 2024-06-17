<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use Statamic\Entries\Entry;
class ImportMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movies:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from the csv file and create a Movies collection from it';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csvPath = storage_path('imports/tmdb_5000_movies.csv');
        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        foreach ($records as $record) {
             $genres = json_decode($record['genres'], true);

            Entry::make()
                ->collection('movies')
                ->slug($this->slugify($record['title']))
                ->data([
                    'title' => $record['title'],
                    'release_date' => $record['release_date'],
                    'overview' => $record['overview'],
                    'genres' => $genres,
                ])
                ->save();
        }

        $this->info('Movies imported successfully.');

        return 0;
    }

    /**
     * function to create the slug for the movie item from the given string
     * which in this case will be the title.
     */
    protected function slugify($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
}

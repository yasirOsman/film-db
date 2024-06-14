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
    protected $description = 'Command description';

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
            Entry::make()
                ->collection('movies')
                ->slug($this->slugify($record['title']))
                ->data([
                    'title' => $record['title'],
                    'release_date' => $record['release_date'],
                    'overview' => $record['overview'],
                    'genres' => $record['genres'],
                    // Add other fields as necessary
                ])
                ->save();
        }

        $this->info('Movies imported successfully.');

        return 0;
    }

    protected function slugify($string)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateAll extends Command
{
    protected $signature = 'db:truncate';
    protected $description = 'Truncate all tables';

    public function handle()
    {
        // For PostgreSQL, we need to use CASCADE or disable triggers
        // Option 1: Using CASCADE (recommended)
        try {
            DB::table('dividends')->truncate();
            DB::table('stocks')->truncate();
            DB::table('ipo')->truncate();
            DB::table('news')->truncate();
            DB::table('prices')->truncate();
            DB::table('actions')->truncate();
            DB::table('meetings')->truncate();
            DB::table('sessions')->truncate();
            
            $this->info('All tables truncated successfully!');
        } catch (\Exception $e) {
            // If foreign key constraints cause issues, use the alternative method
            $this->handleWithCascade();
        }
    }

    private function handleWithCascade()
    {
        // Option 2: Using raw SQL with CASCADE
        DB::statement('TRUNCATE TABLE dividends, stocks, ipo, news, prices, actions, meetings, sessions CASCADE;');
        $this->info('All tables truncated successfully with CASCADE!');
    }
}
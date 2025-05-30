<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\FetchProductsCommand;

class Kernel extends ConsoleKernel
{
    // ✅ Register your command here
    protected $commands = [
        FetchProductsCommand::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // You can schedule your command here (optional)
        // $schedule->command('fetch:products')->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

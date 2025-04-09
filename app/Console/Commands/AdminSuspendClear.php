<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Admin;

class AdminSuspendClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:suspend-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically lift expired suspensions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Admin::whereNotNull('suspended_until')
            ->where('suspended_until', '<=', Carbon::now())
            ->update([
                'suspended_until' => null,
            ]);
    }
}

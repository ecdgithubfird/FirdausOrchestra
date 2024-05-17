<?php

namespace Modules\Subscription\Console\Commands;

use Illuminate\Console\Command;

class SubscriptionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SubscriptionCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Command::SUCCESS;
    }
}

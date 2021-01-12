<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Authentication\User;
use App\Models\TransOrder;
use App\Notifications\NotifyExpireUser;
use App\Jobs\SendEmail;

class ExpireUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:expireuser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email Expire User';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Send Email');
        TransOrder::sendEmail();
    }
}

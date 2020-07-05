<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class SetRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles:set {userId} {roleId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


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
        $userId = $this->argument( 'userId' );
        $roleId   = $this->argument( 'roleId' );

        $user = User::where( 'id', $userId )->first();
        $user->attachRole( $roleId );
    }
}

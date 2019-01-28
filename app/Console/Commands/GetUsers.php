<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'help:user-generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data about users';

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
        $fields = ['id',
                   'first_name',
                   'last_name',
                   'count_of_products',
                   'salutation',
                   'country',
                   'city',
                   'address',
                   'created_at',
                   'updated_at'];

        $this->output->write($fields, true);
    }
}

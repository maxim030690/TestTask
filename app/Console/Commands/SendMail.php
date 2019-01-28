<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\Http\Controllers\Controller;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use App\Jobs\SendQueuesEmail;

class SendMail extends Command
{
    private $fields     = 'first_name,count_of_products';
    private $fileName;
    private $email;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report {email} {--fields=*} {--type=-1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generation of csv file';

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
        $this->email = filter_var($this->argument('email'), FILTER_VALIDATE_EMAIL);
        if($this->email){
            $fields = $this->option('fields')[0];
            $type = ($this->option('type')[0] != '') ? $this->option('type')[0] : -1;
            $fields = !empty($fields) ? explode(',', $fields) : explode(',',$this->fields);

            $this->fileName = 'report'.date("Y-m-d H:i:s").'.csv';

            try {
                Excel::store(new UsersExport($fields, $type), $this->fileName);
            }catch(\Exception $e){
                $this->output->write("Wrong columns!", true);
                die;
            }

            if(UsersExport::$numberRows > 300){
                SendQueuesEmail::dispatch($this->email, $this->fileName);
                $this->output->write("File will be sent soon", true);
            }else{
                $this->attachmentEmail();
            }

        }else{
            $this->output->write("Email not correct", true);
            die;
        }
    }

    /**
     * Send mail with attachment.
     *
     */
    public function attachmentEmail()
    {
        Mail::raw('Excel.csv', function ($message) {
            $message->to($this->email);
            $message->subject('Report data!');
            $message->attach(storage_path('app/'.$this->fileName));
        });
        $this->output->write("Email Sent with attachment. Check your inbox.", true);
        die;
    }
}

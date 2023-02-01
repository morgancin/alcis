<?php

namespace App\Http\Controllers;

//use App\Mail\ActivityEmail;
use App\Jobs\Logger;
use Illuminate\Http\Request;

class TestQueueEmails extends Controller
{
    /**
    * test email queues
    **/
    public function sendTestEmails()
    {
        $emailJobs = new Logger();
        $this->dispatch($emailJobs);
    }
}

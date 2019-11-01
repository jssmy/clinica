<?php

namespace App\Http\Controllers;

use App\Mail\automaticMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //

    public function send(){

        $toMail = "servidorlogico@gmail.com";
        Mail::to($toMail)->send(new automaticMail());

    }
}

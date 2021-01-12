<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TransOrder;
class ServiceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function send($tipe)
     {
       if ($tipe == 'all') {
             return TransOrder::sendEmail();
       }else{
            return TransOrder::sendSingleEmail($tipe);
       }
    }
}

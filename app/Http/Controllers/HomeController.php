<?php

namespace App\Http\Controllers;

use App\Constants\Supervisord\ProcessState;
use App\Services\Supervisord;
use Zend\Http\Client as HttpClient;
use Zend\XmlRpc\Client as XmlRpcClient;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return view('home');

//            $process = Supervisord::call(Supervisord::GET_ALL_CONFIG_INFO);
////
//            dd($process);
//
//            $logLength = filesize($process['stdout_logfile']);
//
//            dd(Supervisord::call(Supervisord::READ_PROCESS_STD_OUT_LOG, [
//                'name' => 'test',
//                'offset' => $logLength,
//                'length' => 9000000
//            ]));
//
            dd(Supervisord::call(Supervisord::GET_ALL_PROCESS_INFO));

            dd(Supervisord::call(Supervisord::SYSTEM_METHOD_HELP, [
                'name' => Supervisord::GET_ALL_PROCESS_INFO,
            ]));

        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }
    }
}

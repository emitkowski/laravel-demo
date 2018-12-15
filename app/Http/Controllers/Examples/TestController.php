<?php

namespace App\Http\Controllers\Examples;

use App\Services\Deliverable\TestService\Tester;
use App\Services\Support\SMS\EmailSMSHandler;
use Illuminate\Routing\Controller;

class TestController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard to the user.
     *
     */
    public function index()
    {
        er('Test Controller');
    }

    /**
     *  Test Text Service
     *
     * @param EmailSMSHandler $text
     */
    public function text(EmailSMSHandler $text)
    {
        er('Text Started');
        $result = $text->send('555555555', 'Verizon', 'Text to Me');
        pr($result);
        er('Text Sent');
    }

    public function log(Tester $tester)
    {
        er('Logging');
        $tester->run();
        er('Logging Done');
    }

}

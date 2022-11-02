<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lib\SendgridController;

class SendgridTest extends Controller {
   

    public function test(Request $request) {
        $sendgridController = new SendgridController();
        $sendgridController->test();
    }

}

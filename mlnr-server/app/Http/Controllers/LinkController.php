<?php

namespace App\Http\Controllers;

use App\Jobs\MailSender;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class LinkController extends BaseController
{
    public function sendMail()
    {
        dispatch(new MailSender('rvgabriel@yahoo.com', 'Valentin',
            'In qui laborum aute anim. Consequat anim aute laboris sit. Mollit qui incididunt consectetur deserunt ex ipsum aliquip sit anim irure tempor.',
            'http://google.com', '2018-10-01 23:00:00'));
        return response()->json(['status' => 'success']);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;
use Redirect;
use App\Encuestado;

use App\Http\Requests;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $encuestado = Encuestado::find(300);
        //dd($encuestado);
        $array[] = 
        Mail::send('encuesta.mail.encuestado', ['encuestado' => $encuestado], function($msj){
            $msj->subject('Encuesta de Clima 2020');
            $msj->to('marlopez04@hotmail.com');
        });

/*      //ejemplo de codigo

        $user = User::findOrFail($id);

        Mail::send('emails.reminder', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@app.com', 'Your Application');

            $m->to($user->email, $user->name)->subject('Your Reminder!');
        });

        //ejemplo de codigo

*/
    }
}

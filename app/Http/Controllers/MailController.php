<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Session;
use Redirect;
use App\Encuestado;
use App\Email;

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
        //$encuestado = Encuestado::find(309);
        //dd($encuestado);

        /*
        $mails = Email::all();

        foreach ($mails as $key => $mailencuestado) {
            # code...
        }
        //dd($mails);

        */

        $encuestado = new Encuestado();
        $encuestado->descripcion = " ";
        $encuestado->area_id = 0;
        $encuestado->rangoedad_id = 0;
        $encuestado->genero_id = 0;
        $encuestado->encuesta_id = 6;
        $encuestado->antiguedad_id = 0;
        $encuestado->sector_id = 0;
        $encuestado->puesto_id = 0;
        $encuestado->estudio_id = 0;
        $encuestado->sede_id = 0;
        $encuestado->contrato_id = 0;
        $encuestado->save();

        $direccion = "http://35.238.99.14/encuesta/encuestado/" . $encuestado->id . "/edit";

        //dd($direccion);

/*

        return view('encuesta.mail.encuestado')
            ->with('direccion',$direccion);

*/

        Mail::send('encuesta.mail.encuestado', ['direccion' => $direccion], function($msj){
            $msj->subject('Encuesta de Clima 2020');
            $msj->to('mlmorales@cofaral.com.ar');
            //$msj->to('abarreto@cofaral.com.ar');
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

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

        // status = 1 (ok para enviar)
        // status = 2 (ya enviado, se bloquea para el envio)
        
        $mails = Email::where('status', 1 )->get();
        //dd($mails);

        //recorro todos los mails, creando un "encuestado", armando el linck y enviando el mail
        foreach ($mails as $this->mail) {

            //dd($mails);

            //creo el encuestado vacio
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

            //dd($mailencuestado->mail);
            //dd($mailencuestado['mail']);
            //dd($this->mail->mail);

            //creo el linck para enviar por mail
            $direccion = "http://35.238.99.14/encuesta/encuestado/" . $encuestado->id . "/edit";

            //envio por mail el linck
            Mail::send('encuesta.mail.encuestado', ['direccion' => $direccion], function($msj){
                $msj->subject('Encuesta de Clima 2020');
                $msj->to($this->mail->mail);
            });

            //marco el mail como ya enviado status = 2

            $email = Email::find($mail->id);
            $email->status = 2;
            $email->save();


        }




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

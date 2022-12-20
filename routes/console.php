<?php

use App\Mail\sendMail;
use App\Models\demande;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('show:email', function () {

    $subday = Carbon::now()->subDays(2);
    $users = User::where('usertype', 1)->get();

    $demandes=demande::all()->where('updated_at' , '<', $subday)->where('status', 'En attente');
    foreach($demandes as $data){


        foreach($users as $user){

            $this->info("nom: $data->demande");
            Mail::to($user->email)->send(new sendMail($data)) ;

         }

        }



})->purpose("Mail de rappel à tous les administrateurs ");

Artisan::command('show:encours', function () {
    $subday = Carbon::now()->subDays(2);
    $users = User::where('usertype', 1)->get();
    $demandes=demande::all()->where('updated_at' , '<', $subday)->where('status', 'En cours de traitement');
    foreach($demandes as $data){
        foreach($users as $user){
            if($user->name==$data->nom_admin){
                $this->info("nom: $data->demande");
                Mail::to($user->email)->send(new sendMail($data)) ;

            }
        }
    }




})->purpose("");


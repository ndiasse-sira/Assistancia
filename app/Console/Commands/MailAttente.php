<?php

namespace App\Console\Commands;

use App\Mail\sendMail;
use App\Mail\sendMail1;
use App\Models\demande;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailAttente extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:attente';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'envoyer mail plus de 2jrs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subday = Carbon::now()->subDays(1);
        $users = User::where('usertype', 1)->get();

        $demandes=demande::all()->where('updated_at' , '<', $subday)->where('status', 'En attente ');
        foreach($demandes as $demande){

            foreach($users as $user){
               $this->info("nom: $demande->demande");
               Mail::to($user->email)->send(new sendMail($demande)) ;

            }

        }
    }
}

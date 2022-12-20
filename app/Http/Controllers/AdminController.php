<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\sendMail;
use App\Mail\sendMail1;
use App\Mail\SendMailRejet;
use App\Mail\SendMailTraité;
use App\Models\demande;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function home(){

        if(Auth::id()){
            return view('admin.home');
        } else {
            return redirect('login');
        }

    }

    public function details(){

        if(Auth::id()){
            $id=Auth::id();
            $users=user::all()->where('id',$id);
            foreach($users as $user){
                $nom=$user->name;
           }

            $demandes=demande::all()->where('nom_admin','' );
            $details = demande::all()->where('nom_admin',$nom );

            return view('admin.details',compact('details','demandes'));
        } else {
            return redirect('login');
        }

    }

    public function update($id){
       $data = demande::find($id);
        return view('admin.update', compact('data'));
    }

    public function modifier(Request $request, $id){
        $users=User::all()->where('usertype',0);
        $doto = demande::find($id);
        $id=Auth::id();
        $admins=user::all()->where('id',$id);
       foreach($admins as $admin){
           $email=$admin->email;
           $nom=$admin->name;
      }
      if($request->email==$email){
        $doto->nom_admin = $nom;

        $doto->status = $request->status;
        $doto->save();
      }
      else{
        return redirect()->back()->with('message-sent', "votre email ne correspond à l' administrateur connecté");
      }
       foreach($users as $user){
            while($user->id==$doto->user_id){
                if($doto->status=="Rejetée"){

                    Mail::to($user->email)->send(new SendMailRejet($doto));
                    return redirect()->back()->with('message-sent', 'Statut mis à jour');
                }
                else if($doto->status=="Traitée"){

                    Mail::to($user->email)->send(new SendMailTraité($doto));
                    return redirect()->back()->with('message-sent', 'Statut mis à jour');
                }
                else{
                    return redirect()->back()->with('message-sent', 'Statut mis à jour');
                }

            }

        }
    }


    public function bord(){
        $data= user::all()->where('usertype', 1);

        return view('admin.bord', compact('data'));

    }
    public function tableau(){

        $id=Auth::id();
        $users=user::all()->where('id',$id);
       foreach($users as $user){
           $nom=$user->name;
      }

        $attente=demande::all()->where('status','En attente')->count();
        $traite=demande::all()->where('status','Traitée')->where('nom_admin',$nom)->count();
        $rejet=demande::all()->where('status','Rejetée')->where('nom_admin',$nom)->count();
        $encours=demande::all()->where('status','En cours de traitement')->where('nom_admin',$nom)->count();
        return view('assistancia.tableau',compact('id','attente','rejet','traite','nom'));

    }
    public function detail(){
        $details = demande::all();
        return view('assistancia.detail',compact('details'));


    }

}

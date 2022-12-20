<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use App\Models\demande;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function home(){
        if(!empty(Auth::user()) && Auth::user()->usertype == 1)
        {
            return view('admin.home');
        }
        elseif(!empty(Auth::user()) && Auth::user()->usertype == 2){
            return view('assistancia.home');
        }
        else {
            return view('user.home');
        }
    }

    public function demande(){

        if(Auth::id()){
            return view('user.demande');
        } else {
            return redirect('login');
        }
    }

    public function envoi(Request $request){
        $data = new demande;
        $user = User::where('usertype', 1)->get();

        $data->user_id = Auth::id();

        $data->demande = $request->demande;
        $data->save();

        foreach($user as $users){
            Mail::to($users->email)->send(new sendMail($data));
        }

        return redirect()->back()->with('message-sent', 'Envoyé avec succés');
    }

    public function status(){

        $id = Auth::id();
        $data = demande::where('user_id', $id)->get();
        return view('user.status', compact('data'));
    }
}

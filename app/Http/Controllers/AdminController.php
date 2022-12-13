<?php

namespace App\Http\Controllers;

use App\Mail\sendMail;
use App\Mail\sendMail1;
use App\Models\demande;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
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
            $details = demande::all();

            return view('admin.details',compact('details'));
        } else {
            return redirect('login');
        }

    }

    public function update($id){
        $data = demande::find($id);
        return view('admin.update', compact('data'));
    }

    public function modifier(Request $request, $id){
        $doto = demande::find($id);
        $doto->nom_admin = $request->nom_admin;
        $doto->status = $request->status;
        $doto->save();

        Mail::to('ndiasse.mbeguere@univ-thies.sn')->send(new sendMail1($doto));
        return redirect()->back()->with('message-sent', 'Statut mis à jour');
    }
}

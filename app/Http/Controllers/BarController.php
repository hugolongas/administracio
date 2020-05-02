<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Notification;
use Validator;
use Redirect;

class BarController extends Controller
{
    public function password()
    {
        return 'password';
    }

    public function Index(Request $request)
    {
        if ($request->session()->exists('projects')) {       
            return view('bar.projects');
        }
        return view('bar.loginProjects');
    }


    public function AccesProjects(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }
        $password = $request->input('password');
        if($password=="nEyBJAbyK9")
        {
            $request->session()->put('projects', 'logged');
            return view('bar.projects');
        }
        $errors = [$this->password() => trans('auth.worngpassword')];
        return redirect()->back()
        ->withErrors($errors);
    }

    public function VotationPage()
    {
        return view('bar.votePage');
    }

    public function AdminVotationPage()
    {
        return view('bar.adminVotePage');
    }

    public function AdminGestionPage()
    {
        return view('bar.adminGestionPage');
    }
}

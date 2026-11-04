<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ControladorPrincipal extends Controller
{
    public function mostrar(): View
    {
         $usuario = Auth::user();
         
        return view('principal');
    }
}

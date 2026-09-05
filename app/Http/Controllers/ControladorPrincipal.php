<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ControladorPrincipal extends Controller
{
    public function mostrar(): View
    {
        return view('principal');
    }
}

<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function (): void {
    $this->comment('backendTemplate');
})->purpose('Mostrar el nombre de la plantilla');

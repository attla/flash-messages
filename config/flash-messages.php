<?php

return [

    // flash types class names, alert-*
    'types' => [
        'alert'     => 'danger',
        'critical'  => 'danger',
        'debug'     => 'light',
        'emergency' => 'warning',
        'error'     => 'danger',
        'info'      => 'info',
        'notice'    => 'secondary',
        'ok'        => 'success',
        'success'   => 'success',
        'warning'   => 'warning',
    ],

    // flash message icon, this can be an html element
    // or just a class that willbe placed inside an <i></i> element
    'icons' => [
        'alert'     => '',
        'critical'  => '',
        'debug'     => '',
        'emergency' => '',
        'error'     => '',
        'info'      => '',
        'notice'    => '',
        'ok'        => '',
        'success'   => '',
        'warning'   => '',
    ],

];

// o factore cria a message, cria um id interno, salva o id interno e o tipo na propria message e retorna a message
//  dai na message tera os methodos de add classe e icon e tals
// ao chamar um metodo auxiliar do message
// é acionado um evento que salva no session a message
// seria interessante também ter um metodo para deletar a message que seguiria o mesmo fluxo

// Flash::info('test');
// Flash::ok('test');
// Flash::alert('test')->icon('fa fa-info')->timeout(3);
// Flash::alert('test')->dismissible();

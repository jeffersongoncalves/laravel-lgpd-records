<?php

return [

    'table' => 'lgpd_processing_activities',

    /*
     * The controller (controlador), as it appears in the records of processing (art. 37).
     */
    'controller' => [
        'name' => env('LGPD_CONTROLLER_NAME', env('APP_NAME')),
        'document' => env('LGPD_CONTROLLER_DOCUMENT'), // CNPJ / CPF
        'contact' => env('LGPD_CONTROLLER_CONTACT'),
    ],

    /*
     * The data protection officer (encarregado). Their identity and contact must be
     * public, clearly and objectively, preferably on your website (art. 41, §1).
     */
    'dpo' => [
        'name' => env('LGPD_DPO_NAME'),
        'email' => env('LGPD_DPO_EMAIL'),
        'phone' => env('LGPD_DPO_PHONE'),
    ],

];

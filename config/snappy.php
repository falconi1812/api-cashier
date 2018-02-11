<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => 'vendor/pngquant/bin/wkhtmltopdf',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => 'vendor/pngquant/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);

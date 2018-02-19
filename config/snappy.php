<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => '~/bin/wkhtmltopdf',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '~/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);

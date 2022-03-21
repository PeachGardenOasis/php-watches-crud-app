<?php

$config =[
    'MODEL_PATH' => APPLICATION_PATH . DS . 'model' . DS, // making model path key
    'VIEW_PATH' => APPLICATION_PATH . DS . 'view' . DS,
    'LIB_PATH' => APPLICATION_PATH . DS . 'lib' . DS,
    'DATA_PATH' => APPLICATION_PATH . DS . 'data' . DS,
    'DATABASE_PATH' => APPLICATION_PATH . DS . 'data' . DS . 'database' . DS,
];

require $config['LIB_PATH'] . 'functions.php';
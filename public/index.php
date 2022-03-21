<?php


const DS = DIRECTORY_SEPARATOR;
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)) . DS . '..' . DS . 'app'); // const variable used to access app folder

#echo realpath(dirname(__FILE__) . DS . '..' . DS . 'app');


// dot used to concatonate
require APPLICATION_PATH . DS . 'config' . DS . 'config.php';
require $config['DATABASE_PATH'] . DS . 'database.php';

//index.php?page=home
$page = get('page', 'home');
$model = $config['MODEL_PATH'] . $page . '.php';
$view = $config['VIEW_PATH'] . $page . '.phtml';
$_404 = $config['VIEW_PATH'] . '404.phtml';


include $config['VIEW_PATH'] . 'tb_layout.phtml';

if (file_exists($model)) {
    require $model;
}

$main_content = $_404;

if (file_exists($view)) {
    $main_content = $view;
}

require $main_content;


<?php

$config = include_once 'config.php';
if(empty($config))
{
    header('location: install.php');
    exit;
}
session_start();
include_once 'functions.php';
if(!empty($_POST['username']) && !empty($_POST['password']) && $config['username'] == $_POST['username'] && $config['password'] == $_POST['password'])
{
    $_SESSION['__isLogain__'] = true; 
    header('location: index.php');
    exit;
}
elseif(!empty($_GET['do']))
{
    switch($_GET['do'])
    {
        case 'logout':
            unset($_SESSION['__isLogain__']);
            header('location: index.php');
            exit;
            break;
        case 'upload':
            include 'editor.php';
            savePhoto();
            break;
        case 'share':
            if(!empty($_GET['path'])) $_GET['path'] = str_replace ("_-_", "/", $_GET['path']);
            if(empty($_GET['path']) || !file_exists('__temp/'.$_GET['path'])) 
            {
                header('location: index.php');
                exit;
            }
            $config['metaImage'] = sitePath('__temp/'.$_GET['path']);
            break;
    }
}
$isLogin = !empty($_SESSION['__isLogain__']);
define("isAdmin", $isLogin);
define("demoMode", $_SERVER['HTTP_HOST'] == 'demos.codesgit.com');
function showDemoMode()
{
    ?>
    <div class="alert alert-danger">
        <i class="fa fa-remove"></i>
        You can't add/edit/change anything in demo mode !
    </div>
    <?php
}

include_once 'templates/index.php';
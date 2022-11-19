<?php
session_start();
//import config & connerctDb
require '../config.php';
require '../connectDB.php';
//require autoload(lib)
require '../vendor/autoload.php';
//import models
require '../bootstrap.php';

//điều hướng đến controller cụ thể dựa vào tham số
$c = $_GET['c'] ?? 'home';
$a = $_GET['a'] ?? 'index';
$controller = ucfirst($c) . 'Controller'; //studentcontroller
//import controller vào hệ thống
require "controller/$controller.php";
$controller = new $controller();
$controller->$a();
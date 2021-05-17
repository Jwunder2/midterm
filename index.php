<?php

//This is my controller for the diner project

//Turn on error-reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require neccassary files
require_once ('vendor/autoload.php');
require_once ('model/data-layer.php');
require_once ('model/validation.php');
//Instantiate Fat-Free
$f3 = Base::instance();

//Define default route
$f3->route('GET /', function(){

    //Display the home page
    $view = new Template();
    echo $view->render('views/survey.html');
});


$f3->route('GET|POST /midterm1', function($f3){

    $_SESSION = array();

    $userName = "";
    $userTerms = array();


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //var_dump($_POST);
        //Data validation will go here

        $userName = $_POST['inputName'];

        if(validName($_POST['inputName'])) {
            $_SESSION['inputName'] = $userName;
        }
        //Otherwise, set an error variable in the hive
        else {
            $f3->set('errors["inputName"]', 'Please enter a Name');
        }

        if (!empty($_POST['terms'])) {

            //Get user input
            $userTerms = $_POST['terms'];

            //If condiments are valid
            if (validTerms($userTerms)) {
                $_SESSION['terms'] = implode(", ", $userTerms);
            } else {
                $f3->set('errors["terms"]', 'Invalid selection');
            }

            if (empty($f3->get('errors'))) {
                header('location: summary');
            }
        }
    }

    $f3->set('midterms', getMidTerm());
    $f3->set('userName', $userName);
    $f3->set('userTerms', $userTerms);


    //Display the breakfast page
    $view = new Template();
    echo $view->render('views/midterm1.html');
});

$f3->route('GET /summary', function(){

    //Display the home page
    $view = new Template();
    echo $view->render('views/summary.html');
});


//Run Fat-Free
$f3->run();
<?php

session_start();

require_once("controller/UserController.php");

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/");
define("IMAGES_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "imageUploads/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "loginForm" => function () {
        if(User::isLoggedIn()){
            ViewHelper::redirect(BASE_URL . "feed"); 
        }
        else{
            UserController::showLoginForm();
        }
    },
    "login" => function () {
        if(User::isLoggedIn()){
            ViewHelper::redirect(BASE_URL . "feed"); 
        }
        else{
            UserController::loginUser();
        }
    },
    "registerForm" => function () {
        if(User::isLoggedIn()){
            ViewHelper::redirect(BASE_URL . "feed"); 
        }
        else{
            UserController::showRegisterForm();
        }
    },
    "register" => function () {
        if(User::isLoggedIn()){
            ViewHelper::redirect(BASE_URL . "feed"); 
        }
        else{
            UserController::registerUser();
        }
    },
    "searchPage" => function () {
        UserController::loadSearchPage();
    },
    "search" => function () {
        UserController::searchUsers();
    },
    "logout" => function () {
        UserController::logoutUser();
    },
    "personal" => function () {
        UserController::toPersonalPage();
    },
    "personal/edit" => function () {
        if(User::isLoggedIn()){
            UserController::editPersonalPage();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "confirmEdit" => function () {
        if(User::isLoggedIn()){
            UserController::editConfirm();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "addFriend" => function () {
        if(User::isLoggedIn() && isset($_GET["id"])){
            UserController::sendRequest();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "acceptRequest" => function () {
        if(User::isLoggedIn() && isset($_GET["id"])){
            UserController::acceptRequest();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "deleteRequest" => function () {
        if(User::isLoggedIn() && isset($_GET["id"])){
            UserController::cancelRequest();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "removeFriend" => function () {
        if(User::isLoggedIn() && isset($_GET["id"])){
            UserController::removeFriend();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "friends" => function () {
        if(User::isLoggedIn()){
            UserController::showFriends();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "postAction" => function () {
        if(User::isLoggedIn()){
            PostController::addPost();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "feed" => function () {
        PostController::postFeed();
    },
    "post/delete" => function () {
        if(User::isLoggedIn() && isset($_GET["id"])){
            PostController::deletePost();
        }
        else{
            ViewHelper::redirect(BASE_URL . "feed");
        }
    },
    "" => function () {
        if(User::isLoggedIn()){
            ViewHelper::redirect(BASE_URL . "feed"); 
        }
        else{
            ViewHelper::redirect(BASE_URL . "loginForm");
        }
    },
];

try {
    if (isset($urls[$path])) {
       $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    ViewHelper::error404();
} 

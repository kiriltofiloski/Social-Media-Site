<?php

require_once("model/UserDB.php");
require_once("model/User.php");
require_once("ViewHelper.php");
require_once("PostController.php");

class UserController {

    public static function showLoginForm () {
        ViewHelper::render("view/login.php", ["formAction" => "login"]);
    }

    public static function loginUser() {
        $rules = [
            "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS]
        ];

        $data = filter_input_array(INPUT_POST, $rules);
        $user = null;
        if(!empty($data["username"]) ){
            $user = UserDB::getUser($data["username"]);
        }

        $errorMessage =  empty($data["username"]) || empty($data["password"]) || $user == null 
        || !UserDB::checkLogin($data["username"], $data["password"]) ? "Invalid username or password." : "";

        if (empty($errorMessage)) {
            User::login($user["userID"]);
            UserController::loadPersonalPage($_SESSION["user"],"");
        } else {
            ViewHelper::render("view/login.php", [
                "errorMessage" => $errorMessage,
                "formAction" => "login"
            ]);
        }
    }

    public static function showRegisterForm() {
        ViewHelper::render("view/register.php", ["formAction" => "register"]);
    }

    public static function registerUser() {
        $rules = [
            "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "fName" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "lName" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "gender" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $user = null;
        if(!empty($data["username"])){
            $user = UserDB::getUser($data["username"]); 
        }

        $errorMessage =  empty($data["username"]) || empty($data["password"]) ||
        empty($data["fName"]) || empty($data["lName"]) ||
        empty($data["gender"]) ? "Please fill in all fields." : "";

        if(empty($errorMessage)){
            $errorMessage = $user != null ? "That username is already taken." : "";
        }

        //hash password
        $password = null;
        if(!empty($data["password"])){
            $password = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        if (empty($errorMessage)) {
            UserDB::addUser($data["username"],$password,$data["fName"],$data["lName"],$data["gender"]);
            $user = UserDB::getUser($data["username"]);
            User::login($user["userID"]);
            ViewHelper::render("view/registerSuccess.php", ["firstName" => $data["fName"]]);
        } else {
            ViewHelper::render("view/register.php", [
                "errorMessage" => $errorMessage,
                "formAction" => "register"
            ]);
        }
    }

    public static function loadSearchPage() {
        ViewHelper::render("view/searchUsers.php", []);
    }

    public static function searchUsers() {
        if (isset($_GET["query"]) && !empty($_GET["query"])) {
            $query = htmlspecialchars($_GET["query"]);
            $hits = UserDB::searchUsers($query);
        } else {
            $hits = [];
        }

        header('Content-type: application/json; charset=utf-8');
        echo json_encode($hits);
    }

    public static function logoutUser() {
        User::logout();
        ViewHelper::render("view/login.php", ["formAction" => "login"]);
    }

    public static function toPersonalPage() {
        if (isset($_GET["id"]) && !empty($_GET["id"])) {
            $id = htmlspecialchars($_GET["id"]);
            UserController::loadPersonalPage($id,"");
        } else {
            ViewHelper::error404();
        }
    }

    public static function loadPersonalPage($userID, $errors) {
        $userInfo = UserDB::getUserInfo($userID);
        if(User::isLoggedIn()){
            if ($_SESSION["user"] == $userInfo["userID"]){
                $isYourPage = true;
                $formAction = "";
                $formText = "";
            }
            else {
                $isYourPage = false;
    
                if(in_array($userInfo["userID"], UserDB::getFriends($_SESSION["user"]))){
                    $formAction = "removeFriend?id=" . $userInfo["userID"];
                    $formText = "Remove from friends";
                }
                else{
                    $youToHim = UserDB::checkIfRequestedFriend($_SESSION["user"], $userInfo["userID"]);
                    $himToYou = UserDB::checkIfRequestFromFriend($_SESSION["user"], $userInfo["userID"]);
    
                    if($youToHim != null){
                        $formAction = "deleteRequest?id=" . $userInfo["userID"];
                        $formText = "Cancel request";
                    }
                    else if($himToYou != null){
                        $formAction = "acceptRequest?id=" . $userInfo["userID"];
                        $formText = "Accept";
                    }
                    else{
                        $formAction = "addFriend?id=" . $userInfo["userID"];
                        $formText = "Add friend";
                    }
                }
            }
        }
        else{
            $isYourPage = false;
            $formAction = "";
            $formText = "";
        }
        $userInfo = UserDB::getUserInfo($userID);
        $posts = PostController::personalPosts($userID);
        ViewHelper::render("view/persPage.php", [
            "user" => $userInfo,
            "isYourPage" => $isYourPage,
            "formAction" => $formAction,
            "formText" => $formText,
            "posts" => $posts,
            "errorMessage" => $errors
        ]);
    }

    public static function editPersonalPage() {
        $userInfo = UserDB::getUserInfo($_SESSION["user"]);
        ViewHelper::render("view/editPersonal.php", [
            "user" => $userInfo,
            "formAction" => "confirmEdit"
        ]);
    }

    public static function editConfirm() {
        $rules = [
            "username" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "password" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "fName" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "lName" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "gender" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "color1" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "color2" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $user = null;
        if(!empty($data["username"])){
            $user = UserDB::getUser($data["username"]);
        }

        $errorMessage = empty($data["fName"]) || empty($data["lName"]) ||
        empty($data["gender"]) ? "Please fill in all fields." : "";

        $themes = null;
        if(!empty($data["color1"]) && !empty($data["color2"])){
            $themesArr = array($data["color1"], $data["color2"]);
            $themes = implode(",", $themesArr);
        }

        if (empty($errorMessage)) {
            UserDB::editUserInfo($_SESSION["user"],$data["fName"],$data["lName"],$data["gender"], $themes);
            UserController::loadPersonalPage($_SESSION["user"],"");
        } else {
            $userInfo = UserDB::getUserInfo($_SESSION["user"]);
            ViewHelper::render("view/editPersonal.php", [
                "user" => $userInfo,
                "formAction" => "confirmEdit",
                "errorMessage" => $errorMessage
            ]);
        }
    }

    public static function sendRequest() {
        $id = htmlspecialchars($_GET["id"]);
        UserDB::requestFriend($_SESSION["user"], $id);

        ViewHelper::redirect(BASE_URL . "personal?id=" . $id);
    }

    public static function acceptRequest() {
        $id = htmlspecialchars($_GET["id"]);
        UserDB::addFriend($_SESSION["user"], $id);

        $temp = UserDB::checkIfRequestFromFriend($_SESSION["user"], $id);
        $requestID = $temp[0]["requestID"];
        UserDB::deleteRequest($requestID);

        ViewHelper::redirect(BASE_URL . "personal?id=" . $id);
    }

    public static function cancelRequest() {
        $id = htmlspecialchars($_GET["id"]);
        $temp = UserDB::checkIfRequestedFriend($_SESSION["user"], $id);
        $requestID = $temp[0]["requestID"];
        UserDB::deleteRequest($requestID);

        ViewHelper::redirect(BASE_URL . "personal?id=" . $id);
    }

    public static function removeFriend() {
        $id = htmlspecialchars($_GET["id"]);
        UserDB::removeFriend($_SESSION["user"], $id);

        ViewHelper::redirect(BASE_URL . "personal?id=" . $id);
    }

    public static function showFriends() {

        $friends = UserDB::getFriends($_SESSION["user"]);
        $requests = UserDB::getUserRequests($_SESSION["user"]);

        ViewHelper::render("view/friends.php", [
            "friends" => $friends,
            "requests" => $requests
        ]);
    }

}
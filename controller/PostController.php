<?php

require_once("model/UserDB.php");
require_once("model/User.php");
require_once("ViewHelper.php");
require_once("UserController.php");

class PostController {

    public static function addPost() {
        $rules = [
            "title" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "contentType" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "postStatus" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
            "myText" => ["filter" => FILTER_SANITIZE_SPECIAL_CHARS],
        ];

        $data = filter_input_array(INPUT_POST, $rules);

        $errorMessage =  empty($data["title"]) || empty($data["contentType"]) ||
        empty($data["postStatus"]) ? "Please fill in all fields." : "";

        if(empty($errorMessage)){
            if( $data["contentType"] == "text"){
                $errorMessage = empty($data["myText"]) ? "Please fill in all fields." : "";
            }
            else{
                $errorMessage = $_FILES["myImage"] == null ? "Please upload an image" : "";
            }
        }

        if(empty($errorMessage)){
            if( $data["contentType"] == "text"){
                UserDB::addPost($_SESSION["user"],$data["title"],$data["myText"],$data["postStatus"],$data["contentType"]);
                UserController::loadPersonalPage($_SESSION["user"],"");
            }
            else{
                $valid = true;
                $uploadName = 'imageUploads/' . basename($_FILES["myImage"]["name"]);
                $imageFileType = strtolower(pathinfo($uploadName,PATHINFO_EXTENSION));
                //check if valid image was uploaded
                $check = getimagesize($_FILES["myImage"]["tmp_name"]);
                if($check !== false) {
                    $valid = true;
                } else {
                    $errorMessage = "File is not an image.";
                    $valid = false;
                }
                //limit size
                if ($_FILES["myImage"]["size"] > 3000000) {
                    $errorMessage = "Sorry, your image is too large.";
                    $valid = false;
                }
    
                if($imageFileType != "png" && $imageFileType != "jpeg" ) {
                    $errorMessage = "Only JPEG and PNG images are accepted.";
                    $valid = false;
                }
    
                if($valid == false){
                    UserController::loadPersonalPage($_SESSION["user"],$errorMessage);
                }
                else{
                    $name = self::getImageNum();
                    $target_file = 'imageUploads/' . $name;
                    move_uploaded_file($_FILES["myImage"]["tmp_name"], $target_file);
                    UserDB::addPost($_SESSION["user"],$data["title"],$name,$data["postStatus"],$data["contentType"]);
                    UserController::loadPersonalPage($_SESSION["user"],"");
                }
            }
        }
        else{
            UserController::loadPersonalPage($_SESSION["user"],$errorMessage); 
        }
    }

    public static function getImageNum(){

        $images = UserDB::getAllImages();
        while (true) {
            $imageNum = rand();
            if($images == null || !in_array($imageNum, $images)){
                return $imageNum;
            }
        }
    }

    public static function isFriend($userID, $friendID){
        $friends = UserDB::getFriends($userID);
        if(in_array($friendID,$friends)){
            return true;
        }
        else{
            return false;
        }
    }

    public static function personalPosts($userID) {

        //if getting own posts or is friends
        if(User::isLoggedIn() && ( $userID == $_SESSION["user"] || self::isFriend($_SESSION["user"],$userID) )){
            $temp1 = UserDB::getUserPosts($userID, "private");
            $temp2 = UserDB::getUserPosts($userID, "public");
            if($temp1 == null){
                $temp1 = [];
            }
            if($temp2 == null){
                $temp2 = [];
            }
            $posts = array_merge($temp1,$temp2);
            
        }
        //if not friends get only public posts
        else{
            $posts = UserDB::getUserPosts($userID, "public");
            if($posts == null){
                $posts = [];
            }
        }

        shuffle($posts);
        return $posts;
    }

    public static function postFeed() {

        if(User::isLoggedIn()){
            $friends = UserDB::getFriends($_SESSION["user"]);
            $posts = UserDB::getPublicPosts();
            if($posts == null){
                $posts = [];
            }
            foreach($friends as $friend){
                $temp = UserDB::getUserPosts($friend, "private");
                if($temp == null){
                    $temp = [];
                }
                $posts = array_merge($posts,$temp);
            }
        }
        else{
            $posts = UserDB::getPublicPosts();
            if($posts == null){
                $posts = [];
            }
        }

        shuffle($posts);
        ViewHelper::render("view/newsFeed.php", [
            "posts" => $posts
        ]);
    }

    public static function includeHeader($post){
        include("view/post.php");
    }

    public static function deletePost(){
        $toDelete = htmlspecialchars($_GET["id"]);

        UserDB::deletePost($toDelete);
        UserController::loadPersonalPage($_SESSION["user"],"");
    }
}
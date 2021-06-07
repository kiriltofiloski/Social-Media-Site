<?php

require_once "DBInit.php";

class UserDB {

    public static function getUser($username) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT userID, username, pass FROM usertable 
            WHERE username = :username");
        $statement->bindParam(":username", $username);
        $statement->execute();

        $user = $statement->fetch();

        return $user;
    }

    //needed for post
    public static function getUsername($userID) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT username FROM usertable 
            WHERE userID = :user");
        $statement->bindParam(":user", $userID);
        $statement->execute();

        $user = $statement->fetch();

        return $user;
    }

    public static function checkLogin($username, $password) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT pass FROM usertable 
            WHERE username = :username");
        $statement->bindParam(":username", $username);
        $statement->execute();

        $pass = $statement->fetch();

        return password_verify($password, $pass["pass"]);
    }

    public static function getUserInfo($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT userID, username, firstName, lastName, gender, theme FROM userinfo 
            WHERE userID = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $userInfo = $statement->fetch();

        if ($userInfo != null) {
            return $userInfo;
        } else {
            throw new InvalidArgumentException("No record with id $id");
        }
    }

    public static function getFriends($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT friends FROM userinfo 
            WHERE userID = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();

        $friendsStr = $statement->fetch();

        $friendsStr = $friendsStr["friends"];

        if ($friendsStr == null) {
            throw new InvalidArgumentException("No record with id $id");
        }

        $friends = explode(",",$friendsStr);

        return $friends;
    }

    public static function getUserPosts($id, $postStatus) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT postID, userID, title, content, postType FROM posts 
            WHERE userID = :id AND postStatus = :postStatus");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->bindParam(":postStatus", $postStatus);
        $statement->execute();

        $userPosts = $statement->fetchAll();

        return $userPosts;
    }

    public static function getPublicPosts() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT postID, userID, title, content, postType FROM posts 
            WHERE postStatus = 'Public'");
        $statement->execute();

        $publicPosts = $statement->fetchAll();

        return $publicPosts;
    }

    public static function getAllImages() {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT content FROM posts 
            WHERE postType = 'img'");
        $statement->execute();

        $images = $statement->fetch();

        return $images;
    }

    public static function addUser($username, $pass, $firstName, $lastName, $gender) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO usertable (username, pass)
            VALUES (:username, :pass)");
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->bindParam(":pass", $pass, PDO::PARAM_STR);    
        $statement->execute();

        $statement = $db->prepare("INSERT INTO userinfo (firstName, username, lastName, gender, theme, friends)
        VALUES (:firstName, :username, :lastName, :gender, '#435581,#637DBB', 'blank')");
        $statement->bindParam(":firstName", $firstName, PDO::PARAM_STR);
        $statement->bindParam(":username", $username, PDO::PARAM_STR);
        $statement->bindParam(":lastName", $lastName, PDO::PARAM_STR);
        $statement->bindParam(":gender", $gender, PDO::PARAM_STR);     
        $statement->execute();
    }

    public static function editUserInfo($userID ,$firstName, $lastName, $gender, $theme) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("UPDATE userinfo SET firstName = :firstName,
            lastName = :lastName, gender = :gender, theme = :theme WHERE userID = :id");
        $statement->bindParam(":firstName", $firstName);
        $statement->bindParam(":lastName", $lastName);
        $statement->bindParam(":gender", $gender);
        $statement->bindParam(":theme", $theme);
        $statement->bindParam(":id", $userID, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function addFriend($userID , $friendID) {
        $db = DBInit::getInstance();

        // set for first user
        $friends = UserDB::getFriends($userID);
        array_push($friends, $friendID);
        $newFriends = implode(",", $friends);

        $statement = $db->prepare("UPDATE userinfo SET friends = :friends WHERE userID = :id");
        $statement->bindParam(":friends", $newFriends);
        $statement->bindParam(":id", $userID, PDO::PARAM_INT);
        $statement->execute();

        // set for second user
        $friends = UserDB::getFriends($friendID);
        array_push($friends, $userID);
        $newFriends = implode(",", $friends);

        $statement = $db->prepare("UPDATE userinfo SET friends = :friends WHERE userID = :id");
        $statement->bindParam(":friends", $newFriends);
        $statement->bindParam(":id", $friendID, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function removeFriend($userID , $friendID) {
        $db = DBInit::getInstance();

        //set for first user
        $friends = UserDB::getFriends($userID);
        if (($key = array_search($friendID, $friends)) !== false) {
            unset($friends[$key]);
        }
        $newFriends = implode(",", $friends);

        $statement = $db->prepare("UPDATE userinfo SET friends = :friends WHERE userID = :id");
        $statement->bindParam(":friends", $newFriends);
        $statement->bindParam(":id", $userID, PDO::PARAM_INT);
        $statement->execute();

        //set for second user
        $friends = UserDB::getFriends($friendID);
        if (($key = array_search($userID, $friends)) !== false) {
            unset($friends[$key]);
        }
        $newFriends = implode(",", $friends);
    
        $statement = $db->prepare("UPDATE userinfo SET friends = :friends WHERE userID = :id");
        $statement->bindParam(":friends", $newFriends);
        $statement->bindParam(":id", $friendID, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function addPost($userID, $title, $content, $postStatus, $postType) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO posts (userID, title, content, postStatus, postType)
            VALUES (:userID, :title, :content, :postStatus, :postType)");
        $statement->bindParam(":userID", $userID, PDO::PARAM_INT);
        $statement->bindParam(":title", $title); 
        $statement->bindParam(":content", $content);
        $statement->bindParam(":postStatus", $postStatus); 
        $statement->bindParam(":postType", $postType); 
        $statement->execute();
    }

    public static function deletePost($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM posts WHERE postID = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }    

    public static function searchUsers($query) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT userID, username, firstName, lastName, gender FROM userinfo 
            WHERE firstName LIKE :query OR lastName LIKE :query OR username LIKE :query");
        $statement->bindValue(":query", '%' . $query . '%');
        $statement->execute();

        return $statement->fetchAll();
    }
    
    public static function requestFriend($userID, $friendID) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("INSERT INTO requests (toUser, fromUser)
            VALUES (:toUser, :fromUser)");
        $statement->bindParam(":toUser", $friendID, PDO::PARAM_INT);
        $statement->bindParam(":fromUser", $userID, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function deleteRequest($requestID) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("DELETE FROM requests WHERE requestID = :id");
        $statement->bindParam(":id", $requestID, PDO::PARAM_INT);
        $statement->execute();
    }

    public static function getUserRequests($userID) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT requestID, toUser, fromUser FROM requests 
            WHERE toUser = :id");
        $statement->bindParam(":id", $userID, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function checkIfRequestFromFriend($userID, $friendID) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT requestID, toUser, fromUser FROM requests 
            WHERE toUser = :id AND fromUser = :friendId");
        $statement->bindParam(":id", $userID, PDO::PARAM_INT);
        $statement->bindParam(":friendId", $friendID, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public static function checkIfRequestedFriend($userID, $friendID) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("SELECT requestID, toUser, fromUser FROM requests 
            WHERE toUser = :friendId AND fromUser = :id");
        $statement->bindParam(":id", $userID, PDO::PARAM_INT);
        $statement->bindParam(":friendId", $friendID, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
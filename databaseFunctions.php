<?php
include_once ("databaseCon.php");
class databaseFunction {
private $db;

public function __construct(){
  $this->db = new databaseCon();
  $this->db = $this->db->connect();
}

public function getUser($Username, $Password) {
  $records = $this->db->prepare('SELECT UserId,username,password  FROM  tbl_users  WHERE username = :username AND  password = :password');
  $records->bindParam(':username', $Username);
  $records->bindParam(':password', $Password);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);
  if($results != false){
    $response["user"]["username"] = $results["username"];
    $_SESSION['username'] = $results["username"];
    $_SESSION['UserId'] = $results["UserId"];
    $response["user"]["UserId"] = $results["UserId"];
    return $response;
  } else {
    // user not found
    // echo json with error = 1
    $response["error"] = "ERROR";
    $response["error_msg"] = "Incorrect email or password!";
    return $response;
    }
  }

      //Check user is existed or not
public function isUserExisted($Username, $Password) {
  $records = $this->db->prepare('SELECT UserId,username,password  FROM  tbl_users  WHERE username = :username AND  password = :password');
  $records->bindParam(':username', $Username);
  $records->bindParam(':password', $Password);
  $records->execute();
  return $records;
}

public function storeUser($Username, $Password) {
  $hash = $this->hashSSHA($Password);
     $encrypted_password = $hash["encrypted"]; // encrypted password
     $salt = $hash["salt"]; // salt
     $queryconnect = $this->db->prepare("INSERT INTO tbl_users( username, password) VALUES ('$Username','$Password')");
       $queryresult = $queryconnect->execute();
     echo json_encode($queryresult);
    return $queryresult;
   }

 public function hashSSHA($Password) {
    $salt = sha1(rand());
    $salt = substr($salt, 0, 10);
    $encrypted = base64_encode(sha1($Password . $salt, true) . $salt);
    $hash = array("salt" => $salt, "encrypted" => $encrypted);
    return $hash;
}



public function getactivity($userid) {
  $records = $this->db->prepare('SELECT UserId, ActivityID, Activity FROM  tbl_activityplanner  WHERE userid = :UserId');
  $records->bindParam(':UserId', $userid);
  $records->execute();
  return $records;
}
}

 ?>

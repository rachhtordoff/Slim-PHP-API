<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '/vendor/autoload.php';
include ("databaseFunctions.php");

$app = new \Slim\App;


/* LOGIN STUFF */
$app->post('/register', function() use ($app) {
$dbF = new databaseFunction();
  $Username = $_POST['username'];
  $Password = $_POST['password'];
  $records = $dbF->isUserExisted($Username, $Password);
  if($records->fetch(PDO::FETCH_ASSOC) > 0){
  echo "already exists";
  echo '{"query_result":"FAILED"}';
       }
  /* No rows matched -- do something else */
else {
    echo "No rows matched the query.";
    $user = $dbF->storeUser($Username,$Password);

      if($user == true){

      echo '{"query_result":"SUCCESS"}';
      }
      elseif($user == false){

        echo '{"query_result":"FAILED"}';
      }
      else{
    echo json_encode($user);

      }


         }


});

$app->post('/login', function() use ($app) {
$dbF = new databaseFunction();
$errMsg = '';
//username and password sent from Form
$username = trim($_POST['username']);
$password = trim($_POST['password']);

if($username == ''){
$errMsg = 'You must enter your Username';
echo json_encode($errMsg);
}
elseif($password == ''){
$errMsg = 'You must enter your Password';
echo json_encode($errMsg);
}
if($errMsg == ''){

$records = $dbF->getUser($username, $password);
echo json_encode($records);


    }

});


/* ACTIVITY STUFF */


$app->post('/getactivity', function() use ($app) {
$dbF = new databaseFunction();
$errMsg = '';
//username and password sent from Form
$userid = trim($_POST['userid']);

if($userid == ''){
$errMsg = 'You are not logged in';
echo json_encode($errMsg);
}

if($errMsg == ''){
  $getactivity = $dbF->getactivity($userid);
  echo json_encode($getactivity);

}
});

$app->post('/addactivity', function() use ($app) {
$dbF = new databaseFunction();
$errMsg = '';

$userid = trim($_POST['userid']);
$activity= trim($_POST['Activity']);

if($userid == ''){
$errMsg = 'You are not logged in';
echo json_encode($errMsg);
}
elseif($activity == ''){
$errMsg = 'You must enter an activity';
echo json_encode($errMsg);
}
if($errMsg == ''){
  $addactivity = $dbF->addactivity($userid, $activity);
  echo json_encode($addactivity);
}
});

$app->run();

 ?>

<?php

 class databaseCon {
     // Connecting to database
     public function connect() {
         require_once ("config.inc.php");
         try
         {
         $databaseConnection = new PDO('mysql:host='._HOST_NAME_.';dbname='._DATABASE_NAME_, _USER_NAME_);
         $databaseConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         // return database handler
         return $databaseConnection;

       }
       catch (PDOException $e)
       {
           print "Error: " . $e->getMessage(). "<br/>";
           die();
       }
     }


 }

?>

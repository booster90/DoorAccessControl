Door Access Control & Log System

Program write in php, use avery simple MySQL database.

SETUP
--------------------------------------------------------------------------------
Just copy to server with php interpreter and www server.
I use a nginx and fpm-php, and works well.
Database configuration in file config.php.

INSTALL
--------------------------------------------------------------------------------
Import file with database dump to mysql server and just copy all source files 
to catalogue in server and open path to this in a browser. 

configuration in file config.php: 

$host = "localhost";
$database = "doorAccessControl";
$user = "doorAccessContro";
$password = "blabla123#";

USE
--------------------------------------------------------------------------------
is very simple we have menu with 4 options
 
*) home - here we enter our pin number. If we don't have any - go to Register

*) register - when we enter name and surname, we get on top info with our data 
              and generated pin number 

*) panel - here is list of late comers/ early leavers users this system (
           according to assumption work starts 9am and finish 5.30pm) 

*) list - list of working time of all register users (last 30)
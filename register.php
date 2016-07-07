<!DOCTYPE html>
<!--
Door access control & Log system.
By Krystian Mikołajczyk
-->

<?php
include_once 'database.class.php';
include_once 'user.class.php';

$db = new database($host, $user, $password, $database);
$user = new User();

//reaction on send submit registration data
if (isset($_GET['name']) && isset($_GET['surname']) && $_GET['name'] != '' && $_GET['surname'] != '') {
    $newUser = $user->register($_GET['name'], $_GET['surname'], $db);
    echo "<div class='alert alert-success'><strong>You are register now!<br></strong>Hello $newUser->name!<br> yours new pin number is <strong>$newUser->pin</strong> </div>";
} elseif (isset($_GET['name']) || isset($_GET['surname'])) {
    echo "<div class='alert alert-warning'><strong>Warning!<br></strong>To register enter name and surname.</div>";
}
?>

<html lang="en">
    <head>
        <title>Door Access Control & Log System</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </head>
    <body>

        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Door Access Control & Log System</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="panel.php">Panel</a></li>
                    <li><a href="list.php">List</a></li>
                </ul>
            </div>
        </nav>

        <div class="container">
            <h1>Door Access Control & Log System</h1>
            <p>Register new system user.</p>

            <form role="form" action="register.php" method="get">
                <div class="form-group">
                    <label for="pin">Name:</label>
                    <input type="text" name="name" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="pin">Surname:</label>
                    <input type="text" name="surname" class="form-control" id="surname">
                </div>

                <button class="btn btn-primary btn-block" type="submit" value="submit">Register</button>
            </form>
        </div>
    </body>
</html>
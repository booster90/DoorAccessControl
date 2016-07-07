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

if (isset($_GET['pin'])) {

    //sanitize(already do in method)..
    $isSave = $db->getLastInputPinFromUser($_GET['pin']);

    //show user what system doing
    if ($isSave['isSavePin']) {
        /*         * *
          echo '<pre>';
          var_dump($isSave);
          echo '</pre>';
         */
        if ($isSave['isCome'])
            echo "<div class='alert alert-success'><strong>Log in!<br></strong>Hello.</div>";
        else
            echo "<div class='alert alert-success'><strong>Log out!<br></strong>Bye.</div>";
    } else {
        echo "<div class='alert alert-warning'><strong>Warning!<br></strong>That pin number is not exist. Try again or register.</div>";
    }
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
            <p>Enter pin code.</p>

            <form role="form" action="index.php" method="get">
                <div class="form-group">
                    <label for="pin">Pin:</label>
                    <input type="number" name="pin" class="form-control" id="pin">
                </div>
                <button class="btn btn-primary btn-block" type="submit" value="submit">Submit</button>
            </form>
        </div>

        <?php
        //if send GET request
        //var_dump( $dupa->isPinExist(4329) );
        //$dupa->setUser('andaaarzej', 'testowy', 4331);
        //var_dump($user->generatePin($db));
        $name = "marta";
        $surname = "antczak";
        /*
          $newUserData = $user->register($name, $surname, $db);

          echo $newUserData->name;
          echo $newUserData->surname;
          echo $newUserData->pin;
         */

        //var_dump($db->getLastInputPinFromUser(420));
        //$db->saveUserComingOutComing(1234, 0);
        ?>

    </body>
</html>

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include_once 'config.php';

class database extends mysqli {

    private $host;
    private $database;
    private $user;
    private $password;

    public function __construct($host, $user, $password, $database) {
        $this->host = $host;
        $this->database = $database;
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Save data of user in database.
     * 
     * @param type $name
     * @param type $surname
     * @param type $pin
     * @return boolean
     */
    function setUser($name, $surname, $pin) {

        $db = new mysqli($this->host, $this->user, $this->password, $this->database);
        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        //satanize, but repare sql is not nesesary
        $name = $db->real_escape_string(htmlentities($name));
        $surname = $db->real_escape_string(htmlentities($surname));

        if ($stmt = $db->prepare("INSERT INTO User (name, surname, pin) VALUES (?, ?,?)")) {
            $stmt->bind_param("ssi", $name, $surname, $pin);

            $stmt->execute();

            if ($stmt->affected_rows != 1)
                return false;
            else
                return true;

            $stmt->close();
        }
        $db->close();
    }

    function getUser($pin) {

        $db = new mysqli($this->host, $this->user, $this->password, $this->database);
        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        if ($stmt = $db->prepare("SELECT id, name, surname, pin FROM User WHERE pin=?")) {
            $stmt->bind_param("i", $pin);
            $stmt->execute();

            $stmt->store_result();
            $num_of_rows = $stmt->num_rows;
            $stmt->bind_result($id, $name, $surname, $pin);

            while ($stmt->fetch()) {
                echo 'ID: ' . $id . '<br>';
                echo 'First Name: ' . $name . '<br>';
                echo 'Last Name: ' . $surname . '<br>';
                echo 'pin: ' . $pin . '<br><br>';
            }
            $stmt->close();
        }
        $db->close();
    }

    /**
     * Check is pin number exist in database
     * 
     * @param type $pin
     * @return boolean
     */
    function isPinExist($pin) {

        $db = new mysqli($this->host, $this->user, $this->password, $this->database);
        /* check connection */
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }


        if ($stmt = $db->prepare("SELECT id FROM User WHERE pin=?")) {
            $stmt->bind_param("i", $pin);
            $stmt->execute();

            $stmt->store_result();
            $num_of_rows = $stmt->num_rows;
            if ($num_of_rows != 1)
                return false;
            else
                return true;

            $stmt->close();
        }
        $db->close();
    }

    /**
     * Saving any write pin number by user, and check is he come/leave
     * 
     * @param type $pin
     * @return boolean
     */
    function getLastInputPinFromUser($pin) {
        //first, get last saved record input from user SELECT * FROM time WHERE pin=$pin DESC
        //$pin=NULL;
        $time = NULL;
        $coming = NULL;
        if ($this->isPinExist($pin)) {

            $db = new mysqli($this->host, $this->user, $this->password, $this->database);
            //conection
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }

            //SANITIZE DATA FORM POST OR GET!!!!!!!!!
            $pin = $db->real_escape_string(htmlentities($pin));

            if ($stmt = $db->prepare("SELECT time, coming FROM time WHERE pin=? ORDER BY time DESC LIMIT 1")) {
                $stmt->bind_param("i", $pin);
                $stmt->execute();

                $stmt->store_result();
                $num_of_rows = $stmt->num_rows;
                $stmt->bind_result($time, $coming);

                while ($stmt->fetch()) {
                    /* echo 'pin: ' . $pin . '<br>';
                      echo 'time: ' . $time . '<br>';
                      echo 'coming: ' . $coming . '<br>'; */
                }
                $stmt->close();
            }
            $db->close();

            //  later we check user come in or exit 
            //  time.coming=1 is mean user come to work
            //  time.coming=0 is mean user exit from work
            if ($coming == TRUE) {
                //INPUT PIN FROM USER
                $isSave = $this->saveUserComingOutComing($pin, 0);

                return ['isSavePin' => true, 'isCome' => false];
            } else {
                //INPUT PIN 
                $isSave = $this->saveUserComingOutComing($pin, 1);

                return ['isSavePin' => true, 'isCome' => true];
            }
        } else {
            //there is no that PIN NUMBER IN DATABASE
            return ['isSavePin' => false, 'isCome' => false];
        }
    }

    /**
     * Saving in database info about user come(every input pin)
     * 
     * @param type $pin
     * @param type $isComing
     * @return boolean
     */
    function saveUserComingOutComing($pin, $isComing) {
        $db = new mysqli($this->host, $this->user, $this->password, $this->database);
        //conection
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        if ($stmt = $db->prepare("INSERT INTO time (pin, coming) VALUES (?,?)")) {
            $stmt->bind_param("ii", $pin, $isComing);
            $stmt->execute();

            if ($stmt->affected_rows != 1)
                return false;
            else
                return true;

            $stmt->close();
        }
        $db->close();
    }

    function whoIsLate() {

        //preapre arrays for data..
        $lateComers = array();
        $earlyLeavers = array();

        $arrayOfShame = array();

        $db = new mysqli($this->host, $this->user, $this->password, $this->database);
        //conection
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        //..
        $sql = "SELECT User.name, User.surname, time.pin, time.time, time.coming FROM `User` JOIN `time` ON User.pin = time.pin";
        if ($stmt = $db->prepare($sql)) {//"SELECT pin, time, coming FROM time ORDER BY time DESC")){ 
            $stmt->execute();

            $stmt->store_result();
            $num_of_rows = $stmt->num_rows;
            $stmt->bind_result($name, $surname, $pin, $time, $coming);

            while ($stmt->fetch()) {
                //echo 'pin: ' . $pin . '<br>';
                //echo 'time: ' . $time . ' ====> '. date("H:i:s", strtotime($time)).'<br>';
                // check if user coming to work late.. 
                $timeOfCome = date("H:i:s", strtotime($time));
                if (($timeOfCome > date("H:i:s", strtotime("09:00:59"))) && $coming == TRUE) {
                    //echo 'You are late!!<br>';
                    //make a array
                    $lateComers = [
                        "name" => $name,
                        "surname" => $surname,
                        "note" => "you are late",
                        "pin" => $pin,
                        "time" => $timeOfCome,
                        "date" => date("d-m-Y", strtotime($time))
                    ];

                    array_push($arrayOfShame, $lateComers);
                }

                //check who leave work early..
                if ((date("H:i:s", strtotime($time)) < date("H:i:s", strtotime("17:30:00"))) && $coming == FALSE) {
                    //echo 'You are leave from work early!!<br>';
                    $earlyLeavers = [
                        "name" => $name,
                        "surname" => $surname,
                        "note" => "you are leave early",
                        "pin" => $pin,
                        "time" => $timeOfCome,
                        "date" => date("d-m-Y", strtotime($time))
                    ];
                    array_push($arrayOfShame, $earlyLeavers);
                }
                //echo 'coming: ' . $coming . '<br><br>';
            }
            $stmt->close();
        }
        $db->close();

        return $arrayOfShame;
    }

    function listWorkingTime() {

        //preapre arrays for data..
        $workingTime = array();
        $comeWork = null;
        $leavework = null;
        $userPin = null;

        $timeTA = array();

        $db = new mysqli($this->host, $this->user, $this->password, $this->database);
        //conection
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        //..
        $sql = "SELECT User.name, User.surname, time.pin, time.time, time.coming FROM `User` JOIN `time` ON User.pin = time.pin";
        if ($stmt = $db->prepare($sql)) {//"SELECT pin, time, coming FROM time ORDER BY time DESC")){ 
            $stmt->execute();

            $stmt->store_result();
            $num_of_rows = $stmt->num_rows;
            $stmt->bind_result($name, $surname, $pin, $time, $coming);

            while ($stmt->fetch()) {

                //make array with user PIN and date -> we see how ofen coming and
                //leave in this day
                //if user come to work
                if ($coming == true) {
                    $dateT = date("d-m-Y", strtotime($time));
                    $timeT = date("H:i:s", strtotime($time));
                    $nameT = $name;
                    $pinT = $pin;

                    //$timeTA[]=$time;
                    //$timeTA=["come"=>$time];

                    $come = $time;
                }

                if ($dateT == date("d-m-Y", strtotime($time)) && $pinT == $pin && $coming == false) {
                    $out = $time;

                    $timeTA = ['come' => $come,
                        'out' => $out,
                        'name' => $name];
                    
                    //add 
                    array_push($workingTime, $timeTA);

                //if somebody finish next day..
                } elseif($pinT == $pin && $coming == false) {
          
                    $out = $time;

                    $timeTA = ['come' => $come,
                        'out' => $out,
                        'name' => $name];
                    
                    array_push($workingTime, $timeTA);
                }

                /*if ($coming == TRUE) {
                    $comeWork = new DateTime($time);
                    $nowDate = date("d-m-Y", strtotime($time));
                    $userPin = $pin;
                }

                if ($coming == FALSE && $nowDate == date("d-m-Y", strtotime($time)) && $userPin == $pin) {
                    $leavework = new DateTime($time);
                }

                if ($comeWork != NULL && $leavework != NULL && $nowDate == date("d-m-Y", strtotime($time)) && $userPin == $pin) {
                    $difference = $comeWork->diff($leavework);
                    //echo "$difference->h : $difference->i : $difference->s  <br>";

                    $arrayWorkTime = [
                        "UserName" => $name,
                        "WorkTime" => $difference->h . ':' . $difference->i . ':' . $difference->s,
                        "Date" => $nowDate
                    ];

                    $comeWork = null;
                    $leavework = null;*/
                
            }
            //var_dump($workingTime);

        }
        $stmt->close();
        $db->close();

        return $workingTime;
    }

}

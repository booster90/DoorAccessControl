<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User{
    public $name;
    public $surname;
    public $pin;
    
    /**
     * Method make a new User to system
     * 
     * @param type $name
     * @param type $surname
     * @return boolean
     */
    function register($name, $surname, $db){    
        //generate pin for user
        $pin = $this->generatePin($db);
        
        $this->name=$name;
        $this->surname=$surname;
        $this->pin=$pin;
        
        //save in database new user
        if($db->setUser($name, $surname, $pin))
            return $this;
        else 
            return false;
    }
    
    /**
     * Generates uniqe pin 
     * 
     * @param type $db
     * @return type
     */
    function generatePin($db){
        $pin = mt_rand(1000, 9999);
        
        if($db->isPinExist($pin)){
           $this->generatePin($db);
        } else
            return $pin;    
    }
    
    /**
     * Check on database is user with this pin number is coming or go to home
     * 
     * @param type $pin
     * @return boolean
     */
    function checkIsLoggedInSystem($pin) {
        
        if($isLoggedInSystem)
            return true;
        else
            return false;
    }
   
}
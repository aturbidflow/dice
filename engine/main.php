<?php

    include_once('system.php');
    include_once('users.php');
    include_once('dices.php');

class ErrorGen {
    
    public static $lastError;
    
    public static function ThrowMe($title,$message){
        ErrorGen::$lastError = new Error($title,$message);
        return ErrorGen::$lastError;
    }
    
    public static function LastError(){
        if (!empty(ErrorGen::$lastError)){
            ErrorGen::$lastError->Show();
        }
    }
    
}

class Error {
    
    private $title;
    private $message;
    
    public function __construct($title,$message){
        $this->title = $title;
        $this->message = $message;
    }
    
    public function Show(){
        echo '<h1 class="error-title">'.$this->title.'</h1>';
        echo '<p class="error">'.$this->message.'</p>';
    }
    
}

?>

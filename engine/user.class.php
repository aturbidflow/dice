<?php

class User {
    private $login = '';   
    private $dices = array();
        
    
    public function __construct($login){
        $this->login = $login;
        $this->LoadDices();
    }
    
    public function ID(){
        return Users::GetID($this->login);
    }
    
    public function getLogin(){
        return $this->login;
    }
    
    public function Login(){
        echo $this->getLogin();
    }
    
    public function IsAdmin(){
        return false;
    }
    
    public function Role(){
        echo 'unknown';
    }
    
    public function SetPassword($pwd){
        Users::SetPassword($this->login,$pwd);
    }

    public function Assign(&$dice){
        $dice->setOwner($this);
        $this->dices[] = $dice;        
    }
    
    public function LoadDices(){
        $dices = Dices::LoadDices(Users::GetID($this->login));
        foreach ($dices as $dice){
            $this->Assign($dice);
        }
    }
    
    public function ListOfDices(){
        if (!empty($this->dices)){
            return $this->dices;
        } else {
            return array();
        }
    }
}

class Player extends User {
    
    public function Role(){
        echo 'player';
    }
}

class Admin extends User {
    
    public function IsAdmin(){
        return true;
    }
    
    public function Role(){
        echo 'admin';
    }
    
    public function SetPassword($pwd,$login=''){
        if (empty($login)){
            Users::SetPassword($this->getLogin(),$pwd);
        } else {
            Users::SetPassword($login,$pwd);
        }
    }
}

?>

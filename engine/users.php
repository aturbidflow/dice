<?php
class Users {
    
    public static function CurrentIsAdmin(){
        $user = Users::getCurrentUser();
        
        return $user->IsAdmin();
    }
    
    public static function getCurrentID(){
        return Users::GetID(Users::getCurrentUser());
    }
    
    public static function getCurrentUser(){
        return Users::LoadUser();
    }
    
    public static function GetUsers(){
        $q = new Query('select `id` from `users`');
        $ids = $q->GetRows('int');
        
        $users = array();
        foreach ($ids as $id){
            $users[] = Users::LoadUser($id[0]);
        }
        
        return $users;
    }
    
    public static function LoadUser($id = ''){
        if (empty($id)){
            $login = $_COOKIE['diceuser'];

            $q = new Query('select `role` from `users` where `login`="'.$login.'"');

            $role = $q->Get();

        } else {
            $q = new Query('select `login`,`role` from `users` where `id`='.$id);
            
            $role = $q->Get('role');
            $login = $q->Get('login');                      
        }
        
        switch ($role){
            case 'admin':
                $user = new Admin($login);
            break;
            case 'player':
            default:
                $user = new Player($login);
            break;
        }
        
        return $user;
    }

    
    public static function ForceCheckUserAuth(){
        if (!Users::CheckUserAuth()){
            System::Redirect('/login.php');
        }
    }
    
    public static function ForceCheckUserAdmin(){
        Users::ForceCheckUserAuth();
        
        $user = Users::LoadUser();
        
        if (!$user->IsAdmin()) System::Redirect('/');
    }
    
    public static function CheckUserAuth(){
        if (!empty($_COOKIE['diceauth'])&&!empty($_COOKIE['diceuser'])){
            if (Users::Exists($_COOKIE['diceuser']))
                return true;
            else {
                Users::LogOut();
                return false;
            }
        } else {
            return false;
        }
    }

    public static function VerificateUserAuth($login,$pass){
        if (Users::Exists($login)){
            $q = new Query('select `pwd` from `users` where `login`="'.$login.'"');
            if ($q->is()){
                $pwd = $q->Get();
                $sole = Users::GetSole($login);
                if (Users::HashPWD($pass,$sole) == $pwd) return false;
                else return ErrorGen::ThrowMe('Wrong password','');
            } else {
                return ErrorGen::ThrowMe('No user','Sorry, no such user exists.');
            }
        } else {
            return ErrorGen::ThrowMe('Wrong creditinals','You might be wrong in typing.');
        }
    }
    
    public static function GetSole($login){
        $q = new Query('select `sole` from `users` where `login`="'.$login.'"');
        return $q->Get();
    }
    
    public static function SetAuth($login){
        setcookie('diceauth',md5($login));
        setcookie('diceuser',$login);
    }
    
    public static function LogOut(){
        setcookie('diceauth','');
        setcookie('diceuser','');
    }
    
    public static function Exists($login){
        $q = new Query('select `login` from `users` where `login`="'.$login.'"');
        return $q->HaveData();
    }
    
    public static function SetPassword($login,$pwd){
        if (Users::Exists($login)){
            $q = new Query('update `users` set `pwd`="'.Users::HashPWD($pwd,Users::GetSole($login)).'" where `login`="'.$login.'"');
        } else {
            ErrorGen::ThrowMe('Password change error', 'Can`t change password');
        }
    }
    
    public static function CreateUser($login,$pass,$role = 'player'){
        $sole = Users::GenerateSole();
        $q = new Query('insert into `users` (`id`,`login`,`pwd`,`sole`,`role`) values (NULL,"'.$login.'","'.Users::HashPWD($pass,$sole).'","'.$sole.'","'.$role.'");');
        if (Users::Exists($login)) return true;
        else ErrorGen::ThrowMe('Error','Can`t create user "'.$login.'"');
    }
    
    public static function Install(){
        $q = new Query('CREATE TABLE  `users` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,`login` VARCHAR( 32 ) NOT NULL ,`pwd` VARCHAR( 32 ) NOT NULL ,`sole` VARCHAR( 32 ) NOT NULL,`role` ENUM(  "player",  "admin" ) NOT NULL);');
    }
    
    public static function Installed(){
        $q = new Query('select `id` from `users`');
        return $q->is();
    }
    
    public static function GenerateSole(){
        return md5(rand(0,10000));
    }
    
    public static function HashPWD($pass,$sole=''){
        return md5($pass.$sole);
    }
    
    public static function FormListOf(){
        $q = new Query('select `id`,`login` from `users`');
        if ($q->is()){
            $users = $q->GetRows('str');
            foreach ($users as $user){
                echo '<option value="'.$user['id'].'">'.$user['login'].'</option>';
            }
        }
    }
    
    public static function ListOf(){
        $q = new Query('select `id`,`login` from `users`');
        if ($q->is()){
            $users = $q->GetRows('str');
            foreach ($users as $user){
                echo '<a href="userinfo.php?id='.$user['id'].'">'.$user['login'].'</a>, ';
            }
        }
    }
    
    public static function GetID($login){
        if (is_object($login)){
            $login = $login->getLogin();
        }
        if (is_numeric($login)) return $login;
        $q = new Query('select `id` from `users` where `login`="'.$login.'"');
        return $q->Get();
    }
    
    public static function GetLogin($id){
        if(is_numeric($id)){
            $q = new Query('select `login` from `users` where `id`='.$id);
            return $q->Get();
        } elseif (is_object($id)) {
            return $id->login();
        } else return $id;
    }

}?>

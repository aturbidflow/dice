<?php
    include('../config.php');

    Users::ForceCheckUserAdmin();
    
    $user = Users::LoadUser();
    
    $return = '/';
    
    if (!empty($_GET)){
        $did = $_GET['id'];
        if (!empty($_GET['return'])) $return = $_GET['return'];
        
        $dice = Dices::LoadDice($did);
        
        $dice->Suicide($user);
    }
    
    System::Redirect($return);
    
?>

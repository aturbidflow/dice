<?php
    include('../config.php');

    Users::ForceCheckUserAdmin();
    
    $user = Users::LoadUser();
    $known = Users::LoadUser($_GET['id']);

    Template::Run('adminuserinfo','User info: '.$known->getLogin());
    
    Template::Header();
    
    Template::Widget('userPanel');

    Template::Widget('diceswidget',$known);
    
    Template::Footer(); ?>
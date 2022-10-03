<?php
    include('config.php');

    Users::ForceCheckUserAuth();
    
    $user = Users::LoadUser();
    

    if ($user->IsAdmin())
        System::Redirect('/admin/');
    else
        System::Redirect('/dicepanel.php');
?>
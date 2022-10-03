<?php
    include('../config.php');

    Users::ForceCheckUserAdmin();
    
    $user = Users::LoadUser();

    Template::Run('admin','Admin panel');
    
    Template::Header();
    
    Template::Widget('userPanel');
?>    
    <div id="users-list">
        Профиль пользователя: <?php Users::ListOf(); ?>
    </div>
<?php 
Template::Widget('DicesWidget');
Template::Widget('WaitingDices');
Template::Footer(); ?>
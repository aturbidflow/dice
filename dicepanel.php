<?php
    include('config.php');
    
    Users::ForceCheckUserAuth();
       
    Template::Run('dicepanel','Dice panel');

    Template::Header();
    
    Template::Widget('userPanel');
    
    Template::Widget('DicesWidget');
    
    Template::Footer(); ?>
<?php
    include('config.php');

    if (!empty($_POST)){
        if (isset($_POST['action'])){
            if ($_POST['action']=='selfroll'){
                if (!empty($_POST['userby'])){
                    $owner = $_POST['userby'];
                } else {
                    $owner = Users::GetCurrentID();
                }

                $x = $_POST['x'];
                $count = $_POST['count'];
                $comment = $_POST['comment'];
                $did = Dices::Create($x,$count,$owner,$comment);
            }
        }
        
        
        
        if (empty($did)) $did = $_POST['dice-id'];
        $return = $_POST['return'];
        
        $dice = Dices::LoadDice($did);
               
        if (empty($_POST['userby'])) $dice->Roll();
        
        System::Redirect($return);
    } else {
        System::Redirect('/');
    }
?>

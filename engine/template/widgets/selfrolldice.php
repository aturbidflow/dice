<?php

include_once('square.php');

class SelfRollDice extends Square {

    function Widget($data=array()){ 
        $user = Users::LoadUser();
        if (!empty($data)){
            $userby = $data['user'];
            if ($user->ID()==$userby->ID())
                unset($userby);
        }
        $data['id'] = 'selfrolldice';
        $data['desc'] = 'Новый бросок';
        $data['button'] = true;
        if (isset($userby))
            $data['link'] = '/selfroll.php?by='.$userby->ID().'&return='.System::currentLocation();
        else
            $data['link'] = '/selfroll.php';
        parent::Widget($data);
    }
    
}
<?php

include_once('square.php');

class ClosedDice extends Square {

    function Widget($data=array()){ 
        if (!empty($data['dice'])){
            $dice = $data['dice'];
            $owner = Users::LoadUser($dice->Owner());
            $data['id'] = $owner->getlogin().'-dice-'.$dice->id().'-by-'.Users::GetLogin($dice->ApprovedBy());
            $data['desc'] = $dice->comment();
            $data['sign'] = $dice->time().'<br/> подтверждено: '.Users::GetLogin($dice->ApprovedBy());
            $data['title'] = $dice->result();
            $data['subtitle'] = $dice->getType();
            $data['classes'][] = 'square-dice-'.$dice->x().'-closed';
            $data['classes'][] = 'square-rolleddice';
            $data['classes'][] = 'square-closeddice';
            parent::Widget($data);
        }
    }

    function aTitle(){
        $user = Users::LoadUser();
        $dice = $this->Dice();
        if ($user->IsAdmin()): ?>       
            <h1 class="square-title"><a class="delete-link" href="/admin/delete.php?id=<?php echo $dice->ID(); ?>&return=<?php echo System::currentLocation(); ?>" title="Удалить"><img src="/images/delete-w.png" alt="X"/></a>            
            <?php echo $dice->result(); ?></h1><?php
        else: ?>
            <h1 class="square-title"><?php echo $dice->result(); ?></h1>
        <?php endif;
    }
    
}
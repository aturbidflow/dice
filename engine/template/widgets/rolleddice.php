<?php

include_once('square.php');

class RolledDice extends Square {

    function Widget($data=array()){ 
        if (!empty($data['dice'])){
            $dice = $data['dice'];
            $owner = Users::LoadUser($dice->Owner());
            $data['id'] = $owner->getlogin().'-dice-'.$dice->id();
            $data['desc'] = $dice->comment();
            $data['sign'] = $dice->time().'<br/> ожидает подтверждения';
            $data['title'] = $dice->result();
            $data['subtitle'] = $dice->getType();
            $data['classes'][] = 'square-dice-'.$dice->x().'-rolled';
            $data['classes'][] = 'square-rolleddice';
            parent::Widget($data);
        }
    }
 
    function Title(){
        $user = Users::LoadUser();
        $dice = $this->Dice();
        $owner = Users::LoadUser($dice->Owner());
        if ($user->IsAdmin()): ?>       
<h1 class="square-title"><a class="delete-link" href="/admin/delete.php?id=<?php echo $dice->ID(); ?>&return=<?php echo System::currentLocation(); ?>" data-user="<?php $owner->Login(); ?>" title="Удалить"><img src="/images/delete.png" alt="X"/></a>
            <a class="approve-link" href="/admin/approve.php?id=<?php echo $dice->ID(); ?>&return=<?php echo System::currentLocation(); ?>" data-user="<?php $owner->Login(); ?>" title="Подтвердить"><img src="/images/approve.png" alt="V"/></a>
            <?php echo $dice->result(); ?>
            <a class="decline-link" href="/admin/decline.php?id=<?php echo $dice->ID(); ?>&return=<?php echo System::currentLocation(); ?>" data-user="<?php $owner->Login(); ?>" title="Отклонить"><img src="/images/decline.png" alt="X"/></a></h1>
        <?php else: ?>
            <h1 class="square-title"><?php echo $dice->result(); ?></h1>
        <?php endif;
    }
}
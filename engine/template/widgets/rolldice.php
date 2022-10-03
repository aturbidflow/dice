<?php

include_once('square.php');

class RollDice extends Square {

    function Widget($data=array()){ 
        if (!empty($data['dice'])){
            $dice = $data['dice'];
            $owner = Users::LoadUser($dice->Owner());
            $data['id'] = $owner->getlogin().'-dice-'.$dice->id();
            $data['desc'] = $dice->Comment();
            $data['title'] = $dice->getType();
            $data['classes'][] = 'square-dice-'.$dice->x();
            $data['classes'][] = 'square-rolldice';
            $data['sign'] = 'Бросить';
            $data['button'] = true;
            parent::Init($data);
        } ?>
<div <?php $this->ID(); ?> <?php $this->getClasses(); ?>>
                <form class="rolldice-form" action="/rolldice.php" method="post">
                    <input type="hidden" name="return" value="<?php echo System::currentLocation(); ?>" />
                    <?php $this->Desc(); $this->Title(); $this->Sign(); ?>
                    <input type="hidden" name="dice-id" value="<?php echo $dice->ID(); ?>" />
                    <input type="submit" value="Бросить" />
                </form>    
</div>
<?php
    }

    function Title(){
        $user = Users::LoadUser();
        $dice = $this->Dice();
        if ($user->IsAdmin()): ?>       
            <a class="delete-link" href="/admin/delete.php?id=<?php echo $dice->ID(); ?>&return=<?php echo System::currentLocation(); ?>" title="Удалить"><img src="/images/delete-w.png" alt="X"/></a>
            <h1 class="square-title"><?php echo $dice->getType(); ?>
            </h1>
        <?php else: ?>
            <h1 class="square-title"><?php echo $dice->result(); ?></h1>
        <?php endif;
    }

}
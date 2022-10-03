<?php

class DicesWidget extends Widget {

    function Widget($user=''){ 
        if (empty($user)) $user = Users::LoadUser();
        if (!is_object($user)) $user = Users::LoadUser($user);
        
        ?>
        <div id="dices-panel">
            <h2>Броски <?php $user->Login(); ?></h2>
            <?php $dices = $user->ListOfDices(); 
                if ($user->ID()==Users::getCurrentID())
                    Template::Widget('selfrolldice');
                else
                    Template::Widget('selfrolldice',array('user'=>$user));
                foreach($dices as $dice){
                    Dices::DiceBlock($dice);
                }
            ?>
        </div>
<?php    }
    
}
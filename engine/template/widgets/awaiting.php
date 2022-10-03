<?php

class Awaiting extends Widget {

    function Widget($data=''){ 
        ?>
<h2>Ожидающие подтверждения</h2>
            <?php
            
                    $users = Users::GetUsers();
            
                    foreach ($users as $user){
                        $dices = Dices::GetAwaiting($user->ID());
                        
                        if (!empty($dices)){
                            echo '<h3 class="await-title">'.$user->GetLogin().'</h3>';
                        
                            foreach ($dices as $dice){
                                Dices::DiceBlock($dice);
                            }
                        }
                    }
            ?>
<?php    }
    
}
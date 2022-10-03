<?php
    include('../../config.php');

    Users::ForceCheckUserAdmin();
    
    $user = Users::LoadUser();

    Template::Run('admin','Admin panel');
    
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

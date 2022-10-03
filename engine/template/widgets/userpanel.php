<?php

class UserPanel extends Widget {

    function Widget($data=''){ 
        $user = Users::LoadUser();
        ?>
        <div id="user-panel">
            <div id="logo"><a href="/">Dicegen</a></div>
            <div id="user-info">Вы вошли как <?php $user->Login(); ?>
                <div id="user-controls">
                    <a href="/logout.php">Выход</a> | <?php if (Template::PageName()!='changepass'): ?>
                        <a href="/changepassword.php">Сменить пароль</a>
                    <?php else: ?>
                        <a href="/">На главную</a>
                    <?php endif;                 ?>
                </div>                
            </div>
            <?php if ($user->isAdmin()): ?>
                        <div id="actions-panel">
                            <a href="/admin/createdice.php">Назначить бросок</a> | <a href="/admin/createuser.php">Создать пользователя</a>
                        </div>
                    <?php endif; ?>
        </div>
<?php    }
    
}
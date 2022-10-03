<?php
    include('../config.php');
    
    Users::ForceCheckUserAdmin();
    
    $user = Users::LoadUser();

    if (!empty($_POST)){
        $error = Users::CreateUser($_POST['login'],$_POST['pwd'],$_POST['role']);
        if (!$error){
            System::Redirect('/');
        }
    }
    
    Template::Run('admincreateuser','Create user');
    
    Template::Header();
    
    Template::Widget('userPanel');
?>
    <form id="loginform" action="createuser.php" method="post">
        <h1>Добавить игрока</h1>
        <h2>Dicegen</h2>
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" />
        <label for="pass">Пароль:</label>
        <input type="text" id="pass" name="pwd" /><br/>
        <label for="role">Роль:</label>
        <select id="role" name="role">
            <option value="player" selected>Игрок</option>
            <option value="admin">Админ</option>
        </select>
        <input type="submit" value="Создать" id="loginsubmit" />
        <div class="clear"></div>            
    </form>
<?php Template::Footer(); ?>
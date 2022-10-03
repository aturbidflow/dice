<?php
    include('config.php');
    
    if (!empty($_POST)){
        $error = Users::VerificateUserAuth($_POST['login'],$_POST['pwd']);
        if (!$error){
            Users::SetAuth($_POST['login']);
            System::Redirect('/');
        }
    }
    
    Template::Run('login','Login');
    
    Template::Header();
?>
    <form id="loginform" action="/login.php" method="post">
        <h1>Вход</h1>
        <h2>Dicegen</h2>
        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" />
        <label for="pass">Пароль:</label>
        <input type="password" id="pass" name="pwd" />
        <input type="submit" value="Вход" id="loginsubmit" />
        <div class="clear"></div>
    </form>
<?php Template::Footer(); ?>
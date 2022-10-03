<?php
    include('config.php');
    
    Users::ForceCheckUserAuth();
    
    $user = Users::LoadUser();
    
    if (!empty($_POST)){
        $pass = $_POST['pwd'];
        $new = $_POST['new'];
        $error = Users::VerificateUserAuth($user->getLogin(),$pass);
        if (!$error){
            $user->SetPassword($new);
            System::Redirect('/');
        }
    }
    
    Template::Run('changepass','Create user');
    
    Template::Header();
    
    Template::Widget('userPanel');
?>
    <form id="loginform" action="changepassword.php" method="post">
        <h1>Сменить пароль</h1>
        <h2>Dicegen</h2>
        <label for="pass">Текущий пароль:</label>
        <input type="password" id="pass" name="pwd" /><br/>
        <label for="newpass">Новый пароль:</label>
        <input type="text" id="newpass" name="new" />
        <input type="submit" value="Сменить" id="loginsubmit" />
        <div class="clear"></div>            
    </form>

<?php Template::Footer(); ?>
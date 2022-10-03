<?php
    include('config.php');

    Users::ForceCheckUserAuth();
    
    $user = Users::LoadUser();
       
    Template::Run('rolldice','Roll the dice');
    
    Template::Header();
    
    Template::Widget('userPanel');
    
    $return = '/';
    
    if (!empty($_GET)){
        if (isset($_GET['by'])){
            $userby = $_GET['by'];
        }
        if (isset($_GET['return']))
            $return = $_GET['return'];
    }
?>
    <div id="create-dice">
        <h1>Create dice</h1>
        <form id="dicer" action="rolldice.php" method="post">
            <label for="dice-x">Dice dimentions</label>
            <select id="dice-x" name="x">
                <option value="4" selected>4</option>
                <option value="6">6</option>               
                <option value="8">8</option>               
                <option value="10">10</option>               
                <option value="12">12</option>               
                <option value="20">20</option>               
                <option value="100">Процентник</option>               
            </select>
            <label for="dice-count">Dice roll count</label>
            <input type="text" id="dice-count" name="count" value="1" />
            <label for="comment">Comment:</label>
            <input type="text" id="comment" name="comment" />
            <input type="hidden" name="action" value="selfroll" />
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php if (!empty($userby)): ?>
                <input type="hidden" name="userby" value="<?php echo $userby; ?>"/>
                <input type="submit" value="Добавить" />
            <?php else: ?>
                <input type="submit" value="Крутить" />
            <?php endif; ?>
        </form>
    </div>
<?php Template::Footer(); ?>
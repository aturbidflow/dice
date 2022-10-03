<?php
    include('../config.php');

    Users::ForceCheckUserAdmin();
    
    $user = Users::LoadUser();
    
    if (!empty($_POST)){
        $owner = $_POST['user'];
        $x = $_POST['x'];
        $count = $_POST['count'];
        $comment = $_POST['comment'];
        Dices::Create($x,$count,$owner,$comment);
    }
    
    Template::Run('admincreatedice','Create dice');
    
    Template::Header();
    
    Template::Widget('userPanel');
?>
    <div id="create-dice">
        <h1>Create dice</h1>
        <form id="dicer" action="createdice.php" method="post">
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
            <label for="user">Assign to:</label>
            <select id="user" name="user">
                <?php Users::FormListOf(); ?>
            </select>
            <label for="comment">Comment:</label>
            <input type="text" id="comment" name="comment" />
            <input type="submit" value="Assign" />
        </form>
    </div>
<?php Template::Footer(); ?>
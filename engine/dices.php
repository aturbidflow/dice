<?php

class Dices {
    
    public static function DiceBlock($dice){
        if ($dice->isAssigned())
            Template::Widget ('rolldice',array('dice'=>$dice));
        elseif ($dice->isRolled())
            Template::Widget ('rolleddice',array('dice'=>$dice));
        elseif ($dice->isClosed())
            Template::Widget ('closeddice',array('dice'=>$dice));
    }    
    
    public static function DiceLine($dice,$user = ''){
        if (empty($user)) $user = Users::LoadUser();
        
        if ($dice->Owner() != $user->ID()) $wait = ' (by <a href="/admin/userinfo.php?id='.$dice->Owner().'">'.Users::GetLogin($dice->Owner()).'</a>)'; else $wait = ' (waiting for approve)';
        
        if ($dice->isAssigned()): ?>
            <li class="dice dice-new">
                <form class=rolldice-form" action="/rolldice.php" method="post">
                    <input type="hidden" name="return" value="<?php echo System::currentLocation(); ?>" />
                    Roll the <?php $dice->Type(); ?> dice (<?php echo $dice->comment(); ?>): 
                    <input type="hidden" name="dice-id" value="<?php echo $dice->ID(); ?>" />
                    <input type="submit" value="Roll" />
                </form>
        <?php elseif ($dice->isRolled()): ?> 
            <li class="dice dice-rolled">
                Rolled <?php $dice->Type(); ?> (<?php echo $dice->Comment(); ?>) with result <?php echo $dice->result(); ?> at <?php echo $dice->Time().$wait; ?>
                <?php  if (Users::CurrentIsAdmin()) {
                    echo '<a href="/admin/approve.php?id='.$dice->id().'">Approve</a> <a href="/admin/decline.php?id='.$dice->id().'">Decline</a>';
                } ?>
        <?php else: ?>
            <li class="dice dice-closed">
                Rolled <?php $dice->Type(); ?> (<?php echo $dice->Comment(); ?>) with result <?php echo $dice->result(); ?> at <?php echo $dice->Time(); ?> (approved by <?php echo Users::GetLogin($dice->ApprovedBy()) ;?>)
        <?php endif;
        if (Users::CurrentIsAdmin()&&!$dice->IsClosed()){
            echo '<a href="/admin/delete.php?id='.$dice->id().'">Delete</a></li>'; 
        } else echo '</li>';
    }
    
    public static function Install(){
        $q = new Query('CREATE TABLE  `dices` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`owner` INT NOT NULL , `comment` VARCHAR( 512 ) NOT NULL ,`x` INT NOT NULL ,`count` INT NOT NULL ,`state` ENUM(  "assigned",  "rolled",  "closed" ) NOT NULL ,`result` INT NOT NULL);');
    }
    
    public static function Installed(){
        $q = new Query('select `id` from `dices`');
        return $q->is();
    }
    
    public static function Create($x,$count,$owner,$comment=''){
        $q = new Query('insert into `dices` (`id`,`owner`,`x`,`count`,`state`,`result`,`comment`) values (NULL,'.Users::GetID($owner).','.$x.','.$count.',"assigned",NULL,"'.$comment.'");');
        return $q->InsertID();
    }
    
    public static function GetAwaiting($id = ''){
        if (empty($id))
            $q = new Query('select `id` from `dices` where `state`="rolled"');
        else
            $q = new Query('select `id` from `dices` where `state`="rolled" and `owner`='.$id);
        $dids = $q->GetColumn('id');
        $dices = array();
        foreach ($dids as $did){
            $dices[] = Dices::LoadDice($did);
        }
        return $dices;
    }

        
    public static function LoadDice($id){
        $q = new Query('select `x`,`count`,`result`,`time`,`comment` from `dices` where `id`='.$id);
        $diceinfo = $q->GetRow('str');
        return new Dice($id,$diceinfo['x'],$diceinfo['count'],$diceinfo['result'],$diceinfo['time'],$diceinfo['comment']);
    }
    
    public static function LoadDices($userid){
        $q = new Query('select `id` from `dices` where `owner`='.$userid);
        $dids = $q->GetRows('str');
        $dices = array();
        foreach ($dids as $did){
            $dices[] = Dices::LoadDice($did['id']);
        }
        return $dices;
    }

}

?>

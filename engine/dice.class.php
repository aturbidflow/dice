<?php

class Dice {
    
    private $x;
    private $count;
    private $result;
    private $owner;
    private $id;
    private $time;
    private $comment;
    
    public function __construct($id,$x,$count,$result='',$time='',$comment=''){
        $this->x = $x;
        $this->count = $count;
        $this->id = $id;
        $this->result = $result;
        $this->time = $time;
        $this->comment = $comment;
    }
    
    public function State(){
        $q = new Query('select `state` from `dices` where `id`='.$this->id);
        return $q->Get();
    }
    public function SetOwner(&$owner){
        $this->owner = $owner;
    }
    
    public function Owner(){
        $q = new Query('select `owner` from `dices` where `id`='.$this->id);
        return $q->Get();
    }
    
    public function Comment(){
        return $this->comment;
    }
    
    public function Count(){
        return $this->count;
    }
    
    public function X(){
        return $this->x;
    }
    
    public function Type(){
        echo $this->getType();
    }
    
    public function getType(){
        return $this->count.'d'.$this->x;
    }
    
    public function Result(){
        if (empty($this->result)) return "NULL"; else return $this->result;
    }
    
    public function Time(){
        if (empty($this->time)) return 'Never'; else return System::FormatDate($this->time);
    }
    
    public function ApprovedBy(){
        $q = new Query('select `approvedby` from `dices` where `id`='.$this->id);
        return $q->Get();
    }
    
    public function Roll(){
        $result = 0;
        for ($i=0;$i<$this->count;$i++){
            $result += round(rand(1,$this->x));
        }
        $q = new Query('update `dices` set `result`='.$result.',`state`="rolled",`time`=CURRENT_TIMESTAMP where `id`='.$this->id); 
    }
    
    public function Decline($user){
        if ($user->IsAdmin()){
            $q = new Query('update `dices` set `result`=NULL,`state`="assigned",`time`=CURRENT_TIMESTAMP where `id`='.$this->id);
        }
    }
    
    public function Suicide($user){
        if ($user->IsAdmin()&&!$this->isClosed()){
            $q = new Query('delete from `dices` where `id`='.$this->id);
        }
    }
    
    public function Approve($user){
        if ($user->IsAdmin()){
            $q = new Query('update `dices` set `state`="closed",`approvedby`='.$user->ID().' where `id`='.$this->id);
        }
    }
    
    public function ID(){
        return $this->id;
    }
    
    public function isAssigned(){
        return $this->isState('assigned');
    }
    
    public function isRolled(){
        return $this->isState('rolled');
    }
    
    public function isClosed(){
        return $this->isState('closed');
    }
    
    private function isState($state){
        $q = new Query('select `state` from `dices` where `id`='.$this->id);
        if ($state == $q->Get()) return true; else return false;
    }
    
}

?>

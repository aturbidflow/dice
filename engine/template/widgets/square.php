<?php

class Square extends Widget {
    
    private $id;
    private $classes = array();
    private $isbutton = false;
    private $title = '';
    private $subtitle = '';
    private $sign = '';
    private $desc = '';
    private $link = '/';
    private $dice;
    
    function Init($data=array()){
            if (isset($data['title'])){
                $this->title = $data['title'];
            }
            if (isset($data['id'])){
                $this->id = $data['id'];
            }
            if (isset($data['classes'])){
                $this->classes = $data['classes'];
            }
            if (isset($data['button'])){
                $this->isbutton = $data['button'];
            }
            if (isset($data['subtitle'])){
                $this->subtitle = $data['subtitle'];
            }
            if (isset($data['desc'])){
                $this->desc = $data['desc'];
            }
            if (isset($data['sign'])){
                $this->sign = $data['sign'];
            }
            if (isset($data['link'])){
                $this->link = $data['link'];
            }
            if (isset($data['dice'])){
                $this->dice = $data['dice'];
            }
    }

    function Widget($data=array()){ 
            $this->Init($data);
        ?>
<div <?php $this->ID(); ?> <?php $this->getClasses(); ?>>
    <?php if ($this->isbutton) echo '<a class="likeabutton" href="'.$this->link.'">';
    $this->Desc(); 
    $this->Title(); 
    $this->Subtitle(); 
    $this->Sign();
    if ($this->isbutton) echo '</a>'; ?>
</div>
<?php    }

    function getClasses(){
        $classes = $this->classes;
        if ($this->isbutton) $classes[] = 'square-button'; else $classes[] = 'square-inbox';
        $out = 'class="square';
        foreach ($classes as $class){
            $out .= ' '.$class;
        }
        $out.='"';
        echo $out;
    }
    
    function ID(){
        if(!empty($this->id)) echo 'id="'.$this->id.'"';
    }
    
    function Desc(){
        if(empty($this->desc)&&!$this->dice->IsAssigned()){
            $this->desc = '&nbsp;';
        }
        $user = Users::LoadUser();
        if ($user->IsAdmin()&&!empty($this->dice)&&!$this->dice->IsAssigned()){
            $this->desc .= '<br/><small>(by <a class="owner-link" href="/admin/userinfo.php?id='.$this->dice->Owner().'">'.Users::GetLogin ($this->dice->Owner()).'</a>)</small>';
        }
        ?>
            <h3 class="square-description"><?php echo $this->desc; ?></h3>
        <?php 
    }
    
    function Sign(){
        if(!empty($this->sign)): ?>
            <p class="square-signature"><?php echo $this->sign; ?></p>
        <?php endif;
    }
    
    function Title(){
        if(!empty($this->title)): ?>
            <h1 class="square-title"><?php echo $this->title; ?></h1>
        <?php endif;
    }
    
    function Subtitle(){
        if(!empty($this->subtitle)): ?>
            <h2 class="square-subtitle"><?php echo $this->subtitle; ?></h2>
        <?php endif;
    }
    
    function Dice(){
        return $this->dice;
    }
        
}
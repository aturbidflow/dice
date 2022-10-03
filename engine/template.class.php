<?php

include_once('widget.class.php');

class Template {
    
    private static $title;
    private static $pagename;

    public static function Load(){
        
    }
    
    public static function Header(){
        include_once('template/header.php');
    }
    
    public static function Footer(){
        include_once('template/footer.php');
    }
    
    public static function Title(){
        echo Template::$title;
    }
    
    public static function Run($pagename,$title){
        Template::$pagename = $pagename;
        Template::setTitle($title);
        $widgets = System::GetFilesList(System::Root().'/engine/template/widgets/');
        foreach ($widgets as $widget){
            include_once(System::Root().'/engine/template/widgets/'.$widget);
        }
    }
    
    public static function PageName(){
        return Template::$pagename;
    }
    
    public static function setTitle($title){
        Template::$title = $title;
    }
    
    public static function Widget($widget,$data=''){
            if (class_exists($widget)){
                $w = new $widget;
                $w->Widget($data);
            } else {
                ErrorGen::ThrowMe('No widget', 'Maybe it lost');
            }
    }
}

?>

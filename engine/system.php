<?php
class System {
      
    public static function Redirect($location,$timer=0) {
        if ($location=="back") $location = $_SERVER['HTTP_REFERER'];
        if (System::isLocationCurrent($location)) $location=System::baseLocation();
        if (empty($timer)){
                header ('Location:'.$location);
        } else {
                header ('Refresh: '.$timer.';url='.$location);
        }
    }

    public static function currentLocation(){
	return 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    }

    public static function baseLocation(){
	return 'http://'.$_SERVER['SERVER_NAME'];
    }
    
    public static function isLocationCurrent($location){
            return ($location == System::currentLocation());
    }
    
    public static function CheckRequiments(){
        if (!Users::Installed()) Users::Install();
    }
    
    public static function GetFilesList($dir){
        if (is_dir($dir)){
            if ($d = opendir($dir)){
                $files = array();
                while (($file = readdir($d)) !== false){
                    if (!is_dir($file)){
                        $files[] = $file;
                    }
                }
                closedir($d);
                return $files;
            }
        }
    }
    
    public static function Root(){
        return '/'.trim(str_replace('engine', '', str_replace('engine/','',dirname(__FILE__))),'/');
    }
    
    public static function formatDate($dbdate,$time=true){        
        $date = date('j F Y, H:i:s',System::dbTimestamp($dbdate));
        if ($time){
                if (preg_match('/([0-9]{1,2}) ([a-zA-Z]+) ([0-9]{4}), ([0-2][0-9]\:[0-9]{2}):([0-9]{2})/Uis',$date,$matches)){
                        if ($matches[5] == '00')
                                $out = $matches[1].' '.System::MonthName($matches[2]).' '.$matches[3].' в '.$matches[4];
                        else
                                $out = $matches[1].' '.System::MonthName($matches[2]).' '.$matches[3].' в '.$matches[4].':'.$matches[5];
                } elseif (preg_match('/([0-9]{1,2}) ([a-zA-Z]+) ([0-9]{4}), ([0-2][0-9]\:[0-9]{2})/Uis',$date,$matches)){
                        $out = $matches[1].' '.System::MonthName($matches[2]).' '.$matches[3].' в '.$matches[4];
                }
        } else {
                if (preg_match('/([0-9]{1,2}) ([a-zA-Z]+) ([0-9]{4})/Uis',$date,$matches)) {
                        $out = $matches[1].' '.System::MonthName($matches[2]).' '.$matches[3];
                }
        }
        return $out;
    }
    
    public static function MonthName($num){
            switch (strtolower($num)){
                    case '12':
                    case 'december':
                    case 'dec':
                            $out='декабря';
                    break;
                    case '11':
                    case 'november':
                    case 'nov':
                            $out='ноября';
                    break;
                    case '10':
                    case 'october':
                    case 'oct':
                            $out='октября';
                    break;
                    case '9':
                    case 'september':
                    case 'sep':
                    case 'sept':
                            $out='сентября';
                    break;
                    case '8':
                    case 'august':
                    case 'aug':
                            $out='августа';
                    break;
                    case '7':
                    case 'july':
                    case 'jul':
                            $out='июля';
                    break;
                    case '6':
                    case 'june':
                    case 'jun':
                            $out='июня';
                    break;
                    case '5':
                    case 'may':
                            $out='мая';
                    break;
                    case '4':
                    case 'april':
                    case 'apr':
                            $out='апреля';
                    break;
                    case '3':
                    case 'march':
                    case 'mar':
                            $out='марта';
                    break;
                    case '2':
                    case 'february':
                    case 'feb':
                            $out='февраля';
                    break;
                    case '1':
                    case 'january':
                    case 'jan':
                            $out='января';
                    break;
                    default:
                            $out='нет такого месяца оО';
                    break;
            }

            return $out;
    }

    public static function dbTimestamp($time){
            $q = new Query('select UNIX_TIMESTAMP("'.$time.'")');
            if ($q->is())
                    return $q->Get();
            else
                    return false;
    }
    
}
?>

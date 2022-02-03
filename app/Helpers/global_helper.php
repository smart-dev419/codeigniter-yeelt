<?php

use Config\Services;

function checkIBAN($iban)
{
    if($iban == null || $iban == '') {
        return false;
        exit();
    }
    $iban = strtolower(str_replace(' ','',$iban));
    $Countries = array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
    $Chars = array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

    if(strlen($iban) == $Countries[substr($iban,0,2)]){

        $MovedChar = substr($iban, 4).substr($iban,0,4);
        $MovedCharArray = str_split($MovedChar);
        $NewString = "";

        foreach($MovedCharArray AS $key => $value){
            if(!is_numeric($MovedCharArray[$key])){
                $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
            }
            $NewString .= $MovedCharArray[$key];
        }

        if(bcmod($NewString, '97') == 1)
        {
            return true;
        }
    }
    return false;
}

function is_actief($actief = '')
{
    if($actief == "1") {
        $verwerkt = '<span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span>';
    } else {
        $verwerkt = '<span style="color: red;"><i class="fa fa-times" aria-hidden="true"></i></span>';
    }
    return $verwerkt;
} 

function bedrag($bedrag) {
    $output = number_format($bedrag, 2, ',', '.');
    $output = "&euro; ".$output;
    $output = str_replace(",00",",-",$output);
    return $output;
}

function coach_category_convert($category) {
    $return = array();

    switch($category) {
        case "Woningdossier":
            $return['text'] = "WD";
            $return['class'] = "is-h-purple";
        break;  
        case "Log":
            $return['text'] = "L";
            $return['class'] = "is-h-blue";
        break; 
        case "Contact":
            $return['text'] = "C";
            $return['class'] = "is-h-orange";
        break; 
        case "Bewonersreis":
            $return['text'] = "BR";
            $return['class'] = "is-h-yellow";
        break; 
        default:
            $return['text'] = "-";
            $return['class'] = "is-h-grey";
        break;
    }

    return $return;
}

function truncate($string, $length, $dots = "...") {
    $string = strip_tags($string);
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}

function randomString($lengte = 32) {
    $karakters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $lengte; $i++) {
        $randomString .= $karakters[rand(0, strlen($karakters) - 1)];
    }
    return $randomString;
}

function format_date($date, $format = 'Y-m-d') {
    return date($format, strtotime($date));
}

?>
<?php

use Config\Services;

if (!function_exists('datatable_button')) {
    function datatable_button($url, $data) {
        $buttonsHtml = '<div class="buttons">
                            <a href="'.site_url($data->ListKey).'" class="button h-button is-info is-raised">
                                    <span class="icon is-small">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </a>
                            <a href="'.site_url($data->ListKey).'" class="button h-button is-primary is-raised">
                                    <span class="icon is-small">
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                            </a>
                            <a href="'.site_url($data->ListKey).'" class="button h-button is-danger is-raised">
                                    <span class="icon is-small">
                                    <i class="fas fa-times"></i>
                                </span>
                            </a>
                        </div>';
        return $buttonsHtml;
    }
}

if (!function_exists('datatable_status')) {
    function datatable_status($data) {
        if($data === 'Active') {
            $data = 1;
        }
        if($data == 1) {
            return '<span style="color: green;"><i class="fa fa-check" aria-hidden="true"></i></span>';
        } else { 
            return '<span style="color: red;"><i class="fa fa-times" aria-hidden="true"></i></span>';
        }
    }
}

if (!function_exists('datatable_checksum')) {
    function datatable_checksum($sha1) {
        if(!empty($sha1) && strlen($sha1) > 10) {
            $output = array();
            $output[0] = substr($sha1, 0, 35);
            $output[1] = substr($sha1, 35, 5);
    
            return '<p class="copy hint--top" data-hint="'.$sha1.'" style="padding:0;margin:0;cursor:pointer;">'.$output[1].' <i class="fa fa-copy"></i></p>';
        } else {
            return '<p style="opacity: 0.5;padding:0;margin:0;">Geen</p>';
        }
    }
}

if (!function_exists('datatable_formatbytes')) {
    function datatable_formatbytes($bytes) { 
        $precision = 0;
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }
}

if (!function_exists('datatable_convert_price')) {
    function datatable_convert_price($price) {
        $output = number_format($price, 2, ',', '.');
        $output = "&euro; ".$output;
        $output = str_replace(",00",",-",$output);
        return $output;
    } 
}

if (!function_exists('datatable_datetime')) {
    function datatable_datetime($datetime) {
        return date("d-m-Y H:i:s", strtotime($datetime));
    } 
}

if (!function_exists('datatable_datetime_min')) {
    function datatable_datetime_min($datetime) {
        return date("d-m H:i:s", strtotime($datetime));
    } 
}

if (!function_exists('datatable_rrew_status')) {
    function datatable_rrew_status($status) {
        switch($status) {
            case "OPEN":
                $htmlString  = '<span style="color: #ccc;">OPEN</span>';
            break;
            case "IN AANVRAAG":
                $htmlString  = '<span class="text-warning">IN AANVRAAG</span>';
            break;
            case "AFGEWEZEN":
                $htmlString  = '<span class="text-danger">AFGEWEZEN</span>';
            break;
            case "GOEDGEKEURD":
                $htmlString  = '<span class="text-success">GOEDGEKEURD</span>';
            break;
            case "EXTERN":
                $htmlString  = '<span style="color: purple;">EXTERN</span>';
            break;
            case "ON-HOLD":
                $htmlString  = '<span style="background: #000; color: #fff; padding: 0 7px;">ON-HOLD</span>';
            break;
        }
        return $htmlString;
    } 
}

if (!function_exists('datatable_mailberichtentype')) {
    function datatable_mailberichtentype($status) {
        switch($status) {
            case "Afwijzen":
                $htmlString  = '<span style="color: red;">AFWIJZEN</span>';
            break;
            case "Goedkeuren":
                $htmlString  = '<span style="color: green;">GOEDKEUREN</span>';
            break;
            case "On-hold":
                $htmlString  = '<span style="color: black;">ON-HOLD</span>';
            break;
        }
        return $htmlString;
    } 
}
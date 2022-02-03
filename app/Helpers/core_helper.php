<?php

use Config\Services;

if (!function_exists('convertFieldNames'))
{
    function convertFieldNames($fields)
    {
        $return = array();
        foreach($fields as $field) { $return[$field] = ''; }        
        return $return; 
    }
}

if (!function_exists('get_time_ago'))
{
    function get_time_ago( $time )
    {
        $time_difference = time() - $time;

        if( $time_difference < 1 ) { return 'less than 1 second ago'; }
        $condition = array( 12 * 30 * 24 * 60 * 60 =>  'year',
                    30 * 24 * 60 * 60       =>  'month',
                    24 * 60 * 60            =>  'day',
                    60 * 60                 =>  'hour',
                    60                      =>  'minute',
                    1                       =>  'second'
        );

        foreach( $condition as $secs => $str )
        {
            $d = $time_difference / $secs;

            if( $d >= 1 )
            {
                $t = round( $d );
                return 'about ' . $t . ' ' . $str . ( $t > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
}

if (!function_exists('bedrag'))
{
    function bedrag( $bedrag )
    {
        $output = number_format($bedrag, 2, ',', '.');
        $output = "&euro; ".$output;
        $output = str_replace(",00",",-",$output);
        return $output;
    }
}
<?php


function generateRandomString($length, $alphabets_only = false)
{
    if($alphabets_only)
    {
        $characters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
    }
    else
    {
        $characters = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ123456789';
    }
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function date2sql($date)
{
    if($date)
    {
        return date("Y-m-d", strtotime($date));    
    }
    
}

if ( !function_exists('truncate_string'))
{
    function truncate_string($string_to_trim,$number_of_chars = 20)
    {
        if(!empty($string_to_trim))
        {
            if( strlen( $string_to_trim ) >= $number_of_chars )
            {
                return substr($string_to_trim, 0, ($number_of_chars-1))."...";  // abcd
            }
            else
            {
                return substr($string_to_trim, 0, $number_of_chars);  // abcd
            }
        
        }
        else{
            return "";
        }
    }
}

if ( !function_exists('to_2dp'))
{
    function to_2dp($num1)
    {
        return number_format((float)$num1, 2, '.', '');
    }
}
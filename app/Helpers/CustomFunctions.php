<?php
if (!function_exists('quarter')) {
function quarter() 
{ 
    $month = date("n");
    $yearQuarter = ceil($month / 6);
    return $yearQuarter."/".date("Y");
} 
}
<?php
if (!function_exists('quarter')) {
function quarter() 
{ 
    $month = date("n");
    $yearQuarter = ceil($month / 3);
    return $yearQuarter."/".date("Y");
} 
}
<?php
// Silence is golden.


function gmapsl_checkbox_from_db($val){
    if($val == 1){
        $val = "on";
    }else{
        $val = "off";
    }
    return $val;
}

function gmapsl_checkbox_into_db($val){
    if($val == "on"){
        $val = 1;
    }else{
        $val = 0;
    }
    return $val;
}






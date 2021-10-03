<?php

// Timezone
date_default_timezone_set('Asia/Seoul');


// Error Handling
ini_set('display_errors', 'Off');


// Database Connection (MySQLi)
// $globals의 자료형은 array
$GLOBALS['db_connection'] = mysqli_connect( //싱글톤
    'localhost',
    'root',
    '40387961As!!',
    'phpblog'
);
if(!$GLOBALS['db_connection']){
    exit;
}

//connection은 script가 종료될때 삭제 되어야 한다.
register_shutdown_function(function (){
    if(array_key_exists('db_connection',$GLOBALS['db_connection']) && $GLOBALS['db_connection']){
        mysqli_close($GLOBALS['db_connection']);
    }
});


// Session
ini_set('session.gc_maxlifetime', 1440); //세션 시간 설정
session_set_cookie_params(1440);

session_start();


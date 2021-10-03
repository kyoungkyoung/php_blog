<?php

require_once '/phpBlog/bootstrap/app.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password');   
$token = filter_input(INPUT_POST, 'token');

if($email && $password && hash_equals($token, $_SESSION['CSRF_TOKEN'])){
    //wkjang4@gamil.com -> wkjang4 return
    $username = explode('@', $email)[0]; //current(explode('@', $email));
    $password = password_hash($password, PASSWORD_DEFAULT); //password 보안의 위해 해줘야함

    $stmt = mysqli_prepare(
        $GLOBALS['db_connection'],
        'insert into users(email, password, username) values(?,?,?)'
        );
    mysqli_stmt_bind_param($stmt, 'sss', $email, $password, $username);

    if(mysqli_stmt_execute($stmt)){
        session_unset();
        session_destroy();
        return header('Location: /auth/login.php');
    }else{
        return header('Location: /user/register.php');
    }
}else{
    return header('Location: /user/register.php');
}
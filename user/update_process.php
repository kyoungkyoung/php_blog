<?php

require_once '/phpBlog/bootstrap/app.php';

if(array_key_exists('user', $_SESSION)){
    $user = $_SESSION['user'];
    echo "<script>alert({$user});</script>";
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL, FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password');
    $token = filter_input(INPUT_POST, 'token');

    if($email && $password && hash_equals($token, $_SESSION['CSRF_TOKEN'])){
        $username = current(explode('@', $email));
        $password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare(
            $GLOBALS['db_connection'],
            'update users set email=?, password=?, username=? where id=?');
        mysqli_stmt_bind_param($stmt, 'sssi', $email, $password, $username, $user['id']);
        if(mysqli_stmt_execute($stmt)){
            //update 성공하면 session없애           
            echo "<script>alert('수정완료!!');</script>";
            session_unset();
            session_destroy();
            header('Location: /auth/login.php');
        }else{
            header('Location: /user/update.php');
        }
        return mysqli_stmt_close($stmt);
    }
    echo "<script>alert('실패');</script>";
    return header('Location: /auth/login.php');
}
return header('Location: /phpBlog/auth/login.php');


?>
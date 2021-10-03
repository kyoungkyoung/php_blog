<?php

require_once dirname(__DIR__).'/bootstrap/app.php';

if(array_key_exists('user', $_SESSION)){
    $user = $_SESSION['user'];
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // post['id']
    $token = filter_input(INPUT_GET, 'token');

    if($id && hash_equals($token, $_SESSION['CSRF_TOKEN'])){
        $stmt = mysqli_prepare(
            $GLOBALS['db_connection'],
            'select * from posts where id=?'
        );
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            [ 'userId' => $userId ] = mysqli_fetch_assoc($result);
        }
        mysqli_stmt_close($stmt);
    }
    if($user['id'] == $userId){
        $stmt = mysqli_prepare(
            $GLOBALS['db_connection'],
            'delete from posts where id=?'
        );
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if(mysqli_stmt_execute($stmt)){
            header('Location: /');
        } else {
            echo "<script>alert('실패')</script>";
            header('Location: /posts/read.php?id='.$id);
        }
        return mysqli_stmt_close($stmt);
    }
    echo "<script>alert('실패')</script>";
    header('Location: /posts/read.php?id='.$id);
}
return header('Location: /auth/login.php');
?>

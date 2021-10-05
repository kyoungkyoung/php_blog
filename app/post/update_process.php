<?php
require_once dirname(__DIR__).'/bootstrap/app.php';

if(array_key_exists('user', $_SESSION)){
    $user = $_SESSION['user'];
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $content = filter_input(INPUT_POST, 'content');
    $token = filter_input(INPUT_POST, 'token');

    if(isset($id) && isset($title) && isset($content) && hash_equals($token, $_SESSION['CSRF_TOKEN'])){
        $stmt = mysqli_prepare(
            $GLOBALS['db_connection'],
            'select * from posts where id=?'
        );
        mysqli_stmt_bind_param($stmt, 'i', $id);
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            [
                'userId' => $userId
            ] = mysqli_fetch_assoc($result);
        }
        mysqli_stmt_close($stmt);
        
        if($user['id'] == $userId){
            $stmt = mysqli_prepare(
                $GLOBALS['db_connection'],
                'update posts set title=?, content=? where id=?'
            );
            
            mysqli_stmt_bind_param($stmt, 'ssi', $title, $content, $id);
            if(mysqli_stmt_execute($stmt)){
                return header('Location: /post/read.php?id='.$id);
            }else {
                header('Location: /post/update.php?id='.$id);
            }
            mysqli_stmt_close($stmt);
        }
    }else{
        header('Location: /post/update.php?id'.$id);
    }
}else{
    echo "<script>alert('로그인 먼저!!')</script>";
    header('Location: /auth/login.php');
}
        
        
        ?>

<?php require_once '/phpBlog/layouts/top.php';?>
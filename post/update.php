<?php
require_once dirname(__DIR__).'/bootstrap/app.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$token = filter_input(INPUT_GET, 'token');

if(!array_key_exists('user', $_SESSION)){
    return header('Location: /auth/login.php');
}
$user = $_SESSION['user'];

$_SESSION['CSRF_TOKEN'] = bin2hex(random_bytes(32));
output_add_rewrite_var('token', $_SESSION['CSRF_TOKEN']);


$stmt = mysqli_prepare(
    $GLOBALS['db_connection'],
    'select * from posts where id=? limit 1'
);
mysqli_stmt_bind_param($stmt, 'i', $id);
if(mysqli_stmt_execute($stmt)){
    $result = mysqli_stmt_get_result($stmt);
    [
        'userId'  => $userId,
        'title'   => $title,
        'content' => $content,
    ] = mysqli_fetch_assoc($result);
}
mysqli_stmt_close($stmt);

if($user['id'] != $userId){
    return header('Location: /'); // 현재 페이지에 그대로 있게한다 ; 잘못된 접근이니까 화면 안넘어가게
}
?>

<?php require_once '/phpBlog/layouts/top.php';?>
<div id="main_form_post">
    <form method="post" action="/post/update_process.php?id=<?=$id?>">
        <input type="text" name="title" value="<?=$title?>" class="uk-input uk-article-title">
        <hr>
        <div class="editor uk-align-center">
            <textarea name="content"></textarea>
            <div id="editor"><?=$content?></div>
        </div>
        <input type="submit" value="수정하기" class="uk-button uk-button-default uk-width-1-3">
    </form>
</div>

<?php require_once '/phpBlog/layouts/bottom.php';?>

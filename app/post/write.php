<?php

require_once dirname(__DIR__).'/bootstrap/app.php';

if(!array_key_exists('user', $_SESSION)){
    return header('Location: /auth/login.php');
}
$_SESSION['CSRF_TOKEN'] = bin2hex(random_bytes(32));
output_add_rewrite_var('token', $_SESSION['CSRF_TOKEN']);

?>

<?php require_once '/phpBlog/layouts/top.php'; ?>
<div id="main_form_post" style="text-align:center;">
    <form method="post" action="/post/write_process.php">
        <input type="text" name="title" placeholder="제목을 입력하세요" class="uk-input uk-article-title">
        <hr>
        <div class="editor uk-align-center">
            <textarea name="content" rows="15"></textarea>
            <div id="editor"></div>
            <br>
        </div>
        <input type="submit" value="작성하기" class="uk-button uk-button-default uk-width-1-3">
    </form>
</div>


<?php require_once '/phpBlog/layouts/bottom.php'; ?>

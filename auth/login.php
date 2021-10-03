<?php

//DB 설정
require_once '/phpBlog/bootstrap/app.php';
//session
$_SESSION['CSRF_TOKEN'] = bin2hex(random_bytes(32));
output_add_rewrite_var('token', $_SESSION['CSRF_TOKEN']);

//top
require_once '/phpBlog/layouts/top.php';
?>

<div id="main_form_auth" class="uk-padding uk-position-fixed uk-position-center">
    <form action="/auth/login_process.php" method="POST">
        <!-- <input type="hidden" name="token" value="<?=$_SESSION['CSRF_TOKEN']?>"> -->
        <input type="text" name="email" class="uk-input uk-form-blank" placeholder="Email">
        <input type="password" name="password" class="uk-input uk-form-blank uk-margin-small-top" placeholder="password">
        <input type="submit" value="Sign in" class="uk-button uk-margin-small-top uk-button-default uk-width-1-1">
    </form>
</div>

<?php require_once '/phpBlog/layouts/bottom.php';?>
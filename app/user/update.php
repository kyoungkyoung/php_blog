<?php

require_once '/phpBlog/bootstrap/app.php';

if(!array_key_exists('user', $_SESSION)){
    return header('Location: /phpBlog/auth/login.php');
}

$_SESSION['CSRF_TOKEN'] = bin2hex(random_bytes(32));
output_add_rewrite_var('token', $_SESSION['CSRF_TOKEN']);
$user = $_SESSION['user'];

//top
require_once '/phpBlog/layouts/top.php';
?>

<div id="main_form_update" class="uk-padding uk-position-fixed uk-position-center">
    <form action="/user/update_process.php" method="POST">
        <!-- <input type="hidden" name="token" value="<?=$_SESSION['CSRF_TOKEN']?>"> -->
        <input type="text" name="email" class="uk-input uk-form-blank" value="<?=$user['email']?>" placeholder="Email">
        <input type="password" name="password" class="uk-input uk-form-blank uk-margin-small-top" placeholder="password">
        <input type="submit" value="Sign in" class="uk-button uk-margin-small-top uk-button-default uk-width-1-1">
    </form>
</div>

<?php require_once '/phpBlog/layouts/bottom.php';?>
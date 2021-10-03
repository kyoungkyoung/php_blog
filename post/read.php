<?php

require_once dirname(__DIR__).'/bootstrap/app.php';

$_SESSION['CSRF_TOKEN'] = bin2hex(random_bytes(32)); //delete 할때 csrf_token도 같이 넘겨주기위해

// $user = $_SESSION['user'] ?? null; // session에 user가 있으면 user반환, 없으면 null반환

if(array_key_exists('user', $_SESSION)){
    $user = $_SESSION['user'];
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // post['id']

$stmt = mysqli_prepare(
    $GLOBALS['db_connection'],
    'select * from posts where id=?'
);
mysqli_stmt_bind_param($stmt, 'i', $id);
if(mysqli_stmt_execute($stmt)){
    $result = mysqli_stmt_get_result($stmt);
    [
        'userId'    => $userId,         // 컬럼이 userId인 애를 $userId에 넣고
        'title'     => $title,
        'content'   => $content,
        'createdAt' => $createdAt
    ] = mysqli_fetch_assoc($result);
}
mysqli_stmt_close($stmt);

if($userId){
    $stmt = mysqli_prepare(
        $GLOBALS['db_connection'],
        'select * from users where id=?'
    );
    mysqli_stmt_bind_param($stmt, 'i', $userId);
    if(mysqli_stmt_execute($stmt)){
        $result = mysqli_stmt_get_result($stmt);
        [
            'username' => $username,
            'email'    => $email
        ] = mysqli_fetch_assoc($result);
    }
}

if($userId && isset($user)){
    $isOwner = $userId == $user['id'];
}

?>

<?php require_once '/phpBlog/layouts/top.php'; ?>

<div id="main_article" class="uk-container">
    <article class="uk-margin uk-article">
        <h1 class="uk-article-title"><?=$title?></h1>
        <div class="uk-text-meta">
            by <?=$username?>
        </div>
        <div class="uk-text-meta">
            <?=$createdAt?>
            <?php if(isSet($isOwner)){ ?>
                <span cl
                ass="owner">
                    <a href="/post/delete_process.php?id=<?=$id?>&token=<?=$_SESSION['CSRF_TOKEN']?>"
                        class="uk-link-text" id="delete">Delete</a>
                    <a href="/post/update.php?id=<?=$id?>&token=<?=$_SESSION['CSRF_TOKEN']?>"
                    class="uk-link-text" id="delete">Update</a>
                </span>
            <?php } ?>
        </div>
        <div class="uk-text-lead uk-margin-bottom"><?=$content?></div>
    </article>
</div>

<?php require_once '/phpBlog/layouts/bottom.php'; ?>
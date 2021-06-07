<!DOCTYPE html>

<meta charset="UTF-8" />
<title>MyArea Feed</title>
<link rel="stylesheet" type="text/css" href=<?= ASSETS_URL . "style.css"?> />

<div class="center">
<h1>Post feed</h1>
</br>
<?php include("view/menu.php"); ?>
</div>

</br>

<?php foreach ($posts as $post){
    PostController::includeHeader($post);
    }?>

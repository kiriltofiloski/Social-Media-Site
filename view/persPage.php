<!DOCTYPE html>

<meta charset="UTF-8" />
<title>MyArea</title>
<link rel="stylesheet" type="text/css" href=<?= ASSETS_URL . "style.css"?> />

<?php $themes = explode(",", $user["theme"]);?>

<style>
html {background-color: <?php echo $themes[0];?>;}
h1,p,a   {color: <?php echo $themes[1];?>;}
</style>

<h1><?php echo $user["username"];?>'s Page</h1>

<div class="center">
<?php include("view/menu.php"); ?>
</div>

<div class="box">
<p><?php echo $user["firstName"];?> <?php echo $user["lastName"];?></p>

<p>Gender: <?php echo $user["gender"];?></p>
</div>
</br>

<?php if($isYourPage == false && User::isLoggedIn()) : ?>
    <form action="<?= BASE_URL . $formAction ?>" method="post">
    <p><button><?php echo $formText;?></button></p>
    </form>
<?php endif; ?>

<?php if($isYourPage == true) : ?>
    <a href="<?= BASE_URL . "personal/edit" ?>">Edit Information</a>    
<?php endif; ?>

</br>

<?php if (!empty($errorMessage)): ?>
    </br><b class="important"><?= $errorMessage ?></b></br>
<?php endif; ?>
<?php if($isYourPage == true) : ?>
    <?php include("view/addPost.php"); ?>
<?php endif; ?>

</br>

<?php foreach ($posts as $post){
    PostController::includeHeader($post);
    }?>

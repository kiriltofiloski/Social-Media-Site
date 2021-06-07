<!DOCTYPE html>

<meta charset="UTF-8" />
<title>MyArea Friends</title>
<link rel="stylesheet" type="text/css" href=<?= ASSETS_URL . "style.css"?> />

<h1>Friends</h1>

<div class="center">
<?php include("view/menu.php"); ?>
</div>

<h2>Friend requests</h2>

<ul>

    <?php foreach ($requests as $request): ?>
        <?php $friendInfo = UserDB::getUserInfo($request["fromUser"]);?>
        <li><a href="<?= BASE_URL . "personal?id=" . $request["fromUser"] ?>"> <?= $friendInfo["username"] ?> 
        <?= $friendInfo["firstName"] ?> <?= $friendInfo["lastName"] ?> <?= $friendInfo["gender"] ?></a></li>
    <?php endforeach; ?>

</ul>

<h2>Friend List</h2>

<ul>

    <?php foreach ($friends as $friend): ?>
        <?php if($friend != "blank") : ?>
            <?php $friendInfo = UserDB::getUserInfo($friend);?>
            <li><a href="<?= BASE_URL . "personal?id=" . $friend ?>"> <?= $friendInfo["username"] ?> 
            <?= $friendInfo["firstName"] ?> <?= $friendInfo["lastName"] ?> <?= $friendInfo["gender"] ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>

</ul>
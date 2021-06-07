<!DOCTYPE html>

<meta charset="UTF-8" />
<title>MyArea</title>
<link rel="stylesheet" type="text/css" href=<?= ASSETS_URL . "style.css"?> />

<div class="center">
<h1>Thank you for joining MyArea <?php echo $firstName;?>!</h1>
</div>
<div class="center">
<a href="<?= BASE_URL . "personal?id=" . $_SESSION["user"] ?>">Continue to personal page.</a>
</div>

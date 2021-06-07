<!DOCTYPE html>

<meta charset="UTF-8" />
<title>MyArea login</title>
<link rel="stylesheet" type="text/css" href=<?= ASSETS_URL . "style.css"?> />
<div class="center">
<h1>Welcome to MyArea!</h1>
</div>
<div class="center">
<div class="box">
<p>Please log in or register.</p>

<?php if (!empty($errorMessage)): ?>
    <b class="important"><?= $errorMessage ?></b>
<?php endif; ?>

<form action="<?= BASE_URL . $formAction ?>" method="post">
    <p>
        <label>Username: <input type="text" name="username" autocomplete="off" placeholder="Enter Username" 
            required autofocus /></label><br/>
        <label>Password: <input type="password" name="password" placeholder="Enter Password" required /></label>
    </p>
    <p><button>Log-in</button></p>
</form>
</div>
</br>
</div>
<div class="center">
<a href="<?= BASE_URL . "registerForm" ?>">Don't have an account? Register here!</a> </br>
<a href="<?= BASE_URL . "feed" ?>">Continue without logging in.</a>
</div>

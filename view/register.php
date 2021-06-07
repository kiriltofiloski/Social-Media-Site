<!DOCTYPE html>

<meta charset="UTF-8" />
<title>MyArea register</title>
<link rel="stylesheet" type="text/css" href=<?= ASSETS_URL . "style.css"?> />

<div class="center">
<h1>Register</h1>
</div>
<div class="center">
<div class="box">
<p>Please enter the required information bellow.</p>

<?php if (!empty($errorMessage)): ?>
    <p class="important"><?= $errorMessage ?></p>
<?php endif; ?>

<form action="<?= BASE_URL . $formAction ?>" method="post">
    <p>
        <label>Username: <input type="text" name="username" autocomplete="off" placeholder="Enter Username" 
            required autofocus /></label><br/>
        <label>Password: <input type="password" name="password" placeholder="Enter Password" required /></label><br>
        <label>First Name: <input type="text" name="fName" autocomplete="off" placeholder="John" 
            required autofocus /></label><br/>
        <label>Last Name: <input type="text" name="lName" autocomplete="off" placeholder="Doe" 
            required autofocus /></label><br/>
        <input type="radio" id="male" name="gender" value="M" required>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="F" required>
        <label for="female">Female</label><br>
    </p>
    <p><button>Register</button></p>
</form>
</div>
</br>
</div>
<div class="center">
<a href="<?= BASE_URL . "loginForm" ?>">Cancel</a>
</div>
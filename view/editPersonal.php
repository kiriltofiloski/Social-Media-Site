<!DOCTYPE html>

<meta charset="UTF-8" />
<title>MyArea</title>
<link rel="stylesheet" type="text/css" href=<?= ASSETS_URL . "style.css"?> />

<h1>Edit Personal</h1>

</br>

<div class="box">

<?php if (!empty($errorMessage)): ?>
    <p class="important"><?= $errorMessage ?></p>
<?php endif; ?>

<?php
    $themes = explode(",", $user["theme"]);
?>

<form action="<?= BASE_URL . $formAction ?>" method="post">
    <p>
        <label>First Name: <input type="text" name="fName" value="<?= $user["firstName"] ?>" autocomplete="off" placeholder="John" 
            required autofocus /></label><br/>
        <label>Last Name: <input type="text" name="lName" value="<?= $user["lastName"] ?>" autocomplete="off" placeholder="Doe" 
            required autofocus /></label><br/>
        <input type="radio" id="male" name="gender" value="M" required>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="F" required>
        <label for="female">Female</label><br>
        <label for="color1">Select your theme color 1:</label>
        <input type="color" id="color1" name="color1" value="<?=$themes[0]?>">
        <label for="color2">Select your theme color 2:</label>
        <input type="color" id="color2" name="color2" value="<?=$themes[1]?>">
    </p>
    <p><button>Save changes</button></p>
</form>
</div>
</br>
<a href="<?= BASE_URL . "personal?id=" . $_SESSION["user"] ?>">Cancel</a>
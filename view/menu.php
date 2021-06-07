<?php if (User::isLoggedIn()): ?>
    <p>
    <a href="<?= BASE_URL . "feed" ?>">News Feed</a>
    <a href="<?= BASE_URL . "personal?id=" . $_SESSION["user"] ?>">Personal page</a>
    <a href="<?= BASE_URL . "searchPage" ?>">Search for users!</a>
    <a href="<?= BASE_URL . "friends" ?>">Friends</a> 
    <a href="<?= BASE_URL . "logout" ?>">Logout</a>
    </p>
<?php else: ?>
    <p>
    <a href="<?= BASE_URL . "feed" ?>">News Feed</a> 
    <a href="<?= BASE_URL . "searchPage" ?>">Search for users!</a>
    <a href="<?= BASE_URL . "loginForm" ?>">Log in</a>
    </p>
<?php endif; ?>
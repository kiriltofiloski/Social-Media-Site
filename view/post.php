<div class="box" id="post"> 
<?php if ($post["postType"] == "img"): ?>
    <p><?php echo UserDB::getUsername($post["userID"])["username"]?> posted:</p>
    <b><?php echo $post["title"]?></b></br></br>
    <img src=<?= IMAGES_URL . $post["content"]?> alt="image" height="15%" width="50%"></br>
<?php else: ?>
    <p><?php echo UserDB::getUsername($post["userID"])["username"]?> posted:</p>
    <b><?php echo $post["title"]?></b>
    <p><?php echo $post["content"]?></p>
<?php endif; ?>
<?php if(User::isLoggedIn() && $post["userID"] == $_SESSION["user"]) : ?>
    <a href="<?= BASE_URL . "post/delete?id=" . $post["postID"] ?>">Delete Post</a>    
<?php endif; ?>
</div>
</br>
</br>
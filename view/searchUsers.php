<!DOCTYPE html>

<meta charset="UTF-8" />
<title>MyArea Search</title>
<link rel="stylesheet" type="text/css" href=<?= ASSETS_URL . "style.css"?> />

<div class="center">
<h1>User search</h1>

</br>

<?php include("view/menu.php"); ?>

</br>

<label id="loneLabel">Search: <input id="search-field" type="text" name="query" autocomplete="off" autofocus /></label>

</br>

<ul id="user-hits"></ul>

</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#search-field").keyup(function(){
        $("#user-hits").empty();
        q = $(this).val();
        console.log(q);
        $.get("<?= BASE_URL . "search?query="?>" + q,
        function (data) {
                for(i of data){
                    $("#user-hits").append("<li>" + "<a href=<?= BASE_URL . "personal?id="?>" + i.userID + ">" + i.username + " " + i.firstName + " " + i.lastName + " " + i.gender + "</a></li>");
                }
            }
        );
    });
});
</script>
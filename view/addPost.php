<div class="center" id="addPost">
<div class="box">
<h3>Add post</h3>

<form action="<?= BASE_URL . "postAction" ?>" method="post" id="postForm" enctype="multipart/form-data">
    <p>
        <label>Title: <input type="text" name="title" autocomplete="off" placeholder="Enter title" 
            required /></label><br/>
        <input type="radio" id="text" name="contentType" value="text" required>
        <label for="text">Text</label>
        <input type="radio" id="img" name="contentType" value="img" required checked>
        <label for="img">Image</label><br>
        <input type="radio" id="public" name="postStatus" value="public" required>
        <label for="public">Public</label>
        <input type="radio" id="private" name="postStatus" value="private" required checked>
        <label for="private">Private(Only friends)</label><br>
        <label id="label" for="myImage">Choose an image:</label>
        <input type="file" id="myImage" name="myImage" required>
        <textarea name="myText" id="myText" form="postForm" rows="7" cols="100" placeholder="Write something..." required></textarea>
    </p>
    <p><button>Post</button></p>
</form>
</div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript">
$("#myText").hide();
$('#postForm input').on('change', function() {
   let checkedButton = $('input[name=contentType]:checked', '#postForm').val();
   if(checkedButton == "text"){
       $("#myImage").hide();
       $("#myText").show();
       $("#label").hide();
       document.getElementById("myImage").required = false;
       document.getElementById("myText").required = true;
   }
   else{
       $("#myImage").show();
       $("#myText").hide();
       $("#label").show();
       document.getElementById("myImage").required = true;
       document.getElementById("myText").required = false;
   }
});
</script>
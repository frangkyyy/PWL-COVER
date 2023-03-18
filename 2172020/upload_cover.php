<?php
$editedISBN = filter_input(INPUT_GET, 'isbn');
if(isset($editedISBN)){
    $book = fetchOneBook($editedISBN);
    $bookgenre = fetchOneBookName($editedISBN);
}
$uploadRequest = filter_input(INPUT_POST, 'btnUpload');
if (isset($uploadRequest)) {
    $fileExtension = pathinfo($_FILES['imageFile']['name'], PATHINFO_EXTENSION);
    $fileName = $book['isbn'];
    $targetDirectory = 'uploads/';
    $file = $fileName . '.' . $fileExtension;
    $pathToUpload = $targetDirectory . $file;
    if ($_FILES['imageFile']['size'] > 1024*2048){
        echo '<div>File size exceed 2MB. Please choose another file.</div>';
    } else{
        move_uploaded_file($_FILES['imageFile']['tmp_name'], $pathToUpload);
        $book = "UPDATE book SET Cover='".$file."' WHERE Cover IS NULL";
    }
}

    echo"<div>Current Cover</div>";
    if (is_null($book['Cover'])) {
        $url = '<img class="img-tbl" src="uploads/ComingSoon.PNG"></img>';
      }
      else {
        $url = '<img class="img-tbl" src="uploads/'. $book['Cover'].'"></img>';
      }
    echo $url;
    ?>
    <br>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="imageFile" accept="image/*" class="form-control">
        <br>
        <div>
            <input type="submit" name="btnUpload" value="Upload Image" class="btn btn-primary">
        </div>
    </form>
</div>

<?php
$editedIsbn = filter_input(INPUT_GET, 'isbn');
if (isset($editedIsbn)) {
    $book = fetchOneBook($editedIsbn);
    $genreName = fetchOneBookName($editedIsbn);
}
$uploadRequest = filter_input(INPUT_POST, 'btnUpload');
if(isset($uploadRequest)){
    $fileName = filter_input(INPUT_POST, 'txtName');
    $targetDirectory = 'uploads/';
    $fileExtension = pathinfo($_FILES['imageFile']['name'],PATHINFO_EXTENSION);
    $pathToUpload = $targetDirectory . $fileName . '.' . $fileExtension;
    if($_FILES['imageFile']['size']>1024*2048){
        echo '<div> File size exceed 2MB. Please choose another file.</div>';
    } else{
        move_uploaded_file($_FILES['imageFile']['tmp_name'], $pathToUpload);
    }
}
echo"<div>Current Cover</div>";
if(is_null($book['cover'])){
    $url = '<img class="img-tbl" src="upload/comingsoon.jpeg" width="150" height="150"></img>';
} else{
    $url = '<img class="img-tbl" src="upload/"'. $book["cover"].'"></img>';
}
echo $url;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script scr="js/bootstrap.js"></script>
    <title>Upload File</title>
</head>
<body>
<div>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="imageFile" accept="image/*" class="form-control">
        <input type="submit" name="btnUpload" value="Upload Image" class="btn btn-primary">
    </form>
</div>
</body>
</html>
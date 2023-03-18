<?php
$uploadRequest = filter_input(INPUT_POST, 'btnUpload');
if (isset($uploadRequest)) {
    $fileName = filter_input(INPUT_POST, 'txtName');
    $targetDirectory = 'uploads/';
    $fileExtension = pathinfo($_FILES['imageFile']['name'], PATHINFO_EXTENSION);
    $pathToUpload = $targetDirectory . $fileName . '.' . $fileExtension;
    if ($_FILES['imageFile']['size'] > 1024*2048){
        echo '<div>File size exceed 2MB. Please choose another file.</div>';
    } else{
        move_uploaded_file($_FILES['imageFile']['tmp_name'], $pathToUpload);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
<body>
<br>
<div class="container">
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="txtName" placeholder="File Name" class="form-control">
        <input type="file" name="imageFile" accept="image/*" class="form-control">
        <br>
        <div>
            <input type="submit" name="btnUpload" value="Upload Image" class="btn btn-primary">
        </div>
    </form>
</div>
</body>
</html>

<?php
$update= filter_input(INPUT_GET, 'genreID');
if(isset($update)){
    $link = createMySQLConnection();
    $query = "SELECT * FROM genre WHERE Id=?";
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $update);
    $stmt->execute();
    $result = $stmt->fetch();
    $link = null;
}

$updatePressed = filter_input(INPUT_POST, 'btnUpdateGenre');
if(isset($updatePressed)){
    $name = filter_input(INPUT_POST, 'genreUpdate');
    $link = createMySQLConnection();
    $query = 'UPDATE genre SET name = ? WHERE Id = ?';
    $stmt = $link -> prepare($query);
    $stmt -> bindParam(1, $name);
    $stmt -> bindParam(2, $result['Id']);
    $link -> beginTransaction();
    if ($stmt -> execute()) {
        $link -> commit();
    } else {
        $link -> rollBack();
    }
    $link = null;
    header("location:index.php?menu=genre");
}
?>

<form method="post">
    <div>
        <label for="upd" class="col-sm-2 col-form-label">Genre</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" name="genreUpdate" id="upd" value="<?php echo $result['name']; ?>">
        </div><br>
    <div>
        <input type="submit" class="btn btn-primary col-sm-2" value="Save Updated Genre" name="btnUpdateGenre">
    </div>
</form>

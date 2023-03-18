<?php
$link = createMySQLConnection();
$query = 'SELECT id, name FROM genre ';
$stmt = $link -> prepare($query);
$stmt->execute();
$result = $stmt -> fetchAll();
$link = null;
?>

<form method="post">
    <div>
        <label for="txtGenre" class="col-sm-2 col-form-label">Genre</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" autofocus name="txtGenre" 
            id="txtGenre" placeholder="Book Genre" class="form-control">
        </div>
    <div><br>
    <div>
        <input type="submit" class="btn btn-primary col-sm-2" value="Save Genre" name="btnSaveGenre">
    </div><br>
</form>
<table id="dttable"> 
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($result as $genre){
            echo '<tr>';
            echo '<td>'. $genre['id'] . '</td>';
            echo '<td>'. $genre['name'] . '</td>';
            echo '<td><button onclick = "return updateValue('. $genre['id'] . ')">Update</button>
            <button onclick = "return deleteValue('. $genre['id'] . ')">Delete</button></td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<?php
    $submitPressed = filter_input(INPUT_POST, 'btnSaveGenre');
    if(isset($submitPressed)){
        $name = filter_input(INPUT_POST, 'txtGenre');
        $link = createMySQLConnection();
        $query = 'INSERT INTO genre(Id, name) VALUES(null, ?)';
        $stmt = $link -> prepare($query);
        $stmt -> bindParam(1, $name);
        $link -> beginTransaction();
        if ($stmt -> execute()) {
            $link -> commit();
            header("location:index.php?menu=genre");
        } else {
            $link -> rollBack();
        }
        $link = null;
    }

    $delete = filter_input(INPUT_GET, 'cmd');
    if(isset($delete) && $delete == 'del'){
        $genreID = filter_input(INPUT_GET, 'genreID');
        if(isset($genreID)){
            $link = createMySQLConnection();
            $query = "DELETE FROM genre WHERE Id = ?";
            $stmt = $link->prepare($query);
            $stmt->bindParam(1, $genreID);
            $link->beginTransaction();
            if($stmt->execute()){
                $link->commit();
            } else{
                $link->rollBack();
            }
            $link = null;
            header("location:index.php?menu=genre");
        }
    }
?>

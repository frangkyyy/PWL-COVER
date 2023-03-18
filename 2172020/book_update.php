<?php
$editedISBN = filter_input(INPUT_GET, 'isbn');
if(isset($editedISBN)){
    $book = fetchOneBook($editedISBN);
    $bookgenre = fetchOneBookName($editedISBN);
}

    ?>
<form method="post">
    <div>
        <label for="txtIsbn" class="col-sm-2 col-form-label">ISBN</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtIsbn" 
            id="txtIsbn" placeholder="Book ISBN" class="form-control" value="<?php echo $book['isbn']; ?>">
        </div>
    <div>
        <label for="txtTitle" class="col-sm-2 col-form-label">Title</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtTitle" 
            id="txtTitle" placeholder="Book Title" class="form-control" value="<?php echo $book['Title']; ?>">
        </div>
    </div>
    <div>
        <label for="txtAuthor" class="col-sm-2 col-form-label">Author</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtAuthor" 
            id="txtAuthor" placeholder="Book Author" class="form-control" value="<?php echo $book['Author']; ?>">
        </div>
    </div>
    <div>
        <label for="txtPublisher" class="col-sm-2 col-form-label">Publisher</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtPublisher" 
            id="txtPublisher" placeholder="Book Publisher" class="form-control" value="<?php echo $book['Publisher']; ?>">
        </div>
    </div>
    <div>
        <label for="txtYear" class="col-sm-2 col-form-label">Publish Year</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtYear" 
            id="txtPublisher" placeholder="Book Published Year" class="form-control" value="<?php echo $book['Publish_Year']; ?>">
        </div>
    </div>
    <div>
        <label for="txtDesc" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
        <textarea maxlength="300" rows="5" cols="30" placeholder="Book Description" 
            class="form-control" name="txtDesc"><?php echo $book['Short_Description']; ?></textarea value="">
        </div>
    </div>
    <div>
        <label for="comboGenre" class="col-sm-2 col-form-label">Genre</label>
        <div class="col-sm-10">
            <select class="form-control" id="comboGenre" name="comboGenre">
                <option value="<?php echo $book['genre_id']; ?>" selected><?php echo $bookgenre['name'];?></option>;
                <?php
                $result = fetchGenre();
                foreach($result as $genre){
                    echo '<option value ="'.$genre['Id'].'">'.$genre['name'].'</option>';
                }
                ?>
            </select>
        </div>
    </div><br>
    <div>
        <input type="submit" class="btn btn-primary col-sm-2" value="Update Book" name="btnUpdateBook">
    </div>
    <?php
    $updatePressed = filter_input(INPUT_POST, 'btnUpdateBook');
    if(isset($updatePressed)){
        $isbn = filter_input(INPUT_POST, 'txtIsbn');
        $title = filter_input(INPUT_POST, 'txtTitle');
        $author = filter_input(INPUT_POST, 'txtAuthor');
        $publisher = filter_input(INPUT_POST, 'txtPublisher');
        $year = filter_input(INPUT_POST, 'txtYear');
        $description = filter_input(INPUT_POST, 'txtDesc');
        $Id = filter_input(INPUT_POST, 'comboGenre');
        $link = createMySQLConnection();
        $query = 'UPDATE book SET isbn = ?, title = ?, author = ?, 
        publisher = ?, publish_year = ?, short_description = ?, genre_id = ?)';
        $link -> beginTransaction();
        $stmt = $link -> prepare($query);
        $stmt -> bindParam(1, $isbn);
        $stmt -> bindParam(2, $title);
        $stmt -> bindParam(3, $author);
        $stmt -> bindParam(4, $publisher);
        $stmt -> bindParam(5, $year);
        $stmt -> bindParam(6, $description);
        $stmt -> bindParam(7, $Id);
        if ($stmt -> execute()) {
            $link -> commit();
        } else {
            $link -> rollBack();
        }
        $result = $stmt -> fetch();
        $link = null;
        header("location:index.php?menu=book");
        return $result;
    
    }
    ?>
</form>
<br><br>
<?php
    include_once 'upload_cover.php';
    ?>

<?php
$link = createMySQLConnection();
$query = 'SELECT cover, isbn, title, author, publisher, publish_year, name FROM book INNER JOIN genre ON book.genre_id = genre.Id';
$stmt = $link -> prepare($query);
$stmt->execute();
$result = $stmt -> fetchAll();
$link = null;
?>
<table id="dttable">
    <thead>
        <tr>
            <th>COVER</th>
            <th>ISBN</th>
            <th>TITLE</th>
            <th>AUTHOR</th> 
            <th>PUBLISHER</th>
            <th>PUBLISH YEAR</th>
            <th>GENRE</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $link = createMySQLConnection();
        $query = 'SELECT cover, isbn, title, author, publisher, publish_year, name FROM book INNER JOIN genre ON book.genre_id = genre.Id';
        $stmt = $link -> prepare($query);
        $stmt->execute();
        $result = $stmt -> fetchAll();
        $link = null;
        foreach ($result as $book){
            echo '<tr>';
            if (is_null($book['cover'])) {
                $url = '<img class="img-tbl" src="uploads/ComingSoon.PNG"></img>';
              }
              else {
                $url = '<img class="img-tbl" src="uploads/'. $book['cover'].'"></img>';
              }
            echo '<td>'. $url .'</td>';
            echo '<td>'. $book['isbn'] . '</td>';
            echo '<td>'. $book['title'] . '</td>';
            echo '<td>'. $book['author'] . '</td>';
            echo '<td>'. $book['publisher'] . '</td>';
            echo '<td>'. $book['publish_year'] . '</td>';
            echo '<td>'. $book['name'] . '</td>';
            echo '<td>
            <button onclick="return bookCov(\''.$book['isbn'],'\')">Change Cover</button>
            <button onclick="return updateBook(\''.$book['isbn'],'\')">Update</button>
            <button onclick="return deleteBook(\''.$book['isbn'],'\')">Delete</button>
            </td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>
<form method="post">
    <div>
        <label for="txtIsbn" class="col-sm-2 col-form-label">ISBN</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtIsbn" 
            id="txtIsbn" placeholder="Book ISBN" class="form-control">
        </div>
    <div>
        <label for="txtTitle" class="col-sm-2 col-form-label">Title</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtTitle" 
            id="txtTitle" placeholder="Book Title" class="form-control">
        </div>
    </div>
    <div>
        <label for="txtAuthor" class="col-sm-2 col-form-label">Author</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtAuthor" 
            id="txtAuthor" placeholder="Book Author" class="form-control">
        </div>
    </div>
    <div>
        <label for="txtPublisher" class="col-sm-2 col-form-label">Publisher</label>
        <div class="col-sm-10">
            <input type="text" maxlength="100" required autofocus name="txtPublisher" 
            id="txtPublisher" placeholder="Book Publisher" class="form-control">
        </div>
    </div>
    <div>
        <label for="txtYear" class="col-sm-2 col-form-label">Publish Year</label>
        <div class="col-sm-10">
            <input type="year" maxlength="100" required autofocus name="txtYear" 
            id="txtPublisher" placeholder="Book Published Year" class="form-control">
        </div>
    </div>
    <div>
        <label for="txtDesc" class="col-sm-2 col-form-label">Description</label>
        <div class="col-sm-10">
            <textarea maxlength="300" rows="5" cols="30" placeholder="Book Description" 
            class="form-control" name="txtDesc"></textarea>
        </div>
    </div>
    <div>
        <label for="comboGenre" class="col-sm-2 col-form-label">Genre</label>
        <div class="col-sm-10">
            <select class="form-control" id="comboGenre" name="comboGenre">
                <option> -- Select your Genre -- </option>
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
        <input type="submit" class="btn btn-primary col-sm-2" value="Save Book" name="btnSaveBook">
    </div>
    <?php
    $submitPressed = filter_input(INPUT_POST, 'btnSaveBook');
    if(isset($submitPressed)){
        $link = createMySQLConnection();
        $isbn = filter_input(INPUT_POST, 'txtIsbn');
        $title = filter_input(INPUT_POST, 'txtTitle');
        $author = filter_input(INPUT_POST, 'txtAuthor');
        $publisher = filter_input(INPUT_POST, 'txtPublisher');
        $year = filter_input(INPUT_POST, 'txtYear');
        $description = filter_input(INPUT_POST, 'txtDesc');
        $Id = filter_input(INPUT_POST, 'comboGenre');
        $link -> beginTransaction();
        $query = 'INSERT INTO book(isbn, title, author, publisher, publish_year, short_description, genre_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = $link -> prepare($query);
        $stmt -> bindParam(1, $isbn);
        $stmt -> bindParam(2, $title);
        $stmt -> bindParam(3, $author);
        $stmt -> bindParam(4, $publisher);
        $stmt -> bindParam(5, $year);
        $stmt -> bindParam(6, $description);
        $stmt -> bindParam(7, $Id);
        if($stmt -> execute()) {
            $link->commit();
        }
        $result = $stmt -> fetch();
        $link = null;
        return $result;
    }


    $delete = filter_input(INPUT_GET, 'cmd');
    if(isset($delete) && $delete == 'del'){
        $isbn = filter_input(INPUT_GET, 'isbn');
        if(isset($isbn)){
            $link = createMySQLConnection();
            $query = "DELETE FROM book WHERE isbn = ?";
            $stmt = $link->prepare($query);
            $stmt->bindParam(1, $isbn);
            $link->beginTransaction();
            if($stmt->execute()){
                $link->commit();
            } else{
                $link->rollBack();
            }
            $link = null;
        };
    }
?>
</form>
<?php
$deleteCommand = filter_input(INPUT_GET, 'cmd');
if(isset($deleteCommand) && $deleteCommand == 'del'){
    $bookId=filter_input(INPUT_GET, 'bid');
    $result =deleteBookFromDb($bookId);
    if($result){
        echo '<div>Data sucessfully removed</div>';
    }else{
        echo '<div>Failed to remove data</div>'; 
    }
}

$submitPressed = filter_input(INPUT_POST, "btnSaveBook");
if (isset($submitPressed))
{
    $isbn = filter_input(INPUT_POST, "txtIsbn");
    $title = filter_input(INPUT_POST, "txtTitle");
    $author = filter_input(INPUT_POST, "txtAuthor");
    $publisher = filter_input(INPUT_POST, "txtPublisher");
    $year = filter_input(INPUT_POST, "txtYear");
    $genreId = filter_input(INPUT_POST, "comboGenre");
    #$cover = filter_input (INPUT_POST, 'cover');
    if (trim($isbn) == '' || trim($title) == '' || trim($author) == '' || trim($publisher) == '' || trim($year) == '' 
    || trim($genreId) == '') {
        echo '<div> Please provide with a valid data for book </div>';
    } else {
        $result = addNewBook($isbn, $title, $author, $publisher, $year, $genreId);
        if ($result){
            echo '<div> Data successfully added </div>';
        }else{
            echo '<div> Failed to add data</div>';
        }
    }
}
?>

<table>
<form method="post">
    <tr>
        <td><label for="txtName">ISBN : </label></td>
        <td><input type="text" maxlength="45" id="txtIsbn" name="txtIsbn" required autofocus placeholder="isbn"></td>
    </tr>
    <tr>
        <td><label for="txtName">Title : </label></td>
        <td><input type="text" maxlength="45" id="txtTitle" name="txtTitle" required autofocus placeholder="title"></td>    
    </tr>
    <tr>
        <td><label for="txtName">Author : </label></td>
        <td><input type="text" maxlength="45" id="txtAuthor" name="txtAuthor" required autofocus placeholder="author"></td>
    </tr>
    <tr>
        <td><label for="txtName">Publisher : </label></td>
        <td><input type="text" maxlength="45" id="txtPublisher" name="txtPublisher" required autofocus placeholder="publisher"></td>
    </tr>
    <tr>
        <td><label for="txtName">Publish Year : </label></td>
        <td><input type="year" id="txtYear" name="txtYear" required autofocus placeholder="publish year"></td>
    </tr>
    <tr>
        <td><label for="comboGenre">Genre : </label></td>
        <td><select name="comboGenre" id="comboGenre">
        <option value="">--Select your Genre--</option>
        <?php
        $result = fetchGenreFromDb();
        foreach($result as $genre) {
            echo '<option value= "'. $genre['id'] .'">'. $genre['name'].' </option>';
        }
        ?>
    </select></td>
    </tr>
    <input type="submit" name="btnSaveBook" value="Save Book">     
</form>
</table>

<h3>Book Data</h3>
<table class="content-table" id="dttable">
    <thead>
    <tr>
        <th>COVER</th>
        <th>ISBN</th>
        <th>TITLE</th>
        <th>AUTHOR</th>
        <th>PUBLISHER</th>
        <th>PUBLISH YEAR</th>
        <th>GENRE NAME</th>
        <th>ACTION</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $result = fetchBookFromDb();
    foreach ($result as $book){ 
        echo '<tr>';
        echo '<td><img src="uploads/default-cover . png" width="150" height="150"></td>';
        echo '<td>'. $book['isbn'] . '</td>';
        echo '<td>'. $book['title'] . '</td>';
        echo '<td>'. $book['author'] . '</td>';
        echo '<td>'. $book['publisher'] . '</td>';
        echo '<td>'. $book['publish_year'] . '</td>';
        echo '<td>'. $book['name'] . '</td>'; 
        echo '<td>
        <button onclick = "editBook('. $book['isbn'] . ')" 
        class=""> Edit Data </button>
        <button onclick = "deleteBook('. $book['isbn'] . ')" 
        class=""> Delete Data </button>
        <button class=""> Add Cover </button>
        </td>';
        echo '</tr>';     
    }
    ?>
    </tbody>
</table>

<script src="js/genre_index.js"></script>
<script>
$(document).ready(function () {
    $('#dttable').DataTable();
}); 
</script>
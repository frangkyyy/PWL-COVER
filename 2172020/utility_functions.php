<?php
function createMySQLConnection() {
    $link = new PDO('mysql:host=localhost;dbname=mydb', 'root', '');
    $link->setAttribute(PDO::ATTR_AUTOCOMMIT, false);
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $link;
}


function closeConnection(PDO $link){
    if ($link != null) {
        $link = null;
    }
}

function login($email, $password){
    $link = createMySQLConnection();
    $query = "SELECT id, name, email FROM user WHERE email = ? AND password = MD5(?)";
    $stmt = $link->prepare($query);
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $password);
    $stmt->execute();
    $user = $stmt->fetch();
    $link = null;
    return $user;
}

function deleteBook($isbn){
    $result = 0;
    $command = filter_input(INPUT_GET, 'cmd');
    if(isset($command) && $command == 'del'){
        $link = createMySQLConnection();
        $link->beginTransaction();
        $query='DELETE FROM book WHERE isbn = ?';
        $stmt = $link->prepare($query);
        $stmt->bindParam(1, $isbn);
        if($stmt->execute()){
            $link->commit();
            $result=1;
        } else{
            $link -> rollBack();
        }
    }
    $link = null;
    return $result;
}

function fetchOneBook($isbn){
    $link = createMySQLConnection();
    $query = 'SELECT * FROM book WHERE isbn=?';
    $stmt = $link->prepare($query);
    $stmt->bindParam(1,$isbn);
    $stmt->execute();
    $results = $stmt->fetch();
    $link = null;
    return $results;
}

function fetchOneBookName($isbn){
    $link = createMySQLConnection();
    $query = 'SELECT name FROM book INNER JOIN genre 
    ON book.genre_id = genre.id WHERE isbn=?';
    $stmt = $link->prepare($query);
    $stmt->bindParam(1,$isbn);
    $stmt->execute();
    $results = $stmt->fetch();
    $link = null;
    return $results;
}

function fetchGenre(){
    $link = createMySQLConnection();
    $query = 'SELECT Id, name FROM genre';
    $stmt = $link -> prepare($query);
    $stmt->execute();
    $result = $stmt -> fetchAll();
    $link = null;
    return $result;
}

?>


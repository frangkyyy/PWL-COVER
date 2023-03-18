// 2172020 ( Nicholas Christopher Rudy ) 
// 2172036 ( Frangky Hernandez )
// 2172039 ( Rizky Jeremia Simanjuntak ) 

<?php
session_start();
include_once 'utility_functions.php';
if(!isset($_SESSION['is_user_logged'])) {
    $_SESSION['is_user_logged'] = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INDEX</title>
    <script src="command_script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href ="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="page">
    <?php
        if($_SESSION['is_user_logged']) {
    ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <ul>
                    <a href="?menu=home">Home &nbsp</a>
                    <a href="?menu=genre">Genre &nbsp</a>
                    <a href="?menu=book">Book &nbsp</a>
                    <a href="?menu=upload">Upload &nbsp</a>
                    <a href="?menu=logout">Logout &nbsp</a>
                <ul>
            </div>
        </div>
    </nav>
    <?php
    $menu = filter_input(INPUT_GET, 'menu');
    switch ($menu) {
        case 'home':
            include_once 'home.php';
            break;
        case 'genre':
            include_once 'genre.php';
            break;
        case 'book':
            include_once 'book.php';
            break;
        case 'upload':
            include_once 'index2.php';
            break;
        case 'upd':
            include_once 'genre_update.php';
            break;
        case 'updBook':
            include_once 'book_update.php';
            break;
        case 'updBookCov':
            include_once 'upload_cover.php';
            break;
        case 'editBook':
            include_once 'book_update.php';
            break;
        case 'logout':
            session_unset();
            session_destroy();
            header('location:index.php');
            break;
        default:
            include_once 'home.php';
        
    }
    ?>
</div>
<?php
} else{
        include_once 'login.php'; 
    }
?>
<script>
$(document).ready(function () {
    $('#dttable').DataTable();
}); 
</script>
</body>
</html>

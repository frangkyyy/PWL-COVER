function coverBook(isbn){
    window.location = "index.php?menu=upload_cover&isbn=" + isbn;
}

function editBook(isbn){
    window.location = "index.php?menu=book_edit&isbn=" + isbn;
}

function deleteBook(isbn){
    const confirmation = window.confirm("are u sure want to delete"+
        "this data?");
    if(confirmation){
        window.location = "index.php?menu=book&cmd=del&isbn=" + isbn;
    }
}

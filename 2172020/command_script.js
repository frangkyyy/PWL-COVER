
//Genre
function updateValue(id) {
    window.location = "index.php?menu=upd&genreID=" + id;
    return false;
}

function deleteValue(id) {
    let confirmation = window.confirm("Are you sure you want to delete this data?")
    if(confirmation) {
        window.location = "index.php?menu=genre&cmd=del&genreID=" + id;
        return false;
    }
}


//Book
function updateBook(isbn) {
    window.location = "index.php?menu=updBook&isbn=" + isbn;
    return false;
}

function bookCov(isbn){
    window.location = "index.php?menu=updBookCov&isbn=" + isbn;
    return false;
}
function deleteBook(isbn) {
    let confirmation = window.confirm("Are you sure you want to delete this data?")
    if(confirmation) {
        window.location = "index.php?menu=book&cmd=del&isbn=" + isbn;
        return false;
    }
}

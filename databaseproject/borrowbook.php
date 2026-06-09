<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

if(isset($_POST['borrow_book']))
{
    $book_id = $_POST['book_id'];
    $member_code = $_POST['member_code'];
    $due_date = $_POST['due_date'];

    $member_sql = "
    SELECT *
    FROM members
    WHERE member_code = '$member_code'
    ";

    $member_result = mysqli_query($conn,$member_sql);

    if(mysqli_num_rows($member_result) > 0)
    {
        $member = mysqli_fetch_assoc($member_result);

        $member_id = $member['member_id'];

        $book_sql = "
        SELECT *
        FROM books
        WHERE book_id='$book_id'
        ";

        $book_result = mysqli_query($conn,$book_sql);

        $book = mysqli_fetch_assoc($book_result);

        if($book['available_copies'] > 0)
        {
            $sql = "
            INSERT INTO borrowings
            (
                borrow_date,
                due_date,
                status,
                member_id,
                book_id
            )
            VALUES
            (
                CURDATE(),
                '$due_date',
                'Borrowed',
                '$member_id',
                '$book_id'
            )
            ";

            mysqli_query($conn,$sql);

            $sql = "
            UPDATE books
            SET available_copies = available_copies - 1
            WHERE book_id='$book_id'
            ";

            mysqli_query($conn,$sql);

            echo "<h3>Book Borrowed Successfully</h3>";
        }
        else
        {
            echo "<h3>No Available Copies</h3>";
        }
    }
    else
    {
        echo "<h3>Member Code Not Found</h3>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Borrow Books</title>
</head>

<body>

<h1>Borrow Book</h1>

<form method="GET">

    <label>Search Book</label>
    <br>

    <input
    type="text"
    name="search"
    placeholder="Book ID, ISBN or Title"
    required>

    <button type="submit">
        Search Book
    </button>

</form>

<br><hr><br>

<?php

if(isset($_GET['search']))
{
    $search = $_GET['search'];

    $sql = "
    SELECT
        b.book_id,
        b.title,
        b.isbn,
        b.publication_year,
        b.available_copies,
        a.author_name,
        c.category_name,
        p.publisher_name

    FROM books b

    INNER JOIN authors a
    ON b.author_id = a.author_id

    INNER JOIN categories c
    ON b.category_id = c.category_id

    INNER JOIN publishers p
    ON b.publisher_id = p.publisher_id

    WHERE
        b.book_id = '$search'
        OR b.isbn = '$search'
        OR b.title LIKE '%$search%'
    ";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $book = mysqli_fetch_assoc($result);
?>

<h2>Book Information</h2>

<table border="1">

<tr>
    <td>Book ID</td>
    <td><?php echo $book['book_id']; ?></td>
</tr>

<tr>
    <td>Title</td>
    <td><?php echo $book['title']; ?></td>
</tr>

<tr>
    <td>ISBN</td>
    <td><?php echo $book['isbn']; ?></td>
</tr>

<tr>
    <td>Publication Year</td>
    <td><?php echo $book['publication_year']; ?></td>
</tr>

<tr>
    <td>Author</td>
    <td><?php echo $book['author_name']; ?></td>
</tr>

<tr>
    <td>Category</td>
    <td><?php echo $book['category_name']; ?></td>
</tr>

<tr>
    <td>Publisher</td>
    <td><?php echo $book['publisher_name']; ?></td>
</tr>

<tr>
    <td>Available Copies</td>
    <td><?php echo $book['available_copies']; ?></td>
</tr>

</table>

<br>

<form method="POST">

    <input
    type="hidden"
    name="book_id"
    value="<?php echo $book['book_id']; ?>">

    <label>Member Code</label>
    <br>

    <input
    type="text"
    name="member_code"
    placeholder="M000001"
    required>

    <br><br>

    <label>Due Date</label>
    <br>

    <input
    type="date"
    name="due_date"
    required>

    <br><br>

    <button
    type="submit"
    name="borrow_book">

    Borrow Book

    </button>

</form>

<?php
    }
    else
    {
        echo "<h3>Book Not Found</h3>";
    }
}
?>

</body>
</html>


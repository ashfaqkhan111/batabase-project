
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$book = null;

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

            mysqli_query(
                $conn,
                "UPDATE books
                 SET available_copies = available_copies - 1
                 WHERE book_id='$book_id'"
            );

            echo "<h3 class='success-message'>Book Borrowed Successfully</h3>";
        }
        else
        {
            echo "<h3 class='error-message'>No Available Copies</h3>";
        }
    }
    else
    {
        echo "<h3 class='error-message'>Member Code Not Found</h3>";
    }
}

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
    }
    else
    {
        echo "<h3 class='error-message'>Book Not Found</h3>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Borrow Books</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/pagespec.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tables.css">
</head>

<body>

<div class="content">

    <div class="form-box">

        <h2>Search Book</h2>

        <form method="GET">

            <input
            type="text"
            name="search"
            placeholder="Book ID, ISBN or Title"
            required>

            <button type="submit">
                Search Book
            </button>

        </form>

    </div>

    <div class="form-box">

        <h2>Borrow Book</h2>

        <form method="POST">

            <input
            type="hidden"
            name="book_id"
            value="<?php echo $book ? $book['book_id'] : ''; ?>">

            <table>

                <tr>
                    <td><strong>Book ID</strong></td>
                    <td><?php echo $book ? $book['book_id'] : '-'; ?></td>
                </tr>

                <tr>
                    <td><strong>Title</strong></td>
                    <td><?php echo $book ? $book['title'] : '-'; ?></td>
                </tr>

                <tr>
                    <td><strong>ISBN</strong></td>
                    <td><?php echo $book ? $book['isbn'] : '-'; ?></td>
                </tr>

                <tr>
                    <td><strong>Publication Year</strong></td>
                    <td><?php echo $book ? $book['publication_year'] : '-'; ?></td>
                </tr>

                <tr>
                    <td><strong>Author</strong></td>
                    <td><?php echo $book ? $book['author_name'] : '-'; ?></td>
                </tr>

                <tr>
                    <td><strong>Category</strong></td>
                    <td><?php echo $book ? $book['category_name'] : '-'; ?></td>
                </tr>

                <tr>
                    <td><strong>Publisher</strong></td>
                    <td><?php echo $book ? $book['publisher_name'] : '-'; ?></td>
                </tr>

                <tr>
                    <td><strong>Available Copies</strong></td>
                    <td><?php echo $book ? $book['available_copies'] : '-'; ?></td>
                </tr>

            </table>

            <hr>

            <label>Member Code</label>

            <input
            type="text"
            name="member_code"
            placeholder="M000001"
            required>

            <label>Due Date</label>

            <input
            type="date"
            name="due_date"
            required>

            <button
            type="submit"
            name="borrow_book"
            <?php if(!$book) echo "disabled"; ?>>

                Borrow Book

            </button>

        </form>

    </div>

</div>

</body>
</html>


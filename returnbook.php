<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';



if(isset($_POST['return_book']))
{
    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];

    $borrow_query = mysqli_query(
        $conn,
        "
        SELECT *
        FROM borrowings
        WHERE borrow_id='$borrow_id'
        "
    );

    $borrow = mysqli_fetch_assoc($borrow_query);

    mysqli_query(
        $conn,
        "
        UPDATE borrowings
        SET
            status='Returned',
            return_date=CURDATE()
        WHERE borrow_id='$borrow_id'
        "
    );

    mysqli_query(
        $conn,
        "
        UPDATE books
        SET available_copies = available_copies + 1
        WHERE book_id='$book_id'
        "
    );

    $due_date = strtotime($borrow['due_date']);
    $today = strtotime(date('Y-m-d'));

    if($today > $due_date)
    {
        $days_late =
        ($today - $due_date) / (60 * 60 * 24);

        $fine_amount = $days_late * 1;

        $check = mysqli_query(
            $conn,
            "
            SELECT *
            FROM fines
            WHERE borrow_id='$borrow_id'
            "
        );

        if(mysqli_num_rows($check) == 0)
        {
            mysqli_query(
                $conn,
                "
                INSERT INTO fines
                (
                    borrow_id,
                    amount,
                    paid_status
                )
                VALUES
                (
                    '$borrow_id',
                    '$fine_amount',
                    'Unpaid'
                )
                "
            );
        }

        $message =
        "Book Returned Successfully | Fine Created: $fine_amount";
    }
    else
    {
        $message =
        "Book Returned Successfully | No Fine Applied";
    }
}



if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = $_GET['search'];

    $sql = "
    SELECT
        br.borrow_id,
        m.member_code,
        m.member_name,
        b.book_id,
        b.title,
        b.isbn,
        br.borrow_date,
        br.due_date

    FROM borrowings br

    INNER JOIN members m
    ON br.member_id = m.member_id

    INNER JOIN books b
    ON br.book_id = b.book_id

    WHERE
        br.status='Borrowed'
        AND
        (
            m.member_code LIKE '%$search%'
            OR
            m.member_name LIKE '%$search%'
        )

    ORDER BY br.borrow_date DESC
    ";
}
else
{
    $sql = "
    SELECT
        br.borrow_id,
        m.member_code,
        m.member_name,
        b.book_id,
        b.title,
        b.isbn,
        br.borrow_date,
        br.due_date

    FROM borrowings br

    INNER JOIN members m
    ON br.member_id = m.member_id

    INNER JOIN books b
    ON br.book_id = b.book_id

    WHERE br.status='Borrowed'

    ORDER BY br.borrow_date DESC
    ";
}

$result = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Return Book</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tables.css">
    <link rel="stylesheet" href="css/pagespec.css">

</head>

<body>

<div class="content">

    <?php
    if(isset($message))
    {
        echo "<div class='success-message'>$message</div>";
    }
    ?>

    <div class="form-box-search">

        <h2>Return Book</h2>

        <form class="search-form" method="GET">

            <input
            type="text"
            name="search"
            placeholder="Search Member Code or Member Name">

            <button type="submit">
                Search
            </button>

        </form>

    </div>

    <div class="table-container">

        <h2>Borrowed Books</h2>

        <table>

            <tr>
                <th>Borrow ID</th>
                <th>Member Code</th>
                <th>Member Name</th>
                <th>Book Title</th>
                <th>ISBN</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Action</th>
            </tr>

            <?php

            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
            ?>

            <tr>

                <td><?php echo $row['borrow_id']; ?></td>

                <td><?php echo $row['member_code']; ?></td>

                <td><?php echo $row['member_name']; ?></td>

                <td><?php echo $row['title']; ?></td>

                <td><?php echo $row['isbn']; ?></td>

                <td><?php echo $row['borrow_date']; ?></td>

                <td><?php echo $row['due_date']; ?></td>

                <td>

                    <form method="POST">

                        <input
                        type="hidden"
                        name="borrow_id"
                        value="<?php echo $row['borrow_id']; ?>">

                        <input
                        type="hidden"
                        name="book_id"
                        value="<?php echo $row['book_id']; ?>">

                        <button
                        type="submit"
                        name="return_book">

                            Return Book

                        </button>

                    </form>

                </td>

            </tr>

            <?php
                }
            }
            else
            {
                echo "
                <tr>
                    <td colspan='8'>
                        No borrowed books found
                    </td>
                </tr>
                ";
            }
            ?>

        </table>

    </div>

</div>



    <div class="sidebar">
     <p class="welcome-message">Welcome, <?php echo $_SESSION['librarian_name']; ?></p>

    <h2> <a href="dashboard.php">📚 Library Management</a></h2>

   

    <button class="drop-menu">
       📖 Manage Books
    </button>

    <div class="dropdown-content">
        <a href="addbook.php">➕ Add Book</a>
        <a href="viewbooks.php">👁️ View Books</a>
        <a href="edit_book.php">✏️ Edit Books</a>
        <a href="borrow_book.php">  📤 Borrow a Book</a>
        <a href="returnbook.php"> 📥 Return a Book</a>
        <a href="author_publisher.php"> 👨‍💼 Add Author & Publisher </a>
    </div>

    <button class="drop-menu">
        👥 Manage Members
    </button>

    <div class="dropdown-content">
        <a href="registration.php"> 📝 Register</a>
        <a href="editmember.php"> 👀 View & Edit Members</a>
    </div>

    <button class="drop-menu">
        💰 Fine Management
    </button>

    <div class="dropdown-content">
        <a href="viewfines.php">👁️ View Fine</a>
        <a href="update_fine.php">🔄 Update Fine</a>
    </div>

    <a class="menu-link" href="index.php">🚪 Logout</a>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    let dropdowns = document.getElementsByClassName("drop-menu");

    for (let i = 0; i < dropdowns.length; i++) {

        dropdowns[i].addEventListener("click", function () {

            let menu = this.nextElementSibling;

            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }

        });

    }

});
</script>

</body>
</html>
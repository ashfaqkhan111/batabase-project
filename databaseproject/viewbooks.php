<?php
session_start();

if (!isset($_SESSION['librarian_id'])) {
    header("Location: login.php");
    exit();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$sql = "SELECT
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
ON b.publisher_id = p.publisher_id";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Books</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="sidebar">

        <h2>Library Management</h2>

        <p>Welcome, <?php echo $_SESSION['librarian_name']; ?></p>

        <button class="drop-menu">
            Manage Books
        </button>

        <div class="dropdown-content">
            <a href="addbook.php">Add Book</a>
            <a href="viewbooks.php">View Books</a>
            <a href="edit_book.php">Edit Books</a>
        </div>

        <button class="drop-menu">
            Manage Members
        </button>

        <div class="dropdown-content">
            <a href="registration.php">Register</a>
            <a href="editmember.php">View Members</a>
            <a href="edit.html">Search Member</a>
        </div>

        <a class="menu-link" href="borrowedbooks.php">Borrowed Books</a>

        <a class="menu-link" href="returnbook.php">Returned Books</a>

        <button class="drop-menu">
            Fine Management
        </button>

        <div class="dropdown-content">
            <a href="viewfines.php">View Fine</a>
            <a href="update_fine.php">Update Fine</a>
        </div>

        <a class="menu-link" href="dashboard.php">Dashboard</a>

        <a class="menu-link" href="logout.php">Logout</a>

    </div>

    <div class="content">

        <h1>All Books</h1>

        <table border="1">

            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>ISBN</th>
                <th>Publication Year</th>
                <th>Available Copies</th>
                <th>Author</th>
                <th>Category</th>
                <th>Publisher</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>
                    <td><?php echo $row['book_id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['isbn']; ?></td>
                    <td><?php echo $row['publication_year']; ?></td>
                    <td><?php echo $row['available_copies']; ?></td>
                    <td><?php echo $row['author_name']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo $row['publisher_name']; ?></td>
                </tr>

            <?php } ?>

        </table>

    </div>

    <script>

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

    </script>

</body>
</html>
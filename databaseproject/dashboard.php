<?php
session_start();

if (!isset($_SESSION['librarian_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="styled.css">
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

        <a class="menu-link" href="logout.php">Logout</a>

    </div>

    <div class="content">
        <h1>Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['librarian_name']; ?></p>
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
<?php 
include 'db.php';

$sql = "
SELECT
    f.fine_id,
    f.amount,
    f.paid_status,
    m.member_code,
    m.member_name,
    b.title,
    br.borrow_date,
    br.due_date,
    br.return_date

FROM fines f

INNER JOIN borrowings br
ON f.borrow_id = br.borrow_id

INNER JOIN members m
ON br.member_id = m.member_id

INNER JOIN books b
ON br.book_id = b.book_id

ORDER BY f.fine_id DESC
";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            View Fines
        </title>
        <link rel="stylesheet" href="css/sidebar.css">
        <link rel="stylesheet" href="css/tables.css">
    </head>
    <body>
        <div class="content">
            <div class="table-container">

           
        <h1>Fine Management</h1>

        <table border="1">
            <tr>
                <th>Fine ID</th>
                    <th>Member Code</th>
                    <th>Member Name</th>
                    <th>Book Title</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Return Date</th>
                    <th>Amount</th>
                    <th>Paid Status</th>
            </tr>
            <?php
            while($row = mysqli_fetch_assoc($result)){
                ?>

                <tr>
                        <td><?php echo $row['fine_id']; ?></td>

                        <td><?php echo $row['member_code']; ?></td>

                        <td><?php echo $row['member_name']; ?></td>

                        <td><?php echo $row['title']; ?></td>

                        <td><?php echo $row['borrow_date']; ?></td>

                        <td><?php echo $row['due_date']; ?></td>

                        <td><?php echo $row['return_date']; ?></td>

                        <td><?php echo $row['amount']; ?></td>

                        <td><?php echo $row['paid_status']; ?></td>
              </tr>
              <?php  
            }
            ?>
        </table>
         </div>
        </div>

        <div class="sidebar">

        <h2>Library Management</h2>

       

        <button class="drop-menu">
        Manage Books
        </button>

        <div class="dropdown-content">
        <a href="addbook.php">Add Book</a>
        <a href="viewbooks.php">View Books</a>
        <a href="edit_book.php">Edit Books</a>
        <a href="borrow_book.php">Borrow a Book</a>
        <a href="returnbook.php">Return a Book</a>
        <a href="author_publisher.php">Add Author & Publisher</a>
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

        <a class="menu-link" href="index.php">Logout</a>

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
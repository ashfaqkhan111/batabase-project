<?php 
include 'db.php';

$sql = "SELECT br.borrow_id, m.member_code, m.member_name, b.title,b.isbn
br.borrow_sate, br.due_date, br.status
FROM borrowings br
INNER JOIN members m
ON br.member_id = m.member_id
INNER JOIN books b 
ON br.books_id = b.book_id

Where br.status = 'Borrowed'
ORDER BY br.borrow_date DESC";
$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            Borrowed Books
        </title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h1>Borrowed Books</h1>

        <table border = "1">
            <tr>
                <th>Borrow ID</th>
                <th>Member Code</th>
                <th>Member Name</th>
                <th>Book Title</th>
                <th>ISBN</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
            <?php
            while($row = mysqli_fetch_assoc($result)){
                ?>
                <tr>
                    <td><?php echo $row['borrow_id']; ?></td>

                    <td><?php echo $row['member_code']; ?></td>

                    <td><?php echo $row['member_name']; ?></td>

                    <td><?php echo $row['title']; ?></td>

                    <td><?php echo $row['isbn']; ?></td>

                    <td><?php echo $row['borrow_date']; ?></td>

                    <td><?php echo $row['due_date']; ?></td>

                    <td><?php echo $row['status']; ?></td> 
                </tr>
                <?php

            }
            ?>
           
        </table>
    </body>
</html>
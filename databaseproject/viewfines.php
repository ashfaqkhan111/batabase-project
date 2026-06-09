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
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
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
    </body>
</html>
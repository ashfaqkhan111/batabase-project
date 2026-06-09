<?php
include 'db.php';

if(isset($_POST['return_book']))
{
    $borrow_id = $_POST['borrow_id'];
    $book_id = $_POST['book_id'];

    $borrow_query = mysqli_query(
        $conn,
        "SELECT * FROM borrowings
         WHERE borrow_id='$borrow_id'"
    );

    $borrow = mysqli_fetch_assoc($borrow_query);

    $sql = "
    UPDATE borrowings
    SET
        status='Returned',
        return_date=CURDATE()
    WHERE borrow_id='$borrow_id'
    ";

    mysqli_query($conn,$sql);

    $sql = "
    UPDATE books
    SET available_copies = available_copies + 1
    WHERE book_id='$book_id'
    ";

    mysqli_query($conn,$sql);
    $due_date = strtotime($borrow['due_date']);
    $today = strtotime(date('Y-m-d'));

    if($today > $due_date)
    {
        $days_late =
        ($today - $due_date) / (60 * 60 * 24);

        $fine_amount = $days_late * 1;

        $check = mysqli_query(
            $conn,
            "SELECT * FROM fines
             WHERE borrow_id='$borrow_id'"
        );

        if(mysqli_num_rows($check) == 0)
        {
            $fine_sql = "
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
            ";

            mysqli_query($conn,$fine_sql);
        }

        echo "<h3>Book Returned Successfully</h3>";
        echo "<h3>Late Fine Created: $fine_amount</h3>";
    }
    else
    {
        echo "<h3>Book Returned Successfully</h3>";
        echo "<h3>No Fine Applied</h3>";
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            Return Book
        </title>

    </head>
    <body>
        <h1>Return a Book</h1>
        <form method="GET">
            <label for="member_code">Member Code</label>
            <input type="text" name="member_code" id="member_code" placeholder="M0000001" required>
            <button type="submit"> search</button>
        </form>
        <br><hr><br>

        <?php
        if(isset($_GET['member_code'])){
            $member_code = $_GET['member_code'];

            $sql = "SELECT * FROM members WHERE member_code = '$member_code'";

            $member_result = mysqli_query($conn,$sql);

            if(mysqli_num_rows($member_result)>0){
                $member = mysqli_fetch_assoc($member_result);

                echo "<h3> Member Information</h3>";

                echo "Member Code: ".$member['member_code']."<br>";
                echo "Member Name: ".$member['member_name']."<br><br>";
                $member_id = $member['member_id'];

                $sql = "SELECT br.borrow_id, br.borrow_date, br.due_date,
                b.book_id, b.title, b.isbn
                FROM borrowings br
                
                INNER JOIN books b
                ON br.book_id = b.book_id
                
                WHERE br.member_id='$member_id'
                AND br.status='Borrowed'";

                $result = mysqli_query($conn,$sql);

                if(mysqli_num_rows($result)>0){

                ?>

                <table border="1">
                    <tr>
                        <th>Borrow ID</th>
                        <th>Title</th>
                        <th>ISBN</th>
                        <th>Borrow Date</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                    <?php

                    while($row = mysqli_fetch_assoc($result)){
                        ?>
                        <tr>
                            <td><?php echo $row['borrow_id']; ?></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['isbn']; ?></td>
                            <td><?php echo $row['borrow_date']; ?></td>
                            <td><?php echo $row['due_date']; ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="borrow_id" value="<?php echo $row['borrow_id']; ?>">
                                    <input type="hidden" name="book_id" value="<?php echo $row['book_id']; ?>">
                                    <button type="submit" name="return_book">Return Book</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
                } else {
                    echo "No borrowed books found";
                }
            } else {
                echo "Member not found";
            }
        }
        ?>
    </body>
</html>
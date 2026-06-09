<?php

include 'db.php';

if(isset($_POST['update_fine']))
{
    $fine_id = $_POST['fine_id'];
    $paid_status = $_POST['paid_status'];

    $sql = "
    UPDATE fines
    SET paid_status='$paid_status'
    WHERE fine_id='$fine_id'
    ";

    mysqli_query($conn,$sql);

    echo "<h3>Fine Status Updated Successfully</h3>";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Update Fine Status</title>
</head>

<body>

<h1>Update Fine Status</h1>

<form method="GET">

    <label>Fine ID</label>

    <input
    type="number"
    name="fine_id"
    required>

    <button type="submit">
        Search
    </button>

</form>

<br><hr><br>

<?php

if(isset($_GET['fine_id']))
{
    $fine_id = $_GET['fine_id'];

    $sql = "
    SELECT
        f.*,
        m.member_code,
        m.member_name,
        b.title

    FROM fines f

    INNER JOIN borrowings br
    ON f.borrow_id = br.borrow_id

    INNER JOIN members m
    ON br.member_id = m.member_id

    INNER JOIN books b
    ON br.book_id = b.book_id

    WHERE f.fine_id='$fine_id'
    ";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_assoc($result);
?>

<form method="POST">

    <input
    type="hidden"
    name="fine_id"
    value="<?php echo $row['fine_id']; ?>">

    <p>
        <strong>Fine ID:</strong>
        <?php echo $row['fine_id']; ?>
    </p>

    <p>
        <strong>Member Code:</strong>
        <?php echo $row['member_code']; ?>
    </p>

    <p>
        <strong>Member Name:</strong>
        <?php echo $row['member_name']; ?>
    </p>

    <p>
        <strong>Book Title:</strong>
        <?php echo $row['title']; ?>
    </p>

    <p>
        <strong>Amount:</strong>
        <?php echo $row['amount']; ?>
    </p>

    <label>Paid Status</label>

    <select name="paid_status">

        <option value="Paid"
        <?php
        if($row['paid_status']=="Paid")
        echo "selected";
        ?>>
        Paid
        </option>

        <option value="Unpaid"
        <?php
        if($row['paid_status']=="Unpaid")
        echo "selected";
        ?>>
        Unpaid
        </option>

    </select>

    <br><br>

    <button
    type="submit"
    name="update_fine">

    Update Fine

    </button>

</form>

<?php
    }
    else
    {
        echo "Fine Not Found";
    }
}
?>

</body>
</html>
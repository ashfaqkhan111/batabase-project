<?php
include 'db.php';

if(isset($_POST['update_member']))
{
    $member_id = $_POST['member_id'];
    $member_name = $_POST['member_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

    $sql = "
    UPDATE members
    SET
        member_name='$member_name',
        email='$email',
        phone='$phone',
        address='$address',
        gender='$gender'
    WHERE member_id='$member_id'
    ";

    if(mysqli_query($conn,$sql))
    {
        echo "<h3>Member Updated Successfully</h3>";
    }
    else
    {
        die(mysqli_error($conn));
    }
}


if(isset($_POST['delete_member'])){
    $member_id = $_POST['member_id'];
    $sql = "DELETE FROM members Where member_id = '$member_id'";

    mysqli_query($conn,$sql);

    echo "<h3>Member Deleted Successfully</h3>";

}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            Update Member
        </title>

    </head>
    <body>
        <h1>Manage Member</h1>

        <form method="GET">
            <label for="search">Search Member</label>
            <br>
            <input type="text" name="search" placeholder="member code or name">

            <button type="submit" >search</button>
        </form>
        <br><hr><br>

        <?php
            if(isset($_GET['search'])){
                $search = $_GET['search'];
                $sql = "
                        SELECT *
                        FROM members
                        WHERE
                        member_code LIKE '%$search%'
                        OR member_name LIKE '%$search%'
                        ";
                $result = mysqli_query($conn, $sql);

                echo "<table border ='1'>
                <tr>
                <th> Member Code</th>
                <th>Member Name</th>
                <th>Action</th>
                </tr>
                ";

                while($row = mysqli_fetch_assoc($result)){
                    echo "
                    <tr>
                    <td> ".$row['member_code']."</td>
                    <td> ".$row['member_name']."</td>
                    <td>
                    <a href='editmember.php?id=".$row['member_id']."'>
                    select
                    </a>
                    </td>
                    </tr>
                    ";
                }
                echo "</table>";

            }

            if(isset($_GET['id'])){
                $id = $_GET['id'];
                $sql = "SELECT * FROM members WHERE member_id='$id'";

                $result = mysqli_query($conn,$sql);
                $member = mysqli_fetch_assoc($result);
            }
        ?>
        <br><hr><br>

        <h2>Edit Member</h2>
        <form method="post">
            <label for="member_code">Member Code</label>
            <br>
            <input name="member_code" value="<?php echo $member['member_code'];?>" readonly>
            <br><br>
            <label for="member_name">Member Name</label>
            <br>
            <input type="text" name="member_name" value="<?php echo $member['member_name']; ?>" required>
            <br><br>

            <label for="email">Email</label>
            <br>
            <input type="email" name="email" value="<?php echo $member['email']; ?>">
            <br><br>

            <label for="phone">Phone</label>
            <br>
            <input type="text" name="phone" value="<?php echo $member['phone']; ?>">
            <br><br>
            <label for="address">Address</label>
            <br>
            <input type="text" name="address" value="<?php echo $member ['address']; ?>">
            <br>

            <label for="gender">Gender</label>
            <br>
            <select name="gender">
                <option value="Male"
                <?php if($member['gender'] == "Male") echo "selected";?>>Male</option>

                <option value="Female" 
            <?php if($member['gender'] == "Female") echo "selected";?>>Female</option>

            </select>

            <br><br>

            <button type="submit" name="update_member"> Update Member</button>
        </form>

       
    </body>
</html>
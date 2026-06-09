<?php
include 'db.php';

if(isset($_POST['register_member'])){
    $member_name = $_POST['member_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];

$sql = "INSERT INTO members (member_name,email,phone,address,gender,registration_date)
VALUES ('$member_name','$email','$phone','$address','$gender',CURDATE())";

mysqli_query($conn,$sql);
$member_id = mysqli_insert_id($conn);
$member_code = "M" . str_pad($member_id,6,"0",STR_PAD_LEFT);

$update = "UPDATE members SET member_code ='$member_code' where member_id = '$member_id'";

mysqli_query($conn,$update);

echo "<h3>Member Registerd Successfully</h3>";
echo "Member Code: $member_code </h3>";
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            Registration
        </title>
        <link rel="stylesheet" href="css/style.css">
        </head>
        <body>
            <h1>Register Member</h1>

            <form method="post">
                <label for="member_name">Name</label>
                <br>
                <input type="text" name="member_name" id="member_name" placeholder="jhon" required>
                <br>

                <label for="email">Email</label>
                <br>
                <input type="email" name="email" id="email" placeholder="abc@example.com" required>
                <br>
                <label for="phone">Phone</label>
                <br>
                <input type="text" name="phone" placeholder="0988700988" required>
                <br>
                <label for="address"> Address</label>
                <br>
                <input type="text" name="address" id="address" placeholder="address" required>
                <br>
                <label for="gender">Gender</label>
                <br>
                <select name="gender">
                    <option value="male">
                        Male
                    </option>
                    <option value="female">
                        Female
                    </option>
                </select>
                <br><br>
                <button type="submit" name="register_member">register</button>
            </form>
        </body>
    
</html>
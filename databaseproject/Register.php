<?php
// 1. Connect to the Laragon database
include 'koneksi.php';

// 2. Retrieve data from the HTML form
$member_id   = $_POST['member_id'];
$member_name = $_POST['member_name'];
$email       = $_POST['email'];
$phone       = $_POST['phone'];
$address     = $_POST['address'];
$gender      = $_POST['gender'];

// 3. Prepare the SQL query to insert the new member
$sql = "INSERT INTO Members (member_id, member_name, email, phone, address, gender) 
        VALUES ('$member_id', '$member_name', '$email', '$phone', '$address', '$gender')";

// 4. Execute the query and check for success
if (mysqli_query($conn, $sql)) {
    echo "<script>
            alert('New member successfully registered!');
            window.location='view.html'; // Redirects to the view members page (from your dashboard menu)
          </script>";
} else {
    // If there is an error (like entering a member_id that already exists), it will show here
    echo "<script>
            alert('Error: Could not register member. Check if the Member ID already exists.');
            window.location='register.html';
          </script>";
}

// 5. Close the database connection
mysqli_close($conn);
?>
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
        <link rel="stylesheet" href="css/sidebar.css">
        <link rel="stylesheet" href="css/global.css">
        </head>
        <body>
            <div class="form-box">
            <h1>Register Member</h1>

            <form method="post">
                <label for="member_name">Name</label>
           
                <input type="text" name="member_name" id="member_name" placeholder="jhon" required>
          

                <label for="email">Email</label>
              
                <input type="email" name="email" id="email" placeholder="abc@example.com" required>
             
                <label for="phone">Phone</label>
               
                <input type="text" name="phone" placeholder="0988700988" required>
                
                <label for="address"> Address</label>
            
                <input type="text" name="address" id="address" placeholder="address" required>
               
                <label for="gender">Gender</label>
                
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

    <div class="sidebar">
     <p class="welcome-message">Welcome, <?php echo $_SESSION['librarian_name']; ?></p>

    <h2> <a href="dashboard.php">📚 Library Management</a></h2>

    <button class="drop-menu">
       📖 Manage Books
    </button>

    <div class="dropdown-content">
        <a href="addbook.php">➕ Add Book</a>
        <a href="viewbooks.php">👁️ View Books</a>
        <a href="edit_book.php">✏️ Edit Books</a>
        <a href="borrow_book.php">  📤 Borrow a Book</a>
        <a href="returnbook.php"> 📥 Return a Book</a>
        <a href="author_publisher.php"> 👨‍💼 Add Author & Publisher </a>
    </div>

    <button class="drop-menu">
        👥 Manage Members
    </button>

    <div class="dropdown-content">
        <a href="registration.php"> 📝 Register</a>
        <a href="editmember.php"> 👀 View & Edit Members</a>
    </div>

    <button class="drop-menu">
        💰 Fine Management
    </button>

    <div class="dropdown-content">
        <a href="viewfines.php">👁️ View Fine</a>
        <a href="update_fine.php">🔄 Update Fine</a>
    </div>
    <a class="menu-link" href="index.php">🚪 Logout</a>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

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

});
</script>
        </body>
    
</html>
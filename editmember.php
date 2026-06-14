<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';

$member = null;



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
        header("Location: editmember.php?id=$member_id&updated=1");
        exit();
    }
}



if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $sql = "
    SELECT *
    FROM members
    WHERE member_id='$id'
    ";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0)
    {
        $member = mysqli_fetch_assoc($result);
    }
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Edit Member</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tables.css">
    <link rel="stylesheet" href="css/pagespec.css">

</head>

<body>

<div class="content">

    <h2>Manage Member</h2>

    <?php
    if(isset($_GET['updated']))
    {
        echo "
        <div class='success-message'>
            Member Updated Successfully
        </div>";
    }
    ?>

    <form class="search-form" method="GET">

        <input
        type="text"
        name="search"
        placeholder="Member Code or Member Name">

        <button type="submit">
            Search
        </button>

    </form>

    <?php

    if(isset($_GET['search']))
    {
        $search = $_GET['search'];

        $sql = "
        SELECT *
        FROM members
        WHERE
            member_code LIKE '%$search%'
            OR member_name LIKE '%$search%'
        ";

        $result = mysqli_query($conn,$sql);

        if(mysqli_num_rows($result) > 0)
        {
        ?>

        <div class="table-container">

            <h2>Search Results</h2>

            <table>

                <tr>
                    <th>Member Code</th>
                    <th>Member Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>

                <?php
                while($row = mysqli_fetch_assoc($result))
                {
                ?>

                <tr>

                    <td><?php echo $row['member_code']; ?></td>

                    <td><?php echo $row['member_name']; ?></td>

                    <td><?php echo $row['email']; ?></td>

                    <td><?php echo $row['phone']; ?></td>

                    <td>

                        <a
                        class="select-btn"
                        href="editmember.php?id=<?php echo $row['member_id']; ?>">

                            Select

                        </a>

                    </td>

                </tr>

                <?php
                }
                ?>

            </table>

        </div>

        <?php
        }
        else
        {
            echo "
            <div class='error-message'>
                No Members Found
            </div>";
        }
    }
    ?>

    <?php if($member !== null){ ?>

    <div class="form-box">

        <h2>Edit Member</h2>

        <form method="POST">

            <input
            type="hidden"
            name="member_id"
            value="<?php echo $member['member_id']; ?>">

            <label>Member Code</label>

            <input
            type="text"
            value="<?php echo $member['member_code']; ?>"
            readonly>

            <label>Member Name</label>

            <input
            type="text"
            name="member_name"
            value="<?php echo $member['member_name']; ?>"
            required>

            <label>Email</label>

            <input
            type="email"
            name="email"
            value="<?php echo $member['email']; ?>">

            <label>Phone</label>

            <input
            type="text"
            name="phone"
            value="<?php echo $member['phone']; ?>">

            <label>Address</label>

            <input
            type="text"
            name="address"
            value="<?php echo $member['address']; ?>">

            <label>Gender</label>

            <select name="gender">

                <option
                value="Male"
                <?php if($member['gender']=="Male") echo "selected"; ?>>
                    Male
                </option>

                <option
                value="Female"
                <?php if($member['gender']=="Female") echo "selected"; ?>>
                    Female
                </option>

            </select>

            <button
            type="submit"
            name="update_member">

                Update Member

            </button>

        </form>

    </div>

    <?php } ?>

</div>



<div class="sidebar">

   

    <h2>
        <a href="dashboard.php">Library Management</a>
    </h2>

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
        <a href="editmember.php">View & Edit Members</a>
    </div>

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


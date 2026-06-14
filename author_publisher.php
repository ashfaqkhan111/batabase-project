
<?php
include 'db.php';

if(isset($_POST['add_author']))
{
    $author_name = $_POST['author_name'];
    $country = $_POST['country'];

    $sql = "
    INSERT INTO authors
    (
        author_name,
        country
    )
    VALUES
    (
        '$author_name',
        '$country'
    )
    ";

    mysqli_query($conn,$sql);

    echo "
    <div class='success-message'>
        Author Added Successfully
    </div>
    ";
}

if(isset($_POST['add_publisher']))
{
    $publisher_name = $_POST['publisher_name'];
    $address = $_POST['address'];

    $sql = "
    INSERT INTO publishers
    (
        publisher_name,
        address
    )
    VALUES
    (
        '$publisher_name',
        '$address'
    )
    ";

    mysqli_query($conn,$sql);

    echo "
    <div class='success-message'>
        Publisher Added Successfully
    </div>
    ";
}

if(isset($_POST['add_category']))
{
    $category_name = $_POST['category_name'];

    $sql = "
    INSERT INTO categories
    (
        category_name
    )
    VALUES
    (
        '$category_name'
    )
    ";

    mysqli_query($conn,$sql);

    echo "
    <div class='success-message'>
        Category Added Successfully
    </div>
    ";
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Library Data</title>

    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/pagespec.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/tables.css">

</head>

<body>

<div class="content">

    <div class="form-box">

        <h1>Add Author</h1>

        <form method="POST">

            <label>Author Name</label>

            <input
            type="text"
            name="author_name"
            placeholder="John"
            required>

            <label>Country</label>

            <input
            type="text"
            name="country"
            placeholder="USA"
            required>

            <button
            type="submit"
            name="add_author">

                Add Author

            </button>

        </form>

    </div>

    <div class="form-box">

        <h1>Add Publisher</h1>

        <form method="POST">

            <label>Publisher Name</label>

            <input
            type="text"
            name="publisher_name"
            placeholder="Pearson"
            required>

            <label>Address</label>

            <input
            type="text"
            name="address"
            placeholder="Publisher Address"
            required>

            <button
            type="submit"
            name="add_publisher">

                Add Publisher

            </button>

        </form>

    </div>

    <div class="form-box">

        <h1>Add Category</h1>

        <form method="POST">

            <label>Category Name</label>

            <input
            type="text"
            name="category_name"
            placeholder="Technical"
            required>

            <button
            type="submit"
            name="add_category">

                Add Category

            </button>

        </form>

    </div>

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


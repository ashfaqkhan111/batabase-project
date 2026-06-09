<?php
include 'db.php';

if(isset($_POST['add_author'])){
    $author_name = $_POST['author_name'];
    $country = $_POST['country'];
    $sql = "INSERT INTO authors(author_name,country) VALUES ('$author_name','$country')";

    mysqli_query($conn,$sql);
    echo "Auther added Successfully";
}

if (isset($_POST['add_publisher'])){
    $publisher_name = $_POST['publisher_name'];
    $address = $_POST['address'];
    $sql = "INSERT INTO publishers(publisher_name,address) VALUES ('$publisher_name','$address')";

    mysqli_query($conn,$sql);
    echo "Publisher Added";
}

if(isset($_POST['add_category'])){
    $category_name = $_POST['category_name'];
    $sql = "INSERT INTO categories(category_name) VALUES ('$category_name')";

    mysqli_query($conn,$sql);
    echo "Category Added Successfully!!";
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            library data
        </title>
    </head>
    <body>
        <h1>library management</h1>
        <hr>

        <h2>Add Author</h2>
        <form method="post">
            <label for="author">
                Author Name</label>
                <br>

                <input type="text" name="author_name" id="author_name" placeholder="jhon" required >
                <br>

                <label for="country">Country</label>
                <br>
                <input type="text" name="country" id="country" placeholder="USA" required>
                <br>
                <br>

                <button type="submit" name="add_author">Add Author</button>
        </form>
            <hr>
        <br>
        <form method="post">

        <h2>Add Publisher</h2>

        <label for="publisher">Publisher Name</label>
        <br>
        <input type="text" name="publisher_name" id="publisher_name" required>
        <br>
        <label for="address">Address</label>
        <br>
        <input type="text" name="address" id="address" placeholder="address" required>
        <br><br>

        <button type="submit" name="add_publisher">Add publisher</button>
        </form>
        <hr>

        <br>
        <form method ="post">
            <h2>Category</h2>

            <label for="category_name">Category</label>
            <input type="text" name="category_name" id="category_name" placeholder="Technical" required>
            <br><br>
            <button type="submit" name="add_category">Add Cateogry</button>
        </form>
    </body>
</html>
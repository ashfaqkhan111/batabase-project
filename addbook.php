<?php
include 'db.php';
if(isset($_POST['add_book'])){
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $publication_year = $_POST['publication_year'];
    $avalible_copies = $_POST['available_copies'];
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $publisher_id = $_POST['publisher_id'];

    $sql = "INSERT INTO books(title,isbn,publication_year,available_copies, author_id,category_id,publisher_id)
    VALUES ('$title','$isbn','$publication_year','$avalible_copies','$author_id','$category_id','$publisher_id')";

    mysqli_query($conn, $sql);
    echo "Book Added Successfully";

}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Add Book</title>
        <link rel="stylesheet" href="css/global.css">
        <link rel="stylesheet" href="css/tables.css">
        <link rel="stylesheet" href="css/sidebar.css"
    </head>
    <body>
        
        <div class="form-box">
            <h1>Add Book</h1>
        <form method="POST">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="programming" required>

            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn" placeholder="5345456rt65" required>

            <label for="publication_year"> Publication Year</label>
            <input type="number" name="publication_year" id="publication_year" placeholder="2001" min="1850" max="2100" required>

            <label for="available_copies">Available Copies</label>
            <input type="number" name="available_copies" id="available_copies" required>

            <label for="author">Author Name</label>
            <div class="select-add-book"></div>
            <select name="author_id" id="">
                <?php
                $sql = "SELECT * FROM authors";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)){
                    ?>
                    <option value="<?php echo $row['author_id']; ?>">
                        <?php echo $row['author_name']; ?>
                    </option>
                    
                    <?php
                    
                }
                ?>
            </select>

            <label for="category">Category</label>
            <select name="category_id">

            <?php
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($conn,$sql);

            while($row = mysqli_fetch_assoc($result)){
                ?>
                <option value="<?php echo $row['category_id']; ?>">
                    <?php echo $row['category_name']; ?>
                </option>
                <?php
            }
            ?>

            </select>
            <label for="publisher_id">Publisher</label>
            <select name="publisher_id">

                <?php
                $sql = "SELECT * FROM publishers";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)){
                    ?>

                    <option value="<?php echo $row['publisher_id'];?>">
                <?php echo $row['publisher_name']; ?>        
                </option>
                <?php
                }
                ?>

            </select>
            <button class="add-book-button" type="submit" name="add_book">Add Book</button>
        </form>
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

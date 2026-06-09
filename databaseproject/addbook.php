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
<link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <h1 class="add-book">Add Book</h1>
        
        <form method="POST">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="programming" required>
            <br><br>

            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" id="isbn" placeholder="5345456rt65" required>
            <br><br>

            <label for="publication_year"> Publication Year</label>
            <input type="number" name="publication_year" id="publication_year" placeholder="2001" min="1850" max="2100" required>
            <br><br>

            <label for="available_copies">Available Copies</label>
            <input type="number" name="available_copies" id="available_copies" required>
            <br><br>

            <label for="author">Author Name</label>
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
            <br><br>

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
            <br><br>
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
            <br><br>
            <button type="submit" name="add_book">Add Book</button>
        </form>
    </body>
</html>

<?php
// Start session
session_start();

// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);



$tokenMessage = "";
if (isset($_SESSION['token'])) {
    $tokenId = $_SESSION['token']['id'];
    $token = $_SESSION['token']['value'];
    $tokenMessage = "
                     <p><strong>Student ID:</strong> $tokenId</p>
                     <p><strong>Generated Token:</strong> $token</p>";
    unset($_SESSION['token']); // Clear token data after displaying
}

if (isset($_SESSION['error'])) {
    $tokenMessage = "<p style='color: red;'>{$_SESSION['error']}</p>";
    unset($_SESSION['error']); // Clear error after displaying
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <img src="images/ID.jpg" alt="Screenshot of ID">
    <div class="head">
        <h1><b><i><u>Book Borrowing Management</u></i></b></h1>
    </div>
    <div>
        <div class="outerclass">
            <div class="rightBox">

                <div class="box9">
                    <h2>Add a New Book</h2>
                    <form action="add.php" method="post" enctype="multipart/form-data">
                        <label for="book_name">Book Name:</label><br>
                        <input type="text" id="book_name" name="book_name" required><br><br>
                        <label for="author_name">Author Name:</label><br>
                        <input type="text" id="author_name" name="author_name" required><br><br>

                        <label for="image">Book Image:</label><br>
                        <input type="file" id="image" name="image" accept="image/*" required><br><br>

                        <label for="category">Category:</label><br>
                        <select id="category" name="category" required>
                            <option value="">-- Select a Category --</option>
                            <option value="story">Story</option>
                            <option value="science">Science</option>

                        </select><br><br>

                        <label for="fees">Fees:</label><br>
                        <input type="number" id="fees" name="fees" step="0.01" required><br><br>



                        <button type="submit">Add Book</button>
                    </form>
                </div>
                <div class="box9">
                    <h2>Update or Remove Book</h2>
                    <form method="POST" action="update_remove.php">
            <label for="search">Search (Book Name or Author Name):</label><br>
            <input type="text" name="search" id="search" placeholder="Enter Book or Author Name" required><br><br>
            <button type="submit">Search</button>
        </form>
                </div>





            </div>


            <div class="middleBox">



                <div class="third">
                    <div class="box7">
                        <div class="box7">
                            <h1>Book Types</h1>
                        </div>
                    </div>
                    <div class="box7">
                        <a href="story_books.php" style="text-decoration: none;">
                            <div class="box8" style="cursor: pointer;">
                                <img src="images/StoryTime.jpg" style="height: 130px; width: 120.5px;">
                            </div>
                        </a>
                        <a href="science_books.php" style="text-decoration: none;">
                            <div class="box8" style="cursor: pointer;">
                                <img src="images/ScienceBooks.jpg" style="height: 130px; width: 120.5px;">
                            </div>
                        </a>
                    </div>
                    <div class="box1">
                        <h3>Request a Token</h3>
                        <form action="token.php" method="post">
                            <label for="tokenSid">Student ID:</label>
                            <input type="text" id="tokenSid" name="tokenSid" required>
                            <button type="Submit">Get Token</button>
                        </form>
                    </div>
                    <div class="box1">
                        <h4>Token Details</h4>
                        <?php echo $tokenMessage; ?>

                    </div>
                </div>
                <div class="fourth">
                    <form action="process.php" method="post">
                        <div class="box4">
                            <h2>Borrow Book</h2>
                            <label for="SName">Student Name</label><br>
                            <input type="text" id="SName" name="Sname"><br>
                            <label for="SId">Student Id</label><br>
                            <input type="text" id="SId" name="Sid"><br>
                            <label for="Smail">Student Email</label><br>
                            <input type="text" id="Smail" name="Smail"><br>
                            <?php
                            // Include database connection
                            include 'db.php';

                            // Fetch books grouped by category
                            $sql = "SELECT book_name, category FROM books ORDER BY category, book_name";
                            $result = $conn->query($sql);

                            // Create the dropdown
                            echo '<label for="selectBook">Choose a Book</label><br>';
                            echo '<select name="selectBook" id="selectBook" required>';

                            $currentCategory = ""; // To track category changes
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Check if the category has changed
                                    if ($currentCategory !== $row['category']) {
                                        // Close previous optgroup if it's not the first iteration
                                        if ($currentCategory !== "") {
                                            echo '</optgroup>';
                                        }
                                        // Start a new optgroup
                                        $currentCategory = $row['category'];
                                        echo '<optgroup label="' . htmlspecialchars(ucwords($currentCategory)) . '">';
                                    }
                                    // Add book option
                                    echo '<option value="' . htmlspecialchars($row['book_name']) . '">' . htmlspecialchars($row['book_name']) . '</option>';
                                }
                                // Close the last optgroup
                                echo '</optgroup>';
                            } else {
                                echo '<option value="">No books available</option>';
                            }

                            echo '</select><br>';
                            ?>
                            <label for="Borrow">Borrow Book Date:</label><br>
                            <?php date_default_timezone_set('Asia/Dhaka'); ?>
                            <input type="date" id="Borrow" name="Borrow"><br>
                            <label for="Token">Token No:</label><br>
                            <input type="text" id="Token" name="Token"><br>
                            <label for="Return">Return Book Date:</label><br>
                            <input type="date" id="Return" name="Return"><br>
                            <label for="Fees">Fees:</label><br>
                            <input type="number" id="Fees" name="Fees"><br>
                            <button type="submit">Submit</button>
                        </div>
                    </form>
                    <div class="box5">
                    </div>
                </div>
            </div>
            <div class="leftBox" style="padding: 20px; border:1px solid rgb(0, 0, 0); ">

                <div style="margin-top: 20px; max-height: 633px; overflow-y: auto; border:1px solid rgb(0, 0, 0); padding: 10px;">
                    <h2>Search Books</h2>
                    <form method="GET" action="">
                        <label for="book_name">Book Name:</label>
                        <input type="text" id="book_name" name="book_name"><br><br>

                        <label for="author_name">Author Name:</label>
                        <input type="text" id="author_name" name="author_name"><br><br>

                        <label for="category">Category:</label><br>
                        <select id="category" name="category">
                            <option value="">-- All Categories --</option>
                            <option value="story">Story</option>
                            <option value="science">Science</option>
                           
                        </select><br><br>

                        <label for="min_fees">Fees Range:</label><br>
                        Min: <input type="number" id="min_fees" name="min_fees" step="0.01">
                        Max: <input type="number" id="max_fees" name="max_fees" step="0.01"><br><br>

                        <button type="submit">Search</button>
                    </form><?php include 'search.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="dead"></div>
</body>

</html>
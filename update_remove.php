<?php
// Include the database connection
include 'db.php';

// Initialize variables
$book = null;
$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['search'])) {
        $search = htmlspecialchars(trim($_POST['search']));

        // Search for the book or author in the database
        $sql = "SELECT * FROM books WHERE book_name LIKE ? OR author_name LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchLike = "%$search%";
        $stmt->bind_param("ss", $searchLike, $searchLike);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch the book details
            $book = $result->fetch_assoc();
        } else {
            $error_message = "No book or author found matching '$search'.";
        }
        $stmt->close();
    } elseif (isset($_POST['action'])) {
        // Handle updates or deletions
        $action = $_POST["action"];
        $book_id = htmlspecialchars(trim($_POST["book_id"]));

        if ($action === "update") {
            // Update book details
            $book_name = htmlspecialchars(trim($_POST["book_name"]));
            $category = htmlspecialchars(trim($_POST["category"]));
            $fees = htmlspecialchars(trim($_POST["fees"]));
            $author_name = htmlspecialchars(trim($_POST["author_name"]));

            // Prepare the SQL statement
            $sql = "UPDATE books SET book_name = ?, category = ?, fees = ?, author_name = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssdsi", $book_name, $category, $fees, $author_name, $book_id);

            // Execute the query
            if ($stmt->execute()) {
                $success_message = "Book updated successfully!";
            } else {
                $error_message = "Error updating book: " . $stmt->error;
            }
            $stmt->close();
        } elseif ($action === "delete") {
            // Delete the book
            $sql = "DELETE FROM books WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $book_id);

            // Execute the query
            if ($stmt->execute()) {
                $success_message = "Book deleted successfully!";
            } else {
                $error_message = "Error deleting book: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update or Remove Book</title>
    <style>
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input, form button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        form button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #0056b3;
        }

        .message {
            max-width: 400px;
            margin: 20px auto;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <h2>Search, Update, or Remove Book</h2>

    <?php if ($error_message): ?>
        <div class="message error"><?php echo $error_message; ?></div>
    <?php elseif ($success_message): ?>
        <div class="message success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <?php if (!$book): ?>
        <form method="POST" action="update_remove.php">
            <label for="search">Search (Book Name or Author Name):</label>
            <input type="text" name="search" id="search" placeholder="Enter Book Name or Author Name" required>
            <button type="submit">Search</button>
        </form>
    <?php else: ?>
        <form method="POST" action="update_remove.php">
            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">

            <label for="book_name">Book Name:</label>
            <input type="text" name="book_name" id="book_name" value="<?php echo $book['book_name']; ?>" required>

            <label for="category">Category:</label>
            <input type="text" name="category" id="category" value="<?php echo $book['category']; ?>" required>

            <label for="fees">Fees:</label>
            <input type="number" name="fees" id="fees" value="<?php echo $book['fees']; ?>" step="0.01" required>

            <label for="author_name">Author Name:</label>
            <input type="text" name="author_name" id="author_name" value="<?php echo $book['author_name']; ?>" required>

            <button type="submit" name="action" value="update">Update Book</button>
            <button type="submit" name="action" value="delete" style="background-color: red; color: white;">Delete Book</button>
            
        </form>
    <?php endif; ?>
    <label  for ="Go Back"><p><a href='index.php'>Go Back</a></p></label>
</body>

</html>

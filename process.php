<?php
// Turn on error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrowing Receipt</title>
    <link rel="stylesheet" href="process.css">
</head>

<body>

    <?php

    $errors = [];

    // Validate Student Name
    if (empty(trim($_POST['Sname']))) {
        $errors[] = "Student Name is required.";
    } else {
        $studentName = $_POST['Sname'];
        if (!preg_match("/^([A-Z][a-z.]*\s+)([A-Z][a-z.\s+]* )([A-Z][a-z.]*\s*)*$/", $studentName)) {
            $errors[] = "Student Name must include only letters, spaces, and dots, with each word starting with a capital letter and atlest first and last name";
        } else {
            $studentName = htmlspecialchars($studentName);
        }
    }

    // Validate Student ID
    if (empty(trim($_POST['Sid']))) {
        $errors[] = "Student ID is required.";
    } else {
        $studentId = $_POST['Sid'];

        if (!preg_match("/^[0-9]{2}-[0-9]{5}-[1-3]{1}$/", $studentId)) {
            $errors[] = "Student ID must be in the format XX-XXXXX-X(1-3) ";
        } else {
            $studentId = htmlspecialchars($studentId);
        }
    }

    // Validate Student Email
    if (empty(trim($_POST['Smail']))) {
        $errors[] = "Student Email is required.";
    } else {
        $studentEmail = $_POST['Smail'];
        if (!preg_match("/^[0-9]{2}-[0-9]{5}-[1-3]{1}@student\.aiub\.edu$/", $studentEmail)) {
            $errors[] = "Student Email must be in the format XX-XXXXX-X(1-3)@student.aiub.edu";
        } else {
            $studentEmail = htmlspecialchars($studentEmail);
        }
    }
    // Validate Token
    if (!empty(trim($_POST["Token"]))) {
        $token = $_POST["Token"];


        if (!preg_match("/^[A-Za-z0-9]*$/", $token)) {
            $errors[] = "Enter a valid token. It should contain no special characters or spaces.";
        } else {

            $token = htmlspecialchars($token);
        }
    } else {

        $token = "";
    }
    
    //Borrow Date
    date_default_timezone_set('Asia/Dhaka');
    $today = date("Y-m-d");
    if (isset($_POST['Borrow']) && !empty($_POST['Borrow'])) {
        $borrowDate = $_POST['Borrow'];
        if ($borrowDate <= $today) {
            $errors[] = "Error: The selected Borrow date must be after today.";
        }
    } else {
        $errors[] = "Error: Enter borrow Date. Try again!";
    }

  
    
    // Returndate
if (isset($_POST["Return"]) && !empty($_POST["Return"])) {
    $returnDate1 = $_POST["Return"];
    $finishBorrow = date("Y-m-d", strtotime($borrowDate . " +10 days"));
    $extendedBorrow = date("Y-m-d", strtotime($borrowDate . " +20 days"));

    // Check if token is provided for extension
    if ($returnDate1 > $finishBorrow) {
        if (isset($_POST['Token']) && !empty($_POST['Token'])) {
            $token = htmlspecialchars($_POST['Token']);

            // Load token data from token.json
            $jsDirectory = "token/";
            
            $FilePath = $jsDirectory . $studentId . ".json";
            if (file_exists($FilePath)) {
                $tokenData = json_decode(file_get_contents($FilePath), true);

                // Check if the token exists
                if (in_array($token, $tokenData)) {
                    // Validate if return date is within 20 days
                    if ($returnDate1 <= $extendedBorrow) {
                        $returnDate = $returnDate1;
                    } else {
                        $errors[] = "Error: The return date must be within 20 days from the borrow date.";
                    }
                } else {
                    $errors[] = "Error: Invalid token. Please provide a valid token for extension.";
                }
            } else {
                $errors[] = "Error: Token file not found. Please contact the library.";
            }
        } else {
            $errors[] = "Error: Token is required to extend the return date beyond 10 days.";
        }
    } elseif ($returnDate1 <= $finishBorrow && $returnDate1 > $borrowDate) {
        // Return date within the first 10 days (no token required)
        $returnDate = $returnDate1;
    } else {
        $errors[] = "Error: Return date must be after the borrow date.";
    }
} else {
    $errors[] = "Error: Enter a return date.";
}



    // Selected Book and Cookie
    $cookie_name = "selectbook";
    $cookie_value = htmlspecialchars($_POST['selectBook']);
    $cookie_name_sname = "studentName";
    $cookie_value_sname = htmlspecialchars($_POST['Sname']);
    if (isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] === $cookie_value) {
        if (isset($_COOKIE[$cookie_name_sname]) && $_COOKIE[$cookie_name_sname] === $cookie_value_sname) {
            $errors[] = "You already borrowed this book.";
        } else {
            $errors[] = "This book is already borrowed. Please wait until it becomes available.";
        }
    }
    else{setcookie($cookie_name, $cookie_value, time() + 30, '/');
        setcookie($cookie_name_sname, $cookie_value_sname, time() + 30, '/');}









    // Validate Fees
    $fees = htmlspecialchars(trim($_POST['Fees']));
    
     if (!empty($errors)): ?>
        <div style="color: red;">
            <h3>Validation Errors:</h3>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php 
     
    elseif ($_SERVER["REQUEST_METHOD"] === "POST"):
     ?>
        <div class="details">
            <h1>Library Receipt</h1>
            <div class="info">
                <p>Student Name:</p>
                <p><?php echo $studentName; ?></p>
            </div>
            <div class="info">
                <p>Student ID:</p>
                <p><?php echo $studentId; ?></p>
            </div>
            <div class="info">
                <p>Student Email:</p>
                <p><?php echo $studentEmail; ?></p>
            </div>
        </div>
        <div class="book-list">
            <div class="book">
                <p>Selected Book:</p>
                <p><?php echo $cookie_value; ?></p>
            </div>
            <div class="book">
                <p>Fees:</p>
                <p><?php echo $fees; ?></p>
            </div>
            <div class="Dates">
                <p>Borrow Date:</p>
                <p><?php echo $borrowDate; ?></p>
            </div>
            <div class="Dates">
                <p>Return Date:</p>
                <p><?php echo $returnDate; ?></p>
            </div>
        </div>
    <?php endif;
     ?>
    
    
</body>
</html>
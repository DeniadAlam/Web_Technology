<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="show.css">
</head>
<body>
    <?php
        if (file_exists("jsonfiles/".$_POST['username'].".json")) {
            $person=json_decode(file_get_contents("jsonfiles/".$_POST['username'].".json"));  
            
            echo "<div class=\"wrapper\"><img class=\"pic\" src=\"userimages/$person->imagefile\">
            <p> $person->username<p>
            </div>";
        

        }
        else {
            die("User Not Found!");
        }

    ?>
  
  
</body>
</html>

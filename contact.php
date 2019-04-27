<?php
dd($_POST);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required />
        <label for="name">Email:</label>
        <input type="email" name="email" required />
        <label for="subject">Subject:</label>
        <input type="text" name="subject" required>
        <label for="message" name="message" required>Message:</label>
        <button type="submit">Submit</button>
    </form>
</body>
</html>

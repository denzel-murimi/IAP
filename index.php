<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>This my page</h1>
    <?php
    require_once"load.php";
    print $Obj->user_age("Zirkzee",2002);
    print'<br>';

    ?>
</body>
</html>
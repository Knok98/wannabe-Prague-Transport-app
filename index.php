<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Kdy pojede nejblizsi spoj</title>
</head>
<body>
<?php
?>
<div class="findRoute">
    <form action="controllers/processQuery.php" method="post" id="routeQuery">
        <div class="inputFields">
        <input type="text" placeholder="odkud" class="route from" name="routeF">
        <input type="text" placeholder="kam" class="route to" name="routeT">
        </div>
        <button class="submitQ" type="submit">V kolik na zastávce ?</button>
    </form>
</div>
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="functions.js"></script>
</body>
</html>


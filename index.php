<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src=https://code.jquery.com/jquery-latest.min.js></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <title>Kdy pojede nejblizsi spoj</title>
</head>

<body>
    <?php
    ?>
    <div class="findRoute">
        <form action="App/processQuery.php" method="post" id="routeQuery">
            <div class="inputFields">
                <input type="text" placeholder="odkud" class="route from" name="routeF">
                <input type="text" placeholder="kam" class="route to" name="routeT">
                <input type="number" name="idDiv" hidden>
            </div>
            <button class="submitQ" type="submit" id="send">V kolik na zastávce ?</button>
        </form>
    </div>
    <script src="ajax.js"></script>

</body>

</html>
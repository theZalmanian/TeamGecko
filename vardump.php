<html lang="en">
    <head>
        <title>PHP Test</title>
    </head>
    <body>
        <?php echo "<p>POST</p>"; ?>
        <pre>
            <?php echo var_dump($_POST); ?>
        </pre>

        <?php echo "<p>GET</p>"; ?>
        <pre>
            <?php echo var_dump($_GET); ?>
        </pre>
    </body>
</html>
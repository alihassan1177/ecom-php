<?php

/** @var array $data */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data["page-info"]["title"] ?? "" ?> - Next Sportswear</title>
    <?php

    use App\Functions;

    Functions::Scripts();
    ?>
</head>

<body style="min-height: 100vh;">
    <header>
        <h3>Header</h3>
    </header>
    
    <main>
        {{content}}
    </main>

</body>

</html>
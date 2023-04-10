<?php

/** @var array $data */
?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php 
    
    use App\Functions;

    Functions::PageHead($data);
    Functions::Scripts();

    ?>
</head>

<body style="min-height: 100vh;">
    <header>
        <?php 
        
        echo "<pre>";

        print_r($_ENV);

        ?>
        <h3>Header</h3>
    </header>
    
    <main>
        {{content}}
    </main>

</body>

</html>
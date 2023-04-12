<?php

$products = $data["data"]["products"];
foreach ($products as $product) {
    echo html_entity_decode($product["description"]);
}
?>

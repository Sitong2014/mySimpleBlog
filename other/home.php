<?php
    require("./page.php");
    $homePage = new page();
    $homePage -> content = "<div>this is homePage.<div>";
    $homePage -> Display();
?>
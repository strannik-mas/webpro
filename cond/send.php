<?php
    if(isset($_POST["email"])){
        $headers  = "Content-type: text/html; charset=utf-8 \r\n";
        $headers .= "From: Магазин кондиционеров <supercooller@example.com>\r\n";
        mail($_POST["email"], "Заказ на кондиционеры", $_SESSION["mes"], $headers);
            
    }
?>

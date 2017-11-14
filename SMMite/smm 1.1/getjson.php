<?php
    $params = array(
        'vkGroupId'     => $_GET['vkGroupId']
    );
    $jsonData = file_get_contents($_GET['url'] . '?' . urldecode(http_build_query($params)));
    echo $jsonData;
?>
<?php
require_once '../../src/includes/loader.php';

if(!empty($_POST['message']) && !empty($_POST['author']) && !empty($_POST['channel']) && is_numeric($_POST['channel'])){
    if(mb_strlen($_POST['message']) > 0 && mb_strlen($_POST['author']) > 2){
        createMessage($database, intval($_POST['channel']), htmlspecialchars($_POST['author']), htmlspecialchars($_POST['message']));
    }
    die;
}

if(!empty($_GET['id']) && is_numeric($_GET['id'])){
    echo json_encode(getMessages($database, intval($_GET['id'])));
    die;
}

echo json_encode(['status' => 'error', 'message' => 'Access denied !']);

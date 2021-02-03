<?php
if(empty($_GET['id']) || !is_numeric($_GET['id']) || empty($_GET['pseudo']) || mb_strlen($_GET['pseudo']) < 3){
    header('Location: /');
    die;
}

require_once '../src/includes/loader.php';

$channel = getChannel($database, intval($_GET['id']));
if($channel == null) {
    header('Location: /');
    die;
}

$links = '<meta name="pseudo" content="'.htmlspecialchars($_GET['pseudo']).'"/>';
$links .= '<meta name="channel" content="'.$_GET['id'].'"/>';
$links .= '<script src="/assets/js/channels.js" defer></script>';
include_once '../src/views/header.php';

include_once '../src/views/chat.php';

include_once '../src/views/footer.php';

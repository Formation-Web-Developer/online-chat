<?php
require_once '../../src/includes/loader.php';

if(!empty($_POST['create']))
{
    if(!empty($_POST['author']) && mb_strlen($_POST['author']) > 2){
        if(!empty($_POST['channel']) && mb_strlen($_POST['channel']) > 3){
            $id = createChannel($database, htmlspecialchars($_POST['author']), htmlspecialchars($_POST['channel']));
            $response = [
                'status'  => 'success',
                'type'    => 'redirect',
                'href'    => '/channel.php?id=' . $id . '&pseudo=' . urlencode(htmlspecialchars($_POST['author']))
            ];
        }else{
            $response = [
                'status'  => 'error',
                'type'    => 'channel',
                'message' => 'Ce champs doit-être renseigné et faire plus de 3 caractères.'
            ];
        }
    }else{
        $response = [
            'status'  => 'error',
            'type'    => 'author',
            'message' => 'Ce champs doit-être renseigné et faire plus de 2 caractères.'
        ];
    }
}
else
{
    $response = getChannels($database);
}

echo json_encode($response);

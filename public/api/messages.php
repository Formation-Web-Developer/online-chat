<?php
require_once '../../src/includes/loader.php';

if(!empty($_POST['message']) && !empty($_POST['author']) && !empty($_POST['channel']) && is_numeric($_POST['channel'])){
    if(mb_strlen($_POST['message']) > 0 && mb_strlen($_POST['author']) > 2){
        $reg_exUrl = "/http[s]{0,1}\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        $message = $_POST['message'];
        $data = null;

        $extensions = ["gif", "jpg", "jpeg", "png", "tiff", "tif"];

        $urlValid = [
            'images' => [],
            'url'   => []
        ];

        while (preg_match($reg_exUrl, $message, $urls) && (count($urlValid['images']) === 0 || count($urlValid['url']) === 0))
        {
            if(count($urls) > 0){
                $url = $urls[0];
                $urlExt = pathinfo($url, PATHINFO_EXTENSION);
                if (in_array($urlExt, $extensions)) {
                    if(count($urlValid['images']) !== 1){
                        $urlValid['images'][] = $url;
                    }
                }else{
                    if(count($urlValid['url']) !== 1){
                        $urlValid['url'][] = $url;
                    }
                }
                $message = str_replace($url, ' ', $message);
            }
        }

        if(count($urlValid['images']) > 0 || count($urlValid['data']) > 0) {
            $data = json_encode($urlValid);
        }
        createMessage($database, intval($_POST['channel']), htmlspecialchars($_POST['author']), $message, $data);
    }
    die;
}

if(!empty($_GET['id']) && is_numeric($_GET['id'])){
    echo json_encode(getMessages($database, intval($_GET['id'])));
    die;
}

echo json_encode(['status' => 'error', 'message' => 'Access denied !']);

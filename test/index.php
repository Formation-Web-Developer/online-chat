<?php


$reg_exUrl = '/http[s]{0,1}\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/';

$message = 'Test: https://www.imagesdepinal.com/4358-home_default_2x/lithographie-creatures-fantastiques-par-fortifem.jpg';

echo 'start'.PHP_EOL;
$data = null;
$extensions = ["gif", "jpg", "jpeg", "png", "tiff", "tif"];

if(preg_match($reg_exUrl, $message, $urls)){
    $urlValid = [
        'images' => [],
        'url'   => []
    ];
    foreach ($urls as $url){
        $urlExt = pathinfo($url, PATHINFO_EXTENSION);
        if (in_array($urlExt, $extensions)) {
            if(count($urlValid['images']) !== 1){
                $urlValid['images'][] = $url;
            }
        }else{
            $urlValid['url'][] = $url;
        }
        $message = str_replace($url, ' ', $message);
    }
    $data = json_encode($urlValid);
}
if($data != null){
    echo $data.PHP_EOL;
}
echo 'end';

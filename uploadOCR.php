<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {

    $url = 'http://127.0.0.1:5000/process_image/upload-image';

    $image = $_FILES['image']['tmp_name'];
    $imageName = $_FILES['image']['name'];
    $longi = $_POST["Longitude"];
    $lati = $_POST["Latitude"];
    $username = $_POST["UserID"];

    $ch = curl_init();

    $cfile = new CURLFile($image, $_FILES['image']['type'], $imageName);

    $data = array('image' => $cfile,
        'longitude' => $longi,
        'latitude' => $lati,
        'username' => $username

                     );

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'Error: ' . curl_error($ch);
    } else {
        echo 'Response from server: ' . $response;
    }

    curl_close($ch);
} else {
    echo "No image uploaded or invalid request method.";
}
?>

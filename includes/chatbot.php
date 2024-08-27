<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');
    $message = $_POST['message'];

    $url = 'http://127.0.0.1:5000/predict';
    $data = json_encode(array('message' => $message));

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data,
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo json_encode(array('answer' => 'Error communicating with chatbot.'));
        exit();
    }

    $response = json_decode($result, true);
    echo json_encode(array('answer' => $response['answer']));
    exit();
}
?>

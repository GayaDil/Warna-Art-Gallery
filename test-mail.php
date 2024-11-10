<?php

require 'config.php';


$template = file_get_contents('email/password-reset.tpl');

$reciever_name = 'Test Username';
$password_reset_link = '8913ab7a155659871df21ba2634bfa06fc202186';

$reset_btn = $app_url.'reset-password?reset='.$password_reset_link;

$template = str_replace("<!-- #{resetButton} -->", $reset_btn, $template);
$template = str_replace("<!-- #{userFullName} -->", $reciever_name, $template);

echo $template;
exit();

$data = array(
    'sender' => array(
        'name' => 'Warna.lk',
        'email' => 'info@warna.lk',
    ),

    'to' => array([
            'name' => 'Gayanthi',
            'email' => 'gdsenev@gmail.com',
        ],
    ),
    'subject' => 'Warna Test mail',
    'htmlContent' => $template
);

$payload = json_encode($data);

$headers = [
    'Accept: application/json',
    'api-key: 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',
    'content-type: application/json'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://api.sendinblue.com/v3/smtp/email");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,$payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$server_output = curl_exec ($ch);
curl_close ($ch);

print_r($server_output);



?>
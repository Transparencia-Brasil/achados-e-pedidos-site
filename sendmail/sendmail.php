<?php
require_once "Mail.php";

$from = '<contato@achadosepedidos.org.br>';
$to = '<send2paulo@gmail.com>';
$subject = 'Hi!';
$body = "Hi,\n\nHow are you?";

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
);

$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'xxxxx@xxxx.org.br',
        'password' => 'xxxxxx'
    ));


if (PEAR::isError($smtp)) {
    echo $smtp->getMessage() . "\n" . $smtp->getUserInfo() . "\n";
    die();
}
$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
} else {
    echo('<p>Message successfully sent!</p>');
}
?>

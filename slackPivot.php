<?php

// Get this from Slack: Browse Apps -> Custom Integrations -> Incoming WebHooks
$slackURL = "https://hooks.slack.com/services/...";

// Pull the alert name for the message title and remove the signature because it's long and not very useful here
$alert_name = $_POST['alert_name'];
unset($_POST['alert_name']);
unset($_POST['p_signature']);

// Bold the field keys (and do any other additional formatting)
$attachmentText = "";
foreach ($_POST as $key => $value) {
    $attachmentText .= "*" . $key . "*" . " : " . $value . "\n";
}

// Make your message
$message = array(
    'payload' => json_encode(array(
        'text' => "*" . $alert_name . "*",
        'attachments' => array(
            array(
                'text' => $attachmentText,
                'mrkdwn_in' => array(
                    'text'
                )
            )
        )
    ))
);

$c = curl_init($slackURL);
curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($c, CURLOPT_POST, true);
curl_setopt($c, CURLOPT_POSTFIELDS, $message);
curl_exec($c);
curl_close($c);

?>

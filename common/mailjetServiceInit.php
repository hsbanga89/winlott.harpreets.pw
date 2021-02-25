<?php

// Details changed due to security reasons
include '/mailjet/vendor/autoload.php';

use \Mailjet\Resources;

function sendEmail($u_email, $u_name, $u_subject, $u_message)
{
    $pub_key = 'public-key';
    $private_key = 'private-key';

    $mj = new \Mailjet\Client($pub_key, $private_key, true, ['version' => 'v3.1']);
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => $u_email,
                    'Name' => $u_name
                ],
                'To' => [
                    [
                        'Email' => "user@email.com",
                        'Name' => "Winlott - User Mail"
                    ]
                ],
                'Subject' => $u_subject,
                'TextPart' => $u_message
            ]
        ]
    ];

    return $mj->post(Resources::$Email, ['body' => $body]);
}
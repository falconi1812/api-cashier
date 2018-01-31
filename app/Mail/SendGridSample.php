<?php

namespace App\Mail;

use Sichikawa\LaravelSendgridDriver\SendGrid;
use Illuminate\Mail\Mailable;

class SendGridSample extends Mailable {
    use SendGrid;

    public function build()
    {
        return $this
            ->subject('sdfsd')
            ->from('from@example.com')
            ->to(['thefalcon1812@hotmail.com'])
            ->embedData([
                'personalizations' => [
                    [
                        'to' => [
                            'email' => 'user1@example.com',
                            'name' => 'user1',
                        ],
                        'substitutions' => [
                            '-email-' => 'user1@example.com',
                        ],
                    ],
                    [
                        'to' => [
                            'email' => 'user2@example.com',
                            'name' => 'user2',
                        ],
                        'substitutions' => [
                            '-email-' => 'user2@example.com',
                        ],
                    ],
                ],
                'categories' => ['user_group1'],
                'custom_args' => [
                    'user_id' => "123" // Make sure this is a string value
                ],
                'template_id' => 'your-template-id'
            ], 'sendgrid/x-smtpapi');
    }
}

?>

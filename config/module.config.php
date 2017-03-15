<?php

namespace SzmNoty;

return [
    'view_helpers' => [
        'aliases' => [
            'notification' => View\Helper\Notification::class
        ],
        'factories' => [
            View\Helper\Notification::class => Factory\View\Helper\NotificationFactory::class
        ]
    ],
];
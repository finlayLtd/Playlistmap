<?php


return [
   'assets_version' => filemtime(public_path() . '/css/style.css'),
    'no_record' => 'No Records Found',
    'template_placeholders' => [
        'playlistOwner', 'playlistName', 'playlistURL', 'trackLink', 'userFullName'
    ],

    'user_statuses' => [
        1 => 'Active',
        2 => 'Pending',
        3 => 'Inactive',
        4 => 'Banned',
        5 => 'Deleted'
    ]
];

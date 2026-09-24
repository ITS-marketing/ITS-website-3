<?php

return [
    'type' => 'cta_card',
    'data' => [
        'background_image' => 'media/hero-bg.jpg',
        'icon_image' => 'media/its-beeldmerk.png',
        'title' => "We begrijpen dat IT\nlastig kan zijn",
        'body' => "Daarom nemen wij het volledig van je over.\nEén gesprek is genoeg.",
        'button' => ['label' => 'Ga vrijblijvend in gesprek', 'url' => '/contact'],
        'show_contact' => true,
        'logos' => [
            ['image' => 'media/certs/ms-modern-work.png', 'alt' => 'Microsoft 365 Solution Partner Modern Work'],
            ['image' => 'media/certs/ms-azure.png', 'alt' => 'Microsoft Infrastructure & Azure'],
        ],
        'anchor' => null,
    ],
];

<?php

$card = fn (string $category, string $title, string $url, ?string $image = null, ?string $from = null, ?string $to = null) => [
    'category' => $category,
    'title' => $title,
    'url' => $url,
    'image' => $image,
    'gradient_from' => $from,
    'gradient_to' => $to,
];

return [
    'type' => 'card_slider',
    'data' => [
        'eyebrow' => 'Ontdek meer',
        'title' => 'Misschien is dit ook iets voor jou',
        'intro' => null,
        'background' => 'white',
        'read_more_label' => 'Lees meer',
        'anchor' => null,
        'cards' => [
            $card('Ons team', 'Maak kennis met ons team', '/over-ons/team', 'media/its-team-juichen.jpg'),
            $card('Over IT Synergy', 'Wie is IT Synergy?', '/over-ons', 'media/its-hero-over-ons.jpg'),
            $card('IT Synergy Academy', 'Ontdek de IT Synergy Academy', '/academy', null, '#C2540A', '#7A3300'),
            $card('Werken bij', 'Kom werken bij IT Synergy', '/werken-bij', 'media/its-oprichters.jpg'),
            $card('Blog', 'Wat is VoIP telefonie en waarom is het slimmer?', '/academy?type=blog', null, '#0066CC', '#003380'),
            $card('Blog', 'Microsoft 365 volledig uitgelegd', '/academy?type=blog', null, '#005CB8', '#002966'),
            $card('Blog', 'Alles wat je moet weten over NIS2', '/academy?type=blog', null, '#0052A3', '#001F4D'),
        ],
    ],
];

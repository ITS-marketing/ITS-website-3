<?php

return [
    'type' => 'hero',
    'data' => [
        'badge_emoji' => '🏆',
        'badge_text' => "Microsoft Gold Partner & FD Gazellen '25",
        'title' => "Houden van ICT door\nslimme,\nveilige en schaalbare IT oplossingen.",
        'title_responsive_breaks' => true,
        'body' => '<p>Als fullservice ICT bedrijf richten we de volledige ICT omgeving van MKB en grote bedrijven in. Dit vatten we samen in <strong>de online werkplek</strong>; ons complete pakket aan ICT diensten.</p>',
        'stats' => [
            '500+ tevreden klanten',
            '15+ jaar ervaring',
            '2 vestigingen in Rotterdam en Mijdrecht',
        ],
        'trust_labels' => [
            ['emoji' => '🏆', 'text' => 'Microsoft Gold Partner'],
            ['emoji' => '📈', 'text' => "FD Gazellen '25"],
            ['emoji' => '🔒', 'text' => 'ISO 27001'],
        ],
        'anchor' => null,

        'primary_button' => ['label' => 'Laten we samenwerken', 'url' => '/contact', 'emoji' => '🖥️'],
        'secondary_button' => ['label' => 'Bereken je IT kosten', 'url' => '/kosten-berekenen'],
        'show_scroll_button' => true,
        'scroll_button_label' => 'Scroll verder',

        'quicklinks' => [
            ['emoji' => '💻', 'title' => 'Alles over de online werkplek', 'subtitle' => 'Onze slimme alles-in-1 dienstverlening', 'url' => '/online-werkplek'],
            ['emoji' => '💙', 'title' => 'ICT om van te houden', 'subtitle' => 'Hoe doen we dat eigenlijk?', 'url' => '/over-ons'],
            ['emoji' => '🎧', 'title' => 'Support aanvragen', 'subtitle' => 'Voor klanten van IT Synergy', 'url' => '/support'],
        ],

        'photo_strip_speed' => 0.7,
        'photo_strip' => [
            ['image' => 'media/its-oprichters.jpg', 'alt' => 'Het team van IT Synergy', 'caption' => 'Ons team in Mijdrecht', 'width' => 350, 'rotation' => 1, 'type' => 'photo', 'video_url' => null],
            ['image' => 'media/its-team-juichen.jpg', 'alt' => 'Het team van IT Synergy juicht', 'caption' => 'Wie wij zijn in 1 minuut.', 'width' => 620, 'rotation' => -0.8, 'type' => 'video', 'video_url' => null],
            ['image' => 'media/ict-liefde.jpg', 'alt' => 'ICT om van te houden', 'caption' => 'ICT om van te houden', 'width' => 780, 'rotation' => 1.2, 'type' => 'photo', 'video_url' => null],
            ['image' => 'media/hero-sales.jpg', 'alt' => 'IT Synergy', 'caption' => 'Persoonlijk advies op locatie', 'width' => 520, 'rotation' => -1, 'type' => 'photo', 'video_url' => null],
            ['image' => 'media/its-kuip.jpg', 'alt' => 'Achter de schermen bij IT Synergy', 'caption' => 'Een kijkje achter de schermen', 'width' => 620, 'rotation' => 0.8, 'type' => 'video', 'video_url' => null],
            ['image' => 'media/cases/koers.jpg', 'alt' => 'Klantcase', 'caption' => 'Klantcase: Koers', 'width' => 640, 'rotation' => -1.3, 'type' => 'photo', 'video_url' => null],
            ['image' => 'media/blog-wouter.jpg', 'alt' => 'Wouter van IT Synergy', 'caption' => 'Wouter — IT specialist', 'width' => 370, 'rotation' => 1, 'type' => 'photo', 'video_url' => null],
            ['image' => 'media/pdc-hero.jpg', 'alt' => 'Producten & diensten', 'caption' => 'Ons volledig dienstenaanbod', 'width' => 720, 'rotation' => -0.8, 'type' => 'photo', 'video_url' => null],
        ],

        'background_image' => 'media/hero-bg.jpg',
    ],
];

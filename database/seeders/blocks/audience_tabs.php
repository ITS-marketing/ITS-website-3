<?php

$kpis = ['98%', '11k', '< 4u'];

return [
    'type' => 'audience_tabs',
    'data' => [
        'eyebrow' => 'ICT Dienstverlener uit Rotterdam en Mijdrecht',
        'title_prefix' => 'Zo laten wij',
        'rotating_words' => ['iedereen', 'managers', 'gebruikers'],
        'title_suffix' => 'van ICT houden',
        'rotate_interval_ms' => 2800,
        'default_tab' => 'ICT voor gebruikers',
        'anchor' => null,
        'tabs' => [
            [
                'label' => 'ICT voor iedereen',
                'mockup_color' => 'primary',
                'title' => 'Eén ICT omgeving die voor iedereen werkt',
                'description' => 'Of je nu manager, medewerker of eindgebruiker bent — wij zorgen dat technologie nooit in de weg staat. Met een slimme, stabiele en veilige omgeving laten wij iedereen binnen jouw organisatie van ICT houden.',
                'bullets' => [
                    'Één aanspreekpunt voor de hele organisatie',
                    'Altijd bereikbaar, ongeacht locatie of apparaat',
                    'Schaalbaar meegroeiend met jouw bedrijf',
                ],
                'link' => ['label' => 'Alles over IT Synergy', 'url' => '/over-ons'],
                'stats' => [
                    ['value' => '500+', 'label' => 'Tevreden klanten'],
                    ['value' => '15+', 'label' => 'Jaar ervaring'],
                ],
                'mockup_kpis' => $kpis,
                'image' => null,
            ],
            [
                'label' => 'ICT voor gebruikers',
                'mockup_color' => 'blue',
                'title' => 'Een slimme Microsoft 365 online werkplek',
                'description' => 'Een all-in ICT pakket in de cloud voor jouw onderneming. Wij beheren en beveiligen jouw volledige IT omgeving en zorgen dat systemen altijd werken met persoonlijke on- en offsite support.',
                'bullets' => [
                    'Microsoft 365 & Teams volledig ingericht',
                    'Persoonlijke helpdesk support on- en offsite',
                    'Veilig werken vanaf elke locatie',
                ],
                'link' => ['label' => 'Alles over de online werkplek', 'url' => '/online-werkplek'],
                'stats' => [
                    ['value' => '11k+', 'label' => 'Gebruikers in beheer'],
                    ['value' => '9+', 'label' => 'Klanttevredenheid'],
                ],
                'mockup_kpis' => $kpis,
                'image' => null,
            ],
            [
                'label' => 'ICT voor managers',
                'mockup_color' => 'dark',
                'title' => 'Volledige controle over jouw IT omgeving',
                'description' => 'Realtime inzicht in jouw IT omgeving, kosten en performance. Neem beslissingen op basis van data en voorspelbare maandelijkse kosten, terwijl wij de dagelijkse IT volledig uit handen nemen.',
                'bullets' => [
                    'Maandelijkse rapportage & inzicht in kosten',
                    'Proactief beheer met 99,9% uptime garantie',
                    'Vaste prijs per gebruiker, geen verrassingen',
                ],
                'link' => ['label' => 'Alles over managed IT services', 'url' => '/managed-service-provider'],
                'stats' => [
                    ['value' => '99,9%', 'label' => 'Uptime garantie'],
                    ['value' => '< 4u', 'label' => 'Gemiddelde responstijd'],
                ],
                'mockup_kpis' => $kpis,
                'image' => null,
            ],
        ],
    ],
];

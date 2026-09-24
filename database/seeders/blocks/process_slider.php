<?php

return [
    'type' => 'process_slider',
    'data' => [
        'eyebrow' => 'Zo werken wij',
        'title' => 'Ons bewezen verbeterproces',
        'intro' => 'Een gestructureerd proces voor een soepele overstap én een IT omgeving die blijft verbeteren.',
        'link' => ['label' => 'Lees meer over onze werkwijze', 'url' => '/over-ons/werkwijze'],
        'anchor' => null,
        'phases' => [
            ['name' => 'Onboarding', 'color' => '#0072CC'],
            ['name' => 'Evergreening', 'color' => '#2BA84A'],
        ],
        'steps' => [
            [
                'label' => 'Inventarisatie',
                'phase' => 'Onboarding',
                'image' => 'media/how-we-work/step-1.jpg',
                'title' => 'Overstappen naar IT Synergy',
                'text' => 'We inventariseren je huidige IT omgeving en doen er alles aan om de migratie zonder downtime te laten verlopen.',
                'loop_badge' => null,
            ],
            [
                'label' => 'Plan van aanpak',
                'phase' => 'Onboarding',
                'image' => 'media/how-we-work/step-2.jpg',
                'title' => 'Een helder projectvoorstel',
                'text' => 'Op basis van de inventarisatie stellen wij een concreet plan van aanpak op voor jouw onboarding bij IT Synergy.',
                'loop_badge' => null,
            ],
            [
                'label' => 'Project',
                'phase' => 'Onboarding',
                'image' => 'media/how-we-work/step-3.jpg',
                'title' => 'Migratie naar IT Synergy',
                'text' => 'Onze engineers zorgen voor een soepele migratie van jouw IT omgeving, zonder verstoringen voor jouw team.',
                'loop_badge' => null,
            ],
            [
                'label' => 'Technische standaard',
                'phase' => 'Evergreening',
                'image' => 'media/how-we-work/step-4.jpg',
                'title' => 'Jouw omgeving op onze standaard',
                'text' => 'Na het project brengen wij jouw omgeving naar onze bewezen IT standaard — de basis voor continu verbeteren.',
                'loop_badge' => null,
            ],
            [
                'label' => 'Audit',
                'phase' => 'Evergreening',
                'image' => 'media/how-we-work/step-5.jpg',
                'title' => 'Periodieke audit op 150+ punten',
                'text' => 'We controleren jouw IT omgeving regelmatig op meer dan 150 punten om kwaliteit en veiligheid te waarborgen.',
                'loop_badge' => null,
            ],
            [
                'label' => 'Strategie',
                'phase' => 'Evergreening',
                'image' => 'media/how-we-work/step-6.jpg',
                'title' => 'IT roadmap op maat',
                'text' => 'Op basis van de audit stellen we samen een strategie en roadmap op voor de komende kwartalen.',
                'loop_badge' => null,
            ],
            [
                'label' => 'Project',
                'phase' => 'Evergreening',
                'image' => 'media/how-we-work/step-7.jpg',
                'title' => 'Continu verbeteren',
                'text' => 'Elk nieuw project verbetert jouw omgeving verder — waarna de cyclus opnieuw begint bij stap 4.',
                'loop_badge' => 'Cyclus herhaalt vanaf stap 4',
            ],
        ],
    ],
];

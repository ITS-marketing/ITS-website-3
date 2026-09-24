<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $item = fn (string $emoji, string $title, string $description, string $url) => compact('emoji', 'title', 'description', 'url');

        $blog = fn (string $title, ?string $image = null, string $category = 'Blog', string $url = '/academy?type=blog') => compact('category', 'title', 'url', 'image');

        $cloudBlog = $blog('Zo kies je de juiste cloud strategie voor jouw bedrijf');
        $culture = $blog('Zo bouwen we aan een IT bedrijf waar iedereen van houdt', null, 'Over ons', '/over-ons/cultuur');

        Setting::setMany([
            'general' => [
                'site_name' => 'IT Synergy',
                'meta_title' => 'IT Synergy — Houden van ICT door slimme, veilige en schaalbare IT oplossingen',
                'meta_description' => 'IT Synergy biedt complete IT oplossingen voor het MKB. Van cloudoplossingen en cybersecurity tot managed IT services en Microsoft 365.',
                'logo' => 'media/logo.png',
                'logo_white' => 'media/its-logo-wit.png',
            ],

            'contact' => [
                'phone' => '010 30 31 930',
                'phone_link' => 'tel:+310103031930',
                'email' => 'hi@itsynergy.nl',
                'portal_url' => '#',
                'kvk' => '72760583',
                'btw' => 'NL859227042B01',
                'iban' => 'NL63 INGB 000 607 26 38',
            ],

            'header' => [
                'cta' => ['label' => 'Contact', 'url' => '/contact'],
                'mobile_cta' => ['label' => 'Offerte aanvragen', 'url' => '/contact'],
                'show_language' => true,
                'show_contrast' => true,
                'nav' => [
                    [
                        'label' => 'Online Werkplek', 'url' => '/online-werkplek', 'emoji' => '💻', 'group' => 'services', 'columns' => 2,
                        'tagline' => 'Ontworpen om medewerkers veilig en efficiënt te laten werken.',
                        'items' => [
                            $item('👤', 'Managed Users', 'Volledig beheer van gebruikersaccounts, rechten en identiteiten.', '/online-werkplek/managed-user'),
                            $item('💻', 'Managed Endpoints', 'Beheer en beveiliging van alle devices in jouw organisatie.', '/online-werkplek/managed-endpoint'),
                            $item('🟦', 'Microsoft 365', 'De complete Microsoft suite als basis van jouw werkplek.', '/online-werkplek/microsoft365'),
                            $item('🖥️', 'Azure Virtual Desktop', 'Virtuele Windows-werkplek vanuit de cloud, veilig op elk apparaat.', '/online-werkplek/azure-virtual-desktop'),
                            $item('🌐', 'Managed Netwerk', 'Betrouwbare netwerkinfrastructuur voor kantoor en meerdere locaties.', '/online-werkplek/managed-netwerk'),
                            $item('✨', 'Werkplek add-ons', 'Slimme uitbreidingen die jouw werkplek nog productiever maken.', '/online-werkplek/add-ons'),
                        ],
                        'featured' => $blog('Zo kies je de juiste IT partner voor jouw bedrijf', 'media/blog-wouter.jpg'),
                    ],
                    [
                        'label' => 'Managed Service Provider', 'url' => '/managed-service-provider', 'emoji' => '⚙️', 'group' => 'services', 'columns' => 2,
                        'tagline' => 'Onze experts staan iedere dag klaar om jou te helpen.',
                        'items' => [
                            $item('⚙️', 'IT Beheer', 'Proactief beheer van jouw volledige IT omgeving, 24/7 gemonitord.', '/managed-service-provider/it-beheer'),
                            $item('🎧', 'IT Support', 'Persoonlijke helpdesk support on- en offsite voor al jouw medewerkers.', '/managed-service-provider/it-support'),
                            $item('🏗️', 'IT Consultancy & Projecten', 'Van advies tot oplevering — wij begeleiden jouw IT projecten.', '/managed-service-provider/it-consultancy'),
                            $item('🧭', 'IT Strategie', 'Strategisch IT advies afgestemd op de groei van jouw organisatie.', '/managed-service-provider/it-strategie'),
                            $item('🔄', 'Evergreening', 'Jouw omgeving altijd up-to-date met de laatste versies.', '/managed-service-provider/evergreening'),
                            $item('🎓', 'IT Trainingen', 'Effectief gebruikmaken van Microsoft 365 en security awareness.', '/managed-service-provider/it-trainingen'),
                        ],
                        'featured' => $blog('IT volledig uitbesteden: wat levert het jou op?'),
                    ],
                    [
                        'label' => 'IT Security', 'url' => '/it-security', 'emoji' => '🛡️', 'group' => 'services', 'columns' => 2,
                        'tagline' => 'Security is geen luxe, maar noodzaak. Wij zorgen dat je compliant bent.',
                        'items' => [
                            $item('🛡️', 'Security technieken', 'Geavanceerde technieken om jouw omgeving te beschermen tegen moderne dreigingen.', '/it-security/cybersecurity-technieken'),
                            $item('📋', 'Duidelijke processen', 'Heldere security processen en beleid zodat iedereen weet wat te doen.', '/it-security/cybersecurity-processen'),
                            $item('🧑‍💼', 'Personeels awareness', 'Medewerkers zijn de eerste verdedigingslinie — wij maken ze bewust.', '/it-security/cybersecurity-voor-personeel'),
                            $item('🇪🇺', 'NIS2', 'Voldoe aan de Europese NIS2-richtlijn en zorg voor aantoonbare compliance.', '/it-security/cybersecurity-processen/compliance'),
                            $item('🔍', '24x7 SOC', 'Doorlopende bewaking van jouw Microsoft 365 omgeving.', '/it-security/cybersecurity-processen/soc'),
                            $item('🎣', 'Phishing simulaties', 'Test en train de alertheid van jouw medewerkers.', '/it-security/cybersecurity-voor-personeel/phishing-simulaties'),
                        ],
                        'featured' => $blog('Alles wat je moet weten over NIS2 compliance'),
                    ],
                    [
                        'label' => 'IT Infrastructuur', 'url' => '/it-infrastructuur', 'emoji' => '🏗️', 'group' => 'services', 'columns' => 2,
                        'tagline' => 'Solide, schaalbare infrastructuur — on-premise, hybride of volledig in de cloud.',
                        'items' => [
                            $item('🏢', 'On-premise', 'Lokale serverinfrastructuur volledig beheerd.', '/it-infrastructuur/on-premise'),
                            $item('🔀', 'Hybride cloud', 'Combinatie van lokale en cloudinfrastructuur.', '/it-infrastructuur/hybride-cloud'),
                            $item('🔵', 'Microsoft Azure', 'Schaalbare cloudinfrastructuur van Microsoft.', '/it-infrastructuur/microsoft-azure'),
                            $item('🌐', 'Cloud hosting', 'Servers en applicaties in de cloud.', '/it-infrastructuur/microsoft-azure/cloud-hosting'),
                            $item('🚚', 'Cloud migratie', 'Veilige migratie naar de cloud.', '/it-infrastructuur/microsoft-azure/cloud-migratie'),
                        ],
                        'featured' => $cloudBlog,
                    ],
                    [
                        'label' => 'A.I. Oplossingen', 'url' => '/ai-oplossingen', 'emoji' => '🤖', 'group' => 'services', 'columns' => 2,
                        'tagline' => 'Slimme automatisering en AI integraties voor maximale tijdsbesparing.',
                        'items' => [
                            $item('⚡', 'AI Automatiseringen', 'Automatiseer processen met kunstmatige intelligentie.', '/ai-oplossingen/ai-automatiseringen'),
                            $item('🧭', 'AI Strategie', 'Een doordacht plan voor AI-adoptie binnen jouw organisatie.', '/ai-oplossingen/ai-strategie'),
                            $item('🚀', 'AI Adoptie', 'Begeleiding bij het daadwerkelijk gaan werken met AI.', '/ai-oplossingen/ai-adoptie'),
                            $item('🪄', 'Microsoft Copilot', 'AI-assistent geïntegreerd in jouw Microsoft 365 omgeving.', '/ai-oplossingen/microsoft-copilot'),
                            $item('🎓', 'AI Trainingen', 'Praktische trainingen om AI effectief in te zetten.', '/ai-oplossingen/ai-trainingen'),
                        ],
                        'featured' => $cloudBlog,
                    ],
                    [
                        'label' => 'Connectiviteit', 'url' => '/connectiviteit', 'emoji' => '📞', 'group' => 'services', 'columns' => 2,
                        'tagline' => 'Zakelijk bellen en verbonden zijn via de cloud. Vast, mobiel of via Microsoft Teams.',
                        'items' => [
                            $item('🌐', 'Internet', 'Betrouwbare internetverbindingen voor kantoor en meerdere locaties.', '/connectiviteit/internet'),
                            $item('📞', 'VoIP Telefonie', 'Zakelijk bellen via de cloud: vast, mobiel of via Microsoft Teams.', '/connectiviteit/voip-telefonie'),
                            $item('☁️', 'VoIP hosting', 'Telefooncentrale volledig in de cloud.', '/connectiviteit/voip-telefonie/voip-hosting'),
                            $item('📱', 'Mobiele telefonie', 'Mobiel bereikbaar met jouw bedrijfsnummer, overal.', '/connectiviteit/voip-telefonie/mobiel-bellen'),
                        ],
                        'featured' => $cloudBlog,
                    ],
                    [
                        'label' => 'Branches', 'url' => '/branches', 'emoji' => '🏗️', 'group' => 'other', 'columns' => 2,
                        'tagline' => 'Bewezen IT oplossingen voor jouw branche.',
                        'items' => [
                            $item('🏫', 'Kinderdagverblijven', 'Veilige en betrouwbare IT voor kinderopvang en crèches.', '/it-voor-kinderdagverblijven'),
                            $item('🏗️', 'Bouw & installatie', 'Robuuste IT voor projectbeheer en werkplekken op locatie.', '/it-voor-bouwbedrijven'),
                            $item('🏥', 'Zorg & welzijn', 'NEN 7510-compliant IT voor zorgorganisaties en klinieken.', '/it-voor-de-zorg'),
                            $item('📊', 'Accountancy', 'Veilige en efficiënte IT voor financiële dienstverlening.', '/it-voor-accountancy'),
                        ],
                        'featured' => $blog('Hoe een zorginstelling haar IT volledig uitbesteedde aan IT Synergy', null, 'Klantcase', '/academy/klantcases'),
                    ],
                    [
                        'label' => 'Over ons', 'url' => '/over-ons', 'emoji' => '🏢', 'group' => 'other', 'columns' => 2,
                        'tagline' => 'Leer ons kennen — het team achter IT Synergy.',
                        'items' => [
                            $item('👥', 'Team', 'De mensen achter IT Synergy.', '/over-ons/team'),
                            $item('💛', 'Cultuur', 'Wat ons als bedrijf drijft.', '/over-ons/cultuur'),
                            $item('🌱', 'Impact', 'Onze maatschappelijke impact.', '/over-ons/impact'),
                            $item('📍', 'Vestigingen', 'Rotterdam en Mijdrecht.', '/over-ons/locaties'),
                            $item('🏅', 'Certificeringen', 'Onze keurmerken en certificaten.', '/over-ons/certificeringen'),
                            $item('📋', 'Producten & dienstencatalogus', 'Volledig overzicht van ons aanbod.', '/producten-diensten'),
                        ],
                        'featured' => $culture,
                    ],
                    [
                        'label' => 'Academy', 'url' => '/academy', 'emoji' => '🎓', 'group' => 'other', 'columns' => 2,
                        'tagline' => 'Handleidingen, trainingen, e-books en blogs om jij en je team optimaal te laten werken.',
                        'items' => [
                            $item('🎓', 'Handleidingen & trainingen', "Stap-voor-stap handleidingen en video's om zelf snel verder te komen.", '/academy?type=training'),
                            $item('📰', 'Blogs', 'Nieuws, inzichten en praktische tips over IT en security.', '/academy?type=blog'),
                            $item('📘', 'E-books', 'Diepgaande gidsen om vrijblijvend te downloaden.', '/academy?type=ebook'),
                            $item('📁', 'Klantcases', 'Hoe wij andere bedrijven hielpen met hun IT.', '/academy/klantcases'),
                            $item('🗓️', 'Events', 'Webinars, workshops en Lunch & Learns.', '/academy/events'),
                        ],
                        'featured' => $blog('NIS2: wat betekent het voor accountants?'),
                    ],
                    [
                        'label' => 'Werken bij', 'url' => '/werken-bij', 'emoji' => '💼', 'group' => 'other', 'columns' => 1,
                        'tagline' => 'Bouw mee aan een IT-bedrijf waar iedereen van houdt.',
                        'items' => [
                            $item('📋', 'Alle vacatures', 'Bekijk alle openstaande functies bij IT Synergy.', '/werken-bij/alle-vacatures'),
                            $item('💛', 'Onze cultuur', 'Wat het werken bij IT Synergy zo bijzonder maakt.', '/werken-bij/cultuur'),
                            $item('🤝', 'Voor recruiters', 'Informatie voor recruitment- en wervingspartners.', '/werken-bij/recruitment'),
                        ],
                        'featured' => $culture,
                    ],
                ],
            ],

            'footer' => [
                'tagline' => 'ICT om van te houden',
                'columns' => [
                    ['title' => 'Diensten', 'links' => [
                        ['label' => 'Online Werkplek', 'url' => '/online-werkplek'],
                        ['label' => 'IT Security', 'url' => '/it-security'],
                        ['label' => 'Managed Service Provider', 'url' => '/managed-service-provider'],
                        ['label' => 'IT Infrastructuur', 'url' => '/it-infrastructuur'],
                        ['label' => 'AI Oplossingen', 'url' => '/ai-oplossingen'],
                        ['label' => 'Connectiviteit', 'url' => '/connectiviteit'],
                    ]],
                    ['title' => 'Branches', 'links' => [
                        ['label' => 'Kinderdagverblijven', 'url' => '/it-voor-kinderdagverblijven'],
                        ['label' => 'Bouw', 'url' => '/it-voor-bouwbedrijven'],
                        ['label' => 'Zorg', 'url' => '/it-voor-de-zorg'],
                        ['label' => 'Accountancy', 'url' => '/it-voor-accountancy'],
                    ]],
                    ['title' => 'Over ons', 'links' => [
                        ['label' => 'Team', 'url' => '/over-ons/team'],
                        ['label' => 'Cultuur', 'url' => '/over-ons/cultuur'],
                        ['label' => 'Impact', 'url' => '/over-ons/impact'],
                        ['label' => 'Rotterdam', 'url' => '/over-ons/rotterdam'],
                        ['label' => 'Mijdrecht', 'url' => '/over-ons/mijdrecht'],
                    ]],
                    ['title' => 'Werken bij', 'links' => [
                        ['label' => 'Alle vacatures', 'url' => '/werken-bij'],
                        ['label' => 'Onze cultuur', 'url' => '/werken-bij/cultuur'],
                    ]],
                    ['title' => 'Overig', 'links' => [
                        ['label' => 'Academy', 'url' => '/academy'],
                        ['label' => 'Klantcases', 'url' => '/academy/klantcases'],
                        ['label' => 'Events', 'url' => '/academy/events'],
                        ['label' => 'Producten & diensten', 'url' => '/producten-diensten'],
                    ]],
                ],
                'socials' => [
                    ['short' => 'in', 'name' => 'LinkedIn', 'url' => 'https://linkedin.com/company/itsynergy'],
                    ['short' => 'ig', 'name' => 'Instagram', 'url' => 'https://instagram.com/itsynergy'],
                    ['short' => 'yt', 'name' => 'YouTube', 'url' => 'https://youtube.com/@itsynergy'],
                ],
                'legal' => [
                    ['label' => 'Privacy policy', 'url' => '/privacy'],
                    ['label' => 'Cookiebeleid', 'url' => '/cookies'],
                    ['label' => 'SLA', 'url' => '/sla'],
                    ['label' => 'Sitemap', 'url' => '/sitemap'],
                    ['label' => 'Begrippen', 'url' => '/begrippen'],
                    ['label' => 'Algemene voorwaarden', 'url' => '/algemene-voorwaarden'],
                    ['label' => 'AI beleid', 'url' => '/ai-beleid'],
                ],
                'copyright' => '© :year IT Synergy B.V.',
            ],
        ]);
    }
}

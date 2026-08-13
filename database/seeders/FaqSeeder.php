<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Basisdata voor de FAQ pagina: categorieën met bijhorende vragen/antwoorden.
     */
    public function run(): void
    {
        $data = [
            [
                'name'       => 'Vrijwilliger worden',
                'sort_order' => 1,
                'faqs'       => [
                    [
                        'question' => 'Hoe kan ik vrijwilliger worden bij Humanity First Belgium?',
                        'answer'   => "Maak een account aan op dit platform en vul je profiel in. Een van onze coördinatoren neemt daarna contact met je op om te bespreken welke projecten bij jou passen.",
                    ],
                    [
                        'question' => 'Moet ik ervaring hebben om te kunnen helpen?',
                        'answer'   => "Nee. De meeste taken vragen vooral engagement en betrouwbaarheid. Voor gespecialiseerde projecten (zoals medische missies) zoeken we wel mensen met de juiste opleiding.",
                    ],
                    [
                        'question' => 'Hoeveel tijd wordt er van mij verwacht?',
                        'answer'   => "Dat bepaal je zelf. Sommige vrijwilligers helpen een paar uur per maand bij een lokale actie, anderen nemen een vaste rol op binnen een project.",
                    ],
                    [
                        'question' => 'Is er een minimumleeftijd?',
                        'answer'   => "Je moet minstens 16 jaar zijn om je in te schrijven. Voor activiteiten in het buitenland geldt een minimumleeftijd van 18 jaar.",
                    ],
                ],
            ],
            [
                'name'       => 'Projecten',
                'sort_order' => 2,
                'faqs'       => [
                    [
                        'question' => 'In welke landen zijn jullie actief?',
                        'answer'   => "Naast onze werking in België lopen er projecten in onder andere Togo en Burundi, met focus op water, onderwijs, voedselzekerheid en oogzorg.",
                    ],
                    [
                        'question' => 'Kan ik zelf een project voorstellen?',
                        'answer'   => "Zeker. Stuur je voorstel via het contactformulier. Vermeld het doel, de doelgroep en een inschatting van de nodige middelen.",
                    ],
                    [
                        'question' => 'Organiseren jullie ook acties in België?',
                        'answer'   => "Ja. Denk aan voedselbedelingen, speelgoedacties in asielcentra en inzamelacties bij rampen. Deze staan aangekondigd bij het nieuws op deze site.",
                    ],
                ],
            ],
            [
                'name'       => 'Donaties',
                'sort_order' => 3,
                'faqs'       => [
                    [
                        'question' => 'Waar gaat mijn donatie naartoe?',
                        'answer'   => "Donaties worden toegewezen aan het project van jouw keuze. Zonder specifieke keuze zetten we het bedrag in waar de nood op dat moment het hoogst is.",
                    ],
                    [
                        'question' => 'Krijg ik een fiscaal attest?',
                        'answer'   => "Voor giften vanaf 40 euro per kalenderjaar bezorgen we een fiscaal attest, op voorwaarde dat de erkenning van kracht is op het moment van de gift.",
                    ],
                    [
                        'question' => 'Kan ik goederen doneren in plaats van geld?',
                        'answer'   => "Bij specifieke acties zamelen we goederen in, bijvoorbeeld kleding of speelgoed. Neem contact op om te horen wat we op dit moment nodig hebben.",
                    ],
                ],
            ],
            [
                'name'       => 'Dit platform',
                'sort_order' => 4,
                'faqs'       => [
                    [
                        'question' => 'Wie kan mijn profiel zien?',
                        'answer'   => "Je profielpagina is publiek zichtbaar, ook voor bezoekers zonder account. Vul dus enkel informatie in die je wil delen.",
                    ],
                    [
                        'question' => 'Hoe pas ik mijn gegevens aan?',
                        'answer'   => "Log in en ga naar Profile. Daar wijzig je je gebruikersnaam, verjaardag, profielfoto en je 'over mij' tekst.",
                    ],
                    [
                        'question' => 'Ik ben mijn wachtwoord vergeten. Wat nu?',
                        'answer'   => "Klik op 'Forgot your password?' op de inlogpagina. Je ontvangt een e-mail met een link om een nieuw wachtwoord in te stellen.",
                    ],
                ],
            ],
        ];

        foreach ($data as $categoryData) {
            $category = FaqCategory::create([
                'name'       => $categoryData['name'],
                'sort_order' => $categoryData['sort_order'],
            ]);

            foreach ($categoryData['faqs'] as $index => $faq) {
                Faq::create([
                    'faq_category_id' => $category->id,
                    'question'        => $faq['question'],
                    'answer'          => $faq['answer'],
                    'sort_order'      => $index + 1,
                    'is_public'       => true,
                ]);
            }
        }
    }
}

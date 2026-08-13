<?php

namespace Database\Seeders;

use App\Models\NewsItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Basisdata voor de nieuwspagina. De afbeeldingen blijven leeg (null):
     * uploads worden pas via het admin panel toegevoegd, en de views tonen
     * een nette placeholder wanneer er geen afbeelding is.
     */
    public function run(): void
    {
        $author = User::where('email', 'admin@ehb.be')->first() ?? User::first();

        if (! $author) {
            return;
        }

        $items = [
            [
                'title'        => 'Waterput opgeleverd in Kpalimé',
                'excerpt'      => 'Ruim 400 gezinnen hebben sinds deze maand toegang tot proper drinkwater in de regio Kpalimé.',
                'content'      => "Na drie maanden werk is de nieuwe waterput in Kpalimé officieel in gebruik genomen.\n\nHet dorp haalde tot nu toe water uit een rivier op ruim twee kilometer van de woningen. Vooral voor kinderen betekende dat dagelijks een lange tocht, vaak ten koste van schooltijd.\n\nDe put werd volledig gefinancierd door giften uit België en wordt beheerd door een lokaal comité dat instaat voor het onderhoud. Onze partners ter plaatse volgen de waterkwaliteit maandelijks op.",
                'days_ago'     => 3,
            ],
            [
                'title'        => 'Speelgoedactie in asielcentrum Broechem',
                'excerpt'      => 'Vrijwilligers deelden meer dan tweehonderd pakjes uit aan kinderen in het asielcentrum.',
                'content'      => "Afgelopen weekend bezochten vijftien vrijwilligers het asielcentrum in Broechem.\n\nDe kinderen kregen elk een pakje samengesteld uit gedoneerd speelgoed, boeken en knutselmateriaal. Daarnaast werd er een namiddag met spelletjes georganiseerd in de gemeenschappelijke ruimte.\n\nWe danken iedereen die materiaal doneerde tijdens de inzamelweek in Merksem. De volgende actie staat gepland voor het einde van het jaar.",
                'days_ago'     => 12,
            ],
            [
                'title'        => 'Oogcampagne bereikt 1.200 patiënten',
                'excerpt'      => 'Tijdens de Gift of Sight campagne werden honderden staaroperaties uitgevoerd.',
                'content'      => "De jaarlijkse Gift of Sight campagne is afgerond.\n\nIn totaal werden 1.200 patiënten onderzocht en kregen 340 mensen een staaroperatie. Voor veel van hen betekent dit dat ze opnieuw kunnen werken en zelfstandig kunnen leven.\n\nHet medische team bestond uit vrijwilligers uit België en lokale artsen. De campagne werd mee mogelijk gemaakt door de opbrengst van de benefietavond in maart.",
                'days_ago'     => 28,
            ],
            [
                'title'        => 'Nieuwe vrijwilligers gezocht voor de winterwerking',
                'excerpt'      => 'Vanaf november zoeken we extra handen voor de wekelijkse voedselbedeling.',
                'content'      => "De winterwerking start opnieuw in november.\n\nWe zoeken vrijwilligers die op zaterdagochtend kunnen helpen bij het klaarmaken en uitdelen van voedselpakketten. Ervaring is niet nodig, een gemotiveerde instelling wel.\n\nInteresse? Maak een account aan op dit platform en vul je profiel in, of stuur ons een bericht via het contactformulier.",
                'days_ago'     => 45,
            ],
            [
                'title'        => 'Schoolmateriaal uitgedeeld aan 600 leerlingen',
                'excerpt'      => 'Het Knowledge for Life project startte het schooljaar met een grote materiaaluitdeling.',
                'content'      => "Bij de start van het nieuwe schooljaar kregen 600 leerlingen een pakket met schriften, pennen en een schooltas.\n\nHet Knowledge for Life project richt zich op kinderen die anders het schooljaar zouden missen door een gebrek aan basismateriaal. Naast de uitdeling ondersteunen we drie scholen met lesmateriaal voor de klas.\n\nDe volgende fase van het project voorziet in een bibliotheek voor de gemeenschap.",
                'days_ago'     => 70,
            ],
            [
                'title'        => 'Jaarverslag 2024 beschikbaar',
                'excerpt'      => 'Een overzicht van onze projecten, uitgaven en resultaten van het afgelopen jaar.',
                'content'      => "Het jaarverslag over 2024 is klaar.\n\nHet verslag bevat een overzicht per project, de financiële cijfers en de doelstellingen voor het komende jaar. Transparantie over de besteding van giften is voor ons een basisvoorwaarde.\n\nHeb je vragen over het verslag? Neem gerust contact op via het contactformulier.",
                'days_ago'     => 110,
            ],
        ];

        foreach ($items as $item) {
            NewsItem::create([
                'user_id'      => $author->id,
                'title'        => $item['title'],
                'slug'         => Str::slug($item['title']),
                'excerpt'      => $item['excerpt'],
                'content'      => $item['content'],
                'image_path'   => null,
                'published_at' => now()->subDays($item['days_ago']),
            ]);
        }
    }
}
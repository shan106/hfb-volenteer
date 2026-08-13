<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VolunteerSeeder extends Seeder
{
    /**
     * Basisdata: een aantal vrijwilligers zodat de publieke profielen,
     * de zoekfunctie en de 'aanbevolen vrijwilligers' op de homepage
     * meteen iets te tonen hebben.
     */
    public function run(): void
    {
        $volunteers = [
            [
                'name'     => 'Amina Haddad',
                'username' => 'amina',
                'email'    => 'amina@example.be',
                'birthday' => '1995-04-12',
                'about'    => 'Coördinator van de voedselbedelingen in Antwerpen. Altijd op zoek naar extra handen op zaterdagochtend.',
            ],
            [
                'name'     => 'Tom Verhaegen',
                'username' => 'tomv',
                'email'    => 'tom@example.be',
                'birthday' => '1988-09-30',
                'about'    => 'Verpleegkundige. Ging mee op medische missie naar Togo en helpt met de voorbereiding van de volgende reis.',
            ],
            [
                'name'     => 'Fatima Zahra',
                'username' => 'fatima',
                'email'    => 'fatima@example.be',
                'birthday' => '2001-01-22',
                'about'    => 'Studente sociaal werk. Begeleidt de speelgoedactie in de asielcentra en schrijft mee aan onze nieuwsberichten.',
            ],
            [
                'name'     => 'Youssef El Amrani',
                'username' => 'youssef',
                'email'    => 'youssef@example.be',
                'birthday' => '1992-07-05',
                'about'    => 'Logistiek verantwoordelijke. Regelt transport en opslag van goederen voor onze inzamelacties.',
            ],
            [
                'name'     => 'Lien De Smet',
                'username' => 'liends',
                'email'    => 'lien@example.be',
                'birthday' => '1999-11-17',
                'about'    => 'Fotografeert onze acties en beheert de sociale media. Vertaalt ook rapporten naar het Nederlands.',
            ],
            [
                'name'     => 'Bilal Khan',
                'username' => 'bilal',
                'email'    => 'bilal@example.be',
                'birthday' => '1997-03-08',
                'about'    => 'IT-vrijwilliger. Onderhoudt dit platform en helpt bij de digitalisering van onze administratie.',
            ],
            [
                'name'     => 'Sofie Peeters',
                'username' => 'sofiep',
                'email'    => 'sofie@example.be',
                'birthday' => '1985-06-25',
                'about'    => 'Leerkracht. Werkt mee aan het Knowledge for Life project en verzamelt schoolmateriaal.',
            ],
            [
                'name'     => 'Karim Benali',
                'username' => 'karim',
                'email'    => 'karim@example.be',
                'birthday' => '1993-12-02',
                'about'    => 'Verantwoordelijke fondsenwerving. Contactpersoon voor bedrijven die onze projecten willen steunen.',
            ],
        ];

        foreach ($volunteers as $volunteer) {
            User::updateOrCreate(
                ['email' => $volunteer['email']],
                [
                    'name'        => $volunteer['name'],
                    'username'    => $volunteer['username'],
                    'password'    => Hash::make('Password!321'),
                    'birthday'    => $volunteer['birthday'],
                    'about'       => $volunteer['about'],
                    'avatar_path' => null,
                    'is_admin'    => false,
                ]
            );
        }
    }
}

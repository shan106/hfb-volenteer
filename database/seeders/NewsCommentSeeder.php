<?php

namespace Database\Seeders;

use App\Models\NewsComment;
use App\Models\NewsItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsCommentSeeder extends Seeder
{
    /**
     * Voorbeeldreacties zodat de commentaarsectie meteen gevuld is.
     */
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        $items = NewsItem::orderByDesc('published_at')->get();

        if ($users->isEmpty() || $items->isEmpty()) {
            return;
        }

        $comments = [
            'Mooi resultaat. Ik was er vorig jaar bij en het is fijn om te zien dat het project verder loopt.',
            'Kan ik hier op een of andere manier bij helpen? Ik ben op zaterdag meestal vrij.',
            'Hier word ik blij van. Bedankt aan iedereen die zich hiervoor heeft ingezet.',
            'Zijn er nog cijfers beschikbaar over de volgende fase van dit project?',
            'Ik heb dit gedeeld met mijn collega\'s, misschien dat er nog mensen willen meehelpen.',
            'Indrukwekkend hoeveel mensen jullie hiermee bereiken.',
            'Wanneer staat de volgende actie gepland? Ik zou graag meegaan.',
            'Dank voor de duidelijke uitleg over waar de middelen naartoe gaan.',
        ];

        $index = 0;

        foreach ($items->take(4) as $item) {
            $count = rand(1, 3);

            for ($i = 0; $i < $count; $i++) {
                $createdAt = $item->published_at?->copy()->addDays($i + 1) ?? now();

                $comment = new NewsComment([
                    'news_item_id' => $item->id,
                    'user_id'      => $users->random()->id,
                    'body'         => $comments[$index % count($comments)],
                ]);

                $comment->created_at = $createdAt;
                $comment->updated_at = $createdAt;
                $comment->save();

                $index++;
            }
        }
    }
}

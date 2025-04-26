<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Comment;
use App\Models\Favorite;
use App\Models\Instrument;
use App\Models\Pad;
use App\Models\SetList;
use App\Models\SetListSong;
use App\Models\Song;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Створюємо користувачів
        $users = User::factory()->count(10)->create();

        // Створюємо інструменти
        $instruments = Instrument::factory()->count(5)->create();

        // Створюємо гурти
        $bands = Band::factory()->count(3)->create();

        // Пов’язуємо гурти з користувачами
        foreach ($users as $user) {
            $user->bands()->attach(
                $bands->random(rand(1, 2))->pluck('id')->toArray()
            );
        }

        // Пов’язуємо користувачів з інструментами
        foreach ($users as $user) {
            $user->instruments()->attach(
                $instruments->random(rand(1, 2))->pluck('id')->toArray()
            );
        }

        // Створюємо пісні
        $songs = Song::factory()->count(20)->create();

        // Створюємо педи
        $pads = Pad::factory()->count(5)->create();

        // Створюємо сет-листи
        $setLists = SetList::factory()->count(5)->create();

        // Створюємо сет-лист пісні
        foreach ($setLists as $setList) {
            $randomSongs = $songs->shuffle()->take(rand(3, 6));
            foreach ($randomSongs as $song) {
                SetListSong::factory()->create([
                    'set_list_id' => $setList->id,
                    'song_id' => $song->id,
                    'leader_id' => $users->random()->id,
                    'pad_id' => $pads->random()->id,
                ]);
            }
        }

        // Створюємо туторіали
        $tutorials = Tutorial::factory()->count(10)->create([
            'song_id' => fn () => $songs->random()->id,
            'instrument_id' => fn () => $instruments->random()->id,
        ]);

        // Створюємо коментарі
        Comment::factory()->count(50)->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        // Створюємо відповіді до коментарів
        Comment::factory()->count(20)->reply()->create([
            'user_id' => fn () => $users->random()->id,
        ]);
        // Створюємо улюблені пісні
        $favoritesCount = 30;
        $favoritesCreated = 0;

        while ($favoritesCreated < $favoritesCount) {
            foreach ($users as $user) {
                $existingFavorites = Favorite::where('user_id', $user->id)->pluck('song_id')->toArray();
                $availableSongs = $songs->whereNotIn('id', $existingFavorites);

                if ($availableSongs->isEmpty()) {
                    continue;
                }

                $song = $availableSongs->random();
                Favorite::factory()->create([
                    'user_id' => $user->id,
                    'song_id' => $song->id,
                ]);
                $favoritesCreated++;

                if ($favoritesCreated >= $favoritesCount) {
                    break;
                }
            }
        }
    }
}

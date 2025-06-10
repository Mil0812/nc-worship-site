<?php

namespace Database\Seeders;

use App\Models\Band;
use App\Models\Comment;
use App\Models\Favourite;
use App\Models\Instrument;
use App\Models\Pad;
use App\Models\SetList;
use App\Models\SetListSong;
use App\Models\Song;
use App\Models\SongSection;
use App\Models\Tutorial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            array_merge(
                User::factory()->admin()->make()->toArray(),
                ['password' => Hash::make('Agent007$')]
            )
        );

        $users = User::factory()->count(10)->create();

        $instruments = Instrument::factory()->count(5)->create();

        $bands = Band::factory()->count(3)->create();

        foreach ($users as $user) {
            $user->bands()->attach(
                $bands->random(rand(1, 2))->pluck('id')->toArray()
            );
        }

        foreach ($users as $user) {
            $user->instruments()->attach(
                $instruments->random(rand(1, 2))->pluck('id')->toArray()
            );
        }

        $songs = Song::factory()
            ->count(10)
            ->has(SongSection::factory()->count(fake()->numberBetween(2, 5)))
            ->create();

        $pads = Pad::factory()->count(5)->create();

        $setLists = SetList::factory()->count(5)->create();

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

        $tutorials = Tutorial::factory()->count(10)->create([
            'song_id' => fn () => $songs->random()->id,
            'instrument_id' => fn () => $instruments->random()->id,
        ]);

        Comment::factory()->count(50)->create([
            'user_id' => fn () => $users->random()->id,
        ]);

        Comment::factory()->count(20)->reply()->create([
            'user_id' => fn () => $users->random()->id,
        ]);
        $favouritesCount = 30;
        $favouritesCreated = 0;

        while ($favouritesCreated < $favouritesCount) {
            foreach ($users as $user) {
                $existingFavourites = Favourite::where('user_id', $user->id)->pluck('song_id')->toArray();
                $availableSongs = $songs->whereNotIn('id', $existingFavourites);

                if ($availableSongs->isEmpty()) {
                    continue;
                }

                $song = $availableSongs->random();
                Favourite::factory()->create([
                    'user_id' => $user->id,
                    'song_id' => $song->id,
                ]);
                $favouritesCreated++;

                if ($favouritesCreated >= $favouritesCount) {
                    break;
                }
            }
        }
    }
}

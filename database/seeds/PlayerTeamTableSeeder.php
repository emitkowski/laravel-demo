<?php

use App\Models\Player;
use App\Models\PlayerTeam;
use App\Models\Team;
use Illuminate\Database\Seeder;

class PlayerTeamTableSeeder extends Seeder
{
    private $teams = 10;
    private $players_per_team = 8;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()->make(Team::class)->truncate();
        app()->make(Player::class)->truncate();
        app()->make(PlayerTeam::class)->truncate();

        // Seed Teams
        factory(Team::class, $this->teams)->create()
            ->each(function ($team) {

                // Seed players for each team
                factory(Player::class, $this->players_per_team)->create()
                    ->each(function ($player) use ($team) {
                        $team->players()->attach($player->id);
                    });
            });
    }
}

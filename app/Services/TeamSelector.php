<?php

namespace App\Services;

use App\Enums\PlayerPosition as PlayerPositionEnum;
use App\Enums\PlayerSkill as PlayerSkillEnum;
use App\Exceptions\InsufficientPlayersException;
use App\Models\Player;
use App\Models\PlayerSkill;
use Illuminate\Database\Eloquent\Collection;

class TeamSelector
{
    protected array $usedPlayerIds = [];

    public function __construct() {}

    /**
     * @param PlayerPositionEnum $position
     * @param PlayerSkillEnum $skill
     * @param int $numberOfPlayers
     * @return Collection
     * @throws InsufficientPlayersException
     */
    public function getPlayers(PlayerPositionEnum $position, PlayerSkillEnum $skill, int $numberOfPlayers) : Collection
    {
        // The app should return an error if there are no available players in the required position.
        if (Player::query()
                ->where('position', $position)
                ->whereNotIn('id', $this->usedPlayerIds)
                ->count() < $numberOfPlayers
        ) {
            throw new InsufficientPlayersException();
        }

        $players = new Collection();

        while ($numberOfPlayers--) {
            // can be optimized to skip to position only match if the position/skill pair is exhausted
            $player = $this->playerByHighestSkill($position, $skill);

            if ($player === null) {
                $player = $this->playerByHighestSkill($position, null);
            }

            if ($player === null) {
                throw new InsufficientPlayersException();
            }

            $this->usedPlayerIds[] = $player->id;

            $players->push($player);
        }

        return $players;
    }

    protected function playerByHighestSkill(PlayerPositionEnum $position, PlayerSkillEnum $skill = null)
    {
        $query = PlayerSkill::query()
            ->selectRaw('player_id')
            ->join('players', 'players.id', '=', 'player_skills.player_id')
            ->where('players.position', '=', $position->value)
            // the same player cannot be used multiple times.
            ->whereNotIn('players.id', $this->usedPlayerIds)
            ->orderBy('value', 'desc')
            ->limit(1);

        if ($skill !== null) {
            $query->where('player_skills.skill', '=', $skill->value);
        }

        $row = $query->first();

        return $row
            ? Player::find($row->player_id)
            : null;
    }
}

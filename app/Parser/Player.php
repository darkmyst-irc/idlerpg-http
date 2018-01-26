<?php

class Parser_Player
{

    const CHARACTER_NAME = 0;
    const ACCOUNT_PASSWORD = 1;
    const IS_ADMIN = 2;
    const CHARACTER_LEVEL = 3;
    const CHARACTER_CLASS = 4;
    const SECONDS_TO_NEXT_LEVEL = 5;
    const USER_NICKNAME = 6;
    const USER_IDENT = 7;
    const IS_ONLINE = 8;
    const SECONDS_IDLED = 9;
    const CHARACTER_POSITION_X = 10;
    const CHARACTER_POSITION_Y = 11;

    const PENALTIES_BEGIN = 12;
    const PENALTIES_SIZE = 7;

    const PENALTY_MESSAGE_FIELD    = 0;
    const PENALTY_NICKCHANGE_FIELD = 1;
    const PENALTY_PART_FIELD       = 2;
    const PENALTY_KICKED_FIELD     = 3;
    const PENALTY_QUIT_FIELD       = 4;
    const PENALTY_QUESTS_FIELD     = 5;
    const PENALTY_LOGOUT_FIELD     = 6;

    const ACCOUNT_CREATED = 19;
    const LAST_LOGIN = 20;

    const INVENTORY_BEGIN = 21;
    const INVENTORY_SIZE = 10;

    const INVENTORY_AMULET_LEVEL_FIELD   = 0;
    const INVENTORY_CHARM_LEVEL_FIELD    = 1;
    const INVENTORY_HELM_LEVEL_FIELD     = 2;
    const INVENTORY_BOOTS_LEVEL_FIELD    = 3;
    const INVENTORY_GLOVES_LEVEL_FIELD   = 4;
    const INVENTORY_RING_LEVEL_FIELD     = 5;
    const INVENTORY_LEGGINGS_LEVEL_FIELD = 6;
    const INVENTORY_SHIELD_LEVEL_FIELD   = 7;
    const INVENTORY_TUNIC_LEVEL_FIELD    = 8;
    const INVENTORY_WEAPON_LEVEL_FIELD   = 9;

    const CHARACTER_ALIGNMENT = 31;

    public function makePlayer(array $fields)
    {
        $penalties    = $this->makePenalties($fields);
        $inventory    = $this->makeInventory($fields);
        $character    = $this->makeCharacter($fields, $inventory);
        $playerStatus = $this->makePlayerStatus($fields);

        return new Player(
            $fields[static::USER_NICKNAME],
            $fields[static::USER_IDENT],
            new DateTime('@' . $fields[static::ACCOUNT_CREATED]),
            new DateTime('@' . $fields[static::LAST_LOGIN]),
            (bool) $fields[static::IS_ADMIN],
            $character,
            $penalties,
            $playerStatus
        );
    }

    public function makePlayerStatus(array $fields)
    {
        return new PlayerStatus(
            $fields[static::IS_ONLINE],
            $fields[static::SECONDS_TO_NEXT_LEVEL],
            $fields[static::SECONDS_IDLED]
        );
    }

    public function makeCharacter($fields, Inventory $inventory): Character
    {
        return new Character(
            $fields[static::CHARACTER_NAME],
            $fields[static::CHARACTER_LEVEL],
            $fields[static::CHARACTER_CLASS],
            $fields[static::CHARACTER_POSITION_X],
            $fields[static::CHARACTER_POSITION_Y],
            $fields[static::CHARACTER_ALIGNMENT],
            $inventory
        );
    }

    public function makePenalties(array $fields): Penalties
    {
        $raw = array_slice($fields, static::PENALTIES_BEGIN, static::PENALTIES_SIZE);
        return new Penalties(
            $raw[static::PENALTY_KICKED_FIELD],
            $raw[static::PENALTY_LOGOUT_FIELD],
            $raw[static::PENALTY_MESSAGE_FIELD],
            $raw[static::PENALTY_NICKCHANGE_FIELD],
            $raw[static::PENALTY_PART_FIELD],
            $raw[static::PENALTY_QUESTS_FIELD],
            $raw[static::PENALTY_QUIT_FIELD]
        );
    }

    public function makeInventory($fields): Inventory
    {
        $raw = array_slice($fields, static::INVENTORY_BEGIN, static::INVENTORY_SIZE);
        return new Inventory(
            new Item($raw[static::INVENTORY_AMULET_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_BOOTS_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_CHARM_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_GLOVES_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_HELM_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_LEGGINGS_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_RING_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_SHIELD_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_TUNIC_LEVEL_FIELD]),
            new Item($raw[static::INVENTORY_WEAPON_LEVEL_FIELD])
        );
    }

}

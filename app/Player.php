<?php

class Player
{

    private $nick = '';
    private $ident = '';
    private $created = null;
    private $lastLogin = null;
    private $isAdmin = false;
    private $character = null;
    private $penalties = null;
    private $status = null;

    public function __construct(
        string $nick,
        string $ident,
        DateTime $created,
        DateTime $lastLogin,
        bool $isAdmin,
        Character $character,
        Penalties $penalties,
        PlayerStatus $status
    )
    {
        $this->nick      = $nick;
        $this->ident     = $ident;
        $this->created   = $created;
        $this->lastLogin = $lastLogin;
        $this->isAdmin   = $isAdmin;
        $this->character = $character;
        $this->penalties = $penalties;
        $this->status    = $status;
    }

    public function getNick(): string
    {
        return $this->nick;
    }

    public function getIdent(): string
    {
        return $this->ident;
    }

    public function getTimeCreated(): DateTime
    {
        return $this->created;
    }

    public function getLastLogin(): DateTime
    {
        return $this->lastLogin;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function getCharacter(): Character
    {
        return $this->character;
    }

    public function getPenalties(): Penalties
    {
        return $this->penalties;
    }

    public function getStatus(): PlayerStatus
    {
        return $this->status;
    }

}

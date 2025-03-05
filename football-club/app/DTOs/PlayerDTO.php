<?php

namespace App\DTOs;

class PlayerDTO
{

    public string $username;
    public string $email;
    public string $name;
    public string $password;
    public string $last_name;
    public string $ssn;
    public string $date_of_birth;
    public string $position;
    public int $place_id;
    public int $club_id;
    public ?string $picture;

    public function __construct(
        string  $username,
        string  $email,
        string  $name,
        string $password,
        string  $last_name,
        string  $ssn,
        string  $date_of_birth,
        string  $position,
        int     $place_id,
        int     $club_id,
        ?string $picture = null
    )
    {
        $this->username = $username;
        $this->email = $email;
        $this->name = $name;
        $this->password = $password;
        $this->last_name = $last_name;
        $this->ssn = $ssn;
        $this->date_of_birth = $date_of_birth;
        $this->position = $position;
        $this->place_id = $place_id;
        $this->club_id = $club_id;
        $this->picture = $picture;
    }
}

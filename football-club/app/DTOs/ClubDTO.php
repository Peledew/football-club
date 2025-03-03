<?php

namespace App\DTOs;

class ClubDTO
{
    public function __construct(
        public string $name,
        public int $place_id
    ) {}

    public static function fromModel($club): self
    {
        return new self($club->name, $club->place_id);
    }
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['place_id']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'place_id' => $this->place_id,
        ];
    }
}

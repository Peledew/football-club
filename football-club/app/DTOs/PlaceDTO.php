<?php

namespace App\DTOs;

use App\Models\Place;

class PlaceDTO
{
    public function __construct(
        public string $name,
        public int $ptt
    ) {}

    public static function fromModel(Place $place): self
    {
        return new self($place->name, $place->ptt);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['ptt']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'ptt' => $this->ptt,
        ];
    }
}

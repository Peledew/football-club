<?php

namespace App\DTOs;

class PlaceDTO
{
    public function __construct(
        public string $name,
        public int $ptt
    ) {}

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

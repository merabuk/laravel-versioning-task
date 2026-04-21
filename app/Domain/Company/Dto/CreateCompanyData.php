<?php

declare(strict_types=1);

namespace App\Domain\Company\Dto;

final readonly class CreateCompanyData
{
    public function __construct(
        public string $name,
        public string $edrpou,
        public string $address,
    ) {
    }
}

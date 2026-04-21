<?php

declare(strict_types=1);

namespace App\Domain\Company\Dto;

final readonly class GetCompanyVersionListData
{
    public function __construct(
        public string $edrpou,
    ) {
    }
}

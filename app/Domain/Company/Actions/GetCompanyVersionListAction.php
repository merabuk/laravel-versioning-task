<?php

declare(strict_types=1);

namespace App\Domain\Company\Actions;

use App\Domain\Company\Dto\GetCompanyVersionListData;
use App\Domain\Company\Eloquent\CompanyReadEloquent;
use App\Domain\Company\Models\Company;
use App\Infrastructure\Exceptions\DatabaseException;

final readonly class GetCompanyVersionListAction
{
    public function __construct(
        private CompanyReadEloquent $companyReadEloquent,
    ) {
    }

    /**
     * @throws DatabaseException
     */
    public function execute(GetCompanyVersionListData $data): Company
    {
        return $this->companyReadEloquent->getByEdrpou(edrpou: $data->edrpou, withRelations: true);
    }
}

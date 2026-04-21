<?php

declare(strict_types=1);

namespace App\Domain\Company\Actions;

use App\Core\Versioning\Services\VersioningService;
use App\Domain\Company\Dto\CreateCompanyData;
use App\Domain\Company\Eloquent\CompanyReadEloquent;
use App\Domain\Company\Models\Company;
use App\Domain\Company\Services\CompanyService;
use App\Infrastructure\Exceptions\DatabaseException;
use App\Infrastructure\Exceptions\EntityCreateException;
use App\Infrastructure\Exceptions\EntityUpdateException;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class CreateOrUpdateCompanyAction
{
    public function __construct(
        private CompanyReadEloquent $companyReadEloquent,
        private CompanyService $companyService,
        private VersioningService $versioningService
    ) {
    }

    /**
     * @throws DatabaseException
     */
    public function execute(CreateCompanyData $data): Company
    {
        $existingCompany = $this->companyReadEloquent->findByEdrpou(edrpou: $data->edrpou);

        try {
            return DB::transaction(function () use ($existingCompany, $data): Company {
                if ($existingCompany) {
                    $company = $this->companyService->updateCompany($existingCompany, $data);
                } else {
                    $company = $this->companyService->createCompany($data);
                }

                $this->versioningService->handle($company);

                return $company;
            });
        } catch (Throwable $e) {
            if ($existingCompany) {
                throw new EntityUpdateException(message: 'Company could not be updated', previous: $e);
            }

            throw new EntityCreateException(message: 'Company could not be created', previous: $e);
        }
    }
}

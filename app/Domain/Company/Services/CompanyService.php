<?php

declare(strict_types=1);

namespace App\Domain\Company\Services;

use App\Domain\Company\Dto\CreateCompanyData;
use App\Domain\Company\Eloquent\CompanyWriteEloquent;
use App\Domain\Company\Models\Company;
use RuntimeException;

final readonly class CompanyService
{
    public function __construct(
        private CompanyWriteEloquent $companyWriteEloquent,
    ) {
    }

    public function createCompany(CreateCompanyData $data): Company
    {
        $company = new Company();
        $company->name = $data->name;
        $company->edrpou = $data->edrpou;
        $company->address = $data->address;

        return $this->companyWriteEloquent->save($company);
    }

    public function updateCompany(Company $company, CreateCompanyData $data): Company
    {
        if ($company->edrpou !== $data->edrpou) {
            throw new RuntimeException('Edrpou cannot be changed');
        }

        $company->name = $data->name;
        $company->address = $data->address;

        if ($company->isDirty()) {
            $this->companyWriteEloquent->save($company);
        }

        return $company;
    }
}

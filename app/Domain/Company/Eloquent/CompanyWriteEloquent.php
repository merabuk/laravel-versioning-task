<?php

declare(strict_types=1);

namespace App\Domain\Company\Eloquent;

use App\Domain\Company\Models\Company;

class CompanyWriteEloquent extends BaseCompanyEloquent
{
    public function save(Company $company): Company
    {
        $company->save();

        return $company;
    }
}

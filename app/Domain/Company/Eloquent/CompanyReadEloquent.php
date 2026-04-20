<?php

declare(strict_types=1);

namespace App\Domain\Company\Eloquent;

use App\Domain\Company\Exceptions\CompanyFindException;
use App\Domain\Company\Models\Company;

class CompanyReadEloquent extends BaseCompanyEloquent
{
    /**
     * @throws CompanyFindException
     */
    public function getByEdrpou(string $edrpou): Company
    {
        return $this->findByEdrpou($edrpou) ?? throw new CompanyFindException('edrpou');
    }

    public function findByEdrpou(string $edrpou): ?Company
    {
        return $this->model->newQuery()
            ->where('edrpou', '=', $edrpou)
            ->first();
    }
}

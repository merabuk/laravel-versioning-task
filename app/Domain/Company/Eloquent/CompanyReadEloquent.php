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
    public function getByEdrpou(string $edrpou, bool $withRelations = false): Company
    {
        return $this->findByEdrpou(edrpou: $edrpou, withRelations: $withRelations) ?? throw new CompanyFindException('edrpou');
    }

    public function findByEdrpou(string $edrpou, bool $withRelations = false): ?Company
    {
        $query = $this->model->newQuery()
            ->where('edrpou', '=', $edrpou);

        if ($withRelations) {
            $query->with(['versions']);
        }

        return $query->first();
    }
}

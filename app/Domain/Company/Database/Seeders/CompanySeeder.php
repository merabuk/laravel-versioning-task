<?php

declare(strict_types=1);

namespace App\Domain\Company\Database\Seeders;

use App\Core\Versioning\Models\Version;
use App\Domain\Company\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    private const int COMPANY_COUNT = 200;

    public function run(): void
    {
        $this->createCompanies();
    }

    private function createCompanies(): void
    {
        $raw = Company::factory()->count(self::COMPANY_COUNT)->raw();

        Company::query()->insert($raw);

        $companies = Company::query()->latest('id')->limit(self::COMPANY_COUNT)->get();

        foreach ($companies as $company) {
            $this->crateCompanyVersions($company);
        }
    }

    private function crateCompanyVersions(Company $company): void
    {
        $count = rand(1, 10);

        $raw = [];

        for ($i = 1; $i < $count + 1; $i++) {
            $raw[] = Version::factory()
                ->forVersionable($company)
                ->withVersion($i)
                ->withSnapshot(Company::factory()->withEdrpou($company->edrpou)->make())
                ->raw();
        }

        Version::query()->insert($raw);
    }
}

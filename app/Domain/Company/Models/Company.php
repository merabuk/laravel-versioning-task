<?php

declare(strict_types=1);

namespace App\Domain\Company\Models;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Traits\HasVersions;
use App\Domain\Company\Database\Factories\CompanyFactory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $edrpou
 * @property string $address
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 *
 * @method static CompanyFactory factory($count = null, $state = [])
 */
#[UseFactory(CompanyFactory::class)]
class Company extends Model implements Versionable
{
    /**
     * @use HasFactory<CompanyFactory>
     */
    use HasFactory;
    use HasVersions;

    protected $fillable = ['name', 'edrpou', 'address'];

    /**
     * @return string[]
     */
    public function getVersioningFields(): array
    {
        return ['name', 'edrpou', 'address'];
    }
}

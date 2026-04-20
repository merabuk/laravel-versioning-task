<?php

declare(strict_types=1);

namespace App\Domain\Company\Models;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Traits\HasVersions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Company\Database\Factories\CompanyFactory;

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
class Company extends Model implements Versionable
{
    use HasVersions;

    protected $fillable = ['name', 'edrpou', 'address'];

    public function getVersioningFields(): array
    {
        return ['name', 'edrpou', 'address'];
    }

    protected static function newFactory(): CompanyFactory
    {
        return CompanyFactory::new();
    }
}

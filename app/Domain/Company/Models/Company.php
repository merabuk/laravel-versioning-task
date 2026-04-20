<?php

declare(strict_types=1);

namespace App\Domain\Company\Models;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Traits\HasVersions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
#[UseFactory(CompanyFactory::class)]
class Company extends Model implements Versionable
{
    use HasFactory;
    use HasVersions;

    protected $fillable = ['name', 'edrpou', 'address'];

    public function getVersioningFields(): array
    {
        return ['name', 'edrpou', 'address'];
    }
}

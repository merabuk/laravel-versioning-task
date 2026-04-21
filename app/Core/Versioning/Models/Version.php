<?php

declare(strict_types=1);

namespace App\Core\Versioning\Models;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Database\Factories\VersionFactory;
use App\Core\Versioning\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $versionable_id
 * @property string $versionable_type
 * @property array<string, mixed> $snapshot
 * @property int $version
 * @property Carbon $created_at
 * @property-read Model&Versionable $versionable
 *
 * @method static VersionFactory factory($count = null, $state = [])
 */
#[UseFactory(VersionFactory::class)]
class Version extends Model
{
    /**
     * @use HasFactory<VersionFactory>
     */
    use HasFactory;

    public const ?string UPDATED_AT = null;

    public ?StatusEnum $temporaryStatus = null;

    protected $fillable = [
        'versionable_id',
        'versionable_type',
        'snapshot',
        'version',
    ];

    protected $attributes = [
        'version' => 1,
    ];

    /**
     * @return MorphTo<Model, $this>
     */
    public function versionable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'snapshot' => 'array',
            'version' => 'integer',
        ];
    }
}

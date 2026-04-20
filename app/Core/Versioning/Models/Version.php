<?php

declare(strict_types=1);

namespace App\Core\Versioning\Models;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Enums\StatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property int $versionable_id
 * @property string $versionable_type
 * @property array $snapshot
 * @property int $version
 * @property Carbon $created_at
 * @property-read Versionable $versionable
 */
class Version extends Model
{
    public const ?string UPDATED_AT = null;

    public StatusEnum $temporaryStatus;

    protected $fillable = [
        'versionable_id',
        'versionable_type',
        'snapshot',
        'version',
    ];

    protected $attributes = [
        'version' => 1,
    ];

    protected $appends = [
        'status'
    ];

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
            'status' => StatusEnum::class,
            'snapshot' => 'array',
            'version' => 'integer',
            'created_at' => 'datetime',
        ];
    }
}

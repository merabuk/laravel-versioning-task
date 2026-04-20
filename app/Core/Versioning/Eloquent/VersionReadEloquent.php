<?php

declare(strict_types=1);

namespace App\Core\Versioning\Eloquent;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Exceptions\VersionFindException;
use App\Core\Versioning\Models\Version;

class VersionReadEloquent extends BaseVersionEloquent
{
    /**
     * @throws VersionFindException
     */
    public function getByVersionable(Versionable $versionable): Version
    {
        return $this->findByVersionable($versionable) ?? throw new VersionFindException('versionable');
    }

    public function findByVersionable(Versionable $versionable): ?Version
    {
        return $this->model->newQuery()
            ->where('versionable_type', '=', $versionable->getMorphClass())
            ->where('versionable_id', '=', $versionable->getKey())
            ->first();
    }
}

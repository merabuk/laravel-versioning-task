<?php

declare(strict_types=1);

namespace App\Core\Versioning\Eloquent;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Exceptions\VersionFindException;
use App\Core\Versioning\Models\Version;

class VersionWriteEloquent extends BaseVersionEloquent
{
    public function save(Version $version): Version
    {
        $version->save();

        return $version;
    }
}

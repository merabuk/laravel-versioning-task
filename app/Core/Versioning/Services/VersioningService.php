<?php

declare(strict_types=1);

namespace App\Core\Versioning\Services;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Eloquent\VersionReadEloquent;
use App\Core\Versioning\Eloquent\VersionWriteEloquent;
use App\Core\Versioning\Enums\StatusEnum;
use App\Core\Versioning\Models\Version;

final readonly class VersioningService
{
    public function __construct(
        private VersionReadEloquent $versionReadEloquent,
        private VersionWriteEloquent $versionWriteEloquent,
    ) {
    }

    public function handle(Versionable $versionable): void
    {
        $existingVersion = $this->versionReadEloquent->findByVersionable($versionable);

        $oldSnapshot = $this->normalizeSnapshot($existingVersion->snapshot ?? []);
        $newSnapshot = $this->normalizeSnapshot($versionable->toSnapshot());

        $status = match (true) {
            $existingVersion === null => StatusEnum::Created,
            $oldSnapshot !== $newSnapshot => StatusEnum::Updated,
            default => StatusEnum::Duplicate,
        };

        if ($existingVersion && $status === StatusEnum::Duplicate) {
            $existingVersion->temporaryStatus = StatusEnum::Duplicate;

            $versionable->setRelation('latestVersion', $existingVersion);

            return;
        }

        $version = new Version();
        $version->versionable_id = $versionable->getKey();
        $version->versionable_type = $versionable->getMorphClass();
        $version->snapshot = $newSnapshot;
        $version->version = $existingVersion ? $existingVersion->version + 1 : 1;

        $version->temporaryStatus = $status;

        $savedVersion = $this->versionWriteEloquent->save($version);

        $versionable->setRelation('latestVersion', $savedVersion);
    }

    /**
     * @param array<string, mixed> $snapshot
     * @return array<string, mixed>
     */
    private function normalizeSnapshot(array $snapshot): array
    {
        ksort($snapshot);

        foreach ($snapshot as $key => $value) {
            if (is_array($value)) {
                $snapshot[$key] = $this->normalizeSnapshot($value);
            }
        }

        return $snapshot;
    }
}

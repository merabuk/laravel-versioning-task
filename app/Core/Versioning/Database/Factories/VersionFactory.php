<?php

declare(strict_types=1);

namespace App\Core\Versioning\Database\Factories;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Models\Version;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Version>
 */
class VersionFactory extends Factory
{
    protected $model = Version::class;

    public function definition(): array
    {
        return [
            'snapshot' => [],
            'version' => $this->faker->numberBetween(1, 10),
            'created_at' => $this->faker->dateTimeBetween(now()->subYears()),
        ];
    }

    public function forVersionable(Versionable $versionable): self
    {
        return $this->state(fn () => [
            'versionable_id' => $versionable->getKey(),
            'versionable_type' => $versionable->getMorphClass(),
            'snapshot' => $versionable->toSnapshot(),
        ]);
    }

    /**
     * @param array<string, mixed> $snapshot
     */
    public function withSnapshot(array $snapshot): self
    {
        return $this->state(fn () => [
            'snapshot' => $snapshot,
        ]);
    }

    public function withVersion(int $version): self
    {
        return $this->state(fn () => [
            'version' => $version,
        ]);
    }

    public function withCreatedAt(string $createdAt): self
    {
        return $this->state(fn () => [
            'created_at' => $createdAt,
        ]);
    }
}

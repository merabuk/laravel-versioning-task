<?php

declare(strict_types=1);

namespace App\Domain\Company\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Company\Models\Company;

/**
 * @mixin Factory<Company>
 */
class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'edrpou' => $this->faker->numberBetween(10_000_000, 99_999_999),
            'address' => $this->faker->address(),
            'created_at' => $createdAt = $this->faker->dateTimeBetween(now()->subYears()),
            'updated_at' => $this->faker->dateTimeBetween($createdAt),
        ];
    }

    public function withName(string $name): self
    {
        return $this->state(fn () => [
            'name' => $name,
        ]);
    }

    public function withEdrpou(string $edrpou): self
    {
        return $this->state(fn () => [
            'edrpou' => $edrpou,
        ]);
    }

    public function withAddress(string $address): self
    {
        return $this->state(fn () => [
            'address' => $address,
        ]);
    }
}

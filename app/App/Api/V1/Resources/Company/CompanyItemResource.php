<?php

declare(strict_types=1);

namespace App\App\Api\V1\Resources\Company;

use App\Domain\Company\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 */
class CompanyItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->latestVersion?->temporaryStatus->value,
            'company_id' => $this->id,
            'version' => $this->latestVersion?->version,
        ];
    }
}

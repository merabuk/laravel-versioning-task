<?php

declare(strict_types=1);

namespace App\App\Api\V1\Resources\Company;

use App\App\Api\V1\Resources\Version\VersionListResource;
use App\Domain\Company\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Company
 */
class CompanyListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'company_id' => $this->id,
            'edrpou' => $this->edrpou,
            'name' => $this->name,
            'address' => $this->address,
            'versions' => VersionListResource::collection($this->versions),
        ];
    }
}

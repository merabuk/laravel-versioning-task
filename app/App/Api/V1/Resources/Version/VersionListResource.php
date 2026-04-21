<?php

declare(strict_types=1);

namespace App\App\Api\V1\Resources\Version;

use App\Core\Versioning\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Version
 */
class VersionListResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'version' => $this->version,
            'payload' => $this->snapshot,
        ];
    }
}

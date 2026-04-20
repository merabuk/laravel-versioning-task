<?php

namespace App\App\Api\V1\Requests\Company;

use App\App\Api\V1\Requests\BaseApiRequest;
use App\Domain\Company\Dto\GetCompanyVersionListData;
use App\Domain\Company\Rules\Edrpou;
use App\Domain\Company\Services\EdrpouValidator;

class GetCompanyVersionListRequest extends BaseApiRequest
{
    public function rules(EdrpouValidator $validator): array
    {
        return [
            'edrpou' => ['bail', 'required', 'string', 'max:10', new Edrpou($validator)],
        ];
    }

    public function getData(): GetCompanyVersionListData
    {
        return new GetCompanyVersionListData(
            edrpou: $this->validated('edrpou')
        );
    }
}

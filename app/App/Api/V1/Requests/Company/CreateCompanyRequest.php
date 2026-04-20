<?php

namespace App\App\Api\V1\Requests\Company;

use App\App\Api\V1\Requests\BaseApiRequest;
use App\Domain\Company\Dto\CreateCompanyData;
use App\Domain\Company\Rules\Edrpou;
use App\Domain\Company\Services\EdrpouValidator;

class CreateCompanyRequest extends BaseApiRequest
{
    public function rules(EdrpouValidator $validator): array
    {
        return [
            'name' => ['bail', 'required', 'string', 'max:256'],
            'edrpou' => ['bail', 'required', 'string', 'max:10', new Edrpou($validator)],
            'address' => ['bail', 'required', 'string', 'max:' . 65_535],
        ];
    }

    public function getData(): CreateCompanyData
    {
        return new CreateCompanyData(
            name: $this->validated('name'),
            edrpou: $this->validated('edrpou'),
            address: $this->validated('address'),
        );
    }
}

<?php

declare(strict_types=1);

namespace App\App\Api\V1\Controllers\Company;

use App\App\Api\V1\Controllers\BaseController;
use App\App\Api\V1\Requests\Company\CreateCompanyRequest;
use App\App\Api\V1\Resources\Company\CompanyItemResource;
use App\Domain\Company\Actions\CreateOrUpdateCompanyAction;
use App\Infrastructure\Exceptions\DatabaseException;
use Illuminate\Http\JsonResponse;

class CreateCompanyController extends BaseController
{
    /**
     * @throws DatabaseException
     */
    public function __invoke(CreateCompanyRequest $request, CreateOrUpdateCompanyAction $action): JsonResponse
    {
        $company = $action->execute($request->getData());

        return response()->json(new CompanyItemResource($company));
    }
}

<?php

declare(strict_types=1);

namespace App\App\Api\V1\Controllers\Company;

use App\App\Api\V1\Controllers\BaseController;
use App\App\Api\V1\Requests\Company\GetCompanyVersionListRequest;
use App\App\Api\V1\Resources\Company\CompanyListResource;
use App\Domain\Company\Actions\GetCompanyVersionListAction;
use App\Infrastructure\Exceptions\DatabaseException;
use Illuminate\Http\JsonResponse;

class GetCompanyVersionListController extends BaseController
{
    /**
     * @throws DatabaseException
     */
    public function __invoke(GetCompanyVersionListRequest $request, GetCompanyVersionListAction $action): JsonResponse
    {
        $company = $action->execute($request->getData());

        return response()->json(new CompanyListResource($company));
    }
}

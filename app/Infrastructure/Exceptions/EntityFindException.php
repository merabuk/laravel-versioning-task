<?php

declare(strict_types=1);

namespace App\Infrastructure\Exceptions;

use Symfony\Component\HttpFoundation\Response;

abstract class EntityFindException extends DatabaseException
{
    protected string $entityName = 'entity';
    protected string $field = 'ID';

    public function __construct(?string $field = null)
    {
        $this->field = $field ?? $this->field;

        parent::__construct(
            message: "{$this->getEntityName()} not found by {$this->getEntityField()}",
            code: Response::HTTP_NOT_FOUND
        );
    }

    public function getCodeName(): string
    {
        return $this->entityName;
    }

    public function getEntityName(): string
    {
        return str($this->entityName)->headline()->lower()->ucfirst()->toString();
    }

    public function getEntityField(): string
    {
        return $this->field;
    }
}

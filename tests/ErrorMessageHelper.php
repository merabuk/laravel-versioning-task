<?php

declare(strict_types=1);

namespace Tests;

trait ErrorMessageHelper
{
    protected function getBaseValidationErrorStructure(array $customKeys): array
    {
        return [
            'error',
            'message',
            'errors' => $customKeys,
        ];
    }

    protected function getExactEntityNotFound(string $entity, string $field = 'ID'): array
    {
        return $this->getBaseExactError(
            error: __('errors.entity_not_found.code', [
                'entity' => $entity,
            ]),
            message: __('errors.entity_not_found.message', [
                'entity' => mb_ucfirst($entity),
                'field' => $field,
            ]),
        );
    }

    protected function getExactServiceUnavailableError(): array
    {
        return $this->getBaseExactError(
            error: __('errors.unexpected_error.code'),
            message: __('errors.unexpected_error.message'),
        );
    }

    protected function getBaseExactError(
        string $error,
        string $message,
        string $errorKey = 'error',
        string $messageKey = 'message'
    ): array {
        return [
            $errorKey => $error,
            $messageKey => $message,
        ];
    }
}

<?php

declare(strict_types=1);

return [
    'unexpected_error' => [
        'code' => 'unexpected_error',
        'message' => 'An unexpected error occurred. Please try again later.',
    ],
    'not_found' => [
        'code' => 'not_found',
        'message' => 'The requested resource was not found.',
    ],
    'entity_not_found' => [
        'code' => ':entity_notFound',
        'message' => ':entity with a given :field does not exist',
    ],
    'method_not_found' => [
        'code' => 'requestMethod_notFound',
        'message' => 'Method not found',
    ],
    'method_not_allowed' => [
        'code' => 'requestMethod_notAllowed',
        'message' => 'Method not allowed',
    ],
    'validation_error' => [
        'code' => 'request_validationFailed',
        'message' => 'Request validation failed',
    ],
    'too_many_requests' => [
        'code' => 'request_tooMany',
        'message' => 'You have made too many requests. Try again in :time',
    ],
];

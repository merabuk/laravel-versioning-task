<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    public function validationData(): array
    {
        return [...$this->all(), ...$this->route()->parameters];
    }
}

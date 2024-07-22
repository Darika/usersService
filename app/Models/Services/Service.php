<?php

namespace App\Models\Services;

use App\Models\Errors\ErrorsTrait;
use Illuminate\Http\Request;

abstract class Service
{
    use ErrorsTrait;

    protected ?Request $request;

    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    protected function response(array $data = null): array
    {
        $response = [
            'status' => $this->hasErrors() ? 'error' : 'ok',
        ];

        if ($this->hasErrors()) {
            $response['message'] = $this->getError()?->getMessage();

            return $response;
        }

        return [
            ...$response,
            'data' => $data
        ];
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    protected function setRequest(Request $request): static
    {
        $this->request = $request;
        return $this;
    }
}

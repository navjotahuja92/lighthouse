<?php

namespace Nuwave\Lighthouse\Support\Http\Responses;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Nuwave\Lighthouse\Support\Contracts\CanStreamResponse;

class MemoryStream extends Stream implements CanStreamResponse
{
    /**
     * @var mixed[]
     */
    public $chunks = [];

    /**
     * Stream GraphQL response.
     *
     * @param  mixed[]  $data
     * @param  string[]  $paths
     */
    public function stream(array $data, array $paths, bool $final): void
    {
        if (! empty($paths)) {
            $data = (new Collection($paths))
                ->mapWithKeys(function (string $path) use ($data): array {
                    $response['data'] = Arr::get($data, "data.{$path}", []);
                    $errors = $this->chunkError($path, $data);
                    if (! empty($errors)) {
                        $response['errors'] = $errors;
                    }

                    return [$path => $response];
                })
                ->all();
        }

        $this->chunks[] = $data;
    }
}

<?php

namespace App\Traits;

use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser {

    protected function successResponse($data, $code) {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code) {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = Response::HTTP_OK, $paginate = false) {

        $resourceCollection = $collection->firstOrFail()->resourceCollection;
        $collection = $paginate ? $this->paginate($collection) : $collection;

        return (new $resourceCollection($collection))->response()->setStatusCode($code);
    }

    protected function showOne(Model $model, $code = Response::HTTP_OK) {

        $resource = $model->resource_full;

        return (new $resource($model))->response()->setStatusCode($code);
    }

    protected function paginate(Collection $collection) {

        $rules = [
            // 'per_page' => 'integer|min:1|max:50'
            'per_page' => ['integer', Rule::in(['-1', '3', '5', '10', '15'])]
        ];

        Validator::make(request()->query(), $rules)->validate();

        $page = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 15;

        if (request()->query('per_page')) {
            $perPage = (int)request()->query('per_page');
            if ($perPage === -1) {
                $perPage = $collection->count();
            }
        }

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();
        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);
        $paginated->appends(request()->query());

    return $paginated;
    }

    protected function cacheTime() {
        if (request()->is('api/*')) {
            return 0;
        } else {
            return config('const.cache_time');
        }
    }

    protected function cacheResponse() {
        $url = request()->url();
        $queryParams = request()->query();

        if (!$queryParams) {
            return $url;
        }

        ksort($queryParams);
        $queryString = http_build_query($queryParams);
        return "{$url}?{$queryString}";
    }
}

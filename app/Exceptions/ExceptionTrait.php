<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

trait ExceptionTrait
{
    /**
     * @param $request
     * @param $e
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiException($request, $e)
    {
        if ($this->isModel($e))
            return $this->ModelResponse($e);
        if ($this->isHttp($e))
            return $this->HttpRespons($e);
        if ($e instanceof TokenInvalidException)
            return response(['error' => 'Token is invalid'], 400);
        if ($e instanceof TokenExpiredException)
            return response(['error' => 'Token is Expired'], 400);
        if ($e instanceof JWTException)
            return response(['error' => 'There is problem with your token'], 400);

        return parent::render($request, $e);
    }

    private function isModel($e){
        return $e instanceof ModelNotFoundException;
    }
    private function isHttp($e) { //true route ?
        return $e instanceof NotFoundHttpException;
    }

    private function ModelResponse($e){
        return response()->json([
            'errors'=>'Product Model not found'
        ], Response::HTTP_NOT_FOUND);
    }
    
    private function HttpRespons($e) {
        return response()->json([
            'errors'=>'Incorect route'
        ], Response::HTTP_NOT_FOUND);
    }
}

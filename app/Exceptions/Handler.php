<?php

namespace tiendaVirtual\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function render($request, Throwable $e){
        // dd($e);
        if($e instanceof \Illuminate\Database\QueryException){
            return handleError($e,'Lo sentimos, hubo un error en base de datos, inténtelo más tarde',400);
        }
        else if($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException){
            return handleError($e,'No se encontró la información que buscaba',404);
        }
        else if($e instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException){
            return handleError($e,'Página no encontrada',404);
        }
        return parent::render($request, $e);
    }
}
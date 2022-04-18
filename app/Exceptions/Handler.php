<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\QueryException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Registre las devoluciones de llamada de manejo de excepciones para la aplicación.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $exception) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException) {
            return response()->json(['errors' => 'No autenticado', 'code' => 401], 401);
        }

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            return response()->json(['errors' => 'No posee permisos para ejecutar esta acción.', 'code' => 403], 403);
        }

        if ($exception instanceof ModelNotFoundException) {
            $modelo = strtolower(class_basename($exception->getModel()));
            return response()->json(['errors' => [
                'No existe ninguna instancia de ' . $modelo . ' con el id expecificado'
            ], 'code' => 404], 404);
        }

        if ($exception instanceof AuthorizationException) {
            return response()->json(['errors' => 'No posee permisos para ejecutar esta acción', 'code' => 403], 403);
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['errors' => 'El metodo especificado en la peticion no es valido', 'code' => 405], 405);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['errors' => 'No se encontro la url ingresada', 'code' => 404],404);
        }

        if ($exception instanceof HttpException) {
            return response()->json(['errors' => $exception->getMessage(), $exception->getStatusCode()]);
        }

        if ($exception instanceof QueryException) {
            $codigo = $exception->errorInfo[1];
            if ($codigo == 1451) {
                return response()->json(['errors' => 'No se puede eliminar de forma permanente el recurso porque esta relacionado', 'code' => 409], 409);
            }else{
                // Descomentar en producción
                // return response()->json(['errors' => ['Error inesperado en el Sistema'], 'code' => 500], 500);
            }
        }

        // return response()->json(['errors' => 'Falla inesperada, intente luego', 'code' => 500], 500);

        return parent::render($request, $exception);
    }
}

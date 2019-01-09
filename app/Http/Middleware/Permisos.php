<?php

namespace App\Http\Middleware;

use App\Pantalla;
use App\Ruta;
use App\User;
use Closure;
use Mockery\Exception;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Tymon\JWTAuth\JWTAuth;

class Permisos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = auth()->user()->id;
        $user = User::with('perfil.pantallas.rutas')->find($userId);
        $permisos = $user->perfil->pantallas->map(function($pantalla){ return $pantalla->nombre;});
        $fullPath = $request->getPathInfo();
        $path = explode("/", $fullPath);
        $pantalla = $path[1];
        $request->request->add(['userId' => $user->id]);

        foreach($permisos as $permiso)
        {
            if($permiso == $pantalla)
            {
                return $next($request);
            }
        }
        $userRoute = $user->perfil->pantallas->first(function($pantalla) use ($fullPath){
            return $pantalla->rutas->first(function($ruta) use ($fullPath){
                return $ruta->ruta == $fullPath;
            });
        });
        if($userRoute == null)
        {
            throw new \RuntimeException('acceso denegado');
        } else {
            return $next($request);
        }
    }
}

<?php 

namespace Application\Lumen53\Providers;
use Illuminate\Support\ServiceProvider;

/**
 * If the incoming request is an OPTIONS request
 * we will register a handler for the requested route
 */
class CatchAllOptionsRequestsProvider extends ServiceProvider {
  public function register()
  {
    $request = app('request');
    if ($request->isMethod('OPTIONS'))
    {
        app()->options($request->path(), 
                        function() use ($request) {
                            return response('', 200)
                            ->header('Access-Control-Allow-Origin', '*')
                            ->header('Access-Control-Allow-Methods', 'GET, HEAD, POST, PUT, PATCH, DELETE, OPTIONS')
                            ->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'))
                            ; 
                        });
    }
  }
}
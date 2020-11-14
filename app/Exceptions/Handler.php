<?php

namespace App\Exceptions;

use App\Menu;
use App\Http\Controllers\SiteController;
use App\Repositories\MenusRepository;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($this->isHttpException($e)) {
            $status_code = $e->getStatusCode();

            switch ($status_code) {
                case '404':
                    $obj = new SiteController(new MenusRepository(new Menu()));

                    $navigation = view(config('settings.theme') . '.navigation')
                        ->with('menu', $obj->getMenu())
                        ->render();

                    Log::alert('Страница не найдена - ' . $request->url());

                    return response()->view(config('settings.theme') . '.404', [
                        'bar' => 'no',
                        'title' => 'Страница не найдена',
                        'navigation' => $navigation,
                    ]);
            }
        }

        return parent::render($request, $e);
    }
}

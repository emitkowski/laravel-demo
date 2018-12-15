<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Swift_TransportException;

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
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Handle token mismatch by forwarding back to form page with alert
        if ($exception instanceof TokenMismatchException) {
            return redirect()->back()->withInput($request->except('_token'))->with('alert', 'Your session has expired. Please try submitting form again.');
        }

        // Handle SMTP Email Errors by forwarding back to page with alert
        if ($exception instanceof Swift_TransportException) {
            return redirect()->back()->withInput($request->except('_token'))->with('alert', 'There was a problem sending email from the site. Please try again later.');
        }

        return parent::render($request, $exception);
    }
}

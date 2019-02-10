<?php

namespace App\Support\Response;

use Request;
use Symfony\Component\HttpFoundation\Response;
use URL;

trait GeneralResponseTrait
{
    /**
     * @param string      $message
     * @param string|null $to
     * @param array       $params
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function success(string $message = '', string $to = null, array $params = []) : Response
    {
        return $this->successfulResponse($message, $to, $params);
    }

    /**
     * @param string      $message
     * @param string|null $to
     * @param array       $params
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function warning(string $message = '', string $to = null, array $params = []) : Response
    {
        return $this->successfulResponse($message, $to, $params, 'warning');
    }

    /**
     * @param string      $message
     * @param string|null $to
     * @param array       $params
     * @param string      $dataKey
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    private function successfulResponse(
        string $message = '',
        string $to = null,
        array $params = [],
        string $dataKey = 'success'
    ) : Response {
        if (Request::ajax() || Request::wantsJson()) {
            return response()->json([
                'message' => $message,
                'data'    => $params
            ]);
        }
        $redirect = redirect()->to($to === null ? URL::previous() : $to);
        if ($message) {
            $redirect = $redirect->with($dataKey, $message);
        }
        foreach ($params as $key => $value) {
            $redirect = $redirect->with($key, $value);
        }

        return $redirect;
    }

    /**
     * @param array|string $messages
     * @param string|null  $to
     * @param array        $params
     * @param array|null   $exceptInput
     * @param int          $statusCode
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function error(
        $messages = [],
        string $to = null,
        array $params = [],
        array $exceptInput = null,
        int $statusCode = 400
    ) : Response {
        $messages = (array) $messages;
        if ($exceptInput === null) {
            $exceptInput = ['password', 'password_confirmation'];
        }
        if (Request::ajax() || Request::wantsJson()) {
            return response()->json([
                'message' => array_first($messages),
                'data'    => $params
            ], $statusCode);
        }
        $redirect = redirect()->to($to === null ? URL::previous() : $to)
                ->withErrors($messages)
                ->withInput(Request::except($exceptInput));
        foreach ($params as $key => $value) {
            $redirect = $redirect->with($key, $value);
        }

        return $redirect;
    }
}

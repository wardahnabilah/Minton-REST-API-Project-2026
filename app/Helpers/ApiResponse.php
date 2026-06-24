<?php

namespace App\Helpers;

class ApiResponse {
    public static function success(
        $data = null,
        $message = 'success', 
        $status_code = 200,
        $meta = null,
        $links = null,
    ) {
        $response = [
            'success'   => true,
            'message'   => $message,
            'data'      => $data,
        ];

        if($meta) {
            $response['meta'] = $meta;
        }

        if($links) {
            $response['links'] = $links;
        }

        return response()->json($response, $status_code);
    }

    public static function error(
        $errors = null,
        $message = 'error',
        $status_code = 500,
    ) {
        return response()->json(array_filter([
            'success'   => false,
            'message'   => $message,
            'errors'    => $errors,
        ], fn($value) => !is_null($value)), 
        $status_code);
    }
}
<?php

namespace App\Traits;

trait ApiResponser{

    protected function loginResponse($message, $bearerToken, $data, $code = 200)
	{
		return response()->json([
			'status'  => 1, 
			'message' => $message,
			'bearer_token' => $bearerToken,
			'data'    => $data
		], $code);
	}

    protected function successDataResponse($message, $data, $code = 200)
	{
		return response()->json([
			'status'  => 1, 
			'message' => $message,
			'data'    => $data
		], $code);
	}

    protected function successResponse($message = null, $code = 200)
	{
		return response()->json([
			'status'  => 1, 
			'message' => $message
		], $code);
	}

	protected function errorResponse($message = null, $code)
	{
		return response()->json([
			'status'  => 0,
			'message' => $message
		], $code);
	}

	protected function errorDataResponse($message, $data, $code)
	{
		return response()->json([
			'status'  => 0,
			'message' => $message,
			'data'    => $data
		], $code);
	}
}
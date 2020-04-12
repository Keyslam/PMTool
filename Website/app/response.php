<?php
class Response
{
	private static function create($success, $response_code, $fields = []) {
		return json_encode(array_merge([
			"success" => $success,
			"response_code" => $response_code,
		], $fields));
	}

	public static function success($fields = [])
	{
		echo Response::create(true, 200, $fields);
		die();
	}

	public static function fail($fields = [])
	{
		echo Response::create(false, 200, $fields);
		die();
	}

	public static function badRequest()
	{
		echo Response::create(false, 400);
		die();
	}

	public static function NotAuthorized() {
		echo Response::create(false, 401);
		die();
	}

	public static function notFound() {
		echo Response::create(false, 404);
		die();
	}

	public static function locked() {
		echo Response::create(false, 423);
		die();
	}

	public static function internalServerError() {
		echo Response::create(false, 500);
		die();
	}
}

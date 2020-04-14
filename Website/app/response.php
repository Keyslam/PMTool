<?php
class Response
{
	private static function create($success, $response_code, $fields = []) {
		return json_encode(array_merge([
			"success" => $success,
			"response_code" => $response_code,
		], $fields));
	}

	public static function view($viewName, $data = []) {
		$html = blade()->run($viewName, $data);

		return Response::success([
			"html" => $html,
		]);
	}

	public static function success($fields = [])
	{
		return Response::create(true, 200, $fields);
	}

	public static function fail($silent = true, $fields = [])
	{
		return Response::create(false, 200, array_merge([
			"silent" => $silent,
		], $fields));
	}

	public static function badRequest()
	{
		return Response::create(false, 400);
	}

	public static function notAuthorized() {
		return Response::create(false, 401);
	}

	public static function notFound() {
		return Response::create(false, 404);
	}

	public static function locked() {
		return Response::create(false, 423);
	}

	public static function internalServerError($exception) {
		return Response::create(false, 500, [
			"exception" => $exception,
		]);
	}
}

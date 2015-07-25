<?php
/**
 * Created by PhpStorm.
 * User: linroid
 * Date: 7/24/15
 * Time: 16:08
 */

namespace app\Http\Controllers\Api;


use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Validator;

class ApiController extends Controller {
	use Helpers;
	/**
	 * @property Response $response
	 */
//	/**
//	 * {@inheritdoc}
//	 */
//	protected function formatErrors(Validator $validator)
//	{
//		return $validator->errors()->all();
//	}
}
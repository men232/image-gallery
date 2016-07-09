<?php

namespace AlbumGalleryBundle;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;

class ApiManager
{
	const ERROR_HAS_NO_ERRORS        = 0;
	const ERROR_UNKNOWN              = 1;
	const ERROR_UNKNOW_API_METHOD    = 2;
	const ERROR_ACCESS_DENIED        = 3;
	const ERROR_INCORRECT_SIGNATURE  = 4;
	const ERROR_SESSION_NOT_EXIST    = 5;
	const ERROR_INCORRECT_TOKEN      = 6;
	const ERROR_SESSION_HAS_EXPIRED  = 7;
	const ERROR_MARKET_NOT_EXIST     = 8;
	
	protected $credits;
	protected $container;

	function __construct($container)
	{
		$this->container = $container;
	}

	/**
	 * A function to create correct json response
	 * 
	 * @param mixed $data 
	 * @param array $groups 
	 * @return JsonResponse
	 */
	public function createResponse($data = [], $groups = null)
	{
		$response = [];

		if ($data instanceof \Symfony\Component\Form\Form) {
			$data = $this->getErrors($data);
		}

		if ($data instanceof \Exception) {
			$response = [
				'error' => [
					'error_msg' => $data->getMessage(),
					'error_code' => $data->getCode(),
				]
			];
		} else {
			$response = is_null($data) ? false : $data;
		}

		if (is_array($groups)) {
			$groups = SerializationContext::create()->setGroups($groups);
		}

		$response = $this->container->get('jms_serializer')
			->serialize($response, 'json', $groups);

		$jsonResponse = new JsonResponse();
		$jsonResponse->setContent($response);
		$jsonResponse->headers->set('Access-Control-Allow-Origin', '*');
		$jsonResponse->headers->set('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
		$jsonResponse->headers->set('Access-Control-Allow-Headers', 'origin, content-type, accept');

		return $jsonResponse;
	}

	/**
	 * A method to build array object based on form errors messages
	 * @param  Form $form
	 * @return array
	 */
	private function getErrors(\Symfony\Component\Form\Form $form)
	{
		$errors = array();

		foreach ($form->getErrors() as $error) {
			$errors[] = $error->getMessage();
		}

		foreach ($form->all() as $key => $child) {
			if ($err = $this->getErrors($child)) {
				$errors[$key] = $err;
			}
		}

		return $errors;
	}
}
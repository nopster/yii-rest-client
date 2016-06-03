<?php
namespace app\data;

use yii\httpclient\Client;

class ApiWrapper{
	private $api_url;
	
	public function __construct() 
	{
       $this->api_url = \Yii::$app->params['serverApi'];
	}
	
	public function getUsers($query = '')
	{
		$client = new Client();
		$response = $client->createRequest()
			->setFormat(Client::FORMAT_JSON)
			->setUrl($this->api_url."users?$query")
			->send();
		return $response->getData();
	}
	
	public function getUser($id)
	{
		$client = new Client();
		$response = $client->createRequest()
			->setFormat(Client::FORMAT_JSON)
			->setUrl($this->api_url.'users/'.$id)
			->send();
		return $response->isOk ? $response->getData() : null;
	}
	
	public function deleteUser($id)
	{
		$client = new Client();
		$response = $client->createRequest()
			->setMethod('delete')
			->setFormat(Client::FORMAT_JSON)
			->setUrl($this->api_url.'users/'.$id)
			->send();
		return $response->isOk;		
	}
	
	public function createUser($data)
	{
		$client = new Client();
		$response = $client->createRequest()
			->setMethod('post')
			->setFormat(Client::FORMAT_JSON)
		    ->setData($data)
			->setUrl($this->api_url.'users')
			->send();
		return $response->isOk ? $response->getData()['id'] : null;
	}
	
	public function updateUser($id,$data)
	{
		$client = new Client();
		$response = $client->createRequest()
			->setMethod('put')
			->setFormat(Client::FORMAT_JSON)
		    ->setData($data)
			->setUrl($this->api_url.'users/'.$id)
			->send();
		return $response->isOk ? $response->getData()['id'] : null;
	}
	
	public function getUsersCount($query = '')
	{
		$client = new Client();
		$response = $client->createRequest()
			->setFormat(Client::FORMAT_JSON)
			->setUrl($this->api_url."users?$query")
			->send();
		return $response->isOk ? $response->getHeaders()->get('X-Pagination-Total-Count') : 0;
	}
}
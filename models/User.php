<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\data\ApiWrapper;

class User extends Model
{
	public $username;
    public $email;
    public $password;
	public $id;
    public $display_name;
	public $status;
	public static $statusArray = ['1' => 'active',
						   '2' => 'deactive'];
						   
	public $isNewRecord = true;

    public function rules()
    {
        return [
		    [['id'], 'integer'],
            [['username','email','password'], 'required'],
            [['username'], 'string', 'max' => 20],
			['email','email'], 
            [['email'], 'string', 'max' => 255],
            [['password'], 'string', 'length' => [6, 30]],
            [['display_name'], 'string', 'max' => 70],
			[['status'], 'integer'],
        ];
    }
	
	public function delete()
	{
		$api = new ApiWrapper();
		return $api->deleteUser($this->id);
	}
	
	public static function getStatusesArray()
	{
		return self::$statusArray;
	}
	
	public function getStatusName()
	{
		return self::$statusArray[$this->status];
	}
	
	public function findOne($id)
	{
		$api = new ApiWrapper();
		$data = $api->getUser($id);
		if ($data === null)
			return null;
		$user = new User();
		$user->setAttributes($data);
		if ($user->id!==null)
			$user->isNewRecord = false;
		return $user;
	}
	
	public function save()
	{
		$api = new ApiWrapper();
		$attributes = $this->getAttributes();
		if ($this->isNewRecord){
			$this->id = $api->createUser($attributes);
		} else {
			$this->id = $api->updateUser($this->id,$attributes);	
		}
		return true;
	}
	
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'display_name' => 'Display Name',
			'status' => 'Status'
        ];
    }
}

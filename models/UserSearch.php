<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class UserSearch extends User
{
	public function search(){
		
	}
	public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username'], 'safe'],
			[['email'], 'safe'],
			[['password'], 'safe'],
			[['display_name'], 'safe'],
			[['status'], 'integer'],
        ];
    }
}
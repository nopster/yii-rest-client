<?php
namespace app\data;

use yii\data\BaseDataProvider;
use app\data\ApiWrapper;
use yii\helpers\ArrayHelper;

class ApiDataProvider extends BaseDataProvider
{

    public $key;
    private $api;
    public $query;
	
    public function init()
    {
        parent::init();
        $this->api = new ApiWrapper;
    }
 
    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        $models = [];
        $pagination = $this->getPagination();

        if ($pagination === false) {
            $models = $this->api->getUsers();
        } else {
            $pagination->totalCount = $this->getTotalCount();
            $limit = $pagination->getLimit();
			$page = $pagination->page + 1;
            $models = $this->api->getUsers($this->query);
        }
		
        return $models;
		
		
    }
 
    /**
     * @inheritdoc
     */
    protected function prepareKeys($models)
    {
     /*   if ($this->key !== null) {
            $keys = [];
 
            foreach ($models as $model) {
                if (is_string($this->key)) {
                    $keys[] = $model[$this->key];
                } else {
                    $keys[] = call_user_func($this->key, $model);
                }
            }
 
            return $keys;
        } else {
            return array_keys($models);
        }*/
	/*	print_r($models);
		echo $key;
		return $models['id'];*/
		
		return ArrayHelper::getColumn($models, 'id');// array_keys($models);
    }
 
    /**
     * @inheritdoc
     */
    protected function prepareTotalCount()
    {
		return $this->api->getUsersCount($this->query);
    }
}
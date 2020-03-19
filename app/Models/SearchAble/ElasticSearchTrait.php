<?php

namespace App\Models\SearchAble;

use App\Utils\ElasticSearchUtil;
use Elasticsearch\ClientBuilder;
use Exception;
use Illuminate\Database\Eloquent\Model;


/**
 * 官方不支持 7.x, 自行封装
 * Trait ElasticSearchTrait
 * @package App\Models\SearchAble
 */
trait ElasticSearchTrait
{
    protected static $client;
    
    public static function client()
    {
        if (is_null(self::$client)) {
            
            $configs = config('elasticsearch');
            
            $builder = ClientBuilder::create();
            $builder->setHosts($configs['hosts']);
            
            self::$client = $builder->build();
        }
        
        return self::$client;
    }
    
    public static function info()
    {
        $instance = new static;
    
    
        $index = array(
            'index' => $instance->getIndexName(),
            'client' => [
                'timeout' => 5,        // ten second timeout
                'connect_timeout' => 5
            ]
        );
    
        return self::client()->indices()->get($index);
    }
    
    public static function indexExists()
    {
        $instance = new static;
        
        
        $index = array(
            'index' => $instance->getIndexName(),
            'client' => [
                'timeout' => 5,        // ten second timeout
                'connect_timeout' => 5
            ]
        );
        
        return self::client()->indices()->exists($index);
    }
    
    
    public static function deleteIndex()
    {
        $instance = new static;


        $index = array(
            'index' => $instance->getIndexName(),
            'client' => [
                'timeout' => 5,        // ten second timeout
                'connect_timeout' => 5
            ]
        );

        return self::client()->indices()->delete($index);
    }

    public static function createIndex($shards = null, $replicas = null)
    {
        /**
         * @var $instance ElasticSearchTrait
         */
        $instance = new static;

        $client = self::client();

        $index = array(
            'index' => $instance->getIndexName(),
        );

        $settings = $instance->getIndexSettings();
        if (!is_null($settings)) {
            $index['body']['settings'] = $settings;
        }

        if (!is_null($shards)) {
            $index['body']['settings']['number_of_shards'] = $shards;
        }

        if (!is_null($replicas)) {
            $index['body']['settings']['number_of_replicas'] = $replicas;
        }

        $mappingProperties = $instance->getMappingProperties();
        if (!is_null($mappingProperties)) {
            $index['body']['mappings'] = [
                '_source' => array('enabled' => true),
                'properties' => $mappingProperties,
            ];
        }

        return $client->indices()->create($index);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function addToIndex($body = [])
    {
        if (!$this->exists) {
            throw new Exception('Document does not exist.');
        }

        $params = $this->getBasicEsParams();

        // Get our document body data.
        $params['body'] =  $body;

        // The id for the document must always mirror the
        // key for this model, even if it is set to something
        // other than an auto-incrementing value. That way we
        // can do things like remove the document from
        // the index, or get the document from the index.
        $params['id'] = $this->getKey();

        return self::client()->index($params);
    }

    public function removeFromIndex()
    {
        return self::client()->delete($this->getBasicEsParams());
    }

    /**
     * query: {
     * "match": {
     * "tweet": "elasticsearch"
     * }
     * }
     * 排序：[
     * { "post_date" : {"order" : "asc"}},
     * "user",
     * { "name" : "desc" },
     * { "age" : "desc" },
     * "_score"
     * ]
     * @param $query
     * @param $limit
     * @param $offset
     * @param null $sort
     * @param null $sourceFields
     * @param null $aggregations
     * @return array
     */
    public static function search($query, $limit = null, $offset = null, $sort = null, $sourceFields = null, $aggregations = null)
    {
        $instance = new static;

        $params = $instance->getBasicEsParams(true, true, true, $limit, $offset);

        if (!empty($sourceFields)) {
            $params['body']['_source']['include'] = false;
        }

        if (!empty($query)) {
            $params['body']['query'] = $query;
        }

        if (!empty($aggregations)) {
            $params['body']['aggs'] = $aggregations;
        }

        if (!empty($sort)) {
            $params['body']['sort'] = $sort;
        }

        $result = self::client()->search($params);
        return $result;
    }


    public static function searchCount($query)
    {
        $instance = new static;

        $params = $instance->getBasicEsParams(true, true, true, null, null);


        if (!empty($query)) {
            $params['body']['query'] = $query;
        }


        $result = self::client()->count($params);
        return $result;
    }

    public function getBasicEsParams($getIdIfPossible = true, $getSourceIfPossible = false, $getTimestampIfPossible = false, $limit = null, $offset = null)
    {
        $params = array(
            'index' => $this->getIndexName(),
            'client' => [
                'timeout' => 5,        // ten second timeout
                'connect_timeout' => 5
            ]
        );

        if ($getIdIfPossible && $this->getKey()) {
            $params['id'] = $this->getKey();
        }


        if (is_numeric($limit)) {
            $params['size'] = $limit;
        }

        if (is_numeric($offset)) {
            $params['from'] = $offset;
        }

        return $params;
    }

    public function getIndexName()
    {
        $indexName = config('elasticsearch.default_index', 'default');

        return $indexName;
    }

    public function getIndexSettings()
    {
        return null;
    }

    public function getMappingProperties()
    {
        return [];
    }

}

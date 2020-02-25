<?php

namespace HighwayPro\App\Data\Model\UrlExtra;

use HighWayPro\App\Data\Schema\UrlExtraTable;
use HighWayPro\App\Data\Schema\UrlTable;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Model\Gateway;
use HighwayPro\App\Data\Model\UrlExtra\UrlExtra;

Class UrlExtraGateway extends Gateway
{
    protected function model()
    {
        return [
            'table' => new UrlExtraTable,
            'domain' => UrlExtra::class
        ];
    }

    public function getInjectionKeywordsForPostType($postType)
    {
        (object) $urlTable = new UrlTable;
        
        return $this->createCollection(
            $this->driver->get(
                "SELECT extra.*
                 FROM {$this->table->getName()} extra
                 RIGHT JOIN {$urlTable->getName()} url
                 ON extra.url_id = url.id
                 WHERE extra.`name` = 'keyword_injection'
                 AND extra.value != ''
                 AND `context` {$this->driver->getLIKEPlaceHolder($postType)}
                ",
                [
                    '%'.$this->driver->escapeLike($postType).'%'
                ]
            )
        );
    }

    public function createOrUpdateSingleField(Array $data)
    {
        $data = new Collection($data);

        (string) $urlId     = $data->get('url_id');
        (string) $fieldName = $data->get('fieldName');
        (string) $value     = $data->get('value');

        if (!is_numeric($urlId) || !$fieldName) return false;

        (string) $columnName = $this->getAliasedFieldName($fieldName);

        (object) $existingFields = $this->getWithUrlIdAndName($urlId, $columnName);

        (object) $urlExtra = $existingFields->haveAny()? $existingFields->first() : new UrlExtra([]);

        $urlExtra->url_id = $urlId;
        $urlExtra->name   = $columnName;

        if ($fieldName === 'keyword_injection_context') {
            $urlExtra->context = Collection::createFromString((string) $value);
        } else {
            $urlExtra->value = $value;
        }

        if ($existingFields->haveAny()) {
            return $this->update($urlExtra->getAvailableValues());
        } else {
            return $this->insert($urlExtra);
        }
    }

    protected function getAliasedFieldName($fieldName)
    {  
        switch ($fieldName) {
            case 'keyword_injection_keywords':
            case 'keyword_injection_context':
                return 'keyword_injection';
                break;
            default:
                return $fieldName;
                break;
        }
    }
    

    public function getWithUrlIdAndName($urlId, $name)
    {
        $name = $this->getAliasedFieldName($name);

        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT * FROM {$this->table->getName()} 
                         WHERE {$this->table->getField('url_id')} = ? 
                                   AND 
                               {$this->table->getField('name')}   = ?",
                        [$urlId, $name]
                    )
                );   
    }

    public function getWithUrlId($urlId)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE url_id = ?", [$urlId])
                );
    }   

    public function GetWithId($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE id = ?", [$id])
                )->first();
    }   

}
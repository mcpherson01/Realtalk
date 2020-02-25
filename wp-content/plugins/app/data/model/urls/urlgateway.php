<?php

namespace HighwayPro\App\Data\Model\Urls;

use HighWayPro\App\Data\Model\Posts\Post;
use HighWayPro\App\Data\Schema\DestinationTable;
use HighWayPro\App\Data\Schema\DestinationTargetTable;
use HighWayPro\App\Data\Schema\UrlTable;
use HighWayPro\App\Data\Schema\UrlTypeTable;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\DirectTarget;
use HighWayPro\App\HighWayPro\DestinationComponents\BuiltIn\Targets\PostTarget;
use HighWayPro\App\HighWayPro\Paths\PathManager;
use HighWayPro\Original\Characters\StringManager;
use HighWayPro\Original\Collections\Collection;
use HighWayPro\Original\Data\Drivers\WordPressDatabaseDriver;
use HighWayPro\Original\Data\Model\Gateway;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTarget;
use HighwayPro\App\Data\Model\DestinationTargets\DestinationTargetGateway;
use HighwayPro\App\Data\Model\Destinations\Destination;
use HighwayPro\App\Data\Model\Destinations\DestinationGateway;
use HighwayPro\App\Data\Model\Urls\Url;
use Highwaypro\App\Data\Model\Preferences\Preferences;
use Highwaypro\app\highWayPro\urls\PathGenerator;

Class UrlGateway extends Gateway
{
    protected function model()
    {
        return [
            'table' => new UrlTable,
            'domain' => Url::class
        ];
    }

    public static function ensurePathFormat($path)
    {
        $path = new StringManager((string) $path);

        return (string) $path->ensureLeft('/');
    }
    

    public function getDestinationGateway()
    {
        return $this->cache->getIfExists('destinationGateway')->otherwise(function() {
            return new DestinationGateway(new WordPressDatabaseDriver);
        });   
    }

    public function getDestinationTargetGateway()
    {
        return $this->cache->getIfExists('destinationTargetGateway')->otherwise(function() {
            return new DestinationTargetGateway(new WordPressDatabaseDriver);
        });   
    }
    
    public function getFromFullPath(Collection $paths)  
    {
        $paths = $paths->clean();
        
        (boolean) $isPathWithSubdomain = $paths->haveMoreThan(1);
        (string) $operator = $isPathWithSubdomain? '= ?' : 'IS NULL OR types.base_path = ""';

        return $this->createCollection(
            (array) $this->driver->get(
                "SELECT urls.* FROM {$this->table->getName()} urls
                LEFT JOIN {$this->getUrlTypesTable()->getName()} types 
                ON urls.type_id = types.id
                WHERE urls.path = BINARY ? AND types.base_path {$operator}",
                array_filter([
                    $this->getPath($paths->last()),
                    $isPathWithSubdomain? $this->getPath($paths->first()) : null
                ])
            )
        );
    }

    public function getAllWithTypeId($typeId)
    {
        if ($typeId < 1) throw new \Exception("Url type id must be an integer greater than 0");
        
        return $this->createCollection(
            $this->driver->get(
                "SELECT * FROM {$this->table->getName()} 
                 WHERE type_id = ?
                 ORDER BY id DESC",
                [
                    $typeId
                ]
            )
        );   
    }
    

    /**
     * This method is important to check if there is already a row with a specific path
     * without having to make JOINs like self::getWithPath()
     */
    public function pathExists($path)
    {
        return $this->fieldWithValueExists([
            'name' => 'path',
            'value' => $this->getPath($path)
        ]);
    }

    public function nameExists($name)
    {
        return $this->fieldWithValueExists([
            'name' => 'name',
            'value' => trim($name)
        ]);
    }

    public function getWithPath($path)
    {
        return $this->createCollection(
                    (array) $this->driver->get("SELECT * FROM {$this->table->getName()} WHERE path = ?", [$this->getPath($path)])
                )->first();
    } 

    public function getWithPartialName($partialName, $limit = 0)
    {
        (string) $LIMIT = $limit? "LIMIT ?" : '';

        return $this->createCollection(
            (array) $this->driver->get(
                "SELECT * FROM {$this->table->getName()} 
                 WHERE name {$this->driver->getLIKEPlaceHolder($partialName)} $LIMIT", 
                array_filter([
                    $this->driver->escapeLike($partialName).'%',
                    $limit? $limit : null
                ])
            )
        );
    }

    public function getFromPostTargetWithPostId($postId)
    {
        (object) $destinationTargetTable = new DestinationTargetTable;
        (object) $destinationTable = new DestinationTable;

        return $this->createCollection(
                    (array) $this->driver->get(
                        "
                        SELECT url.* 
                        FROM {$destinationTargetTable->getName()} target
                        JOIN {$destinationTable->getName()} destination 
                        ON target.destination_id = destination.id
                        JOIN {$this->table->getName()} url
                        ON url.id = destination.url_id
                        WHERE (target.type = ?) 
                               AND 
                              (
                               (target.parameters = '{\"type\":\"withid\",\"id\":?}')
                               OR 
                               (target.parameters LIKE '{%\"type\":\"withid\",\"id\":?%}')
                              )
                        ", 
                        [
                            PostTarget::name,
                            $postId,
                            $postId
                        ]
                    )
                );
    }

    public function deleteUrlAndAllItsComponents(Url $url)
    {
        $result = $this->delete($url);   

        if ($result === false) return false;

        foreach ($url->getDestinationsIncludingThoseWithoutATarget()->asArray() as $destination) {

            $result = $this->getDestinationGateway()
                           ->deleteDestinationAndItsComponents($destination);

            if ($result === false) {
                return false;
            }
        }

        if (WordPressDatabaseDriver::errors()->haveAny()) return false;

        return $result;
    }
    
    
    public function findNewRandomPath()
    {
        (object) $pathGenerator = new PathGenerator(Preferences::get());

        do {
            (string) $generatedPath = $pathGenerator->generate();

            (object) $urls = $this->createCollection(
                $this->driver->get(
                    "SELECT id 
                     FROM {$this->table->getName()} 
                     WHERE path = ? OR path = ?", 
                    [
                        $pathWithLeadingSlash = "/$generatedPath",
                        $pathWithOutLeadingSlash = "$generatedPath"
                    ] 
                )
            );
        } while ($urls->haveAny());

        return $generatedPath;
    }

    /**
     * This method checks the existence of a row with an id 
     * it does not do JOINs as opposed to getWithId
     */
    public function idExists($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT id FROM {$this->table->getName()} WHERE id = ?", 
                        [$id]
                    )
                )->haveAny();
    } 
    
    public function getWithId($id)
    {
        return $this->createCollection(
                    (array) $this->driver->get(
                        "SELECT * FROM {$this->table->getName()} WHERE id = ?", 
                        [$id]
                    )
                )->first();
    }   

    public function createShorturlForPostWithComponents(Url $url, Post $post)
    {
        try {
            $this->insert($url);

            (integer) $newUrlId = $this->driver->wpdb->insert_id;

            $this->getDestinationGateway()->insert(new Destination([
                'url_id' => $newUrlId,
                'position' => 1
            ]));

            (integer) $newDestinationId = $this->driver->wpdb->insert_id;

            (object) $postTarget = new PostTarget(json_encode([
                'type' => 'withid',
                'id'   => $post->ID
            ]));

            $this->getDestinationTargetGateway()->deleteAllWithDestinationIdAndInsertNew(
                new DestinationTarget([
                    'destination_id' => $newDestinationId,
                    'type'           => PostTarget::name,
                    'parameters'     =>  json_encode($postTarget->getParameters())
                ])
            );

            return $newUrlId;
            
        } catch (\Exception $e) {
            throw $e;
        }
    }
    

    protected function getPath($path)
    {
        return (new PathManager($path))->getClean();
    }

    protected function getUrlTypesTable()
    {
        return new UrlTypeTable;
    }

}
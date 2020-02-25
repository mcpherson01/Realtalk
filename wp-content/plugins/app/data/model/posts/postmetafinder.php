<?php

namespace HighwayPro\App\Data\Model\Posts;

use HighWayPro\App\Data\Model\Posts\PostMeta;

Class PostMetaFinder
{
    protected $postId;

    public function __construct($postId)
    {
        $this->postId = (integer) $postId;   
    }

    public function getWithKey($metaKey)
    {
        $metaValue = get_post_meta($this->postId, $metaKey, $single = true);

        if (!$this->hasMeta($metaKey)) $metaValue = '';

        return new PostMeta([
            'key' => $metaKey,
            'value' => $metaValue,
            'post_id' => $this->postId
        ]);
    }

    public function hasMeta($metaKey)
    {
        return (boolean) metadata_exists('post', $this->postId, $metaKey);   
    }
}
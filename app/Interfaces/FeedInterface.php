<?php namespace App\Interfaces;

interface FeedInterface
{
    /**
     * FeedInterface constructor.
     * @param $data_key
     * @param $feed_cache_time
     */
    public function __construct(string $data_key,int $feed_cache_time);

    /**
     * @param \SimpleXMLElement $fetch_data
     * @return array
     */
    public function parseFeed(\SimpleXMLElement $fetch_data ): array;

    /**
     * Feed cache time in minutes
     * @return int
     */
    public function getFeedCacheTime(): int;

    /**
     * Feed cache key
     * @return string
     */
    public function getDataKey(): string;
}
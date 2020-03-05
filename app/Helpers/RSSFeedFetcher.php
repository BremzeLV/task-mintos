<?php namespace App\Helpers;

use App\Interfaces\FeedInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class RSSFeedFetcher
{
    public function __construct(){}

    /**
     * Gets data from url and parses ir to array with parseFeed() function.
     * @param FeedInterface $feed
     * @return array
     */
    public static function fetchData(FeedInterface $feed){
        $rssFeed = Cache::remember($feed->getDataKey(), $feed->getFeedCacheTime() * 60, function () use ($feed) {

            $loaded_data = simplexml_load_file( $feed::FETCH_URL );

            if($loaded_data)
                return $feed->parseFeed($loaded_data);
            else
                return array();
        });

        return $rssFeed;
    }
}
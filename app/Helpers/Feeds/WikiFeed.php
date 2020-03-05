<?php namespace App\Helpers\Feeds;

use App\Interfaces\FeedInterface;

class WikiFeed implements FeedInterface
{
    const FETCH_URL = 'https://en.wikipedia.org/w/api.php?action=parse&page=Most_common_words_in_English&prop=iwlinks&section=1&disabletoc=true&format=xml';

    private $data_key  = null;
    private $feed_cache_time = null;

    /**
     * @inheritdoc
     */
    public function __construct(string $data_key,int $feed_cache_time)
    {
        $this->data_key  = $data_key;
        $this->feed_cache_time = $feed_cache_time;
    }

    /**
     * @inheritdoc
     */
    public function parseFeed(\SimpleXMLElement $fetch_data ): array
    {
        $collection = array(
            'values' => array()
        );

        foreach($fetch_data->parse->iwlinks->iw as $word){
            $nodes                = $word->children();
            $attributes           = $word->attributes();

            if (0 !== count($attributes)) {
                foreach ($attributes as $attrName => $attrValue) {
                    $collection['attributes'][$attrName] = strval($attrValue);
                }
            }

            if (0 === $nodes->count()) {
                if( !empty($collection['attributes']['prefix']) )
                    $collection['values'][] = str_replace($collection['attributes']['prefix'].':', '', strval($word));
                else
                    $collection['values'][] = strval($word);

            }
        }

        return $collection['values'];

    }

    /**
     * @inheritdoc
     */
    public function getFeedCacheTime(): int
    {
        return $this->feed_cache_time;
    }

    /**
     * @inheritdoc
     */
    public function getDataKey(): string
    {
        return $this->data_key;
    }
}
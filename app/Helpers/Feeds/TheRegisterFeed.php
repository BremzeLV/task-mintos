<?php namespace App\Helpers\Feeds;


use App\Interfaces\FeedInterface;

class TheRegisterFeed implements FeedInterface
{
    const FETCH_URL = 'https://www.theregister.co.uk/software/headlines.atom';

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
        $fetch_data_return = array(
            'title'  => null,
            'rights' => null,
            'rows'   => array(),
        );

        $fetch_data_return['title']  = strval($fetch_data->title);
        $fetch_data_return['rights'] = strval($fetch_data->rights);

        foreach($fetch_data->entry as $item){
            $fetch_data_return['rows'][] = array(
                'link'      => strval($item->link['href']),
                'title'     => strval($item->title),
                'summary'   => strip_tags($item->summary),
            );
        }

        return $fetch_data_return;
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
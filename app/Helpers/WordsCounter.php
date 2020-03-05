<?php namespace App\Helpers;


class WordsCounter
{

    /**
     * Counting word occurrences in theRegister Feed
     * @param array $theRegister
     * @param array $words_exclude
     * @param int $limit
     * @return array
     */
    public static function countWordsInRegisterRows(array $the_register, array $words_exclude, int $limit = 0) : array
    {
        if( empty($the_register) )
            return array();

        $pattern_to_match = "/[^'\w\s]/";
        $words_data = array();

        if(  count($words_exclude) > 50 )
            $words_exclude = array_slice($words_exclude, 0, 50);

        $the_register['title'] = strtolower($the_register['title']);
        $words_data_main_title = str_word_count(preg_replace($pattern_to_match, ' ',  $the_register['title']), 1);
        $words_data = array_merge($words_data, $words_data_main_title);
        
        foreach ($the_register['rows'] as $row){
            $row['title']   = strtolower($row['title']);
            $row['summary'] = strtolower($row['summary']);
            
            $words_data_title   = str_word_count(preg_replace($pattern_to_match, ' ', $row['title']), 1);
            $words_data_summary = str_word_count(preg_replace($pattern_to_match, ' ', $row['summary']), 1);

            $words_data = array_merge($words_data, $words_data_title, $words_data_summary);
        }

        $words_data = array_count_values($words_data);

        foreach($words_data as $word => $count){
            if( in_array(strtolower($word), $words_exclude) ) unset($words_data[$word]);
        }

        array_multisort($words_data, SORT_DESC);

        if( $limit !== 0 && count($words_data) > $limit )
            $words_data = array_slice($words_data, 0, $limit);

        return $words_data;
    }
}
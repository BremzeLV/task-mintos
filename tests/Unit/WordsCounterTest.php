<?php

namespace Tests\Unit;

use App\Helpers\WordsCounter;
use PHPUnit\Framework\TestCase;

class WordsCounterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCountWordsInRegisterRows()
    {
        $input_data = array(
            'title' => 'Hello',
            'rows'  =>  array(
                array('title'=>'hello', 'summary'=>'it wee3223is OMG-me'),
                array('title'=>'you', 'summary'=>'looking for. hello')
            )
        );
        $exclude_words  = array('it');
        $exclude_words2 = array('it', 'wee', 'is');

        $this->assertEquals(array('hello' => 3, 'wee' => 1), WordsCounter::countWordsInRegisterRows($input_data, $exclude_words, 2));
        $this->assertEquals(array('hello' => 3), WordsCounter::countWordsInRegisterRows($input_data, $exclude_words, 1));
        $this->assertEquals(array('hello' => 3, 'omg' => 1), WordsCounter::countWordsInRegisterRows($input_data, $exclude_words2, 2));
    }
}

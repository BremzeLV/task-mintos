<?php

namespace App\Http\Controllers;

use App\Helpers\Feeds\TheRegisterFeed;
use App\Helpers\Feeds\WikiFeed;
use App\Helpers\RSSFeedFetcher;
use App\Helpers\WordsCounter;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $wiki = new WikiFeed('eng', 3600);
        $wikiData = RSSFeedFetcher::fetchData($wiki);

        $theRegister = new TheRegisterFeed('theRegister', 60);
        $theRegisterData = RSSFeedFetcher::fetchData($theRegister);

        $wordList = WordsCounter::countWordsInRegisterRows($theRegisterData, $wikiData, 10);

        return view('home', [
            'rssData' => $theRegisterData,
            'wordList'=> $wordList
        ]);
    }
}

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xs-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (!empty($rssData) )

                        <h2>Popular words</h2>

                        @foreach($wordList as $word => $count)
                            <span type="button" class="badge badge-light">
                                {{ $word }} <span class="badge badge-success">{{ $count }}</span>
                            </span>
                        @endforeach

                        <hr />

                        <h1>{{ $rssData['title'] }}</h1>

                        @foreach($rssData['rows'] as $row)
                            <h3><a href="{{ $row['link'] }}">{{ strip_tags($row['title'])  }}</a></h3>

                            {{ strip_tags($row['summary']) }}

                            <hr />
                        @endforeach

                        <small>{{ $rssData['rights'] }}</small>

                    @else

                        <span class="alert alert-info">
                            No RSS feed loaded.
                        </span>

                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

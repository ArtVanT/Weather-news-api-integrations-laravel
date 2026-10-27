<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API</title>
</head>
<body>
    <header><h1>Mykolaiv</h1></header>
    <main>
        @if ($weather)
     <p>Temperature: {{ $weather['temperature'] }} °C</p>
        <p>Humidity: {{ $weather['humidity'] }} %</p>
        <p>Precipitation probability: {{ $weather['precipitation_probability'] }} %</p>
    @else
           <p>Weather API failed.</p>
    @endif
    @if(count($news))
    <ul>
        @foreach($news as $article)
        <li><a href="{{ $article['url'] }}">{{ $article['title'] }}}}</a>
        </li>
        @endforeach
    </ul>
    @else
    <p>No news available.</p>
    @endif
    </main>
    <footer></footer>
</body>
</html>
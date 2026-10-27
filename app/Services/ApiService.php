<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Pool;

class ApiService{
    function getResponse(){
// $responses = Http::pool(fn (Pool $pool) =>[
//     $pool->get('https://api.open-meteo.com/v1/forecast?latitude=46&longitude=31&hourly=relative_humidity_2m,apparent_temperature,precipitation_probability,precipitation,soil_temperature_6cm,soil_moisture_1_to_3cm'),
//     $pool->withHeaders([
//     'X-Api-Key' => config('services.news.key'),
//     ])->get('https://newsapi.org/v2/everything'),
// ]);
// return $responses[0]->ok() && $responses[1]->ok();
$responses = Http::pool(fn (Pool $pool) => [
    $pool->get('https://api.open-meteo.com/v1/forecast',[
        'latitude' => 46,
        'longitude' => 31,
        'hourly' => 'temperature_2m,relative_humidity_2m,apparent_temperature,precipitation_probability,precipitation,soil_temperature_6cm,soil_moisture_1_to_3cm',
    ]),

    $pool->withHeaders([
    'X-Api-Key' => config('services.news.key')
])->get('https://newsapi.org/v2/everything', [
    'q' => 'Mykolaiv',
    'pageSize' => 5,
]),
]);
// dump($responses[0]->status(), $responses[0]->body());
$weather = null;
if($responses[0]->ok()){
    $hourly = $responses[0]->json('hourly');
    $weather = [
        'time' => $hourly['time'][0] ?? null,
        'temperature' => $hourly['temperature_2m'][0] ?? null,
        'humidity' => $hourly['relative_humidity_2m'][0] ?? null,
        'apparent_temperature' => $hourly['apparent_temperature'][0] ?? null,
        'precipitation_probability' => $hourly['precipitation_probability'][0] ?? null,
        'precipitation' => $hourly['precipitation'][0] ?? null,
        'soil_temperature' => $hourly['soil_temperature_6cm'][0] ?? null,
        'soil_moisture' => $hourly['soil_moisture_1_3cm'][0] ?? null,
    ];
}

$news = [];
if($responses[1]->ok()){
    foreach($responses[1]->json('articles') as $article){
        $news[] = [
    'title' => $article['title'] ?? null,
    'url' => $article['url'] ?? null,
 ];   
  }
}

return [
    'weather' => $weather,
    'news' => $news,
];

    }
}
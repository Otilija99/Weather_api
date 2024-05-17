<?php
$apiKey = 'secret';

$city = readline("Enter city name: ");

$geoApiUrl = 'http://api.openweathermap.org/geo/1.0/direct';
$geoUrl = "$geoApiUrl?q=$city&appid=$apiKey";

$geoResponse = file_get_contents($geoUrl);
$geoData = json_decode($geoResponse, false);

if ($geoData) {
    $latitude = $geoData[0]->lat;
    $longitude = $geoData[0]->lon;

    $weatherApiUrl = 'http://api.openweathermap.org/data/2.5/weather';
    $weatherUrl = "$weatherApiUrl?lat=$latitude&lon=$longitude&appid=$apiKey";

    $weatherResponse = file_get_contents($weatherUrl);
    $weatherData = json_decode($weatherResponse, false);

    if ($weatherData && isset($weatherData->weather)) {
        $weatherDescription = $weatherData->weather[0]->description;
        $temperature = $weatherData->main->temp;
        $temperatureCelsius = $temperature - 273.15;
        $humidity = $weatherData->main->humidity;

        echo "Weather in $city: $weatherDescription" . PHP_EOL;
        echo "Temperature: $temperatureCelsius °C" . PHP_EOL;
        echo "Humidity: $humidity%" . PHP_EOL;
    } else {
        echo "Error fetching weather data." . PHP_EOL;
    }
} else {
    echo "Error fetching city coordinates." . PHP_EOL;
}
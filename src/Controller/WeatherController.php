<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{countryCode}/{city}')]
    public function forecast(string $countryCode, string $city) {
        $forecast = [
            [
                'date' => new \DateTime('2025-09-04'),
                'temperature' => 25,
                'wind_speed' => 1.7,
                'wind_deg' => 270,
                'humidity' => 50,
                'pressure' => 1013,
                'clouds' => 36,
                'icon' => 'brightness-high',
            ],
            [
                'date' => new \DateTime('2025-09-03'),
                'temperature' => 20,
                'wind_speed' => 3.7,
                'wind_deg' => 260,
                'humidity' => 67,
                'pressure' => 1013,
                'clouds' => 96,
                'icon' => 'cloud-sun
',
            ],
            [
                'date' => new \DateTime('2025-09-02'),
                'temperature' => 18,
                'wind_speed' => 3.8,
                'wind_deg' => 180,
                'humidity' => 93,
                'pressure' => 1013,
                'clouds' => 75,
                'icon' => 'cloud-rain',
            ],
        ];

        $response = $this->render('weather/forecast.html.twig', [
            'forecasts' => $forecast,
            'city' => $city,
            'countryCode' => $countryCode,
        ]);
        return new Response($response);
    }
}
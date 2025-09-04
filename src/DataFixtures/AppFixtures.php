<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Location;
use App\Entity\Forecast;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $barcelona = $this->addLocation($manager, 'Barcelona', 'ES', 41.3851, 2.1734);
        $this->addForecast($manager, $barcelona, new \DateTime('2025-09-04'), 25, 25, 1013, 50, 1.7, 270, 0, 'sun');
        $this->addForecast($manager, $barcelona, new \DateTime('2025-09-05'), 17, 20, 999, 57, 1.9, 240, 70, 'cloud');

        $berlin = $this->addLocation($manager, 'Berlin', 'DE', 52.5200, 13.4050);
        $this->addForecast($manager, $berlin, new \DateTime('2025-09-03'), '17', '17', '1013', '50', '1.7', '270', '0', 'sun');
        $this->addForecast($manager, $berlin, new \DateTime('2025-09-04'), '21', '20', '1010', '58', '3.2', '240', '20', 'cloud');
        $this->addForecast($manager, $berlin, new \DateTime('2025-09-05'), '19', '18', '1007', '65', '4.5', '200', '60', 'cloud-rain');
        $this->addForecast($manager, $berlin, new \DateTime('2025-09-06'), '23', '22', '1015', '45', '2.0', '310', '10', 'sun');
        $this->addForecast($manager, $berlin, new \DateTime('2025-09-07'), '15', '14', '1002', '72', '6.0', '180', '90', 'cloud-lightning');

        $london = $this->addLocation($manager, 'London', 'GB', 51.5074, -0.1278);
        $this->addForecast($manager, $london, new \DateTime('2025-09-03'), '28', '27', '1014', '42', '2.5', '160', '10', 'sun');
        $this->addForecast($manager, $london, new \DateTime('2025-09-04'), '30', '29', '1013', '38', '3.0', '120', '0', 'sun');

        $paris = $this->addLocation($manager, 'Paris', 'FR', 48.8566, 2.3522);
        $this->addForecast($manager, $paris, new \DateTime('2025-09-03'), '22', '21', '1012', '55', '3.1', '200', '30', 'cloud-sun');
        $this->addForecast($manager, $paris, new \DateTime('2025-09-04'), '24', '23', '1016', '48', '2.4', '150', '5', 'sun');
        $this->addForecast($manager, $paris, new \DateTime('2025-09-05'), '18', '17', '1008', '70', '5.5', '220', '80', 'cloud-rain');
        $this->addForecast($manager, $paris, new \DateTime('2025-09-06'), '20', '19', '1011', '60', '3.8', '270', '50', 'cloud');
        $this->addForecast($manager, $paris, new \DateTime('2025-09-07'), '16', '15', '1005', '75', '6.7', '190', '95', 'cloud-lightning');

        $rome = $this->addLocation($manager, 'Rome', 'IT', 41.8902, 12.4923);
        $this->addForecast($manager, $rome, new \DateTime('2025-09-03'), '28', '27', '1014', '42', '2.5', '160', '10', 'sun');
        $this->addForecast($manager, $rome, new \DateTime('2025-09-04'), '30', '29', '1013', '38', '3.0', '120', '0', 'sun');
        $this->addForecast($manager, $rome, new \DateTime('2025-09-05'), '26', '25', '1009', '55', '4.1', '200', '40', 'cloud-sun');
        $this->addForecast($manager, $rome, new \DateTime('2025-09-06'), '22', '21', '1007', '65', '5.8', '210', '70', 'cloud-rain');
        $this->addForecast($manager, $rome, new \DateTime('2025-09-07'), '24', '23', '1010', '50', '3.6', '250', '20', 'cloud');
        $manager->flush();
    }

    private function addLocation(ObjectManager $manager, $name, $countryCode, $latitude, $longitude): Location {
        $location = new Location(0);
        $location->setName($name)
            ->setCountryCode($countryCode)
            ->setLatitude($latitude)
            ->setLongitude($longitude);
        $manager->persist($location);

        return $location;
    }

    private function addForecast(ObjectManager $manager, $location, $date, $temperature, $flTemperature, $pressure, $humidity, $windSpeed, $windDeg, $clouds, $icon): Forecast {
        $forecast = new Forecast();
        $forecast->setDate($date)
            ->setLocation($location)
            ->setTemperature($temperature)
            ->setFlTemperature($flTemperature)
            ->setPressure($pressure)
            ->setHumidity($humidity)
            ->setWindSpeed($windSpeed)
            ->setWindDeg($windDeg)
            ->setCloudiness($clouds)
            ->setIcon($icon);
        $manager->persist($forecast);
        return $forecast;
    }
}

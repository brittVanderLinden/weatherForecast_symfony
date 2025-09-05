<?php

namespace App\Tests\Controller;

use App\Entity\Forecast;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class ForecastControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $forecastRepository;
    private string $path = '/forecast/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->forecastRepository = $this->manager->getRepository(Forecast::class);

        foreach ($this->forecastRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Forecast index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'forecast[date]' => 'Testing',
            'forecast[temperature]' => 'Testing',
            'forecast[flTemperature]' => 'Testing',
            'forecast[pressure]' => 'Testing',
            'forecast[humidity]' => 'Testing',
            'forecast[windSpeed]' => 'Testing',
            'forecast[windDeg]' => 'Testing',
            'forecast[cloudiness]' => 'Testing',
            'forecast[icon]' => 'Testing',
            'forecast[location]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->forecastRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Forecast();
        $fixture->setDate('My Title');
        $fixture->setTemperature('My Title');
        $fixture->setFlTemperature('My Title');
        $fixture->setPressure('My Title');
        $fixture->setHumidity('My Title');
        $fixture->setWindSpeed('My Title');
        $fixture->setWindDeg('My Title');
        $fixture->setCloudiness('My Title');
        $fixture->setIcon('My Title');
        $fixture->setLocation('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Forecast');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Forecast();
        $fixture->setDate('Value');
        $fixture->setTemperature('Value');
        $fixture->setFlTemperature('Value');
        $fixture->setPressure('Value');
        $fixture->setHumidity('Value');
        $fixture->setWindSpeed('Value');
        $fixture->setWindDeg('Value');
        $fixture->setCloudiness('Value');
        $fixture->setIcon('Value');
        $fixture->setLocation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'forecast[date]' => 'Something New',
            'forecast[temperature]' => 'Something New',
            'forecast[flTemperature]' => 'Something New',
            'forecast[pressure]' => 'Something New',
            'forecast[humidity]' => 'Something New',
            'forecast[windSpeed]' => 'Something New',
            'forecast[windDeg]' => 'Something New',
            'forecast[cloudiness]' => 'Something New',
            'forecast[icon]' => 'Something New',
            'forecast[location]' => 'Something New',
        ]);

        self::assertResponseRedirects('/forecast/');

        $fixture = $this->forecastRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getTemperature());
        self::assertSame('Something New', $fixture[0]->getFlTemperature());
        self::assertSame('Something New', $fixture[0]->getPressure());
        self::assertSame('Something New', $fixture[0]->getHumidity());
        self::assertSame('Something New', $fixture[0]->getWindSpeed());
        self::assertSame('Something New', $fixture[0]->getWindDeg());
        self::assertSame('Something New', $fixture[0]->getCloudiness());
        self::assertSame('Something New', $fixture[0]->getIcon());
        self::assertSame('Something New', $fixture[0]->getLocation());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Forecast();
        $fixture->setDate('Value');
        $fixture->setTemperature('Value');
        $fixture->setFlTemperature('Value');
        $fixture->setPressure('Value');
        $fixture->setHumidity('Value');
        $fixture->setWindSpeed('Value');
        $fixture->setWindDeg('Value');
        $fixture->setCloudiness('Value');
        $fixture->setIcon('Value');
        $fixture->setLocation('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/forecast/');
        self::assertSame(0, $this->forecastRepository->count([]));
    }
}

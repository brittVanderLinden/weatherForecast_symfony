<?php

namespace App\Tests\Controller;

use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class LocationControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $locationRepository;
    private string $path = '/location/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->locationRepository = $this->manager->getRepository(Location::class);

        foreach ($this->locationRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Location index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'location[name]' => 'Testing',
            'location[countryCode]' => 'Testing',
            'location[latitude]' => 'Testing',
            'location[longitude]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->locationRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Location();
        $fixture->setName('My Title');
        $fixture->setCountryCode('My Title');
        $fixture->setLatitude('My Title');
        $fixture->setLongitude('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Location');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Location();
        $fixture->setName('Value');
        $fixture->setCountryCode('Value');
        $fixture->setLatitude('Value');
        $fixture->setLongitude('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'location[name]' => 'Something New',
            'location[countryCode]' => 'Something New',
            'location[latitude]' => 'Something New',
            'location[longitude]' => 'Something New',
        ]);

        self::assertResponseRedirects('/location/');

        $fixture = $this->locationRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getName());
        self::assertSame('Something New', $fixture[0]->getCountryCode());
        self::assertSame('Something New', $fixture[0]->getLatitude());
        self::assertSame('Something New', $fixture[0]->getLongitude());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Location();
        $fixture->setName('Value');
        $fixture->setCountryCode('Value');
        $fixture->setLatitude('Value');
        $fixture->setLongitude('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/location/');
        self::assertSame(0, $this->locationRepository->count([]));
    }
}

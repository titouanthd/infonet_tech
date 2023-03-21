<?php

namespace App\Command;

use App\Entity\Movie;
use App\Entity\Character;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'starwars:import',
    description: 'Import 30 Star Wars characters and all Star Wars movies from SWAPI API',
)]
class StarwarsImportCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $httpClient = HttpClient::create();

        $io = new SymfonyStyle($input, $output);

        // print start movies import message
        $io->title('Importing Star Wars movies...');
        $films_response = $httpClient->request('GET', 'https://swapi.dev/api/films/');

        // continue if status code is 200
        if ($films_response->getStatusCode() !== 200) {
            $io->error('Something went wrong!');
            return Command::FAILURE;
        } else {
            $io->success('Response status code is 200!');
        }

        $movies = $films_response->toArray()['results'];

        // count movies
        $io->writeln(sprintf('Number of movies: %d', count($movies)));

        // if count of movies > 0
        if (count($movies) > 0) {
            // for each movie in the response array save title, episode_id, opening_crawl and release_date to database
            foreach ($movies as $movie) {
                $m = new Movie();
                $m->setName($movie['title']);
                // save movie to database
                $this->entityManager->persist($m);
                
                // print movie title
                $io->writeln(sprintf('Movie title: %s', $m->getName()));
            }

            $this->entityManager->flush();
        } else {
            $io->error('No movies found!');
        }

        // print start import message
        $io->title('Importing Star Wars characters...');

        $characters = [];
        $charactersMax = 30;

        // get all characters from SWAPI API
        for ( $i = 1; $i <= ceil($charactersMax / 10); $i++ ) {
            $response = $httpClient->request('GET', 'https://swapi.dev/api/people/', [
                'query' => [
                    'page' => $i,
                    'limit' => 10,
                ],
            ]);

            // continue if status code is 200
            if ($response->getStatusCode() !== 200) {
                $io->error('Something went wrong!');
                return Command::FAILURE;
            } else {
                $io->success('Response status code is 200!');
            }

            $characters = array_merge($characters, $response->toArray()['results']);
        }

        // count characters
        $io->writeln(sprintf('Number of characters: %d', count($characters)));

        // for the 30 first characters in the response array save name, mass, height and gender to database
        if (count($characters) > 0) {
            foreach ($characters as $character) {
                $c = new Character();
                $c->setName($character['name']);
                $c->setMass($character['mass']);
                $c->setHeight($character['height']);
                $c->setGender($character['gender']);

                $movies = $character['films'];
                // for each movie in the movies array
                foreach ($movies as $movie) {
                    // get movie id from url
                    $movieId = explode('/', $movie)[5];
                    // print movie id
                    $io->writeln(sprintf('Movie id: %s', $movieId));
                    // get movie from database
                    $movie = $this->entityManager->getRepository(Movie::class)->findOneBy(['id' => $movieId]);
                    // add movie to character
                    $c->addMovie($movie);
                }

                // save character to database
                $this->entityManager->persist($c);
                
                // print character name
                $io->writeln(sprintf('Character name: %s', $c->getName()));
            }

            $this->entityManager->flush();
    
            $io->success('Star Wars characters imported successfully!');
        } else {
            $io->error('No characters found!');
        }

        return Command::SUCCESS;
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DOMDocument;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use App\Application\Service\ManageUploadFileService;

final class Version20210320161221 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Insert several rows in movie table';
    }

    public function up(Schema $schema) : void
    {
        $doc = new DOMDocument();
        $manageFile = new ManageUploadFileService();
    
        $doc->load('/var/www/html/migrations/data/moviesData.xml');
        $movies = $doc->getElementsByTagName('movie');

        foreach($movies as $movie){
            $movieObject = (object)[
                'title' => $movie->getAttribute('title'), 
                'overview' => $movie->getElementsByTagName('overview')->item(0)->nodeValue,
                'releaseDate' => $movie->getAttribute('releaseDate'),
                'duration' => $movie->getAttribute('duration'),
                'image' => base64_encode(file_get_contents($movie->getElementsByTagName('image')->item(0)->getAttribute('path')))
            ];

            $accessiblePath = $manageFile->uploadFileFromBase64("/var/www/html/uploadMovieImages/", $movieObject);

            $this->insertMovie($movieObject, $accessiblePath);

            $genres = $movie->getElementsByTagName('genre');

            $lastIdMovie = $this->getLastIdMovie();

            foreach($genres as $genre){
                $idGenre = $this->getIdGenre($genre->getAttribute('name'));
                $this->connection->insert('movies_genre', ['movies_id' => $lastIdMovie, 'genre_id' => $idGenre]);
            }
        }
    }

    public function down(Schema $schema) : void
    {
        $doc = new DOMDocument();
        $doc->load('/var/www/html/migrations/data/moviesData.xml');
        $movies = $doc->getElementsByTagName('movie');

        foreach($movies as $movie){
            $this->connection->delete('movies',['title' => $movie->getAttribute('title')]);
        }
    }

    private function insertMovie(object $movie, string $accessiblePath): void
    {
        $this->connection->insert('movies', [
            'title' => $movie->title, 
            'overview' => $movie->overview,
            'release_date' => $movie->releaseDate,
            'duration' => $movie->duration,
            'accessible_path' => $accessiblePath,
        ]);
    }

    private function getLastIdMovie(): string
    {
        return $this->connection->lastInsertId();
    }

    private function getIdGenre(string $genreName): string
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $genre = (object) $queryBuilder->select('g.id')
            ->from('genre', 'g')
            ->where($queryBuilder->expr()->eq('g.name', ':name'))
            ->setParameter('name', $genreName)
            ->execute()
            ->fetch();
        return $genre->id;
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DOMDocument;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210322191719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create more user and reviews for movies';
    }

    public function up(Schema $schema) : void
    {
        $this->insertUsers();

        $doc = new DOMDocument();
        $doc->load('/var/www/html/migrations/data/reviewMoviesData.xml');
        $reviews = $doc->getElementsByTagName('review');

        foreach($reviews as $review){
            $idUser = $this->getIdUser($review->getElementsByTagName('user')->item(0)->getAttribute('username'));
            $idMovie = $this->getIdMovie($review->getElementsByTagName('movie')->item(0)->getAttribute('title'));

            $this->connection->insert('review', 
                [
                'movies_id' => $idMovie,
                'title' => $review->getAttribute('title'),
                'paragraph' => str_replace(["              ", "          ", "         "], " ", $review->getElementsByTagName('paragraph')->item(0)->getAttribute('text')),
                'score' => $review->getAttribute('score'),
                'posting_date' => $review->getAttribute('postingDate'),
                'user_id' => $idUser,
                ]
            );
        }
    }

    public function down(Schema $schema) : void
    {

    }

    private function getIdUser(string $username): string
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $user = (object) $queryBuilder->select('u.id')
            ->from('user', 'u')
            ->where($queryBuilder->expr()->eq('u.username', ':username'))
            ->setParameter('username', $username)
            ->execute()
            ->fetch();
        return $user->id;
    }

    private function getIdMovie(string $title): string
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $movie = (object) $queryBuilder->select('m.id')
            ->from('movies', 'm')
            ->where($queryBuilder->expr()->eq('m.title', ':title'))
            ->setParameter('title', $title)
            ->execute()
            ->fetch();
        return $movie->id;
    }

    private function insertUsers(): void
    {
        $this->connection->insert(
            'user',
             [  
                 'username' => 'sergio', 
                 'email' => 'sergio@gmail.com', 
                 'roles' => json_encode(['ROLE_USER']), 
                 'password' => '$argon2id$v=19$m=65536,t=4,p=1$6pcyzFPhf2iVhbtFUYGyWg$82Jk3uyCC9jZraYs0jdlL0byz61rZqNYyNQCuNMAtHs'
             ]
        );
        $this->connection->insert(
            'user',
             [  
                 'username' => 'brenes', 
                 'email' => 'brenes@gmail.com', 
                 'roles' => json_encode(['ROLE_USER']), 
                 'password' => '$argon2id$v=19$m=65536,t=4,p=1$l6Cl1hdKvRWUGY03g9N8VA$8Vl+H3Ear/ItTX+MoNLmcjC7B24X3xO1opjEvzXhV+0'
             ]
        );
        $this->connection->insert(
            'user',
             [  
                 'username' => 'ruben', 
                 'email' => 'ruben@gmail.com', 
                 'roles' => json_encode(['ROLE_USER']), 
                 'password' => '$argon2id$v=19$m=65536,t=4,p=1$dFNAIbImrvAi2Kp6KI1f0A$q5C0oKZqcDPg6ev60X8fFtAs6Mm0I9VBUP0g/atJNpA'
             ]
        );
    }
}

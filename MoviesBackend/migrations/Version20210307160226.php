<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210307160226 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Change length of username field of user table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('user');
        
        $table->changeColumn('username', ["length"=> 40]);
    }

    public function postUp(Schema $schema): void
    {
        $this->connection->insert(
            'user',
             [  
                 'username' => 'alex', 
                 'email' => 'alex@gmail.com', 
                 'roles' => json_encode(['ROLE_USER', 'ROLE_ADMIN']), 
                 'password' => '$argon2id$v=19$m=65536,t=4,p=1$Bqr30P1LROww9Br/V13mtA$c2J8XXuubaEottPT/2YZtYhva/rO2WxzWV9ehHkveNQ'
             ]);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('user');

        $table->changeColumn('username', ['length' => 180]);
    }
}

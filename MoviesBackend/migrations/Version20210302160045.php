<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210302160045 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create relation between review and user';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('review');
        $table->addColumn('user_id', 'integer')->setNotnull(true);

        $tableUser = $schema->getTable('user');
        $table->addForeignKeyConstraint($tableUser, ['user_id'], ['id'], ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'], 'FK_user_review');
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('review');

        $table->removeForeignKey('FK_user_review');

        $table->dropColumn('user_id');
    }
}

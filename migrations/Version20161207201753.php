<?php

namespace Tv\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161207201753 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $channel = $schema->createTable('read_channel');

        $channel->addColumn('id', 'string', ['length' => 36]);
        $channel->addColumn('name', 'string', ['length' => 60]);
        $channel->addColumn('path', 'string', ['length' => 50]);
        $channel->addColumn('ownerId', 'string', ['length' => 36]);
        $channel->addUniqueIndex(['path']);
        $channel->setPrimaryKey(['id']);
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('read_channel');
    }
}

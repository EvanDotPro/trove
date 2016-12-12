<?php

namespace Tv\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161209195055 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $channel = $schema->createTable('read_counter');

        $channel->addColumn('videoId', 'string', ['length' => 36]);
        $channel->addColumn('channelId', 'string', ['length' => 36]);
        $channel->addColumn('source', 'string', ['length' => 10]);
        $channel->addColumn('sourceId', 'string', ['length' => 36]);
        $channel->addColumn('userId', 'string', ['length' => 36]);
        $channel->addIndex(['channelId']);
        $channel->setPrimaryKey(['videoId']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325072230 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add necessary columns for IOI mode scoreboard.';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(<<<SQL
ALTER TABLE `scorecache`
    ADD `points_up_restricted` INT(4) DEFAULT '0' NOT NULL COMMENT 'the number of tests passed on public board',
    ADD `points_up_public` INT(4) DEFAULT '0' NOT NULL COMMENT 'the number of tests passed on jury board',
    ADD `points_down` INT(4) DEFAULT '0' NOT NULL COMMENT 'the number of all tests'
SQL
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql',
            "Migration can only be executed safely on 'mysql'.");

        $this->addSql('ALTER TABLE scorecache DROP points_up_restricted, DROP points_up_public, DROP points_down');
    }
}

<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240124164402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE artwork_user DROP FOREIGN KEY FK_3975B07A76ED395');
        $this->addSql('ALTER TABLE artwork_user DROP FOREIGN KEY FK_3975B07DB8FFA4');
        $this->addSql('DROP TABLE artwork_user');
        $this->addSql('ALTER TABLE image ADD artwork_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FDB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045FDB8FFA4 ON image (artwork_id)');
        $this->addSql('CREATE INDEX IDX_C53D045FA76ED395 ON image (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artwork_user (artwork_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3975B07A76ED395 (user_id), INDEX IDX_3975B07DB8FFA4 (artwork_id), PRIMARY KEY(artwork_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE artwork_user ADD CONSTRAINT FK_3975B07A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artwork_user ADD CONSTRAINT FK_3975B07DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FDB8FFA4');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA76ED395');
        $this->addSql('DROP INDEX UNIQ_C53D045FDB8FFA4 ON image');
        $this->addSql('DROP INDEX IDX_C53D045FA76ED395 ON image');
        $this->addSql('ALTER TABLE image DROP artwork_id, DROP user_id');
    }
}

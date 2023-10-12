<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408134557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE connexion CHANGE ip_address ip_address VARCHAR(45) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE connexion CHANGE ip_address ip_address VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641082EA2E54');
        $this->addSql('ALTER TABLE facture_product DROP FOREIGN KEY FK_9BADA5F47F2DEE08');
        $this->addSql('ALTER TABLE facture_product DROP FOREIGN KEY FK_9BADA5F44584665A');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F5F004ACF');
    }
}

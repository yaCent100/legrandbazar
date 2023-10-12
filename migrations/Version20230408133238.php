<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408133238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_news_user (blog_news_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FD30C88D5952E423 (blog_news_id), INDEX IDX_FD30C88DA76ED395 (user_id), PRIMARY KEY(blog_news_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_news_user ADD CONSTRAINT FK_FD30C88D5952E423 FOREIGN KEY (blog_news_id) REFERENCES blog_news (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE blog_news_user ADD CONSTRAINT FK_FD30C88DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande RENAME INDEX user_id TO IDX_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE connexion CHANGE user_id user_id INT DEFAULT NULL, CHANGE Ip_Adress ip_adress VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE connexion ADD CONSTRAINT FK_936BF99CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE connexion RENAME INDEX user_id TO IDX_936BF99CA76ED395');
        $this->addSql('ALTER TABLE facture RENAME INDEX commande_id TO IDX_FE86641082EA2E54');
        $this->addSql('ALTER TABLE facture_product MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON facture_product');
        $this->addSql('ALTER TABLE facture_product DROP id');
        $this->addSql('ALTER TABLE facture_product ADD PRIMARY KEY (facture_id, product_id)');
        $this->addSql('ALTER TABLE facture_product RENAME INDEX facture_id TO IDX_9BADA5F47F2DEE08');
        $this->addSql('ALTER TABLE facture_product RENAME INDEX product_id TO IDX_9BADA5F44584665A');
        $this->addSql('ALTER TABLE message CHANGE content content LONGTEXT NOT NULL, CHANGE creat_at creat_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE message RENAME INDEX sender TO IDX_B6BD307F5F004ACF');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_news_user DROP FOREIGN KEY FK_FD30C88D5952E423');
        $this->addSql('ALTER TABLE blog_news_user DROP FOREIGN KEY FK_FD30C88DA76ED395');
        $this->addSql('DROP TABLE blog_news_user');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE commande RENAME INDEX idx_6eeaa67da76ed395 TO user_id');
        $this->addSql('ALTER TABLE connexion DROP FOREIGN KEY FK_936BF99CA76ED395');
        $this->addSql('ALTER TABLE connexion CHANGE user_id user_id INT NOT NULL, CHANGE ip_adress Ip_Adress VARCHAR(11) NOT NULL');
        $this->addSql('ALTER TABLE connexion RENAME INDEX idx_936bf99ca76ed395 TO user_id');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE86641082EA2E54');
        $this->addSql('ALTER TABLE facture RENAME INDEX idx_fe86641082ea2e54 TO commande_id');
        $this->addSql('ALTER TABLE facture_product DROP FOREIGN KEY FK_9BADA5F47F2DEE08');
        $this->addSql('ALTER TABLE facture_product DROP FOREIGN KEY FK_9BADA5F44584665A');
        $this->addSql('ALTER TABLE facture_product ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE facture_product RENAME INDEX idx_9bada5f47f2dee08 TO facture_id');
        $this->addSql('ALTER TABLE facture_product RENAME INDEX idx_9bada5f44584665a TO product_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F5F004ACF');
        $this->addSql('ALTER TABLE message CHANGE content content TEXT NOT NULL, CHANGE creat_at creat_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE message RENAME INDEX idx_b6bd307f5f004acf TO sender');
    }
}

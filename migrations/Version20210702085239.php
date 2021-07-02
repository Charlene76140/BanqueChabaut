<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210702085239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, number VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, date DATETIME NOT NULL, amount INT NOT NULL, INDEX IDX_7D3656A49D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE operation (id INT AUTO_INCREMENT NOT NULL, account_id_id INT NOT NULL, date DATETIME NOT NULL, label VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, amount INT NOT NULL, INDEX IDX_1981A66D49CB4726 (account_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A49D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D49CB4726 FOREIGN KEY (account_id_id) REFERENCES account (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D49CB4726');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A49D86650F');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE user');
    }
}

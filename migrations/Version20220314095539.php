<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220314095539 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, brand VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owns (id INT AUTO_INCREMENT NOT NULL, item_id INT NOT NULL, user_id INT NOT NULL, count INT NOT NULL, INDEX IDX_21CD2033126F525E (item_id), INDEX IDX_21CD2033A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, money INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE owns ADD CONSTRAINT FK_21CD2033126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE owns ADD CONSTRAINT FK_21CD2033A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE owns DROP FOREIGN KEY FK_21CD2033126F525E');
        $this->addSql('ALTER TABLE owns DROP FOREIGN KEY FK_21CD2033A76ED395');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE owns');
        $this->addSql('DROP TABLE user');
    }
}

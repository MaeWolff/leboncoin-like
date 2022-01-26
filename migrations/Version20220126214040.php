<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126214040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD author_id INT DEFAULT NULL, ADD tag_id INT NOT NULL, ADD created_at DATETIME NOT NULL, ADD title VARCHAR(255) NOT NULL, ADD description VARCHAR(5000) NOT NULL, ADD images LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DBAD26311 ON post (tag_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DBAD26311');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8DBAD26311 ON post');
        $this->addSql('ALTER TABLE post DROP author_id, DROP tag_id, DROP created_at, DROP title, DROP description, DROP images, DROP price');
    }
}

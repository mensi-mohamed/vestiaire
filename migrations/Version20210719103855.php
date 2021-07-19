<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210719103855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, currency_id INT DEFAULT NULL, seller_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, INDEX IDX_1F1B251E38248176 (currency_id), INDEX IDX_1F1B251E8DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payout (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, currency_id INT NOT NULL, INDEX IDX_4E2EA9028DE820D9 (seller_id), INDEX IDX_4E2EA90238248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seller (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E38248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E8DE820D9 FOREIGN KEY (seller_id) REFERENCES seller (id)');
        $this->addSql('ALTER TABLE payout ADD CONSTRAINT FK_4E2EA9028DE820D9 FOREIGN KEY (seller_id) REFERENCES seller (id)');
        $this->addSql('ALTER TABLE payout ADD CONSTRAINT FK_4E2EA90238248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E38248176');
        $this->addSql('ALTER TABLE payout DROP FOREIGN KEY FK_4E2EA90238248176');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E8DE820D9');
        $this->addSql('ALTER TABLE payout DROP FOREIGN KEY FK_4E2EA9028DE820D9');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE payout');
        $this->addSql('DROP TABLE seller');
    }
}

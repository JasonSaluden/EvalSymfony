<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250428132427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, id_produit_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, INDEX IDX_C53D045FAABEFE2C (id_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE message_contact (id INT AUTO_INCREMENT NOT NULL, id_utilisateur_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, sujet VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_DCEADC34C6EE5C49 (id_utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, id_categorie_id INT DEFAULT NULL, nom_produit VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, date_ajout DATETIME NOT NULL, supprime TINYINT(1) NOT NULL, INDEX IDX_29A5EC279F34925F (id_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, date_inscription DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE image ADD CONSTRAINT FK_C53D045FAABEFE2C FOREIGN KEY (id_produit_id) REFERENCES produit (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_contact ADD CONSTRAINT FK_DCEADC34C6EE5C49 FOREIGN KEY (id_utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit ADD CONSTRAINT FK_29A5EC279F34925F FOREIGN KEY (id_categorie_id) REFERENCES categorie (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAABEFE2C
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE message_contact DROP FOREIGN KEY FK_DCEADC34C6EE5C49
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC279F34925F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categorie
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE message_contact
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produit
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE utilisateur
        SQL);
    }
}

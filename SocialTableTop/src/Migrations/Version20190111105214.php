<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190111105214 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE my_table (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, mj VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE my_table_joueur (my_table_id INT NOT NULL, joueur_id INT NOT NULL, INDEX IDX_DB56F020DEADBD13 (my_table_id), INDEX IDX_DB56F020A9E2D76C (joueur_id), PRIMARY KEY(my_table_id, joueur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage (id INT AUTO_INCREMENT NOT NULL, joueur_id INT NOT NULL, table_de_jeux_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6AEA486DA9E2D76C (joueur_id), INDEX IDX_6AEA486D8DDCC73C (table_de_jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE my_table_joueur ADD CONSTRAINT FK_DB56F020DEADBD13 FOREIGN KEY (my_table_id) REFERENCES my_table (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE my_table_joueur ADD CONSTRAINT FK_DB56F020A9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486DA9E2D76C FOREIGN KEY (joueur_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D8DDCC73C FOREIGN KEY (table_de_jeux_id) REFERENCES my_table (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE my_table_joueur DROP FOREIGN KEY FK_DB56F020A9E2D76C');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486DA9E2D76C');
        $this->addSql('ALTER TABLE my_table_joueur DROP FOREIGN KEY FK_DB56F020DEADBD13');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486D8DDCC73C');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE my_table');
        $this->addSql('DROP TABLE my_table_joueur');
        $this->addSql('DROP TABLE personnage');
    }
}

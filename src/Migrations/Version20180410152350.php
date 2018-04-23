<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180410152350 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE reponse');
        $this->addSql('ALTER TABLE question ADD rang VARCHAR(6) NOT NULL, ADD type_q VARCHAR(5) NOT NULL, ADD name VARCHAR(20) NOT NULL, ADD text VARCHAR(60) NOT NULL, ADD response1 VARCHAR(31) NOT NULL, ADD response2 VARCHAR(31) NOT NULL, ADD response3 VARCHAR(31) NOT NULL, ADD response4 VARCHAR(31) NOT NULL, ADD response5 VARCHAR(31) NOT NULL, ADD `default` VARCHAR(31) NOT NULL, DROP nb_response');
        $this->addSql('ALTER TABLE questionnaire ADD name VARCHAR(40) NOT NULL, ADD display_name VARCHAR(60) NOT NULL, ADD description VARCHAR(124) DEFAULT NULL, DROP nom, DROP lib, DROP descriptif, DROP auteur');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, reponse VARCHAR(200) NOT NULL COLLATE utf8_unicode_ci, bonne_reponse INT NOT NULL, INDEX IDX_5FB6DEC71E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC71E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE question ADD nb_response INT NOT NULL, DROP rang, DROP type_q, DROP name, DROP text, DROP response1, DROP response2, DROP response3, DROP response4, DROP response5, DROP `default`');
        $this->addSql('ALTER TABLE questionnaire ADD nom VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, ADD lib VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, ADD descriptif VARCHAR(500) NOT NULL COLLATE utf8_unicode_ci, ADD auteur VARCHAR(100) NOT NULL COLLATE utf8_unicode_ci, DROP name, DROP display_name, DROP description');
    }
}

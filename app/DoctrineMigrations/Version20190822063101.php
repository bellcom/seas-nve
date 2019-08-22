<?php

namespace Application\Migrations;

use AppBundle\Entity\User;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190822063101 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @inheritDoc
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ContactPerson CHANGE mail mail VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fos_user ADD token VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE Virksomhed ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Virksomhed ADD CONSTRAINT FK_8B8D3762A76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_8B8D3762A76ED395 ON Virksomhed (user_id)');
    }

    /**
     * @inheritDoc
     */
    public function postUp(Schema $schema)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.entity_manager');
        /** @var User $user */
        foreach ($em->getRepository('AppBundle:User')->findAll() as $user) {
            if (empty($user->getToken())) {
                $user->generateToken();
                $em->persist($user);
            }
        }
        $em->flush();
    }

    /**
     * @inheritDoc
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ContactPerson CHANGE mail mail VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE Virksomhed DROP FOREIGN KEY FK_8B8D3762A76ED395');
        $this->addSql('DROP INDEX IDX_8B8D3762A76ED395 ON Virksomhed');
        $this->addSql('ALTER TABLE Virksomhed DROP user_id');
        $this->addSql('ALTER TABLE fos_user DROP token');
    }
}

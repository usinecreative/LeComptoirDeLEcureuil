<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Exception;
use JK\CmsBundle\Entity\Media;
use PDO;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Change Media table due to new entity.
 */
class Version20161128005212 extends AbstractMigration implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        
        $this->addSql('ALTER TABLE cms_media ADD updatedAt DATETIME NOT NULL, DROP updated_at, CHANGE filepath fileType VARCHAR(255) NOT NULL, CHANGE created_at createdAt DATETIME NOT NULL');
        $this->addSql('ALTER TABLE cms_media ADD description LONGTEXT NOT NULL');

        $this->addSql('ALTER TABLE cms_category ADD thumbnail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_category ADD CONSTRAINT FK_6CA2D53CFDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES cms_media (id)');
        $this->addSql('CREATE INDEX IDX_6CA2D53CFDFF2E92 ON cms_category (thumbnail_id)');

        $this->addSql('ALTER TABLE cms_article ADD thumbnail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cms_article ADD CONSTRAINT FK_5CD60177FDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES cms_media (id)');
        $this->addSql('CREATE INDEX IDX_5CD60177FDFF2E92 ON cms_article (thumbnail_id)');
    
        $this->addSql('ALTER TABLE cms_category DROP thumbnail_name');
    }
    
    public function postUp(Schema $schema)
    {
        parent::postUp($schema);
    
        $this->updateArticleThumbnails();
    }
    
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cms_media ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP createdAt, DROP updatedAt, CHANGE filetype filepath VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE cms_media DROP description');
        $this->addSql('ALTER TABLE cms_category DROP FOREIGN KEY FK_6CA2D53CFDFF2E92');
        $this->addSql('DROP INDEX IDX_6CA2D53CFDFF2E92 ON cms_category');
        $this->addSql('ALTER TABLE cms_category ADD thumbnail VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP thumbnail_id');
    
        $this->addSql('ALTER TABLE cms_article DROP FOREIGN KEY FK_5CD60177FDFF2E92');
        $this->addSql('DROP INDEX IDX_5CD60177FDFF2E92 ON cms_article');
        $this->addSql('ALTER TABLE cms_article ADD thumbnail_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP thumbnail_id');
        $this->addSql('ALTER TABLE cms_category ADD thumbnail_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
    
    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    
    protected function updateArticleThumbnails()
    {
        // update existing thumbnails
        $entityManager = $this
            ->container
            ->get('doctrine.orm.entity_manager');
    
        $stmt = $entityManager
            ->getConnection()
            ->prepare('SELECT * FROM cms_article');
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $thumbnailDirectory = $this
                ->container
                ->getParameter('kernel.root_dir').'/../web/images/articles/thumbnails/';
        $newThumbnailDirectory = $this
                ->container
                ->getParameter('kernel.root_dir').'/../web/uploads/articles/thumbnails/';
        $fileSystem = new Filesystem();
    
        foreach ($results as $article) {
            $file = $thumbnailDirectory.$article['thumbnail_name'];
    
            if (!$fileSystem->exists($file)) {
                throw new Exception('Article thumbnail '.$article['thumbnail_name'].' can not be found');
            }
            $media = new Media();
            $media->setName($article['thumbnail_name']);
            $media->setFileName($article['thumbnail_name']);
            $media->setFileType($this->getFileExtension($article['thumbnail_name']));
            $media->setType('article_thumbnail');
            $media->setSize(filesize($file));
            $entityManager->persist($media);
            $entityManager->flush($media);
    
            $stmt = $entityManager
                ->getConnection()
                ->prepare('UPDATE cms_article SET thumbnail_id = '.$media->getId().' WHERE id = '.$article['id']);
            $stmt->execute();
            
            $fileSystem->copy($file, $newThumbnailDirectory.$article['thumbnail_name']);
        }
    }
    
    protected function getFileExtension($file)
    {
        $array = explode('.', $file);
    
        return array_pop($array);
    }
}

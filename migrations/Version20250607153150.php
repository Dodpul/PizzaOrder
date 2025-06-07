<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607153150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_comment VARCHAR(255) DEFAULT NULL, customer_id INT NOT NULL, pizza_id INT NOT NULL, size_id INT NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), INDEX IDX_F5299398D41D1D42 (pizza_id), INDEX IDX_F5299398498DA827 (size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, comment VARCHAR(255) DEFAULT NULL, order_id INT NOT NULL, pizza_id INT NOT NULL, size_id INT NOT NULL, INDEX IDX_52EA1F098D9F6D38 (order_id), INDEX IDX_52EA1F09D41D1D42 (pizza_id), INDEX IDX_52EA1F09498DA827 (size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE order_item_toppings (order_item_id INT NOT NULL, toppings_id INT NOT NULL, INDEX IDX_E48F925DE415FB15 (order_item_id), INDEX IDX_E48F925DBE2B4234 (toppings_id), PRIMARY KEY(order_item_id, toppings_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D41D1D42 FOREIGN KEY (pizza_id) REFERENCES pizzas (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` ADD CONSTRAINT FK_F5299398498DA827 FOREIGN KEY (size_id) REFERENCES sizes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09D41D1D42 FOREIGN KEY (pizza_id) REFERENCES pizzas (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09498DA827 FOREIGN KEY (size_id) REFERENCES sizes (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item_toppings ADD CONSTRAINT FK_E48F925DE415FB15 FOREIGN KEY (order_item_id) REFERENCES order_item (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item_toppings ADD CONSTRAINT FK_E48F925DBE2B4234 FOREIGN KEY (toppings_id) REFERENCES toppings (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE orders
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, pizza_id INT NOT NULL, customer_comment VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, size_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398D41D1D42
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398498DA827
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F098D9F6D38
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09D41D1D42
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09498DA827
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item_toppings DROP FOREIGN KEY FK_E48F925DE415FB15
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE order_item_toppings DROP FOREIGN KEY FK_E48F925DBE2B4234
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `order`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE order_item
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE order_item_toppings
        SQL);
    }
}

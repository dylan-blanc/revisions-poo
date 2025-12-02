<?php

$dsn = 'mysql:host=localhost;dbname=draft-shop;charset=utf8';
$user = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion a la base de donnees reussie<br>";
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

class Product
{
    private int $id;
    private string $name = "";
    private array $photos = [];
    private int $price = 0;
    private string $description = "";
    private int $quantity = 0;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private int $category_id;
    private PDO $pdo;


    public function __construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id, PDO $pdo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->category_id = $category_id;
        $this->pdo = $pdo;
    }

    // getters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getPhotos()
    {
        return $this->photos;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function getDescription()
    {
        return $this->description;
    }
    public function getQuantity()
    {
        return $this->quantity;
    }
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    public function getCategory(): ?Category
    {
        $stmt = $this->pdo->prepare("SELECT * FROM category WHERE id = ?");
        $stmt->execute([$this->category_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Category(
                $row['id'],
                $row['name'],
                $row['description'],
                new DateTime($row['created_at']),
                new DateTime($row['updated_at'])
            );
        }
        return null;
    }

    public static function getProductById(PDO $pdo, int $id): ?Product
    {
        $stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->execute([$id]);
        $productData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($productData) {
            return new Product(
                $productData['id'],
                $productData['name'],
                json_decode($productData['photos'], true),
                $productData['price'],
                $productData['description'],
                $productData['quantity'],
                new DateTime($productData['created_at']),
                new DateTime($productData['updated_at']),
                $productData['category_id'],
                $pdo
            );
        }
        return null;
    }

    // setters
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }
    public function setPrice($price)
    {
        $this->price = $price;
    }
    public function setDescription($description)
    {
        $this->description = $description;
    }
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }
}



class Category
{
    private int $id;
    private string $name = "";
    private string $description = "";
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(int $id, string $name, string $description, DateTime $createdAt, DateTime $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
    public function getProducts(PDO $pdo): array
    {
        $stmt = $pdo->prepare("SELECT * FROM product WHERE category_id = ?");
        $stmt->execute([$this->id]);
        $products = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new Product(
                $row['id'],
                $row['name'],
                json_decode($row['photos'], true),
                $row['price'],
                $row['description'],
                $row['quantity'],
                new DateTime($row['created_at']),
                new DateTime($row['updated_at']),
                $row['category_id'],
                $pdo
            );
        }
        return $products;
    }

    // setters  

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}



$product = Product::getProductById($pdo, 7);


if ($product) {
    echo "<h3>Produit (id 7) :</h3>";
    echo "Nom : " . $product->getName() . "<br>";
    echo "Prix : " . ($product->getPrice() / 100) . " €<br>";
    echo "Description : " . $product->getDescription() . "<br>";
    echo "Quantité : " . $product->getQuantity() . "<br>";
    echo "Photos : " . implode(", ", $product->getPhotos()) . "<br>";

    $category = $product->getCategory();
    if ($category) {
        echo "<h3>Categorie du produit (id 7) :</h3>";
        echo "Nom : " . $category->getName() . "<br>";
        echo "Description : " . $category->getDescription() . "<br>";
        echo "Créée le : " . $category->getCreatedAt()->format('d-m-y H:i:s') . "<br>";
        echo "Modifiée le : " . $category->getUpdatedAt()->format('d-m-y H:i:s') . "<br>";
    } else {
        echo "Categorie non trouvée pour le produit.";
    }
} else {
    echo "Produit avec l'id 7 non trouvé.";
}

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
    private ?int $id = null;
    private string $name = "";
    private array $photos = [];
    private int $price = 0;
    private string $description = "";
    private int $quantity = 0;
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private int $category_id = 0;
    private PDO $pdo;


    public function __construct(
        ?int $id,
        string $name,
        array $photos,
        int $price,
        string $description,
        int $quantity,
        DateTime $createdAt,
        DateTime $updatedAt,
        int $category_id,
        PDO $pdo
    ) {
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
    public function getId(): ?int
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
                new DateTime($row['updated_at']),
                $this->pdo
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
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }
    public function setPhotos($photos): self
    {
        $this->photos = $photos;
        return $this;
    }
    public function setPrice($price): self
    {
        $this->price = $price;
        return $this;
    }
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }
    public function setQuantity($quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }
    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function findOneById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->photos = json_decode($row['photos'], true);
            $this->price = $row['price'];
            $this->description = $row['description'];
            $this->quantity = $row['quantity'];
            $this->createdAt = new DateTime($row['created_at']);
            $this->updatedAt = new DateTime($row['updated_at']);
            $this->category_id = $row['category_id'];
            return $this;
        }
        return false;
    }

    public static function findAll(PDO $pdo): array
    {
        $stmt = $pdo->query("SELECT * FROM product");
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

    public function create(): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO product (name, photos, price, description, quantity, created_at, updated_at, category_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $success = $stmt->execute([
            $this->name,
            json_encode($this->photos),
            $this->price,
            $this->description,
            $this->quantity,
            $this->createdAt->format('d-m-y H:i:s'),
            $this->updatedAt->format('d-m-y H:i:s'),
            $this->category_id
        ]);
        if ($success) {
            $this->id = (int)$this->pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public function update(): bool
    {
        if ($this->id === null) {
            return false;
        }
        $stmt = $this->pdo->prepare("UPDATE product SET name = ?, photos = ?, price = ?, description = ?, quantity = ?, created_at = ?, updated_at = ?, category_id = ? WHERE id = ?");
        $success = $stmt->execute([
            $this->name,
            json_encode($this->photos),
            $this->price,
            $this->description,
            $this->quantity,
            $this->createdAt->format('d-m-y H:i:s'),
            $this->updatedAt->format('d-m-y H:i:s'),
            $this->category_id,
            $this->id
        ]);
        return $success;
    }
}



class Category
{
    private int $id;
    private string $name = "";
    private string $description = "";
    private DateTime $createdAt;
    private DateTime $updatedAt;
    private PDO $pdo;

    public function __construct(
        int $id,
        string $name,
        string $description,
        DateTime $createdAt,
        DateTime $updatedAt,
        PDO $pdo
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->pdo = $pdo;
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
    public function getProducts(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM product WHERE category_id = ?");
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
                $this->pdo
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



$product = new Product(
    null,
    'T-shirt',
    ['https://picsum.photos/200/300'],
    1000,
    'A beautiful T-shirt',
    10,
    new DateTime(),
    new DateTime(),
    2,
    $pdo
);

$result = $product->create();
if ($result) {
    echo "Succès : Produit créé avec l'ID : " . $product->getId() . "<br>";
} else {
    echo "Échec de la création du produit.<br>";
}

$product->setName('T-shirt 232')->setQuantity(24);

$product->update();
echo "Produit mis à jour : " . $product->getName() . " avec une quantité de " . $product->getQuantity() . "<br>";

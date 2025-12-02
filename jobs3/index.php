<?php

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


    public function __construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt, $category_id)
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
    public function getCategoryId()
    {
        return $this->category_id;
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
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
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

$product1 = new Product(1, 'T-shirt', ['https://picsum.photos/200/300'], 1000, 'A beautiful T-shirt', 10, new DateTime(), new DateTime(), 1);

echo "<table border='1' cellpadding='5' style='float: left;'>";
echo "<tr><th>Propriété</th><th>Valeur assignée</th></tr>";
echo "<tr><td>Id</td><td>" . $product1->getId() . "</td></tr>";
echo "<tr><td>Name</td><td>" . $product1->getName() . "</td></tr>";
echo "<tr><td>Photos</td><td>" . implode(", ", $product1->getPhotos()) . "</td></tr>";
echo "<tr><td>Price</td><td>" . $product1->getPrice() . "</td></tr>";
echo "<tr><td>Description</td><td>" . $product1->getDescription() . "</td></tr>";
echo "<tr><td>Quantity</td><td>" . $product1->getQuantity() . "</td></tr>";
echo "<tr><td>Created At</td><td>" . $product1->getCreatedAt()->format('d-m-Y') . "</td></tr>";
echo "<tr><td>Updated At</td><td>" . $product1->getUpdatedAt()->format('d-m-Y') . "</td></tr>";
echo "</table>";
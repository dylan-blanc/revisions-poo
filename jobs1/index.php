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

    public function __construct($id, $name, $photos, $price, $description, $quantity, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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


$test = new Product(1, "Test", ["photo1.jpg", "photo2.jpg"], 100, "test description", 10, new DateTime("2012-12-12"), new DateTime("2012-12-13"));

echo "<h2> <- Tableau via echo (get) -> </h2>";


echo "<table border='1' cellpadding='5' style='float: left;'>";
echo "<tr><th>Propriété</th><th>Valeur assignée</th></tr>";
echo "<tr><td>Id</td><td>" . $test->getId() . "</td></tr>";
echo "<tr><td>Name</td><td>" . $test->getName() . "</td></tr>";
echo "<tr><td>Photos</td><td>" . implode(", ", $test->getPhotos()) . "</td></tr>";
echo "<tr><td>Price</td><td>" . $test->getPrice() . "</td></tr>";
echo "<tr><td>Description</td><td>" . $test->getDescription() . "</td></tr>";
echo "<tr><td>Quantity</td><td>" . $test->getQuantity() . "</td></tr>";
echo "<tr><td>Created At</td><td>" . $test->getCreatedAt()->format('d-m-Y') . "</td></tr>";
echo "<tr><td>Updated At</td><td>" . $test->getUpdatedAt()->format('d-m-Y') . "</td></tr>";
echo "</table>";

$test->setName("TestTest");
$test->setPhotos(["photo3.jpg", "photo4.jpg"]);
$test->setPrice(200);
$test->setDescription("updated description");
$test->setQuantity(20);
$test->setCreatedAt(new DateTime("2013-01-01"));
$test->setUpdatedAt(new DateTime("2013-01-02"));

echo "<table border='2' cellpadding='5' style= 'float: right;'>";
echo "<tr><th>Propriété</th><th>Valeur modif (set)</th></tr>";
echo "<tr><td>Id</td><td>" . $test->getId() . "</td></tr>";
echo "<tr><td>Name</td><td>" . $test->getName() . "</td></tr>";
echo "<tr><td>Photos</td><td>" . implode(", ", $test->getPhotos()) . "</td></tr>";
echo "<tr><td>Price</td><td>" . $test->getPrice() . "</td></tr>";
echo "<tr><td>Description</td><td>" . $test->getDescription() . "</td></tr>";
echo "<tr><td>Quantity</td><td>" . $test->getQuantity() . "</td></tr>";
echo "<tr><td>Created At</td><td>" . $test->getCreatedAt()->format('d-m-Y') . "</td></tr>";
echo "<tr><td>Updated At</td><td>" . $test->getUpdatedAt()->format('d-m-Y') . "</td></tr>";
echo "</table>";

echo '<div class="main-content">';

echo "<h2>var_dump simple </h2>";
echo "<p>";
var_dump($test);
echo "</p>";

echo "<h2>var_dump sous forme de tableau </h2>";


echo "<table border='1' cellpadding='5' style='margin-top:20px' class='var-dump-table'>";
echo "<tr><th>Propriété</th><th>Valeur</th></tr>";
foreach ((new ReflectionClass($test))->getProperties() as $prop) {
    $prop->setAccessible(true);
    $value = $prop->getValue($test);
    if (is_array($value)) {
        $value = implode(', ', $value);
    } elseif ($value instanceof DateTime) {
        $value = $value->format('d-m-Y');
    }
    echo "<tr><td>{$prop->getName()}</td><td>{$value}</td></tr>";
}
echo "</table>";

echo '</div>';

?>

<style>
    .main-content {
        position: relative;
        top: 50px;
    }

    .var-dump-table {
        margin-left: auto;
        margin-right: auto;
    }

    h2 {
        text-align: center;
        margin-top: 40px;
    }

    p {
        text-align: center;

    }
</style>
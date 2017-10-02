<?php
/**
 * Created by PhpStorm.
 * User: Maxime
 * Date: 19/09/2017
 * Time: 10:49
 */
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="product")
 */


class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name",type="string",length=255)
     * @var string
     *
     */
    private $name;

    /**
     * @ORM\Column(name="description",type="text")
     * @var text
     *
     */
    private $description;

    /**
     * @ORM\Column(name="price",type="bigint")
     * @var bigint
     */
    private $price;

    /**
     *@Assert\NotBlank()
     *@Assert\Image()
     *@ORM\Column(type="string")
     *
     * @var string
     */
    private $image;

    /**
     * @return bigint
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param bigint $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return text
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @ORM\ManyToOne(
     * targetEntity="Category",
     * inversedBy="products")
     *
     * @var Category
     */
    private $category;

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function __toString()
    {
        return $this->name;
    }
}


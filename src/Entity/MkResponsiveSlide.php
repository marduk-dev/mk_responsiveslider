<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Marduk\Module\Mk_ResponsiveSlider\Repository\MkResponsiveSlideRepository")
 */
class MkResponsiveSlide
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id_slide", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @ORM\Column(name="order_weight", type="integer")
     */
    private $orderWeight;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $imageName;

    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var string
     * 
     * @ORM\Column(name="sub_title", type="string")
     */
    private $subTitle;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOrderWeight()
    {
        return $this->orderWeight;
    }

    /**
     * @param mixed $orderWeight
     */
    public function setOrderWeight($orderWeight): void
    {
        $this->orderWeight = $orderWeight;
    }

    /**
     * @return string
     */
    public function getImageName(): string
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     */
    public function setImageName(string $imageName): void
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    /**
     * @param string $subTitle
     */
    public function setSubTitle($subTitle): void
    {
        $this->subTitle = $subTitle;
    }
}

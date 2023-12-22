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
   * @var bool
   *
   * @ORM\Column(name="is_enabled", type="boolean")
   */
  private $enabled = true;

  /**
   * @ORM\Column(type="integer")
   */
  private $position = -1;

  /**
   * @var string
   * 
   * @ORM\Column(type="string")
   */
  private $title;

  /**
   * @var string
   * 
   * @ORM\Column(type="string")
   */
  private $description;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   */
  private $url;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   */
  private $desktopImageName;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   */
  private $mobileImageName;

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
   * @return bool
   */
  public function isEnabled(): bool
  {
    return $this->enabled;
  }

  public function enable(): void
  {
    $this->enabled = true;
  }

  public function disable(): void
  {
    $this->enabled = false;
  }

  /**
   * @return int
   */
  public function getPosition()
  {
    return $this->position;
  }

  /**
   * @param int $position
   */
  public function setPosition(int $position): void
  {
    $this->position = $position;
  }

  /**
   * @return string
   */
  public function getUrl(): string|null
  {
    return $this->url;
  }

  /**
   * @param string $url
   */
  public function setUrl(string|null $url): void
  {
    $this->url = $url;
  }

  /**
   * @return string
   */
  public function getDesktopImageName(): string
  {
    return $this->desktopImageName;
  }

  /**
   * @param string $imageName
   */
  public function setDesktopImageName(string $imageName): void
  {
    $this->desktopImageName = $imageName;
  }

  /**
   * @return string
   */
  public function getMobileImageName(): string
  {
    return $this->mobileImageName;
  }

  /**
   * @param string $imageName
   */
  public function setMobileImageName(string $imageName): void
  {
    $this->mobileImageName = $imageName;
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
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription($description): void
  {
    $this->description = $description;
  }
}

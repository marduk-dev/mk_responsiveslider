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
   * @ORM\Column(name="link_url", type="string")
   */
  private $linkUrl;

  /**
   * @var string
   *
   * @ORM\Column(name="desktop_image_url", type="string")
   */
  private $desktopImageUrl;

  /**
   * @var string
   *
   * @ORM\Column(name="mobile_image_url", type="string")
   */
  private $mobileImageUrl;

  /**
   * @var bool
   *
   * @ORM\Column(name="is_text_visible", type="boolean")
   */
  private $textVisible;

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
  public function getLinkUrl(): string|null
  {
    return $this->linkUrl;
  }

  /**
   * @param string $url
   */
  public function setLinkUrl(string|null $linkUrl): void
  {
    $this->linkUrl = $linkUrl;
  }

  /**
   * @return string
   */
  public function getDesktopImageUrl(): string
  {
    return $this->desktopImageUrl;
  }

  /**
   * @param string $imageUrl
   */
  public function setDesktopImageUrl(string $imageUrl): void
  {
    $this->desktopImageUrl = $imageUrl;
  }

  /**
   * @return string
   */
  public function getMobileImageUrl(): string
  {
    return $this->mobileImageUrl;
  }

  /**
   * @param string $imageUrl
   */
  public function setMobileImageUrl(string $imageUrl): void
  {
    $this->mobileImageUrl = $imageUrl;
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
  public function getDescription(): string | null
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
  
  /**
   * @return bool
   */
  public function isTextVisible(): bool
  {
    return $this->textVisible;
  }

  public function showText(): void
  {
    $this->textVisible = true;
  }

  public function hideText(): void
  {
    $this->textVisible = false;
  }
}

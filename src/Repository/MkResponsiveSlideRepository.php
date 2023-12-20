<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Repository;

use Doctrine\ORM\EntityRepository;
use Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide;
use Marduk\Module\Mk_ResponsiveSlider\Helpers\FileHelper;

class MkResponsiveSlideRepository extends EntityRepository
{
  /**
   * @param $weight
   * @param $imageName
   */
  public function addSlider($weight, $title, $subTitle)
  {
    $slide = new MkResponsiveSlide();
    $slide->setOrderWeight($weight);
    $slide->setTitle($title);
    $slide->setSubTitle($subTitle);

    $this->set($slide);
  }

  public function updateSlider($id, $weight, $title, $subTitle)
  {
    $slide = $this->findOneBy(['id' => $id]);
    $slide->setWeight($weight);
    $slide->setTitle($title);
    $slide->setSubTitle($subTitle);

    $this->set($slide);
  }

  public function get($id): MkResponsiveSlide|null
  {
    if (is_null($id)) {
      return null;
    }
    return $this->findOneBy(['id' => $id]);
  }

  public function set(MkResponsiveSlide $slide)
  {
    $em = $this->getEntityManager();
    $em->persist($slide);
    $em->flush();
  }

  /**
   * @param MkResponsiveSlide $slide
   */
  public function deleteSlide(MkResponsiveSlide $slide)
  {
    if ($slide) {
      $em = $this->getEntityManager();
      $em->remove($slide);
      $em->flush();
    }
  }

  public function setDesktopImageName(int $id, string $originalName): string|false
  {
    $slide = $this->get($id);
    if ($slide) {
      $imageName = FileHelper::randomizeName($originalName);
      $slide->setDesktopImageName($imageName);
      $this->set($slide);

      return $imageName;
    }
    return false;
  }

  public function setMobileImageName(int $id, string $originalName): string|false
  {
    $slide = $this->get($id);
    if ($slide) {
      $imageName = FileHelper::randomizeName($originalName);
      $slide->setMobileImageName($imageName);
      $this->set($slide);

      return $imageName;
    }
    return false;
  }
}

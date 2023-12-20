<?php

declare(strict_types=1);

namespace Marduk\Module\Mk_ResponsiveSlider\Repository;

use Doctrine\ORM\EntityRepository;
use Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide;

class MkResponsiveSlideRepository extends EntityRepository
{
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

  public function getNextPosition(): int
  {
    $lastPos = $this->getEntityManager()
        ->createQueryBuilder()
        ->select('max(s.position)')
        ->from('Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide', 's')
        ->getQuery()
        ->getSingleScalarResult() ?? 0;
    return $lastPos + 1;
  }

  public function delete(int $slideId): void {
    $this->getEntityManager()
        ->createQueryBuilder()
        ->delete('Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide', 's')
        ->where('s.id = :slide_id')
        ->setParameter('slide_id', $slideId)
        ->getQuery()
        ->execute();
  }
}

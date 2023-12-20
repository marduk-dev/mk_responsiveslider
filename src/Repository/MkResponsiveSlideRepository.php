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
    return $this->getEntityManager()
        ->createQueryBuilder()
        ->select('max(s.id) + 1')
        ->from('Marduk\Module\Mk_ResponsiveSlider\Entity\MkResponsiveSlide', 's')
        ->getQuery()
        ->getSingleScalarResult() ?? 1;
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

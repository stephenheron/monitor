<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Path;

use Doctrine\ORM\EntityRepository;

/**
 * SnapshotRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SnapshotRepository extends EntityRepository
{
    public function getSnapshotsForPathQuery(Path $path)
    {
        $query = $this->getEntityManager()
            ->createQuery('SELECT s FROM AppBundle:Snapshot s WHERE s.path = :path ORDER BY s.created DESC'
            )->setParameter('path', $path);

        return $query;
    }

    public function getSnapshotsForPath(Path $path)
    {
        $query = $this->getSnapshotsForPathQuery($path);
        return $query->getResult();
    }
}

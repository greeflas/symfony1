<?php

/**
 * JobeetAffiliate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Vladimir Kuprienko
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class JobeetAffiliate extends BaseJobeetAffiliate
{
    /**
     * @inheritdoc
     */
    public function save(Doctrine_Connection $conn = null)
    {
        if (!$this->getToken()) {
            $this->setToken(sha1($this->getEmail() . rand(11111, 99999)));
        }

        return parent::save($conn);
    }

    /**
     * @return mixed
     */
    public function getActiveJobs()
    {
        $q = Doctrine_Query::create()
            ->select('j.*')
            ->from('JobeetJob j')
            ->leftJoin('j.JobeetCategory c')
            ->leftJoin('c.JobeetAffiliate a')
            ->where('a.id = ?', $this->getId());

        return Doctrine_Core::getTable('JobeetJob')
            ->addActiveJobsQuery($q)
            ->execute();
    }
}

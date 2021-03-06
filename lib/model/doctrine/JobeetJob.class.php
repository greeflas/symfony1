<?php

/**
 * JobeetJob
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Vladimir Kuprienko
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class JobeetJob extends BaseJobeetJob
{
    /**
     * Returns slug for company field.
     *
     * @return string
     */
    public function getCompanySlug()
    {
        return Jobeet::slugify($this->getCompany());
    }

    /**
     * Returns slug for position field.
     *
     * @return string
     */
    public function getPositionSlug()
    {
        return Jobeet::slugify($this->getPosition());
    }

    /**
     * Returns slug for location field.
     *
     * @return string
     */
    public function getLocationSlug()
    {
        return Jobeet::slugify($this->getLocation());
    }

    /**
     * Convert object to array.
     *
     * @param string $host
     * @return array
     */
    public function asArray($host)
    {
        return [
            'category'      => $this->getJobeetCategory()->getName(),
            'type'          => $this->getType(),
            'company'       => $this->getCompany(),
            'logo'          => $this->getLogo() ? 'http://' . $host . '/uploads/jobs/' . $this->getLogo() : null,
            'url'           => $this->getUrl(),
            'position'      => $this->getPosition(),
            'location'      => $this->getLocation(),
            'description'   => $this->getDescription(),
            'how_to_apply'  => $this->getHowToApply(),
            'expires_at'    => $this->getExpiresAt(),
        ];
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        $types = Doctrine_Core::getTable('JobeetJob')->getTypes();
        return $this->getType() ? $types[$this->getType()] : '';
    }

    /**
     * @return bool
     * @throws sfException
     */
    public function isExpired()
    {
        return $this->getDaysBeforeExpires() < 5;
    }

    /**
     * @return bool
     * @throws sfException
     */
    public function expiresSoon()
    {
        return $this->getDaysBeforeExpires() < 5;
    }

    /**
     * @return float
     * @throws sfException
     */
    public function getDaysBeforeExpires()
    {
        return ceil(($this->getDateTimeObject('expires_at')->format('U') - time()) / 86400);
    }

    /**
     * Activate job.
     */
    public function publish()
    {
        $this->setIsActivated(true);
        $this->save();
    }

    /**
     * Extend expires date.
     *
     * @param bool $force
     * @return bool
     * @throws sfException
     */
    public function extend($force = false)
    {
        if (!$force && !$this->expiresSoon()) {
            return false;
        }

        $this->setExpiresAt(date('Y-m-d', time() + 86400 * sfConfig::get('app_active_days')));

        $this->save();

        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function save(Doctrine_Connection $conn = null)
    {
        if ($this->isNew() && !$this->getExpiresAt()) {
            $now = $this->getCreatedAt()
                ? $this->getDateTimeObject('created_at')->format('U')
                : time();
            $this->setExpiresAt(date('Y-m-d h:i:s', $now + 86400 * sfConfig::get('app_active_days')));
        }

        if (!$this->getToken()) {
            $this->setToken(sha1($this->getEmail() . rand(11111, 99999)));
        }

        parent::save($conn);
    }
}

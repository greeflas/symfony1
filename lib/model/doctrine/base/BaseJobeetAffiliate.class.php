<?php

/**
 * BaseJobeetAffiliate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $url
 * @property string $email
 * @property string $token
 * @property boolean $is_active
 * @property Doctrine_Collection $JobeetCategories
 * @property Doctrine_Collection $JobeetCategoryAffiliate
 * 
 * @method string              get()                        Returns the current record's "url" value
 * @method string              get()                        Returns the current record's "email" value
 * @method string              get()                        Returns the current record's "token" value
 * @method boolean             get()                        Returns the current record's "is_active" value
 * @method Doctrine_Collection get()                        Returns the current record's "JobeetCategories" collection
 * @method Doctrine_Collection get()                        Returns the current record's "JobeetCategoryAffiliate" collection
 * @method JobeetAffiliate     set()                        Sets the current record's "url" value
 * @method JobeetAffiliate     set()                        Sets the current record's "email" value
 * @method JobeetAffiliate     set()                        Sets the current record's "token" value
 * @method JobeetAffiliate     set()                        Sets the current record's "is_active" value
 * @method JobeetAffiliate     set()                        Sets the current record's "JobeetCategories" collection
 * @method JobeetAffiliate     set()                        Sets the current record's "JobeetCategoryAffiliate" collection
 * 
 * @package    jobeet
 * @subpackage model
 * @author     Vladimir Kuprienko
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseJobeetAffiliate extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('jobeet_affiliate');
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 255,
             ));
        $this->hasColumn('token', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('JobeetCategory as JobeetCategories', array(
             'refClass' => 'JobeetCategoryAffiliate',
             'local' => 'affiliate_id',
             'foreign' => 'category_id'));

        $this->hasMany('JobeetCategoryAffiliate', array(
             'local' => 'id',
             'foreign' => 'affiliate_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}
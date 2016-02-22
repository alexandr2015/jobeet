<?php

class JobeetJobTable extends Doctrine_Table
{
    static public $types = [
        'full-time' => 'Full time',
        'part-time' => 'Part time',
        'freelance' => 'Freelance',
    ];

    public function getTypes()
    {
        return self::$types;
    }

    public function retrieveActiveJob(Doctrine_Query $q)
    {
        return $this->addActiveJobsQuery($q)->fetchOne();
    }

    public function getActiveJobs(Doctrine_Query $q = null)
    {
        return $this->addActiveJobsQuery($q)->execute();
    }

    public function countActiveJobs(Doctrine_Query $q = null)
    {
        return $this->addActiveJobsQuery($q)->count();
    }

    public function addActiveJobsQuery(Doctrine_Query $q = null)
    {
        if (is_null($q)){
            $q = Doctrine_Query::create()
                ->from('JobeetJob j');
        }

        $alias = $q->getRootAlias();

        $q->andWhere($alias . '.expires_at > ?', date('Y-m-d h:i:s'))
            ->addOrderBy($alias . '.expires_at DESC')
            ->andWhere($alias . '.is_activated = ?', 1);

        return $q;
    }

    public function cleanup($days)
    {
        return $this->createQuery('a')
            ->delete()
            ->andWhere('a.is_activated = ?', 0)
            ->andWhere('a.created_at < ?', date('Y-m-d', time() - 86400 * $days))
            ->execute();
    }

    public function retrieveBackendJobList(Doctrine_Query $q)
    {
        $rootAlias = $q->getRootAlias();

        return $q->leftJoin($rootAlias, '.JobeetCategory c');
    }

    public function getLatestPost()
    {
        $query = Doctrine_Query::create()
            ->from('JobeetJob j');
        $this->addActiveJobsQuery($query);

        return $query->fetchOne();
    }

    public function getForToken(array $parameters)
    {
        $affiliate = Doctrine_Core::getTable('JobeetAffiliate') ->findOneByToken($parameters['token']);
        if (!$affiliate || !$affiliate->getIsActive())
        {
            throw new sfError404Exception(sprintf('Affiliate with token "%s" does not exist or is not activated.', $parameters['token']));
        }

        return $affiliate->getActiveJobs();
    }

    static public function getLuceneIndex()
    {
        ProjectConfiguration::registerZend();

        if (file_exists($index = self::getLuceneIndexFile())) {
            return Zend_Search_Lucene::open($index);
        } else {
            return Zend_Search_Lucene::create($index);
        }
    }

    static public function getLuceneIndexFile()
    {
        return sfConfig::get('sf_data_dir') . '/job.' . sfConfig::get('sf_environment') .'.index';
    }

    public function getForLuceneQuery($query)
    {
        $hits = self::getLuceneIndex()->find($query);

        $pks = [];
        foreach ($hits as $hit) {
            $pks[] = $hit->pk;
        }

        if (empty($pks)) {
            return [];
        }

        $q = $this->createQuery('j')
            ->whereIn('j.id', $pks)
            ->limit(20);

        $q = $this->addActiveJobsQuery($q);

        return $q->execute();
    }
}

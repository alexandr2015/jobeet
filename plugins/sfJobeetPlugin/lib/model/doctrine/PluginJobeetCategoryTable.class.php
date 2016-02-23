<?php

abstract class PluginJobeetCategoryTable extends Doctrine_Table
{
    public function getWithJobs()
    {
        return $this->createQuery('c')
            ->leftJoin('c.JobeetJobs j')
            ->where('j.expires_at > ?', date('Y-m-d h:i:s'))
            ->andWhere('j.is_activated = ?', 1)
            ->execute();
    }
}

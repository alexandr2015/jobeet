<?php

abstract class PluginJobeetAffiliateTable extends Doctrine_Table
{
    public function countToBeActivated()
    {
        return $this->createQuery('a')
            ->where('a.is_active = ?', 0)
            ->count();
    }
}

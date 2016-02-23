<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 23.02.16
 * Time: 9:43
 */
class sfJobeetPluginConfiguration extends sfPluginConfiguration
{
    public function initialize()
    {
        $this->dispatcher->connect('user.method_not_found', [
            'JobeetUser', 'methodNotFound'
        ]);
    }
}
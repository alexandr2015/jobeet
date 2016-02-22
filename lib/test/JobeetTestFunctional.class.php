<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.02.16
 * Time: 11:56
 */
class JobeetTestFunctional extends sfTestFunctional
{
    public function loadData()
    {
        Doctrine_Core::loadData(sfConfig::get('sf_test_dir').'/fixtures');

        return $this;
    }

    public function createJob($values = [], $publish = false)
    {
        $this->get('/job/new')
            ->click('Preview your job', [
                'job' => array_merge([
                    'company'      => 'Sensio Labs',
                    'url'          => 'http://www.sensio.com/',
                    'position'     => 'Developer',
                    'location'     => 'Atlanta, USA',
                    'description'  => 'You will work with symfony to develop websites for our customers.',
                    'how_to_apply' => 'Send me an email',
                    'email'        => 'for.a.job@example.com',
                    'is_public'    => false,
                ], $values)
            ])->followRedirect();

        if ($publish) {
            $this->click('Publish',[], [
                'method' => 'put',
                '_with_csrf' => true]
            )
            ->followRedirect();
        }

        return $this;
    }

    public function getJobByPosition($position)
    {
        $q = Doctrine_Query::create()
            ->from('JobeetJob j')
            ->where('j.position = ?', $position);

        return $q->fetchOne();
    }
}
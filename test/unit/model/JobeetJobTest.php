<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 19.02.16
 * Time: 11:29
 */
include(__DIR__.'/../../bootstrap/Doctrine.php');

$test = new lime_test(3);
$test->comment('->getCompanySlug()');
$job = Doctrine::getTable('JobeetJob')->createQuery()->fetchOne();
$test->is($job->getCompanySlug(), Jobeet::slugify($job->getCompany()), '->getCompanySlug() return the slug for the company');
$test->comment('->save()');
$job = create_job();
$job->save();
$expiresAt = date('Y-m-d', time() + 86400 * sfConfig::get('app_active_days'));
$test->is($job->getDateTimeObject('expires_at')->format('Y-m-d'), $expiresAt, '->save() updates expires_at if not set');

$job = create_job(array('expires_at' => '2016-08-08'));
$job->save();
$test->is($job->getDateTimeObject('expires_at')->format('Y-m-d'), '2016-08-08', '->save() does not update expires_at if set');

function create_job($defaults = array())
{
    static $category = null;

    if (is_null($category))
    {
        $category = Doctrine_Core::getTable('JobeetCategory')
            ->createQuery()
            ->limit(1)
            ->fetchOne();
    }

    $job = new JobeetJob();
    $job->fromArray(array_merge(array(
        'category_id'  => $category->getId(),
        'company'      => 'Sensio Labs',
        'position'     => 'Senior Tester',
        'location'     => 'Paris, France',
        'description'  => 'Testing is fun',
        'how_to_apply' => 'Send e-Mail',
        'email'        => 'job@example.com',
        'token'        => rand(1111, 9999),
        'is_activated' => true,
    ), $defaults));

    return $job;
}
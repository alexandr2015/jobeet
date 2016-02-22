<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new JobeetTestFunctional(new sfBrowser());
$browser->setTester('doctrine', 'sfTesterDoctrine');
$browser->loadData();

$browser->info('3 - Post a Job page')
    ->info('3.1 - submit a job')
    ->get('/job/new')
    ->with('request')
        ->begin()
            ->isParameter('module', 'job')
            ->isParameter('action', 'new')
        ->end()
    ->click('Preview your job', [
        'job' => [
            'company'      => 'Sensio Labs',
            'url'          => 'http://www.sensio.com/',
            'logo'         => sfConfig::get('sf_upload_dir').'/jobs/sensio-labs.gif',
            'position'     => 'Developer',
            'location'     => 'Atlanta, USA',
            'email'        => 'for.a.job',
            'is_public'    => false,
        ]
    ])
    ->with('request')
        ->begin()
            ->isParameter('module', 'job')
            ->isParameter('action', 'create')
        ->end()
    ->with('form')
        ->begin()
            ->hasError(3)
            ->isError('description', 'required')
            ->isError('how_to_apply', 'required')
            ->isError('email', 'invalid')
        ->end()
//    ->info(' 3.2 - On the preview page, oyu can publish the job')
//    ->createJob(['position' => 'F001'])
//    ->click('Publish', [], [
//        'method' => 'put',
//        '_with_csrf' => true,
//    ])
//    ->with('doctrine')
//        ->begin()
//            ->check('JobeetJob', [
//                'position' => 'F001',
//                'is_activated' => true,
//            ])
//        ->end()
    ->info('  3.3 - On the preview page, you can publish the job')
    ->createJob(['position' => 'FOO2'])
    ->click('Delete', [], [
        'method' => 'delete',
        '_with_csrf' => true
    ])
    ->with('doctrine')
    ->begin()
        ->check('JobeetJob', [
            'position'     => 'FOO2',
        ], false)
    ->end()
;
$browser->get('/job/new')
    ->click('Preview your job', array('job' => array(
        'token' => 'fake_token',
    )))
    ->with('form')
    ->begin()
        ->hasErrors(7)
        ->hasGlobalError('extra_fields')
    ->end()
;
//$browser->info('4 - user job history')
//    ->loadData()
//    ->restart()
//    ->info('    4.1 - When the user access a job, it is added to its history')
//    ->get('/')
//    ->click('Web Developer', [], [
//        'position', 1,
//    ])
//    ->get('/')
//    ->with('user')
//    ->begin()
//        ->isAttribute('job_history', [
//            $browser->getMostRecentProgrammingJob()->getId()
//        ])
//    ->end()
//    ->info('    4.2 - A job is not added twice in the history')
//    ->click('Web Developer', [] , [
//        'position' => 1,
//    ])
//    ->get('/')
//    ->with('user')
//    ->begin()
//        ->isAttribute('job_history', array($browser->getMostRecentProgrammingJob()->getId()))
//    ->end()
//;
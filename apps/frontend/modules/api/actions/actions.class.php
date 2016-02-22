<?php

/**
 * api actions.
 *
 * @package    jobeet
 * @subpackage api
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class apiActions extends sfActions
{
    public function executeList(sfWebRequest $request)
    {
        $this->jobs = [];
        foreach($this->getRoute()->getObjects() as $job) {
            $this->jobs[$this->generateUrl('job_show_user', $job, true)] = $job->asArray($request->getHost());
        }

        $this->getResponse()->setContentType('text/json');

        return $this->renderText(json_encode(
            $this->jobs
        ));
    }
}

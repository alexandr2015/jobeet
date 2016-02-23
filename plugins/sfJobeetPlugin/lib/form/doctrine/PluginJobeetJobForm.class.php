<?php

/**
 * JobeetJob form.
 *
 * @package    jobeet
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginJobeetJobForm extends BaseJobeetJobForm
{
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    $this->removeFields();

    $this->validatorSchema['email'] = new sfValidatorAnd([
      $this->validatorSchema['email'],
      new sfValidatorEmail,
    ]);

    $this->widgetSchema['type'] = new sfWidgetFormChoice([
      'choices' => array_keys(Doctrine_Core::getTable('JobeetJob')->getTypes()),
      'expanded' => true,
    ]);

    $this->validatorSchema['logo'] = new sfValidatorFile([
        'required'   => false,
        'path'       => sfConfig::get('sf_upload_dir').'/jobs',
        'mime_types' => 'web_images',
    ]);

    $this->widgetSchema->setLabels([
        'category_id'    => 'Category',
        'is_public'      => 'Public?',
        'how_to_apply'   => 'How to apply?',
    ]);

    $this->widgetSchema->setHelp('is_public', 'Whether the job can also be published on affiliate websites or not.');
    $this->widgetSchema->setNameFormat('job[%s]');
  }

    public function removeFields()
    {
        unset(
            $this['created_at'], $this['updated_at'],
            $this['expires_at'], $this['is_activated'], $this['token']
        );
    }
}

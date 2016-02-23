<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 22.02.16
 * Time: 11:33
 */

abstract class PluginBackendJobeetJobForm extends JobeetJobForm
{
    public function configure()
    {
        parent::configure();

        $this->widgetSchema['logo'] = new sfWidgetFormInputFileEditable([
            'label' => 'Company logo',
            'file_src' => '/uploads/jobs/' . $this->getObject()->getLogo(),
            'is_image' => true,
            'edit_mode' => !$this->isNew(),
            'template' => '<div>%file%<br />%input%<br />%delete% %delete_label%</div>',
        ]);

        $this->validatorSchema['logo_delete'] = new sfValidatorPass();
    }

    public function removeFields()
    {
        unset($this['created_at'], $this['updated_at'], $this['token']);
    }
}
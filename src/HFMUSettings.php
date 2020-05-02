<?php
use HTML_Forms\Form;

class HFMUSettings{

    /**
     * @var HFMUForm[]
     */
    protected $forms;

    public function __construct($forms){

        $this->forms = $forms;
    }


    /**
     * @since $VID:$
     * @return HFMUForm[]
     */
    public function forms(){
        return $this->forms;
    }


    /**
     * @since $VID:$
     * @param Form $form
     * @return HFMUForm
     */
    public function getFormData(Form $form)
    {
        foreach($this->forms() as $form_settings){
            if( $form_settings->getSlug() === $form->slug){
                return $form_settings;
            }
        }
        return null;
    }


    /**
     * @since $VID:$
     * @param Form $form
     * @return string
     */
    public function getQuestionsHTML(Form $form)
    {
        $form_settings = $this->getFormData($form);
        $html = '';
        if( ! $form_settings){
            return $html;
        }
        return $form_settings->getHtml();
    }
}
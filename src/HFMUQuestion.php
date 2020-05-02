<?php
class HFMUQuestion{
    protected $input_name;
    protected $display_text;

    /**
     * @var string options: text (default), textearea, radio-other, checkbox-other, dropdown-other,
     */
    protected $type;
    protected $options;

    /**
     * Indicates if this field should have an "other" option
     * @var bool
     */
    private $other;


    /**
     * HFMUQuestion constructor.
     *
     * @param $input_name
     * @param $display_text
     * @param $type
     * @param $options
     */
    public function __construct($input_name, $display_text, $type = 'text', $options = [], $other = false)
    {
        $this->input_name = $input_name;
        $this->type = $type;
        $this->options = $options;
        $this->display_text = $display_text;
        $this->other = $other;
    }


    /**
     * @return HFMUQuestionOption[]
     */
    public function getOptions()
    {
        return $this->options;
    }


    /**
     * @return mixed
     */
    public function getInputName()
    {
        return $this->input_name;
    }


    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * @return mixed
     */
    public function getDisplayText()
    {
        return $this->display_text;
    }

    public function getInputHtml(HFMUForm $form)
    {
        $label_open = '<label>' . $this->getDisplayText();
        $label_close = '</label>';
        $html = '';
        switch($this->getType()){
            case 'checkbox':
                $html .= $label_open . $label_close;
                foreach($this->getOptions() as $option){
                    $html .= '<label><input type="checkbox" name="' . $this->getFullInputName($form). '[]" value="' . $option->getValue() . '"> ' . $option->getText() . '</label>';
                }
                break;
            case 'radio':
                $html .= $label_open . $label_close;
                foreach($this->getOptions() as $option){
                    $html .= '<label><input type="radio" name="' . $this->getFullInputName($form) . '" value="' . $option->getValue(). '"> ' . $option->getText() . '</label>';
                }
                break;
            case 'textarea':
                $html .= $label_open . '<textarea name="' . $this->getFullInputName($form) . '"></textarea>' . $label_close;
                break;
            case 'text':
            default:
            $html .= $label_open . '<input type="text" name="' .  $this->getFullInputName($form) . '">' . $label_close;
        }
        return $html . '';
    }


    /**
     * Returns whether or not there should be an "other" option for this question.
     * @since $VID:$
     * @return bool
     */
    public function hasOther(){
        return $this->other;
    }

    public function getOtherInputHtml(HFMUForm $form)
    {
        return '<label>Other<input type="text" name="' . $this->getFullInputName($form) . '-other"></label>';
    }
    public function getFullInputName(HFMUForm $form){
        return $this->getInputName() . '_' . $form->getSlug();
    }
}
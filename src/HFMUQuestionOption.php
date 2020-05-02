<?php
class HFMUQuestionOption{
    protected $value;
    protected $text;
    protected $tag;


    /**
     * HFMUQuestionOption constructor.
     *
     * @param      $value
     * @param      $text
     * @param bool|string $tag true to automatically calculate the MailChimp tag from the value, false for no tag, a string to specify the tag name
     */
    public function __construct($value, $text, $tag = true)
    {
        $this->value = $value;
        $this->text = $text;
        $this->tag = $tag;
    }


    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }


    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
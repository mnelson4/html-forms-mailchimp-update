<?php
class HFMUForm{
    private $slug;
    protected $questions;

    /**
     * @var boolean require the user to have filled out their email or redirect them to the signup page
     */
    private $require_email;


    /**
     * HFMUForm constructor.
     *
     * @param $slug
     * @param $questions
     */
    public function __construct($slug, $require_email, $questions)
    {

        $this->slug = $slug;
        $this->questions = $questions;
        $this->require_email = $require_email;
    }

    /**
     * @since $VID:$
     * @return HFMUQuestion[]
     */
    public function questions(){
        return $this->questions;
    }


    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function getHtml(){
        $html = '';
        foreach($this->questions() as $question){
            $html .= $question->getInputHtml($this);
            if($question->hasOther()){
                $html .= $question->getOtherInputHtml($this);
            }
            $html .= '<br>';


        }
        return $html;
    }


    /**
     * @return bool
     */
    public function requiresEmail()
    {
        return $this->require_email;
    }
}
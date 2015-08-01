<?php

class MustView extends Mustache_Engine {

    public $data; //Session data

    public function __construct($options)
    {
        parent::__construct($options);
    }

    private function mergeData ($tplvars) {
        // Filling session template values
        $this->data['baseurl']= Config::get('URL');
        $this->data['user_logged_in']= (Session::get('user_logged_in') ? true : false);
        $this->data['user_level']= Session::get('user_account_type');
        $this->data['user_name']= Session::get('user_name');
        $this->data['user_id']= Session::get('user_id');
        $this->data['feedback_positive']= Session::get('feedback_positive');
        $this->data['feedback_negative']= Session::get('feedback_negative');
        $this->data['user_is_admin'] = Session::get('user_account_type') == '2' ? true : false;
        
        // Merge with controller data
        $data = is_array($tplvars) ? array_merge($this->data,$tplvars) : $this->data;
        return $data;
    }

    /**
     * Renders view with feedback, header and footer
     */
    public function renderAll($filename,$tplvars=false)
    {
        echo $this->render('_templates/header',$tplvars);
        echo $this->render($filename,$tplvars);
        echo $this->render('_templates/footer',$tplvars);

        // delete feedback messages (as they are not needed anymore and we want to avoid to show them twice)
        Session::clearFeedback();
    }

    public function render($filename,$tplvars=false,$nodisplay=false)
    {
        $data = $this->mergeData($tplvars);
        $tpl=parent::render($filename,$data);
        if($nodisplay) {
            return $tpl;
        }else{
            echo $tpl;
        }
    }
}

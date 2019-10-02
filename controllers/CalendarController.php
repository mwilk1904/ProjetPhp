<?php
class CalendarController{

    private $_db;

    public function __construct($db) {
      $this->_db = $db;
    }

	public function run(){
        if (empty($_SESSION['authentificate'])) {
                header("Location: index.php?action=home");
                die();
        }
        require 'lib/iCalendar/CalendarEvent.class.php';
        require 'lib/iCalendar/Calendar.class.php';

        $array_event = array();
        if(!empty($_GET['training_id'])){
            $training = $this->_db->select_training($_GET['training_id']);
            $array_training = $this->_db->select_training_days($_GET['training_id']);
            foreach ($array_training as $i => $day) {
                if(trim($day->html_activity()) != ""){
                    $temp_date_start = str_replace("/","-",$day->html_date());
                    $temp_date_start = $temp_date_start." 12:00:00";
                    $temp_date_start = date('Y-m-d H:i:s', strtotime($temp_date_start));
                    $temp_date_start = new DateTime($temp_date_start);

                    $temp_date_end = str_replace("/","-",$day->html_date());
                    $temp_date_end = $temp_date_end." 14:00:00";
                    $temp_date_end = date('Y-m-d H:i:s', strtotime($temp_date_end));
                    $temp_date_end = new DateTime($temp_date_end);

                    $array_event[] =  CalendarEvent::createCalendarEvent(
                    $temp_date_start,
                    $temp_date_end,
                    $day->activity(),
                    "Entrainement",
                    "");
                }
            }


            $calendar = Calendar::createCalendar($array_event,$training->html_descriptive(),"Coach Sami");
            $calendar->generateDownload();
            $redirect = "Location: index.php?action=training&event_id=".$_GET['training_id'];
            header($redirect);
            die();
        }

        header("Location: index.php?action=home");
        die();



    }
}
?>

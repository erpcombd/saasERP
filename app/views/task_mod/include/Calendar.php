<?php
class Calendar {

    private $userID;
    private $active_year, $active_month, $active_day;
    private $events = [];
    private $weeklyOffdays = [];
    private $partialWeeklyOffdays_day = [];
    private $partialWeeklyOffdays_week = [];
    private $myMonthlyTasks = [''];
    private $myMonthlyTasks_date = [''];


    public function __construct($date = null) {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : date('Y');
        $this->active_month = $date != null ? date('m', strtotime($date)) : date('m');
        $this->active_day = $date != null ? date('d', strtotime($date)) : date('d');
    }
    
    public function setUser($user){
        $this->userID = $user;
    }
    
    public function find_a_field($table, $data, $condition){
        
        
require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
        
        return find_a_field($table, $data, $condition);
    }

    public function add_weekly_offdays($offday){
        array_push($this->weeklyOffdays, $offday);
    }
    
    public function add_partialWeekly_offdays($offday){

            $FindPartial = explode("#", $offday);
            $partialWeek = $FindPartial[0];
            $partialDayName = $FindPartial[1];
            
            array_push($this->partialWeeklyOffdays_week, $partialWeek);
            array_push($this->partialWeeklyOffdays_day, $partialDayName);

    }

    public function add_event($txt, $date, $days = 1, $color = '') {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$txt, $date, $days, $color];
    }
    
    public function setMyMonthlyTasks($task){
        array_push($this->myMonthlyTasks, $task);
    }
    
    public function setMyMonthlyTasks_date($date){
        array_push($this->myMonthlyTasks_date, $date);
    }
        
    public function getMyMonthlyTasks(){
        return $this->myMonthlyTasks;
    }
    
    public function getMyMonthlyDates(){
        return $this->myMonthlyTasks_date;
    }

    public function __toString() {
        $num_days = date('t', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_day . '-' . $this->active_month . '-' . $this->active_year)));
        $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
        $first_day_of_week = array_search(date('D', strtotime($this->active_year . '-' . $this->active_month . '-1')), $days);
        $html = '<div class="calendar">';
        $html .= '<div class="header">';
        $html .= '<div class="month-year">';
        $html .= date('F Y', strtotime($this->active_year . '-' . $this->active_month . '-' . $this->active_day));
        $html .= '</div>';
        $html .= '</div>';
        $html .= '<div class="days">';
        
        foreach ($days as $day) { 
            if(in_array($day, $this->weeklyOffdays)){ 
                $html .= '
                    <div class="day_name" style="background:#ce5151;border-right:1px solid #cf6b51;">
                        ' . $day . '
                    </div>
                ';
            }else{
                $html .= '
                    <div class="day_name">
                        ' . $day . '
                    </div>
                ';
            }
        }
        
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month-$i+1) . '
                </div>
            ';
        }
        
        $wk_cnt = 1; $cnt = 1;
        for ($i = 1; $i <= $num_days; $i++) {
            
            if($cnt==8){
                $wk_cnt++;
                $cnt = 1;
            }else{
                $cnt++;
            }
            
            $selected = '';
            if ($i == $this->active_day) {
                $selected = ' selected';
            }
            
                if(strlen($i)==1){
                    $tkDay = '0'.$i;
                }else{
                    $tkDay = $i;
                }
            
            $specificDate = $this->active_year.'-'.$this->active_month.'-'.$tkDay;
            $html .= '<div onclick="imAnEvent('."'".$specificDate."'".');" class="day_num' . $selected; 
            
            $thisDay = date('D',strtotime(date('Y-m-'.$i)));
            if(in_array($thisDay, $this->weeklyOffdays)){
                $html .= '" style="background:#e7111126;">';
            }else{
                if(in_array($wk_cnt, $this->partialWeeklyOffdays_week)){
                    if(in_array(array_search($thisDay, $days), $this->partialWeeklyOffdays_day)){
                        $html .= '" style="background:#e7111126;">';
                    }else{
                        $html .= '">';
                    }
                }else{
                    $html .= '">';
                }
                
            }
            
            $html .= '<div style="width:100%;"> <span>' . $i . '</span>';

            $taskCnt = find_a_field('crm_lead_activity', 'count(*)', 'date = "'.$specificDate.'" AND entry_by = "'.$this->userID.'"');

            if($taskCnt > 0){
                $html .= '<span title="You Have ';
                
                if($taskCnt > 0){$html .= $taskCnt.' Task(s) '; $newTask = find_a_field('crm_lead_activity', 'concat(activity_type," - ",call_to)', 'date = "'.$specificDate.'" AND entry_by = "'.$this->userID.'"');}else{$newTask = '';}
                
                $html .= 'Pending on this date" style="float:right;font-size:8px;background:#337a6d;height:20px;overflow:hidden!important;width:20px;color:#edf9f8;text-align:center;display:block;border-radius:50%;margin-top:3px;">'.($taskCnt).'</span> ';
            

                $this->setMyMonthlyTasks($newTask);
                $this->setMyMonthlyTasks_date($specificDate);
                
            }
            
            foreach ($this->events as $event) {
                for ($d = 0; $d <= ($event[2]-1); $d++) {
                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[1]))) {
            
                        $html .= '<div class="event' . $event[3] . '">';
                        $html .= $event[0];
                        $html .= '</div>';
                        
                    }
                }
            }
            
            $html .= '</div> </div>';
        }
        
        for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
            $html .= '
                <div class="day_num ignore">
                    ' . $i . '
                </div>
            ';
        }
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}
?>
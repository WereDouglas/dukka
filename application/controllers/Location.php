<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller {

    function __construct() {

        parent::__construct();
        // error_reporting(E_PARSE);
        $this->load->model('Md');
        $this->load->library('session');
        $this->load->library('encrypt');
        date_default_timezone_set("Africa/Nairobi");
        $this->load->library('helper');
    }

    public function index() {

        $this->load->view('home');
    }

    public function map() {

        $data['locations'] = array();

        $all = array();
        $query1 = $this->Md->query("select * from user");

        //var_dump($query1);
        foreach ($query1 as $v) {
            $resv = new stdClass();
            $resv->image = $v->image;
            $resv->username = $v->username;
            $query2 = $this->Md->query("select * from location where username ='" . $v->username . "' order by id desc LIMIT 1 ");
            $results = $query2;
            $resv->lat = "";
            $resv->lng = "";
            $resv->created = "";
            foreach ($results as $res) {
                $resv->lat = $res->lat;
                $resv->lng = $res->lng;
                $resv->created = $res->created;
            }
            array_push($all, $resv);
        }
        $data['locations'] = $all;

        $this->load->view('view-all', $data);
    }

    public function save() {

        $this->load->helper(array('form', 'url'));

        $username = $this->input->post('username');
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $session = $this->input->post('session');


       // $username = "Douglas";
        //$lat = "0.2207913";
        //$lng = "32.1943488";
        //$session = "douglas04ut90ru1";


        $dist = 0;
        $distance = 0;
        $distancem = 0;

        $created = date('Y-m-d H:i:s');
        if ($username != "") {
            $results = $this->Md->query("select * from location where username ='" . $username . "' and session='" . $session . "'");

            if (!$results) {

                $locate = array('username' => $username, 'distance' => "0", 'session' => $session, 'lat' => $lat, 'lng' => $lng, 'created' => $created);
                $this->Md->save($locate, 'location');
                $b["info"] = "starting session........";
                echo json_encode($b);
                return;
            }
            $resulte = $this->Md->query("select * from location where username ='" . $username . "' and session='" . $session . "' ORDER BY id DESC LIMIT 0, 1 ");
            // $b["posted"] =  $results;             

            foreach ($resulte as $res) {


                $lat2 = $res->lat;
                $lng2 = $res->lng;
            }
            //  echo $b["distance"] = $this->distance(0.3419071 , 32.5944203 , 0.3419071 , 32.5944204 , "K") . "Km";
            if ($lat != NULL && $lng != NULL) {

                $dist = $this->distance($lat2, $lng2, $lat, $lng, "K");
                $distance = (int)($dist * 1000);
                $distancem = (int)number_format($distance, 1);
                $b["info"] = $distancem . "metres " ;
                
            }
            /// echo json_encode($b);                 
             if ((int) $distancem < 1) {
                $b["info"] =(int)$distancem."m";
                 $b["total"] = "0";
                $b["state"] ="paused";
                echo json_encode($b);
                return;
               } else {
                $locate = array('username' => $username, 'distance' => (int) $distancem, 'session' => $session, 'lat' => $lat, 'lng' => $lng, 'created' => $created);
                $this->Md->save($locate, 'location');
                $totals = $this->Md->query("select sum(distance) as totals from location where session ='" . $session . "'");

                foreach ($totals as $res) {
                    $totale = $res->totals;
                }              
                $b["info"] = "new:".((int) $distancem/1000 ).'Km ';
                 $b["total"] =  'TOTAL: '.($totale/1000).'Km';
                 $b["state"] ="run";
                echo json_encode($b);
                $lat = 0;
                $lng = 0;
            }
        } else {

            $b["info"] = "invalid user";
            echo json_encode($b);
        }
    }

    public function session() {

        $this->load->helper(array('form', 'url'));
        $this->load->helper('string');

        $username = $this->input->post('username');
        $status = $this->input->post('status');
        if ($status == "start") {
            $sid = random_string('alnum', 16);
            $b["session"] = $sid;
            echo json_encode($b);
            return;
        }
        if ($status == "stop") {            
            $b["session"] = "";
            echo json_encode($b);
            return;
        }
    }

    public function dateDiff($start, $end) {

        $mydate = $end;
        $theDiff = "";
        //echo $mydate;//2014-06-06 21:35:55
        $datetime1 = date_create($start);
        $datetime2 = date_create($mydate);
        $interval = date_diff($datetime1, $datetime2);
        //echo $interval->format('%s Seconds %i Minutes %h Hours %d days %m Months %y Year    Ago')."<br>";
        $min = $interval->format('%i');
        $sec = $interval->format('%s');
        $hour = $interval->format('%h');
        $mon = $interval->format('%m');
        $day = $interval->format('%d');
        $year = $interval->format('%y');
        if ($interval->format('%i%h%d%m%y') == "00000") {
            //echo $interval->format('%i%h%d%m%y')."<br>";
            return $sec . " Seconds";
        } else if ($interval->format('%h%d%m%y') == "0000") {
            return $min . " Minutes";
        } else if ($interval->format('%d%m%y') == "000") {
            return $hour . " Hours";
        } else if ($interval->format('%m%y') == "00") {
            return $day . " Days";
        } else if ($interval->format('%y') == "0") {
            return $mon . " Months";
        } else {
            return $year . " Years";
        }
    }

    /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
    /* ::                                                                         : */
    /* ::  This routine calculates the distance between two points (given the     : */
    /* ::  latitude/longitude of those points). It is being used to calculate     : */
    /* ::  the distance between two locations using GeoDataSource(TM) Products    : */
    /* ::                                                                         : */
    /* ::  Definitions:                                                           : */
    /* ::    South latitudes are negative, east longitudes are positive           : */
    /* ::                                                                         : */
    /* ::  Passed to function:                                                    : */
    /* ::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  : */
    /* ::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  : */
    /* ::    unit = the unit you desire for results                               : */
    /* ::           where: 'M' is statute miles                                   : */
    /* ::                  'K' is kilometers (default)                            : */
    /* ::                  'N' is nautical miles                                  : */
    /* ::  Worldwide cities and other features databases with latitude longitude  : */
    /* ::  are available at http://www.geodatasource.com                          : */
    /* ::                                                                         : */
    /* ::  For enquiries, please contact sales@geodatasource.com                  : */
    /* ::                                                                         : */
    /* ::  Official Web site: http://www.geodatasource.com                        : */
    /* ::                                                                         : */
    /* ::         GeoDataSource.com (C) All Rights Reserved 2014                  : */
    /* ::                                                                         : */
    /* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

    public function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "M") . " Miles<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "K") . " Kilometers<br>";
//echo distance(32.9697, -96.80322, 29.46786, -98.53506, "N") . " Nautical Miles<br>";

    public function delete() {

        $session = $this->uri->segment(3);
         $username = $this->uri->segment(4);
        $query = $this->Md->delete_query("Delete from location where session ='".$session."'");
       
            redirect('/user/location/'.$username, 'refresh');
        
    }
    public function deletemobile() {

        $session = $this->uri->segment(3);
         $username = $this->uri->segment(4);
        $query = $this->Md->delete_query("Delete from location where session ='".$session."'");
       
            redirect('/user/mobile/'.$username, 'refresh');
        
    }

    public function check($metar) {
        $this->load->helper(array('form', 'url'));

        $metar = ($metar == "") ? $this->input->post('name') : $metar;
        //check($value,$field,$table)
        $get_result = $this->Md->check($metar, 'name', 'metar');

        if (!$get_result)
            echo '<span style="color:#f00"> name already in use. </span>';
        else
            echo '<span style="color:#0c0"> name not in use</span>';
    }

    public function check_email() {
        $this->load->helper(array('form', 'url'));

        $email = $this->input->post('email');
        //check($value,$field,$table)
        $get_result = $this->Md->check($email, 'email', 'metar');

        if (!$get_result)
            echo '<span style="color:#f00">email already in use. </span>';
        else
            echo '<span style="color:#0c0">email not in use</span>';
    }

}

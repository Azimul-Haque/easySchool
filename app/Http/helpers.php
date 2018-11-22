<?php 

function bangla($str){
      $en = array(1,2,3,4,5,6,7,8,9,0);
      $bn = array('১','২','৩','৪','৫','৬','৭','৮','৯','০');
      $str = str_replace($en, $bn, $str);
      $en = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
      $en_short = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
      $bn = array( 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর' );
      $str = str_replace( $en, $bn, $str );
      $str = str_replace( $en_short, $bn, $str );
      $en = array('Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday');
      $en_short = array('Sat','Sun','Mon','Tue','Wed','Thu','Fri');
      $bn_short = array('শনি', 'রবি','সোম','মঙ্গল','বুধ','বৃহঃ','শুক্র');
      $bn = array('শনিবার','রবিবার','সোমবার','মঙ্গলবার','বুধবার','বৃহস্পতিবার','শুক্রবার');
      $str = str_replace( $en, $bn, $str );
      $str = str_replace( $en_short, $bn_short, $str );
      $en = array( 'am', 'pm' );
      $bn = array( 'পূর্বাহ্ন', 'অপরাহ্ন' );
      $str = str_replace( $en, $bn, $str );
      return $str;
}

function bangla_class($str){
      $en = array(1,2,3,4,5,6,7,8,9,10);
      $bn = array('প্রথম','দ্বিতীয়','তৃতীয়','চতুর্থ','পঞ্চম','ষষ্ঠ','সপ্তম','অষ্টম','নবম','দশম');
      $str = str_replace($en, $bn, $str);
      return $str;
}
function bangla_section($section_type, $class, $section){
      if($section_type == 1) {
            $en = array(0, 1, 2, 3, 4, 5);
            $bn = array('', 'ক','খ','গ', 'ঘ', 'ঙ');
            $section = str_replace($en, $bn, $section);
      } elseif ($section_type == 2) {
            $en = array(0, 1, 2, 3, 4, 5);
            if($class < 9) {
                  $bn = array('', 'ক','খ','গ', 'ঘ', 'ঙ');
            } else {
                  $bn = array('', 'বিজ্ঞান','মানবিক','বাণিজ্য', 'ভোকেশনাল', 'কারিগরি');
            }
            
            $section = str_replace($en, $bn, $section);
      } else {
            //
      }
      return $section;
}

function english_section($section_type, $class, $section){
      if($section_type == 1) {
            $en = array(0, 1, 2, 3, 4, 5);
            $bn = array('', 'A','B','C', 'D', 'E');
            $section = str_replace($en, $bn, $section);
      } elseif ($section_type == 2) {
            $en = array(0, 1, 2, 3, 4, 5);
            if($class < 9) {
                  $bn = array('', 'A','B','C', 'D', 'E');
            } else {
                  $bn = array('', 'SCIENCE','ARTS','COMMERCE', 'VOCATIONAL', 'TECHNICAL');
            }
            
            $section = str_replace($en, $bn, $section);
      } else {
            //
      }
      return $section;
}
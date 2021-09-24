<?php

class FrontofficeSelect
{
    
     function get_reservation_detail($values,$conn)
    {
        $reservation_no =  $values['reservation_no'];
        
     $sql = "select reservation_master_new.*,customer_master.*, travel_agency.travel_agency_name , meal_plan.meal_plan_full
            from reservation_master_new 
            JOIN customer_master ON customer_master.customer_id = reservation_master_new.customer_id
            LEFT JOIN meal_plan ON meal_plan.meal_plan_id = reservation_master_new.meal_plan_id
            JOIN travel_agency ON travel_agency.travel_agency_id = reservation_master_new.travel_agency_id where reservation_no='".$reservation_no."'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row_details["master"] = $result->fetch_all(MYSQLI_ASSOC);
        	$sql_details = "select reservation_master_detail.* , room_category.room_category_id as room_category
        	from reservation_master_detail
        	JOIN room_category ON room_category.room_category_id = reservation_master_detail.room_category
        	where reservation_no='".$reservation_no."'";
        	$result_details = $conn->query($sql_details);
        	$row_details["details"] = $result_details->fetch_all(MYSQLI_ASSOC);
        	
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_details));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
    
    
    
    function get_list_reservation($values,$conn)
    {
        $status =  (!empty($values['status'])) ? $values['status']: 'A';
        
      $sql = "select reservation_master_new.*,customer_master.* ,travel_agency.travel_agency_name from reservation_master_new JOIN customer_master ON customer_master.customer_id = reservation_master_new.customer_id JOIN travel_agency ON travel_agency.travel_agency_id = reservation_master_new.travel_agency_id where reservation_master_new.`reservation_status` IN (".$status.")";
        //echo $sql;
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row_details = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_details));
        }else{
        $row = array();
        	echo json_encode(array("message"=>"No Results Found","status_code"=>400,"result"=>$row));
        }
    }
    
    function get_list_booking($values,$conn)
    {
        $status =  (!empty($values['status'])) ? $values['status']: 'A';
        
        $sql = "select booking_master_new.booking_no,booking_master_new.customer_id,booking_master_new.meal_count,booking_master_new.total_amount,customer_master.customer_id ,customer_master.customer_fname ,customer_master.customer_phone,travel_agency.travel_agency_name,SUM(advance_master.advance_amount) as advance from booking_master_new JOIN customer_master ON customer_master.customer_id = booking_master_new.customer_id JOIN travel_agency ON travel_agency.travel_agency_id = booking_master_new.travel_agency_id LEFT JOIN advance_master ON advance_master.process_no = booking_master_new.booking_no where booking_master_new.`booking_status`= '".$status."' GROUP BY booking_master_new.booking_no";

        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row_details = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_details));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"No Results Found","status_code"=>400,"result"=>$row));
        }
    }
    
    function get_adv_details($values,$conn)
    {
        $invoice_no =  (!empty($values['invoice_no'])) ? $values['invoice_no']: 'A';
        $sql = "select invoice_no,advance_type,payment_mode, from advance_master where invoice_no= '".$invoice_no."' ";
        $result = $conn->query($sql);
        $row_details = $result->fetch_all(MYSQLI_ASSOC);

        


        if ($result->num_rows > 0) {
        	$row_details = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_details));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
    
    function get_list_advance($values,$conn)
    {
    
    if($values['advance_no'])
    {
         $advance_no =  (!empty($values['advance_no'])) ? $values['advance_no']: '';
        $where = "  WHERE advance_master.process_no ='".$advance_no."'";
    }
    if($values['advance_master_id']){
        
         $advance_master_id =  (!empty($values['advance_master_id'])) ? $values['advance_master_id']: '';
         $where = " WHERE  advance_master.advance_master_id ='".$advance_master_id."'";
    }
        
     $sql = " SELECT advance_master.*,customer_master.*, payment_master.*
                FROM `advance_master` 
                JOIN customer_master ON customer_master.customer_id = advance_master.customer_id
                JOIN payment_master ON payment_master.payment_master_id = advance_master.payment_mode
                 ".$where;
       //echo $sql;
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row_details = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_details));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
    function get_list_advance_print($values,$conn)
    {
    
    if($values['advance_no'])
    {
         $advance_no =  (!empty($values['advance_no'])) ? $values['advance_no']: '';
        $where = "  WHERE advance_master.advance_no ='".$advance_no."'";
    }
    if($values['advance_master_id']){
        
         $advance_master_id =  (!empty($values['advance_master_id'])) ? $values['advance_master_id']: '';
         $where = " WHERE  advance_master.advance_master_id ='".$advance_master_id."'";
    }
        
     $sql = " SELECT advance_master.*,customer_master.*, payment_master.*
                FROM `advance_master` 
                JOIN customer_master ON customer_master.customer_id = advance_master.customer_id
                JOIN payment_master ON payment_master.payment_master_id = advance_master.payment_mode
                 ".$where;
       //echo $sql;
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row_details = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_details));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
    
    function get_list_advance_old($values,$conn)
    {
        $advance_master_id =  (!empty($values['advance_master_id'])) ? $values['advance_master_id']: '';
        
     $sql = " SELECT advance_master.*,customer_master.*, payment_master.*
                FROM `advance_master` 
                JOIN customer_master ON customer_master.customer_id = advance_master.customer_id
                JOIN payment_master ON payment_master.payment_master_id = advance_master.payment_mode
                WHERE  advance_master_id =".$advance_master_id."";
       // echo $sql;
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row_details = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_details));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
    
    
    function get_booking_detail($values,$conn)
    {
        $booking_no =  $values['booking_no'];
        
       $sql = "select booking_master_new.*,customer_master.*,travel_agency.travel_agency_name 
       from booking_master_new 
       JOIN customer_master ON customer_master.customer_id = booking_master_new.customer_id 
       JOIN travel_agency ON travel_agency.travel_agency_id = booking_master_new.travel_agency_id
       where booking_master_new.booking_no='".$booking_no."'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row_details["master"] = $result->fetch_all(MYSQLI_ASSOC);
        	$sql_details = "select * from booking_master_detail where booking_no='".$booking_no."'";
        	$result_details = $conn->query($sql_details);
        	$row_details["details"] = $result_details->fetch_all(MYSQLI_ASSOC);
        	
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_details));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
    function get_booking_detail_invoice_old($values,$conn)
    {
        $invoice_no =  $values['invoice_no'];

        $sql_invoice ="SELECT GROUP_CONCAT(room_no) as room_no,booking_no FROM `booking_master_detail` WHERE invoice_no= '".$invoice_no."'";
        $result = $conn->query($sql_invoice);
        $row_details = $result->fetch_all(MYSQLI_ASSOC);
        
        if($row_details[0]['room_no']){
            $room_no = $row_details[0]['room_no'];
            $booking_no = $row_details[0]['booking_no'];
        
        $sql_invoice_master ="SELECT invoice_master.* ,customer_master.*,payment_master.payment_mode,booking_master_new.reservation_no,booking_master_new.total_beforetax,booking_master_new.hotel_charges_for_extra_bed,booking_master_new.tax_cgst_percentage,booking_master_new.tax_sgst_percentage,booking_master_new.cgst,booking_master_new.sgst,booking_master_new.total_taxamount,booking_master_new.total_amount,booking_master_new.total_discount,booking_master_new.remarks,booking_master_new.advance,booking_master_new.travel_agency_id,booking_master_new.travel_agency_transaction_no,booking_master_new.meal_plan_id,booking_master_new.meal_price,booking_master_new.meal_count,booking_master_new.meal_total,booking_master_new.booking_documents,booking_master_new.booking_type,booking_master_new.booking_status,booking_master_new.created_by,travel_agency.travel_agency_name,meal_plan.meal_plan_full  
        FROM `invoice_master` 
        JOIN booking_master_new ON booking_master_new.booking_no = invoice_master.process_no
        JOIN travel_agency ON travel_agency.travel_agency_id = booking_master_new.travel_agency_id
        LEFT JOIN meal_plan ON meal_plan.meal_plan_id = booking_master_new.meal_plan_id
        JOIN customer_master ON customer_master.customer_id = invoice_master.customer_id
        JOIN payment_master ON payment_master.payment_master_id = invoice_master.payment_type
        WHERE invoice_no= '".$invoice_no."'";
        $result_invoice_master = $conn->query($sql_invoice_master);
        $row_invoice_master['master'] = $result_invoice_master->fetch_all(MYSQLI_ASSOC);
    
    
        $sql_invoice_details ="SELECT booking_master_detail.* ,room_category.room_category 
        FROM `booking_master_detail` 
        JOIN room_category ON room_category.room_category_id = booking_master_detail.room_category
        WHERE invoice_no= '".$invoice_no."'";
        $result_details = $conn->query($sql_invoice_details);
        $row_invoice_master['details'] = $result_details->fetch_all(MYSQLI_ASSOC);
        
        $sql_customer_ledger ="SELECT * from customer_ledger WHERE booking_no = '".$booking_no."' AND room_no IN (".$room_no.")";
        $result_ledger_details = $conn->query($sql_customer_ledger);
        $row_ledger_result = $result_ledger_details->fetch_all(MYSQLI_ASSOC);
        
        
        $total_ledger = array();
        foreach($row_ledger_result as $ledger_result)
        {
           if($ledger_result['income_type'] == 'Advance')
           {
               
             $sql_advance ="SELECT advance_master.*,customer_master.customer_fname 
              from advance_master 
              JOIN customer_master ON customer_master.customer_id = advance_master.customer_id
              WHERE advance_master.advance_no = '".$ledger_result['bill_no']."' AND advance_master.status =1";
              $result_advance_ledger = $conn->query($sql_advance);
              $total_ledger[] = $result_advance_ledger->fetch_all(MYSQLI_ASSOC);
              
           }
           if($ledger_result['income_type'] == 'Hotel')
           {
               
               $total_hotel[] = $ledger_result;
           }
           
        }
        
        $row_invoice_master['Advance'] = $total_ledger;
        $row_invoice_master['Hotel'] = $total_hotel;
        
        echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_invoice_master));

        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
     function get_booking_detail_invoice($values,$conn)
    {
        
        if($values['invoice_no'])
        {
            $req_invoice_no =  $values['invoice_no'];
            $sql_invoice ="SELECT GROUP_CONCAT(room_no) as room_no,booking_no FROM `booking_master_detail` WHERE invoice_no= '".$req_invoice_no."'";
            $result = $conn->query($sql_invoice);
            $row_details = $result->fetch_all(MYSQLI_ASSOC);
            
            
            if($row_details[0]['room_no']){
                $room_no = $row_details[0]['room_no'];
                $booking_no = $row_details[0]['booking_no'];
            
            $sql_invoice_master ="SELECT customer_master.*,booking_master_new.reservation_no,booking_master_new.total_beforetax,booking_master_new.hotel_charges_for_extra_bed,booking_master_new.tax_cgst_percentage,booking_master_new.tax_sgst_percentage,booking_master_new.cgst,booking_master_new.sgst,booking_master_new.total_taxamount,booking_master_new.total_amount,booking_master_new.total_discount,booking_master_new.remarks,booking_master_new.advance,booking_master_new.travel_agency_id,booking_master_new.travel_agency_transaction_no,booking_master_new.meal_plan_id,booking_master_new.meal_price,booking_master_new.meal_count,booking_master_new.meal_total,booking_master_new.booking_documents,booking_master_new.booking_type,booking_master_new.booking_status,booking_master_new.created_by,travel_agency.travel_agency_name,meal_plan.meal_plan_full  
            FROM `booking_master_new` 
            JOIN travel_agency ON travel_agency.travel_agency_id = booking_master_new.travel_agency_id
            LEFT JOIN meal_plan ON meal_plan.meal_plan_id = booking_master_new.meal_plan_id
            JOIN customer_master ON customer_master.customer_id = booking_master_new.customer_id
            WHERE booking_master_new.booking_no= '".$booking_no."'";
            $result_invoice_master = $conn->query($sql_invoice_master);
            $row_invoice_master['master'] = $result_invoice_master->fetch_all(MYSQLI_ASSOC);
        
        
            $sql_invoice_details ="SELECT booking_master_detail.* ,room_category.room_category 
            FROM `booking_master_detail` 
            JOIN room_category ON room_category.room_category_id = booking_master_detail.room_category
            WHERE booking_master_detail.booking_no= '".$booking_no."' AND booking_master_detail.room_no IN (".$room_no.")";
            $result_details = $conn->query($sql_invoice_details);
            $row_invoice_master['details'] = $result_details->fetch_all(MYSQLI_ASSOC);
            
            $sql_customer_ledger ="SELECT * from customer_ledger WHERE booking_no = '".$booking_no."' AND room_no IN (".$room_no.") AND status=1";
            $result_ledger_details = $conn->query($sql_customer_ledger);
            $row_ledger_result = $result_ledger_details->fetch_all(MYSQLI_ASSOC);
            
            
            // $total_ledger = array();
            foreach($row_ledger_result as $ledger_result)
            {
               if($ledger_result['income_type'] == 'Advance')
               {
                   
                 $sql_advance ="SELECT advance_master.*,customer_master.customer_fname 
                  from advance_master 
                  JOIN customer_master ON customer_master.customer_id = advance_master.customer_id
                  WHERE advance_master.advance_no = '".$ledger_result['bill_no']."' AND advance_master.status =1";
                  $result_advance_ledger = $conn->query($sql_advance);
                  $advance_ledger = $result_advance_ledger->fetch_all(MYSQLI_ASSOC);
                  $total_ledger[] = $advance_ledger[0];
               }
               if($ledger_result['income_type'] == 'Hotel')
               {
                   $total_hotel[] = $ledger_result;
               }
               if($ledger_result['income_type'] == 'Miscellaneous')
               {
                   $miscellaneous_expenses_sql ="SELECT miscellaneous_expenses.*
                    FROM miscellaneous_expenses
                    WHERE  miscellaneous_expenses_id='".$ledger_result['bill_no']."'";
                    $result_miscellaneous_expenses = $conn->query($miscellaneous_expenses_sql);
                    $row_miscellaneous_expenses = $result_miscellaneous_expenses->fetch_all(MYSQLI_ASSOC);
                   $total_miscellaneous[] = $row_miscellaneous_expenses[0];
               }
               
               
            }
            
            $sql_booking ="SELECT customer_ledger.room_no, SUM(customer_ledger.amount) as total_amount, MAX(customer_ledger.income_date) as to_date, 
                            COUNT(customer_ledger.booking_no) as no_of_nights
                            FROM customer_ledger
                            WHERE customer_ledger.booking_no='".$booking_no."' AND customer_ledger.income_type='Booking' AND customer_ledger.room_no IN (".$room_no.")
                            GROUP BY customer_ledger.room_no";
                  $result_booking_ledger = $conn->query($sql_booking);
                  $booking_ledger = $result_booking_ledger->fetch_all(MYSQLI_ASSOC);
                  $i=0;$result_details=array();
            foreach($booking_ledger as $booking_details)
            {
               $sql_detail_booking ="SELECT booking_master_detail.room_no,booking_master_detail.room_category,room_category.room_category,booking_master_detail.hotel_discount,booking_master_detail.discount_amount,booking_master_detail.room_cgst,booking_master_detail.room_sgst,booking_master_detail.room_total,booking_master_detail.hotel_from_date,booking_master_detail.hotel_price,booking_master_detail.hotel_no_of_adults,booking_master_detail.hotel_no_of_childs
                            FROM booking_master_detail
                            JOIN room_category ON room_category.room_category_id = booking_master_detail.room_category 
                            WHERE booking_master_detail.booking_no='".$booking_no."' AND  booking_master_detail.room_no ='".$booking_details['room_no']."'";
                  $result_booking_detail = $conn->query($sql_detail_booking);
                  $detail_result = $result_booking_detail->fetch_all(MYSQLI_ASSOC);
                  $result_merge = array_merge($detail_result[0],$booking_details);
                 $result_details[] = $result_merge;
            }
                  
            $row_invoice_master['Advance'] = $total_ledger;
            $row_invoice_master['Hotel'] = $total_hotel;
            $row_invoice_master['Booking'] = $result_details;
            $row_invoice_master['Miscellaneous'] = $total_miscellaneous;
            
            
            echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_invoice_master));
    
            }else{
            	$row = array();
            	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
            }
        
            
        }
    }
    
    function get_booking_detail_ledger($values,$conn)
    {
        
        
        if($values['booking_no'])
        {
            $req_booking_no =  $values['booking_no'];
            if($values['room_no'])
            {
                $req_room_no =  $values['room_no'];
               $where_condition = " WHERE booking_no= '".$req_booking_no."' AND room_no = '".$req_room_no."' AND invoice_no =''";
            }
            else{
                 $where_condition = " WHERE booking_no= '".$req_booking_no."' AND invoice_no =''";
            }
            $sql_invoice ="SELECT GROUP_CONCAT(room_no) as room_no,booking_no FROM `booking_master_detail` ".$where_condition."";
            $result = $conn->query($sql_invoice);
            $row_details = $result->fetch_all(MYSQLI_ASSOC);
            
            
            if($row_details[0]['room_no']){
                $room_no = $row_details[0]['room_no'];
                $booking_no = $row_details[0]['booking_no'];
            
            $sql_invoice_master ="SELECT customer_master.*,booking_master_new.reservation_no,booking_master_new.total_beforetax,booking_master_new.hotel_charges_for_extra_bed,booking_master_new.tax_cgst_percentage,booking_master_new.tax_sgst_percentage,booking_master_new.cgst,booking_master_new.sgst,booking_master_new.total_taxamount,booking_master_new.total_amount,booking_master_new.total_discount,booking_master_new.remarks,booking_master_new.advance,booking_master_new.travel_agency_id,booking_master_new.travel_agency_transaction_no,booking_master_new.meal_plan_id,booking_master_new.meal_price,booking_master_new.meal_count,booking_master_new.meal_total,booking_master_new.booking_documents,booking_master_new.booking_type,booking_master_new.booking_status,booking_master_new.created_by,travel_agency.travel_agency_name,meal_plan.meal_plan_full  
            FROM `booking_master_new` 
            JOIN travel_agency ON travel_agency.travel_agency_id = booking_master_new.travel_agency_id
            LEFT JOIN meal_plan ON meal_plan.meal_plan_id = booking_master_new.meal_plan_id
            JOIN customer_master ON customer_master.customer_id = booking_master_new.customer_id
            WHERE booking_master_new.booking_no= '".$booking_no."'";
            $result_invoice_master = $conn->query($sql_invoice_master);
            $row_invoice_master['master'] = $result_invoice_master->fetch_all(MYSQLI_ASSOC);
        
        
            $sql_invoice_details ="SELECT booking_master_detail.* ,room_category.room_category 
            FROM `booking_master_detail` 
            JOIN room_category ON room_category.room_category_id = booking_master_detail.room_category
            WHERE booking_master_detail.booking_no= '".$booking_no."' AND booking_master_detail.room_no IN (".$room_no.")";
            $result_details = $conn->query($sql_invoice_details);
            $row_invoice_master['details'] = $result_details->fetch_all(MYSQLI_ASSOC);
            
            $sql_customer_ledger ="SELECT * from customer_ledger WHERE booking_no = '".$booking_no."' AND room_no IN (".$room_no.") and status=1";
            $result_ledger_details = $conn->query($sql_customer_ledger);
            $row_ledger_result = $result_ledger_details->fetch_all(MYSQLI_ASSOC);
            
            
            // $total_ledger = array();
            foreach($row_ledger_result as $ledger_result)
            {
               if($ledger_result['income_type'] == 'Advance')
               {
                   
                 $sql_advance ="SELECT advance_master.*,customer_master.customer_fname 
                  from advance_master 
                  JOIN customer_master ON customer_master.customer_id = advance_master.customer_id
                  WHERE advance_master.advance_no = '".$ledger_result['bill_no']."' AND advance_master.status =1";
                  $result_advance_ledger = $conn->query($sql_advance);
                  $advance_ledger = $result_advance_ledger->fetch_all(MYSQLI_ASSOC);
                  $total_ledger[] = $advance_ledger[0];
               }
               if($ledger_result['income_type'] == 'Hotel')
               {
                   $total_hotel[] = $ledger_result;
               }
               if($ledger_result['income_type'] == 'Miscellaneous')
               {
                   $miscellaneous_expenses_sql ="SELECT miscellaneous_expenses.*
                    FROM miscellaneous_expenses
                    WHERE  miscellaneous_expenses_id='".$ledger_result['bill_no']."'";
                    $result_miscellaneous_expenses = $conn->query($miscellaneous_expenses_sql);
                    $row_miscellaneous_expenses = $result_miscellaneous_expenses->fetch_all(MYSQLI_ASSOC);
                   $total_miscellaneous[] = $row_miscellaneous_expenses[0];
               }
            }
            
            $sql_booking ="SELECT customer_ledger.room_no, SUM(customer_ledger.amount) as total_amount, MAX(customer_ledger.income_date) as to_date, 
                            COUNT(customer_ledger.booking_no) as no_of_nights
                            FROM customer_ledger
                            WHERE customer_ledger.booking_no='".$booking_no."' AND customer_ledger.income_type='Booking' AND customer_ledger.room_no IN (".$room_no.")
                            GROUP BY customer_ledger.room_no";
                  $result_booking_ledger = $conn->query($sql_booking);
                  $booking_ledger = $result_booking_ledger->fetch_all(MYSQLI_ASSOC);
                  $i=0;$result_details=array();
            foreach($booking_ledger as $booking_details)
            {
               $sql_detail_booking ="SELECT booking_master_detail.room_no,booking_master_detail.room_category,room_category.room_category,booking_master_detail.hotel_discount,booking_master_detail.discount_amount,booking_master_detail.room_cgst,booking_master_detail.room_sgst,booking_master_detail.room_total,booking_master_detail.hotel_from_date,booking_master_detail.hotel_price,booking_master_detail.hotel_no_of_adults,booking_master_detail.hotel_no_of_childs
                            FROM booking_master_detail
                            JOIN room_category ON room_category.room_category_id = booking_master_detail.room_category 
                            WHERE booking_master_detail.booking_no='".$booking_no."' AND  booking_master_detail.room_no ='".$booking_details['room_no']."'";
                  $result_booking_detail = $conn->query($sql_detail_booking);
                  $detail_result = $result_booking_detail->fetch_all(MYSQLI_ASSOC);
                  $result_merge = array_merge($detail_result[0],$booking_details);
                 $result_details[] = $result_merge;
            }
                  
            $row_invoice_master['Advance'] = $total_ledger;
            $row_invoice_master['Hotel'] = $total_hotel;
            $row_invoice_master['Booking'] = $result_details;
            $row_invoice_master['Miscellaneous'] = $total_miscellaneous;
            
            
            echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row_invoice_master));
    
            }else{
            	$row = array();
            	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
            }
        
            
        }
    }
    
    function get_login_details($values,$conn)
    {
        $user_name =  $values['user_name'];
        $password =  $values['user_password'];
        
        $sql = "select employee_master.*, login_master.* 
                FROM login_master
                JOIN employee_master ON employee_master.employee_id = login_master.employee_id
                WHERE login_master.login_name='".$user_name."' AND login_password='".$password."' AND employee_master.status=1";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            
            $login_insert_sql = "UPDATE login_master SET login_status=1 WHERE login_name='".$user_name."'";
         
                $login_insert_result= $conn->query($login_insert_sql); 
            
        	$row = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
    function get_reservation($values,$conn,$where_values,$like_values,$limit_values)
    {
        $reservation_no =  $values['reservation_no'];
        
        $sql = "SELECT reservation_master_new.*,reservation_master_detail.*
                FROM `reservation_master_new` 
                JOIN reservation_master_detail ON reservation_master_detail.reservation_no = reservation_master_new.reservation_no 
                WHERE reservation_master_new.reservation_no='".$reservation_no."'".$where_values.$like_values.$limit_values;
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }
    }
    
    function get_normal_dashboard($values,$conn)
    {
    
        $reservation_no =  $values['reservation_no'];
        $current_date = date("Y-m-d");
        
        $sql = "select (select count(1) from booking_master_detail where date(hotel_from_date) = '".$current_date."' AND room_status = 'I') as Checkin, (select count(1) from booking_master_detail where date(hotel_to_date) = '".$current_date."' AND room_status = 'O') AS checkout ,(select count(reservation_master_detail.reservation_master_detail_id) from reservation_master_detail JOIN reservation_master_new ON reservation_master_new.reservation_no = reservation_master_detail.reservation_no AND reservation_master_new.reservation_status ='A' where date(hotel_from_date) = '".$current_date."' ) as ExpectedArrival,(select count(1) from booking_master_detail where date(hotel_to_date) = '".$current_date."' AND room_status = 'I') AS ExpectedDepature";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row = $result->fetch_all(MYSQLI_ASSOC);
        	
         $sql_room = "select room_master.room_master_id,room_master.room_no,room_master.room_name,room_master.room_floor_id,room_master.current_status,room_category.room_category_id,floor_master.floor_name,employee_master.employee_name,
            IFNULL(booking_master_detail.booking_no, '') as booking_no
        from room_master
        join room_category ON room_category.room_category_id = room_master.room_category_id and room_category.status=1
        join floor_master ON floor_master.floor_master_id = room_master.room_floor_id and floor_master.status=1
        join employee_master ON employee_master.employee_id = room_master.created_by and employee_master.status=1
         LEFT JOIN booking_master_detail ON booking_master_detail.room_no = room_master.room_no AND booking_master_detail.room_status='I'";
        	 $result_room = $conn->query($sql_room);
        	foreach($result_room as $res)
    		{
    		    $res_room[$res['floor_name']][] = $res;
    		}
    		$row[0]['RoomStatus'] = json_encode($res_room);
    		
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }

    }
    
    function get_admin_dashboard($values,$conn)
    {
    
        $reservation_no =  $values['reservation_no'];
        
        
        $sql = "";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
        	$row = $result->fetch_all(MYSQLI_ASSOC);
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }

    }
    
    // Function to get all the dates in given range 
    function getDatesFromRange($start, $end, $format = 'Y-m-d') { 
          
        // Declare an empty array 
        $array = array(); 
          
        // Variable that store the date interval 
        // of period 1 day 
        $interval = new DateInterval('P1D'); 
      
        $realEnd = new DateTime($end); 
        $realEnd->add($interval); 
      
        $period = new DatePeriod(new DateTime($start), $interval, $realEnd); 
      
        // Use loop to store date into array 
        foreach($period as $date) {                  
            $array[] = $date->format($format);  
        } 
      
        // Return the array elements 
        return $array; 
    } 
    
     function getDatesFromMonthYear($month, $year) { 
          
        
        $start_date = "01-".$month."-".$year;
        $start_time = strtotime($start_date);
        
        $end_time = strtotime("+1 month", $start_time);
        
        for($i=$start_time; $i<$end_time; $i+=86400)
        {
           $list[] = date('Y-m-d', $i);
        }
        
      //  print_r($list);
        return $list; 
    } 
    
    function calander_availablity($values,$conn)
    {
        
        $month =  $values['month'];
        $year =  $values['year'];
        
        $Date_list = $this->getDatesFromMonthYear($month, $year);
        $room_category =  $values['room_category'];
        
         $room_cat_sql ="select `room_category_id`,`room_category`
 from room_category WHERE status =1 ";
         $room_cat_result = $conn->query($room_cat_sql);
         $room_cat_count = $room_cat_result->fetch_all(MYSQLI_ASSOC);
        $reservation_occupaid=array(); 
        foreach($Date_list as $ch_av)
        {
           
          foreach($room_cat_count as $room_category) 
            {
          
             $sql = "SELECT COUNT(reservation_master_detail.room_category) as occupaid
                FROM reservation_master_new 
                JOIN reservation_master_detail ON reservation_master_detail.reservation_no = reservation_master_new.reservation_no
                WHERE reservation_master_new.reservation_status IN ('A','AM') AND reservation_master_detail.room_category = ".$room_category['room_category_id']." AND '".$ch_av."' BETWEEN DATE(reservation_master_detail.hotel_from_date) and DATE(reservation_master_detail.hotel_to_date) AND DATE(reservation_master_detail.hotel_to_date) !='".$ch_av."'";
            $result_reservation = $conn->query($sql);
            $res_reservation =  $result_reservation->fetch_all(MYSQLI_ASSOC);
            $reservation_occupaid[$ch_av]['Reservation'][$room_category['room_category']] = $res_reservation[0];
            
        
            $sql_room_count = "SELECT room_category.room_category, count(1) as total_room 
                           from room_master 
                           JOIN room_category ON room_category.room_category_id = room_master.room_category_id
                           WHERE room_master.room_category_id =".$room_category['room_category_id']."
                           GROUP BY room_category.room_category ";
            $result_room = $conn->query($sql_room_count);
            $res_room =  $result_room->fetch_all(MYSQLI_ASSOC);
            $reservation_occupaid[$ch_av]['room_count'][$room_category['room_category']] = $res_room[0];
           
            
            
           $sql_booking = "SELECT COUNT(booking_master_detail.room_category) as occupaid_booking
                FROM booking_master_new 
                JOIN booking_master_detail ON booking_master_detail.booking_no = booking_master_new.booking_no
                WHERE booking_master_new.booking_status IN ('A','AM') AND booking_master_detail.room_category = ".$room_category['room_category_id']." AND '".$ch_av."' BETWEEN DATE(booking_master_detail.hotel_from_date) and DATE(booking_master_detail.hotel_to_date) AND DATE(booking_master_detail.hotel_to_date) != '".$ch_av."'";
            $result_booking = $conn->query($sql_booking);
            $res_booking = $result_booking->fetch_all(MYSQLI_ASSOC);
            $reservation_occupaid[$ch_av]['Booking'][$room_category['room_category']] = $res_booking[0];
            
            
            }
            
            
        }
         if ($reservation_occupaid) {
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$reservation_occupaid));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }

    }  
    
    function roomcheckAvail($values,$conn,$where_values,$like_values,$limit_values)
    {
        
        $hotel_from_date =  $values['hotel_from_date'];
        $hotel_to_date =  $values['hotel_to_date'];
        $Date_list = $this->getDatesFromRange($hotel_from_date, $hotel_to_date);
        $room_category =  $values['room_category'];
        
       
        foreach($Date_list as $ch_av)
        {
          $sql = "SELECT IFNULL(sum(reservation_master_detail.hotel_no_of_rooms),0) as `no_of_rooms_occupaid`
                FROM reservation_master_new 
                JOIN reservation_master_detail ON reservation_master_detail.reservation_no = reservation_master_new.reservation_no
                WHERE reservation_master_new.reservation_status IN ('A','AM') AND reservation_master_detail.room_category = ".$room_category." AND '".$ch_av."' BETWEEN DATE(reservation_master_detail.hotel_from_date) and DATE(reservation_master_detail.hotel_to_date)   OR DATE(reservation_master_detail.hotel_to_date) = '".$ch_av."' AND reservation_master_detail.room_category = ".$room_category." OR DATE(reservation_master_detail.hotel_from_date) = '".$ch_av."' AND reservation_master_detail.room_category = ".$room_category." ";
           $result = $conn->query($sql);
           $reservation_occupaid[$ch_av] = $result->fetch_all(MYSQLI_ASSOC);
           $min_val[] = ($reservation_occupaid[$ch_av][0]['no_of_rooms_occupaid']);
            
        }
        
        $reservation_occupaid['min_occupaid'] = min($min_val);
        $reservation_occupaid['max_occupaid'] = max($min_val);
        
        if ($reservation_occupaid) {
        
        	$sql_count = "SELECT count(1) as available_count FROM `room_master` WHERE room_category_id =".$room_category." AND status= 'A'";
                $result_count = $conn->query($sql_count);
            	$row_count = $result_count->fetch_all(MYSQLI_ASSOC);
        	
        	$reservation_occupaid['total_no_rooms'] = $row_count[0]['available_count'];
        	
        	echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$reservation_occupaid));
        }else{
        	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
        }

    }  
    
    
    
    function get_avail_rooms($values,$conn)
    {
        
        $hotel_from_date =  $values['hotel_from_date'];
        $hotel_to_date =  $values['hotel_to_date'];
        $Date_list = $this->getDatesFromRange($hotel_from_date, $hotel_to_date);
        $room_category =  $values['room_category'];
        
       
        foreach($Date_list as $ch_av)
        {
         $sql = "SELECT booking_master_detail.room_no as `occupaid_rooms`
                FROM booking_master_new 
                JOIN booking_master_detail ON booking_master_detail.booking_no = booking_master_new.booking_no
                WHERE booking_master_new.booking_status IN ('A') 
                AND booking_master_detail.room_category = ".$room_category." 
                AND '".$ch_av."' BETWEEN DATE(booking_master_detail.hotel_from_date) and DATE(booking_master_detail.hotel_to_date) 
                OR DATE(booking_master_detail.hotel_from_date) = '".$ch_av."' AND booking_master_detail.room_status IN ('I') AND booking_master_detail.room_category = ".$room_category."";
           $result = $conn->query($sql);
           $booking_occupaid[$ch_av] = $result->fetch_all(MYSQLI_ASSOC);
           
           $rooms_list[] = ($booking_occupaid[$ch_av][0]['occupaid_rooms']);
            
        }
        
        if ($booking_occupaid) {
        
        $sql_count = "SELECT GROUP_CONCAT(room_no) as room_no FROM `room_master` WHERE room_category_id =".$room_category." AND status= 'A' AND current_status NOT IN ('OS','OD','R')";
        $result_count = $conn->query($sql_count);
        $row_count = $result_count->fetch_all(MYSQLI_ASSOC);
        
        $val_rooms =  explode(',',$row_count[0]['room_no']);
        
        $arr_1 = array_diff($rooms_list, $val_rooms);
        $arr_2= array_diff($val_rooms,$rooms_list);
        $final_output = array_merge($arr_1, $arr_2);

        
        $available_rooms=  array_unique(array_filter($final_output));
        echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$available_rooms));
       
        }else{
        	$row = "";
        	echo json_encode(array("message"=>"Failed","status_code"=>400));
        }

    }  
    
    
    function roomMaster($values,$conn,$where_values,$like_values,$limit_values)
    {
        
      $sql = "select room_master.*,room_category.*,floor_master.floor_name,employee_master.employee_name
                    from room_master
                    join room_category ON room_category.room_category_id = room_master.room_category_id and room_category.status = 'A'
                    join floor_master ON floor_master.floor_master_id = room_master.room_floor_id and floor_master.status=1
                    join employee_master ON employee_master.employee_id = room_master.created_by and employee_master.status=1 ".$where_values.$like_values.$limit_values;
     	$result = $conn->query($sql);
    	
    	if ($result->num_rows > 0) {
    		$row = $result->fetch_all(MYSQLI_ASSOC);
    		
    		echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row));
    	}else{
    		$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
    	}
    
    }
    
    function generalMaster($values,$conn,$where_values,$like_values,$limit_values)
    {
       
       if($values['table_name']){
         
       $sql = "select ".$values['column']." from ".$values['table_name'].$where_values.$like_values.$limit_values;
        //echo $sql;
        $result = $conn->query($sql);
       if ($result->num_rows > 0) {
    		$row = $result->fetch_all(MYSQLI_ASSOC);
    		echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row));
    	}else{
    		$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
    	}
       }else{
    		$row = "";
    		echo json_encode(array("message"=>"Invalid Json","status_code"=>404,));
    	}
    }
    
    
    function expensesMaster($values,$conn,$where_values,$like_values,$limit_values)
    {
        
        $sql = "SELECT `expenses_master`.*,expenses_type.expenses_type as expenses_type_name,employee_master.employee_name
                FROM `expenses_master`
                JOIN  `expenses_type` ON `expenses_type`.`expenses_type_id` = `expenses_master`.`expenses_type` AND `expenses_type`.`status`=1
                join employee_master ON employee_master.employee_id = expenses_master.created_by and employee_master.status=1".$where_values.$like_values.$limit_values;
     	$result = $conn->query($sql);
    	
    	if ($result->num_rows > 0) {
    		$row = $result->fetch_all(MYSQLI_ASSOC);
    		echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row));
    	}else{
    	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
    	}
    
    }
    
    
     function get_customer_ledger($values,$conn,$where_values)
    {
    
    
    $sql_check_room = "SELECT customer_ledger.* from customer_ledger where customer_ledger.booking_no= '".$values['booking_no']."'";
    
    $result_check_room = $conn->query($sql_check_room);
    $row_check_room = $result_check_room->fetch_all(MYSQLI_ASSOC);
    	
    if($values['room_no']){    
        
       
                $sql = "SELECT customer_ledger.`customer_ledger_id`,customer_ledger.booking_no,customer_ledger.room_no,customer_ledger.refer_room,customer_ledger.income_type,customer_ledger.description,customer_ledger.amount,customer_ledger.income_date,customer_ledger.payment_type as payment_mode,customer_ledger.bill_no,customer_ledger.status,customer_ledger.created_by,customer_ledger.created_at,customer_ledger.updated_at ,customer_master.customer_fname,booking_master_new.customer_id,booking_master_new.meal_plan_id,booking_master_new.meal_price,booking_master_new.meal_count,booking_master_new.meal_total,meal_plan.meal_plan_full, payment_master.payment_mode as payment_type
                FROM `customer_ledger`
                JOIN booking_master_new ON booking_master_new.booking_no = customer_ledger.booking_no
                JOIN customer_master ON customer_master.customer_id = booking_master_new.customer_id
                LEFT JOIN meal_plan ON meal_plan.meal_plan_id = booking_master_new.meal_plan_id
                LEFT JOIN payment_master ON payment_master.payment_master_id = customer_ledger.payment_type
                WHERE customer_ledger.status=1 AND customer_ledger.booking_no='".$values['booking_no']."' AND customer_ledger.room_no='".$values['room_no']."' OR customer_ledger.refer_room='".$values['room_no']."' ";
             	$result = $conn->query($sql);
             	$row_book = $result->fetch_all(MYSQLI_ASSOC);
            
            foreach($row_book as $check_refer)
            {
                 $refer_array[] = $check_refer['room_no'];
            }
       
        $refer_room_confirmed = implode(',',array_filter(array_unique($refer_array)));
      
      
        $sql_booking = "select booking_master_detail.* ,room_category.room_category,room_category.room_category_id
        from booking_master_detail 
        JOIN room_category ON room_category.room_category_id = booking_master_detail.room_category WHERE booking_master_detail.booking_no='".$values['booking_no']."' AND booking_master_detail.room_no IN ($refer_room_confirmed)";
        $result_booking = $conn->query($sql_booking);  
        $row_booking = $result_booking->fetch_all(MYSQLI_ASSOC);
        $final_result = array();$i=0;
        
        
    	foreach($row_book as $rowresult)
    	{
    	    
// print_r($rowresult[$i]['income_type']);

    	   if($row_book[$i]['income_type'] == "Booking"){
    	     
    	     $final_result["Booking"][] = $rowresult;
    	     
    	    }
    	     if($row_book[$i]['income_type'] == "Advance"){
    	        $final_result["Advance"][] = $rowresult;
    	       
    	    }
    	    if($row_book[$i]['income_type'] == "Hotel"){
    	        $final_result["Hotel"][] = $rowresult;
    	        
    	    }
    	   /* if($row_book[$i]['income_type'] == "Miscellaneous"){
    	        $final_result["Miscellaneous"][] = $rowresult;
    	        
    	    }*/
    	    
    	    $final_result["Meals"]['meal_plan_full'] = $rowresult['meal_plan_full'];
    	    $final_result["Meals"]['meal_price'] = $rowresult['meal_price'];
    	    $final_result["Meals"]['meal_count'] = $rowresult['meal_count'];
    	    $final_result["Meals"]['meal_total'] = $rowresult['meal_total'];
    	    
    	    
    	    
    	$i++;}
        
    }else{
        
        $sql_noroom = "SELECT customer_ledger.`customer_ledger_id`,customer_ledger.booking_no,customer_ledger.room_no,customer_ledger.income_type,customer_ledger.description,customer_ledger.amount,customer_ledger.income_date,customer_ledger.payment_type as payment_mode,customer_ledger.bill_no,customer_ledger.status,customer_ledger.created_by,customer_ledger.created_at,customer_ledger.updated_at ,customer_master.customer_fname,booking_master_new.customer_id,booking_master_new.meal_plan_id,booking_master_new.meal_price,booking_master_new.meal_count,booking_master_new.meal_total,meal_plan.meal_plan_full, payment_master.payment_mode as payment_type
        FROM `customer_ledger`
        JOIN booking_master_new ON booking_master_new.booking_no = customer_ledger.booking_no
        JOIN customer_master ON customer_master.customer_id = booking_master_new.customer_id
        LEFT JOIN meal_plan ON meal_plan.meal_plan_id = booking_master_new.meal_plan_id
        LEFT JOIN payment_master ON payment_master.payment_master_id = customer_ledger.payment_type
        WHERE customer_ledger.status=1 AND customer_ledger.booking_no='".$values['booking_no']."'";
        $result_noroom = $conn->query($sql_noroom);
        $row_book = $result_noroom->fetch_all(MYSQLI_ASSOC);   
        
        $sql_booking = "select booking_master_detail.* ,room_category.room_category,room_category.room_category_id
        from booking_master_detail 
        JOIN room_category ON room_category.room_category_id = booking_master_detail.room_category WHERE booking_master_detail.booking_no='".$values['booking_no']."'";
        $result_booking = $conn->query($sql_booking);    
        $row_booking = $result_booking->fetch_all(MYSQLI_ASSOC);
        
       	$final_result = array(); 
       
        foreach($row_book as $rowresult)
    	{
    	    
    	    if($rowresult['income_type'] == "Booking"){
    	     
    	     $final_result["Booking"][] = $rowresult;
    	     continue;
    	    }
    	    if($rowresult['income_type'] == "Advance"){
    	        $final_result["Advance"][] = $rowresult;
    	        continue;
    	    }
    	    if($rowresult['income_type'] == "Hotel"){
    	        $final_result["Hotel"][] = $rowresult;
    	        continue;
    	    }
    	   /* if($rowresult['income_type'] == "Miscellaneous"){
    	        $final_result["Miscellaneous"][] = $rowresult;
    	        continue;
    	    }*/
    	}
    }
    	if(count($final_result['Booking']) <= 0 )
    	{
    	     $final_result["Booking"] = array();
    	}
    	if(count($final_result['Advance']) <= 0 )
    	{
    	     $final_result["Advance"] = array();
    	}
    	if(count($final_result['Hotel']) <= 0 )
    	{
    	     $final_result["Hotel"] = array();
    	}
    /*	if(count($final_result['Miscellaneous']) <= 0 )
    	{
    	     $final_result["Miscellaneous"] = array();
    	}*/
    	//echo count($final_result['Booking']);
    	
    	 $sql_invoice = "SELECT invoice_no FROM `invoice_master` 
         WHERE invoice_master.process_no='".$values['booking_no']."'";
        $result_invoice = $conn->query($sql_invoice);    
        $row_result = $result_invoice->fetch_all(MYSQLI_ASSOC);	
        
        // get Audit date
        $get_audit_date = $this->get_audit($conn);
         
        // Miscellaneous
        $miscellaneous_expenses_sql ="SELECT customer_ledger.* , miscellaneous_expenses.*
                    FROM customer_ledger 
                    JOIN miscellaneous_expenses ON miscellaneous_expenses.miscellaneous_expenses_id = customer_ledger.bill_no 
                    WHERE customer_ledger.income_type='Miscellaneous' AND customer_ledger.booking_no='".$values['booking_no']."' AND customer_ledger.status=1";
        $result_miscellaneous_expenses = $conn->query($miscellaneous_expenses_sql);    
        $row_result_miscellaneous_expenses = $result_miscellaneous_expenses->fetch_all(MYSQLI_ASSOC);	
         
    		
    	// Booking Master
        $booking_master_sql ="select booking_master_new.booking_no,booking_master_new.travel_agency_id,booking_master_new.travel_agency_transaction_no,booking_master_new.booking_type,booking_master_new.booking_documents,travel_agency.travel_agency_name FROM booking_master_new LEFT JOIN travel_agency ON travel_agency.travel_agency_id = booking_master_new.travel_agency_id WHERE booking_master_new.booking_no = '".$values['booking_no']."'";
        $result_booking_master = $conn->query($booking_master_sql);    
        $row_booking_master = $result_booking_master->fetch_all(MYSQLI_ASSOC);
        
    	 $final_result['invoice_details'] = $row_result;	
         $final_result['booking_details'] = $row_booking;
         $final_result['audit_date'] = $get_audit_date;
         $final_result["Miscellaneous"] = $row_result_miscellaneous_expenses;
         $final_result["Booking_master"] = $row_booking_master;
    		
    	 echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$final_result));
    }
    
    
    function get_audit($conn)
    {
            $sql_audit ="SELECT `night_audit_date` FROM `night_audit_master` WHERE `night_audit_status` =1 ORDER BY `night_audit_master_id` DESC limit 1";
         	$result_audit = $conn->query($sql_audit);
         	$row_audit = $result_audit->fetch_all(MYSQLI_ASSOC);
         	
         	return $currentaudit_date = $row_audit[0]['night_audit_date'];
        
    }
    
    
     function customer_ledger_list($values,$conn)
    {
        
      $sql = "select GROUP_CONCAT(room_master.room_no) as room_no,room_master.current_status,
employee_master.employee_name,booking_master_new.customer_id,customer_master.customer_fname,customer_master.customer_phone,
            IFNULL(booking_master_detail.booking_no, '') as booking_no
        from room_master
        LEFT join employee_master ON employee_master.employee_id = room_master.created_by and employee_master.status=1
        LEFT JOIN booking_master_detail ON booking_master_detail.room_no = room_master.room_no AND booking_master_detail.room_status='I'
        LEFT JOIN booking_master_new ON booking_master_new.booking_no = booking_master_detail.booking_no
        LEFT JOIN customer_master ON customer_master.customer_id = booking_master_new.customer_id
         WHERE room_master.current_status ='IH' AND booking_master_new.booking_status !='D'
         GROUP BY booking_master_detail.booking_no";
     	$result = $conn->query($sql);
    	
    	if ($result->num_rows > 0) {
    		$row = $result->fetch_all(MYSQLI_ASSOC);
    		echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$row));
    	}else{
    	$row = array();
        	echo json_encode(array("message"=>"failed","status_code"=>400,"result"=>$row));
    	}
    
    }
    
      function check_night_query($values,$conn)
    {
        //check audit date
        $sql_audit ="SELECT night_audit_date FROM `night_audit_master` WHERE night_audit_status =0";
         	$result_audit = $conn->query($sql_audit);
         	$row_audit = $result_audit->fetch_all(MYSQLI_ASSOC);
         	
         	$currentaudit_date = $row_audit[0]['night_audit_date'];
           // $currentaudit_date = '2021-06-24';
         if($currentaudit_date)
        {
            
            $audit_date = $currentaudit_date;
            $sql_booking = "select booking_master_detail.* ,room_category.room_category as room_category
            FROM booking_master_detail 
            JOIN room_category ON room_category.room_category_id = booking_master_detail.room_category
                WHERE DATE(booking_master_detail.hotel_to_date) = '".$audit_date."' AND booking_master_detail.room_status='I'";
    
         	$result_booking = $conn->query($sql_booking);
         	
         	$row_booking = $result_booking->fetch_all(MYSQLI_ASSOC);
         	
         	$sql_reservation = "select reservation_master_new.reservation_status,reservation_master_new.reservation_no,reservation_master_new.reservation_status,reservation_master_new.total_amount,customer_master.customer_fname,customer_master.customer_phone
                                FROM reservation_master_detail 
                                JOIN reservation_master_new ON reservation_master_new.reservation_no = reservation_master_detail.reservation_no
                                JOIN customer_master ON customer_master.customer_id = reservation_master_new.customer_id
                WHERE DATE(reservation_master_detail.hotel_from_date) = '".$audit_date."' AND reservation_master_new.reservation_status IN ('A','AM') GROUP BY reservation_master_new.reservation_no";
    
         	$result_reservation = $conn->query($sql_reservation);
         	$row_reservation = $result_reservation->fetch_all(MYSQLI_ASSOC);
         	
         	
         	$sql_expenses = "SELECT expenses_master.expenses_id,expenses_master.expenses_type,expenses_master.expenses_description,expenses_master.expenses_remarks,expenses_master.expenses_amount,expenses_master.status,expenses_type.expenses_type,payment_master.payment_mode
                            FROM `expenses_master` 
                            JOIN expenses_type ON expenses_type.expenses_type_id = expenses_master.expenses_type
                            JOIN payment_master ON payment_master.payment_master_id = expenses_master.expenses_payment_type WHERE DATE(expenses_master.created_at) = '".$audit_date."'";
    
         	$result_expenses = $conn->query($sql_expenses);
         	$row_expenses = $result_expenses->fetch_all(MYSQLI_ASSOC);
         	
         	 $sql_income ="SELECT * FROM `customer_ledger` WHERE DATE(`created_at`)= '".$audit_date."'AND income_type IN ('Booking','Hotel','Miscellaneous') and status=1";
         	$result_income = $conn->query($sql_income);
         	$row_income = $result_income->fetch_all(MYSQLI_ASSOC);
         	
         	$sql_invoice ="SELECT invoice_master.*, payment_master.payment_mode,customer_master.customer_fname,customer_master.customer_phone
         	                FROM `invoice_master` 
         	                JOIN customer_master ON customer_master.customer_id = invoice_master.customer_id
         	                JOIN payment_master ON payment_master.payment_master_id = invoice_master.payment_type
         	                WHERE DATE(invoice_master.`created_at`)= '".$audit_date."' and invoice_master.status=1";
         	$result_invoice = $conn->query($sql_invoice);
         	$row_invoice = $result_invoice->fetch_all(MYSQLI_ASSOC);
         	
         	$sql_advance ="SELECT advance_master.* ,payment_master.payment_mode,customer_master.customer_fname,customer_master.customer_phone
         	FROM `advance_master`
         	JOIN customer_master ON customer_master.customer_id = advance_master.customer_id
         	JOIN payment_master ON payment_master.payment_master_id = advance_master.payment_mode
         	WHERE DATE(advance_master.`created_at`)= '".$audit_date."' and advance_master.status=1";
         	$result_advance = $conn->query($sql_advance);
         	$row_advance = $result_advance->fetch_all(MYSQLI_ASSOC);
         	
         	
         	
         	$final_result['booking'] =  $row_booking;
        	$final_result['reservation'] =  $row_reservation;
        	$final_result['expenses'] =  $row_expenses;
        	$final_result['income'] =  $row_income;
        	$final_result['collection'] =  array_merge($row_invoice,$row_advance);
        	
         	return $final_result;
        	
        }else{
            echo json_encode(array("message"=>"Parameter Missing","status_code"=>400));
        }
    
    }
    
    function night_audit_date($values,$conn)
    {
        //check audit date
        $sql_audit ="SELECT night_audit_date FROM `night_audit_master` WHERE night_audit_status =0";
         	$result_audit = $conn->query($sql_audit);
         	$row_audit = $result_audit->fetch_all(MYSQLI_ASSOC);
         	
         	$currentaudit_date = $row_audit[0]['night_audit_date'];
           
           echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$currentaudit_date));
    }
    
    
    
    function check_night_audit($values,$conn)
    {
        //check audit date
        $sql_audit ="SELECT night_audit_date FROM `night_audit_master` WHERE night_audit_status =0";
         	$result_audit = $conn->query($sql_audit);
         	$row_audit = $result_audit->fetch_all(MYSQLI_ASSOC);
         	
         	$currentaudit_date = $row_audit[0]['night_audit_date'];
           // $currentaudit_date = '2021-06-24';
         if($currentaudit_date)
        {
            
           $final_result =   $this->check_night_query($currentaudit_date,$conn);
           $final_result['audit_date'] =$currentaudit_date;
           
           echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$final_result));
        	
        }else{
            echo json_encode(array("message"=>"Parameter Missing","status_code"=>400));
        }
    }
    
    function close_night_audit($values,$conn)
    {
        
        $sql_audit ="SELECT night_audit_date,night_audit_status FROM `night_audit_master` WHERE night_audit_date='".$values['audit_date']."'";
     	$result_audit = $conn->query($sql_audit);
     	$row_audit = $result_audit->fetch_all(MYSQLI_ASSOC);
         	if(count($row_audit) == 1 && ($row_audit[0]['night_audit_status'] == 0))
         	{
         	   /* $sys_date = date("Y-m-s");
                $audit_date = $values['audit_date'];
                
                if($audit_date <= $sys_date)
                {*/
                    $currentaudit_date = $row_audit[0]['night_audit_date'];
                   // $currentaudit_date = '2021-06-24';
                    $res =   $this->check_night_query($currentaudit_date,$conn);
                    
                    if(count($res['booking']) == 0 && count($res['reservation']) == 0)
                    {
                    
                    //check audit date
                    if($currentaudit_date)
                    {
                      $next_date = date('Y-m-d', strtotime($currentaudit_date .' +1 day'));  
                    //start  booking insert next date on ledger:
                    
                    $check_sql = "select booking_master_detail_id,booking_no,room_no,room_total
                    from booking_master_detail
                    WHERE booking_master_detail.room_status='I'
                    AND '".$next_date."' BETWEEN booking_master_detail.hotel_from_date and booking_master_detail.hotel_to_date OR booking_master_detail.hotel_to_date = '".$next_date."' 
                    OR booking_master_detail.hotel_from_date = '".$next_date."'";
                    
                    $result_check = $conn->query($check_sql);
                	$row_check = $result_check->fetch_all(MYSQLI_ASSOC);
                	
                	foreach($row_check as $loop_chk)
                	{
                	    
                	    $sql_booking ="insert INTO customer_ledger 
                	        SELECT '',`booking_no`,`room_no`,`refer_room`,`income_type`,`description`,`amount`,`income_date`,`payment_type`,`bill_no`,`status`,`created_by`,`created_at`,`updated_at` FROM customer_ledger WHERE booking_no='".$loop_chk['booking_no']."' AND room_no='".$loop_chk['room_no']."' AND income_type='Booking' ORDER BY customer_ledger_id ASC LIMIT 1 ";
                        $result_booking_ledger = $conn->query($sql_booking);
                        
                	    
                	   $ledger_insert_sql = "UPDATE customer_ledger SET income_date='".$next_date."'  WHERE customer_ledger_id='".$conn->insert_id."'";
                        $ledger_insert_result= $conn->query($ledger_insert_sql); 
                	}
                	    
                    //End booking insert next date on ledger:
                    //Update Audit
                    $sql_close_audit = "UPDATE night_audit_master SET night_audit_status =1 WHERE night_audit_status=0 AND night_audit_date='".$currentaudit_date."'";
                    $result_close_audit = $conn->query($sql_close_audit);
                    
                    //Insert New Audit
                    
                    $sql_open_audit = "INSERT INTO `night_audit_master` (`night_audit_master_id`, `night_audit_date`, `night_audit_status`, `created_at`, `created_by`) VALUES (NULL, '".$next_date."', '0', CURRENT_TIMESTAMP, '10001');";
                    $result_open_audit = $conn->query($sql_open_audit);
                    
                    echo json_encode(array("message"=>"success","status_code"=>200));
                    
                    }
                    
                    }else{
                    echo json_encode(array("message"=>"Audit Pending","status_code"=>400));
                    }
        
               /* }else{
                    echo json_encode(array("message"=>"Systemdate Mismatch","status_code"=>400));
                }*/
         	}else{
         	    
         	    if(($row_audit[0]['night_audit_status'] != 0)){
         	    echo json_encode(array("message"=>"Audit Already Done ","status_code"=>400));
         	    }else{
         	        echo json_encode(array("message"=>"Date Replicated","status_code"=>400));
         	    }
         	}
    
    }
    
     function get_all_reports($values,$conn)
    {
        
            switch($values['report_type'])
           {
               
                case "CheckinReport":
                    
                    $report_sql = "SELECT booking_master_new.booking_master_id,booking_master_new.booking_no,booking_master_new.customer_id,booking_master_new.created_at,customer_master.customer_fname,customer_master.customer_phone
FROM booking_master_new
JOIN customer_master ON customer_master.customer_id = booking_master_new.customer_id";
                    
                    
                    
                break;
                
                default:
                    $result = json_encode(array("message"=>"Date Replicated","status_code"=>400));
                    
                
           }
           return  $result;
        
        
    }
    
    
}
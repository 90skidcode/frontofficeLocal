<?php

class Frontoffice
{
    function insert_reservation($values,$conn){
        
        
        $check_res_sql = "SELECT reservation_no from reservation_master_new WHERE reservation_no='".$values['reservation_no']."'";
        $result_details = $conn->query($check_res_sql);
        $row_res_available = $result_details->fetch_all(MYSQLI_ASSOC);
        
        if ($result_details->num_rows > 0) {
            	$row = array();
            	echo json_encode(array("message"=>"Already Exist","status_code"=>200,"result"=>$row));
             exit;
        }

       
        $master_insert =array();$details_insert = array();
        $master_insert['reservation_no'] = $values['reservation_no'];
        $master_insert['customer_id'] = $values['customer_id'];
        $master_insert['total_beforetax'] = $values['total_beforetax'];
       /* $master_insert['tax_cgst_percentage'] = $values['tax_cgst_percentage'];
        $master_insert['tax_sgst_percentage'] = $values['tax_cgst_percentage'];
        $master_insert['sgst'] = $values['sgst'];
        $master_insert['cgst'] = $values['cgst'];*/
        
        $master_insert['total_taxamount'] = $values['total_taxamount'];
        $master_insert['total_amount'] = $values['total_amount'];
        $master_insert['total_discount'] = $values['total_discount'];
        $master_insert['reservation_type'] = $values['reservation_type'];
        $master_insert['travel_agency_id'] = $values['travel_agency_id'];
        $master_insert['travel_agency_transaction_no'] = $values['travel_agency_transaction_no'];
        $master_insert['meal_plan_id'] = $values['meal_plan_id'];
        $master_insert['meal_price'] = $values['meal_price'];
        $master_insert['meal_count'] = $values['meal_count'];
        $master_insert['meal_total'] = $values['meal_total'];
        $master_insert['created_by'] = $values['created_by'];
        $master_insert['advance'] = $values['advance'];
        $master_insert['reservation_status'] = "A";
        $master_insert['remarks'] = $values['remarks'];
        $master_insert['tracking_id'] = rand();
        
        $advance_insert['payment_mode'] = $values['payment_mode'];
        
        foreach($master_insert as $key => $qty){
    	   $table_key .= $key.",";
    	   $table_value .= "'".$qty."'".",";
    	}
    
    	$table_key 		= rtrim($table_key, ',');
    	$table_value 	= rtrim($table_value, ',');
    	
     $sql = "INSERT INTO reservation_master_new  (".$table_key.") VALUES (".$table_value.")";
     
        if ($conn->query($sql)) {
            
             $i=0;
        	    foreach($values['hotel_from_date'] as $details)
        	    {
        	      
        	     $detail_sql = "INSERT INTO reservation_master_detail (reservation_no,room_category,hotel_no_of_night,hotel_from_date,hotel_to_date,hotel_no_of_rooms,hotel_no_of_adults,hotel_no_of_childs,hotel_price,room_total,hotel_discount,discount_amount,room_cgst,room_sgst,tracking_id)
        	      VALUES ('".$values['reservation_no']."',".$values['room_category'][$i].",".$values['hotel_no_of_night'][$i].",'".$values['hotel_from_date'][$i]."','".$values['hotel_to_date'][$i]."',".$values['hotel_no_of_rooms'][$i].",".$values['hotel_no_of_adults'][$i].",".$values['hotel_no_of_childs'][$i].",".$values['hotel_price'][$i].",".$values['room_total'][$i].",".$values['hotel_discount'][$i].",".$values['discount_amount'][$i].",".$values['room_cgst'][$i].",".$values['room_sgst'][$i].",".$master_insert['tracking_id'].")";
        	      $result= $conn->query($detail_sql);
        	       
        	    $i++;}
    		 
    		   if($values['advance'])
    		   {
    		       
    		        $advance_no = "";
                    $get_last_invoice_sql = "select advance_no from advance_master order by advance_master_id DESC limit 1";  
                    $result_count = $conn->query($get_last_invoice_sql);
                    $row_count = $result_count->fetch_all(MYSQLI_ASSOC);
                    $val_invoice =  explode(',',$row_count[0]['advance_no']);
                    
                    if(!empty($val_invoice[0]))
                    {
                    $invoice_split = explode("V",$val_invoice[0]);
                    $invoice_val = $invoice_split[1] + 1;
                    $advance_no = "ADV".+$invoice_val; 
                    }
                    else{
                    $advance_no ="ADV100001";
                    }
                    
                    $advance_sql = "INSERT INTO advance_master (advance_no,advance_amount,advance_type,payment_mode,status,process_no,customer_id,created_by)  VALUES ('".$advance_no."',".$values['advance'].",'R',".$values['payment_mode'].",'1','".$values['reservation_no']."',".$values['customer_id'].",'".$values['created_by']."')";
                    $advance_result= $conn->query($advance_sql);
    		        
                }
    		  
    		    if($result){
        		    echo json_encode(array("message"=>"success","status_code"=>200));
        		}else{
        		    
        		    echo json_encode(array("message"=>"Failed in details","status_code"=>400));
        		}
    	}else{
    		
    	   echo json_encode(array("message"=>"Failed in master","status_code"=>400));
    	}
        
        
    }
    
    function insert_booking($values,$conn){
        
        
        $check_res_sql = "SELECT booking_no from booking_master_new WHERE booking_no='".$values['booking_no']."'";
        $result_details = $conn->query($check_res_sql);
        $row_res_available = $result_details->fetch_all(MYSQLI_ASSOC);
        if ($result_details->num_rows > 0) {
            	$row = array();
            	echo json_encode(array("message"=>"Already Exist","status_code"=>200,"result"=>$row));
             exit;
        }
        
        
        // generate booking no:
        $booking_no = "";
        $get_last_booking_sql = "select booking_no from booking_master_new order by booking_master_id DESC limit 1";  
        $result_booking_count = $conn->query($get_last_booking_sql);
        $row_booking_count = $result_booking_count->fetch_all(MYSQLI_ASSOC);
        $val_booking =  explode(',',$row_booking_count[0]['booking_no']);
        
        if(!empty($val_booking[0]))
        {
        $booking_split = explode("K",$val_booking[0]);
        $booking_val = $booking_split[1] + 1;
        $booking_no = "CHK".+$booking_val; 
        }
        else{
        $booking_no ="CHK1";
        }
         
        $master_insert =array();$details_insert = array();
        $master_insert['reservation_no'] = $values['reservation_no'];
        $master_insert['booking_no'] = $booking_no;
        $master_insert['customer_id'] = $values['customer_id'];
        $master_insert['total_beforetax'] = $values['total_beforetax'];
       /* $master_insert['sgst'] = $values['sgst'];
        $master_insert['cgst'] = $values['cgst'];*/
        $master_insert['total_taxamount'] = $values['total_taxamount'];
       /* $master_insert['tax_cgst_percentage'] = $values['tax_cgst_percentage'];
        $master_insert['tax_sgst_percentage'] = $values['tax_sgst_percentage'];*/
        $master_insert['total_amount'] = $values['total_amount'];
        $master_insert['total_discount'] = $values['total_discount'];
        $master_insert['booking_type'] = $values['booking_type'];
        $master_insert['hotel_charges_for_extra_bed'] = $values['hotel_charges_for_extra_bed'];
        $master_insert['travel_agency_id'] = $values['travel_agency_id'];
        $master_insert['travel_agency_transaction_no'] = $values['travel_agency_transaction_no'];
        $master_insert['meal_plan_id'] = $values['meal_plan_id'];
        $master_insert['meal_price'] = $values['meal_price'];
              $master_insert['meal_count'] = $values['meal_count'];
        $master_insert['meal_total'] = $values['meal_total'];
        $master_insert['advance'] = $values['advance'];
        $master_insert['booking_documents'] = $values['booking_documents'];
        $master_insert['remarks'] = $values['remarks'];
        $master_insert['booking_status'] = "A";
        $master_insert['created_by'] = $values['created_by'];
        $master_insert['tracking_id'] = rand();
        
        
        
        foreach($master_insert as $key => $qty){
    	   $table_key .= $key.",";
    	   $table_value .= "'".$qty."'".",";
    	}
    
    	$table_key 		= rtrim($table_key, ',');
    	$table_value 	= rtrim($table_value, ',');
    	
        $sql = "INSERT INTO booking_master_new  (".$table_key.") VALUES (".$table_value.")";
      
        
        if ($conn->query($sql)) {
             $i=0;
        	    foreach($values['hotel_from_date'] as $details)
        	    {
        	      
        	     $detail_sql = "INSERT INTO booking_master_detail (booking_no,room_category,hotel_no_of_night,hotel_from_date,hotel_to_date,room_no,hotel_no_of_adults,hotel_no_of_childs,hotel_no_of_extra_bed,hotel_price,hotel_discount,room_status,discount_amount,room_total,room_cgst,room_sgst,tracking_id)
        	      VALUES ('".$booking_no."',".$values['room_category'][$i].",".$values['hotel_no_of_night'][$i].",'".$values['hotel_from_date'][$i]."','".$values['hotel_to_date'][$i]."','".$values['room_no'][$i]."',".$values['hotel_no_of_adults'][$i].",".$values['hotel_no_of_childs'][$i].",".$values['hotel_no_of_extra_bed'][$i].",".$values['hotel_price'][$i].",".$values['hotel_discount'][$i].",'I',".$values['discount_amount'][$i].",'".$values['room_total'][$i]."',".$values['room_cgst'][$i].",".$values['room_sgst'][$i].",'".$master_insert['tracking_id']."')";
        	       
        	      $result= $conn->query($detail_sql);
        	      
        	      
        	        $update_room_sql = "UPDATE room_master SET current_status ='IH' WHERE room_no ='".$values['room_no'][$i]."' ";
    		        $update_reservation_result= $conn->query($update_room_sql);
        	       
        	        //customer Ledger 
                    
                   // Per Day calculation
                   $value1 = ($values['hotel_price'][$i] / 100) * $values['hotel_discount'][$i];
                   
                   $total_gst = $values['room_sgst'][$i] + $values['room_cgst'][$i];
                   $value2 = $values['hotel_price'][$i] - $value1;
                   $value3 = ($value2 / 100) * $total_gst;
                   $value4 = $value2 + $value3;
                   
                   
                   
                   $ledger_insert_sql = "INSERT INTO customer_ledger (booking_no,room_no,income_type,amount,income_date,payment_type,status,created_by)  VALUES ('".$booking_no."','".$values['room_no'][$i]."','Booking','".$value4."','".$values['hotel_from_date'][$i]."','".$values['payment_mode']."','1','".$values['created_by']."')";
         
                   $ledger_insert_result= $conn->query($ledger_insert_sql); 
        	       
        	       
        	       
        	    $i++;}
        	    
        	    
        	   if($values['reservation_no']){
        	       
        	        $update_reservation_sql = "UPDATE reservation_master_new SET reservation_status ='B',booking_no='".$booking_no."' WHERE reservation_no ='".$values['reservation_no']."' ";
        		    $update_reservation_result= $conn->query($update_reservation_sql);
        		    
        		    
        		    $get_reservationadvance_sql = "select * from advance_master WHERE process_no='".$values['reservation_no']."' AND status=1";  
                    $result_reservationadvance_count = $conn->query($get_reservationadvance_sql);
                    $row_reservationadvance_count = $result_reservationadvance_count->fetch_all(MYSQLI_ASSOC);
                    if($row_reservationadvance_count){
                        
                        foreach($row_reservationadvance_count as $res_adv)
                        {
                            $ledger_insert_sql_revadv = "INSERT INTO customer_ledger (booking_no,room_no,income_type,amount,income_date,payment_type,status,created_by,bill_no,created_at)  
                            VALUES ('".$booking_no."','".$values['room_no'][0]."','Advance','".$res_adv['advance_amount']."','".$res_adv['created_at']."','".$res_adv['payment_mode']."','1','".$res_adv['created_by']."','".$res_adv['advance_no']."','".$res_adv['created_at']."')";
                            $ledger_insert_result_revadv = $conn->query($ledger_insert_sql_revadv);
                        }
                    }
                    
        	       
        	       
        	   }
        	   else{
        	       
        	       if($values['advance'])
    		        {
    		        $advance_no = "";
                    $get_last_invoice_sql = "select advance_no from advance_master order by advance_master_id DESC limit 1";  
                    $result_count = $conn->query($get_last_invoice_sql);
                    $row_count = $result_count->fetch_all(MYSQLI_ASSOC);
                    $val_invoice =  explode(',',$row_count[0]['advance_no']);
                    
                    if(!empty($val_invoice[0]))
                    {
                    $invoice_split = explode("V",$val_invoice[0]);
                    $invoice_val = $invoice_split[1] + 1;
                    $advance_no = "ADV".+$invoice_val; 
                    }
                    else{
                    $advance_no ="ADV100001";
                    }
                    
                    $advance_sql = "INSERT INTO advance_master (advance_no,advance_amount,advance_type,payment_mode,status,process_no,customer_id,created_by)  VALUES ('".$advance_no."',".$values['advance'].",'B',".$values['payment_mode'].",'1','".$values['booking_no']."',".$values['customer_id'].",'".$values['created_by']."')";
                    $advance_result= $conn->query($advance_sql);
                    
                     $ledger_insert_sql_adv = "INSERT INTO customer_ledger (booking_no,room_no,income_type,amount,income_date,payment_type,status,created_by,bill_no)  VALUES ('".$booking_no."','".$values['room_no'][0]."','Advance','".$values['advance']."','".$values['hotel_from_date'][0]."','".$values['payment_mode']."','1','".$values['created_by']."','".$advance_no."')";
         
                   $ledger_insert_result_adv = $conn->query($ledger_insert_sql_adv);
    		    }
    		    
        	   }
        	    
        	   if($values['reservation_no']){
    		   $update_reservation_sql = "UPDATE reservation_master_new SET reservation_status ='B',booking_no='".$booking_no."' WHERE reservation_no ='".$values['reservation_no']."' ";
    		   $update_reservation_result= $conn->query($update_reservation_sql);
    		   
    		   }
    		
    		    if($result){
        		    echo json_encode(array("message"=>"success","status_code"=>200));
        		}else{
        		    
        		    echo json_encode(array("message"=>"Failed in details","status_code"=>400));
        		}
    	}else{
    		
    	   echo json_encode(array("message"=>"Failed in master","status_code"=>400));
    	}
        
        
    }
    
    function ledger_booking_insert($values,$conn){
      
        $master_insert['booking_no'] = $values['booking_no'];
        $master_insert['room_no'] = $values['room_no'];
        $master_insert['room_category'] = $values['room_category'];
        $master_insert['hotel_no_of_night'] = $values['hotel_no_of_night'];
        $master_insert['hotel_from_date'] = $values['hotel_from_date'];
        $master_insert['hotel_to_date'] = $values['hotel_to_date'];
        $master_insert['hotel_no_of_adults'] = $values['hotel_no_of_adults'];
        $master_insert['hotel_no_of_childs'] = $values['hotel_no_of_childs'];
        $master_insert['hotel_no_of_extra_bed'] = $values['hotel_no_of_extra_bed'];
        $master_insert['hotel_price'] = $values['hotel_price'];
        $master_insert['room_cgst'] = $values['hotel_cgst'];
        $master_insert['room_sgst'] = $values['hotel_sgst'];
        $master_insert['hotel_discount'] = $values['hotel_discount'];
        $master_insert['discount_amount'] = $values['discount_amount'];
        $master_insert['room_total'] = $values['room_total'];
        
        foreach($master_insert as $key => $qty){
    	   $table_key .= $key.",";
    	   $table_value .= "'".$qty."'".",";
    	}
    
    	$table_key 		= rtrim($table_key, ',');
    	$table_value 	= rtrim($table_value, ',');
    	
        $sql = "INSERT INTO booking_master_detail  (".$table_key.") VALUES (".$table_value.")";
        $result= $conn->query($sql);
        
        // Update Room as In House	      
        $update_room_sql = "UPDATE room_master SET current_status ='IH' WHERE room_no ='".$values['room_no']."' ";
        $update_reservation_result= $conn->query($update_room_sql);
        
        // Per Day calculation
        $value1 = ($values['hotel_price'] / 100) * $values['hotel_discount'];
        $total_gst = $values['hotel_sgst'] + $values['hotel_cgst'];
        $value2 = $values['hotel_price'] - $value1;
        $value3 = ($value2 / 100) * $total_gst;
        $value4 = $value2 + $value3;
       
        $ledger_insert_sql = "INSERT INTO customer_ledger (booking_no,room_no,income_type,amount,income_date,status,created_by)  VALUES ('".$values['booking_no']."','".$values['room_no']."','Booking','".$value4."','".$values['hotel_from_date']."','1','".$values['created_by']."')";
        $ledger_insert_result= $conn->query($ledger_insert_sql);
        
        if($ledger_insert_result){
        	 echo json_encode(array("message"=>"success","status_code"=>200));
		}else{
		    
		    echo json_encode(array("message"=>"Failed in details","status_code"=>400));
		}
    }
    function miscellaneous_insert($values,$conn){
    
        // miscellaneous Table
        $master_insert['miscellaneous_expenses'] = $values['miscellaneous_expenses'];
        $master_insert['miscellaneous_amount'] = $values['miscellaneous_amount'];
        $master_insert['miscellaneous_cgst'] = $values['miscellaneous_cgst'];
        $master_insert['miscellaneous_sgst'] = $values['miscellaneous_sgst'];
        $master_insert['miscellaneous_total'] = $values['miscellaneous_total'];
        $master_insert['miscellaneous_payment_type'] = $values['miscellaneous_payment_type'];
        $master_insert['status'] = 1;
        $master_insert['created_by'] = $values['created_by'];
        $table_name_master = "miscellaneous_expenses";
        
        $miscellaneous_expenses_id =  $this->insert_class($table_name_master,$master_insert,$conn);
        
        if($miscellaneous_expenses_id)
        {
            // Customer Ledger
            $customer_ledger['booking_no'] = $values['booking_no'];
            $explode_room = explode(',',$values['room_no']);
            $customer_ledger['room_no'] = $explode_room[0]; 
            $customer_ledger['income_type'] = "Miscellaneous";
            $customer_ledger['description'] = $values['miscellaneous_expenses'];
            $customer_ledger['amount'] = $values['miscellaneous_total'];
            $customer_ledger['income_date'] = date("Y-m-d");
            $customer_ledger['payment_type'] = $values['miscellaneous_payment_type'];
            $customer_ledger['bill_no'] = $miscellaneous_expenses_id;
            $customer_ledger['status'] = 1;
            $customer_ledger['created_by'] = $values['created_by'];
            $table_name = "customer_ledger";
            
            $insert_result_id =  $this->insert_class($table_name,$customer_ledger,$conn);
            if($insert_result_id){
        	 echo json_encode(array("message"=>"success","status_code"=>200));
		    }else{
		    
		    echo json_encode(array("message"=>"Failed in Customer Ledger","status_code"=>400));
		}
            
        }
        else{
            echo json_encode(array("message"=>"Failed in Miscellaneous","status_code"=>400));
        }
    
    }
    
    function insert_class($table,$master_insert,$conn){
         global $result_id;
        
        foreach($master_insert as $key => $qty){
    	   $table_key .= $key.",";
    	   $table_value .= "'".$qty."'".",";
    	}
    
    	$table_key 		= rtrim($table_key, ',');
    	$table_value 	= rtrim($table_value, ',');
    	
     $sql = "INSERT INTO ".$table."  (".$table_key.") VALUES (".$table_value.")";
        $result = $conn->query($sql);
         $conn->insert_id;
        return $result_id =   $conn->insert_id;
        
    }
    
    function insert_advance($values,$conn){
        
        if($values['booking_no']){
            $values['advance_no'] = $values['booking_no'];
            $values['advance_type'] = 'B';
            $table_name = "booking_master_new";
            $where = "booking_no";
            
        } 
        if($values['reservation_no']){
            $values['advance_no'] = $values['reservation_no'];
            $values['advance_type'] = 'R';
            $table_name = "reservation_master_new";
            $where = "reservation_no";
            
        }
        
        // Select sum amount
        $advance_sql = "SELECT COALESCE(SUM(`advance_amount`),0) as total_advance FROM advance_master WHERE `process_no` ='".$values['advance_no']."' AND status =1";
        
        //echo $advance_sql;
        $advance_result= $conn->query($advance_sql);
        $advance_row = $advance_result->fetch_all(MYSQLI_ASSOC);
        $total_advance = $advance_row[0]['total_advance'] + $values['advance'];
       
        // Update Total advance
       $update_sql = "UPDATE ".$table_name." SET  advance =".$total_advance." WHERE ".$where."='".$values['advance_no']."'";
       $advance_update_result= $conn->query($update_sql);

       $advance_no = "";
        $get_last_invoice_sql = "select advance_no from advance_master order by advance_master_id DESC limit 1";  
        $result_count = $conn->query($get_last_invoice_sql);
        $row_count = $result_count->fetch_all(MYSQLI_ASSOC);
        $val_invoice =  explode(',',$row_count[0]['advance_no']);
        
        if(!empty($val_invoice[0]))
        {
        $invoice_split = explode("V",$val_invoice[0]);
        $invoice_val = $invoice_split[1] + 1;
        $advance_no = "ADV".+$invoice_val; 
        }
        else{
        $advance_no ="ADV100001";
        }
        
        $advance_sql = "INSERT INTO advance_master (advance_no,advance_amount,advance_type,payment_mode,status,process_no,customer_id,created_by)  VALUES ('".$advance_no."',".$values['advance'].",'".$values['advance_type']."',".$values['payment_mode'].",'1','".$values['advance_no']."',".$values['customer_id'].",'".$values['created_by']."')";
                    $advance_result= $conn->query($advance_sql);
            
                if($values['booking_no']){    
                    //Customer Ledger
                     $ledger_insert_advance_sql = "INSERT INTO customer_ledger (booking_no,room_no,income_type,amount,payment_type,bill_no,status,created_by,income_date)  VALUES ('".$values['booking_no']."','".$values['room_no']."','Advance','".$values['advance']."','".$values['payment_mode']."','".$advance_no."','1','".$values['created_by']."','".$values['hotel_from_date']."')";
                
                       $ledger_insert_advance_result= $conn->query($ledger_insert_advance_sql); 
                }
        
        /* Insert advance
        $advance_insert_sql = "INSERT INTO advance_master (advance_no,advance_amount,advance_type,payment_mode,customer_id,status,invoice_no)  VALUES ('".$values['advance_no']."',".$values['advance'].",'".$values['advance_type']."',".$values['payment_mode'].",".$values['customer_id'].",'1','$invoice_no')";
      
        $advance_insert_result= $conn->query($advance_insert_sql); */

     if($advance_result){
        		    echo json_encode(array("message"=>"success","status_code"=>200));
        		}else{
        		    
        		    echo json_encode(array("message"=>"Failed in details","status_code"=>400));
        		}
        
    }
    
    
     function insert_employee($values,$conn){
      
      // Insert Employee
      $employee_insert_sql = "INSERT INTO employee_master (employee_id,employee_name,employee_dob,employee_address,employee_phone,employee_email,employee_type_id,employee_docs,status,created_by)  VALUES (".$values['employee_id'].",'".$values['employee_name']."','".$values['employee_dob']."','".$values['employee_address']."','".$values['employee_phone']."','".$values['employee_email']."',".$values['employee_type_id'].",'".$values['employee_docs']."','1',".$values['created_by'].")";
         
         $employee_insert_result= $conn->query($employee_insert_sql); 
        
        if($employee_insert_result){
            
            // insert login
            if($values['login_name'])
            {
              $login_insert_sql = "INSERT INTO login_master (login_name,login_password,employee_id,status)  VALUES ('".$values['login_name']."','".$values['login_password']."',".$values['employee_id'].",'1')";
         
                $login_insert_result= $conn->query($login_insert_sql); 
            }
            
            
                 echo json_encode(array("message"=>"success","status_code"=>200));
        		}else{
        		    
        		    echo json_encode(array("message"=>"Failed in details","status_code"=>400));
        		}
     }
     
     function insert_ledger($values,$conn){
         
         // Add Advance
        if($values['income_type'] == "Advance"){
            
        // Select sum amount
        $advance_sql = "SELECT COALESCE(SUM(`advance_amount`),0) as total_advance FROM advance_master WHERE `process_no` ='".$values['booking_id']."' AND status =1";
        
        //echo $advance_sql;
        $advance_result= $conn->query($advance_sql);
        $advance_row = $advance_result->fetch_all(MYSQLI_ASSOC);
        $total_advance = $advance_row[0]['total_advance'] + $values['amount'];
       
        // Update Total advance
       $update_sql = "UPDATE booking_master_detail SET  discount_amount =".$total_advance." WHERE booking_no='".$values['booking_id']."'";
       $advance_update_result= $conn->query($update_sql);
            
         $advance_no = "";
        $get_last_invoice_sql = "select advance_no from advance_master order by advance_master_id DESC limit 1";  
        $result_count = $conn->query($get_last_invoice_sql);
        $row_count = $result_count->fetch_all(MYSQLI_ASSOC);
        $val_invoice =  explode(',',$row_count[0]['advance_no']);
        
        if(!empty($val_invoice[0]))
        {
        $invoice_split = explode("V",$val_invoice[0]);
        $invoice_val = $invoice_split[1] + 1;
        $advance_no = "ADV".+$invoice_val; 
        }
        else{
        $advance_no ="ADV100001";
        }
        
        $advance_sql = "INSERT INTO advance_master (advance_no,advance_amount,advance_type,payment_mode,status,process_no,customer_id,created_by)  VALUES ('".$advance_no."',".$values['amount'].",'B',".$values['payment_type'].",'1','".$values['booking_id']."','".$values['customer_id']."','".$values['created_by']."')";
                    $advance_result= $conn->query($advance_sql);
                    
        } 
        
        
        if($values['income_type'] == "Advance")
        {
            $bill_no = $advance_no;
        }
        if($values['income_type'] == "Hotel")
        {
            $bill_no = $values['bill_no'];
        }
            $room_no = explode(',',$values['room_no']);
        // Insert Employee
        $ledger_insert_sql = "INSERT INTO customer_ledger (booking_no,room_no,income_type,description,amount,income_date,payment_type,bill_no,status,created_by)  VALUES ('".$values['booking_id']."','".$room_no[0]."','".$values['income_type']."','".$values['description']."','".$values['amount']."','".$values['income_date']."','".$values['payment_type']."','".$bill_no."','1','".$values['created_by']."')";
         
         $ledger_insert_result= $conn->query($ledger_insert_sql);
                    
         
         
          echo json_encode(array("message"=>"success","status_code"=>200));
         
    }
     
     function insert_audit($values,$conn){
         
         
         $check_res_sql = "SELECT night_audit_date from night_audit_master WHERE night_audit_date='".$values['night_audit_date']."' AND night_audit_status='1' ";
        $result_details = $conn->query($check_res_sql);
        $row_res_available = $result_details->fetch_all(MYSQLI_ASSOC);
        
        if ($result_details->num_rows > 0) {
            	$row = array();
            	echo json_encode(array("message"=>"Already Exist","status_code"=>200,"result"=>$row));
             exit;
        }

         
          // Insert Employee
      $audit_insert_sql = "INSERT INTO `night_audit_master` ( `night_audit_date`, `night_audit_status`, `created_by`) VALUES ('".$values['night_audit_date']."', '1', '".$values['created_by']."')";
         
         $audit_insert_result= $conn->query($audit_insert_sql); 
         
          echo json_encode(array("message"=>"success","status_code"=>200));
         
     }
     
     function insert_shift_bill($values,$conn){
         
         
        $check_res_sql = "update customer_ledger SET refer_room='".$values['refer_room']."' WHERE room_no='".$values['room_no']."' AND booking_no='".$values['booking_no']."'";
        $result_details = $conn->query($check_res_sql);
        
        $check_res_sql2 = "update customer_ledger SET refer_room='".$values['refer_room']."' WHERE refer_room='".$values['room_no']."' AND booking_no='".$values['booking_no']."'";
        $result_details2 = $conn->query($check_res_sql2);
        
        $check_res_sql3 = "update booking_master_new SET booking_status='P' WHERE booking_no='".$values['booking_no']."'";
        $result_details3 = $conn->query($check_res_sql3);
        
         $check_res_sql4 = "update booking_master_detail SET room_status='O' WHERE room_no='".$values['room_no']."' AND booking_no='".$values['booking_no']."'";
        $result_details4 = $conn->query($check_res_sql4);
        
         $check_res_sql5 = "update room_master SET current_status='D' WHERE room_no='".$values['room_no']."'";
        $result_details5 = $conn->query($check_res_sql5);
    
         
          echo json_encode(array("message"=>"success","status_code"=>200));
         
     }
     
     
     function insert_swap_room($values,$conn){
         
    
        $check_res_sql = "SELECT room_no FROM `room_master` WHERE current_status='A' AND status='A' AND room_no='".$values['room_no']."' ";
        $result_details = $conn->query($check_res_sql);
        $row_res_available = $result_details->fetch_all(MYSQLI_ASSOC);
        $room_no_check = $row_res_available[0]['room_no'];
        
        if($room_no_check){
            
        $tracking_id = rand();
        $detail_sql = "INSERT INTO booking_master_detail (booking_no,room_category,hotel_no_of_night,hotel_from_date,hotel_to_date,room_no,hotel_no_of_adults,hotel_no_of_childs,hotel_no_of_extra_bed,hotel_price,hotel_discount,room_status,discount_amount,room_total,tracking_id)
        	      VALUES ('".$values['booking_no']."',".$values['room_category'].",".$values['hotel_no_of_night'].",'".$values['hotel_from_date']."','".$values['hotel_to_date']."',".$values['room_no'].",".$values['hotel_no_of_adults'].",".$values['hotel_no_of_childs'].",".$values['hotel_no_of_extra_bed'].",".$values['hotel_price'].",".$values['hotel_discount'].",'".$values['room_status']."',".$values['discount_amount'].",'".$values['room_total']."','".$tracking_id."')";
        	       
        $result= $conn->query($detail_sql);
        
        // Update as swap 
        $swap_update = "UPDATE booking_master_detail SET room_status='S' WHERE booking_no='".$values['booking_no']."' AND room_no='".$values['swap_room_no']."'";
       $update_result = $conn->query($swap_update);
       
       
        $ledger_insert_sql = "INSERT INTO customer_ledger (booking_no,room_no,description,amount,income_date,bill_no,status,created_by)  VALUES ('".$values['booking_no']."','".$values['room_no']."','".$values['description']."','".$values['room_total']."','".$values['hotel_from_date']."','".$values['bill_no']."','1','".$values['created_by']."')";
         
         $ledger_insert_result= $conn->query($ledger_insert_sql);
         
          $check_res_sql5 = "update room_master SET current_status='D' WHERE room_no='".$values['swap_room_no']."'";
          $result_details5 = $conn->query($check_res_sql5);
          
           $check_res_sql6 = "update room_master SET current_status='IH' WHERE room_no='".$values['room_no']."'";
          $result_details6 = $conn->query($check_res_sql6);
        
        echo json_encode(array("message"=>"success","status_code"=>200));	      
        	      
        }else{
            $row = array();
            	echo json_encode(array("message"=>"Room Not Available","status_code"=>400,"result"=>$row));
            
        }	      
         
     }
    
}
?>
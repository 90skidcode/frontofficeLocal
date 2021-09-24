<?php

class FrontofficeUpdate
{
    
    function Update_coloum($update){
        
        foreach($update as $key => $qty){
            if (is_numeric($qty))
                $table_update_condition .= $key." = '".$qty."' , ";
            else	
                $table_update_condition .= $key." = '".$qty."' , ";
        }
    		
    	$table_update_condition_where = "";
    	if($table_update_condition){
    		$table_update_condition	= rtrim($table_update_condition, ', ');
    	return $table_update_condition_where = $table_update_condition;
    	}
    }
    
    function general_updates($data,$conn,$where_values,$like_values)
    {
        if($data['update_coloum']){
            $update_coloums = $this->Update_coloum($data['update_coloum']);
            $sql="update ".$data['table_name']." set ".$update_coloums."".$where_values;
            if ($conn->query($sql)) {
               $updated_values_count= mysqli_affected_rows($conn);
                echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
            }else{
                echo json_encode(array("message"=>"failed","status_code"=>400));
            }
        }else{
            echo json_encode(array("message"=>"Invalid coloums","status_code"=>400));
        }
    }
    
     function reservation_status_update($data,$conn)
    {
        
            $sql="UPDATE reservation_master_new SET reservation_status =".$data['reservation_status']." WHERE reservation_no=".$data['reservation_no'];
            if ($conn->query($sql)) {
               $updated_values_count= mysqli_affected_rows($conn);
                echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
            }else{
                echo json_encode(array("message"=>"failed","status_code"=>400));
            }
    }
    
     function update_ledger_booking($values,$conn)
    {
            
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
        
        $update_coloums = $this->Update_coloum($master_insert);
        $sql = "UPDATE booking_master_detail set ".$update_coloums." WHERE booking_no='".$values['booking_no']."' AND room_no='".$values['room_no']."'";
        if ($conn->query($sql)) {
            
           //Per Day calculation
           $value1 = ($values['hotel_price'] / 100) * $values['hotel_discount'];
           $total_gst = $values['hotel_cgst'] + $values['hotel_sgst'];
           $value2 = $values['hotel_price'] - $value1;
           $value3 = ($value2 / 100) * $total_gst;
           $value4 = $value2 + $value3;
           
           $customer_update['income_date'] = $values['hotel_from_date'];
           $customer_update['amount'] = $value4;
           $update_ledger = $this->Update_coloum($customer_update);
           $sql_customer = "UPDATE customer_ledger set ".$update_ledger." WHERE booking_no='".$values['booking_no']."' AND income_type='Booking' AND room_no='".$values['room_no']."' ORDER BY `customer_ledger_id` limit 1 ";
           $ledger_insert_result= $conn->query($sql_customer); 
           $updated_values_count= mysqli_affected_rows($conn);
            echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
        }else{
            echo json_encode(array("message"=>"failed","status_code"=>400));
        }
    }
    
    
     function update_advance($data,$conn)
    {
            if($data['advance_amount'])
            {
                 $sql="UPDATE advance_master SET advance_amount = ".$data['advance_amount'].", payment_mode=".$data['payment_mode']." WHERE advance_no='".$data['advance_no']."'";
                if ($conn->query($sql)) {
                    
                    $customer_ledger_sql="UPDATE customer_ledger SET amount = ".$data['advance_amount'].", payment_type=".$data['payment_mode'].", description='".$data['description']."' WHERE bill_no ='".$data['advance_no']."' ";
                    $conn->query($customer_ledger_sql);
                    
                   $updated_values_count= mysqli_affected_rows($conn);
                    echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
                }else{
                    echo json_encode(array("message"=>"failed","status_code"=>400));
                }
            }else{
                    echo json_encode(array("message"=>"Advance Amount Missing","status_code"=>400));
                }
    }
    
     function booking_extended_oneday($data,$conn)
    {
            
        $check_date = "SELECT DATE_ADD(`hotel_to_date`, INTERVAL 1 DAY) as hotel_todate from booking_master_detail WHERE  booking_no='".$data['booking_no']."' AND room_no='".$data['room_no']."'";
        $result_check_date = $conn->query($check_date);
        $row_details = $result_check_date->fetch_all(MYSQLI_ASSOC);
        $hotel_todate = $row_details[0]['hotel_todate'];
            
            
        $sql="UPDATE booking_master_detail SET hotel_to_date='".$hotel_todate."' WHERE booking_no='".$data['booking_no']."' AND room_no='".$data['room_no']."' ";
        if ($conn->query($sql)) {
           $updated_values_count= mysqli_affected_rows($conn);
            echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
        }else{
            echo json_encode(array("message"=>"failed","status_code"=>400));
        }
    }
    
    
     function update_ledger($data,$conn)
    {
        
         $customer_ledger_id = $data['customer_ledger_id']; 
         $amount = $data['amount']; 
         $payment_type = $data['payment_type'];
          
         $sql="UPDATE customer_ledger SET amount='".$amount."',payment_type='".$payment_type."' WHERE customer_ledger_id='".$data['customer_ledger_id']."'";
        if ($conn->query($sql)) {
           $updated_values_count= mysqli_affected_rows($conn);
            echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
        }else{
            echo json_encode(array("message"=>"failed","status_code"=>400));
        }
    }
    
    function ledger_status($data,$conn)
    {
        
         $customer_ledger_id = $data['customer_ledger_id']; 
         $status = $data['status']; 
          
         $sql="UPDATE customer_ledger SET status='".$status."' WHERE customer_ledger_id='".$data['customer_ledger_id']."'";
        if ($conn->query($sql)) {
           $updated_values_count= mysqli_affected_rows($conn);
            echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
        }else{
            echo json_encode(array("message"=>"failed","status_code"=>400));
        }
    }
    
    
    function booking_room_delete($data,$conn)
    {
        $customer_ledger_id = $data['booking_no']; 
         
        $where = (empty($data['room_no'])) ? "WHERE booking_no='".$data['booking_no']."'" : "WHERE booking_no='".$data['booking_no']."' AND room_no='".$data['room_no']."'" ;
        
        if(empty($data['room_no']))
        {
            $master_sql="UPDATE booking_master_new SET booking_status='D' ".$where;
            $conn->query($master_sql);
        }
            $sql="UPDATE booking_master_detail SET room_status='A' ".$where;
         
            if ($conn->query($sql)) {
               $updated_values_count= mysqli_affected_rows($conn);
               if(empty($data['room_no'])) 
                {
                    $check_booking = "SELECT GROUP_CONCAT(`room_no`) as room_no FROM `booking_master_detail` WHERE booking_no='".$data['booking_no']."'";
                    $result_check_booking = $conn->query($check_booking);
                    $row_booking = $result_check_booking->fetch_all(MYSQLI_ASSOC);
                    $room_no = $row_booking[0]['room_no'];
                }else{
                    $room_no = $data['room_no'];
                }
                    $check_res_sql5 = "update room_master SET current_status='A' WHERE room_no IN (".$room_no.")";
                    $result_details5 = $conn->query($check_res_sql5);
                    
                    $check_cus_sql5 = "update customer_ledger SET status= 0 ".$where;
                    $result_cus_details5 = $conn->query($check_cus_sql5);
                    
                    echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
            }else{
                echo json_encode(array("message"=>"failed","status_code"=>400));
            }
    }
    
    
     function update_meal_plan($data,$conn)
    {
        
        $master_insert['meal_plan_id'] = $data['meal_plan_id'];
        $master_insert['meal_price'] = $data['meal_price'];
        $master_insert['meal_count'] = $data['meal_count'];
        $master_insert['meal_total'] = $data['meal_total'];
        
        $update_coloums = $this->Update_coloum($master_insert);
        $sql = "UPDATE booking_master_new set ".$update_coloums." WHERE booking_no='".$data['booking_no']."'";
        
        if ($conn->query($sql)) {
           $updated_values_count= mysqli_affected_rows($conn);
            echo json_encode(array("message"=>"success","status_code"=>200,"affected_rows"=>$updated_values_count));
        }else{
            echo json_encode(array("message"=>"failed","status_code"=>400));
        }
    }
    
    
     function checkout_final($data,$conn)
    {
        
        $where_condition =  (!empty($data['room_no'])) ? "WHERE `room_status` ='I' AND booking_no ='".$data['booking_no']."' AND room_no='".$data['room_no']."'": "WHERE `room_status` ='I' AND booking_no ='".$data['booking_no']."'";
        
        $check_booking = "SELECT GROUP_CONCAT(`room_no`) as room_no,`booking_no` FROM `booking_master_detail`".$where_condition;
        $result_check_booking = $conn->query($check_booking);
        $row_booking = $result_check_booking->fetch_all(MYSQLI_ASSOC);
        
        $room_no = $row_booking[0]['room_no'];
    
        if($room_no){
            
        if($data['room_no'])
        {
        $check_res_sql3 = "update booking_master_new SET booking_status='P' WHERE booking_no='".$data['booking_no']."'";
        $result_details3 = $conn->query($check_res_sql3);
        }else{
             $check_res_sql3 = "update booking_master_new SET booking_status='C' WHERE booking_no='".$data['booking_no']."'";
        $result_details3 = $conn->query($check_res_sql3);
        }
        
         $check_res_sql4 = "update booking_master_detail SET room_status='O' WHERE room_no IN (".$room_no.") AND booking_no='".$data['booking_no']."'";
        $result_details4 = $conn->query($check_res_sql4);
        
        $check_res_sql5 = "update room_master SET current_status='D' WHERE room_no IN (".$room_no.")";
        $result_details5 = $conn->query($check_res_sql5);
        
        
            $invoice_no = "";
            $get_last_invoice_sql = "select invoice_no from invoice_master order by invoice_master_id DESC limit 1";  
            $result_count = $conn->query($get_last_invoice_sql);
            $row_count = $result_count->fetch_all(MYSQLI_ASSOC);
            $val_invoice =  explode(',',$row_count[0]['invoice_no']);
            
            if(!empty($val_invoice[0]))
            {
            $invoice_split = explode("V",$val_invoice[0]);
            $invoice_val = $invoice_split[1] + 1;
            $invoice_no = "INV".+$invoice_val; 
            }
            else{
            $invoice_no ="INV100001";
            }
        
        $invoice_insert_sql = "INSERT INTO  invoice_master (invoice_category,invoice_no,process_no,customer_id,total_received,total_amount,payment_type,status)  VALUES ('B','".$invoice_no."','".$data['booking_no']."','".$data['customer_id']."','".$data['total_received']."','".$data['total_amount']."','".$data['payment_type']."','1')"; 
              
        $invoice_insert_result= $conn->query($invoice_insert_sql);
        
        $todate = date('Y-m-d H:i:s');
        
        $get_booking_sql = "SELECT customer_ledger.booking_no,customer_ledger.room_no,customer_ledger.income_type,SUM(customer_ledger.amount)as total_amount,COUNT(customer_ledger.amount) as no_of_nights
                                FROM customer_ledger 
                                WHERE customer_ledger.booking_no='".$data['booking_no']."' AND customer_ledger.income_type='Booking' AND customer_ledger.room_no IN (".$room_no.")
                                GROUP BY customer_ledger.room_no";  
        $result_booking_count = $conn->query($get_booking_sql);
        $row_booking_count = $result_booking_count->fetch_all(MYSQLI_ASSOC);
        
        
        foreach($row_booking_count as $booking_update)
        {
          $check_res_sql6 = "update booking_master_detail SET invoice_no='".$invoice_no."', hotel_to_date='".$todate."', room_total='".$booking_update['total_amount']."', hotel_no_of_night='".$booking_update['no_of_nights']."' WHERE room_no = '".$booking_update['room_no']."' AND booking_no='".$data['booking_no']."'";
            $result_details6 = $conn->query($check_res_sql6);
         }
        
        
        //$check_res_sql6 = "update booking_master_detail SET invoice_no='".$invoice_no."', hotel_to_date='".$todate."' WHERE room_no IN (".$room_no.") AND booking_no='".$data['booking_no']."'";
        //$result_details6 = $conn->query($check_res_sql6);
        
        echo json_encode(array("message"=>"success","status_code"=>200,"result"=>$invoice_no));
        }else{
             $row = array();
        	echo json_encode(array("message"=>"No Booking Number Found","status_code"=>400,"result"=>$row));
        }
   }
    
    
   /* function delete_advance_master($values,$conn,$where_values,$like_values)
    {
        
     $advance_master_id =  (!empty($values['advance_master_id'])) ? $values['advance_master_id']: '';
     
      if($advance_master_id)
      {
          
       $select_sql = "select * from advance_master where  advance_master_id =  ".$advance_master_id ;
        $result = $conn->query($select_sql);
         if ($result->num_rows > 0) {
         
            $row_details = $result->fetch_all(MYSQLI_ASSOC);
            $advance_amount = $row_details[0]['advance_amount'];
            $advance_type = $row_details[0]['advance_type'];
            $advance_no = $row_details[0]['advance_no'];
            
            $update_table_name =  ($advance_type == 'R') ? 'reservation_master_new': 'booking_master_new'; 
            $update_table_where =  ($advance_type == 'R') ? 'reservation_no': 'booking_no';     
            
            $update_sql = "UPDATE ".$update_table_name." SET advance = advance - ".$advance_amount." WHERE  ".$update_table_where." = '".$advance_no."' " ;
            if ($conn->query($update_sql)) {
             
             $delete_sql = "DELETE from advance_master where  advance_master_id =  ".$advance_master_id ;
             $conn->query($delete_sql);
             
            echo json_encode(array("message"=>"success","status_code"=>200));
            }else{
            echo json_encode(array("message"=>"failed","status_code"=>400));
            }
         }
        
      }
    }*/
    
    
    function delete_advance_master($values,$conn,$where_values,$like_values)
    {
        
     $advance_no =  (!empty($values['bill_no'])) ? $values['bill_no']: '';
     
      if($advance_no)
      {
          
        $select_sql = "UPDATE advance_master  SET status =0 WHERE advance_no = '".$advance_no."'" ;
         if ($conn->query($select_sql)) {
            
            $update_sql = "UPDATE customer_ledger SET status = 0 WHERE  bill_no = '".$advance_no."'" ;
            if ($conn->query($update_sql)) {
              echo json_encode(array("message"=>"success","status_code"=>200));
            }else{
                echo json_encode(array("message"=>"Failed Customer Ledger","status_code"=>400));
            }
         }else{
                echo json_encode(array("message"=>"Failed in Advance Master","status_code"=>400));
            }
        
      }else{
            echo json_encode(array("message"=>"Bill No Is Missing","status_code"=>400));
            }
    }
    
    
    
    function update_reservation($values,$conn,$where_values,$like_values)
    {
        
        $master_insert =array();$details_insert = array();
        $master_insert['reservation_no'] = $values['reservation_no'];
        $master_insert['customer_id'] = $values['customer_id'];
        $master_insert['total_beforetax'] = $values['total_beforetax'];
        $master_insert['tax_cgst_percentage'] = $values['tax_cgst_percentage'];
        $master_insert['tax_sgst_percentage'] = $values['tax_sgst_percentage'];
        $master_insert['sgst'] = $values['sgst'];
        $master_insert['cgst'] = $values['cgst'];
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
        $master_insert['reservation_status'] = "AM";
        $master_insert['created_by'] = $values['created_by'];
        $master_insert['advance'] = $values['advance'];
        $master_insert['remarks'] = $values['remarks'];
       // $master_insert['checkout_payment_mode'] = $values['checkout_payment_mode'];
      //  $master_insert['checkout_payment'] = $values['checkout_payment'];
        $master_insert['tracking_id'] = rand();
        
        
        
        $update_coloums = $this->Update_coloum($master_insert);

       $sql = "UPDATE reservation_master_new set ".$update_coloums." WHERE reservation_no='".$master_insert['reservation_no']."'"; 
       
        if ($conn->query($sql)) {
             $i=0;
             
              $del_sql = "DELETE from reservation_master_detail WHERE reservation_no='".$master_insert['reservation_no']."'";
               $conn->query($del_sql);
             
        	    foreach($values['hotel_from_date'] as $details)
        	    {
        	      
        	    $detail_sql = "INSERT INTO reservation_master_detail (reservation_no,room_category,hotel_no_of_night,hotel_from_date,hotel_to_date,hotel_no_of_rooms,hotel_no_of_adults,hotel_no_of_childs,hotel_price,room_total,hotel_discount,discount_amount,room_cgst,room_sgst,tracking_id)
        	      VALUES ('".$values['reservation_no']."',".$values['room_category'][$i].",".$values['hotel_no_of_night'][$i].",'".$values['hotel_from_date'][$i]."','".$values['hotel_to_date'][$i]."',".$values['hotel_no_of_rooms'][$i].",".$values['hotel_no_of_adults'][$i].",".$values['hotel_no_of_childs'][$i].",".$values['hotel_price'][$i].",".$values['room_total'][$i].",".$values['hotel_discount'][$i].",".$values['discount_amount'][$i].",".$values['room_cgst'][$i].",".$values['room_sgst'][$i].",".$master_insert['tracking_id'].")";
        	       
        	      $result= $conn->query($detail_sql);
        	       
        	    $i++;}
    		
        		if($result){
        		    echo json_encode(array("message"=>"success","status_code"=>200));
        		}else{
        		    
        		    echo json_encode(array("message"=>"Failed in details","status_code"=>400));
        		}
    	}else{
    		
    	   echo json_encode(array("message"=>"Failed in master","status_code"=>400));
    	}
        
    }
    
    
    function update_booking($values,$conn,$where_values,$like_values)
    {
        $master_insert =array();$details_insert = array();
        $master_insert['reservation_no'] = $values['reservation_no'];
        $master_insert['booking_no'] = $values['booking_no'];
        $master_insert['customer_id'] = $values['customer_id'];
         $master_insert['sgst'] = $values['sgst'];
        $master_insert['cgst'] = $values['cgst'];
        $master_insert['total_taxamount'] = $values['total_taxamount'];
        $master_insert['total_beforetax'] = $values['total_beforetax'];
        $master_insert['tax_cgst_percentage'] = $values['tax_cgst_percentage'];
        $master_insert['tax_sgst_percentage'] = $values['tax_sgst_percentage'];
        $master_insert['total_amount'] = $values['total_amount'];
        $master_insert['total_discount'] = $values['total_discount'];
        $master_insert['booking_type'] = $values['booking_type'];
        $master_insert['hotel_charges_for_extra_bed'] = $values['hotel_charges_for_extra_bed'];
        $master_insert['advance'] = $values['advance'];
        $master_insert['meal_plan_id'] = $values['meal_plan_id'];
        $master_insert['meal_price'] = $values['meal_price'];
        $master_insert['meal_count'] = $values['meal_count'];
        $master_insert['meal_total'] = $values['meal_total'];
        $master_insert['remarks'] = $values['remarks'];
        $master_insert['booking_status'] = $values['booking_status'];
        $master_insert['created_by'] = $values['created_by'];
        $master_insert['tracking_id'] = rand();
        
        $update_coloums = $this->Update_coloum($master_insert);

      $sql = "UPDATE booking_master_new set ".$update_coloums." WHERE booking_no='".$master_insert['booking_no']."'"; 
        if ($conn->query($sql)) {
             $i=0;
            $del_sql = "DELETE from booking_master_detail WHERE booking_no='".$master_insert['booking_no']."'";
               $conn->query($del_sql);
               
        	    foreach($values['hotel_from_date'] as $details)
        	    {
        	        
        	       
        	     $detail_sql = "INSERT INTO booking_master_detail (booking_no,room_category,hotel_no_of_night,hotel_from_date,hotel_to_date,room_no,hotel_no_of_adults,hotel_no_of_childs,hotel_no_of_extra_bed,hotel_price,hotel_discount,room_status,discount_amount,room_total,room_cgst,room_sgst,tracking_id)
        	      VALUES ('".$values['booking_no']."',".$values['room_category'][$i].",".$values['hotel_no_of_night'][$i].",'".$values['hotel_from_date'][$i]."','".$values['hotel_to_date'][$i]."',".$values['room_no'][$i].",".$values['hotel_no_of_adults'][$i].",".$values['hotel_no_of_childs'][$i].",".$values['hotel_no_of_extra_bed'][$i].",".$values['hotel_price'][$i].",".$values['hotel_discount'][$i].",'".$values['room_status'][$i]."',".$values['discount_amount'][$i].",'".$values['room_total'][$i]."',".$values['room_cgst'][$i].",".$values['room_sgst'][$i].",'".$master_insert['tracking_id']."')";
        	       
        	      $result= $conn->query($detail_sql);
        	      
        	      
        	      if($values['room_status'][$i] != "I")
        	      {
        	       $update_room_sql = "UPDATE room_master SET current_status ='D' WHERE room_no ='".$values['room_no'][$i]."' ";
    		        $update_reservation_result= $conn->query($update_room_sql);
        	      }
        	       
        	    $i++;}
        	    
        	     if($values['booking_no']){
    		   $update_reservation_sql = "UPDATE  booking_master_new SET booking_status ='AM' WHERE booking_no ='".$values['booking_no']."' ";
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
    
     function update_miscellaneous($values,$conn)
    {
       
        // miscellaneous Table
        $miscellaneous_expenses_id = $values['miscellaneous_expenses_id'];
        $master_insert['miscellaneous_expenses'] = $values['miscellaneous_expenses'];
        $master_insert['miscellaneous_amount'] = $values['miscellaneous_amount'];
        $master_insert['miscellaneous_cgst'] = $values['miscellaneous_cgst'];
        $master_insert['miscellaneous_sgst'] = $values['miscellaneous_sgst'];
        $master_insert['miscellaneous_total'] = $values['miscellaneous_total'];
        $master_insert['miscellaneous_payment_type'] = $values['miscellaneous_payment_type'];
        
        $update_coloums = $this->Update_coloum($master_insert);

        $sql = "UPDATE miscellaneous_expenses set ".$update_coloums." WHERE miscellaneous_expenses_id='".$miscellaneous_expenses_id."'";
        if($conn->query($sql))
        {
            $customer_ledger['description'] = $values['miscellaneous_expenses'];
            $customer_ledger['amount'] = $values['miscellaneous_total'];
            $customer_ledger['income_date'] = date("Y-m-d");
            $customer_ledger['payment_type'] = $values['miscellaneous_payment_type'];
             $miscellaneous_expenses_id;
            
            $update_coloums = $this->Update_coloum($customer_ledger);
            
            $sql_customer_ledger = "UPDATE customer_ledger set ".$update_coloums." WHERE bill_no='".$miscellaneous_expenses_id."' AND income_type='Miscellaneous'";
            if($conn->query($sql_customer_ledger))
            {
                echo json_encode(array("message"=>"success","status_code"=>200));
            }else{
                echo json_encode(array("message"=>"Failed in Customer Ledger","status_code"=>400));
            }
        }else{
                echo json_encode(array("message"=>"Failed in ","status_code"=>400));
            }
     
    }
    
    



}
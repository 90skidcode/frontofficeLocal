<?php
header('Access-Control-Allow-Origin: *');
error_reporting(0);
include("connection.php");
require_once("service_add.php");
require_once("service_select.php");
require_once("service_update.php");
$insert_class = new Frontoffice;
$select_class = new FrontofficeSelect;
$update_class = new FrontofficeUpdate;

$json = json_encode($_REQUEST); 
// $json = '{ "list_key": "SwapRoom","booking_no": "CHK2","room_category": "1","hotel_no_of_night": "2","hotel_from_date": "2021-07-11 12:42:00","hotel_to_date": "2021-07-13 12:42:00","room_no": "101","hotel_no_of_adults": "1","hotel_no_of_childs": "1","hotel_no_of_extra_bed": "1","hotel_price": "1","hotel_discount": "1","room_status": "1","discount_amount": "6000","room_total": "7170","swap_room_no": "105","created_by":"10008"}';
 
// $json = ' {"room_category":"1","hotel_no_of_night":"1","swap_room_no":"103","hotel_from_date":"2021-07-13T10:59","hotel_to_date":"2021-07-14T10:59","room_no":"102","hotel_no_of_adults":"2","hotel_no_of_childs":"2","hotel_no_of_extra_bed":"0","hotel_price":"2000","hotel_discount":"10","discount_amount":"200","hotel_cgst":"2.5","hotel_sgst":"2.5","room_total":"1890","status":"1","created_by":"1","list_key":"SwapRoom","booking_no":"CHK2","room_status":"1"}';

if(!empty($json)){
    $data = json_decode($json,true);
    if (is_null($data)) {
      echo json_encode(array("message"=>"Not a proper Json values","status_code"=>400));
    }else{
        
       if(!empty($data['list_key'])){
            $where_values = (!empty($data['condition'])) ? whereCondition($data['condition']) :'';
            $like_values = (!empty($data['like'])) ? likeCondition($data['like'],$where_values) :'';
            $limit_values =(!empty($data['limit'])) ? limitCondition($data['limit']):"";

           switch($data['list_key'])
           {
             
            case "general_update":
                     $result = $update_class->general_updates($data,$conn,$where_values,$like_values);
            break;
            
             case "remove_advance":
                 
                     $result = $update_class->delete_advance_master($data,$conn,$where_values,$like_values);
            break;
            
            case "UpdateReservationStatus":
                 
                     $result = $update_class->reservation_status_update($data,$conn);
            break;
            
            case "UpdateBookingExtended":
                 
                     $result = $update_class->booking_extended_oneday($data,$conn);
            break;
            
             case "FinalCheckout":
                 
                     $result = $update_class->checkout_final($data,$conn);
            break;
            
            case "reservation_update":
                     $result = $update_class->update_reservation($data,$conn,$where_values,$like_values);
            break;
            
            case "booking_update":
                     $result = $update_class->update_booking($data,$conn,$where_values,$like_values);
            break;
            
            case "ledgerUpdate":
                     $result = $update_class->update_ledger($data,$conn);
            break;
            
            case "ledgerStatus":
                     $result = $update_class->ledger_status($data,$conn);
            break;
            
            case "updateAdvance":
                     $result = $update_class->update_advance($data,$conn);
            break;
            
             case "updateBooking":
                     $result = $update_class->update_ledger_booking($data,$conn);
            break;
            
              case "updateMeal":
                    $result = $update_class->update_meal_plan($data,$conn);
            break;
            
            case "MiscellaneousUpdate":
                    $result = $update_class->update_miscellaneous($data,$conn);
            break;
            
            case "DeleteBookingLedger":
                     $result = $update_class->booking_room_delete($data,$conn);
            break;
            
            case "reservation_room_insert":
                     $result = $insert_class->insert_reservation($data,$conn);
            break;
            
            case "LedgerBookingInsert":
                     $result = $insert_class->ledger_booking_insert($data,$conn);
            break;
            
             case "SwapRoom":
                     $result = $insert_class->insert_swap_room($data,$conn);
            break;
            
            case "advance_insert":
                     $result = $insert_class->insert_advance($data,$conn);
            break;
            
             case "MiscellaneousInsert":
                     $result = $insert_class->miscellaneous_insert($data,$conn);
            break;
            
            case "employee_insert":
                     $result = $insert_class->insert_employee($data,$conn);
            break;
            
            case "Addledger":
                     $result = $insert_class->insert_ledger($data,$conn);
            break;
            
             case "Shiftbill":
                     $result = $insert_class->insert_shift_bill($data,$conn);
            break;
            
            case "upload_master_files":
                     $result = $insert_class->master_upload_files($data);
            break;
            
             case "check_room_booking_available":
                     $result = $select_class->get_avail_rooms($data,$conn);
            break;
            
             case "get_invoice_details":
                     $result = $select_class->get_adv_details($data,$conn);
            break;
            
            case "reservation_detail":
                     $result = $select_class->get_reservation_detail($data,$conn);
            break;
            
            case "advance_detail":
                     $result = $select_class->get_advance_detail($data,$conn);
            break;
            
             case "print_advance_detail":
                 
                    $result = $select_class->get_list_advance_print($data,$conn);
            break;
            
             case "get_advance_detail":
                 
                     $result = $select_class->get_list_advance($data,$conn);
            break;
            
             case "Nightaudit":
                     $result = $select_class->check_night_audit($data,$conn);
            break;
            
             case "CloseNightaudit":
                     $result = $select_class->close_night_audit($data,$conn);
            break;
            
             case "get_ledger":
                
                    $result = $select_class->get_customer_ledger($data,$conn,$where_values);
            break;
            
           
            
            case "list_reservation":
                     $result = $select_class->get_list_reservation($data,$conn);
            break;
            
            case "list_booking":
                     $result = $select_class->get_list_booking($data,$conn);
            break;
            
             case "calander_check":
                     $result = $select_class->calander_availablity($data,$conn);
            break;
            
            case "booking_detail":
                     $result = $select_class->get_booking_detail_invoice($data,$conn);
            break;
            
             case "booking_detail_ledger":
                     $result = $select_class->get_booking_detail_ledger($data,$conn);
            break;
            
            case "master_login":
                     $result = $select_class->get_login_details($data,$conn);
            break;
            
            case "get_dashboard":
                     $result = $select_class->get_normal_dashboard($data,$conn);
            break;
            
            case "GetNightaudit":
                     $result = $select_class->night_audit_date($data,$conn);
            break;
            
            case "get_ledger_list":
                     $result = $select_class->customer_ledger_list($data,$conn);
            break;
            
             case "get_admin_dashboard":
                     $result = $select_class->get_admin_dashboard($data,$conn);
            break;
            
            case "get_reservation_details":
                     $result = $select_class->get_reservation($data,$conn,$where_values,$like_values,$limit_values);
            break;
            
            case "CloseAudit":
                     $result = $insert_class->insert_audit($data,$conn);
            break;
            
            
            case "add_resrvation_detail":
                     $result = $insert_class->insert_reservation($data,$conn);
            break;
            
            case "booking_room_insert":
                     $result = $insert_class->insert_booking($data,$conn);
            break;
            
            case "room_availabilty_datewise":
                      $result = $select_class->roomcheckAvail($data,$conn,$where_values,$like_values,$limit_values);
            break;
            
            case "list_room_master":
                    $result = $select_class->roomMaster($data,$conn,$where_values,$like_values,$limit_values);
            break;
            
            case "list_general_tables":
                    $result = $select_class->generalMaster($data,$conn,$where_values,$like_values,$limit_values);
            break;
            
            case "list_expenses_tables":
                  $result = $select_class->expensesMaster($data,$conn,$where_values,$like_values,$limit_values);
            break;
    
            default:
                $result = "invalud argument";
           }
           
           return  $result;
       }else{
            echo json_encode(array("message"=>"Invalid Json","status_code"=>404));
       }
       
    }
}else{   
        echo json_encode(array("message"=>"No post values","status_code"=>404));
}


function whereCondition($where){
    
    foreach($where as $key => $qty){
        if (is_numeric($qty))
            $table_update_condition .= $key." = '".$qty."' AND ";
        else	
            $table_update_condition .= $key." = '".$qty."' AND ";
    }
		
	$table_update_condition_where = "";
	if($table_update_condition){
		$table_update_condition	= rtrim($table_update_condition, 'AND ');
	return $table_update_condition_where = " WHERE ".$table_update_condition;
	}
}

function likeCondition($like,$where){
    
        $like_key= array_keys($like);
        $where_condition =  (!empty($where)) ? " AND " : " WHERE ";
        return $table_like = $where_condition.$like_key[0]." LIKE '%".$like[$like_key[0]]."%'";
}

function limitCondition($like){
    
       
        return $table_like = " LIMIT ".$like;
}
?>
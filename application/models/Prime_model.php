<?php
class Prime_model extends CI_Model {
  public function get_pol() {
	  $marid=$this->input->post('marid');
	  $marpass=$this->input->post('marpass');
	  $policy_number=$this->input->post('polnum');
	  
		$query_user = "select *  from ipl.users_bank  where USERNAME='$marid' and PASSWORD='$marpass'";
		$qu_find = $this->db->query($query_user); 
		
		foreach ($qu_find->result() as $r_user):
		$user= $r_user->USERNAME;
		$bcode= $r_user->BCODE;
		$us[]= $r_user->USERNAME;
		endforeach;
		
		if (count($us)==1){
/*	
	$sql_prem= "select POLICY,totprem ,premno,paymode, pnextpay,NAME,datcom, DOB,SUSPENSE,STATUS,matdate+1 mm, MONTHS_BETWEEN(SYSDATE,PNEXTPAY) ss,
                        IPL.LATE_FEE(POLICY,PRJ_CODE,PLAN,TERM,PAYMODE,TOTPREM,PNEXTPAY,
                        case when paymode='5' then floor(months_between(sysdate,pnextpay))
                             when paymode='1' then floor(floor(months_between(sysdate,pnextpay))/12)
                             when paymode='2' then floor(floor(months_between(sysdate,pnextpay))/6)
                             when paymode='4' then floor(floor(months_between(sysdate,pnextpay))/3)
                        end,SYSDATE,0) LATEFEE,
                        'plil'||lpad(VPC_MERCHTXNREF_SEQ.nextval+1,8,0) orderid,(plan||'-'||term) PLAN,SUMASS,PHONE,PRJ_CODE,(oc1 || '/' ||oc2|| '/' ||oc3|| '/' ||oc4|| '/' ||oc5||'/'||oc6||'/'||oc7||'/'||oc8||'/'||oc9||'/'||oc10)as org_setup,TOTPAID,DECODE(PRJ_CODE,'05','p','24','p','i') PRJ_TYPE
                        from  IPL.ALL_POLICY where policy= '$policy_number'";
  */
  $sql_prem= "select POLICY,totprem ,premno,paymode, pnextpay,NAME,datcom, DOB,SUSPENSE,STATUS,matdate+1 mm, MONTHS_BETWEEN(SYSDATE,PNEXTPAY) ss,
                        IPL.LATE_FEE(POLICY,PRJ_CODE,PLAN,TERM,PAYMODE,TOTPREM,PNEXTPAY,1,SYSDATE,0) LATEFEE,
                        'plil'||lpad(VPC_MERCHTXNREF_SEQ.nextval+1,8,0) orderid,(plan||'-'||term) PLAN,SUMASS,PHONE,PRJ_CODE,(oc1 || '/' ||oc2|| '/' ||oc3|| '/' ||oc4|| '/' ||oc5||'/'||oc6||'/'||oc7||'/'||oc8||'/'||oc9||'/'||oc10)as org_setup,TOTPAID,DECODE(PRJ_CODE,'05','p','24','p','i') PRJ_TYPE
                        from  IPL.ALL_POLICY where policy= '$policy_number'";
    $query_prem = $this->db->query($sql_prem);
	
	foreach ($query_prem->result() as $row_prem):
	$policy= $row_prem->POLICY;
	$name= $row_prem->NAME;
	$datcom= $row_prem->DATCOM;
	$paymode= $row_prem->PAYMODE;
	$pnextpay= $row_prem->PNEXTPAY;
	$plan= $row_prem->PLAN;
	$sumass= $row_prem->SUMASS;
	$totprem= $row_prem->TOTPREM;
	$phone= $row_prem->PHONE;
	$prj_code= $row_prem->PRJ_CODE;
	$org_setup= $row_prem->ORG_SETUP;
	$premno= $row_prem->PREMNO;
	$totpaid= $row_prem->TOTPAID;
	$suspense= $row_prem->SUSPENSE;
	$latefee= $row_prem->LATEFEE;
	$status= $row_prem->STATUS;
	$mm= $row_prem->MM;
	$ss= $row_prem->SS;
									if ($status == 'M') {
									$p_st=0;	
									$pol_stat="Policy Alrrady Matured";
									}
								elseif ($status == 'D') {
									$p_st=0;
									$pol_stat="Date claim Intimated";
									}	
								elseif ($status == 'S') {
									$p_st=0;
									$pol_stat="Policy alrrady Surrenderad";
									}
								elseif ($status == 'C') {
									$p_st=0;
									$pol_stat="Policy is Cancelled";
									}
								elseif ($pnextpay == $mm) {
									$p_st=0;
									$pol_stat="Alrrady Matured";
									}
								elseif ($ss>60) {
									$p_st=0;
									$pol_stat="Special Revival Requerd";
									}
									
								elseif ($ss>3 && $ss<60){
									$p_st=1;
									$pol_stat="DGH Requerd";
									}
								else {
									$p_st=1;
									$pol_stat="Policy Inforce";
									}
	
									if ($paymode == '1') { $term_month ='12'; }
									elseif ($paymode == '2') { $term_month ='6';} 
									elseif ($paymode == '4') { $term_month ='3'; }
									elseif ($paymode == '5') { $term_month ='1';  }
	$n_du=(ceil($ss/$term_month));
									if ($n_du<=0) {$num_due=1;} 
									else {$num_due=$n_du;}
	$prem_amnt=$totprem*1;
	$tot_payable=$prem_amnt+$latefee;
	$discount=0;
	$net_reciv=$tot_payable-$discount-$suspense;
	$up_suspanse=0;
	$up_pol_premno=1+$premno;
	$up_pol_totpayed=$totpaid+$net_reciv;
	$orderid= $row_prem->ORDERID;
	$prj_type= $row_prem->PRJ_TYPE;
	$dob= $row_prem->DOB;
	$orde[]= $row_prem->ORDERID;
	$m_add=1*$term_month;

		if ($p_st==1){
		$query="INSERT INTO ipl.collection_web_new 
		(POLICY,NAME,DATCOM,PAYMODE,PNEXTPAY,PLAN,SUMASS,TOTPREM,PHONE,PRJ_CODE,ORG_SETUP,PREMNO,TOTPAID,UP_POL_PREMNO,UP_POL_TOTPAYED,UP_SUSPANSE,UP_PNEXTPAY,RCPT_DATE,NOS_PREMNO,PREM_AMNT,LATE_FEES,TOT_PAYABLE,DISCOUNT,SUSPANSE_AMT,NET_RECIV,ID_NO,USER_ID,PRJ_TYPE,BCODE,POL_STATUS)  
VALUES ('$policy','$name','$datcom','$paymode','$pnextpay','$plan','$sumass','$totprem','$phone','$prj_code','$org_setup','$premno','$totpaid','$up_pol_premno','$up_pol_totpayed','$up_suspanse',(add_months ('$pnextpay','$m_add')),sysdate,'$num_due','$prem_amnt','$latefee','$tot_payable','$discount','$suspense','$net_reciv',
										'$orderid','$user','$prj_type','$bcode','$pol_stat')";
		}
		else if ($p_st==0){
$query="INSERT INTO ipl.collection_web_new 
		(POLICY,NAME,RCPT_DATE,USER_ID,PRJ_TYPE,BCODE,POL_STATUS,ID_NO)  
VALUES 
		('$policy','$name',sysdate,'$user','$prj_type','$bcode','$pol_stat','$orderid')";
			}
		$this->db->query($query);
	endforeach;	
	
	   if (isset($orde[0])){
	   $orderStr = implode("', '", $orde);	   
	   $query_all_data="select POLICY policy_number,NAME name_of_policyholder,PNEXTPAY DUE_DATE, TOTPREM prm_installment,NOS_PREMNO n_due,PREM_AMNT tot_inst,LATE_FEES late_fee,SUSPANSE_AMT suspense,NET_RECIV total_dues,POL_STATUS status,ID_NO orderid,'1' NO_OF_SUB from ipl.collection_web_new WHERE ID_NO IN ('$orderStr')";  
	   $find_all_data = $this->db->query($query_all_data);    
	   return $find_all_data->result_array();	
	}
			
			}
  }
  public function get_user() {
	  $marid=$this->input->post('marid');
	  $marpass=$this->input->post('marpass');
		$query_user = "select * from ipl.users_bank where USERNAME='$marid' and PASSWORD='$marpass'";
		$q_u_find = $this->db->query($query_user);  
       return $q_u_find->result_array();
  }
}
?>
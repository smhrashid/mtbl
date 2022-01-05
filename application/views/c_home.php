<?php 
$pinfoarray = array();
//url Check
if (base_url()=='http://plil.pragatilife.com/markantile/'){
    	foreach($user_find as $u_find):
		$re_url= $u_find['RETURN_URL'];
		$user_id= $u_find['USERNAME'];
		$bcode= $u_find['BCODE'];
		endforeach;
		
		//user Check
		if (count($user_find)==1){
			//policy check
			if (count($user_pol)==0){
			$policy_number=$this->input->post('polnum');
			$pinfoarray[] = array
			(
				POLICY_NUMBER=>$policy_number,
				STATUS=>"Invalid Policy",
				NO_OF_SUB=>3
			);	
				}
		//policy check	
			else{
		$pinfoarray = array();
		foreach($user_pol as $p_find):
		//
		$pinfoarray[]=$p_find;
		endforeach;
				}
		}
		//user Check
		else {
			$pinfoarray[] = array
			(
				
				STATUS=>"URL/User/pass Not ok",
				NO_OF_SUB=>3
			);
		}
}
//Url Check
else {
			$pinfoarray[] = array
			(
				STATUS=>"URL/User/pass Not ok",
				NO_OF_SUB=>3
			);
	}
	
	$jpinfoarray=json_encode($pinfoarray);
	
		echo $jpinfoarray;
		/*
			echo "<script type='text/javascript'>
			  function submitform()
			 {
			  feeds.submit();
			 }
			</script>
			
			<form name = 'feeds' action='".$re_url."' method='post'>
			  <input type='hidden'  name='returnplil' value ='".$jpinfoarray."' />
			</form>
			<script>
			  window.onload = submitform;
			</script>";
		*/
		
?>

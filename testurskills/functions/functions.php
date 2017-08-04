<?php
function getQuest(){
	
	$sql = mysql_query("select * from subjects");
	
	while($row_sub=mysql_fetch_array($sql)){
		$sub_id = $row_sub['sub_id'];
		$sub_name = $row_sub['sub_name'];
		
		echo "<li class='list-group-item'><a id='side_bar_link' href='home.php?sub=$sub_id'>$sub_name</a></li>";
	}
}



function getSubQues(){
	
	if(isset($_GET['sub'])){
		
		$sub_id=$_GET['sub'];
		$diff_id=$_GET['diff'];
	
		//global $con;
			
		$sql = mysql_query("select * from questions where sub=1 and difficulty=1");
			
		$count = mysql_num_rows($sql);
		
		if($count==0){
				
				echo "<h2 style='padding:20px;'>There are no questions in this subject</h2>";
			
			}
			
		while($row_sub_ques=mysql_fetch_array($sql)){
			
			$ques = $row_sub_ques['ques'];
			$opt1 = $row_sub_ques['opt1'];
			$opt2 = $row_sub_ques['opt2'];
			$opt3 = $row_sub_ques['opt3'];
			$opt4 = $row_sub_ques['opt4'];
		
			echo "
				<div class='col-md-4' id='single_product'>
					<h4>$ques</h4>
					<h5>$opt1</h5>
					<h5>$opt2</h5>
					<h5>$opt3</h5>
					<h5>$opt4</h5>						
				</div>
			";

		}
		
	}
}

?>

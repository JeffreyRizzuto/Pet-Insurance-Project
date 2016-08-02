<?php

class AdminView
{
    public static function show()
    {
        $_SESSION['headertitle'] = "Home Page";
        AdminView::showDetails();
        $_SESSION['footertitle'] = "<h3></h3>";
        MasterView::showFooter();
    }

    public static function showLogin()
    {
    	AdminMasterView::showHeader();
    	AdminMasterView::showNavBar();
        $admin = (array_key_exists('admin', $_SESSION)) ? $_SESSION ['admin'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION ['base'] : "";
        echo '<h2>Please Sign in</h2>';
        echo '<form action="/' . $base . '/admin/login/" method="Post">';
        echo '<p>User Name<br><input type="text" name="userName"';
        if (!is_null($admin)) {
            echo 'value = "' . $admin->getUserName() . '"';
        }
        echo '><br> <span class="error">';
        if (!is_null($admin)) {
            echo $admin->getError('userName');
        }
        echo '<br> Password<br> <input type="password" name="password"';
        if (!is_null($admin)) {
            echo 'value= "' . $admin->getPassword() . '"';
        }
        echo '><br> <span class="error">';
        if (!is_null($admin)) {
            echo $admin->getError('password');
        }
        echo '</span><br> <input type="submit" name="submit" Value="submit"> </p> </form>';
    }
    
    public static function showDetails(){
    	AdminMasterView::showHeader();
    	AdminMasterView::showNavBar();
    	$base = (array_key_exists('base', $_SESSION)) ? $_SESSION ['base'] : "";
    	echo '<section class ="text-center">';
    	echo '<a href="/'.$base.'/admin/usersPolicies/">   Users Policies</a><br> ';
    	echo '<a href="/'.$base.'/admin/getLogs/">   Logs</a><br> ';
    	echo '<a href="/'.$base.'/admin/activeDeactive/">   Active/Deactive</a><br> ';
    	echo '<a href="/'.$base.'/admin/overdue/">   Overdue Bills</a><br> ';
    	echo '<a href="/'.$base.'/admin/policyDetails/">   PolicyDetails</a><br> ';
    	echo '</section>';
    	
    }


    public static function showUsersPolicies()
    {
    	AdminMasterView::showHeader();
    	AdminMasterView::showNavBar();
        $policies = (array_key_exists('policies', $_SESSION)) ? $_SESSION['policies'] : null;
        $base = (array_key_exists('base', $_SESSION)) ? $_SESSION ['base'] : "";
        
        $base = $_SESSION['base'];
        echo '<section class ="text-center">';
        echo '<h1>Admin View</h1>';
        	echo '<form action = "/'.$base.'/admin/usersPolicies/" method="Post">';
        	echo 'First Name<br>';
        	echo '<input type="text" name="firstName"><br>';
        	echo 'Last Name<br>';
        	echo '<input type="text" name="lastName"><br>';
        	echo'<input type="submit" value="Submit"> </form>';

        	echo '<h1> Policies belonging to User</h1>';
            echo '<div class="table-responsive">';
	 	    echo '<table class="table table-hover">';
        	echo "<thead>";
        	echo "<tr><th>Policy Id</th><th>Policy Number</th><th>Start Date</th><th>End Date</th><th>Active</th></tr>";
        	if(!empty($policies)){
        	foreach($policies as $policy){
        		echo '<tr>';
        		echo '<td>'.$policy['policyId'] . '</td>';
        		echo '<td>'.$policy['policyNumber'] . '</td>';
        		echo '<td>'.$policy['startDate'] . '</td>';
        		echo '<td>'.$policy['endDate'] . '</td>';
        		echo '<td>'.$policy['active'] . '</td>';
        		if($policy['active'] != '0'){
        		echo '<td>';
        		echo '<form action = "/'.$base.'/admin/deactivatePolicy/'.$policy['policyId'].'" method="Post">';
        		echo'<input type="submit" value="deactivate policy"> </form>';
        		echo '</td>';
        		}
        		echo '</tr>';
        	}
        	}
        	echo "</tbody>";
        	echo "</table>";
        	echo "</div>";
        	echo '</section>';
        	echo '<a href="/' . $base . '/admin/adminView">Admin Home</a>';
    }
    
    public static function showLogs(){
    	AdminMasterView::showHeader();
    	AdminMasterView::showNavBar();
    	$logs = (array_key_exists('logs', $_SESSION)) ? $_SESSION['logs'] : null;
    	$base = (array_key_exists('base', $_SESSION)) ? $_SESSION ['base'] : "";
    	echo '<section class ="text-center">';
    	echo '<form action = "/'.$base.'/admin/getLogs/" method="Post">';
    	echo '<select name = "type">';
    	echo '<option value="Pet">pet</option>';
    	echo '<option value="Policy">policy</option>';
    	echo '<option value="User">user</option>';
    	echo '</select>';
    	echo'<input type="submit" value="Submit"> </form>';
    	
    	echo '<h1> Logs</h1>';
    	if($logs != null){
    	echo '<div class="table-responsive">';
	 	echo '<table class="table table-hover">';
    	echo "<thead>";
    	echo "<tr><th>Id</th><th>Date Deactived</th>";
    	foreach($logs as $log){
    		echo '<tr>';
    		echo '<td>'.$log['id'] . '</td>';
    		echo '<td>'.$log['dateCreated'] . '</td>';
    		echo '</tr>';
    	}
    	echo "</tbody>";
    	echo "</table>";
    	echo "</div>";
    	}
    	echo '</section>';
    	echo '<a href="/' . $base . '/admin/adminView">Admin Home</a>';
    }
    
    public static function showActiveDeactive()
    {
    	AdminMasterView::showHeader();
    	AdminMasterView::showNavBar();
    	$actives= (array_key_exists('active', $_SESSION)) ? $_SESSION['active'] : null;
    	$base = (array_key_exists('base', $_SESSION)) ? $_SESSION ['base'] : "";
    	$type = (array_key_exists('type', $_SESSION)) ? $_SESSION ['type'] : "";	
    	$base = $_SESSION['base'];
    	echo '<section class ="text-center">';
    	echo '<h1>Active/Deactive</h1>';
    	echo '<form action = "/'.$base.'/admin/activeDeactive/" method="Post">';
    	echo '<select name = "type">';
    	echo '<option value="Pets">pet</option>';
    	echo '<option value="Policies">policy</option>';
    	echo '<option value="Users">user</option>';
    	echo '</select>';
    	echo '<select name = "active">';
    	echo '<option value="1">active</option>';
    	echo '<option value="0">deactive</option>';
    	echo '</select>';
    	echo'<input type="submit" value="Submit"> </form>';
    
		if($type == 'Pets'){
				if($actives[0]['active'] == '1')
    				echo '<h1> Active Pets</h1>';
				else 
					echo '<h1> Deactive Pets</h1>';
				
    			echo '<div class="table-responsive">';
	 			echo '<table class="table table-hover">';
    			echo "<thead>";
    			echo "<tr><th>PetId</th><th>breed</th><th>species</th><th>name</th></tr>";
    			foreach($actives as $active){
    				echo '<tr>';
    				echo '<td>'.$active['petId'] . '</td>';
    				echo '<td>'.$active['breed'] . '</td>';
    				echo '<td>'.$active['species'] . '</td>';
    				echo '<td>'.$active['name'] . '</td>';
    				echo '</tr>';
    			}
    			echo "</tbody>";
    			echo "</table>";
    			echo "</div>";
		}
		
		if($type == 'Policies'){
			if($actives[0]['active'] == '1')
    			echo '<h1> Active Policies</h1>';
			else 
				echo '<h1> Deactive Policies</h1>';
			
			echo '<div class="table-responsive">';
	 		echo '<table class="table table-hover">';
			echo "<thead>";
			echo "<tr><th>Policy Id</th><th>Policy Number</th><th>Start Date</th><th>End Date</th></tr>";
			echo "</thead>";
			foreach($actives as $active){
				echo '<tr>';
				echo '<td>'.$active['policyId'] . '</td>';
				echo '<td>'.$active['policyNumber'] . '</td>';
				echo '<td>'.$active['startDate'] . '</td>';
				echo '<td>'.$active['endDate'] . '</td>';
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
		}
		
		if($type == 'Users'){
			if($actives[0]['active'] == '1')
				echo '<h1> Active Users</h1>';
			else
				echo '<h1> Deactive Users</h1>';
				
			echo '<div class="table-responsive">';
	 		echo '<table class="table table-hover">';
			echo "<thead>";
			echo "<tr><th>User Id</th><th>Policy Id</th><th>First Name</th><th>last Name</th><th>isPrimaryPolicyHolder</th></tr>";
			echo "</thead>";
			foreach($actives as $active){
				echo '<tr>';
				echo '<td>'.$active['userId'] . '</td>';
				echo '<td>'.$active['policyId'] . '</td>';
				echo '<td>'.$active['firstName'] . '</td>';
				echo '<td>'.$active['lastName'] . '</td>';
				echo '<td>'.$active['isPrimaryPolicyHolder'] . '</td>';
				echo '</tr>';
			}
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
		}
    	echo '</section>';
    	
    	echo '<a href="/' . $base . '/admin/adminView">Admin Home</a>';
    }
    
    public static function showOverDue(){
    	AdminMasterView::showHeader();
    	AdminMasterView::showNavBar();
    	$overdues= (array_key_exists('overdue', $_SESSION)) ? $_SESSION['overdue'] : null;
    	$base = (array_key_exists('base', $_SESSION)) ? $_SESSION ['base'] : "";
    	echo '<section class ="text-center">';
    	echo '<div class="table-responsive">';
	 	echo '<table class="table table-hover">';
    	echo "<thead>";
    	echo "<tr><th>First Name</th><th>Last Name</th><th>Due Date</th><th>Balance</th><th>Status</th><th>Policy Start Date</th><th>Policy End Date</th></tr>";
    	echo "</thead>";
    	echo "<tbody>";
    	foreach($overdues as $overdue){
    		echo '<tr>';
    		echo '<td>'.$overdue['firstName'] . '</td>';
    		echo '<td>'.$overdue['lastName'] . '</td>';
    		echo '<td>'.$overdue['dueDate'] . '</td>';
    		echo '<td>'.$overdue['balance'] . '</td>';
    		echo '<td>'.$overdue['status'] . '</td>';
    		echo '<td>'.$overdue['startDate'] . '</td>';
    		echo '<td>'.$overdue['endDate'] . '</td>';
    		echo '<td>';
    		echo '<form action = "/'.$base.'/admin/deactivateAll/'.$overdue['policyId'].'" method="Post">';
    		echo'<input type="submit" value="deactivate all"> </form>';
    		echo '</td>';
    		echo '</tr>';
    	}
    	echo "</tbody>";
    	echo "</table>";
    	echo "</div>";
    	echo '</section>';
    	echo '<a href="/' . $base . '/admin/adminView">Admin Home</a>';
    	 
    }
    
    public static function showPolicyDetails()
    {
    	AdminMasterView::showHeader();
    	AdminMasterView::showNavBar();
    	$policyDetails = (array_key_exists('policyDetails', $_SESSION)) ? $_SESSION['policyDetails'] : null;
    	$base = (array_key_exists('base', $_SESSION)) ? $_SESSION ['base'] : "";
    	echo '<section class ="text-center">';
    	echo '<h1>Policy Details</h1>';
    	echo '<div class="table-responsive">';
	 	echo '<table class="table table-hover">';;
    	echo "<thead>";    	
    	echo "<tr><th>Policy Number</th><th>Number of Users</th><th>Number of Pets</th><th>Number of Policies</th></tr>";
    	echo "</thead>";
    	echo "<tbody>";
    	foreach($policyDetails as $policyDetail){
    		echo '<tr>';
    		echo '<td>'.$policyDetail['policyNumber'] . '</td>';
    		echo '<td>'.$policyDetail['userCount'] . '</td>';
    		echo '<td>'.$policyDetail['petCount'] . '</td>';
    		echo '<td>'.$policyDetail['policyCount'] . '</td>';
    		echo '</tr>';
    	}
    	echo "</tbody>";
    	echo "</table>";
    	echo "</div>";
    	echo "</section>";
    	echo '<a href="/' . $base . '/admin/adminView">Admin Home</a>';
    }
    
    
}

?>
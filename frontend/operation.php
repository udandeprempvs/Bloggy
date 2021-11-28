<?php

require_once ("db.php");
require_once ("component.php");

// create button click
if (isset($_POST['create'])) {
	createData();
}
// update button click
if (isset($_POST['update'])) {
	UpdateData();
}
// delete button click
if (isset($_POST['delete'])) {
	deleteRecord();
}

if (isset($_POST['deleteall'])) {
	deleteAll();
}

// inputs data into the respective tables
function createData()
{
	$name = textboxValue("contact_name");
	$phone_no = textboxValue("contact_number");
	$email = textboxValue("contact_email");
	$add = textboxValue("contact_address");
	$useremail = $_SESSION['email'];
	if ($name && strlen($phone_no) >= 10 && $email) {
		$sql = "INSERT INTO contacts (contact_name, contact_number, contact_email, contact_address ,user_email) 
                    VALUES ('$name','$phone_no','$email','$add','$useremail')";

		if (mysqli_query($GLOBALS['con'], $sql)) {
			TextNode("success", "Record Successfully Inserted...!");
		} else {
			echo "Error";
		}
	} else {
		TextNode("error", "Phone Number invalid!");
	}
}

function textboxValue($value)
{
	 $textbox = mysqli_real_escape_string($GLOBALS['con'], trim($_POST[$value]));
	if (empty($textbox)) {
		return false;
	} else {
		return $textbox;
	}
}


// the banner which comes on top of the website
function TextNode($classname, $msg)
{
	$element = "<h6 class='$classname'>$msg</h6>";
    echo $element;
}


// get data from mysql database
function getData()
{
	$useremail = $_SESSION['email'];
	$sql = "SELECT * FROM contacts WHERE user_email = '$useremail' ORDER BY contact_name ASC";
	$result = mysqli_query($GLOBALS['con'], $sql);

	if (mysqli_num_rows($result) > 0) {
		return $result;
	}
}

// update data
function UpdateData()
{
	$id = textboxValue("contact_id");
	$name = textboxValue("contact_name");
	$phone_no = textboxValue("contact_number");
	$email = textboxValue("contact_email");
	$add = textboxValue("contact_address");
	$useremail = $_SESSION['email'];

	if ($name && strlen($phone_no) >= 10 && $email) {
		$sql = "
            UPDATE contacts SET contact_name='$name', contact_number = '$phone_no', contact_email = '$email', contact_address = '$add' WHERE contact_id='$id' AND user_email = '$useremail';                    
        ";
		if (mysqli_query($GLOBALS['con'], $sql)) {
			TextNode("success", "Data Successfully Updated");
		} else {
			TextNode("error", "Unable to Update Data");
		}
	} else {
		TextNode("error", "Check entered data");
        // TextNode("error", "Phone Number Invalid!");
	}
}

// deletes data of users from respective tables
function deleteRecord()
{
	$useremail = $_SESSION['email'];
	$id = (int)textboxValue("contact_id");

	$sql = "DELETE FROM contacts WHERE contact_id=$id AND user_email = '$useremail'";

	if (mysqli_query($GLOBALS['con'], $sql)) {
		TextNode("success", "Record Deleted Successfully...!");
	} else {
		TextNode("error", "Enable to Delete Record...!");
	}
}

function deleteBtn()
{
	$result = getData();
	$i = 0;
	if ($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			$i++;
			if ($i > 3) {
				buttonElement("btn-deleteall", "btn btn-danger", "<i class='fas fa-trash'></i> Delete All", "deleteall", "");
				return;
			}
		}
	}
}

// deletes all data of a user from a table
// function deleteAll(){
//     $useremail=$_SESSION['email'];
    
//         $sql = "DELETE FROM personal WHERE user_email = '$useremail';";

//     if(mysqli_query($GLOBALS['con'], $sql)){
//         TextNode("success","All Record deleted Successfully...!");
        
//     }else{
//         TextNode("error","Something Went Wrong Record cannot deleted...!");
//     }
// }


// set id to textbox
function setID()
{
	$getid = getData();
	$id = 0;
	if ($getid) {
		while ($row = mysqli_fetch_assoc($getid)) {
			$id = $row['contact_id'];
		}
	}
	return ($id + 1);
}

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>


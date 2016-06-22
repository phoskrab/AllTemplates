<?php 
session_start();
	include('../../configure/configure.php');
	
                        

	
	//$sqluser="SELECT * FROM tbuser u inner join tbstaff s on u.	staff_id=s.staff_id";
	$sqluser="call sp_repgetallfromuser()";
	$result=$con->query($sqluser);
	$rowuser=$result->fetch_object();
//======by Ratha brand protection//
mysqli_next_result($con);
	//$sqlclient="select * from tbclient C inner join tbclienttype CT on C.ClientTypeID=CT.ClientTypeID inner join tbidentitytype IDT on DT.IdentityTypeID=C.IdentityTypeID inner join  tbtypeofsourceincome TPS on TPS.typeofsourceincome_id=C.SourceIncomeID inner join tbbusinesssector BST on BST.BusinessSectorID=.C.BusinessSectorID  where C.ClientTypeID=1 AND LoanRequestID=$_SESSION[getLoanRequestID]";
		//$resultclient=$con->query($sqlclient);
		$resultclient=$con->query("call sp_repsqlclient($_SESSION[getLoanRequestID])");
		$rowclient=$resultclient->fetch_object();
mysqli_next_result($con);
	//$sqlclientprotected="select count(*) as countclientprotected from tbclient C inner join tbclienttype CT on C.ClientTypeID=CT.ClientTypeID 	inner join tbidentitytype IDT on IDT.IdentityTypeID=C.IdentityTypeID inner join  tbtypeofsourceincome TPS on TPS.typeofsourceincome_id=C.SourceIncomeID inner join tbbusinesssector BST on BST.BusinessSectorID=.C.BusinessSectorID  WHERE C.ClientTypeID=1 AND LoanRequestID=$_SESSION[getLoanRequestID]";
		//$resultclientprotected=$con->query($sqlclientprotected);
		$resultclientprotected=$con->query("call sp_repsqlclientprotected($_SESSION[getLoanRequestID])");
		$rowclientprotected=$resultclientprotected->fetch_object();
		if($rowclientprotected->countclientprotected>0){
			$clientco="Have Record";
		}else{
			$clientco="No Record";
		}
		
	mysqli_next_result($con);
																	
	//$sqlcoborrower="select * from tbclient C inner join tbclienttype CT on C.ClientTypeID=CT.ClientTypeID 	inner join tbidentitytype IDT on IDT.IdentityTypeID=C.IdentityTypeID inner join  tbtypeofsourceincome TPS on TPS.typeofsourceincome_id=C.SourceIncomeID inner join tbbusinesssector BST on BST.BusinessSectorID=.C.BusinessSectorID  WHERE C.ClientTypeID=2 AND LoanRequestID=$_SESSION[getLoanRequestID]";
		//$resultCoBorrower=$con->query($sqlcoborrower);
		$resultCoBorrower=$con->query("call sp_repsqlcoborrower($_SESSION[getLoanRequestID])");
		$rowcoborrower=$resultCoBorrower->fetch_object();
		////======by Ratha brand protection//
		mysqli_next_result($con);
	$sqlgg="select count(*) as ratha from tbclient C inner join tbclienttype CT on C.ClientTypeID=CT.ClientTypeID 
	inner join tbidentitytype IDT on IDT.IdentityTypeID=C.IdentityTypeID inner join  tbtypeofsourceincome TPS on TPS.typeofsourceincome_id=C.SourceIncomeID inner join tbbusinesssector BST on BST.BusinessSectorID=.C.BusinessSectorID  WHERE C.ClientTypeID=2 AND LoanRequestID=$_SESSION[getLoanRequestID]";
		$resultgg=$con->query($sqlgg);
		$rowgg=$resultgg->fetch_object();
	if ($rowgg->ratha==0){
		$countcoborrower="No Record";
	}else{
		$countcoborrower="Have Record";
	}

//===For gurrenter=======//
	$sqlGuarantor="select * from tbclient C inner join tbclienttype CT on C.ClientTypeID=CT.ClientTypeID 
	inner join tbidentitytype IDT on IDT.IdentityTypeID=C.IdentityTypeID inner join  tbtypeofsourceincome TPS on TPS.typeofsourceincome_id=C.SourceIncomeID inner join tbbusinesssector BST on BST.BusinessSectorID=.C.BusinessSectorID  WHERE C.ClientTypeID=3 AND LoanRequestID=$_SESSION[getLoanRequestID]";
	 	if($resultguarantor=$con->query($sqlGuarantor)){
	 	$rowguarantor=$resultguarantor->fetch_object();	
	 }
	$sqlGuarantorgg="select count(*) as vannoch from tbclient C inner join tbclienttype CT on C.ClientTypeID=CT.ClientTypeID 
	inner join tbidentitytype IDT on IDT.IdentityTypeID=C.IdentityTypeID inner join  tbtypeofsourceincome TPS on TPS.typeofsourceincome_id=C.SourceIncomeID inner join tbbusinesssector BST on BST.BusinessSectorID=.C.BusinessSectorID  WHERE C.ClientTypeID=3 AND LoanRequestID=$_SESSION[getLoanRequestID]";
	$resultgt=$con->query($sqlGuarantorgg);
	$rowguatan=$resultgt->fetch_object();
	if ($rowguatan->vannoch==0){
		$countguarantor="No Record";
	}else{
		$countguarantor="Have Record";
	}
		
//by Ratha inner iojn tb organization and brand and possition
	$sqlbrand="select * from tborganization OG inner join tbloanrequest LR on OG.RepOrganizationID=LR.LoanRequestID inner join tbbranch BR on BR.branch_id=OG.BranchID inner join tbposition PO on PO.	pos_id=OG.RepPosition where LoanRequestID=".$_SESSION['getLoanRequestID'];
			$resultorganization=$con->query($sqlbrand);
			$roworganization=$resultorganization->fetch_object();
 // //======by Ratha brand protection//
			$sqlbrandprotected="select count(*) as brandprotected from tborganization OG inner join tbloanrequest LR on OG.RepOrganizationID=LR.LoanRequestID inner join tbbranch BR on BR.branch_id=OG.BranchID inner join tbposition PO on PO.	pos_id=OG.RepPosition where LoanRequestID=".$_SESSION['getLoanRequestID'];
			$resultorganizationprotected=$con->query($sqlbrandprotected);
			$roworganizationprotected=$resultorganizationprotected->fetch_object();
			if ($roworganizationprotected->brandprotected>0) {
				$countbrand="Have Record";	
			}
			else{
				$countbrand="No Record";
			}
			 	 	
	
	/*inner join loaninfo with loanrequest */
	$sqlloan="select *from tbloaninfo LI inner join tbloanrequest LR on LI.LoanInfoID=LR.LoanInfoID 
	 WHERE LoanRequestID=".$_SESSION['getLoanRequestID'];
	$resultloan=$con->query($sqlloan);
	$rowloan=$resultloan->fetch_object();

	if($rowloan->Currency==2){
		$cur=" ដុល្លារ";
	}
	if($rowloan->Currency==1){
		$cur=" រៀល";
	}
	//===========by Ratha======//

	$sqlloanshowdetail="select count(*) as loanshowdetail from tbloaninfo LI inner join tbloanrequest LR on LI.LoanInfoID=LR.LoanInfoID 
	 WHERE LoanRequestID=".$_SESSION['getLoanRequestID'];
	$resultshowdetail=$con->query($sqlloanshowdetail);
	$rowbrandshowdetail=$resultshowdetail->fetch_object();
	if ($rowbrandshowdetail->loanshowdetail==1) {
		$loanshowdetailcur="No Record";
	}
	else{
		$loanshowdetailcur="Have Record";
	}

	


	/*inner join loaninfo with loanrequest */				
	$sqlsummary="select * from tbfsummury FI inner join tbloanrequest LR
	 on LR.FinancialID=FI.FinancialID where LoanRequestID=".$_SESSION['getLoanRequestID'];
	$resultsummary=$con->query($sqlsummary);
	$rowsummary=$resultsummary->fetch_object();


	/*inner join loaninfo with loanrequest */				
	$sqlfinancial="SELECT* from tbficomeexpense FI inner join tbloanrequest LR
	 on LR.FinancialID=FI.FinancialID inner join tbfinancial FRR on FRR.FinancialID=FI.FinancialID where LoanRequestID=".$_SESSION['getLoanRequestID'];
	$resultfinancial=$con->query($sqlfinancial);
	$rowfinancial=$resultfinancial->fetch_object();

	if($rowfinancial->CurrencyType==1){
		$curIncome=" រៀល";
	}
	if($rowfinancial->CurrencyType==2){
		$curIncome=" ដុល្លារ";
	}
	if ($rowfinancial->CurrencyType==0) {
		$curIncome="......";
	}

	
		
	$sqlGuarantor="select * from tbclient C inner join tbclienttype CT on C.ClientTypeID=CT.ClientTypeID 
	inner join tbidentitytype IDT on IDT.IdentityTypeID=C.IdentityTypeID inner join  tbtypeofsourceincome TPS on TPS.typeofsourceincome_id=C.SourceIncomeID inner join tbbusinesssector BST on BST.BusinessSectorID=.C.BusinessSectorID  WHERE C.ClientTypeID=3 AND LoanRequestID=$_SESSION[getLoanRequestID]
	";
	$resultguarantor=$con->query($sqlGuarantor);
	$rowguarantor=$resultguarantor->fetch_object();
 ?>
	<?php
	$sqlco="select * from tbuser U inner join tbstaff S on S.staff_id=U.staff_id inner join tbloanrequest L on L.user_id=U.user_id where LoanRequestID=".$_SESSION['getLoanRequestID'];
		$resultco=$con->query($sqlco);
		$rowco=$resultco->fetch_object();
	?>
	
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Micro One</title>
	<link rel="stylesheet" href="../../css/style.css"><!-- update link -->
	<script>
	function myPrint() {
	 document.getElementById("btnReport").style.visibility = "hidden";
	    window.print();
	}
	</script>

</head>
<body>


	<!-- page17 -->
	
	
	<div class="page">
	<button onclick="myPrint()" id="btnReport" class="btnreport"> Print</button>
		 <div class="logo" style="margin-top: 54px;">
			<img src="cfeo.png" alt="logo" width="90">
		</div>
		<div class="kingdom">
			<p>ព្រះរាជាណាចក្រកម្ពុជា</p>
			<p>ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
			<p>ពាក្យសុំចុះឈ្មោះខ្ចីប្រាក់</p>
		</div>
		<br/><br/>
		<p><b>១-ឈ្មោះ និងអាស័យដ្ឋានរបស់អ្នកខ្ចីប្រាក់</b></p>
		<span class="borrow">(ខ្ចីលើកទីៈ ..................)</span>
		<p style="text-indent: 20px;">
		ខ្ញុំបាទ/នាងខ្ញុំឈ្មោះ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............";}?></span></i></b>

		ជាអក្សរឡាតាំង <b><i><span id="v" style="text-transform: uppercase;"><?php if($clientco=="Have Record"){echo $rowclient->NameInLatin;} else{echo "............";}?></span></i></b> 

		ឈ្មោះហៅក្រៅ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->NickName;} else{echo "............";}?></span></i></b>

		ភេទ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Gender;} else{echo "............";}?></span></i></b>

	    សញ្ជាតិ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Nationality;} else{echo "............";}?></span></i></b> 

	    ថ្ងៃខែឆ្នាំកំណើត <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->DateOfBirth;} else{echo "............";}?></span></i></b>

	    អាស័យដ្ឋានបច្ចុប្បន្នៈផ្ទះលេខ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->HouseNo;} else{echo "............";}?></span></i></b>

	     ផ្លូវលេខ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Street;} else{echo "............";}?></span></i></b>

	    ក្រុមទី<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->GroupNo;} else{echo "............";}?></span></i></b>

		ភូមិ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Village;} else{echo "............";}?></span></i></b>

		ឃុំ/សង្កាត់<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Commune;} else{echo "............";}?></span></i></b>

		ស្រុក/ខណ្ឌ/ក្រុង <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->District;} else{echo "............";}?></span></i></b>

		ខេត្ត/រាជធានី <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Province;} else{echo "............";}?></span></i></b> 

		ទូរស័ព្ទលខៈ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Telephone;} else{echo "............";}?></span></i></b>

		មុខរបរ: <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->typeofsourceincome;} else{echo "............";}?></span></i></b>

		ឈ្មោះន្លែងធ្វើកា: <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->BusinessName;} else{echo "............";}?></span></i></b>

		តំណែង:<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Position;} else{echo "............";}?></span></i></b>
	​​       

		ទីកន្លែង:<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Location;} else{echo "............";}?></span></i></b>

		សាអេឡិចត្រូណិច:<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Email;} else{echo "............";}?></span></i></b></p>
		<div class="center">
			<p><b>សូមគោរពជូន</p>
		<p align="center"><b>ប្រធានអង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជាសាខា<?php if($countbrand=="Have Record"){echo " ".$roworganization->branch_nameinkhmer." ";}else{echo "..........";}?></b></p></b>
		</div>
		<div class="list">
			<div class="list_left">
				<p style="text-indent: 20px;">កម្មវត្ថុៈ</p>
			</div>
			<?php
		$c="";
			if($rowloan->Currency==1){$c=" រៀល";}
			if($rowloan->Currency==2){$c=" ដុល្លារ";}
			if($rowloan->Currency==0){$c=".......";}
		?>
			<div class="list_right">
				<p>សំណើសុំខ្ចីប្រាក់ចំនួនជាលេខៈ<span id='v'><b><i><?php if($clientco=="Have Record"){echo $rowloan->LoanAmount."$c";} else{echo "............";}?></span></i></b>
					រយៈពេលខ្ចីប្រាក់<span id='v'><b><i><?php if($clientco=="Have Record"){echo $rowloan->LoanTerm;} else{echo "............";}?></i></b></span>ខែ ដោយយើងខ្ញុំត្រូវការទុនដើម្បី<span id='v'><?php echo $rowloan->LoanPupose;?></span>។ អាស្រ័យហេតុនេះ សូមលោកប្រធាន មេត្តាពិនិត្យសំណើ និងផ្តល់ប្រាក់កម្ចីដល់ ខ្ញុំបាទ/នាងខ្ញុំ ដោយក្តីអនុគ្រោះ ។</p>
				<p>សូមលោកប្រធាន មេត្តាទទួលនូវការគោរពដ៏ខ្ពង់ខ្ពស់អំពីខ្ញុំ ។</p>
			</div>
		</div>
		<p><b>២-ទីតាំងអាស័យដ្ឋានរបស់អ្នកខ្ចី</b></p>
		<div class="map">
			<p>គំនូសប្លង់បង្ហាញពីទីតាំងអាស័យដ្ឋានរបស់អ្នកខ្ចីប្រាក់</p>
		</div>
		<p><d>ស្នាមមេដៃស្តាំរបស់អ្នកសុំខ្ចី</d></p>

		<div style="margin-top:150px">
			<p style="margin-top: -10px;"><d>ឈ្មោះ<span id='v'><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............";}?></span></d></p>
		</div>

	</div>
	<!-- end page17 -->

	<!-- page18 -->	
	<div class="page">
		<div class="logo">
			<img src="cfeo.png" alt="logo" width="90">
		</div>
		<div class="kingdom">
			<p>ព្រះរាជាណាចក្រកម្ពុជា</p>
			<p>ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
			<p>គម្រោងជំនួញ</p>
		</div>
		<br/><br/>
		<p><b>ក- ប្រវត្តសង្ខេបភាគីអ្នកខ្ចី</b></p>
		<p>១- ឈ្មោះ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............";}?></span></i></b>

		ឈ្មោះជាអក្សរឡាតាំង <b><i><span id="v" style="text-transform: uppercase;"><?php if($clientco=="Have Record"){echo $rowclient->NameInLatin;} else{echo "............";}?></span></i></b>

	    ឈ្មោះហៅក្រៅ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->NickName;} else{echo "............";}?></span></i></b>

	    ភេទ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Gender;} else{echo "............";}?></span></i></b>

	    សញ្ជាតិ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Nationality;} else{echo "............";}?></span></i></b>

	    ថ្ងៃខែឆ្នាំកំណើត <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->DateOfBirth;} else{echo "............";}?></span></i></b>

	    <p style="text-indent: 20px;">ឯកសារសំគាល់អត្តសញ្ញាណ: <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->IdentityName;} else{echo "............";}?></span></i></b>

	    លេខ <b><i><span id="v"><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->IDNo;} else{echo "............";}?></span></i></b>

	    ចេញដោយ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->IssuedBy;} else{echo "............";}?></span></i></span></b>។

	    មុខរបរផ្ទាល់ខ្លួន<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->BusinessName;} else{echo "............";}?></span></i></b>

	    <p style="text-indent: 20px;">ទីកន្លែង<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Location;} else{echo "............";}?></span></i></b>

	    ទូរស័ព្ទលេខ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Telephone;} else{echo "............";}?></span></i></b>

	    សមាជិកគ្រសា<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->FamilyMember;} else{echo "............";}?></span></i></b>
		<!-- <p>- ស្ថានភាពគ្រួសារ  -->
		<!-- <?php 
		//echo $marritstatus;die;
			//if($marritstatus=='នៅលីវ '){
				//echo '<input type="checkbox" checkdate(month, day, year)ked>';
			//}else echo '<input type="checkbox">';
		 ?>
 -->
		<!-- នៅលីវ​​  -->
<!--========== Comment Checkbox=============-->
		<!-- <?php 
	//		if($marritstatus=='មានគ្រួសារ '){
			//	echo '<input type="checkbox" checked>';
	//		}else echo '<input type="checkbox">';		
		 ?>

		មានគ្រួសារ,

		<?php 
	//		if($marritstatus=='មេម៉ាយ '){
		//		echo '<input type="checkbox" checked>';
	//		}else echo '<input type="checkbox">';
		 ?>
 -->
		ម៉េម៉ាយ ចំនួនមនុស្សក្នុងបន្ទុកគ្រួសារ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->FamilyMember;} else{echo "............";}?></span></i></b>

		<p style="text-indent: 20px;">នាក់  អ្នករកចំណូលបាន <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->FamilyEarnIncome;} else{echo "............";}?></span></i></b>

		នាក់។</p><p>២- <input type="checkbox">ប្តី, <input type="checkbox">ប្រពន្ឋ, <input type="checkbox"> អ្នកស្នងមរតកឈ្មោះ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></i></b>

		ភេទ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Gender;} else{echo "............";}?></span></i></b> 

		សញ្ជាតិ <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Nationality;} else{echo "............";}?></span></i></b> 

		ថ្ងៃខែឆ្នាំកំណើត <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->DateOfBirth;} else{echo "............";}?></span></i></b> 

		<p style="text-indent: 20px;">-ឯកសារសំគាល់អត្តសញ្ញាណ: <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IdentityName;} else{echo "............";}?></span></i></b>

		  លេខ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IDNo;} else{echo "............";}?></span></i></b>

		   ចេញដោយ <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IssuedBy;} else{echo "............";}?></span></i></b>

		-មុខរបរផ្ទាល់ខ្លួន <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->BusinessName;} else{echo "............";}?></span></i></b>

		 ទីកន្លែង <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Location;} else{echo "............";}?></span></i></b>។</p>

		<p>៣-អាស័យដ្ឋានបច្ចុប្បន្ន: ផ្ទះលេខ <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->HouseNo;} else{echo "............";}?></span></i></b>

		ផ្លូវលេខ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->HouseNo;} else{echo "............";}?></span></i></b>

		ក្រុមទី <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->GroupNo;} else{echo "............";}?></span></i></b> 

		ភូមិ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Village;} else{echo "............";}?></span></i></b>

		ឃុំ/សង្កាត់ <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Commune;} else{echo "............";}?></span></i></b>

		 ស្រុក/ខណ្ខ/ក្រុង <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->District;} else{echo "............";}?></span></i></b> </p>

		<p style="text-indent: 20px;">ខេត្ត/រាជធានី  <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Province;} else{echo "............";}?></span></i></b> ។ 
		</p>
		<p>៤- មុខរបរផ្សេងៗ ( ក្រៅពីអ្នកខ្ចី ) <b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->BusinessName;} else{echo ".............";}?></span></i></b></p>
		<p>៥- ប្រាក់កម្ចី:</p>
		

		<p style="text-indent: 20px;">-ទឹកប្រាក់ខ្ចីចំនួនៈ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowloan->LoanAmount."$c";} else{echo "............";}?></span></i></b></p>

		<p style="text-indent: 20px;">-គោលបំណងប្រើប្រាស់ៈ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowloan->LoanPupose;} else{echo "............";}?></span></i></b></p>

		<p style="text-indent: 20px;">-រយៈពេលសុំខ្ចី <b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowloan->LoanTerm ." ខែ ";}else{echo "..........";}?></span></i></b>

		<p style="text-indent: 20px;">-អាត្រាការប្រាក់ <b><i><span id="v"><?php echo "  ".$rowloan->InterestRate." ភាគរយ " ?></span></i></b></p>
		<!-- <?php 
		//$curIncome="";
		//	if($rowfinancial->Currency==1){$curIncome=" រៀល";}
		//	if($rowfinancial->Currency==2){$curIncome=" ដុល្លារ";}
		//	echo $curIncome;
		?>
 -->

		<p><b>ខ- លំហូរសាច់ប្រាក់</b></p>
		
		
		<p style="text-indent: 50px;">១- ចំណូល និងចំណាយក្នុងមុខរបរក្នុង
		<p style="text-indent: 100px;">-ចំណូលសរុប<span style="margin-left: 105px;">:</span><b><i><span id="v" style="margin-left: 50px;"><?php echo $rowfinancial->TotalSaleNRevenue.$curIncome;?></span></i></b></p>
		<p style="text-indent: 100px;">-ចំណាយមុខរបរ<span style="margin-left: 90px;">:</span><b><i><span id="v" style="margin-left: 50px;"><?php echo $rowfinancial->TotalExpanse.$curIncome;?></span></i></b></p>
		<p style="text-indent: 100px;">-ចំណេញពីមុខរបរ <span style="margin-left: 77px;">:</span><b><i><span id="v" style="margin-left: 50px;"><?php  echo $rowfinancial->TotalExpanse.$curIncome;?></span></i></b></p>

		<p style="text-indent: 50px;">២- សរុបចំណេញសុទ្ឋជាមធ្យមក្នុង 
		<p style="text-indent: 100px;">-ចំណេញសុទ្ឋពីមុខរបរអ្នកខ្ចី <span style="margin-left: 28px;">:</span><b><i><span id="v" style="margin-left: 50px;"><?php echo $rowfinancial->GrossProfit."$curIncome";?></span></i></b></p>
	<p style="text-indent: 100px;">-ចំណេញសុទ្ឋពីមុខរបរអ្នករួមខ្ចី <span style="margin-left:15px;">:</span><b><i><span id="v"style="margin-left: 50px;"><?php echo $rowfinancial->TotalExpanse."$curIncome";?></span></i></b></p>
		<p style="text-indent: 100px;">-ចំណេញសុទ្ឋផ្សេងៗ <span style="margin-left: 63px;">:</span><i><b><span id="v"style="margin-left: 50px;"><?php echo $rowsummary->OtherIncomeSUM ."$curIncome";?></span></i></b></p>
		<p style="text-indent: 100px;">-សរុបចំណេញសុទ្ឋ <span style="margin-left: 73px;">:</span><i><b><span id="v"style="margin-left: 50px;"><?php echo $rowsummary->TotalNeticomeSUM ."$curIncome";?></span></i></b></p>

		<p style="text-indent: 50px;">៣- លទ្ឋភាពសងជាមធ្យមក្នុង </p>
		<p style="text-indent: 100px;">-សរុបចំណេញសុទ្ឋ <span style="margin-left: 73px;">:</span><b><i><span id="v"style="margin-left: 50px;"><?php echo $rowsummary->TotalNeticomeSUM  ."$curIncome";?></span></i></b></p>

		<p style="text-indent: 100px;">-ចំណាយសំរាប់គ្រួសារ <span style="margin-left: 54px;">:</span><b><i><span id="v"style="margin-left: 50px;"><?php echo $rowsummary->FamilyExpenseSUM ."$curIncome";?></span></i></b></p>

		<p style="text-indent: 100px;">-ប្រាក់សំណល់ <span style="margin-left: 93px;">:</span><span style="margin-left: 50px;">..................</span></p>
		<p style="text-indent: 100px;">-ប៉ាន់ស្មានលទ្ឋភាពសង <span style="margin-left: 50px;">:</span><b><i><span id="v"style="margin-left: 50px;"><?php echo $rowsummary->CapacityToRepay ."$curIncome";?></span></i></b></p>
		
			
	</div>
		<!-- end page18 -->	


		<!-- page19 -->	
		<div class="page">
			<p><b>គ- ទ្រព្យសម្បត្តិអះអាងធានាខ្ចីប្រាក់</b></p>
			<p style="text-indent: 50px;">ទ្រព្យសម្បត្តិអះអាងធានាខ្ចីប្រាក់
				<input type='checkbox' id='chk1'> របស់អ្នកខ្ចីប្រាក់,
				<input type='checkbox' id='chk3'> របស់អ្នកធានាប្រាក់, "
			<?php 
				$sq="select Owner from tbcollatoraldetail CD inner join tbclienttype CT on CD.Owner=CT.ClientTypeID WHERE LoanRequestID=".$_SESSION['getLoanRequestID'];
				$res=$con->query($sq);
				$ro=$res->fetch_object();
				while($ro=$res->fetch_object()){
						if($ro->Owner==3){
							echo "<script>document.getElementById('chk3').checked=true;</script>";
						}if($ro->Owner==1){
							echo "<script>document.getElementById('chk1').checked=true;</script>";
						}
							break;	
				}

			?>
			
			
			<table border="1" align="center">
				<tr>
					<th width="100" align="center">ល.រ</th>
					<th width="400" align="center">បរិយាយ</th>
					<th width="150" align="center">តម្លៃ</th>
					<th width="150" align="center">កម្មសិទ្ធ</th>
				</tr>
				<?php 
					// $sqlcallatoral="select * from tbcollatoraldetail CD inner join tbclienttype CT on CD.Owner=CT.ClientTypeID inner join tbCollateraltype CTL on CTL.CollateralTypeId=CT.ClientTypeID WHERE LoanRequestID=".$_SESSION['getLoanRequestID'];

						$sqlcallatoral="select * from tbcollatoraldetail CD inner join tbcollateraltype CT on CT.CollateralTypeId=CD.CollateralType inner join tbclienttype CT1 on CD.Owner=CT1.ClientTypeID where LoanRequestID=".$_SESSION['getLoanRequestID'];



							$resultcollatoral=$con->query($sqlcallatoral);
							$row=0;
							$cur="";
							while($rowcollatoral=$resultcollatoral->fetch_object()){
								$row++;
								if($rowcollatoral->Currency==1){
									$cur=" រៀល";
								}
								if($rowcollatoral->Currency==2){
									$cur=" ដុល្លារ";
								}
							echo "<tr>";
								echo "<td style='text-align: center'>".$row;
						                echo "<td style='text-align: center'>".$rowcollatoral->CollateralTypeInKhmer;
						                echo "<td style='text-align: center'>".$rowcollatoral->EstimatePrice.$cur;
						                echo "<td style='text-align: center'>".$rowcollatoral->ClientTypeInKhmer;
								
							//echo "ឈ្មោះទ្រព្យបញ្ចាំ​​ ";
							}

							$sqlvehicle="select * from tbcollateraldetailvehcle CD inner join tbclienttype CT on CD.Owner=CT.ClientTypeID inner join tbcollateraltype COL on COL.CollateralTypeId=CD.CollateralType WHERE LoanRequestID=".$_SESSION['getLoanRequestID'];
							$resultvehicle=$con->query($sqlvehicle);

						
							while($rowvehicle=$resultvehicle->fetch_object()){
								$row++;
								if($rowvehicle->Currency==1){
									$cur=" រៀល";
								}
								if($rowvehicle->Currency==2){
									$cur=" ដុល្លារ";
								}
							echo "<tr>";
								echo "<td style='text-align: center'>".$row;
								echo "<td style='text-align: center'>".$rowvehicle->CollateralTypeInKhmer;
								echo "<td style='text-align: center'>".$rowvehicle->EstimatePrice.$cur;
								echo "<td style='text-align: center'>".$rowvehicle->ClientTypeInKhmer;
							//echo "ឈ្មោះទ្រព្យបញ្ចាំ​​ ";
							}
						
				 ?>	
			</table>

			<p style="margin-top:40px;margin-left:30px;" align="center">ថ្ងៃទី.....ខែ......ឆ្នាំ ២០....</p>
			<span style="margin-left: 150px;font-family:Khmer OS Muol;font-weight: bold;"> ស្នាមមេដៃស្តាំអ្នកធានា </span>

			<span style="margin-left: 250px;font-family:Khmer OS Muol;font-weight: bold;"> ស្នាមមេដៃស្តាំភាគីអ្នកខ្ចីប្រាក់ </span><br><br><br><br><br>


			<div class="signature"></div>

			<table border="0"width="200px">
			<tr><td><p><span style="margin-right: 150px;font-family:Khmer OS Muol;font-weight: bold">ឈ្មោះ<span id="v">
			<?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></td>
			<td><p><span style="margin-right: 150px;font-family:Khmer OS Muol;font-weight: bold">ឈ្មោះ<span id='v'>
			<?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></span></p></td>
			<td><p><span style="margin-right: 150px;font-family:Khmer OS Muol;font-weight: bold">ឈ្មោះ
			<b><i><span><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............";}?></span></i></b>

			<td><p><span style="margin-right: 150px;font-family:Khmer OS Muol;font-weight: bold">ឈ្មោះ<span id='v'><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></span></p></td></tr>
			</table>
			<div class="signature">
				<p style="font-family:Khmer OS Muol;">
					បានពិនិត្យឃើញថា<br> មានភាពត្រឹមត្រូវច្បាស់លាស់ និងគ្រប់គ្រាន់<br>
								ហត្ថលេខាមន្រ្តីឥណទាន
				</p>
			</div><br><br><br><br>
			<div class="signature">
				<p style="font-family:Khmer OS Muol;">ឈ្មោះ<span id="v"><?php echo " ".$rowco->staff_nameinkhmer; ?></span></p>
			</div>
		</div>
		<!-- end page19 -->
		
		<!-- page20 -->
		<div class="page">
			<div class="logo">
			<img src="cfeo.png" alt="logo" width="90">
			</div>
			<div class="kingdom">
				<p>ព្រះរាជាណាចក្រកម្ពុជា</p>
				<p>ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
				<p><u>ពាក្យសុំខ្ចីចងការ</u></p>
			</div>
			
				<span style="border: 1px black solid; float: right;">លេខអតិថិជន<v></v></span>
			<?php 
			$sqlloancheked="select Kind_ofLoan from tbloaninfo where LoanInfoID=".$_SESSION['getLoanRequestID'];
			$resultloancheked=$con->query($sqlloancheked);
			$rowloancheked=$resultloancheked->fetch_object();
						if($rowloancheked->Kind_ofLoan=='1'){
						?>
							<span style="margin-left: 200px;">
			    				<input type='checkbox' checked id='chkN'>រូបវន្ដបុគ្គល
								<input type='checkbox' id='chkV'> នីតិបុគ្គល,</span>
						<?php
						}
						else{
						?>
						<span style="margin-left: 200px;">
			    				<input type='checkbox'  id='chkN'>រូបវន្ដបុគ្គល
								<input type='checkbox' checked id='chkV'> នីតិបុគ្គល,</span>
								<?php
						}

						
							
					
				
			
			?>
			<br/>
			<br/>
			<p>១-អ្នកសុំខ្ចីចងការ ៖ <b><i><span><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............";}?></span></i></b> 
			ភេទ<b><i><span><?php if($clientco=="Have Record"){echo $rowclient->Gender;} else{echo "............";}?></span></i></b>
			ថ្ងៃខែឆ្នាំកំណើត<b><i><span id='v'><?php if($clientco=="Have Record"){echo $rowclient->DateOfBirth;} else{echo "............";}?></span></i></b>

			សញ្ជាតិ <b><i><span><?php if($clientco=="Have Record"){echo $rowclient->Nationality;} else{echo "............";}?></span></i></b>
			ឯកសារសំគាល់អត្តសញ្ញាណ:<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->IdentityName;} else{echo "............";}?></span></i></b>


			<p style="text-indent: 20px;">លេខ:<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->IDNo."  ";}else{echo "............";} ?></span></i></b>  
			ចុះថ្ងៃទី <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->IssuedDate;} else{echo "............";}?></span></i></b>

			អាស័យដ្ឋានបច្ចុប្បន្នផ្ទះលេខ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->HouseNo;} else{echo "............";}?></span></i></b>

			ផ្លូវលេខ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Street;} else{echo "............";}?></span></i></b>

			ក្រុមទី<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->GroupNo;} else{echo "............";}?></span></i></b>

			ភូមិ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Village;} else{echo "............";}?></span></i></b><p style="text-indent: 20px;">ឃុំ/សង្កាត់<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Commune;} else{echo "............";}?></span></i></b>

				ស្រុក/ខ័ណ្ឌ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->District;} else{echo "............";}?></span></i></b>

			ខេត្ដ/ក្រុង<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Province;} else{echo "............";}?></span></i></b>

			ទូរស័ព្ទលេខ<b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Telephone;} else{echo "............";}?></span></i></b>

			<p>២-អ្នករួមសុំខ្ចីចងការ៖<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></i></b>

			ភេទ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Gender;} else{echo "............";}?></span></i></b>

			ថ្ងៃខែឆ្នាំកំណើត<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->DateOfBirth;} else{echo "............";}?></span></i></b>

			សញ្ជាតិ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Nationality;} else{echo "............";}?></span></i></b>

			សៀវភៅគ្រួសារ<b><i><span='v'><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IdentityName;} else{echo "............";}?></span></i></b>

			លេខ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IDNo;} else{echo "............";}?></span></i></b>

			<p style="text-indent: 20px;">ចុះថ្ងៃទី<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IssuedDate;} else{echo "............";}?></span></i></b>

			ចេញដោយ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IssuedBy;} else{echo "............";}?></span></i></b>

			អាសយដ្ឋានបច្ចុប្បន្ន <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Province;} else{echo "............";}?></span></i></b></p>
			<div class="center">
				<p><b>សូមគោរពចូលមក<br/>
					លោកប្រធានអង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជា
				</b></p>
			</div>	
			<p style="text-indent: 20px;">ក្រោយពីបានយល់ជ្រួតជ្រាបនូវសេចក្ដីណែនាំស្ដីពីគោលការណ៍ និងលក្ខខណ្ឌរួមនៃការអោយខ្ចីចងការទុនពីអង្គការសេដ្ឋកិច្ច គ្រួសារកម្ពុជា<p style="text-indent: 20px;">យើងខ្ញុំសន្យាអនុវត្ដតាមទាំងស្រុង   យើងខ្ញុំសូមគោរពស្នើ លោក-លោកស្រី មេត្ដាអនុម័តអោយខ្ចីចងការប្រាក់ ៖
			ចំនួនជាលេខ ៖<b><i><span id="v"><?php echo "  ".$rowloan->LoanAmount."	$c";?></span></i></b>
			<p style="text-indent: 20px;">ជាអក្សរ<b><i><span id="v"><?php echo "  ".$rowloan->LoanAmount_inword."  " ?></span></i></b>

			សំរាប់រយៈពេល <b><i><span id="v"><?php echo "  ".$rowloan->LoanTerm." ខែ " ?></span></i></b>ក្រោមការដាក់បញ្ចាំ    អចលនវត្ថុ  ចលនវត្ថុ  ៖</p><p style="text-indent: 50px;">	⧠ របស់ (យើង) ខ្ញុំ ផ្ទាល់និង ឬ ⧠ របស់អ្នកដាក់បញ្ចាំជំនួស ៖ <p style="text-indent: 20px;">ឈ្មោះ <b><i><span id="v"><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............";}?></span></i></b>

			និង ឬ ⧠ របស់អ្នកចេញមុខធានា និងដាក់បញ្ចាំជំនួស ៖ ឈ្មោះ<b><i><span id="v">
			<?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></i></b>និង<b><i><span id="v"><span id='v'><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></span></i></b>
			<p style="text-indent: 20px;">និង ឬ ⧠ ក្រោមការដាក់ធានាអះអាងនូវអចលនទ្រព្យ និងចលនទ្រព្យរបស់អ្នកធានា ៖ ឈ្មោះ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></i></b>
			និង<span id='v'><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span>ដើម្បីជាសក្ខីកម្មនៃសំណើខាងលើ <p style="text-indent: 20px;">យើងខ្ញុំសូមជូនភ្ជាប់មកជាមួយនេះនូវ ៖
			</p>
			<?php
				$sql="select * from tbdocument D inner join tbloanrequest L on L.DocumentID=D.DocumentID where LoanRequestID=".$_SESSION['getLoanRequestID'];
  					$result=$con->query($sql);
 				    $rowdocument=$result->fetch_object();
				
			?>
			<p style="text-indent: 50px">
			<input type="checkbox"name="ckbox1" id="ckbox1"<?php  if($rowdocument->Field1==1) echo "checked"; ?> onchange="autoInsertOther()"/>
			 ១	ច្បាប់ថតចម្លងអត្ដសញ្ញាណប័ណ្ណឬសៀវភៅគ្រួសារនៃអ្នកសុំខ្ចី អ្នករួមសុំខ្ចី.................................................................០១ច្បាប់<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox2" <?php if($rowdocument->Field2==1) echo "checked"; ?>  id="ckbox2"onchange="autoInsertOther()"/>
			២	ច្បាប់ថតចម្លងលិខិតអនុញ្ញាតអោយធ្វើអាជីវកម្ម មាននិត្យានុកូលកម្ម....................................................................................០១ច្បាប់<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox3"  <?php  if($rowdocument->Field3==1) echo "checked"; ?> id="ckbox3"onchange="autoInsertOther()"/>

			៣	ច្បាប់ថតចម្លងប័ណ្ណប៉ាតង់....................................................................................................................................០១ច្បាប់<br></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox4" <?php  if($rowdocument->Field4==1) echo "checked"; ?>  id="ckbox4"onchange="autoInsertOther()"/>
			៤	សាលាកប័ត្រផ្ដល់ព័ត៌មានស្ដីពីសកម្មភាពអាជីវកម្ម.....................................................................................................០១ច្បាប់<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox5"<?php  if($rowdocument->Field5==1) echo "checked"; ?>  id="ckbox5"onchange="autoInsertOther()"/>
			៥	ច្បាប់ដើមប័ណ្ណសំគាល់ចលនៈ ឬអចលនវត្ថុដាក់បញ្ចាំ................................................................................................០១ច្បាប់
			<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox6" <?php  if($rowdocument->Field4==1) echo "checked"; ?>  id="ckbox6"onchange="autoInsertOther()"/>
			៦	ច្បាប់ថតចម្លងអត្ដសញ្ញាណប័ណ្ណឬសៀវភៅគ្រួសារប្ដី-ប្រពន្ធនៃអ្នកចេញមុខដាក់បញ្ចាំជំនួសប្រសិនជាមាន..........................០១ច្បាប់់<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox7"<?php  if($rowdocument->Field7==1) echo "checked"; ?>  id="ckbox7"onchange="autoInsertOther()"/>
			៧	គម្រោងជំនួញ.....................................................................................................................................................០១ច្បាប់<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox8"  <?php  if($rowdocument->Field8==1) echo "checked"; ?> id="ckbox8"onchange="autoInsertOther()"/>
			៧	គម្រោងជំនួញ.....................................................................................................................................................០១ច្បាប់<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox9"<?php  if($rowdocument->Field9==1) echo "checked"; ?>  id="ckbox9"onchange="autoInsertOther()"/>
			 ៩	លិខិតអនុញ្ញាតចុះបញ្ជី..........................................................................................................................................០១ច្បាប់<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox10"<?php  if($rowdocument->Field10==1) echo "checked"; ?>  id="ckbox10"onchange="autoInsertOther()"/>
			១០	សេចក្ដីសំរេចរបស់ក្រុមប្រឹក្សាភិបាល.....................................................................................................................០១ច្បាប់<br/></p>
			<p style="text-indent: 50px"><input type="checkbox"name="ckbox11" id="ckbox11" <?php  if($rowdocument->Field11==1) echo "checked"; ?> onchange="autoInsertOther()"/>
			១០	សេចក្ដីសំរេចរបស់ក្រុមប្រឹក្សាភិបាល.....................................................................................................................០១ច្បាប់<br/></p>
			</p>
			<p style="text-indent: 20px;">ហើយ (យើង) ខ្ញុំ សូមសន្យាថា នឹងបំពេញបែបបទបន្ថែមទៀត បើអង្គការត្រូវការ ហើយនឹងផ្ដល់នូវរាល់ការប្រែប្រួល ទាក់ទង នឹងគ្រួសារ ទ្រព្យសម្បត្ដិ <p style="text-indent: 20px;">និងរាល់ព្រឹត្ដិការណ៍ឯទៀតដែលអាចធ្វើអោយខូចប្រយោជន៍អង្គការ ។ បើពុំនោះសោតទេ (យើង) ខ្ញុំសុខចិត្ដទទួលខុស <p style="text-indent: 20px;">ត្រូវទាំងស្រុងចំពោះការខាតបង់ដែលបណ្ដាលមកពីការធ្វេសប្រហែស និងការផ្ដល់ព័ត៌មានផ្ទុយ នឹងការពិតពី (យើង)ខ្ញុំ ។</p>
			<br/>
			<p style="text-indent: 20px;">សូមលោក-លោកស្រីមេត្ដាទទួលនូវការគោរពដ៏ជ្រាលជ្រៅអំពីយើងខ្ញុំ ។</p>
			<p style="text-indent: 20px;">ថ្ងៃទី.....ខែ.....ឆ្នាំ២០១.....</p>
			<div class="center">
				<p style="font-family:Khmer OS Muol;">ស្នាមមេដៃស្ដាំ</p>
			</div>
			<span style="margin-left: 100px;">⧠ អ្នកដាក់បញ្ចាំជំនួស ⧠ អ្នកធានាដាក់បញ្ចាំជំនួស   </span>
			<span style="margin-left: 40px;">⧠ អ្នកធានាដាក់បញ្ចាំជំនួស</span>
			<span style="margin-left: 40px;">⧠ អ្នករួមសុំខ្ចីចងការ អ្នកសុំខ្ចីចងការ</span><br/><br/><br/><br/>
			<span style="margin-left: 100px;font-family:Khmer OS Muol;">(ប្រសិនមាន)     ឈ្មោះ<span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></span>
			<span style="margin-left: 40px;font-family:Khmer OS Muol;"> ឈ្មោះ<span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></span>
			<span style="margin-left: 40px;font-family:Khmer OS Muol;"> ឈ្មោះ<span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></span>
			<span style="margin-left: 40px;font-family:Khmer OS Muol"> ឈ្មោះ<span id="v"><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............";}?></span></i></b>

		</div>

		<!-- end page20 -->
	
		<!--  page21 -->
		<div class="page">
			<div class="twin">
				<div class="twin_content">
					<p style="font-family:Khmer OS Muol;"><u>យោបល់របស់អ្នកអង្កេតលើកទី២</u></p>
					<p align="center">.................................................................................<br/>
					.................................................................................<br/>
					.................................................................................<br/>
					.................................................................................<br/>
					.................................................................................<br/>
					.................................................................................<br/>
					.................................................................................<br/>
					.................................................................................<br/>
					</p>
					<p align="center">ថ្ងៃទី................ខែ................ឆ្នាំ.....................</p><br/></br/<br/><br/>
					<p align="center"style="font-family:'Khmer OS Muol'" >ហត្ថលេខា<span id="v"><?php echo " ".$rowco->staff_nameinkhmer." "; ?></span></p><br>
				</div>
				<div class="twin_content">
					<p style="font-family:Khmer OS Muol;"><u>យោបល់របស់មន្រ្តីឥណទាន</u></p>
					<p>យោងប្រវត្តិអតិថិជន<span id="v"><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............";}?></span></i></b>

					មុខរបរ<span id="v"><?php if($clientco=="Have Record"){echo $rowclient->Position;} else{echo "............";}?></span></i></b><br>

					ស្ថានភាពមុខរបរ<span id="v"><?php ?></span></i></b>
					<br/>
					លទ្ធភាពសង<span id="v"><?php if($clientco=="Have Record"){echo $rowsummary->CapacityToRepay."$cur";} else{echo "............";}?></span></i></b>

					<p>តាមរបាយការណ៍ហិរញ្ញវត្ថុក្នុងគម្រោងជំនួញ និងតម្លៃទ្រព្យ<br/>សម្បត្តិ ដាក់ធានា ខ្ញុំបាទសូមផ្តល់នូវមតិយោបល់ថា គួរសំរេច<br/>អោយខ្ចីប្រាក់ៈ
					ចំនួនជាលេខៈ<span id="v"><?php echo $rowloan->LoanAmount."​$c "?></span>.<br/>
					ជាអក្សរៈ<span id="v"><?php echo $rowloan->LoanAmount_inword." ";?></span> <br/>
					អត្រាការប្រាក់ៈ<span id="v"><?php echo $rowloan->InterestRate."";?></span> ភាគរយក្នុងមួយខែ<br/>
					រយៈពេលខ្ចីប្រាក់ៈ<span id="v"><?php echo $rowloan->LoanTerm." ";?>ខែ
					</p>
					<br/>
					<br/>
				</div>
			</div>
			
			<div class="center_normal"style="text-align: right;float-right"​​>
        <p style="font-family:Khmer OS Muol;">អនុម័តដោយ</p>
        <p style="text-align: right;float-right">⧠ នាយកសាខា </p>  
        <p style="text-align: right;float-right">⧠ នាយកការិយាល័យប្រតិបត្តិការ</p>
        <p style="text-align: right;float-right">⧠ ប្រធានការិយាល័យប៉ុស្ត</p>
        &nbsp;
        </p>
        <?php 
          $sqr="select staff_nameinkhmer from tbstaff  where staff_id=".$roworganization->RepOrganizationName;
               $resultr=$con->query($sqr);
               $r=$resultr->fetch_object();
               
        ?>
        <p class="year1">ថ្ងៃទី………..ខែ……….ឆ្នាំ២០១…….</p>
        
        <p class="year1" style="font-family:Khmer OS Muol;">ហត្ថលេខា</p><br/><br/><br/><br/>
        <p class="year1" style="font-family:Khmer OS Muol;">ឈ្មោះ<span id="v"><?php if($countbrand=="Have Record"){echo" ".$r->staff_nameinkhmer." ";}else{echo "...............";}?></span></span></p>
      </div>
		</div>
		<!-- end page21 -->
			
		<!--  page22 -->
		<div class="page">
			<div class="logo">
				<img src="cfeo.png" alt="logo" width="90">
			</div>
			<div class="kingdom">
				<p >ព្រះរាជាណាចក្រកម្ពុជា</p>
				<p >ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
				<p>កិច្ចសន្យាដាក់ធានា <br/> រវាង</p>
			</div>
			<div class="photo">
				<?php
				
					//$sqlclientphoto="select * from tbclient_photo where LoanRequestID=".$_SESSION['getLoanRequestID'];
					$sqlclientphoto="call sp_repgetclientphoto($_SESSION[getLoanRequestID])";
					$resultclientphoto=$con->query($sqlclientphoto);
					$rowclientphoto=$resultclientphoto->fetch_object();

					if($rowclientphoto){
						$ph=1;
					}
					else{
						$ph=0;
					}
					
				?>

				<div class="group_photo"><p align="center">
				<?php 
					if($ph==1){
						echo '<img width="90" height="100"src="data:image/jpeg;base64,'.base64_encode($rowclientphoto->Photo).'"/>';
					}
					if($ph==0){
						echo '<div style="width:90px;min-height:100px"></div>';
					}
		 		?>
		 		</p>
		 		</div>
		 		
				<div class="group_photo"><p align="center">	
				<?php 
				try{
					 if($countbrand=="Have Record"){$xx=$roworganization->RepOrganizationName;}else{ $xx='NA';}
					 if($xx!='NA'){mysqli_next_result($con);
					 		$mysqltest="select staff_nameinkhmer,photo from tbstaff where staff_id=".$xx;
					 		$result=$con->query($mysqltest);
					 		if($myrow=$result->fetch_object()){
								echo '<img src="../../photo/'.$myrow->photo.'"width=\'90px\'height=\'100px\' />';
								$roworganization->RepOrganizationName=$myrow->staff_nameinkhmer;
				 		
					 		}
					 }
					 if($xx=='NA'){
					 	echo "NA";
					 }

					}catch(Exception $ex){
					echo "<script>alert('aaaa')</script>";
					}

					
		 			
		 			
		 					
		 
		 		?>
		 		</div>
				
			</div>
			<p><b>អ្នកទទួលទ្រព្យធានា៖</b></p>
			<div class="tab">
			<p style="text-indent: 50px;">អង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជា សាខា <b><i><span id="v"><?php if($countbrand=="Have Record"){echo "  ".$roworganization->branch_nameinkhmer."";}else{echo "............";}?></span></i></b> 

			តំណាងស្របច្បាប់ដោយ លោក <b><i><span id="v"><?php if($countbrand=="Have Record"){echo "  ".$myrow->staff_nameinkhmer."  ";}else{echo ".........";}?></span></i></b>តួនាទីជា នាយកសាខា ដែលមានក្នុងកិច្ចសន្យានេះហៅថាភាគី (ក) និង</p>

			<p>អ្នកដាក់ទ្រព្យធានា៖</b></p>
			<p style="text-indent: 50px;">ឈ្មោះ <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></i></b>
			ភេទ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Gender;} else{echo "............";}?></span></i></b>

			ថ្ងៃ ខែ ឆ្នាំកំណើត <b><i><span id="v"><?php if($countcoborrower=="Have Record")
			{echo $rowcoborrower->DateOfBirth;} else{echo "............";}?></span></i></b>

			 សញ្ជាតិ<b><i><span id="v"><?php if($countcoborrower=="Have Record")
			 {echo $rowcoborrower->Nationality;} else{echo "............";}?></span></i></b>
			 
			 ដែលមានអត្តសញ្ញាណប័ណ្ណ<input type="checkbox">

			សៀវភៅគ្រួសារ
			<?php if($clientco=="Have Record"){
				if($rowclient->IdentityName=='Family Book '){
					echo '<input type="checkbox" checked>';			
				}else echo '<input type="checkbox">';
				}
				else{
					echo ".........";
				}			
			 ?>	
			សំបុត្របញ្ជាក់កំណើត<input type="checkbox">ផ្សេងៗ<input type="checkbox">
			.....លេខ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->IDNo."  ";}else{echo".............";}?></span></i></b>។ 

			និងឈ្មោះ<b><i><span id="v"> <?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></i></b> 
			ភេទ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Gender;} else{echo "............"; } ?></span></i></b>

			ថ្ងៃ ខែ ឆ្នាំកំណើត<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->DateOfBirth;} else{echo "............"; } ?></span></i></b>

			សញ្ជាតិ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Nationality;} else{echo "............"; } ?></span></i></b>

			ដែលមានអត្តសញ្ញាណប័ណ្ណ<b><i><span id="v"><input type="checkbox"></span></i></b>

		    សៀវភៅគ្រួសារ<b><i><span id="v"><?php if($clientco=="Have Record"){
				if($rowclient->IdentityName=='Family Book '){
					echo '<input type="checkbox" checked>';			
				}else echo '<input type="checkbox">';}
				else{
					echo "......";
				}		
			 ?></span></i></b>សំបុត្របញ្ជាក់កំណើត<b><i><span id="v"><input type="checkbox"></span></i></b>ផ្សេងៗ<b><i><span id="v"><input type="checkbox"></span></i></b>

			 .....លេខៈ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IDNo;} else{echo "............"; } ?></span></i></b>។
			</p>
			<p>មានអាសយដ្ឋាន ផ្ទះលេខ <b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->HouseNo;} else{echo "............"; } ?></span></i></b>

			 ផ្លូវលេខ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Street;} else{echo "............"; } ?></span></i></b>

			 ក្រុមទី<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->GroupNo;} else{echo "............"; } ?></span></i></b>

			 ភូមិ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Village;} else{echo "............"; } ?></span></i></b>
			ឃុំ/សង្កាត់<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->HouseNo;} else{echo "............"; } ?></span></i></b>

			ស្រុក/ខ័ណ្ឌ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->District;} else{echo "............"; } ?></span></i></b>

			ខេត្ត/ក្រុង<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Province;} else{echo "............"; } ?></span></i></b>។</p>
			<p style="text-indent: 50px;">ភាគី (ក)និងភាគី(ខ)ព្រមព្រៀងគ្នាតាមលក្ខខណ្ឌដូចតទៅៈ </p>
			</div>
			<p><b>ប្រការ១</b><div class="tab"> យោងតាមកិច្ចសន្យាខ្ចីចងការប្រាក់ចុះថ្ងៃទី<b><i><span id="v"><?php echo "  ".$rowloan->LoanDate."  " ?></span></i></b>។ ភាគី(ក)បានយល់ព្រមឱ្យភាគី(ខ) ខ្ចីប្រាក់ចំនួន<b><i><span id="v"><?php echo "  ".$rowloan->LoanAmount." $cur " ?></span></i></b> រយៈពេល<b><i><span id="v"><?php echo "  ".$rowloan->LoanTerm."​​​  ខែ " ?></span></i></b></p>
			</div><p>
			<p style="text-indent: 20px;">ហើយភាគី(ខ)បានព្រមព្រៀងដាក់ធានាជូនទៅភាគី(ក)នូវអចលនវត្ថុ ចលនវត្ថុ និងឯកសារដូចខាងក្រោមៈ</p>
			<p><b>១. ប្រភេទទ្រព្យដាក់ធានា</b></p>
			<p><i>១.១ ប្រភេទចលនះទ្រព្យ</i></p>
			<table border="1" style="width:100%" align="center">
				<?php
				 try{
					$sqlcollatoraldetail="select * from tbcollatoraldetail CD inner join tbcollateraltype CT on CT.CollateralTypeId=CD.CollateralType inner join tbclienttype CL on CL.ClientTypeID=CD.Owner where LoanRequestID=".$_SESSION['getLoanRequestID'];
							$resultcollatoraldetail=$con->query($sqlcollatoraldetail);

							 while($rowcollatoraldetail=$resultcollatoraldetail->fetch_object()){
							 	if($rowcollatoraldetail->Currency==1){
							 		$curr=" រៀល";
							 	}else{
							 		$curr=" ដុល្លារ";
							 	}
							 	echo "<tr><td>-ប្រភេទទ្រព្យបញ្ចាំ<span id='v'>".$rowcollatoraldetail->CollateralTypeInKhmer."</span><br>-ប្រភេទឯកសារ<span id='v'>".$rowcollatoraldetail->TypeOfDocurment."</span><br>-លេខ <span id='v'>".$rowcollatoraldetail->DocumentNo."</span>";
							 	echo "<td>-ខាងជើងទល់<span id='v'>".$rowcollatoraldetail->North."</span><br>-ខាងត្បូងទល់<span id='v'>".$rowcollatoraldetail->South."</span><br>-ខាងកើតទល់<span id='v'>".$rowcollatoraldetail->East."</span><br>-ខាងលិចទល់<span id='v'>".$rowcollatoraldetail->West."</span><br>";
							 	echo "<td>-តម្លៃបញ្ចាំ <span id='v'>".$rowcollatoraldetail->EstimatePrice."$curr</span><br>-តម្លៃលក់បន្ទាន់ <span id='v'>".$rowcollatoraldetail->SaleUrgentPrice."$curr</span><br>-កម្មសិទ្ធិរបស់<span id='v'>".$rowcollatoraldetail->ClientTypeInKhmer."</span>";
							}
				}catch(Exception $ex){
echo "<script>alert('aaaaaaaa')</script>";
				}
				
				
				?>

				
			</table>
			<p><b><i>១.២អចលនះទ្យព្យ</i></b></p>
			<table border="1" style="width:100%" align="center">
				<?php
				//========by ratha for show table on colateral vehcle=======//
				 try{
					$sqlcollatoralvehcle="select * from tbcollateraldetailvehcle CD inner join tbcollateraltype CT on CT.CollateralTypeId=CD.CollateralType inner join tbclienttype CL on CL.ClientTypeID=CD.Owner where LoanRequestID=".$_SESSION['getLoanRequestID'];
							$resultcollatoralvehcle=$con->query($sqlcollatoralvehcle);
							 while($rowcollatoralvehcle=$resultcollatoralvehcle->fetch_object()){
							 	if($rowcollatoralvehcle->Currency==1){
							 		$curvechcle=" រៀល";
							 	}else{
							 		$curvechcle=" ដុល្លារ";
							 	}
							 	echo "<tr><td>-ប្រភេទទ្រព្យបញ្ចាំ<span id='v'>".$rowcollatoralvehcle->CollateralTypeInKhmer."</span><br>-ប្រភេទឯកសារ<span id='v'>".$rowcollatoralvehcle->DocurmentType."</span><br>-លេខ <span id='v'>".$rowcollatoralvehcle->DocumentNo."</span>";
							 	echo "<td>-ប្រភេទយានយន្ត<span id='v'>".$rowcollatoralvehcle->Model."</span><br>-សេរ៉ីរថយន្ត<span id='v'>".$rowcollatoralvehcle->SerialOfModel."</span><br>-ថាមពល<span id='v'>".$rowcollatoralvehcle->Power."</span><br><br>";
							 	
							 	echo "<td>-តំលៃបញ្ចាំ<span id='v'>".$rowcollatoralvehcle->EstimatePrice."$curvechcle</span><br>
							 			-តំលៃលក់បន្ទាន់<span id='v'>".$rowcollatoralvehcle->SaleUrgent."$curvechcle</span><br>
							 			-កម្មសិទ្ធិរបស់<span id='v'>".$rowcollatoralvehcle->ClientTypeInKhmer."</span><br><br>";
							 	
								}

					
				}catch(Exception $ex){
				}
				?>
				</table>

			<p><b>២. ប្រភេទឯកសារដាក់តម្កល់</b></p>
			<table border="1px" align="center" width='100%'>
				<tr>
					<th align="center">ល.រ</th>
					<th align="center">ឈ្មោះឯកសារ</th>
					<th align="center">លេខ</th>
					<th align="center">ចុះថ្ងៃទី ខែ ឆ្នាំ</th>
					<th align="center">ចេញដោយ</th>
				</tr>
				
				
					<?php
						$sqlcol="select * from tbcollatoraldetail where LoanRequestID=".$_SESSION['getLoanRequestID'];
						$resultcol=$con->query($sqlcol);
						$count=0;
						while($rowcol=$resultcol->fetch_object()){
							$count+=1;
							echo "<tr><td style='text-align:center'>".$count."<td style='text-align:center'>".$rowcol->TypeOfDocurment."<td style='text-align:center'>".$rowcol->DocumentNo."<td style='text-align:center'>".$rowcol->IssuedDate."<td style='text-align:center'>".$rowcol->IssuedBy;
						}

						$sqlveh="select * from tbcollateraldetailvehcle where LoanRequestID=".$_SESSION['getLoanRequestID'];
						$resultveh=$con->query($sqlveh);
					
						while($rowveh=$resultveh->fetch_object()){
							$count+=1;
							echo "<tr><td style='text-align:center'>".$count."<td style='text-align:center'>".$rowveh->DocurmentType."<td style='text-align:center'>".$rowveh->DocumentNo."<td style='text-align:center'>".$rowveh->IssuedDate."<td style='text-align:center'>".$rowveh->IssuedBy;
						}
					?>
			
			</table>
		</div>
		<!-- end page22 -->
			<br><br>
		<!--  page23 -->
		
		<div class="page">
			<br/>
			<p><b><u>ប្រការ២</u> </b></p>	
			<div class="tab">
			<p>២.១​ ភាគី(ខ)ធានាថាអចលនវត្ថុដាក់ធានា គឺពិតជាកម្មសិទ្ធិរបស់ខ្លួន និងពុំមានដាក់បញ្ចាំជាមួយបុគ្គលណាម្នាក់ឡើយ។ប្រសិនបើការអះអាងនេះផ្ទុយពីការពិត ភាគី(ខ)នឹងត្រូវទទួលខុសត្រូវទាំងស្រុងចំពោះមុខច្បាប់។</p>

			<p>២.២  ភាគី(ខ)សន្យាថាក្នុងរយៈពេលនៃការដាក់បញ្ចាំនេះនឹងមិនធ្វើការរុះរើ  ផ្លាស់ប្តូរ  កែប្រែ  លក់  ផ្ទេរ  ធ្វើអំណោយ ឬដាក់បញ្ចាំអោយទៅបុគ្គលណាផ្សេងឡើយនិងធានាថែរក្សា រៀបចំអចលនទ្រព្យទាំងនេះ ឲ្យនៅក្នុងលក្ខខណ្ឌល្អរហូតដល់បំណុលត្រូវបានទូរទាត់សងរួចហើយភាគី(ក)នឹងប្រគល់ប័ណ្ណកម្មសិទ្ធិ ឬលិខិតបញ្ជាក់ដែលបានទទួលពីភាគី(ខ) ទៅភាគី(ខ)វិញ។  </p>
			<p>២.៣  ករណីភាគី(ខ)អនុវត្តមិនបានត្រឹមត្រូវតាម    កិច្ចសន្យាខ្ចីប្រាក់ទេនោះភាគី(ខ)សុខចិត្តលក់ឡាយឡុងអចលនវត្ថុដាក់ធានាខាងលើដើម្បីសងបំណុលទាំងប្រាក់ដើម ការប្រាក់ និងពិន័យឲ្យគ្រប់ចំនួន ឬភាគី(ក) ប្តឹងទៅតុលាការ ដើម្បីរឹបអូសអចលនវត្ថុដាក់ធានា និងទ្រព្យសម្បត្តិផ្សេងៗ ទៀតលក់ឡាយឡុងដើម្បីយកប្រាក់មកសងបំណុលអោយបានគ្រប់ចំនួនទាំងដើម ការប្រាក់ និងប្រាក់ពិន័យ ហើយរាល់ការចំណាយផ្សេងៗជាបន្ទុករបស់ភាគី(ខ)។</p>
			<p>២.៤  ភាគី(ក)និងភាគី(ខ)សន្យាយ៉ាងម៉ឺងម៉ាត់ថា នឹងគោរពតាមប្រការទាំងឡាយដូចមានចែងខាងលើ។
			ក្នុងការអនុវត្តន៍ផ្ទុយ ឬដោយរំលោភលើប្រការណាមួយ ភាគីដែលល្មើសត្រូវទទួលខុសត្រូវចំពោះមុខច្បាប់។
			កិច្ចសន្យាមានប្រសិទ្ធភាពចាប់ពីថ្ងៃចុះហត្ថលេខានិងផ្តិតមេដៃនេះតទៅ។
			</p>
			</div>
			<div class="twin">
				<div class="twin_content">
					<p style="font-family:Khmer OS Muol;align="center"">
						ភាគីដាក់ធានា ¬ភាគី ("ខ")<br/>
						ស្នាមមេដៃ
					</p>
					<div class="figner_print"></div>
					<div class="figner_print"></div>
					<div class="figner_print"></div>
					<div class="figner_print"></div>
				</div>
				<div class="twin_content">
					<br/>
					<br/>
					<p>ធ្វើនៅភូមិ...................ថ្ងៃទី....... ខែ............ ឆ្នាំ២០១...</p><br/>
					<p style="text-indent:100px;font-family:Khmer OS Muol;">
					ភាគីអ្នកទទួលធានា<br>¬ភាគី("ក")តំណាងអង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជា</p>
						<p style="text-indent:100px;font-family:Khmer OS Muol;">នាយកសាខា
					</p>
					<br/>
					<br/>
					<br/>

						<p style="text-indent:100px;"><span id="v"><?php if($countbrand=="Have Record"){echo" ".$roworganization->RepOrganizationName."";}else{echo ".........";}?></span></p>
				</div>
			</div>

			
			<div style="margin-top:40px; margin-left: 0px; width: 500px;">
				
				<span id="v"><?php if($clientco=="Have Record"){echo $rowclient->NameInKhmer;} else{echo "............"; } ?></span></span​>
				&nbsp;
				<span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></span​>
				&nbsp;
				<span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></span​>
				&nbsp;
				<span id="v"><span​ id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></span​>
			</div> 
			<div class="center_format format">
				<br/>
				<div class="signature">
				<p style="font-family:Khmer OS Muol;">បានឃើញ និងបញ្ជាក់ថា</p>
					<p style="font-family:Khmer OS Muol;">ស្នាមមេដៃខាងលើពិតជារបស់ភាគី (ខ) និងហត្ថលេខា <br/> ពិតជារបស់ភាគី(ក) អចលនវត្ថុដាក់ធានាពិតជាកម្មសិទ្ធិ<br/>
				ស្របច្បាប់របស់ភាគី(ខ) និងមិនមានពាក់ព័ន្ធ ឬទំនាស់<br/>ជាមួយអ្នកណាផ្សេងឡើយ។  
				</b></p></span>
				<p align="center">ថ្ងៃទី...........ខែ.	............. ឆ្នាំ២០១.......</p>
				<p align="center">មេភូមិ ....................................</p>
				<br/>
				<br/>
				<br/>
				<p align="center">...............................</p></div>
			</div>
		</div>
		<!-- end page23 -->
		
	
		<!-- page24 -->

		<div class="page">
			<div class="logo">
				<img src="cfeo.png" alt="logo" width="90">
			</div>
			<div class="kingdom">
				<p>ព្រះរាជាណាចក្រកម្ពុជា</p>
				<p>ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
				<p>កិច្ចសន្យាខ្ចីប្រាក់<br/></p>
			</div>
			<div class="loan">
				<p>គណនីកម្ចី : .................</p>
				<p>គណនីអតិថិជនៈ...........................</p>
			</div>
			<br/>
			<p style="text-indent:270px;">ធ្វើនៅ ថ្ងៃទី.............ខែ............  ឆ្នាំ................<br/><b>រវាង</b></p>
			<p>១- ភាគីឱ្យខ្ចីប្រាក់ៈ <b class="khmer_os_muol">អង្គការសេដ្ឋកិច្ជគ្រួសារកម្ពុជា</b></p>
			<div class="tab"> 
		តំណាងស្របច្បាប់ដោយ លោក <b><i><span id="v"><?php if($countbrand=="Have Record"){echo "  ".$roworganization->RepOrganizationName."  ";}else{echo ".........";}?></span></i></b>
			នាទីជា<b class="khmer_os_muol">នាយកសាខា </b>ជាម្ចាស់បំណុល តទៅនេះហៅកាត់ថា ភាគី «<b class="khmer_os_muol">ក</b>»។
			</div>
			
			<p>២-ភាគីសុំខ្ចីប្រាក់ៈឈ្មោះ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->NameInKhmer."  ";}else{echo "...............";}?></span></i></b>

			ភេទ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->Gender." ";}else{echo "................";} ?></span></i></b>

			សញ្ជាតិ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->Nationality."  ";}else{echo "..............";} ?></span></i></b>
			ថ្ងៃខែឆ្នាំកំណើត<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->DateOfBirth."  ";}else{echo ".............";} ?></span></i></b>
			ឯកសារកំណត់អត្តសញ្ញាណ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->IdentityName."  ";}else{echo "............";} ?></span></i></b>

		<div class="tab">លេខ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->IDNo."  ";}else{echo "...............";}?></span></i></b>

			ចុះថ្ងៃទី<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->IssuedDate."  ";}else{echo "............";}?></span></i></b>

			ចេញដោយ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->IssuedBy."  ";}else{echo "............";}?></span></i></b>

			និងឈ្មោះ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></i></b>

			ភេទ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Gender;} else{echo "............";}?></span></i></b>

			សញ្ជាតិ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Nationality;} else{echo "............";}?></span></i></b>

			ថ្ងៃខែឆ្នាំកំណើត<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->DateOfBirth;} else{echo "............";}?></span></i></b>

			ឯកសារកំណត់អត្តសញ្ញាណ <b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IdentityName;} else{echo "............";}?></span></i></b>

			លេខ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IDNo;} else{echo "............";}?></span></i></b>

			ចុះថ្ងៃទី<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IssuedDate;} else{echo "............";}?></span></i></b>

			ចេញដោយ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->IssuedBy;} else{echo "............";}?></span></i></b><!-- ត្រូវជា<b><i><span id="v"><?php// echo "  ".$//rowcoborrower->relatedTo."  " ?> --></span></i></b>

			អាស័យដ្ឋានបច្ចុប្បន្នៈ ផ្ទះលេខ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->HouseNo;} else{echo "............";}?></span></i></b>

			ផ្លូវលេខ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Street;} else{echo "............";}?></span></i></b>

			ក្រុមទី<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->GroupNo;} else{echo "............";}?></span></i></b>

			ភូមិ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Village;} else{echo "............";}?></span></i></b>

			ឃុំ/សង្កាត់<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Commune;} else{echo "............";}?></span></i></b>

			ស្រុក/ខណ្ឌ/ក្រុង<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->District;} else{echo "............";}?></span></i></b>

			ខេត្ត/រាជធានី<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->Province;} else{echo "............";}?></span></i></b>

			តទៅហៅកាត់ថាភាគី«<b class="khmer_os_muol">ខ</b>»</p>

			<p style="text-index: 50px;">ភាគី«<b class="khmer_os_muol">ក</b>»និងភាគី«<b class="khmer_os_muol">ខ</b>»បានព្រមព្រៀងចុះកិច្ចសន្យាខ្ចីប្រាក់ ដោយអនុវត្តតាមរាល់ប្រការដូចខាងក្រោម :</p>
			<p class="khmer_os_muol">ប្រការ១ 		អំពីលក្ខខណ្ឌរួម</p>
			<p>លើមូលដ្ឋាននៃការស្នើសុំខ្ចីប្រាក់ សេចក្តីណែនាំស្តីពីគោលការណ៍ និងលក្ខខណ្ឌរួមនៃការអោយខ្ចីប្រាក់ភាគី«ក»យល់ព្រមអោយ ភាគី «<b class="khmer_os_muol">ខ</b>» ខ្ចីប្រាក់ ហើយភាគី «<b class="khmer_os_muol">ខ</b>» ក៏ព្រមទទួលនិងសន្យាសងមកភាគី «<b class="khmer_os_muol">ក</b>» វិញជាដាច់ខាតនូវប្រាក់ខ្ចីនេះតាមចំនួន និងរាល់លក្ខខណ្ឌ ដែលបានព្រមព្រៀងដូចតទៅនេះ:</p>
		</div>
			<p><b>១.១ - ទ្រព្យដាក់ធានា </b></p>
			<div class="tab">
				<p>
				<input type="checkbox" name="" id="">
				 ក្រោមការដាក់ធានាដើម្បីធានាបំណុលទាំងដើម និងការប្រាក់ :</p>
				<!-- <p>-<?php 
				//	if($rowcollatoraldetail->CollatoralType==1){
				//		echo '<input type="checkbox" checked>'; 
				//	}else echo '<input type="checkbox">'; 
				 ?> -->
				  <p>ចលនទ្រព្យ,</i></b><br>
				 <!--  <?php 
				//	if($rowcollatoraldetail->CollatoralType==2){
				//		echo '<input type="checkbox" checked>'; 
				//	}else echo '<input type="checkbox">'; 

				 ?> --><?php
				 //=======by Ratha for proted on show colateraldetail
				$sqlcollatoraldetailguranter="select * from tbcollatoraldetail CD inner join tbcollateraltype CT on CT.CollateralTypeId=CD.CollateralType where LoanRequestID=".$_SESSION['getLoanRequestID'];
					$resultcolaterquranter=$con->query($sqlcollatoraldetailguranter);
					$rowcolateralqurater=$resultcolaterquranter->fetch_object();

				$sqlcollatoraldetailprotect="select count(*) as cfeo from tbcollatoraldetail CD inner join tbcollateraltype CT on CT.CollateralTypeId=CD.CollateralType where LoanRequestID=".$_SESSION['getLoanRequestID'];
					$resulcloateralprotect=$con->query(	$sqlcollatoraldetailprotect);

				while ($rowcolateralprotect=$resulcloateralprotect->fetch_object()){
				if ($rowcolateralprotect->cfeo>0){
						$cfeoshow="Have Record";
				}
				else{
					$cfeoshow="No Record";
				}
	
					}	
				
				?>
				  អចលនទ្រព្យ របស់ឈ្មោះ <b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->NameInKhmer."  ";}else{echo "..........";}?></span></i></b> 

				  និងឈ្មោះ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></i></b>

				   ក្នុងលិខិតកម្មសិទ្ឋិ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->NameInKhmer."  ";}else{echo ".............";}?></span></i></b>

				   លេខ<b><i><span id="v"><?php if($cfeoshow=="Have Record"){echo"".$rowcolateralqurater->DocumentNo;}else{echo "...........";}?></span></i></b>

				 ចេញដោយ<b><i><span id="v"><?php if($cfeoshow=="Have Record"){echo "  ".$rowcolateralqurater->IssuedBy." ";}else{echo "............";}?></span></i></b>

				 ដែលមានបញ្ជាក់ក្នុងកិច្ចសន្យាដាក់ធានាលេខ <b><i><span id="v"><?php if($cfeoshow=="Have Record"){echo "  ".$rowcolateralqurater->CollatoralID."";}else{echo "..........";}?></span></i></b>

				 ចុះថ្ងៃទី <b><i><span id="v"><?php if($cfeoshow=="Have Record"){echo "  ".$rowcolateralqurater->IssuedDate." ";}else{echo "............";}?></span></i></b>

				 បានបញ្ជាក់ដោយ<b><i><span id="v"><?php if($cfeoshow=="Have Record"){echo "  ".$rowcolateralqurater->IssuedBy."";}else{echo "............";}?></span></i></b></p>

				<p>+ភាគី«<b class="khmer_os_muol">ខ</b>» អះអាងថា ទ្រព្យសម្បត្តិដែលបានដាក់ធានា មានបញ្ជាក់ក្នុងប្រការ ១.១ ខាងលើពិតជាកម្មសិទ្ឋិស្របច្បាប់ផ្ទាល់ របស់ខ្លួន ក្រុមហ៊ុន ឫអ្នកដាក់ធានាជំនួស ដោយពុំជាប់ពាក់ព័ន្ឋនឹងអ្វីមួយ ឫជនណាមួយឡើយ ដែលធ្វើឱ្យបាត់បង់កាតព្វកិច្វជា កម្មសិទ្ឋករ ហើយបើផ្ទុយពីនេះនឹងទទួលខុសត្រូវចំពោះមុខច្បាប់ ។</p>
			</div>
			<p><b>១-២ ប្រាក់កម្ចីៈ</b></p>
			<div class="tab">
				<pstyle="font-family:Khmer OS Muol;">-ភាគី «ខ» បានទទួលប្រាក់កម្ចីចំនួនជាលេខ<b><i><span id="v"><?php echo "  ".$rowloan->LoanAmount."$cur " ?></span></i></b>  ជាអក្សរ <b><i><span id="v"><?php echo "  ".$rowloan->LoanAmount_inword."  " ?></span></i></b> ។</p>
				<p>- រយៈពេលខ្ចីប្រាក់ៈ  <b><i><span id="v"><?php echo "  ".$rowloan->LoanTerm." ខែ " ?></span></i></b> 

				<p>- របៀបសងប្រាក់ៈ  អនុវត្តន៍តាមតារាងកាលវិភាគសងប្រាក់ ។</p>
				<p>- អត្រាការប្រាក់ៈ  <b><i><span id="v"><?php echo "  ".$rowloan->InterestRate." %  " ?></span></i></b>   ក្នុង
					<?php 
						if($rowloan->LoanTerm==1){
							echo '<input type="checkbox" checked>';
						}else echo '<input type="checkbox">';
					 ?>
					មួយថ្ងៃ,
					<?php 
						if($rowloan->LoanTerm==7){
							echo '<input type="checkbox" checked>';
						}else echo '<input type="checkbox">';
					 ?>
					មួយសប្តាហ៍, 

					<?php 
						if($rowloan->LoanTerm==15){
							echo '<input type="checkbox" checked>';
						}else echo '<input type="checkbox">';
					 ?>
					ពីរសប្តាហ៍,  
					<?php 
						if($rowloan->LoanTerm==30){
							echo '<input type="checkbox" checked>';
						}else echo '<input type="checkbox">';
					 ?>		
					មួយខែ</p>
			</div>
			<p>១-៣ លក្ខខណ្ឌបើកប្រាក់ៈ ភាគី «<b class="khmer_os_muol">ខ</b>» បានយល់ព្រម និងតម្រូវអោយភាគី«<b class="khmer_os_muol">ក</b>» បើកប្រាក់អោយតាមលក្ខណៈ</p>
			<div class="tab">
				<p>  <input type="checkbox">ម្នាក់ក្នុងចំណោមភាគី«<b class="khmer_os_muol">ខ</b>», <input type="checkbox"> ទាំងអស់គ្នានៃភាគី«<b class="khmer_os_muol">ខ</b>», <input type="checkbox"> មានតែឈ្មោះ<span id="v"><?php if($clientco=="Have Record"){echo " ".$rowclient->NameInKhmer." ";}else{echo "...........";}?></span></p>
			</div>
			<p>១-៤ ទីកន្លែងបង់ប្រាក់</p>
			<div class="tab">
				<p>- ទៅយកដល់ផ្ទះភាគី«<b class="khmer_os_muol">ខ</b>» ឫមកបង់ដល់ការិយាល័យអង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជា។</p>
			</div>
		</div>

		<!-- end page24 -->

		<!--  page25 -->
		<style type="text/css">
				.page{
					margin-bottom:200px;
				}
		</style>
			<div class="page">
				<p class="khmer_os_muol"><b>ប្រការ ២: អំពីលក្ខខណ្ខពិសេស</b></p>
				<p>២-១  &nbsp;&nbsp;&nbsp;ក្នុងករណីដែលភាគី«ខ» មិនបានការអនុវត្តការសន្យាសងប្រាក់ប្រាក់ដើម និងការប្រាក់តាមការកំណត់នៅចំណុច១.២-១.៣ </p>
				<div class="tab">
					<p>ក្នុងករណីដែលកូនបំណុលសងផ្តាច់មុនកាលកំណត់និងមុនរយៈពេលពាក់កណ្តាលនៃតារាងកាលវិភាគសងប្រាក់   អតិថិជនត្រូវបង់ការប្រាក់រហូតដល់ពាក់កណ្តាលនៃតាងរាងកាលវិភាគ។ ប្រសិនបើអតិថិជនបង់ផ្តាច់ក្រោយរយៈពេលពាក់កណ្តាលនៃតារាងកាលវិភាគ ត្រូវគិតការប្រាក់តាមចំនួនថ្ងៃដែលបានប្រើនិងប្រាក់ដើមដែលនៅសល់។</p>
				</div>
				<p>២-២	&nbsp;&nbsp;&nbsp;ក្នុងករណីដែលកូនបំណុលសងផ្តាច់មុនកាលកំណត់ មុនរយៈពេលពាក់កណ្តាលនៃតារាងកាលវិភាគសងប្រាក់   អតិថិជនត្រូវ</p>
				<div class="tab">
					<p>
					បង់ការប្រាក់រហូតដល់ពាក់កណ្តាលនៃតាងរាងកាលវិភាគ។ 
					ប្រសិនបើអតិថិជនបង់ផ្តាច់ក្រោយរយៈពេលពាក់កណ្តាលនៃតារាងកាលវិភាគត្រូវគិតការប្រាក់តាមចំនួនថ្ងៃដែលបានប្រើនិងប្រាក់ដើមដែលនៅសល់។ </p>
				</div>
				<p>២-៣	&nbsp;&nbsp;&nbsp;ក្នុងករណីដែលខកខានសងបំណុលតាមការកំណត់តាមចំណុច ១.២ កន្លងផុតរយៈពេល ០១ខែភាគី «ខ» សុខចិត្តលក់ទ្រព្យ </p>
				<div class="tab">
					<p>សម្បត្តិរបស់ខ្លួនដើម្បីទូទាត់បំណុល ឫឱ្យអ្នកធានាបំណុលរបស់ខ្លួន ដែលបានសងជំនួស ឫភាគី«ក» កាត់កងឫប្តឹង ទៅតុលាការ ដើម្បីរឹបអូសទ្រព្យសម្បត្តិខ្លួនជាចលនទ្រព្យ អចលនទ្រព្យដែលដាក់ធានា ឫទ្រព្យសម្បត្តិផ្សេងទៀត ដូចជា សន្និធិ ទំនិញ ចលនទ្រព្យ ឫអចលនទ្រព្យ ដែលមានក្រៅពីទ្រព្យដាក់ធានា លក់ឡាយឡុង ដើម្បីកាត់យកមកទូទាត់ប្រាក់សំណង ដែលបានសងជួស ឫទូទាត់បំណុលដែលនូវជំពាក់ ភាគី «ខ» ត្រូវមានកាតព្វកិច្ច សងបំណុលដែលនៅសល់បន្ថែមទៀត រហូតទាល់តែគ្រប់ចំនួន ។</p>
				</div>
		
				<p><b>ប្រការ៣:​​ អំពីអ្នកធានាបំណុល</b></p>
				<p>៣-១ 	&nbsp;&nbsp;&nbsp;ភាគីអ្នកធានាប្រាក់ៈឈ្មោះ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></i></b>

				ភេទ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Gender;} else{echo "............"; } ?></span></i></b>  

				 សញ្ជាតិ <b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Nationality;} else{echo "............"; } ?></span></i></b> 

				 ថ្ងៃខែឆ្នាំកំណើត <b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->DateOfBirth;} else{echo "............"; } ?></span></i></b></p>
				<div class="tab">
				<p>ឯកសារកំណត់អត្តសញ្ញាណ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IdentityName;} else{echo "............"; } ?></span></i></b>

				លេខ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IDNo;} else{echo "............"; } ?></span></i></b>

				ចុះថ្ងៃទី <b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IssuedDate;} else{echo "............"; } ?></span></i></b>

				ចេញដោយ <b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IssuedBy;} else{echo "............"; } ?></span></i></b>

				និងឈ្មោះ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></i></b>

				ភេទ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Gender;} else{echo "............"; } ?></span></i></b>

				សញ្ជាតិ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Nationality;} else{echo "............"; } ?></span></i></b>

				ថ្ងៃខែឆ្នាំកំណើត<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->DateOfBirth;} else{echo "............"; } ?></span></i></b>

				ឯកសារកំណត់អត្តសញ្ញាណ <b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IdentityName;} else{echo "............"; } ?></span></i></b>

				លេខ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IDNo;} else{echo "............"; } ?></span></i></b>

				ចុះថ្ងៃទី<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IssuedDate;} else{echo "............"; } ?></span></i></b>

				ចេញដោយ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->IssuedBy;} else{echo "............"; } ?></span></i></b>

					ត្រូវជាអ្នកធានាបំណុល។អាស័យដ្ឋានបច្ចុប្បន្នៈផ្ទះលេខ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->HouseNo;} else{echo "............"; } ?></span></i></b>

					ផ្លូវលេខ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Street;} else{echo "............"; } ?></span></i></b>

					ក្រុមទី<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->GroupNo;} else{echo "............"; } ?></span></i></b>

					ភូមិ<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Village;} else{echo "............"; } ?></span></i></b>
					ឃុំ/សង្កាត់<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Commune;} else{echo "............"; } ?></span></i></b>

					ស្រុក/ខណ្ឌ/ក្រុង<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->District;} else{echo "............"; } ?></span></i></b>

					ខេត្ត/រាជធានី<b><i><span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->Province;} else{echo "............"; } ?></span></i></b>។
				</p>

				</div>
				<p>៣-២	&nbsp;&nbsp;&nbsp;អ្នកធានាមានសិទ្ធិស្មើរនិងអ្នកខ្ចី ក្នុងករណីដែលអ្នកខ្ចីរត់ចោលបំណុល មិនព្រមសងបំណុល គេចមិនចូលផ្ទះ គ្មានលទ្ធភាពសង</p>
				<div class="tab">
					<p>បំណុលមកវិញទេ នោះកាតព្វកិច្ចទាំងឡាយរបស់ភាគី(ខ)ត្រូវធ្លាក់មកលើអ្នកធានាបំណុលទាំងស្រុង។</p>
				</div>
				<p>៣-៣	&nbsp;&nbsp;&nbsp;ក្រែងមិនពិតប្រាកដ យើងខ្ញុំសុខចិត្តផ្ដិតមេដៃស្ដាំទុកចំណាំចំពោះផ្លូវច្បាប់ ដោយគ្មានការបង្ខិតបង្ខំពីអ្នកណាម្នាក់ឡើយ។</p>
				<p><b>ប្រការ៤:	 អំពីលក្ខខណ្ឌអវសាន</b></p>
				<div class="tab">
					<p>ភាគី «ក» និងភាគី «ខ» សន្យាគោរពយ៉ាងម៉ឺងម៉ាត់តាមរាល់ប្រការនៃខសន្យានានាខាងលើ ។   ក្នុងករណីមានការអនុវត្តផ្ទុយ</p>
					<p>ឫ ដោយរំលោភលើលក្ខណាខណ្ឌមួយនៃកិច្ចសន្យានេះភាគីដែលល្មើស ត្រូវទទួលខុសត្រូវចំពោះមុខច្បាប់ជាធរមាន ។<br/>
					 រាល់សោហ៊ុយ&nbsp;ចំណាយទាក់ទងក្នុងការដោះស្រាយលើវិវាទជាបន្ទុករបស់ភាគីដែលរំលោភបំពានលើកិច្ចសន្យា។កិច្ចសន្យានេះត្រូវបានធ្វើឡើង ដោយមានការព្រមព្រៀងពិតប្រាកដនិងដោយសេរី គ្មានការបង្ខិតបង្ខំពីភាគីណាមួយឡើយ ហើយមានប្រសិទ្ឋភាពចាប់ពីថ្ងៃចុះហត្ថាលេខានេះតទៅ។</p>
				</div>
				<p style="text-indent: 50px;">កិច្ចសន្យានេះត្រូវបានធ្វើឡើងជាពីរច្បាប់ ជាភាសាខ្មែរ ដើម្បីតម្កល់ទុកនៅៈ</p>
				<p style="text-indent: 100px;">	-   ភាគី «ក»   ..............................................០១ (ច្បាប់ដើម)</p>
				<p style="text-indent: 100px;">	- ភាគី «ខ»   ..............................................០១ (ច្បាប់ដើម)</p>
			
				<div class="twin">	
					<div class="twin_content">	
						<p style="font-family:Khmer OS Muol;">ស្នាមមេដៃស្តាំភាគី «ខ»</p><br/><br/><br/><br/>

						<p style="font-family:Khmer OS Muol;">ឈ្មោះ<span id="v"><?php if($clientco=="Have Record"){echo"".$rowclient->NameInKhmer."";}else{echo "............";}?></span>

						ឈ្មោះ<span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></p>
						<p style="font-family:Khmer OS Muol;"align="center">ស្នាមមេដៃស្តាំអ្នកធានា</p><br/><br/><br>
						<p style="font-family:Khmer OS Muol;">ឈ្មោះ<span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span>ឈ្មោះ<span id="v"><?php if($countguarantor=="Have Record"){echo $rowguarantor->NameInKhmer;} else{echo "............"; } ?></span></p>
					</div>
					</div>
					<br><br><br><br><br><br>
					
					<div class="twin_content">	
						<p align="center">ធ្វើនៅ……………………ថ្ងៃទី……..ខែ……………ឆ្នាំ២០១….</p>
						<p><d>តំណាងភាគី «ក»<br/>
						ហត្ថលេខា និងត្រា
						</d>
						</p>
						<br><br><br><br><br>					
						<p style="text-align:right;"><span id="v"><?php if($countbrand=="Have Record"){echo " ".$roworganization->RepOrganizationName." ";}else{echo "...........";}?></span></p>
					</div>
			</div>
			

		<!-- end page25 -->
		<!-- page26 -->
		
		<div class="page">
			<div class="logo">
				<img src="cfeo.png" alt="logo" width="90">
			</div>
			<div class="kingdom">
				<p>ព្រះរាជាណាចក្រកម្ពុជា</p>
				<p>ជាតិ សាសនា ព្រះមហាក្សត្រ</p>
				<p><u>បង្កាន់ដៃតម្កល់ទ្រព្យធានា</u><br/></p>
			</div>
			<br>
			<p align="right">អតិថិជនលេខះ...........................</p>
			<p align="center">  <input type="checkbox">១ .កម្មសិទ្ធិរបស់អតិថិជន          <input type="checkbox"> ២ .កម្មសិទ្ធិរបស់អ្នកផ្សេង</p>
			<p><b>ក-អត្ដសញ្ញាណ</b></p>
			<p>១-អតិថិជនឈ្មោះ ៖<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->NameInKhmer."  ";}else{echo "..........";} ?></span></i></b>និងឈ្មោះ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></i></b>ត្រូវជា<b><i><span id="v"><!-- <?php //echo "  ".$rowcoborrower->relatedTo."  " ?> --></span></i></b></p>
			<p>២-ម្ចាស់កម្មសិទ្ធិឈ្មោះ<b><i><span id="v"><?php if($clientco=="Have Record"){echo "  ".$rowclient->NameInKhmer."  ";}else{echo "..........";}?></span></i></b>និងឈ្មោះ<b><i><span id="v"><?php if($countcoborrower=="Have Record"){echo $rowcoborrower->NameInKhmer;} else{echo "............";}?></span></i></b>ត្រូវជា<b><i><span id="v"><!-- <?php// echo "  ".$rowcoborrower->relatedTo."  " ?> --></span></i></b>
			</p>
			<p>   បានដាក់ទ្រព្យតម្កល់ធានា ប្រាក់កម្ចី<input type="checkbox">   ផ្ទាល់ខ្លួន <input type="checkbox">  ជំនួសអោយកូនបំណុល ពីអង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជា ដែលមានប័ណ្ណ សំគាល់ដូចខាងក្រោម ៖ </p>
			<p><b>ខ-ប្រភេទលិខិតសំគាល់ទ្រព្យតម្កល់ធានា</b></p>
			<div class="tab">
				<?php 


						//	$sqlcallatoral="SELECT *FROM tbcollatoraldetail WHERE LoanRequestID=".$_SESSION['getLoanRequestID'];
				$sqlcallatoral="select * from tbcollatoraldetail CD inner join tbcollateraltype CT on CT.CollateralTypeId=CD.CollateralType where LoanRequestID=".$_SESSION['getLoanRequestID'];

							$resultcollatoral=$con->query($sqlcallatoral);
							$no=0;
							while($rowcollatoral=$resultcollatoral->fetch_object()){
							$no++;
							echo '<p>'.$no.'.    '.$rowcollatoral->CollateralTypeInKhmer.'    លេខៈ'.'    '.$rowcollatoral->DocumentNo.'    ចុះថ្ងៃទី     '.$rowcollatoral->IssuedDate	.'';		
							}
						 ?>		
				<p>ជាកម្មសិទ្ធិរបស់ឈោ្មះ <b><i><span id="v">

				<?php if($clientco=="Have Record"){echo " ".$rowclient->NameInKhmer."  ";}else{echo "..........";}?></span></i></b></p>
			</div>
			<br/>
			<table border="1" align="center">
				
				<tr>
					<td style="text-align:center">
						<p align="center">
							ថ្ងៃទី........ខែ............ឆ្នាំ២០១…..<br/>
							តំណាងអង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជា<br/>
							ហត្ថលេខា និងត្រា  
						</p>
						<br/>
						<br/>
						<p align="center">ឈ្មោះ<span id="v"><?php if($countbrand=="Have Record"){echo " ".$roworganization->RepOrganizationName." ";}else{echo "...........";}?></span></p>
					</td>
					<td style="text-align:center">
						<p align="center">ថ្ងៃទី........ខែ............ឆ្នាំ២០១….. <br/>ហត្ថលេខាអ្នកប្រគល់</p>
						<br/>
						<br/>
						<br/>
						<p align="center">ឈ្មោះ<span id="v"><?php echo " ".$rowco->staff_nameinkhmer; ?></span></p>
					</td>
					<td style="text-align:center">
						<p align="center">ថ្ងៃទី........ខែ............ឆ្នាំ២០១….. <br/>ស្នាមមេដៃអ្នកទទួល</p>
						<br/>
						<br/>
						<br/>
						<p align="center">ឈ្មោះ<span id="v"><?php if($clientco=="Have Record"){echo " ".$rowclient->NameInKhmer." ";}else{echo ".........";}?></span></p>
					</td>
				</tr>
			</table>
			<br/>
		<p style="text-indent: 50px"><b><u>សេចក្ដីបញ្ជាក់៖</u></b> 
		ម្ចាស់កម្មសិទ្ធិត្រូវតែរក្សាទុក បង្កាន់ដៃនេះសំរាប់ដកយកប័ណ្ណកម្មសិទ្ធិ របស់ខ្លួនដែលបានដាក់តម្កល់ ។	 មានតែអ្នកដែលបាន 	&nbsp;&nbsp;ផ្ដិតមេដៃដាក់តម្កល់ទេទើបមាន សិទ្ធិដកយកកម្មសិទ្ធិវិញបាន។ ម្ចាស់កម្មសិទ្ធិអាចដកយកវិញបានលុះត្រាតែរួច បំណុលពីអង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជា 	&nbsp;&nbsp;ហើយភ្ជាប់មកជាមួយនូវ ៖ បង្កាន់ដៃដាក់តម្កល់នេះ។ 	ក្នុងករណីបាត់បង់បង្កាន់ដៃនេះ អង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជាមិនទទួលខុសត្រូវឡើយ ។ &nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ករណីចាំបាច់អង្គការសេដ្ឋកិច្ចគ្រួសារកម្ពុជាតម្រូវឱ្យម្ចាស់កម្មសិទ្ធិស្រប ច្បាប់ធ្វើលិខិតបញ្ជាក់ពីអាជ្ញាធរមូលដា្ឋន ភូមិ/ឃុំ/សង្កាត់ ។</p>
		</div>
		<!-- end page26 -->
</body>
</html>
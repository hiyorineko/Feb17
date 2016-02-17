<?php
	
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta chaset="utf8">
		<title>将棋部</title>
	</head>
	<body>
		<header>
			<h1>将棋部</h1>
			<nav>
				<h2>メニュー</h2>
				<ol>
					<li><a href="member.php">メンバー</a></li>
					<li>成績管理アプリ</li>
				</ol>
			</nav>
		</header>
		<section>
			<article>
				<form action="" method="get">
<input name="seiseki" type="radio" value="1">一覧表示<br>
<input name="seiseki" type="radio" value="2">成績データ登録<br>
<input name="seiseki" type="radio" value="3">成績データ修正<br>
<input name="seiseki" type="radio" value="4">成績データ削除<br>
<input name="seiseki" type="radio" value="5">成績データソート<br><br>
<input type="submit" value="選択"><br><br>
</form>

<?php
	if(!empty($_GET['seiseki'])){
   	  $choice = $_GET['seiseki'];
      switch($choice){
     	case 1:
     	    view();
     		echo "<br>成績一覧です。<br>";
     		break;
     	case 2:
     		view();
     		echo "<br>追加する成績を入力して追加を押してください。<br>";
     		addsets();
     		break;
     	case 3:
     		view();
     		echo "<br>どの学番を修正するか入力して修正ボタンを押してください。<br>";
     		editsets();
     		break;
     	case 4:
     		view();
     		echo "<br>どの学番を削除するか入力して削除ボタンを押してください。<br>";
     		removesets();
     		break;
     	case 5:
     		view();
     		echo "<br>何順にソートするか選択してソートボタンを押してください。<br>";
     		sortsets();
     		break;
     	default:
     		echo "何かがおかしいようです。";
     		break;
 	    }
	}else if(!empty($_GET['remove'])){
		$choice = $_GET['remove'];
		if($choice == 1){
			if(isset($_COOKIE['removeno'])){
				$lines = file('seiseki.csv');
				for($i=0;$i<count($lines);$i++){
     				$datas = split(',',$lines[$i]);//splitした配列
					if($datas[0]==$_COOKIE['removeno']){
						unset($lines[$i]);
					}
     			}
     			$file = "seiseki.csv";
     			file_put_contents($file, $lines);
				echo "削除しました。<br>";
				setcookie('removeno','');
			}
		}else{
			echo "中止しました。<br>";
		}
					
	}else if(!empty($_GET['sort'])){
		$choice = $_GET['sort'];
		$howsort = $_GET['howsort'];
		sortdatas($choice,$howsort);
	}else{
   	  echo "処理区分を選択してください。<br>";
	}
	
	 function sortdatas($choice,$howsort){
	 	$lines = file('seiseki.csv');
	 	$choices;
	 	$newlines;
     	for($i=1;$i<count($lines);$i++){
     	    $datas = split(',',$lines[$i]);//splitした配列
			if($choice == 7){
				$choices[] = $datas[2]+$datas[3]+$datas[4]+$datas[5]+$datas[6];
			}else if($choice == 8){
				$sum = $datas[2]+$datas[3]+$datas[4]+$datas[5]+$datas[6];
				$choices[] = $sum/5;
			}else if($choice ==1){
				$choices[] = intval($datas[0]);
			}else{
				$choices[] = intval($datas[$choice]);
			}
     	}
     	if($howsort==1){
     		for($i=0;$i<count($choices);$i++){
     			for($j=0;$j<count($choices)-1;$j++){
     				if($choices[$j]>$choices[$j+1]){
     					$ctemp = $choices[$j];
     					$choices[$j] = $choices[$j+1];
     					$choices[$j+1] = $ctemp;
     					$temp = $lines[$j+1];
     					$lines[$j+1] = $lines[$j+2];
     					$lines[$j+2] = $temp; 
     				}
     			}
     		}
     	}else{
     		for($i=0;$i<count($choices);$i++){
     			for($j=0;$j<count($choices)-1;$j++){
     				if($choices[$j]<$choices[$j+1]){
     				    $ctemp = $choices[$j];
     					$choices[$j] = $choices[$j+1];
     					$choices[$j+1] = $ctemp;
     					$temp = $lines[$j+1];
     					$lines[$j+1] = $lines[$j+2];
     					$lines[$j+2] = $temp; 
     				}
     			}
     		}
     	}
     	
     	$file = "seiseki.csv";
     	file_put_contents($file, $lines);
		echo "ソートしました。<br>";
		view();
	 }
	 
     function view(){
     	$lines = file('seiseki.csv');
     	for($k=0;$k<count($lines);$k++){
     	    $datas = split(',',$lines[$k]);//splitした配列
     		if($k==0){
     			$datas[] = "合計";
     			$datas[] = "平均";
     			echo "<table border =".'"1"'." align=".'"left"'.">";
     			echo "<thead>\r\n";
     			echo "<tr>\r\n";
     			echo "<th>$datas[0]</th><th>$datas[1]</th><th>$datas[2]</th><th>$datas[3]</th><th>$datas[4]</th><th>$datas[5]</th><th>$datas[6]</th><th>$datas[7]</th><th>$datas[8]</th>\r\n";
     			echo "</tr>\r\n";	
     			echo "</thead>\r\n";
     			echo "<tbody>\r\n";
     		}else{
     			$datas[7] = $datas[2]+$datas[3]+$datas[4]+$datas[5]+$datas[6];
     			$datas[8] = $datas[7]/5;
     			echo "<tr>\r\n";
     			echo "<td>$datas[0]</td><td>$datas[1]</td><td>$datas[2]</td><td>$datas[3]</td><td>$datas[4]</td><td>$datas[5]</td><td>$datas[6]</td><td>$datas[7]</td><td>$datas[8]\r\n</td>\r\n";
     			echo "</tr>\r\n";
     		}
     	}
     		echo "</tbody>\r\n";
     		echo "</table>\r\n";
     		echo "<br><br><br><br><br><br><br><br>";
     }
     
     function removesets(){
			echo '<form action="" method="POST">';
     		echo '<input type = "text" name = "removeno" placeholder="削除する学番"><br>';
    		echo '<input type="submit" value="削除"><br>';
    		echo '</form>';
     }
     function editsets(){
			echo '<form action="" method="POST">';
     		echo '<input type = "text" name = "editno" placeholder="編集する学番"><br>';
     		echo '<input type="submit" value="編集"><br>';
    		echo '</form>';
     }
     function addsets(){
     		echo '<form action="" method="POST">';
     		echo '<input type = "text" name = "gakuban" placeholder="学番"><br>';
			echo '<input type = "text" name = "shimei" placeholder="氏名"><br>';
			echo '<input type = "text" name = "kokugo" placeholder="国語"><br>';
			echo '<input type = "text" name = "sansu" placeholder="算数"><br>';
			echo '<input type = "text" name = "rika" placeholder="理科"><br>';
			echo '<input type = "text" name = "shakai" placeholder="社会"><br>';
			echo '<input type = "text" name = "eigo" placeholder="英語"><br>';
    		echo '<input type="submit" value="追加"><br>';
    		echo '</form>';
     }
     
     function sortsets(){
		echo '<form action="" method="get">';
		echo '<input name="sort" type="radio" value="1" checked>学番<br>';
		echo '<input name="sort" type="radio" value="2">国語<br>';
		echo '<input name="sort" type="radio" value="3">算数<br>';
		echo '<input name="sort" type="radio" value="4">理科<br>';
		echo '<input name="sort" type="radio" value="5">社会<br>';
		echo '<input name="sort" type="radio" value="6">英語<br>';
        echo '<input name="sort" type="radio" value="7">合計<br>';
        echo '<input name="sort" type="radio" value="8">平均<br>';
        echo '<input type="submit" value="ソート">';
        echo '<input name="howsort" type="radio" value="1" checked>昇順';
        echo '<input name="howsort" type="radio" value="2">降順<br>';
        echo '</form>';
     }
	
	function editdata(){
			echo "修正内容を入力して更新ボタンを押してください。";
     		echo '<form action="" method="POST">'; 
			echo '<input type = "text" name = "eshimei" placeholder="氏名"><br>';
			echo '<input type = "text" name = "ekokugo" placeholder="国語"><br>';
			echo '<input type = "text" name = "esansu" placeholder="算数"><br>';
			echo '<input type = "text" name = "erika" placeholder="理科"><br>';
			echo '<input type = "text" name = "eshakai" placeholder="社会"><br>';
			echo '<input type = "text" name = "eeigo" placeholder="英語"><br>';
    		echo '<input type="submit" value="更新"><br>';
    		echo '</form>';
	}
	
	function removedata(){
			echo "本当に削除してもよろしいですか？";
			echo '<form action="" method="get">';
   			echo '<input name="remove" type="radio" value="1">YES';
			echo '<input name="remove" type="radio" value="2">NO<br>';
    		echo '<input type="submit" value="選択"><br>';
    		echo '</form>';
	}
	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		if(!empty($_POST['gakuban'])){
			$gakuban = $_POST['gakuban'];
			$shimei = $_POST['shimei'];
			$kokugo = $_POST['kokugo'];
			$sansu = $_POST['sansu'];
			$rika = $_POST['rika'];
			$shakai = $_POST['shakai'];
			$eigo = $_POST['eigo'];
			$numchk = true;
		
			$lines = file('seiseki.csv');
			foreach($lines as $line){
     			$datas = split(',',$line);//splitした配列
				if($gakuban == $datas[0]){
					$numchk = false;
					echo "同じ学番が存在します。";
				}
     		}	
			if($gakuban>100 || $gakuban<0){
				$numchk = false;
				echo "学番は000~100の範囲の数字でなければいけません。<br>";
			}
			if(strlen($gakuban)!=3){
				$numchk = false;
				echo "学番は3ケタの数字でなければいけません。<br>";
			}
			if(ctype_digit($gakuban)==false){
				$numchk = false;
				echo "学番には数字を入力してください。<br>";
			}
			if($kokugo>100 || $kokugo<0){
				$numchk = false;
				echo "国語の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($kokugo)==false){
				$numchk = false;
				echo "国語の成績には数字を入力してください。<br>";
			}
			if($sansu>100 || $sansu<0){
				$numchk = false;
				echo "算数の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($sansu)==false){
				$numchk = false;
				echo "算数の成績には数字を入力してください。<br>";
			}
			if($rika>100 || $rika<0){
				$numchk = false;
				echo "理科の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($rika)==false){
				$numchk = false;
				echo "理科の成績には数字を入力してください。<br>";
			}
			if($shakai>100 || $shakai<0){
				$numchk = false;
				echo "社会の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($shakai)==false){
				$numchk = false;
				echo "社会の成績には数字を入力してください。<br>";
			}
			if($eigo>100 || $eigo<0){
				$numchk = false;
				echo "英語の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($eigo)==false){
				$numchk = false;
				echo "英語の成績には数字を入力してください。<br>";
			}
			if($numchk){
				$file = "seiseki.csv";
				$adddata = "$gakuban,$shimei,$kokugo,$sansu,$rika,$shakai,$eigo\n";
				file_put_contents($file,$adddata,FILE_APPEND);
				echo "追加しました。<br>";
			}else{
				echo "追加に失敗しました。<br>";
			}
		}else if(!empty($_POST['removeno'])){
			$removeno = $_POST['removeno'];
			$numchk = false;
			$lines = file('seiseki.csv');
			foreach($lines as $line){
     			$datas = split(',',$line);//splitした配列
				if($removeno == $datas[0]){
					$numchk = true;
				}
     		}
     		if($numchk){
     			setcookie("removeno","$removeno");
     			removedata();
     		}else{
     			echo "入力された学番は存在しません。<br>";
     		}
		}else if(!empty($_POST['editno'])){
			$editno = $_POST['editno'];
			$numchk = false;
		
			$lines = file('seiseki.csv');
			foreach($lines as $line){
     			$datas = split(',',$line);//splitした配列
				if($editno == $datas[0]){
					$numchk = true;
				}
     		}
	     	if($numchk){
		     	setcookie("editno","$editno");
    	 		editdata();
     		}else{
     			echo "入力された学番は存在しません。<br>";
     		}
		}else if(!empty($_POST['eshimei']) || !empty($_POST['ekokugo']) ||!empty($_POST['esansu']) || !empty($_POST['erika']) || !empty($_POST['eshakai']) || !empty($_POST['eeigo'])){
			$gakuban = $_COOKIE['editno'];
			$shimei = $_POST['eshimei'];
			$kokugo = $_POST['ekokugo'];
			$sansu = $_POST['esansu'];
			$rika = $_POST['erika'];
			$shakai = $_POST['eshakai'];
			$eigo = $_POST['eeigo'];
			$numchk = true;
			
			if($kokugo>100 || $kokugo<0){
				$numchk = false;
				echo "国語の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($kokugo)==false){
				$numchk = false;
				echo "国語の成績には数字を入力してください。<br>";
			}
			if($sansu>100 || $sansu<0){
				$numchk = false;
				echo "算数の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($sansu)==false){
				$numchk = false;
				echo "算数の成績には数字を入力してください。<br>";
			}
			if($rika>100 || $rika<0){
				$numchk = false;
				echo "理科の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($rika)==false){
				$numchk = false;
				echo "理科の成績には数字を入力してください。<br>";
			}
			if($shakai>100 || $shakai<0){
				$numchk = false;
				echo "社会の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($shakai)==false){
				$numchk = false;
				echo "社会の成績には数字を入力してください。<br>";
			}
			if($eigo>100 || $eigo<0){
				$numchk = false;
				echo "英語の成績は0~100の範囲の数字でなければいけません。<br>";
			}
			if(ctype_digit($eigo)==false){
				$numchk = false;
				echo "英語の成績には数字を入力してください。<br>";
			}
			if($numchk){
				$lines = file('seiseki.csv');
				for($i=0;$i<count($lines);$i++){
     				$datas = split(',',$lines[$i]);//splitした配列
					if($datas[0]==$_COOKIE['editno']){
						unset($lines[$i]);
						$lines[] = "$gakuban,$shimei,$kokugo,$sansu,$rika,$shakai,$eigo\n";
					}
     			}
     			$file = "seiseki.csv";
     			file_put_contents($file, $lines);
				echo "更新しました。<br>";
				setcookie('editno','');
			}else{
				echo "更新に失敗しました。<br>";
			}
		}
	}
?>
			</article>
		</section>
		
		
		<footer>
			作成日付:2016/02/17
		</footer>
	</body>
</html>
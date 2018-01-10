
<html>
    <?php
        header("Content-Type: text/html; charset = UTF-8");
    
        try{

            //データベースへの接続
            $servername = "ホスト";
            $username = "ユーザー名";
            $password= "パスワード";
            $dbname = "データベース名";
            $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            
            //削除機能
            if(isset($_POST["submit2"])){
                    if (!empty($_POST["remove"]) && !empty($_POST["password2"])){

                        $id = $_POST["remove"];

                        //GET THE PASSWORD FROM THE TABLE
                        $sql = "SELECT * FROM MyGuests";
                        $results = $pdo->query($sql);
                        foreach($results as $row){
                            if($id == $row["id"]){
                                $password = $row["password"];
                            }         
                        }

                        //CONFIRM THE PASSWORD
                        if($password != $_POST["password2"]){
                            echo "<script type='text/javascript'>alert('パスワードが間違っています');</script>";
                        }else{
                            //MISSION2-14: USE "DELETE" TO REMOVE CONTENTS
                            $sql = "DELETE FROM MyGuests WHERE id= '$id'";
                            $result = $pdo->query($sql);
                            header('Location: /mission_2-15.php');
                        }
                    }
            }
            
            //編集機能
            if(!empty($_POST["edit"]) && !empty($_POST["password3"])){
                    $id = $_POST["edit"];
                    
                    //GET THE PASSWORD FROM THE TABLE
                    $sql = "SELECT * FROM MyGuests";
                    $results = $pdo->query($sql);
                    foreach($results as $row){
                        if($id == $row["id"]){
                            $password = $row["password"];
                        }         
                    }
                    
					//CONFIRM THE PASSWORD
					if($password != $_POST["password3"]){
							
							echo "<script type='text/javascript'>alert('パスワードが間違っています');</script>";
							
					}
				}
        }
        //IF FAILED TO CONNECT
        catch(PDOException $e){
            echo "Error: "."<br>". $e->getMessage();
            die();
        }

    ?>
	<head>
		<title>〜日本留学中〜</title>
		<style type="text/css">
            
			body{
				margin-left: 50px;
				margin-top: 15;
			}
			
            #welcome{
                
                width: 550px;
				padding-top: 10px;
				border: 1px solid black;
				border-radius: 5px;
                text-align: center;
                margin-bottom: 10px;
                
            }
            
            .container{
                width: 550px;
				padding-top: 10px;
				border: 1px solid black;
				border-radius: 5px;
                text-align: center;
                margin-bottom: 10px;
                
            }
            .container input{
                width:300px;
                margin-top: -5px;
            }
		</style>
	</head>
	
	<body>
        
        <!--入力フォーム-->
        <div class="container">
		<form method="post" id="myForm" enctype="multipart/form-data">
			<h3>日本での留学生活について、今日の感想は?</h3>
			<p>ユーザーネーム: </p>
			<input type="text" name="username" placeholder="Username"
						<?php  
                            //IF IT'S EDIT MODE SHOW THE VALUE
                            if(!empty($_POST["edit"]) && !empty($_POST["password3"])){
                                $id = $_POST["edit"];
                                $sql = "SELECT * FROM MyGuests";
                                $results = $pdo->query($sql);
                                foreach($results as $row){
                                    if($id == $row["id"]){
                                        echo "value=".$row['username'];
                                    }         
                                }
                            }
						?>
			>
			
			<p>コメント:</p>
			<input type="text" name="comment" placeholder="Comment here"
						<?php
							//IF IT'S EDIT MODE SHOW THE VALUE
								if(!empty($_POST["edit"]) && !empty($_POST["password3"])){
									$id = $_POST["edit"];
                                    $sql = "SELECT * FROM MyGuests";
                                    $results = $pdo->query($sql);
                                    foreach($results as $row){
                                        if($id == $row["id"]){
                                            echo "value=".$row['comment'];
                                        }         
                                    }
								}
						?>
			>
            
			<p>パスワード:</p>
			<input type="text" name="password" placeholder="password"
						<?php
							//IF IT'S EDIT MODE SHOW THE VALUE
								if(!empty($_POST["edit"]) && !empty($_POST["password3"])){
									$id = $_POST["edit"];
                                    $sql = "SELECT * FROM MyGuests";
                                    $results = $pdo->query($sql);
                                    foreach($results as $row){
                                        if($id == $row["id"]){
                                            echo "value=".$row['password'];
                                        }         
                                    }
									
								}
						?>
			>
            <br>
            <br>
			<?php  if(!empty($_POST["edit"]) && !empty($_POST["password3"])){echo "<input type='hidden' name='editConfirmation' value=".$_POST['edit'].">";}?>
			<input type="submit" name="submit" value="投稿" onclick="return confirm('確認しましたか?');">
			<?php
				//編集モードかどうか判別する
				if(empty($_POST["editConfirmation"])){
					if (empty($_POST["username"]) || empty($_POST["comment"]) || empty($_POST["password"])){
						echo '<h5>✰必須項目を記入してください！✰</h5>';
					}else{
                        //PDO
                        $servername = "localhost";
                        $username = "co-779.it.99sv-c";
                        $password= "KuGs7j";
                        $dbname = "co_779_it_99sv_coco_com";
                        $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8";
                        $pdo= new PDO($dsn, $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        
                        $sql = $pdo -> prepare("INSERT INTO MyGuests (username, comment, password) VALUES (:username, :comment, :password)");
                        $sql -> bindParam(':username',$username,PDO::PARAM_STR);
                        $sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
                        $sql -> bindParam(':password',$password,PDO::PARAM_STR);
                        $username = $_POST["username"];
                        $comment = $_POST["comment"];
                        $password = $_POST["password"];
                        $sql->execute();
                        header('Location: /mission_2-15.php');
                    }
                }else{
                    //編集機能
                    $id = $_POST["editConfirmation"];
                    $username = $_POST["username"];
                    $comment = $_POST["comment"];
                    $password = $_POST["password"];
                    
                    $sql ="UPDATE MyGuests SET username='$username', comment='$comment', password='$password' WHERE id='$id'";
                    $results = $pdo->query($sql);
                    
                    header('Location: /mission_2-15.php');
                }
								
			?>
			
		</form>
		</div>
        
        <!--掲示板-->
		<div>
			<h3>コメント</h3>
			<?php
                //MISSION2-12: USE "SELECT" TO SHOW THE INSERTED DATA
                $sql = "SELECT * FROM MyGuests ORDER BY id ASC";
                $results = $pdo->query($sql);
                foreach ($results as $row){
                    echo "<div class='container'>";
                    echo "【".$row["id"]."】".$row["username"]."、 ".$row["comment"]."、 ".$row["date"]."<br>";
                    echo "</div><br>"; 
                }
			?>
		</div>
		<br>
		<!--削除フォーム-->
        <div class="container">
		<form method="post"　id="removeForm">
			<p>削除したい内容がありますか?</p>
			<p>削除対象番号：</p><input name="remove" type="text" placeholder="number">
			<p>パスワード:</p><input type="text" name="password2" placeholder="Password">
            <br><br>
			<input type="submit" name="submit2" value="削除" onclick="return confirm('確認しましたか?');">
		</form>
		</div>
        
		<!--編集フォーム-->
        <div class="container">
		<form method="post" id="editForm">
			<p>編集したい内容がありますか?</p>
			<p>編集対象番号：</p><input name="edit" type="text" placeholder="number">
			<p>パスワード:</p><input type="text" name="password3" placeholder="password">
            <br><br>
			<input type="submit" name="submit3" value="編集">
		</form>
        </div>
	</body>
</html>
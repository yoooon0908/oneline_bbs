<?php
  //POST送信が行われたら、下記の処理を実行
  //テストコメント

    //データベースに接続
    $dsn = 'mysql:dbname=oneline_bbs;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn,$user,$password);
    $dbh->query('SET NAMES utf8');

    $nickname = $_POST['nickname'];
    $nickname = htmlspecialchars($nickname);
    $comment = $_POST['comment'];
    $comment = htmlspecialchars($comment);

    if(isset($_POST) && !empty($_POST)){
 

    $sql = 'INSERT INTO `posts` (`nickname`,`comment`, `created`) VALUES("'.$nickname.'","'.$comment.'", NOW())';
    
    

    $stmt = $dbh->prepare($sql);
    $stmt->execute();

  
   

    //INSERT文実行

   
            
    //データベースから切断
    //$dbh = null;
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

</head>
<body>

  <br />
  <br />

  <form action="bbs.php" method="post">
    <input type="text" name="nickname" placeholder="nickname" required>
    <textarea type="text" name="comment" placeholder="comment" required></textarea>
    <button type="submit" >つぶやく</button>
  </form> 

   <br />
   <br />
    
    <a href="#"></a>
    <span>
      <?php
         
        $sql = 'SELECT * FROM `posts` ORDER BY `created` DESC';
        

        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        
        while(1) {
          $rec = $stmt->fetch(PDO::FETCH_ASSOC);
          if($rec == false) {
          break;
          }
            echo $rec['nickname'];
            echo $rec['comment'];
            echo $rec['created'];
            echo '<br />';

        }

      ?>
    </span>
     <!--  <span>2015-12-02 10:10:20</span>
      <p></p> -->
    <!-- <h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:10</span></h2>
    <p>つぶやきコメント2</p> -->
</body>
</html>

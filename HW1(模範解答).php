<?php
	//HW1:DBに接続

	//⭐️時差は見ている国によって、時間や表示がずれる

  	//POST送信が行われたら、下記の処理を実行
  	//テストコメント
 	  
 		

    //データベースに接続
   	$dsn = 'mysql:dbname=oneline_bbs;host=localhost';
   	$user = 'root';
   	$dbh = new PDO($dsn,$user,$password);
   	$dbh->query('SET NAMES utf8');

    if(isset($_POST) && !empty($_POST)){

    //SQL文作成(INSERT文)
    $sql = 'INSERT INTO `posts` (`id`, `nickname`, `comment`, `created`)';
    $sql .='VALUES ('.$_POST['nickname'].','.$_POST['comment'].',now())';

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    //SQL文作成(SELECT文)
     $sql = 'SELECT * FROM `posts`';

    //INSERT文実行
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $posts = array();

    //実行結果として得られた結果を表示する
    //$recの中にfalseがすでにはいっているため、echo $rec['nickname'];だけでは表示できない
    //⭐️利点１:違う配列を作って、while文を書かなくてもすきなタイミングでデータが出せる
    //⭐️利点２:直接while文を書く書き方をすると、データベースをファイルの一番下で記述しなければいけないが、
            //違う配列に入れることでいちいちデータベースを切断しなくてもよくなる
    while(1){
      $rec = $stmt->fetch(PDO::fetch_ASSOC);
      if($rec == false){
      break;
      }
        // echo $rec['id'];
        // echo $rec['nickname'];
        // echo $rec['created'];
        // echo '<br />';
        $posts[]=$rec;
    }

    //データベースから切断
    $dbh = null;
    
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>セブ掲示版</title>

</head>
<body>
    <form action="bbs.php" method="post">
      <input type="text" name="nickname" placeholder="nickname" required>
      <textarea type="text" name="comment" placeholder="comment" required></textarea>
      <button type="submit" >つぶやく</button>
    </form>
    <?php foreach ($posts as $post) { ?>
      
    <h2><a href="#"><?php echo $post['nickname']; ?></a> <span>2015-12-02 10:10:20</span></h2>
    <p>つぶやきコメント</p>

    <h2><a href="#">nickname Eriko</a> <span>2015-12-02 10:10:10</span></h2>
    <p>つぶやきコメント2</p>

    <?php } ?>
</body>
</html>

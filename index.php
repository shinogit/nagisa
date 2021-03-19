<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8" />
  <title>test nagisa</title>
</head>
<body>

  <?php
  $hello = $_GET['hello']; //URLから変数helloの値を取得

  if ($hello === 'Program') {
    echo 'Hello Program';
  } elseif ($hello === 'Nagisa') {
    echo 'Hello Nagisa';
  } elseif ($hello === '') {
    echo 'Hello Null';
  } else {
    echo 'Hello Unknown';
  }
  ?>

  <?php
  $dsn = 'mysql:host=ip-10-0-10-57.ap-northeast-1.compute.internal;dbname=test;charaset=utf8';
  $user = 'nagisa';
  $pass = 'nagisa';
  $dbh = new PDO($dsn, $user);
  try {
    $dbh = new PDO($dsn, $user);
    echo "接続成功\n";
  } catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
  }
  ?>

</body>
</html>
<?php

$dsn = 'mysql:host=ip-10-0-10-57.ap-northeast-1.compute.internal;dbname=test;charaset=utf8';
$user = 'nagisa';
$password = '';

try {
  /* リクエストから得たスーパーグローバル変数をチェックするなどの処理 */
  // データベースに接続
  $dbh = new PDO(
    $dsn,
    $user,
    $password,
    [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
  );
  /* データベースから値を取ってきたり， データを挿入したりする処理 */
  $parent_id = $_GET['parent_id'];
  $sql = "UPDATE tests SET subject = CONCAT(subject, '(後ろに追記)') WHERE parent_id = $parent_id";
  $count = $dbh->exec($sql);
} catch (PDOException $e) {
  // エラーが発生した場合は「500 Internal Server Error」でテキストとして表示して終了する
  // - もし手抜きしたくない場合は普通にHTMLの表示を継続する
  // - ここではエラー内容を表示しているが， 実際の商用環境ではログファイルに記録して， Webブラウザには出さないほうが望ましい
  header('Content-Type: text/plain; charset=UTF-8', true, 500);
  exit($e->getMessage());
}
// Webブラウザにこれから表示するものがUTF-8で書かれたHTMLであることを伝える
// (これか <meta charset="utf-8"> の最低限どちらか1つがあればいい． 両方あっても良い．)
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8 /">
  <title>nagisa test</title>
</head>

<body>
  <h2>parent_idが<?php echo $parent_id; ?>のやつに文言追記しました</h2>
  <h3>件数：<?php echo $count; ?>件</h3>
</body>

</html>
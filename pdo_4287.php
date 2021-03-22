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
    // 論理削除されたレコードを物理削除（子レコードは親レコードに依存）。
    $sql = "DELETE FROM tests WHERE id IN(
      SELECT id FROM tests WHERE deleted_at IS NOT NULL
      UNION SELECT id FROM tests WHERE parent_id IN
      (SELECT id FROM tests WHERE deleted_at IS NOT NULL AND parent_id IS NULL))";
    $sth = $dbh->query($sql);
    // 全レコードを抽出
    $sql = "SELECT * FROM tests";
    $sth = $dbh->query($sql);
    $aryItem = $sth->fetchAll(PDO::FETCH_ASSOC);
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
        <title>物理削除</title>
    </head>
    <body>
    <p>物理削除が実行されました</p>
    <p>下記は物理削除されていないレコード一覧です</p>
    <p><?php print_r($aryItem); ?><br></p>
    </body>
</html>
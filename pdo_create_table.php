<?php
  $dsn = 'mysql:host=ip-10-0-10-57.ap-northeast-1.compute.internal;dbname=test;charaset=utf8';
  $user = 'nagisa';

  $sql = "ALTER TABLE tests ADD (name VARCHAR(255) NOT NULL,
                                  subject VARCHAR(255) NULL,
                                  body VARCHAR(512) NULL,
                                  parent_id INT NULL,
                                  post_user VARCHAR(32) NULL,
                                  created_at DATETIME NOT NULL default current_timestamp,
                                  updated_at DATETIME NOT NULL default current_timestamp on update current_timestamp,
                                  deleted_at DATETIME NULL)";

  try {
    $dbh = new PDO($dsn, $user);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "接続成功\n";
    $stmt = $dbh->query($sql);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    print_r($result);

  } catch (PDOException $e) {
    echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
  }

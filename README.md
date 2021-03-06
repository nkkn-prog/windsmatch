アプリの概要

▼WindsMatchとは？

楽器を趣味としている人を繋げるマッチングサービスで、ミュージックスクールに行かなくても同じ楽器ができる人と繋がることができる。

▼背景

自身が中高吹奏楽部出身で、社会人以後に楽器を趣味として始めようとした時、レッスンスクールだけの出会いでは金銭的にも時間的にもコストがかかると考えた。
そこで、楽器ができる人同士のマッチングサービスがあれば気軽に同趣味の人と繋がれると考え、このアプリの制作を開始した。

▼使用技術

言語: PHP 7.3.33, HTML5, CSS3, 

フレームワーク: Laravel 6.20.44

その他: AWS(EC2, S3), MySQL


▼機能一覧

・新規登録機能(デフォルト & GoogleAPI連携)

・ログイン機能(デフォルト & GoogleAPI連携)

・プロフィール作成機能(ニックネーム、性別、居住地、出来る楽器、好きなジャンル、楽器歴、ひとこと、画像)

・写真アップロード機能(AWS S3)

・バリデーション機能(上記のプロフィール作成機能に実装)

・パスワード暗号化

・条件別検索機能

・オススメ機能(ユーザーがプロフィール作成時に選択した楽器に紐づく既存ユーザーのプロフィールを表示)

・チャット機能


▼注力した機能

1)条件別検索機能

多対多のリレーションや中間テーブルを用いて、選択した楽器と居住地から該当するプロフィールを検索する機能を実装した。
ユーザーは、①近くに住んでいる ②同じ楽器ができる という情報があればオフラインで気軽に接点を持つことができると考え、
検索機能に楽器と居住地を設定した。
また検索機能を隠せるcss設定を行い、画面の煩雑さを極力無くす工夫をした。

2)チャット機能

ユーザー同士が気軽にメッセージを送り合えるようなチャット機能を実装した。
連絡の手段としてユーザー登録時のメールアドレスの使用を考えたが、セキュリティーの観点からプライベートメッセージ機能を採用した。
また、ユーザーが慣れているあろうLINE風のメッセージ画面を実装し、利用する際のハードルを下げる工夫をした。


▼環境構築の手順

1)AWS Cloud9を用いて、プロジェクトを作成

2)データベース(MariaDB)の設定

3)Git, GitHubの設定

▼デモ画面(動画)
Google Drive URL

https://drive.google.com/file/d/13p_mySXzDc9FIIrq0Q2xuLvCFjXirCz_/view?usp=sharing

▼ポートフォリオURL

https://windsmatch.herokuapp.com/

▼テストアカウント

E-mail: test1@gmail.com / Password:test1111

E-mail: test2@gmail.com / Password:test2222

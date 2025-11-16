# フリーマーケットアプリ(模擬案件)

## 環境構築
### Dockerビルド
1. git clone https://github.com/ainyan4645/flea-market_coachtech.git
2. cd flea-market_coachtech
3. docker-compose up -d --build

### Laravel環境構築
1. cd src
2. cp .env.example .env
3. .env.testingは？？？？？？？？？？？？？？？
4. docker-compose exec php bash
5. composer install
6. php artisan key:generate
7. php artisan migrate
8. php artisan db:seed
9. php artisan storage:link
10. composer require stripe/stripe-php

 ※permissionエラーが出る場合は `/contact-form__test` ディレクトリで以下のコマンドを実行してください。
 ```bash
 sudo chmod -R 777 src/*
 ```

## 使用技術(実行環境)
- php 8.2
- Laravel 8.0
- MySQL 8.0
- nginx 1.24

## ER図
![ER図](./flea-market_ER.drawio.svg)

## 開発環境(URL)
- 商品一覧画面(トップ)： http://localhost/
- phpMyAdmin： http://localhost:8080/

## 機能確認用ユーザ
- サンプル商品出品ユーザ<br>
メール： sell@example.com<br>
パスワード： password

- 認証必須機能確認用ユーザ<br>
メール： testA@example.com<br>
パスワード： password

## 補足事項
- 画像アップロード時の画面に即時反映はJavaScriptを使用しないと難しいため、アップロード時は何も表示されません。フォーム送信後に画像が反映されているかのご確認をお願いいたします。
- stripe決済はまだ開発段階のため、現段階ではカード決済完了時にのみ購入完了します。
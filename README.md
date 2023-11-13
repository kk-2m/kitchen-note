# KitchenNote
![KitchenNote](https://github.com/kk-2m/kitchen-note/assets/112247999/5348554d-940e-4849-ae06-e2af3d09e886)

<!--<p align="center">-->
<!--<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>-->
<!--<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>-->
<!--<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>-->
<!--<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>-->
<!--</p>-->

## URL

testアカウントは[下記](https://github.com/kk-2m/kitchen-note#%E3%83%86%E3%82%B9%E3%83%88%E3%82%A2%E3%82%AB%E3%82%A6%E3%83%B3%E3%83%88)に記載があります

アプリURL(https://kitchen-note-732a61d9545e.herokuapp.com/)

## 背景・概要

「冷蔵庫の中に何があったかな？」このような疑問はもうおしまいです。
KitcheNoteはシンプルながらも、効果的な機能で日常の小さな悩みを解決します。
レシピの管理から賞味・消費期限などの在庫情報まで、このアプリは毎日の食事準備を簡単に効率的にします。

献立を考える際も、KitcheNoteがあればスマートに計画を立てられます。
ボタン1つで瞬時に買い物リストが生成され、アイテムにチェックを入れるだけで在庫が自動更新されます。

KitcheNoteはただのレシピ管理アプリではありません。
このアプリは、料理をより楽しく、生活をより効率的にするあなたの新しいキッチンパートナーです。

## アプリケーションのイメージ


## 機能一覧
| トップ画面 |　アカウント登録画面 |
| ---- | ---- |
| ![TopPage](https://github.com/kk-2m/kitchen-note/assets/112247999/4d70ade7-dd73-4699-9572-13c9fa599824) | ![RegisterPage](https://github.com/kk-2m/kitchen-note/assets/112247999/4c4767ca-f62d-4fdb-bbc8-3b7fc12dacb3) |
| URLを読み込ませる毎にトップページの画像が変わる機能を実装しました。 | メール認証を用いたアカウント登録を実装しました。 |

| ログイン画面 |　パスワードリセット画面 |
| ---- | ---- |
| ![LoginPage](https://github.com/kk-2m/kitchen-note/assets/112247999/19e7c814-9d90-47a3-b3e3-a2676d2bc96a) | ![PasswordResetPage](https://github.com/kk-2m/kitchen-note/assets/112247999/9c34823d-6257-4c3f-8cab-467714d90409) |
| メールアドレスとパスワードを用いた認証機能を実装しました。 | メールアドレスを用いてパスワードを再設定できる機能を実装しました。 |

| ダッシュボード |　プロフィール画面 |
| ---- | ---- |
| ![Dashboard](https://github.com/kk-2m/kitchen-note/assets/112247999/95b4a49d-33c0-427a-8228-f1ead77c23ff) | ![ProfilePage](https://github.com/kk-2m/kitchen-note/assets/112247999/b6660193-c2d8-4ef8-b726-ec605f75a28e) |
| APIとWebスクレイピングを用いて楽天レシピの人気ランキングを表示する機能を実装しました。楽天レシピは毎日12時に更新されます。| プロフィール情報ではユーザー名とメールアドレスの変更、パスワードの変更、アカウントの削除ができます。 |

| レシピ一覧画面 |　レシピ作成画面 |
| ---- | ---- |
| ![RecipeIndexPage](https://github.com/kk-2m/kitchen-note/assets/112247999/de752f0e-d20b-4e65-85b5-1aed1e4401e2) | ![RecipeCreatePage](https://github.com/kk-2m/kitchen-note/assets/112247999/4916f8bd-751a-4290-8373-2c8b4374058d) |
| この画面から登録したレシピを一覧形式で見ることができます。また、献立に追加するボタンでは、レシピIDをURLパラメータとして献立作成画面に渡します。 | 材料項目と手順項目は増減させることが可能です。その際は、材料番号や手順番号が自動で変更されます。 |

| レシピ詳細画面 |　レシピ編集画面 |
| ---- | ---- |
| ![RecipeShowPage](https://github.com/kk-2m/kitchen-note/assets/112247999/fe0fb4a1-d0e4-4524-a2f6-33bd6eb47bf5) | ![RecipeEditPage](https://github.com/kk-2m/kitchen-note/assets/112247999/e90849eb-e81c-4204-a316-057c9eba5747) |
| レシピの手順を見ることができます。 | 初期表示は登録情報ですが、バリデーションが機能した時は項目に入っていた値が再度格納されるようになっています。詳しくは動画をご覧ください。 |

| 在庫情報一覧画面 |　新規在庫作成画面 |
| ---- | ---- |
| ![StockIndexPage](https://github.com/kk-2m/kitchen-note/assets/112247999/89e623d6-67c9-41cc-821d-67fbfef6f1b3) | ![StockCreatePage](https://github.com/kk-2m/kitchen-note/assets/112247999/4e9381a9-a879-4f8c-bce0-8a7c5b34dcc4) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | ログインIDとパスワードでの認証機能を実装しました。 |

| 在庫情報編集画面 |　献立一覧画面 |
| ---- | ---- |
| ![StockEditPage](https://github.com/kk-2m/kitchen-note/assets/112247999/313c1620-aabd-44fa-8e7a-2af4161eba03) | ![MenuIndexPage](https://github.com/kk-2m/kitchen-note/assets/112247999/ea9a4ca8-25ce-4c98-b4cd-e8682d476635) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | 各献立は曜日によってソートされます。また、表示される献立は今日から１週間です。買い物リスト作成ボタンによって表示されている材料を買い物リストに追加することができます。 |

| 献立作成画面 |　献立編集画面 |
| ---- | ---- |
| ![MenuCreatePage](https://github.com/kk-2m/kitchen-note/assets/112247999/61132de6-3cd9-421e-9df8-b9fdb038a711) | ![MenuEditPage](https://github.com/kk-2m/kitchen-note/assets/112247999/50c773ec-a875-4df8-a7fe-5b587c8b5f72) |
| 人数によってレシピに必要な材料の量が線形変換されます | レシピIDと献立IDを対応付けさせる必要があるためレシピは編集できないようにしました。 |

| 買い物情報一覧画面 |　買い物情報編集画面 |
| ---- | ---- |
| ![ShoppingIndexPage](https://github.com/kk-2m/kitchen-note/assets/112247999/75c093b5-b232-40fb-b47a-1ab46936321c) | ![ShoppingEditPage](https://github.com/kk-2m/kitchen-note/assets/112247999/1a120bff-9733-4926-9df5-26b3bb4befa9) |
| この画面で新規に買い物リストへ追加することもできます。追加する材料はオートコンプリート機能により、登録されている材料からしか選べない仕様になっています。また、買い物リストにチェックがつけられると、Ajax通信により買い物情報が在庫情報に登録されます。 | 買い物リストの編集ができます。買い物IDと材料IDを対応づかせるため、材料名は編集できないようにしています。 |

| 買い物リストへ追加 |　買い物リスト |
| ---- | ---- |
| ![ShoppingCreate](https://github.com/kk-2m/kitchen-note/assets/112247999/50fd4f30-5ea2-4b4d-a6c9-399e1956ebd8) | ![ShoppingList](https://github.com/kk-2m/kitchen-note/assets/112247999/d08f0cf9-70f5-46b6-a0e7-7a3a5d5777fa) |
| この画面で新規に買い物リストへ追加することもできます。追加する材料はオートコンプリート機能により、登録されている材料からしか選べない仕様になっています。 | また、買い物リストにチェックがつけられると、Ajax通信により買い物情報が在庫情報に登録されます。 |

## 使用技術

以下はアプリ開発に使った技術になります。

### フロントエンド
* HTML/CSS
    - Tailwind CSS：レスポンシブなデザイン作成
* JavaScript
    - jQuery：ユーザーインタラクション, Ajax通信
### バックエンド
* PHP（8.0.30）
    - Laravel（9.52.15）：MVCアーキテクチャの構築
    - Guzzle（7.8.0）：Webスクレイピング
    - Breeze（v1.19.2）：認証機能
### データベース
* MariaDB（10.2.38）：開発時に使用
* PostgresSQL：デプロイ時に使用
### その他のツール・技術
* Gmail：メール認証時に送信するためのメールアドレス
* AWS
    - Amazon EC2：テストサーバー
    - AWS Cloud9：Cloud IDE
* Git（2.40.1）
    - GitHub：バージョン管理
* Xserver：Herokuの外部ストレージ, 画像を保存しURL化
* Heroku：デプロイ時に使用したクラウド・アプリケーション・プラットフォーム
    - Heroku Scheduler：楽天レシピの情報を毎日更新するためのタスクスケジューラー 
* API
    - 楽天レシピカテゴリ別ランキングAPI

## ER図

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).


## テストアカウント

```
user name : test1

user email : test1@email.com

password : testaccount
```
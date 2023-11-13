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
これは、料理をより楽しく、生活をより効率的にするあなたの新しいキッチンパートナーです。

## アプリケーションのイメージ



## 使用技術

以下はアプリ開発に使った技術になります。

### フロントエンド
* HTML/CSS
    - Tailwind CSS：レスポンシブなデザイン作成
* JavaScript
    - jQuery：ユーザーインタラクション、Ajax通信
### バックエンド
* PHP（8.0.30）
    - Laravel（9.52.15）：MVCアーキテクチャの構築
    - Guzzle（7.8.0）：Webスクレイピング
    - Breeze（v1.19.2）：認証機能
### データベース
* MariaDB（10.2.38）：開発時に使用
* PostgresSQL：デプロイ時に使用
### その他のツール・技術
* AWS
    - Amazon EC2：テストサーバー
    - AWS Cloud9：Cloud IDE
* Git（2.40.1）：バージョン管理
* GitHub
* Xserver
* Heroku：デプロイ時に使用
* API
    - 楽天レシピカテゴリ別ランキングAPI

## ER図

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## 機能一覧
| トップ画面 |　アカウント登録画面 |
| ---- | ---- |
| ![TopPage](https://github.com/kk-2m/kitchen-note/assets/112247999/4d70ade7-dd73-4699-9572-13c9fa599824) | ![RegisterPage](https://github.com/kk-2m/kitchen-note/assets/112247999/4c4767ca-f62d-4fdb-bbc8-3b7fc12dacb3) |
| URLを読み込ませる毎にトップページの画像が変わる機能を実装しました。 | メール認証を用いたアカウント登録を実装しました。 |

| ログイン画面 |　パスワードリセット画面 |
| ---- | ---- |
| ![LoginPage](https://github.com/kk-2m/kitchen-note/assets/112247999/19e7c814-9d90-47a3-b3e3-a2676d2bc96a) | ![PasswordResetPage](https://github.com/kk-2m/kitchen-note/assets/112247999/9c34823d-6257-4c3f-8cab-467714d90409) |
| メールアドレスとパスワードでの認証機能を実装しました。 | メールアドレスを用いてパスワードを再設定できる機能を実装しました。 |

| ダッシュボード |　プロフィール画面 |
| ---- | ---- |
| ![Dashboard](https://github.com/kk-2m/kitchen-note/assets/112247999/95b4a49d-33c0-427a-8228-f1ead77c23ff) | ![ProfilePage](https://github.com/kk-2m/kitchen-note/assets/112247999/b6660193-c2d8-4ef8-b726-ec605f75a28e) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | ログインIDとパスワードでの認証機能を実装しました。 |

| レシピ一覧画面 |　レシピ作成画面 |
| ---- | ---- |
| ![RecipeIndexPage](https://github.com/kk-2m/kitchen-note/assets/112247999/de752f0e-d20b-4e65-85b5-1aed1e4401e2) | ![RecipeCreatePage](https://github.com/kk-2m/kitchen-note/assets/112247999/4916f8bd-751a-4290-8373-2c8b4374058d) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | ログインIDとパスワードでの認証機能を実装しました。 |

| レシピ詳細画面 |　レシピ編集画面 |
| ---- | ---- |
| ![RecipeShowPage](https://github.com/kk-2m/kitchen-note/assets/112247999/fe0fb4a1-d0e4-4524-a2f6-33bd6eb47bf5) | ![LoginPage](https://github.com/kk-2m/kitchen-note/assets/112247999/19e7c814-9d90-47a3-b3e3-a2676d2bc96a) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | ログインIDとパスワードでの認証機能を実装しました。 |

| 在庫情報一覧画面 |　新規在庫作成画面 |
| ---- | ---- |
| ![TopPage](https://github.com/kk-2m/kitchen-note/assets/112247999/4d70ade7-dd73-4699-9572-13c9fa599824) | ![LoginPage](https://github.com/kk-2m/kitchen-note/assets/112247999/19e7c814-9d90-47a3-b3e3-a2676d2bc96a) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | ログインIDとパスワードでの認証機能を実装しました。 |

| 在庫情報編集画面 |　献立一覧画面 |
| ---- | ---- |
| ![TopPage](https://github.com/kk-2m/kitchen-note/assets/112247999/4d70ade7-dd73-4699-9572-13c9fa599824) | ![LoginPage](https://github.com/kk-2m/kitchen-note/assets/112247999/19e7c814-9d90-47a3-b3e3-a2676d2bc96a) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | ログインIDとパスワードでの認証機能を実装しました。 |

| 献立作成画面 |　献立編集画面 |
| ---- | ---- |
| ![TopPage](https://github.com/kk-2m/kitchen-note/assets/112247999/4d70ade7-dd73-4699-9572-13c9fa599824) | ![LoginPage](https://github.com/kk-2m/kitchen-note/assets/112247999/19e7c814-9d90-47a3-b3e3-a2676d2bc96a) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | ログインIDとパスワードでの認証機能を実装しました。 |

| 買い物情報一覧画面 |　買い物情報編集画面 |
| ---- | ---- |
| ![TopPage](https://github.com/kk-2m/kitchen-note/assets/112247999/4d70ade7-dd73-4699-9572-13c9fa599824) | ![LoginPage](https://github.com/kk-2m/kitchen-note/assets/112247999/19e7c814-9d90-47a3-b3e3-a2676d2bc96a) |
| 登録せずにサービスをお試しいただくためのトライアル機能を実装しました。 | ログインIDとパスワードでの認証機能を実装しました。 |

## テストアカウント

```
user name : test1

user email : test1@email.com

password : testaccount
```
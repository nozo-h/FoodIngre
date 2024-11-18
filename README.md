# FoodIngre (フードイングリ）

FoodIngre(フートイングリ)は食品情報（栄養成分や原材料等）が**一目で分かる** + **その情報をみんなで投稿して共有する**サービスです。
##### ホーム画面
<img width="900" alt="app-home" src="https://github.com/user-attachments/assets/0a28ae66-f67d-4a7b-b52f-aae2136a4515">


## アプリのURL

[FoodIngre]~~(https://foodingre-app.com/)~~

※2024/2/18現在（2024年10月閉鎖）

## アプリの概要

**食品情報を検索すれば一目で分かる**Webアプリケーションです。

また、**検索だけでなくみんなで情報を追加し、共有できるプラットフォーム**です。

### ターゲット層

- 日々生活の中で食による健康意識を持つ人
- トレーニングする人
- 美容を意識される人
- 過去に食べた物の情報をすぐに探したい人 等

### 作成した理由 

過去に私は「コスト重視」「時短」で「お腹が一杯になれば良い」と考え、栄養価など全く考えず食生活を過ごしていました。

結果、体重は増えたり健康診断でも様々な数値が悪くなり、

改善するため普段から食品情報（栄養成分表示や原材料等）を意識して購入するようになりました。

しかし、**毎回スーパーで確認するのも調べるのも大変。情報が集約されているサイトもあまりない。**

そのような課題を解決したい。という思いでアプリを作成しました。


## アプリの主な機能

- 食品情報の閲覧
  - カテゴリ機能ごとに検索
  - 製造者
  - 栄養成分表示
  - 原材料 等
- 食品情報の投稿
  - ユーザー登録をすることで食品情報の投稿、編集ができます 
  - 備考欄を設けることで栄養成分表示、原材料だけでなく保存方法等さまざまな情報を投稿できます

#### カテゴリ画面

カテゴリごとに分類し、情報を探しやすい設計しています

<img width="700" alt="app-category" src="https://github.com/user-attachments/assets/cdbe9955-a5a0-4ed5-9d2b-705f61faf494">


#### 検索画面
検索機能では商品名、企業名（製造所、販売者など）、原材料等のキーワードから情報を探すことができます

<img width="700" alt="app-search" src="https://github.com/user-attachments/assets/5a7166b5-99a4-434d-9c35-8ddc1d6a9310">


#### 食品情報の情報イメージ
食品の画像、原材料、栄養成分や製造者などを情報として掲載できます

<img width="700" alt="app-detail" src="https://github.com/user-attachments/assets/96318742-c1d1-4cca-b6c4-b0af971b0858">


#### 投稿画面
<img width="700" alt="app-create" src="https://github.com/user-attachments/assets/c6806011-70a2-4118-a0f5-5aa197c8ee5f">

#### その他：レスポンシブ対応

スマートフォンやタブレットなどのレスポンシブ画面にも対応しています。

<img width="200" alt="app-responsive-home" src="https://github.com/user-attachments/assets/e997c37b-5e6d-4af0-99ea-c286c9d29566">

## 使用技術
### フロントエンド
- HTML
- Tailwind CSS
- JavaScript

### サーバーサイド（バックエンド）
- PHP 8.2
- Composer
- Laravel 10.44
- MySQL 8.0
- Apache

### インフラ
#### 開発環境
- Docker 20.10.17
- Docker compose 2.6.1

#### 本番環境
- AWS
  - VPC
  - EC2 (Amazon Linux 2023)
  - RDS 
  - S3
  - ACM
  - Route 53
  - ELB

### インフラ構成図
![app-aws-architecture](https://github.com/user-attachments/assets/851108cc-3f5d-4ab9-abb6-a631b9661e42)
※費用面と本番環境へのリリースを優先するため、実際の商用構成のように冗長ではなく単一構成にしています。

### ER図
![app-er](https://github.com/user-attachments/assets/a62d7f15-57dd-4f64-8e74-31ee0049dbfe)

## 今後の予定
現在は一部開発中のため、以下機能を追加予定（検討含め）中です。
- メールによる初期認証
- Googleアカウントによる認証
- 投稿情報の公開・非公開設定
- 食品情報のお気に入り（保存）機能
- 食品情報に対する評価、コメント機能 等

{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/top.css" type="text/css">
{*タイトル用のCSS。とりあえず間に合わせでここに書いてます*}
<link href='http://fonts.googleapis.com/css?family=Ranchers' rel='stylesheet' type='text/css'>
    <style>
     .entrance p {
       margin-bottom: 0px;
       background-color: #e6e6fa;
       font-size: 100px;
       line-height: 3.5;
       font-family: 'Ranchers', cursive; 
       text-align: center;
     }
    </style>
{/block}
{block title append} indexです{/block}
{block main_contents}
<div class="entrance">
<p><a href="/thread/entrance/search"><i class="fa fa-arrow-circle-right"></i> ENTRANCE</a></p>
</div>
<pre>
  2014/01/14現在：
    ajax周り改変中のため、スレッド一覧ページの閲覧ができません。
    もし書き込みの際はお手数ですが、以下URLをコピーの上、
    任意のスレッド番号を指定して直接ジャンプしてください。
    
    http://172.16.14.187/thread/スレッド番号/list

    | id | スレタイ                             
    +----+-----------------------------------
    |  3 | わーすと3でこれが入ればおｋ
    |  4 | わーすと3でこれが入ればおｋ
    |  5 | あばばばばばばば
    |  6 | へんなはなし
    |  7 | 実験
    |  8 | わーすと3でこれが入ればおｋ
    |  9 | あああああああああ
    | 10 | 姉さん事件です
    | 11 | これもてすと
    | 12 | てすと
    | 13 | 雀の往来なんてあったよね
    | 14 | あほあほあほあほあほ
    | 15 | AAを淡々と貼っていくスレ
    | 16 | あああああ
    | 17 | 俺達の座談会
    | 18 | 目安箱のようなもの
    | 19 | GitHubのリポジトリが1000万件に到達
    | 20 | さよなら2013年
    | 21 | 謹賀新年
    | 22 | 投稿してみようっと
    +----+-----------------------------------

    お手数をおかけしますがよろしくお願いいたします。
</pre>
{/block}
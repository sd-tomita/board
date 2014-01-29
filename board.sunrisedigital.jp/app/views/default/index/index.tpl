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
{/block}
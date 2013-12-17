{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/top.css" type="text/css">
{*タイトル用のCSS。とりあえず間に合わせでここに書いてます*}
    <link href='http://fonts.googleapis.com/css?family=Oleo+Script+Swash+Caps' rel='stylesheet' type='text/css'>
    <style>
     .entrance p {
       margin-bottom: 0px;
       background-color: #e6e6fa;
       font-size: 75px;
       font-family: 'Oleo Script Swash Caps', cursive; 
       text-align: center;
     }
    </style>
{/block}
{block title append} indexです{/block}
{block main_contents}
<div class="entrance">
<p>♦♫⁺♦･*:..｡♦♫⁺♦*ﾟ¨</p>    
<p><a href="/thread/entrance/search-thread">ENTRANCE</a></p>
<p>♦♫⁺♦･*:..｡♦♫⁺♦*ﾟ¨</p>
</div>
{/block}
{extends file='default/base.tpl'}
{block title append} narrow{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">ジャンル別ページです</h1>
  </div>
</div>
<div>
    <h2>ジャンル一覧</h2>
  <ul>  
{* {foreach $genre_list as $record}
     <li>{$record->getName}</li>
 {/foreach}
*}  </ul>
     
</div>

{/block}

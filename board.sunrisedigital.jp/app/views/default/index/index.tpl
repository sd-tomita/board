{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/top.css" type="text/css">
{/block}
{block title append} indexです{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">TOPページ</h1>
  </div>
</div>
<h2>メニュー</h2>
<ul>
{foreach $thread_list as $record}
    <li>{$record->get()}</li>

{/foreach}
</ul>
{*
<div class="sub_menu">
  <p><a href="/thread/entrance/thread-list">スレッド全件表示</a></p>

<form action="/thread/entrance/thread-list" method="GET">
<dl>
  <dt>ジャンル</dt>
    <dd><label><input type="radio" name="genre_id" value="">指定なし</label></dd>
  {foreach $genre_list as $record}
    <dd><label><input type="radio" name="genre_id" value="{$record->getId()}">{$record->getName()}</label></dd>
  {/foreach}
  
  <dt>タグ</dt>
  {foreach $tag_list as $record}
    <dd><label><input type="checkbox" name="tag_id[{$record->getId()}]" value="{$record->getId()}">{$record->getName()}</label></dd>
  {/foreach}  
</dl>
  <input type="submit" value="検索開始">
</form>

  {if $sdx_user->hasId()}
  <dl>
    <dt><i class="fa fa-lock"></i> 管理メニュー</dt>
      <dd><a href="/control/thread">スレッド管理</a></dd>
      <dd><a href="/control/genre">ジャンル管理</a></dd>
      <dd><a href="/control/tag">タグ管理</a></dd>
  </dl>
  {/if}
  
</div>
*}

{/block}
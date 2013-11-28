{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/top_page.css" type="text/css">
{/block}
{block title append} indexです{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">TOPページ</h1>
  </div>
</div>
<h2>メニュー</h2>
<div class="sub_menu">
    <p><a href="/thread/entrance/thread-list">スレッド全件表示</a></p>
  <dl>
    <dt><i class="fa fa-th-large"></i> ジャンル</dt>
      {foreach $genre_list as $record}
      <dd><a href="/thread/entrance/thread-list?genre_id={$record->getId()}">{$record->getName()}</a></dd>
      {/foreach}
  </dl>
  <dl>
    <dt><i class="fa fa-tags"></i> おすすめタグ</dt>
      {foreach $tag_list as $record}
      <dd><a href="/thread/entrance/thread-list?tag_id={$record->getId()}">{$record->getName()}</a></dd>
      {/foreach}
  </dl>

  {if $sdx_user->hasId()}
  <dl>
    <dt><i class="fa fa-lock"></i> 管理メニュー</dt>
      <dd><a href="/control/thread">スレッド管理</a></dd>
      <dd><a href="/control/genre">ジャンル管理</a></dd>
      <dd><a href="/control/tag">タグ管理</a></dd>
  </dl>
  {/if}
  
</div>
{/block}
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
  <dl>
    <dt><i class="fa fa-th-large"></i> ジャンル</dt>
      {foreach $genre_list as $record}
      <dd><a href="genre/{$record->getId()}/list">{$record->getName()}</a></dd>
      {/foreach}
  </dl>
  <dl>
    <dt><i class="fa fa-tags"></i> おすすめタグ</dt>
      {foreach $tag_list as $record}
      <dd><a href="tag/{$record->getId()}/list">{$record->getName()}</a></dd>
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
  
<div class="thread_list">
  <h2>スレッド全件</h2>
  <table class="table">
    <tr class="success">
      <th>スレッドNo.</th>
      <th>スレッド名</th>
      <th>スレッド作成日時</th>
      <th>最終エントリ日時</th>
    </tr>
    
    {foreach $thread_list as $record}
    <tr>
      <td>{$record->getId()}</td>
      <td><i class="fa fa-arrow-circle-right"></i><a href="thread/{$record->getId()}/list">{$record->getTitle()}</a></td>
      <td>{$record->getCreated_at()}</td>
      <td>{$record->get('newest_date')}</td> 
    </tr>
    {/foreach}
  </table>    
</div>
<span class="only_clear"></span>
{/block}

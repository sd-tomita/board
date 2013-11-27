{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/top_page.css" type="text/css">
{/block}
{block title append} スレッドリスト{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">スレッド一覧ページ</h1>
  </div>
</div>

<div class="thread_list">
  <h2>スレッドリスト</h2>
  <dl>
  <dt>表示モード</dt>
  {if $smarty.get.genre_id}
  <dd>ジャンル別表示</dd>
  <dt>ジャンル名</dt>
  <dd>{$thread_list->getFirstRecord()->getGenre()->getName()}</dd>
  {elseif $smarty.get.tag_id}
  <dd>タグ別表示</dd>
  <dt>タグ名</dt>
  <dd>{$tag_name->getFirstRecord()->getName()}</dd>
  {else}
  <p>全件表示</p>
  {/if}
  </dl>
  <table class="table">
    <tr class="success">
      <th>スレッドNo.</th>
      <th>スレッド名</th>
      <th>スレッド作成日時</th>
      <th>最終エントリ日時</th>
    </tr>
    {assign var=day_list value=['Sun'=>'日','Mon'=>'月','Tue'=>'火','Wed'=>'水','Thu'=>'木','Fri'=>'金','Sat'=>'土']}
    {foreach $thread_list as $record}
    <tr>
      <td>{$record->getId()}</td>
      <td><i class="fa fa-arrow-circle-right"></i><a href="/thread/{$record->getId()}/list">{$record->getTitle()}</a></td>
      <td>{$record->getCreated_at()}</td>
      <td>{$record->get('newest_date')}</td> 
    </tr>
    {/foreach}
  </table>    
</div>
<span class="only_clear"></span>
{/block}

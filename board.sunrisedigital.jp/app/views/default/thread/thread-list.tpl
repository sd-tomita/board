{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/top.css" type="text/css">
    <link rel="stylesheet" href="/css/threadlist.css" type="text/css">
{/block}
{block title append} スレッドリスト{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">スレッド一覧ページ</h1>
  </div>
</div>

<div class="thread_list">
  <dl class="status_disp">
    {if $smarty.get.genre_id}
    <dt>検索中のジャンル名</dt>
    <dd>{$genre_name->getName()}</dd>
    {/if}
    {if $smarty.get.tag_id}
    <dt>検索中のタグ名</dt>
    {foreach $tag_names as $tag_name}
    <dd>｢{$tag_name->getName()}｣</dd>
    {/foreach}
    {/if}
    {if !$smarty.get.genre_id && !$smarty.get.tag_id}
    <dd>全件表示</dd>
    {/if}
  </dl>
  <h2>スレッドリスト</h2>
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
      <td><i class="fa fa-arrow-circle-right"></i><a href="/thread/{$record->getId()}/list">{$record->getTitle()}</a></td>
      <td>{$record->getFormatedDateByZend('created_at', 'yyyy年MM月dd日(E) HH時mm分ss秒')}</td>
      <td>{if $record->get('newest_date')}{$record->getFormatedDateByZend('newest_date', 'yyyy年MM月dd日(E) HH時mm分ss秒')}{else}まだコメントがありません{/if}</td> 
    </tr>
    {/foreach}
  </table>
  {$pager->getPrevLink('前へ') nofilter}{$pager->getNextLink('次へ') nofilter}
</div>
{/block}

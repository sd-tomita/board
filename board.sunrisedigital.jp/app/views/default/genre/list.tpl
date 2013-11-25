{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/top_page.css" type="text/css">
{/block}
{block title append} ジャンル別ページ{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">ジャンル別ページ</h1>
  </div>
</div>
<div class="thread_list">
  <h2>ジャンル別スレッド一覧：{$thread_list->getFirstRecord()->getGenre()->getName()}</h2>
  <table class="table">
    <tr class="success">
      <th>スレッドNo.</th>
      <th>スレッド名</th>
    </tr>
    
    {foreach $thread_list as $record}
    <tr>
      <td>{$record->getId()}</td>
      <td><i class="fa fa-arrow-circle-right"></i><a href="/thread/{$record->getId()}/list">{$record->getTitle()}</a></td>
    </tr>
    {/foreach}
  </table>    
</div>
{/block}
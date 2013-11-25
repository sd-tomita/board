{extends file='default/base.tpl'}
{block css}
    <link rel="stylesheet" href="/css/top_page.css" type="text/css">
{/block}
{block title append} タグ別ページ{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">タグ別ページ</h1>
  </div>
</div>
<div class="thread_list">
  <h2>タグ｢{$thread_list->getFirstRecord()->getTag()->getName()}｣を含むスレッド</h2>
  <table class="table">
    <tr class="success">
      <th>スレッドNo.</th>
      <th>スレッド名</th>
    </tr>
    
    {foreach $thread_list as $record}
    <tr>
      <td>{$record->getThread()->getId()}</td>
      <td><i class="fa fa-arrow-circle-right"></i><a href="/thread/{$record->getThread()->getId()}/list">{$record->getThread()->getTitle()}</a></td>
    </tr>
    {/foreach}
  </table>    
</div>
{/block}
{extends file='default/base.tpl'}

{block title append} ジャンル別ページ{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">ジャンル別ページ</h1>
  </div>
</div>
<div class="thread_list">
  <h2>ジャンル別スレッド一覧</h2>
  <p>ジャンル名：{$thread_list->getFirstRecord()->getGenre()->getName()}</p>
  <table class="table">
    <tr class="success">
      <th>スレッドNo.</th>
      <th>スレッド名</th>
      <th>スレッド作成日時</th>
    </tr>
    
    {foreach $thread_list as $record}
    <tr>
      <td>{$record->getId()}</td>
      <td><i class="icon-circle-arrow-right"></i>{$record->getTitle()}</a></td>
      <td>{$record->getCreated_at()}</td>
    </tr>
    {/foreach}
  </table>    
</div>
{/block}
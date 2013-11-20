{extends file='default/base.tpl'}
{block title append} indexです{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">TOPページ</h1>
  </div>
</div>
<div>
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
             <td><i class="icon-circle-arrow-right"></i><a href="thread/{$record->getId()}/list">{$record->getTitle()}</a></td>
             <td>{$record->getCreated_at()}</td>
             <td>{$record->get('newest_date')}</td> 
        </tr>
        {/foreach}
    </table>
     
</div>

{/block}

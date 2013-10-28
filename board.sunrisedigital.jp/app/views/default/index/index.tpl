{extends file='default/base.tpl'}
{block title append} indexです{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">indexです</h1>
  </div>
</div>
<div>
    <table>
        <tr>
            <th>スレッド番号</th>
            <th>スレッド名</th>
            <th>作成日時</th>
        </tr>
       {foreach $thread_list as $record}
        <tr>
             <td>{$record->getId()}</td>
             <td>{$record->getTitle()}</td>
             <td>{$record->getCreated_at()}</td>
        </tr>
        {/foreach}
    </table>
     
</div>

{/block}
{block css}
{/block}
<div class="thread_list">
  {foreach $thread_list as $record}
  <table class="table table-bordered">
    <thead>
    <tr class="success">
    <th><a href="/thread/{$record->getId()}/list"><i class="fa fa-play"></i> {$record->getTitle()}</a></th>
    </tr>
    </thead>

    <tbody>
    <tr>
    <td>最終更新日時：{if $record->get('newest_date')}{$record->getFormatedDateByZend('newest_date', 'yyyy年MM月dd日(E) HH時mm分ss秒')}{else}<strong>まだコメントがありません</strong>{/if}</td>
    </tr>
    </tbody>
  </table>
  {/foreach}
  <input type="button" name="more" value="さらに表示">
</div>
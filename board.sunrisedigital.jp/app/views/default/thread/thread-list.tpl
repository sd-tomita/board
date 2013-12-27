{block css}
{/block}

{if get_class($thread_list->getFirstRecord()) == Sdx_Null}
<div class="alert alert-warning">検索条件に合致するスレッドはありません。</div>
{/if}

<div class="thread_list" {if !$pager->hasNextPage()}data-lastpage="on"{/if} data-nextpageid="{$pager->getNextPageId()}">
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
</div>

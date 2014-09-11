{extends file='default/base.tpl'}
{block css}
{/block}
{block main_contents}
{if $thread_list->isEmpty()}
<div class="alert alert-warning">検索条件に合致するスレッドはありません。</div>
{/if}

<div class="thread_list">
  {foreach $thread_list as $record}
  <table class="table table-bordered">
    <thead>
    <tr class="success">
    <th><a href="/thread/{$record->getId()}/entry-list"><i class="fa fa-play"></i> {$record->getTitle()}</a></th>
    </tr>
    </thead>

    <tbody>
    <tr>
    <td>最終更新日時：{if $record->get('newest_date')}{$record->getFormatedDateByZend('newest_date', 'yyyy年MM月dd日(E) HH時mm分ss秒')}{else}<strong>まだコメントがありません</strong>{/if}</td>
    </tr>
    </tbody>
  </table>
  {/foreach}

  {if $pager->hasPrevPage() ||$pager->hasNextPage()}
    <ul class="pager">
      {if $pager->hasPrevPage()}
        <li>{$pager->getPrevLink("前のページ") nofilter}</li>
      {/if}
      {if $pager->hasNextPage()}
        <li>{$pager->getNextLink("次のページ") nofilter}</li>
      {/if}
    </ul>
  {/if}
</div>

{/block}
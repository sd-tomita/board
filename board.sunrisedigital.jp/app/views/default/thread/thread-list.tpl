
<div class="thread_list">
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
  <ul class="pager">
    <li>{$pager->getPrevLink('前へ') nofilter}</li>
    <li>{$pager->getNextLink('次へ') nofilter}</li>
  </ul>
</div>


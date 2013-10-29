{extends file='default/base.tpl'}
{block title append} コメントページです{/block}
{block main_contents}
    <p>表示確認も兼ねて、試験的に何かを書いておく。<br>
    現時点ではEntryテーブルには何もレコードが無いので<br>
    ここにはデータが出力されない　はず</p>
    <p>レコードが追加されれば、以下に出力される</p>
    <table class="table">
        <tr class="success">
            <th>ID</th>
            <th>スレッドID</th>
            <th>アカウントID</th>
            <th>アカウント名</th>
            <th>記事内容</th>
            <th>記事投稿日時</th>
            <th>スレ立て日時</th>
        </tr>
       {foreach $entry_list as $record}
        <tr>
             <td>{$record->getId()}</td>
             <td>{$record->getThread_id()}</td>
             <td>{$record->getAccount_id()}</td>
             <td>{$record->getAccountList()->getName()}</td>
             <td>{$record->getBody()}</td>
             <td>{$record->getUpdated_at()}</td>
             <td>{$record->getCreated_at()}</td>
        </tr>
        {/foreach}
    </table>
{/block}
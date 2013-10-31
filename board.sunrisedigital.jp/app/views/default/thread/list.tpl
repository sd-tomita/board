{extends file='default/base.tpl'}
{block title append} リストページです{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">リストページです</h1>
  </div>
</div>
    <p>トップページからスレッドをクリックするとここにジャンプします。ここにはthreadテーブルのIDフィールドに対応したレコードを取得して表示</p>
    

{*スレッド表示*}
    <table class="table">
        <tr class="success">
            <th>ID</th>
            <th>スレッドID</th>
            <th>アカウントID</th>
            <th>お名前</th>
            <th>記事内容</th>
            <th>記事投稿日時</th>
            <th>スレ立て日時</th>
        </tr>
       {foreach $entry_list as $record}
        <tr>
             <td>{$record->getId()}</td>
             <td>{$record->getThread_id()}</td>
             <td>{$record->getAccount_id()}</td>
             <td>{$record->getAccount()->getLoginId()}</td>
             <td>{$record->getBody()}</td>
             <td>{$record->getUpdated_at()}</td>
             <td>{$record->getThread()->getCreated_at()}</td>
        </tr>
        {/foreach}
    </table>
{/block}
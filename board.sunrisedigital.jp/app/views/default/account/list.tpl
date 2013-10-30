{extends file='default/base.tpl'}
{block title append} アカウントリスト{/block}
{block main_contents}
    <p>ログインIDリストです。Entryテーブルに書き込んだ<br>
    実績のあるログインIDの人はその内容が記載されます</p>
<ul>
  {foreach $account_list as $account}
  <li>
    <div class="account">{$account->getLoginId()}</div>
    <ul>
      {foreach $account->getEntryList() as $entry}
      <li>
        <div>{$entry->getCreatedAt()}</div>
        <div>{$entry->getThread()->getTitle()}</div>
        <div>{$entry->getBody()}</div>
      </li>
      {/foreach}
    </ul>
  </li>
  {/foreach}
</ul>  

    
    
    
    
    
    <div class="panel panel-default">
    <div class="panel-heading">
    <h1 class="panel-title">動作確認用スペース</h1>
    </div>
</div>
<p>いろいろ書き換えてみる用</p>
    <ul>
  {foreach $account_list as $account}
      <li>
          {foreach $account->getEntryList() as $record}
      <li>
        <div>{$record->getThread()->getCreatedAt()}</div>
        <div>{$record->getThread()->getTitle()}</div>
        <div>{$record->getBody()}</div>
      </li>
      {/foreach}
      </li>
  {/foreach}
    </ul>

{/block}
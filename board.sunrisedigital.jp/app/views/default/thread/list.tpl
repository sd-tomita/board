{extends file='default/base.tpl'}
{block title append} リストページです{/block}
{block main_contents}
<div class="panel panel-default">
  <div class="panel-heading">
    <h1 class="panel-title">リストページです</h1>
  </div>
</div>
    
{*------------スレッド表示第二案------------*}
<div style="padding: 15px;">
    <div style="line-height: 3.5;
         text-indent: 10px;
         background-color: #9370db;
         color:white;
         font-weight:bold;
         border-radius: 5px;">
        <i class="icon-tags"></i>thread-{$entry_list->getFirstRecord()->getThread()->getId()}&nbsp;&nbsp;
        {$entry_list->getFirstRecord()->getThread()->getTitle()}&nbsp;&nbsp;
        <i class="icon-time"></i>スレッド作成日時：{$entry_list->getFirstRecord()->getThread()->getCreated_at()}
    </div>
    <div style="margin: 5px;
         padding: 5px;">
    {foreach $entry_list as $record}
        <dl>
            <dt style="text-indent:5px;
                background-color:#d8bfd8;
                border-radius: 5px;">
                <i class="icon-pencil"></i>
                お名前:{$record->getAccount()->getName()}&nbsp;&nbsp;
                記事投稿日時:{$record->getUpdated_at()}&nbsp;&nbsp;
                ID:{$record->getAccount_id()}
            </dt>
            <dd style="padding-left:10px;">{$record->getBody()}</dd>
        </dl>
    {/foreach}
    </div>
</div>
       

{*------------スレッド表示(第二案と比較用。)------------*}
{*    <table class="table">
        <tr class="success">         
            <th>スレッドID</th>
            <th>アカウントID</th>
            <th>お名前</th>
            <th>記事内容</th>
            <th>記事投稿日時</th>
            <th>スレ立て日時</th>
        </tr>
       {foreach $entry_list as $record}
        <tr>
             <td>{$record->getThread_id()}</td>
             <td>{$record->getAccount_id()}</td>
             <td>{$record->getAccount()->getName()}</td>
             <td>{$record->getBody()}</td>
             <td>{$record->getUpdated_at()}</td>
             <td>{$record->getThread()->getCreated_at()}</td>
        </tr>
        {/foreach}
    </table>
*}    
{*------------コメントの投稿フォーム------------*}
<div class="panel panel-default" 
     style="margin:10px;
     padding:35px;
     border:solid thin #a9a9a9;
     border-radius: 15px;">

  <p style="font-weight: bold;"><i class="icon-pencil"></i>コメント投稿フォーム</p>
  <div class="panel-body">
    {$form->renderStartTag() nofilter}
      {*<div class="form-group">
        {$form.account_id->setLabel('アカウントID')->renderLabel() nofilter}
        {$form.account_id->render([class=>"form-control", placeholder=>$form.account_id->getLabel()]) nofilter}
        {$form.account_id->renderError() nofilter}
      </div>*}
      <div class="form-group">
        {$form.body->render([class=>"form-control", placeholder=>$form.body->getLabel()]) nofilter}
        {$form.body->renderError() nofilter}
      </div>
      <div class="text-center">
          <input type="submit" name="submit" value="投稿する！" class="btn btn-success" >
      </div>
    </form>
  </div>
</div>
{/block}
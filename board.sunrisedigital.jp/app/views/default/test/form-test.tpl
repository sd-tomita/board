{extends file='default/base.tpl'}
{block css}
{/block}
{block title append} Formのテストページ{/block}
{block main_contents}
  {$form->renderStartTag() nofilter}
  {$form.genre->setDefaultEmptyChild('指定なし')->render() nofilter}
  {$form.tag->render() nofilter}
  <input type="submit" value="検索">
</form>  
  
  
{/block}
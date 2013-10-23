<?php
class FooController extends Sdx_Controller_Action_Http
{
    public function indexAction()
    {
        $this->_disableViewRenderer();
        //Smartyによるテンプレートのレンダリングを無効にするアクションのメソッドです。
    }
    public function barAction()
    {
        $this->view->assign('date', date('Y-m-d H:i:s'));
    }
    public function dbAction()
    {
        $this->_disableViewRenderer();
        
        //データベースへの接続を取得
        $db = Bd_Db::getConnection('board_master');
                
        //トランザクション開始
        $db->beginTransaction();
        
        //テーブル名を指定してINSERT文を生成・実行
        $db->insert('account', array(
            'login_id' => 'admin',
            'password' => 'some_password',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ));
        
        //コミット
        $db->commit();
        
        //取得して確認
        Sdx_Debug::dump($db->query("SELECT * FROM account")->fetchAll(), 'title');
      }
      public function ormNewAction()
      {
          $this->_disableViewRenderer();
          
          //レコードクラスの生成
          $account = new Bd_Orm_Main_Account();
          
          $account
                  ->setLoginId('test1023')
                  ->setPassword('flkdjf0');
          
          //このレコードが使用する接続を取得
          $db = $account->updateConnection();
          
          $db->beginTransaction();
          $account->save();
          $db->commit();
          
          //取得して確認
          Sdx_Debug::dump($db->query("SELECT * FROM account")->fetchAll(), 'title');
       }
       public function ormSelectAction()
       {
           $this->_disableViewRenderer();
           
           //テーブルクラスの取得
           $t_account = Bd_Orm_Main_Account::createTable();
           //主キー(DB作成時にPrimaryに指定したキー)の値が1のレコードを取得。
           //ここでは、idがPRIに指定されているので、id=1のレコードが取得される。
           $account = $t_account->findByPkey(1);
           
           //toArray()はレコードの配列表現を取得するメソッドです。
           Sdx_Debug::dump($account->toArray(), 'title');
           
           //Selectの取得
           $select = $t_account->getSelect();
           //selectにWHERE句を追加
           $select->add('id', array(1, 3));
           //SQLを発行
           $list = $t_account->fetchAll($select);
           
           //fetchAllの返り値は配列ではなくBd_Db_Record_Listのインスタンスです。
           Sdx_Debug::dump($list, 'title');
           
           //Record_Listの配列表現をdump
           Sdx_Debug::dump($list->toArray(), 'title');
           
           //簡単なJOIN
           //JOIN対象のテーブルを全て生成
           //accountテーブルのクラスを取得
           $t_account = Bd_Orm_Main_Account::createTable();
           //Entryテーブルのクラスを取得
           $t_entry = Bd_Orm_Main_Entry::createTable();
           
           //INNER JOIN
           //※orm.ymlで対象のカラムは指定済みなので、
           //ここではINNER JOINしろ　という命令だけになる。
           $t_account->addJoinInner($t_entry);
           
           //selectを取得するメソッドがgetSelectWithJoinなので注意
           $select = $t_account->getSelectWithJoin();
           
           //この結果はまだentryにレコードがないのでSQLだけ確認
           $list = $t_account->fetchAll($select);
       }
       public function ormUpdateAction(){
           $this->_disableViewRenderer();
           
           //テーブルクラスの取得
           $t_account = Bd_Orm_Main_Account::createTable();
           //主キー1のレコードを取得
           $account = $t_account->findByPkey(1);
           
           $account->setPassword('updated_password_'.date('Y-m-d H:i:s'));
           
           $db = $account->updateConnection();
           
           $db->beginTransaction();
           $account->save();//レコードの保存。逆にdeleteにすると削除になる。
           $db->commit();//トランザクションの終了
           
           //取得して確認
           Sdx_Debug::dump($db->query("SELECT * FROM account")->fetchAll(), 'title');
           
       }
       public function ormDeleteAction()
       {
           $this->_disableViewRenderer();
           
           //テーブルクラスの取得
           $t_account = Bd_Orm_Main_Account::createTable();
           //主キー1のレコードを取得
           $account = $t_account->findByPkey(1);
           
           $db = $account->updateConnection();
           
           $db->beginTransaction();
           $account->delete();
           $db->commit();
           
           //取得して確認
           Sdx_Debug::dump($db->query("SELECT * FROM account")->fetchAll(), 'title');
       }
}
?>

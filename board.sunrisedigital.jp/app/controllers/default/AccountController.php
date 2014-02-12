<?php
class AccountController extends Sdx_Controller_Action_Http
{
    public function createAction()
    {
        $form = new Sdx_Form();//インスタンスを作成
        $form
                ->setActionCurrentPage()//アクション先を現在のURLに設定
                ->setMethodToPost();//メソッドをPOSTに変更
       
        //各エレメントをフォームにセット
        //login_id
        $t_account = Bd_Orm_Main_Account::createTable();
        $elem = new Sdx_Form_Element_Text();
        $elem
                ->setName('login_id')
                ->addValidator(new Sdx_Validate_NotEmpty())//入力値があるかどうか
                ->addValidator(new Sdx_Validate_Regexp(//正規表現とマッチしているか
                        '/^[a-zA-Z0-9_@-]+$/u',
                        '英数字と@_-のみ使用可能です')
                        )
                ->addValidator(new Sdx_Validate_Db_Unique($t_account, 
                        'login_id',
                        $t_account->getSelect()->forUpdate()
                        ));
        $form->setElement($elem);
        
        //password
        $elem = new Sdx_Form_Element_Password();
        $elem
                ->setName('password')
                ->addValidator(new Sdx_Validate_NotEmpty())
                ->addValidator(new Sdx_Validate_StringLength(array('min'=>4)));
        $form->setElement($elem);
        
        //name
        $elem = new Sdx_Form_Element_Text();
        $elem
                ->setName('name')
                ->addValidator(new Sdx_Validate_NotEmpty())
                ->addValidator(new Sdx_Validate_StringLength(array('max'=>18)));
        
        $form->setElement($elem);
        //formがsubmitされていたら
        if($this->_getParam('submit'))//submitボタンが押されていれば
        {
         //Validateを実行するためにformに値をセット
         //エラーがあったとき、各エレメントに値を戻す処理も兼ねる
             $form->bind($this->_getAllparams());
         
            $account = new Bd_Orm_Main_Account();
            $db = $account->updateConnection();
         
            $db->beginTransaction();
            //try～catch 例外処理をするためのステートメント(命令語)
            try
            {
                 //validateの実行はFOR UPDATEのためトランザクションの内側
                if($form->execValidate())
                {
                //全てのエラーチェックを通過
                    $account//ここで値をセットする。
                     ->setLoginId($this->_getParam('login_id'))
                     ->setRawPassword($this->_getParam('password'))
                     ->setName($this->_getParam('name'));
             
                    $account->save();
                    $db->commit();
                    
                    //ログイン処理
                    $login_process = new Bd_Controller_Action_Helper_Secure();
                    $login_process->loginProcess($this->_getParam('login_id'), $this->_getParam('password'));

                    $this->redirectAfterSave('/');
                }
                else
                {
                    $db->rollback();
                }
            }
            catch(Exception $e)
            {
                //別のエクセプションに対しても書ける   
            }
            catch(Exception $e)
            {
                 $db->rollback();
                throw $e;
            }
        }        
        $this->view->assign('form', $form);
        
     }
     public function listAction()
     {
         //JOINに使う各テーブルのクラスを取得
         $t_account = Bd_Orm_Main_Account::createTable();
         $t_entry = Bd_Orm_Main_Entry::createTable();
         $t_thread = Bd_Orm_Main_Thread::createTable();
         
         //JOIN操作
         $t_account->addJoinLeft($t_entry);
         $t_entry->addJoinLeft($t_thread);
         
         //selectを作成
         $select = $t_account->getSelectWithJoin();
         $select->order('id DESC');//ORDER BY id DESC(idを降順でSELECT)
         
         $list = $t_account->fetchAll($select);
         $this->view->assign('account_list', $list);
         
      }
}

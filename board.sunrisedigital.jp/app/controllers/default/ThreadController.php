<?php
class ThreadController extends Sdx_Controller_Action_Http
{
    public function indexAction()
    {
        Sdx_Debug::dump($this->_getParam('thread_id'), 'title');
    }
    public function addAction()
    {
        
    }
    public function deleteAction()
    {
        
    }
}
?>

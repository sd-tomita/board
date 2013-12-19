$(function(){
  /* *
   * 必要なものの準備
   */
  var searchSubmit = $("#search-form input[type='submit']");
  var searchMore = $('input[name=more]');
  var loading = $('.loading');
  var currentPid = 1;
  
  /* *
   * Ajax通信用のfunction
   */
  function loadThread(currentPid){
    searchSubmit.hide();//通信が開始したらすぐ隠す
    var $form = $("#search-form");
    var query = $form.serialize();
    
    $.ajax({
      type: "GET",
      url: "/thread/entrance/thread-list", 
      data: query+"&pid="+currentPid,
    }).done(function(data){
        $('.data-disp').append(data);
    }).fail(function(data){
        alert("NG");
    }).always(function(data){
        searchSubmit.show();//通信が終わったのでsubmitボタンの非表示を解除
        loading.hide();
        
        //｢さらに表示｣ボタンの表示・非表示はここで決める
        if($(".thread_list").is("[data-lastpageflag]")){
          searchMore.hide();
        }
        else
        {
          searchMore.show();
        }
    });
    
    return this;
  }
  
  //検索ボタンを押したときの動作
  searchSubmit.on('click', function(){
    currentPid = 1;//ページIDを先頭に戻す
    searchSubmit.hide();
    loading.show();
    $('.data-disp').html("");//これまでappendされたものを消す。
    loadThread(currentPid);
  });
  
  //｢さらに表示｣ボタンを押したときの動作
  searchMore.on('click', function(){
    ++currentPid;//実行の度にpidが増える。
    searchMore.hide();
    loading.show();
    loadThread(currentPid);
  });
  
  //ページ読み込み時に動作
  loadThread(currentPid);
});

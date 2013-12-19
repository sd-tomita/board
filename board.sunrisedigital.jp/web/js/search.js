$(function(){
  /* *
   * 必要なものの準備
   */
  var searchSubmit = $("#search-form input[type='submit']");
  var searchMore = $('input[name=more]');
  var loading = $('#search-form .loading');
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
        //通信完了時の処理。ここでsubmitボタンを元に戻す
        searchSubmit.show();
        loading.hide();
        if($(".thread_list").is("[data-lastpageflag]")){
          searchMore.hide();
        }
        else{
          searchMore.show();
        }
    });
    return this;
  }
  
  //検索ボタンを押したときの動作
  searchSubmit.on('click', function(){
    currentPid = 1;//ページIDを最初に戻す
    searchSubmit.hide();
    loading.show();
    $('.thread_list').remove();//これまでappendされたものを消す。
    loadThread(currentPid);
  });
  
  //｢さらに表示｣ボタンを押したときの動作
  searchMore.on('click', function(){
    ++currentPid;//実行の度にpidが増える。
    loadThread(currentPid);
  });
  
  //ページ読み込み時に動作
  loadThread(currentPid);
});

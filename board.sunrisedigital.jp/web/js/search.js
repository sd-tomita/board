$(function(){
  /* *
   * 変数の用意
   */
  var searchSubmit = $("#search-form input[type='submit']");
  var searchMore = $('input[name=more]');
  var loading = $('.loading');
  var currentPid = 1;
  
  /* *
   * 通信用の使いまわしfunction
   */
  function loadThread(somePid){
    searchSubmit.hide();//通信が開始したらすぐ隠す
    searchMore.hide();//これも隠しておかないと通信開始直後｢さらに表示｣がいきなり見える。
    var $form = $("#search-form");
    var query = $form.serialize();
    
    $.ajax({
      type: "GET",
      url: "/thread/entrance/thread-list", 
      data: query+"&pid="+somePid,
    }).done(function(data){
        $('.data-disp').append(data);
    }).fail(function(data){
        alert("NG");
    }).always(function(data){
        searchSubmit.show();//通信が終わったのでsubmitボタンの非表示を解除
        loading.hide();
        
        //｢さらに表示｣ボタンは次ページがある場合は表示
        if(!$(".thread_list").is("[data-hasnextpage='on']")){
          searchMore.show();
        }
    });
    
    return this;
  }
  
  /* *
   * 各種イベント別動作
   */
  
  //submitボタンを押したときの動作
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
  
  //ページのロード時に実行
  loadThread(currentPid);
});

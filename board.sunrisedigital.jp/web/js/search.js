$(function(){
  /* *
   * 変数の用意
   */
  var searchSubmit = $("#search-form input[type='submit']");
  var searchMore = $('input[name=more]');
  var loading = $('.loading');
  var nodata = $(".no-data");
  
  /* *
   * 通信用function
   */
  function loadThread(somePid){
    //somePid がnull、0、空文字、undefined だったら"1"になるようにする。
    somePid = somePid || 1;
    
    //いきなり見えちゃよくないものを隠す
    searchSubmit.hide();
    searchMore.hide();
    nodata.hide();
    
    var $form = $("#search-form");
    var query = $form.serialize();
    var tpl_html = $("#tpl_article_row").text();
    
    $(".data-disp").addClass("thread_list");
    $.ajax({
      type: "GET",
      url: "/thread/entrance/thread-list",
      dataType: "json",
      data: query+"&pid="+somePid

    }).done(function(data){
        //検索条件に一致するものが1つも無ければメッセージを表示させる。
        if(data['records'].length === 0){
          nodata.show();
        }
        
        //レコードがあればそれを出力する。
        $.each(data.records, function(){          
          //data.records[i]ごとに毎回テンプレを新しく取得         
          var html = tpl_html;
          
          $.each(this, function(key,value){            
            //newest_dateだけは表示形式に手を加えたいので処理を分岐
            if(key==="newest_date"){            
              //表示形式を変換して代入
              (function(){
                var _bd = BoardSdjpObj;              
                html = html.split("%newest_date%").join(_bd.formatDate(value));
              })();
            }
            //日付以外はそのまま代入
            else
            {
              html = html.split("%"+key+"%").join(value);
            }
          });
          
          //出来上がったHTMLをそのままappendする
          $(".data-disp").append(html);
        });
    
        //｢さらに表示｣ボタンの表示判定に使うdata-next_pid属性を追加
        $(".data-disp").attr("data-next_pid",data.next_pid);
    }).fail(function(jsondata){
        alert("NG");
    }).always(function(jsondata){
        searchSubmit.show();//通信が終わったのでsubmitボタンの非表示を解除
        loading.hide();
        
        //｢さらに表示｣ボタンはnext_pidがある限り表示させる
        if($(".data-disp").attr("data-next_pid")){
          searchMore.show();
        }
    });
    
    return this;
  }
  
  /* *
   * 各種イベント別動作
   */
  
  //｢検索開始｣ボタンを押したら通信
  searchSubmit.on('click', function(){
    searchSubmit.hide();
    loading.show();
    $('.data-disp').html("");//これまでappendされたものを消す。
    loadThread();
  });
  
  //｢さらに表示｣ボタンを押したら通信
  searchMore.on('click', function(){
    searchMore.hide();
    loading.show();
    
    //次ページIDを引数に渡す    
    loadThread($(".data-disp").attr("data-next_pid"));
  });
  
  //ページのロード時に通信
  loadThread();
});
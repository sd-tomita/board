/* * 
 * 日付フォーマット変換用
 * PHPから受け取った日付をそのまま出力すると
 * " 2014-01-10 15:25:43 "みたいな形式になるので
 * これを" 2014年1月10日(金) 15時25分43秒 "になおす。
 */
function formatDate(str) {
  // デフォルト値を設定
  str = str || "投稿がありません";

  // 日付以外が引数に入っているようだったら即returnする。
  // Date()に日付以外を渡すと正常に動かないため。
  if(!str.match(/\d{4}-\d{2}-\d{2}\s\d{2}:\d{2}\:\d{2}/)){
    return str;
  }

  //Chromeではないブラウザ対策
  // yyyy-mm-dd ⇒ yyyy/mm/dd にしてからDate()に渡す
  var date = new Date(str.replace(/-/g,'/'));
    
  var week = ["日","月","火","水","木","金","土"];//日本語曜日表示用
  var month = date.getMonth()+1;//そのまま出力すると0月～11月表記になるので。
    
  //変換開始
  var formatted = 
    date.getFullYear()+"年"
    +month +"月"
    +date.getDate()+"日"
    +"("+week[date.getDay()]+")"+"　"
    +date.getHours()+"時"
    +date.getMinutes()+"分"
    +date.getSeconds()+"秒";

  return formatted;
}
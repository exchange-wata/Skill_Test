// var id = $('div').attr('id');

$(function(){

//モーダルウィンドウを出現させるクリックイベント
$("#modal-open").click( function(){

	//キーボード操作などにより、オーバーレイが多重起動するのを防止する
	$( this ).blur() ;	//ボタンからフォーカスを外す
	// console.log($(this).attr('id'));
	// console.log("#modal-open-"+$(this).attr('id'));

	// if( $( "#modal-overlay" )[0] ) return false ;		//新しくモーダルウィンドウを起動しない (防止策1)
	if($("#modal-overlay")[0]) $("#modal-overlay").remove() ;		//現在のモーダルウィンドウを削除して新しく起動する (防止策2)

	//オーバーレイを出現させる
	$( "body" ).append( '<div id="modal-overlay"></div>' ) ;
	$( "#modal-overlay" ).fadeIn( "slow" ) ;

	//コンテンツをセンタリングする
	centeringModalSyncer() ;

	// var idname="#modal-content-"+$(this).attr('id');
    // $(idname).fadeIn("slow");

	//コンテンツをフェードインする
	$( "#modal-content" ).fadeIn( "slow" ) ;

	 // $("#modal-content-"+$(this).attr('id')).fadeIn("slow");

	//[#modal-overlay]、または[#modal-close]をクリックしたら…
	$( "#modal-overlay,#modal-close" ).unbind().click( function(){
	// $( "#modal-overlay" ).unbind().click( function(){

		//[#modal-content]と[#modal-overlay]をフェードアウトした後に…
		// $(idname).fadeOut("slow");
		$( "#modal-content,#modal-overlay" ).fadeOut( "slow" , function(){

			//[#modal-overlay]を削除する
			$('#modal-overlay').remove() ;

		} ) ;

	} ) ;

} ) ;

//リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
$( window ).resize( centeringModalSyncer ) ;

	//センタリングを実行する関数
	function centeringModalSyncer() {

		//画面(ウィンドウ)の幅、高さを取得
		var w = $( window ).width() ;
		var h = $( window ).height() ;

		// コンテンツ(#modal-content)の幅、高さを取得
		// jQueryのバージョンによっては、引数[{margin:true}]を指定した時、不具合を起こします。
//		var cw = $( "#modal-content" ).outerWidth( {margin:true} );
//		var ch = $( "#modal-content" ).outerHeight( {margin:true} );
		var cw = $( "#modal-content" ).outerWidth();
		var ch = $( "#modal-content" ).outerHeight();

		// 真ん中に配置するために左から何px離せばいいかを計算し変数に格納
		var pxleft = ((w - cw)/2);

		// 真ん中に配置するために上から何px離せばいいかを計算し変数に格納
		var pxtop = ((h - ch)/2);

		//センタリングを実行する
		// $( "#modal-content" ).css( {"left": ((w - cw)/2) + "px","top": ((h - ch)/2) + "px"} ) ;
		$( "#modal-content" ).css( {"left": pxleft + "px","top": pxtop + "px"} ) ;

	}

} ) ;
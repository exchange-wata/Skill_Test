// $(function(){
// 	$('#login-show').click(function(){
// 		$('#login-modal').fadeIn();

// 	});

// });
// 

function load_signin(){
	$("#signin").load("signin.php");
};

// $(function() {
// $.ajax({
// url:'signin.php',
// datetype:'html',
// success: function(data){
// $("#signin").text(data);
// }
// });
// });

// function load_signin(ファイル名, 読込後処理名) {
//         var ＸＭＬＨＲ = new XMLHttpRequest();                              // Ａ
//         ＸＭＬＨＲ.onreadystatechange = function() {                        // Ｂ
//             if (ＸＭＬＨＲ.readyState == 4 && ＸＭＬＨＲ.status==200) {     // Ｃ
//                 var 読込文 = ＸＭＬＨＲ.responseText;                       // Ｄ
//                 document.getElementById("#signin").innerHTML = 読込文;     // Ｅ
//             }
//         }
//         ＸＭＬＨＲ.open("GET", signin.php, true);                           // Ｆ
//         ＸＭＬＨＲ.send(null);                                              // Ｇ
//     };

// function open_load_signin(読込文) {                                   // Ｍ
//         document.getElementById("#signin").innerHTML = 読込文;
//     };
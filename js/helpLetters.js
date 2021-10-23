//used with helpView.php
//listen button wordX
$("#openXL").on("click", function() {
   $('.popup-overlay').load('inc/wordsX_oc-lengadoc.html');
   $('.popup-overlay').addClass("active");

});
$("#openXG").on("click", function() {
   $('.popup-overlay').load('inc/wordsX_oc-gascon.html');
   $('.popup-overlay').addClass("active");

});
$("#closeXL,#closeXG, .popup-overlay").on("click", function() {
  $(".popup-overlay").removeClass("active");
});

//listen button wordQ
$("#openQL").on("click", function() {
   $('.popup-overlay').load('inc/wordsQ_oc-lengadoc.html');
   $('.popup-overlay').addClass("active");

});
$("#openQG").on("click", function() {
   $('.popup-overlay').load('inc/wordsQ_oc-gascon.html');
   $('.popup-overlay').addClass("active");

});
$("#closeQL,#closeQG, .popup-overlay").on("click", function() {
  $(".popup-overlay").removeClass("active");
});

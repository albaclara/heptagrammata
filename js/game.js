
//wordboard contains values of squares corresponding with the word before validation
// It's used by validationWord.js and functions.js, so it need to be global
wordboard = [];
translation = JSON.parse($("#translation").val());

$(document).ready(function () {
    $("#validation").show();
    $("#confirmation").hide();
    $("#miss").show();
    $("#annulation").hide();
    $("#infobeforevalidation").hide();
    $("#wordX").hide();
    $("#wordQ").hide();
    dialect = $("#dialect").val();
    if (Number($("#playersnb").val()==1)) {
        $("#miss").hide();
    }
    var rack = JSON.parse($("#myrack").val());
    for (let i =0; i < 7; i++) { // à revoir pass this like a parameter
        if (rack[i] == "X") {
            $("#wordX").show();
        }
        if (rack[i] == "Q") {
            $("#wordQ").show();
        }
    }

    // Listener button congres
    $("#congres").click(function (){
        var word = $("#word").val().toLowerCase();
        var requestURL = 'https://cors-anywhere.herokuapp.com/http://api.locongres.org/words.php?key=92ce96d0b904c47f28a7e644c8513bce&term='+word+'&var=gascon&sens=i';
        var request = new XMLHttpRequest();
        var message = "";
        request.open('GET', requestURL,true);

        request.responseType = 'json';
        request.send();

        request.onload = function() {
            var verif = request.response;
            if (typeof verif.query  == "undefined") {
                message = translation["Message_CongresKO"][0];
            } else {
                message = translation["Message_CongresOK"][0];
            }
            $("#infobeforevalidation").hide().fadeIn().text(message);
        }
    });

    // Listener button annulation
    $("#annulation").click(function (board){
        $('table td').removeClass("activsquare");
        $("#infobeforevalidation").hide();
        $("#confirmation").hide();
        $("#annulation").hide();
        //$("#information").hide();
        $("#validation").show();
        $("#miss").show();
        cleanwordonboard(board);
        $("#linefirstletter").prop("disabled", false);
        $("#columnfirstletter").prop("disabled", false);
        $("#vertical").prop("disabled", false);
        $("#horizontal").prop("disabled", false);
        //$("#word").prop("disabled", false);
        $("#word").val("");
        $("#word").html("");
        $("#infobeforevalidation").hide().fadeIn().text("");
    });


    // Listener button miss
    $("#miss").click(function (){
        $("#word").val("");
        $("#confirmation").show();
        $("#annulation").show();
        $("#validation").hide();
        $("#miss").hide();
        $("#infobeforevalidation").hide().fadeIn().text(translation["Message_MissConfirm"][0]);
    });

    // Listener button check
    $("#validation").click(function (){
        var valid = true
        var word = $("#word").val().toUpperCase();
        var linemax = parseInt($("#linemax").val());
        var colmax = parseInt($("#colmax").val());
        if (word!="") {
            word = removeAccent(word);
            var lineword = Number($("#linefirstletter").val());
            var columnword = Number($("#columnfirstletter").val());
            var numround = Number($("#numround").val());
            var direction = $('input[name=direction]:checked').val();
            if (direction == 'right') {
                txtdirection =translation["Txt_Right"][0];
            } else {
                txtdirection = translation["Txt_Top"][0];
            }
            // check length of the word (>1)

            if (! lengthword(word)) {
                valid = false;
            } else {
                // check letter in alphabet occitan
                if (! checklettersword(word)) {
                    valid = false;
                } else {
                    // check if num line and num column correct
                    if (! checknumlinecol(columnword,lineword,direction,word,numround,linemax,colmax)) {
                        valid = false;
                    } else {
                        //check if we can put word on the board
                        var board = JSON.parse($("#myboard").val());
                        var rack = JSON.parse($("#myrack").val());
                        // check that word is really crossing with other word
                        if (numround != 1) {
                            if (! checkcrossing(columnword,lineword,direction,word,board)) {
                                valid = false;
                            }
                        }
                        if (valid == true) {
                            // check that letters on the board match with letters of the  word
                            var result = checkwordonboard(columnword,lineword,direction,word,rack,board);
                            var racknew = result[0];
                            var blankused = result[1];
                            if (racknew.join() == rack.join()) {
                                valid = false;
                            } else {
                                rack = racknew;
                            }
                        }
                    }
                }
            }
        }

        if(valid) {
            $("#newrack").val(JSON.stringify(rack));
            if ( $("#word").val() != "") {
                $("#blankused").val(JSON.stringify(blankused));

                $("#infobeforevalidation").hide().fadeIn().text(translation["Message_Confirm"][0]+word+translation["Message_WordColumn"][0]+columnword+translation["Message_WordLine"][0]+lineword+" "+txtdirection+" ?");
            } else {
                $("#infobeforevalidation").hide().fadeIn().text(translation["Message_MissConfirm"][0]);
            }
            $("#confirmation").show();
            $("#annulation").show();
            $("#validation").hide();
            $("#miss").hide();
            $("#linefirstletter").prop("disabled", true);
            $("#columnfirstletter").prop("disabled", true);
            $("#vertical").prop("disabled", true);
            $("#horizontal").prop("disabled", true);
            //$("#word").prop("disabled", true);

        }  // end OK

    });

    // Listener button validation
    $("#confirmation").click(function (){
    $("#linefirstletter").prop("disabled", false);
    $("#columnfirstletter").prop("disabled", false);
    $("#vertical").prop("disabled", false);
    $("#horizontal").prop("disabled", false);
    $("#word").prop("disabled", false);
    $('#form_word').submit();

    });

    // Listener square board
    $('table td').click(function(){

        $('table td').removeClass("activsquare");
        var position = $(this).attr('id').split('_');
        var cell = position[0];
        var row = position[1];
        $(this).addClass("activsquare");
        $("#linefirstletter").val(cell);
        $("#columnfirstletter").val(row);
	});

    //listen button wordX
    $("#openX").on("click", function() {
       $('#popup-overlayX').load('inc/wordsX_'+dialect+'.html');
       $('#popup-overlayX').addClass("active");

    });
    $("#closeX, #popup-overlayX").on("click", function() {
      $("#popup-overlayX").removeClass("active");
    });

    //listen button wordQ
    $("#openQ").on("click", function() {
       $('#popup-overlayQ').load('inc/wordsQ_'+dialect+'.html');
       $('#popup-overlayQ').addClass("active");
    });
    $("#closeQ, #popup-overlayQ").on("click", function() {
      $("#popup-overlayQ").removeClass("active");
    });


});


function removeAccent(word) {
    word =word.replace("É","E");
    word =word.replace("È","E");
    word =word.replace("Ë","E");
    word =word.replace("Í","I");
    word =word.replace("Ï","I");
    word =word.replace("Ú","U");
    word =word.replace("Ü","U");
    word =word.replace("Á","A");
    word =word.replace("À","A");
    word =word.replace("Ò","O");
    word =word.replace("Ó","O");
    word =word.replace("Ç","C");
    $("#word").val(word);
    return word;
}

function checklettersword(word) {
    var valid = true;
var reg =  /^([ABEFHIKMNOPTXYZabefhikmnoptxyzΩΣΠΛΘΔΓΦΞΨ\-\'\ÉÈËÍÏÚÜÁÀÒÓÇàáéèëíïúüóòç])+$/;
    if(!(reg.test(word))) {
        valid = false ;
        $("#infobeforevalidation").hide().fadeIn().text(translation["Error_Character"][0]);
    } else {

    }
    return valid;
}

function lengthword(word) {
    var valid = true;
    if (word.length <2) {
        valid = false ;
        $("#infobeforevalidation").hide().fadeIn().text(translation["Error_Length"][0]);
    } else {

    }
    return valid;
}

function checknumlinecol(columnword,lineword,direction,word,numround,linemax,colmax) {
    var valid = true;
    if (  (parseInt(columnword)>colmax) || (parseInt(lineword)>linemax) ||(parseInt(columnword)<1) || (parseInt(lineword)<1) || (isNaN(parseInt(columnword))) || (isNaN(parseInt(lineword)))) {
        valid = false ;
        $("#infobeforevalidation").hide().fadeIn().text(translation["Error_NumColLine"][0]);
    } else {
        if (direction == 'right') {
            if (parseInt(columnword)>colmax-word.length+1)  {
                valid = false;
                $("#infobeforevalidation").hide().fadeIn().text(translation["Error_NumColLine"][0]);
            }
        } else {
            if (parseInt(lineword)>linemax-word.length+1) {
                valid = false ;
                $("#infobeforevalidation").hide().fadeIn().text(translation["Error_NumColLine"][0]);
            }
        }
    }


    if(numround == 1) {
        // à changer passer 8 en paramètre
        if (direction == 'right') {
            if ((lineword != ((linemax+1)/2)) || (columnword >((colmax+1)/2)) || (columnword<((colmax+1)/2)+1-word.length)) {
                valid = false;
            }
        } else {
            // direction = down
            if ((columnword != ((colmax+1)/2)) || (lineword > ((linemax+1)/2)) || (lineword<((linemax+1)/2)+1-word.length)) {
                valid = false;
            }
        }
        if (valid == false) {
            $("#infobeforevalidation").hide().fadeIn().text(translation["Error_Star"][0]);
        }
    }
    return valid;
}

function checkcrossing(columnword,lineword,direction,word,board) {
    // check that word is really crossing with other word
    var connection = false;
    var reg =  /^([ABEFHIKMNOPTXYZΩΣΠΛΘΔΓΦΞΨ])+$/;

    if (direction == 'right') {
        // for each square
        for (var k =0; k < word.length; k++) {
            if(! reg.test(board[lineword][columnword+k])) {
                //check if letter above
                if(reg.test(board[lineword-1][columnword+k])) {
                    connection=true;
                }
                //check if letter below
                if(reg.test(board[lineword+1][columnword+k])) {
                    connection=true;
                }
            }
            //check if letter on the same line (word extended)
            if(reg.test(board[lineword][columnword+k])) {
                connection=true;
            }
        }
    } else {
        // direction = down
        // for each square
        for (var k =0; k < word.length; k++) {
            if(! reg.test(board[lineword+k][columnword])) {
            // check if letter on the left
                if(reg.test(board[lineword+k][columnword-1])) {
                    connection=true;
                }
                // check if letter on the right
                if(reg.test(board[lineword+k][columnword+1])) {
                    connection=true;
                }
            }
            if(reg.test(board[lineword+k][columnword])) {
                connection=true;
            }
        }
    }
    if (connection == false) {
        $("#infobeforevalidation").hide().fadeIn().text(translation["Error_Crossing"][0]);
    }
    return connection;
}

function checkwordonboard(columnword,lineword,direction,word,rack,board) {
    // check that letters on the board match with the  word
    var valid = true;
    var reg =  /^([ABEFHIKMNOPTXYZΩΣΠΛΘΔΓΦΞΨ])+$/;
    var squareafter;
    var badletters ="";
    //test if letter on the board after the boundary of the word
    if (direction == 'right') {
        squareafter = board[lineword][columnword+word.length];
    } else {
        // direction = down
        squareafter = board[lineword+word.length][columnword];
    }
    if (direction == 'right') {
        squarebefore = board[lineword][columnword-1];
    } else {
        // direction = down
        squarebefore = board[lineword-1][columnword];
    }
    if (reg.test(squareafter) || reg.test(squarebefore)) {
        valid = false;
        message = translation["Error_BeforeAfter"][0];
    } else {


        //nbblank is an array wich contains range of each blanck on the rack
        var nbblank = new Array();
        // store positions where blanks are used instead letters
        var blanksused = new Array();
        // newrack is update when a tile is put on the board and, at the end, contains remaining tiles after putting word on the board
        //newrack is a copy of rack
        var newrack = rack.slice();

        if (direction == 'right') {
            for (let i = columnword; i < word.length+columnword; i++) {
                wordboard[i-columnword] = board[lineword][i];
            }
        } else {
            // direction = down
            for (let i = lineword; i < word.length+lineword; i++) {
                wordboard[i-lineword] = board[i][columnword];
            }
        }

        // badletters contains letters which don't correspond with board
        // store the position of blanks on the rack
        for (let i =0; i < 7; i++) { // à revoir pass this like a parameter
            if (newrack[i] == "#") {
                nbblank.push(i);
            }
        }

        for (let i =0; i < word.length; i++) {
            letter = word.substring(i,i+1);

            letterboard = wordboard[i];
            // if square contains a letter
            if(reg.test(letterboard)) {
                if (letterboard != letter) {
                    valid = false ;
                    message = translation["Error_MismatchLettersBoard"][0];
                }
            // if not letter on the square
            } else {
                rangeLetterRack = newrack.indexOf(letter);
                // letter not in the rack
                if (rangeLetterRack == -1) {
                    //if not blank on the rack  bad letter is recorded in 'badletters'

                    if (nbblank.length == 0) {
                        valid = false ;
                        badletters += letter+" ";
                        message = badletters+translation["Error_LettersMissing"][0];
                    // letter is replaced by a blank, so  a blank is remove from the rack and from nbblank
                    } else {
                        newrack.splice(nbblank[0], 1);
                        nbblank.splice(0,1);
                        // case where there are 2 blanks on the rack
                        if (nbblank.length != 0) {
                            nbblank[0]=nbblank[0]-1;
                        }

                        blanksused.push(i);
                    }
                // letter in the rack
                } else {
                    //letter is removed from the rack
                    newrack.splice(rangeLetterRack, 1);
                    //new position of blanks is computed
                    for (var k= 0; k < nbblank.length; k++) {
                        if (rangeLetterRack<nbblank[k]) {
                            nbblank[k]=nbblank[k]-1;
                        }
                    }

                }
            }
        }

    }
    if (valid == false) {
        $("#infobeforevalidation").hide().fadeIn().text(message);
        newrack = rack.slice();
        clearaftererror();
    } else {
        putwordonboard(columnword,lineword,direction,word);
    }
    return [newrack,blanksused] ;

}




function putwordonboard(columnword,lineword,direction,word) {
    var valsquares = "";
    var valid = true;
    if (direction == 'right') {
        for (var i =0; i < word.length; i++) {
            letter = word.substring(i,i+1);
            mycol = columnword+i;
            valsquares +=$('#'+lineword+'_'+mycol).text();
            $('#'+lineword+'_'+mycol).text(letter);
        }
    } else {
        for (let i =0; i < word.length; i++) {
            letter = word.substring(i,i+1);
            myline = lineword+i;
            valsquares +=$('#'+myline+'_'+columnword).text();
            $('#'+myline+'_'+columnword).text(letter);
        }

    }
}

function cleanwordonboard(board) {
    var squarelegend = Array();
    squarelegend['#'] = '';
    squarelegend[':'] = 'DL';
    squarelegend[';'] = 'TL';
    squarelegend['-'] = 'DM';
    squarelegend['='] = 'TM';
    squarelegend['.'] = ' ';
    squarelegend['*'] ='\u2605';

    var reg =  /^([ABEFHIKMNOPTXYZΩΣΠΛΘΔΓΦΞΨ])$/;
    var word = $("#word").val().toUpperCase();
    if (word!="") {
        var lineword = Number($("#linefirstletter").val());
        var columnword = Number($("#columnfirstletter").val());
        var numround = Number($("#numround").val());
        var direction = $('input[name=direction]:checked').val();
        if (direction == 'right') {
            for (var i =0; i < word.length; i++) {
                legend = wordboard[i];
                if (!(reg.test(legend))) {
                    legend = squarelegend[wordboard[i]];
                }
                mycol = columnword+i;
                $('#'+lineword+'_'+mycol).text(legend);
            }
        } else {
            for (let i =0; i < word.length; i++) {
                legend = wordboard[i];
                if (!(reg.test(legend))) {
                    legend = squarelegend[wordboard[i]];
                }
                myline = lineword+i;
                $('#'+myline+'_'+columnword).text(legend);
            }
        }
    }
}

function clearaftererror() {
        $('table td').removeClass("activsquare");
        //$("#infobeforevalidation").hide();
        $("#confirmation").hide();
        $("#annulation").hide();
        //$("#information").hide();
        $("#validation").show();
        $("#miss").show();
        $("#linefirstletter").prop("disabled", false);
        $("#columnfirstletter").prop("disabled", false);
        $("#vertical").prop("disabled", false);
        $("#horizontal").prop("disabled", false);
        //$("#word").prop("disabled", false);
        $("#word").val("");
        $("#word").html("");
}

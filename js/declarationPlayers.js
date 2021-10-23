translation = JSON.parse($("#translation").val());
$(document).ready(function () {

    $(".delArticle").hide();
    $("#codeduplicate").hide();

    // Listener button duplicate
    $("#duplicateOK").change(function(){
        if ($("#duplicateOK").prop("checked", true)) {
             $("#codeduplicate").hide().fadeIn('slow');
             $(".addArticle").hide();
        }
    });

    $("#duplicateNOK").change(function(){
        if ($("#duplicateNOK").prop("checked", true)) {
             $("#codeduplicate").hide();
             $(".addArticle").hide().fadeIn('slow');
        }
    });

    // Listener button ajout
    $(".addArticle").click(function (){
        var form = $(this).closest('form');
        var articleList = form.find('.article');
        // Le nombre d'articles déjà présents
        var n = articleList.length;
        wordonboard= [];
        if ( $(".article").length <4 ) {
            // Le premier article que l'on va cloner
            var firstArticle = $(articleList[0]);
            // Le dernier article de la liste
            var lastArticle = $(articleList[n-1]);
            // Un article cloné
            var clonedArticle = firstArticle.clone();

            // Pour chaque input clonés
            clonedArticle.find(':input').each(function() {
                // On vide la valeur
                $(this).filter(':text').val('').end()

                // On change le nom en ajoutant le numero
                $(this).attr('name', 'name__'+n);
                $(this).attr('id', 'name__'+n);
            })

            // On l'ajoute au dom après les autres
            clonedArticle.insertAfter(lastArticle).hide().fadeIn('slow');
            clonedArticle.children('span').fadeIn().text("");
            clonedArticle.children(':input').focus();

            // On ajoute le le lien de suppression
            $(".delArticle").fadeIn("fast");
        } else {
           $(".addArticle").fadeOut("fast");

        }
    });

    // Listener button supprimer
    $(".delArticle").click(function (){
        var article = $(".article:last");
        article.remove();

        // If there is less than 2 articles (player alone) we hide button supprimer.
        if ( $(".article").length < 2 ) { $(".delArticle").fadeOut("fast"); }

    });
    // Listener button valid
    $("#valid").click(function() {
  	    var valid = true;
        var form = $(this).closest('form');
        var articleList = form.find('.article');
        var nb = articleList.length;
        var namesplayers = new Array();
        if ((document.getElementById('ficduplicate'))) {
            var codeduplicate = $('input[name=ficduplicate]').val()
            var namefic = "duplicatebag_"+'ficduplicate'+".txt";
        }
        //nettoieMessage();
        // vérification données saisies
        $(".article", form).each(function() {
            id =  $(this).children('input').attr('id');

			nameplayer = $(this).children('input').val();
            //check if other player has the same name
            var pos = namesplayers.indexOf(nameplayer);
            if (pos == -1) {
                //check if name playeris empty
                if(nameplayer == "")  {
                    valid = false;
                    //$(this).children('span').fadeIn().text("Format incorrect");
                    $(this).children('span').fadeIn().text(translation["Error_NamePlayerIncorrect"][0]);
                } else {
                    //check if letters of the name are in the alphabet
                    reg =  /^([A-Za-z\-ÉÈËÍÏÚÜÁÀÒÓÇàáéèëíïúüóòç1234567890 ])+$/;
            		if(!(reg.test(nameplayer))) {
            			valid = false ;
                        $(this).children('span').fadeIn().text(translation["Error_NamePlayerIncorrect"][0]);
                        //articleList.length;
                    } else {
                        namesplayers.push(nameplayer);
                    }
                }
            } else {
                 valid = false ;
                $(this).children('span').fadeIn().text(translation["Error_NamePlayerDuplication"][0]);
            }
      });
      $("#nbplayers").append('<input type="hidden" name="nbplayer" id="nbplayer" value='+nb+' />');
      //return valid;
      return valid;

    });
    function codeOK(code) {
        var namefile = "duplicate/duplicatebag_"+code+".txt";
        var valid = true;
        reg =  /^([0-9])+$/;
        if(!(reg.test(code))) {
            valid = false ;
            $("#errorcode").fadeIn().text("code incorrect");
        }
        $.get(namefile).done(function(data){}).fail(function() {
            valid = false ;
            $("#errorcode").fadeIn().text("code incorrect");
        })
        return valid;

    }

});

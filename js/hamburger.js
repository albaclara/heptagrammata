$( document ).ready(function() {
            $("#hamburgerMenu").hide();
            $("#hamburgerMenu").hamburgerMenu({
                        mainContent: 'page-wrapper'
                    }, [
                        {"id":"acuelh","href":"index.php","text":"Accueil"},
                        {"id":"joc","href":"index.php?action=players","text":"Partie traditionnelle"},
                        {"id":"jocduplicate","href":"index.php?action=duplicate","text":"Partie duplicate"},
                        {"id":"ajuda","href":"index.php?action=help","text":"Règles du jeu"},
                        {"id":"contact","href":"index.php?action=contact","text":"Contact"}
                    ]
            );

        });
jQuery.fn.extend({
    hamburgerMenu: function (settings , menuList) {
        var self= this;
        //propriété config
        this.config = {
            mainContent: 'headerscrabble',
            url:null,
            urlType: 'post',
            urlCache:false,
            urlParam:'',
            position:'left',
            marginTopContent:30,
            fromTo:'topDown'
        };

        if (settings){$.extend(this.config, settings);}

        //render
        this.render= function(menuList, self)
        {
            var me=this;
            this.config.running=false;
            this.config.marginTopContent= parseInt( $(this.config.mainContent).css("margin-top"));

            //balise header
            var header=$('<header>',{id:'header',"data-role":'header'});
            var headerscrabble = $('<header>',{id:'headerscrabble'});

            //bouton
            var containerBtn=$('<div>',{id:'hamburgerBtn'}).addClass("hide");
            containerBtn.append($('<div>'));
            containerBtn.append($('<div>'));
            containerBtn.append($('<div>'));
            $("#headerscrabble").prepend(containerBtn);

            //menu navigation
            var nav=$('<nav>',{id:'menuHamburger'}).addClass("menuHamburger").addClass("hide");
            var ul=$('<ul>');
            ul.height($(window).height());
            ul.height('0px');
            nav.addClass("topSide");
            $.each(menuList, function( index, value ) {
                var li=$('<li>',{id:(value.id!=null?value.id:'')});
                var a=$('<a>',{href:(value.href!=null?value.href:'#')}).text((value.text!=null?value.text:''));
                ul.append(li.append(a));
            });
            nav.append(ul);

            // insertion header et nav
            $(self).append(header);
            $(self).append(nav);

            //actions

            $("#headerscrabble").off('click','#hamburgerBtn');
            $("#headerscrabble").on('click','#hamburgerBtn',this,function (e) {
                if(!$(this).hasClass('hamburgerActive')) {
                    if(!me.config.running) {
                        e.data.onClickAmburger(e);
                    }
                }
            });

            $('body').off('click','#page-wrapper');
            $('body').on('click','#page-wrapper',this,function (e) {
                e.data.hideMenuHamburger(e);
            });

            $("#headerscrabble").off('click','#hamburgerBtn.hamburgerActive');
            $("#headerscrabble").on('click','#hamburgerBtn.hamburgerActive',this,function (e) {
                $("#hamburgerBtn").removeClass("hamburgerActive");
                $("#hamburgerBtn").addClass("hamburgerNoActive");
                e.data.hideMenuHamburger(e);
            });
        };

        // Click sur Hamburger
        this.onClickAmburger = function(e)
        {
            $("#hamburgerMenu").show();
            this.config.running=true;
            var mainContent= '#'+e.data.config.mainContent;
            var contentWidth = $(mainContent).width();
            $(mainContent).css('width', contentWidth);
            $('body').addClass('noScroll');
            var animateMode='linear';
            var animateSideMenuHamburger={"marginLeft": ["0", animateMode]};
            var animateSideMainContent={ "marginLeft": ["25%", animateMode] };
            var me=this;
            //var offsetMenu= $(window).height()*0.7;
            var offsetMenu= $(window).height();

            var heightUl= $("#menuHamburger ul li").length*$("#menuHamburger ul li").outerHeight()+10;
            if(heightUl>offsetMenu) {
                heightUl = offsetMenu;
            }
            //var offsetContent= heightUl+this.config.marginTopContent;
            var offsetContent= heightUl;
            $("#menuHamburger ul").animate({"height": [heightUl+"px", animateMode]}, {
                duration: 700,
                complete: function () {
                    $("#hamburgerBtn").addClass("hamburgerActive");
                    $("#hamburgerBtn").removeClass("hamburgerNoActive");
                    me.config.running=false;
                }
            });

            $(mainContent).animate({"margin-top": [offsetContent+"px", animateMode]}, {
                duration: 700,
                complete: function () {

                }
            });
        };

        // hide MenuHamburger
        this.hideMenuHamburger = function(e)
        {
            var mainContent= '#'+e.data.config.mainContent;
            $('body').removeClass('noScroll');

            var animateMode='linear';
            var animateSideMenuHamburger={ "marginLeft": ["-25%", animateMode] };
            var animateSideMainContent={"marginLeft": ["6", animateMode]};


        $("#menuHamburger ul").animate({"height": ["0px", animateMode]}, {
            duration: 700,
            complete: function () {
                $("#hamburgerBtn").removeClass("hamburgerActive");
                $("#hamburgerBtn").addClass("hamburgerNoActive");
            }
        });

        $(mainContent).animate({"margin-top": [0+"px", animateMode]}, {
            duration: 700,
            complete: function () {

            }
        });

        };

        this.render(menuList,self);
    //fin hamburger menu
    },

// fin extend
});

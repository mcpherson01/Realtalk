/*
 * Project:      wpwBot jQuery Plugin
 * Description:  wpwBot AI based Chatting functionality are handled .
 * Author:       QuantumCloud
 * Version:      1.0
 */
var globalwpw;
var wpwTree;
var wpwAction;
var wpwKits;
var wpwMsg;

(function($) {
    "use strict";
    /*
     * Global variable as object will beused to handle
     * wpwbot chatting initialize, tree change transfer,
     * changing tree steps and cookies etc.
     */
    globalwpw={
        initialize:0,
        settings:{},
        wildCard:0,
        wildcards:'',
        wildcardsHelp:['start','support','reset', 'email subscription', 'unsubscribe' , 'livechat'],
        productStep:'asking',
        orderStep:'welcome',
        supportStep:'welcome',
        formStep: 'welcome',
        formfieldid:'',
        formid:'',
        formentry:0,
        bargainStep:'welcome', // bargin welcome message
        bargainId:0, // bargin product id
        bargainVId:0, // bargin product variation id
        bargainPrice:0, // bargin price
        bargainLoop:0, // bargin price
        hasNameCookie:$.cookie("shopper"),
        shopperUserName:'',
        shopperEmail:'',
        shopperMessage:'',
        emptymsghandler:0,
        repeatQueryEmpty:'',
        wpwIsWorking:0,
        ai_step:0,
        df_status_lock:0,
		counter:0,
		emailContent:[]

    };
    /*
     * wpwbot welcome section coverd
     * greeting for new and already visited shopper
     * based the memory after asking thier name.
     */

    var wpwWelcome={
        greeting:function () {
			
            //Very begining greeting.
            
            //generating unique session id.
            if(!localStorage.getItem('botsessionid')){

                var number = Math.random() // 0.9394456857981651
                number.toString(36); // '0.xtis06h6'
                var id = number.toString(36).substr(2); // 'xtis06h6'

                localStorage.setItem('botsessionid', id);
                console.log(localStorage.getItem('botsessionid'));
            }


			if(globalwpw.settings.obj.skip_wp_greetings==1){
				
				if(globalwpw.settings.obj.re_target_handler==0 && globalwpw.settings.obj.disable_first_msg!=1){
				var botJoinMsg="<strong>"+globalwpw.settings.obj.agent+" </strong> "+wpwKits.randomMsg(globalwpw.settings.obj.agent_join);
				wpwMsg.single(botJoinMsg);
				}

				$.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
				localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
				globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
				globalwpw.ai_step=1;
				globalwpw.wildCard=0;
				localStorage.setItem("wildCard",  globalwpw.wildCard);
				localStorage.setItem("aiStep", globalwpw.ai_step);
				
				setTimeout(function(){
					var firstMsg=wpwKits.randomMsg(globalwpw.settings.obj.hi_there)+' '+wpwKits.randomMsg(globalwpw.settings.obj.welcome)+" <strong>"+globalwpw.settings.obj.host+"!</strong> ";
					var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
					wpwMsg.single(firstMsg);
					
					setTimeout(function(){
						
						wpwMsg.double_nobg(serviceOffer, globalwpw.wildcards);
					}, globalwpw.settings.preLoadingTime);
					
				}, globalwpw.settings.preLoadingTime);
				
			}
			else if(globalwpw.settings.obj.order_login){
				
				
				if(globalwpw.settings.obj.re_target_handler==0 && globalwpw.settings.obj.disable_first_msg!=1){
				var botJoinMsg="<strong>"+globalwpw.settings.obj.agent+" </strong> "+wpwKits.randomMsg(globalwpw.settings.obj.agent_join);
				wpwMsg.single(botJoinMsg);
				}

				$.cookie("shopper", globalwpw.settings.obj.order_user, { expires : 365 });
				localStorage.setItem('shopper',globalwpw.settings.obj.order_user);
				globalwpw.hasNameCookie=globalwpw.settings.obj.order_user;
				globalwpw.ai_step=1;
				globalwpw.wildCard=0;
				localStorage.setItem("wildCard",  globalwpw.wildCard);
				localStorage.setItem("aiStep", globalwpw.ai_step);
				setTimeout(function(){
					var firstMsg=wpwKits.randomMsg(globalwpw.settings.obj.hi_there)+' '+wpwKits.randomMsg(globalwpw.settings.obj.welcome)+" <strong>"+globalwpw.settings.obj.host+"!</strong> ";
					wpwMsg.single(firstMsg);
					setTimeout(function(){
						//Greeting with name and suggesting the wildcard.
						var NameGreeting=wpwKits.randomMsg(globalwpw.settings.obj.i_am) +" <strong>"+globalwpw.settings.obj.agent+"</strong>! "+wpwKits.randomMsg(globalwpw.settings.obj.name_greeting);

						//this data should be conditional
						var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
						//After completing two steps messaging showing wildcards.
						wpwMsg.double(NameGreeting,serviceOffer);
						globalwpw.ai_step=1;
						globalwpw.wildCard=0;
						localStorage.setItem("wildCard",  globalwpw.wildCard);
						localStorage.setItem("aiStep", globalwpw.ai_step);
					}, globalwpw.settings.preLoadingTime);
				}, globalwpw.settings.preLoadingTime);
				
			}else{

				if(globalwpw.settings.obj.re_target_handler==0 && globalwpw.settings.obj.disable_first_msg!=1){
				var botJoinMsg="<strong>"+globalwpw.settings.obj.agent+" </strong> "+wpwKits.randomMsg(globalwpw.settings.obj.agent_join);
				wpwMsg.single(botJoinMsg);
				}
				//Showing greeting for name in cookie or fresh shopper.
				setTimeout(function(){
					var firstMsg=wpwKits.randomMsg(globalwpw.settings.obj.hi_there)+' '+wpwKits.randomMsg(globalwpw.settings.obj.welcome)+" <strong>"+globalwpw.settings.obj.host+"!</strong> ";
					var secondMsg=wpwKits.randomMsg(globalwpw.settings.obj.asking_name);
					
					wpwMsg.double(firstMsg,secondMsg);
				}, globalwpw.settings.preLoadingTime);
			}
			
        }
    };
    //Append the message to the message container based on the requirement.
    wpwMsg={
        single:function (msg) {

            globalwpw.wpwIsWorking=1;
            $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
            //Scroll to the last message
            wpwKits.scrollTo();
            setTimeout(function(){

               
                var matches = msg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                matches = wpwKits.removeDups(matches);
                if(Array.isArray(matches)){
                jQuery.each(matches, function(i, match){
                    if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !msg.match(/<img/)){
                        msg = msg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                    }

                })
            }

                $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(msg);
                //If has youtube link then show video
                wpwKits.videohandler();
                //scroll to the last message
                wpwKits.scrollTo();
                //Enable the editor
                wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
                //keeping in history
                wpwKits.wpwHistorySave();
            }, globalwpw.settings.preLoadingTime);

        },

        single_nobg:function (msg) {

            globalwpw.wpwIsWorking=1;
            $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
            //Scroll to the last message
            wpwKits.scrollTo();
            setTimeout(function(){

                var matches = msg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                matches = wpwKits.removeDups(matches);
                if(Array.isArray(matches)){
                jQuery.each(matches, function(i, match){
                    if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !msg.match(/<img/)){
                        msg = msg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                    }

                })
            }


                $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').parent().addClass('wp-chatbot-msg-flat');
                $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').parent().append(msg);
                $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').remove();
                //scroll to the last message
                wpwKits.scrollTo();
                wpwKits.videohandler();
                //Enable the editor
                wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
                //Keeping the chat history in localStorage
                wpwKits.wpwHistorySave();
                // disabled editor
                // wpwKits.disableEditor('Please choose an option.');
            }, globalwpw.settings.preLoadingTime);
        },

        double:function (fristMsg,secondMsg) {

            

            globalwpw.wpwIsWorking=1;
            $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
            //Scroll to the last message
            wpwKits.scrollTo();
			wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
            setTimeout(function(){


                var matches = fristMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                matches = wpwKits.removeDups(matches);
                if(Array.isArray(matches)){
                jQuery.each(matches, function(i, match){
                    if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !fristMsg.match(/<img/)){
                        
                        fristMsg = fristMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                    }

                })
            }

                $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(fristMsg);
                wpwKits.videohandler();
                //Second Message with interval
                $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
                //Scroll to the last message
                wpwKits.scrollTo();
                setTimeout(function(){
                    
                    var matches = secondMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                    matches = wpwKits.removeDups(matches);
                    if(Array.isArray(matches)){
                    jQuery.each(matches, function(i, match){
                        if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !secondMsg.match(/<img/)){
                            secondMsg = secondMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                        }

                    })
                }

                    $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(secondMsg);
                    //Scroll to the last message
                    wpwKits.scrollTo();
                    wpwKits.videohandler();
                    //Enable the editor
                    wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
                    //keeping in history
                    wpwKits.wpwHistorySave();
                }, globalwpw.settings.preLoadingTime);

            }, globalwpw.settings.preLoadingTime);

        },

        triple:function (fristMsg, secondMsg, thirdMsg) {



            globalwpw.wpwIsWorking=1;
            $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
            //Scroll to the last message
            wpwKits.scrollTo();
			wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
            setTimeout(function(){
                var matches = fristMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                matches = wpwKits.removeDups(matches);
                if(Array.isArray(matches)){
                jQuery.each(matches, function(i, match){
                    if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match)  && !fristMsg.match(/<img/)){
                        fristMsg = fristMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                    }

                })
            }
                $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(fristMsg);
                wpwKits.videohandler();
                //Second Message with interval
                $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
                //Scroll to the last message
                wpwKits.scrollTo();
                setTimeout(function(){
					var matches = secondMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                    matches = wpwKits.removeDups(matches);
                    jQuery.each(matches, function(i, match){
                        if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !secondMsg.match(/<img/)){
                            secondMsg = secondMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                        }

                    })
                    $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(secondMsg);
                    wpwKits.videohandler();

                    $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
                    //Scroll to the last message
                    wpwKits.scrollTo();
                    
                    //Enable the editor
                    wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
                    //keeping in history
                    //wpwKits.wpwHistorySave();

                    setTimeout(function(){
                        var matches = thirdMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                        matches = wpwKits.removeDups(matches);
                        if(Array.isArray(matches)){
                        jQuery.each(matches, function(i, match){
                            if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !thirdMsg.match(/<img/)){
                                thirdMsg = thirdMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                            }
    
                        })
                    }
                        $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(thirdMsg);
                        //Scroll to the last message
                        wpwKits.scrollTo();
                        wpwKits.videohandler();
                        //Enable the editor
                        wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));

                        wpwKits.wpwHistorySave();

                    }, globalwpw.settings.preLoadingTime);

                }, globalwpw.settings.preLoadingTime);

            }, globalwpw.settings.preLoadingTime);

        },

        double_nobg:function (fristMsg,secondMsg) {



            globalwpw.wpwIsWorking=1;
            $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
            //Scroll to the last message
            wpwKits.scrollTo();
            setTimeout(function(){

                if (typeof fristMsg === 'string') {

                    var matches = fristMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                    matches = wpwKits.removeDups(matches);
                    if(Array.isArray(matches)){
                        jQuery.each(matches, function(i, match){
                            if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match)  && !fristMsg.match(/<img/)){
                                fristMsg = fristMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                            }

                        })
                    }
                }

                $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(fristMsg);
                wpwKits.videohandler();
                //Second Message with interval
                $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
                //Scroll to the last message
                wpwKits.scrollTo();
                setTimeout(function(){

                    var matches = secondMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                    matches = wpwKits.removeDups(matches);
                    if(Array.isArray(matches)){
                    jQuery.each(matches, function(i, match){
                        if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !secondMsg.match(/<img/)){
                            secondMsg = secondMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                        }
    
                    })
                }

                    if(globalwpw.wildCard>0){
                        $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').parent().addClass('wp-chatbot-msg-flat').html(secondMsg).append('<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                    }else{
                        $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').parent().addClass('wp-chatbot-msg-flat').html(secondMsg);
                    }
                    //scroll to the last message
                    wpwKits.scrollTo();
                    wpwKits.videohandler();
                    //Enable the editor
                    if(globalwpw.wildCard==1 && globalwpw.supportStep=='welcome'){
                        //wpwKits.disableEditor('Support');
                    }else{
                        wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
                    }
                    //keeping in history
                    wpwKits.wpwHistorySave();
                    // disabled editor
                    // wpwKits.disableEditor('Please choose an option.');
                }, globalwpw.settings.preLoadingTime);

            }, globalwpw.settings.preLoadingTime);

        },
        triple_nobg:function (fristMsg,secondMsg,thirdMsg) {

            globalwpw.wpwIsWorking=1;
            $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
            //Scroll to the last message
            wpwKits.scrollTo();
            setTimeout(function(){
                var matches = fristMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                matches = wpwKits.removeDups(matches);
                if(Array.isArray(matches)){
                    jQuery.each(matches, function(i, match){
                        if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !fristMsg.match(/<img/)){
                            fristMsg = fristMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                        }
    
                    })
                }
                $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(fristMsg);
                wpwKits.videohandler();
                //Second Message with interval
                $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
                //Scroll to the last message
                wpwKits.scrollTo();

                setTimeout(function(){
                    var matches = secondMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                    matches = wpwKits.removeDups(matches);
                    if(Array.isArray(matches)){
                    jQuery.each(matches, function(i, match){
                        if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !secondMsg.match(/<img/)){
                            secondMsg = secondMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                        }
    
                    })
                }
                    $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(secondMsg);
                    wpwKits.videohandler();
                    $(globalwpw.settings.messageContainer).append(wpwKits.botPreloader());
                    //Scroll to the last message
                    wpwKits.scrollTo();


                    setTimeout(function(){

                        var matches = thirdMsg.match(/(https?:\/\/.*\.(?:png|jpg|gif|jpeg|tiff))/i);
                        matches = wpwKits.removeDups(matches);
                        if(Array.isArray(matches)){
                        jQuery.each(matches, function(i, match){
                            if((/\.(gif|jpg|jpeg|tiff|png)$/i).test(match) && !thirdMsg.match(/<img/)){
                                thirdMsg = thirdMsg.replace(match, "<img src='"+match+"' class='wpbot_auto_image' />");
                            }
        
                        })
                    }

                        if(globalwpw.wildCard>0){
                            $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').parent().addClass('wp-chatbot-msg-flat').html(thirdMsg).append('<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                        }else{
                            $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').parent().addClass('wp-chatbot-msg-flat').html(thirdMsg);
                        }
                        //scroll to the last message
                        wpwKits.scrollTo();
                        wpwKits.videohandler();
                        //Enable the editor
                        if(globalwpw.wildCard==1 && globalwpw.supportStep=='welcome'){
                            //wpwKits.disableEditor('Support');
                        }else{
                            wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
                        }
                        //keeping in history
                        wpwKits.wpwHistorySave();
                        // disabled editor
                        // wpwKits.disableEditor('Please choose an option.');
                    }, globalwpw.settings.preLoadingTime);

                }, globalwpw.settings.preLoadingTime);

                

            }, globalwpw.settings.preLoadingTime);

        },
        shopper:function (shopperMsg) {
            $(globalwpw.settings.messageContainer).append(wpwKits.shopperMsgDom(shopperMsg));
            //scroll to the last message
            wpwKits.scrollTo();
            //keeping in history
            wpwKits.wpwHistorySave();
        },
        shopper_choice:function (shopperChoice) {
            $(globalwpw.settings.messageLastChild).fadeOut(globalwpw.settings.preLoadingTime);
            $(globalwpw.settings.messageContainer).append(wpwKits.shopperMsgDom(shopperChoice));
            //scroll to the last message
            wpwKits.scrollTo();
            //keeping in history
            wpwKits.wpwHistorySave();
        }

    };

    //Every tiny tools are implemented  in wpwKits as object literal.
    wpwKits={

        removeDups: function(names) {
            let unique = {};
            
            if(Array.isArray(names)){
                names.forEach(function(i) {
                if(!unique[i]) {
                    unique[i] = true;
                }
                });
                return Object.keys(unique);
            }else{
                return names;
            }
          },

        enableEditor:function(placeHolder){
            if(globalwpw.settings.editor_handler==0){
                if(globalwpw.settings.obj.disable_auto_focus!=1 && $(window).width()>380){
                    $("#wp-chatbot-editor").attr('disabled',false).focus();
                }
                
                $("#wp-chatbot-editor").attr('disabled',false);
                $("#wp-chatbot-editor").attr('placeholder',placeHolder);
                $("#wp-chatbot-send-message").attr('disabled',false);
            }
        },
        disableEditor:function (placeHolder) {
            if(globalwpw.settings.editor_handler==0){
                $("#wp-chatbot-editor").attr('placeholder',placeHolder);
                $("#wp-chatbot-editor").attr('disabled',true);
                $("#wp-chatbot-send-message").attr('disabled',true);
            }
            //Remove extra pre loader.
            if($('.wp-chatbot-messages-container').find('.wp-chatbot-comment-loader').length>0){
                $('.wp-chatbot-messages-container').find('.wp-chatbot-comment-loader').parent().parent().hide();
            }
        },
		wpwOpenWindow:function (url, title, w, h) {
			// Fixes dual-screen position                         Most browsers      Firefox
			var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : window.screenX;
			var dualScreenTop = window.screenTop != undefined ? window.screenTop : window.screenY;

			var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
			var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

			var left = ((width / 2) - (w / 2)) + dualScreenLeft;
			var top = ((height / 2) - (h / 2)) + dualScreenTop;
			var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

			// Puts focus on the newWindow
			if (window.focus) {
				newWindow.focus();
			}
        },
        htmlEntities:function(str) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        },
        wpwHistorySave:function () {
            
            globalwpw.wpwIsWorking=0;
            var wpwHistory= $(globalwpw.settings.messageWrapper).html();
            localStorage.setItem("wpwHitory", wpwHistory);
            
            if(localStorage.getItem('botsessionid')){

                if(!localStorage.getItem('shopperemail')){
                    var useremail = '';
                }else{
                    var useremail = localStorage.getItem('shopperemail');
                }

                if(globalwpw.hasNameCookie){
                    var shopper=globalwpw.hasNameCookie;
                } else{
                    var shopper=globalwpw.settings.obj.shopper_demo_name;
                }

                if(localStorage.getItem('shopperphone')){
                    var shopperphone = localStorage.getItem('shopperphone');
                }else{
                    var shopperphone = '';
                }
               
                var data = {'action':'qcld_wb_chatbot_conversation_save','session_id': localStorage.getItem('botsessionid'),'name':shopper,'email':useremail, 'phone':shopperphone, 'conversation':wpwKits.htmlEntities(wpwHistory), 'security':globalwpw.settings.obj.ajax_nonce};
                if(globalwpw.settings.obj.is_chat_session_active){
                    wpwKits.ajax(data).done(function (response) {
                        console.log(response);
                    })
                }
                
            }
        },

        randomMsg:function(arrMsg){
            var index=Math.floor(Math.random() * arrMsg.length);
            
            if(globalwpw.hasNameCookie){
                var shopper=globalwpw.hasNameCookie;
            } else{
                var shopper=globalwpw.settings.obj.shopper_demo_name;
            }

            if(arrMsg[index]!='' && typeof arrMsg[index] !=='undefined'){
				return arrMsg[index].replace("%%username%%", '<strong>'+shopper+'</strong>');
			}
        },
        ajax:function (data) {
            return jQuery.post(globalwpw.settings.obj.ajax_url, data);

        },
        dailogAIOAction:function(text){

            if(!localStorage.getItem('botsessionid')){

                var number = Math.random() // 0.9394456857981651
                number.toString(36); // '0.xtis06h6'
                var id = number.toString(36).substr(2); // 'xtis06h6'

                localStorage.setItem('botsessionid', id);
                console.log(localStorage.getItem('botsessionid'));
            }

            if(globalwpw.settings.obj.df_api_version=='v1'){
                return  jQuery.ajax({
                    type : "POST",
                    url :"https://api.dialogflow.com/v1/query?v=20170712",
                    contentType : "application/json; charset=utf-8",
                    dataType : "json",
                    headers : {
                        "Authorization" : "Bearer "+globalwpw.settings.obj.ai_df_token
                    },
                    
                    data: JSON.stringify( {
                        query: text,
                        
                        lang : globalwpw.settings.obj.df_agent_lan,
                        sessionId: localStorage.getItem('botsessionid')?localStorage.getItem('botsessionid'):'wpwBot_df_2018071'
                    } )
                });
            }else{
                return jQuery.post(globalwpw.settings.obj.ajax_url, {
					'action': 'qcld_wp_df_api_call',
                    'dfquery': text,
                    'sessionid': localStorage.getItem('botsessionid')?localStorage.getItem('botsessionid'):'wpwBot_df_2018071'
                });
            }
            
        },
        responseIsOk(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                if(response.status.code==200 || response.status.code==206){
                    return true;
                }else{
                    return false;
                }
            }else{
                if(typeof response.responseId !== "undefined"){
                    return true;
                }else{
                    return false;
                }
            }
        },
        getIntentName(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                return response.result.metadata.intentName;
            }else{
                return response.queryResult.intent.displayName;
            }
        },
        getParameters(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                return response.result.parameters;
            }else{
                return response.queryResult.parameters;
            }
            
        },
        getFulfillmentText(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                return response.result.fulfillment.messages;
            }else{
                return response.queryResult.fulfillmentText;
            }
            
        },
        getFulfillmentSpeech(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                return response.result.fulfillment.speech;
            }else{
                return response.queryResult.fulfillmentText;
            }
            
        },
        getScore(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                return response.result.score;
            }else{
                return response.queryResult.intentDetectionConfidence;
            }
            
        },
        getAction(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                return response.result.action;
            }else{
                if(typeof response.queryResult.action !=="undefined"){
                    return response.queryResult.action;
                }else{
                    return '';
                }
                
            }
            
        },
        queryText(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                return response.result.resolvedQuery;
            }else{
                return response.queryResult.queryText;
            }
        },
		
        isActionComplete(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                if(!response.result.actionIncomplete){
                    return true;
                }else{
                    return false;
                }
            }else{

                return response.queryResult.allRequiredParamsPresent;

            }
            
        },
        isConversationEnd(response){
            if(globalwpw.settings.obj.df_api_version=='v1'){
                if(typeof(response.result.metadata.endConversation)!=="undefined" && response.result.metadata.endConversation){
                    return true;
                }else{
                    return false;
                }
            }else{

                if(typeof response.queryResult.diagnosticInfo !=="undefined"){
                    if(typeof response.queryResult.diagnosticInfo.end_conversation !== "undefined"){
                        return response.queryResult.diagnosticInfo.end_conversation;
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }

            }
            
        },
        sugestCat:function () {
            var productSuggest=wpwKits.randomMsg(globalwpw.settings.obj.product_suggest);
            var data={'action':'qcld_wb_chatbot_category'};
            var result=wpwKits.ajax(data);
            result.done(function( response ) {
                wpwMsg.double_nobg(productSuggest,response);
                if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
                    globalwpw.wildCard=0;
                    globalwpw.ai_step=1;
                    localStorage.setItem("wildCard",  globalwpw.wildCard);
                    localStorage.setItem("aiStep", globalwpw.ai_step);
                }
            });
        },
        subCats:function (parentId) {
            var subCatMsg=wpwKits.randomMsg(globalwpw.settings.obj.product_suggest);
            var data={'action':'qcld_wb_chatbot_sub_category','parent_id':parentId};
            var result=wpwKits.ajax(data);
            result.done(function( response ) {
                wpwMsg.double_nobg(subCatMsg,response);
            });
        },
        suggestEmail:function (emailFor) {
            var sugMsg=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
            var sugOptions= globalwpw.wildcards;
            wpwMsg.double_nobg(sugMsg,sugOptions);

        }
        ,
        videohandler:function () {
            $(globalwpw.settings.messageLastChild+' .wp-chatbot-paragraph').html(function(i, html) {
                
                return html.replace(/(?:https:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g, '<iframe width="250" height="180" src="https://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>');
            });
        },
        scrollTo:function () {
            $(globalwpw.settings.botContainer).animate({ scrollTop: $(globalwpw.settings.messageWrapper).prop("scrollHeight")}, 'slow').parent().find('.slimScrollBar').css({'top':$(globalwpw.settings.botContainer).height()+'px'});
        },
        botPreloader:function () {
            var typing_animation = globalwpw.settings.obj.image_path+'comment.gif';

            if(globalwpw.settings.obj.template=='template-06' || globalwpw.settings.obj.template=='template-07'){
                typing_animation = globalwpw.settings.obj.image_path+'loader.gif';
            }

            if(globalwpw.settings.obj.typing_animation!=''){
                typing_animation  = globalwpw.settings.obj.typing_animation;
            }

            var msgContent='<li class="wp-chatbot-msg">' +
                '<div class="wp-chatbot-avatar">'+
                '<img src="'+globalwpw.settings.obj.agent_image_path+'" alt="">'+
                '</div>'+
                '<div class="wp-chatbot-agent">'+ globalwpw.settings.obj.agent+'</div>'
                +'<div class="wp-chatbot-paragraph"><img class="wp-chatbot-comment-loader" src="'+typing_animation+'" alt="Typing..." /></div></li>';
            return msgContent;
        },
        shopperMsgDom:function (msg) {
            if(globalwpw.hasNameCookie){
                var shopper=globalwpw.hasNameCookie;
            } else{
                var shopper=globalwpw.settings.obj.shopper_demo_name;
            }

            var client_image = globalwpw.settings.obj.client_image;
            if(client_image==''){
                client_image = globalwpw.settings.obj.image_path+'client.png';
            }

            var msgContent='<li class="wp-chat-user-msg">' +
                '<div class="wp-chatbot-avatar">'+
                '<img src="'+client_image+'" alt="">'+
                '</div>'+
                '<div class="wp-chatbot-agent">'+shopper +'</div>'
                +'<div class="wp-chatbot-paragraph">'+msg+'</div></li>';
            return msgContent;
        },
        showCart:function () {
            var data = {'action':'qcld_wb_chatbot_show_cart'}
            this.ajax(data).done(function (response) {
                //if cart show on message board
                if($('#wp-chatbot-shortcode-template-container').length == 0) {
                    $(globalwpw.settings.messageWrapper).html(response.html);
                    $('#wp-chatbot-cart-numbers').html(response.items);
                    $('.wp-chatbot-ball-cart-items').html(response.items);
                    wpwKits.disableEditor(wpwKits.randomMsg(globalwpw.settings.obj.shopping_cart));
                }else{  //Cart show on shortcode
                    $('.wp-chatbot-cart-shortcode-container').html(response.html);

                }
                //Add scroll to the cart shortcode
                if($('#wp-chatbot-shortcode-template-container').length > 0  && $('.chatbot-shortcode-template-02').length==0) {
                    $('.wp-chatbot-cart-body').slimScroll({height: '200px', start: 'bottom'});
                }
            });
        },
        toTitlecase:function (msg) {
            return msg.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        },
        filterStopWords:function(msg){
            var spcialStopWords=",;,/,\\,[,],{,},(,),&,*,.,+ ,?,^,$,=,!,<,>,|,:,-";
            var userMsg="";
            //Removing Special Characts from last position.
            var msgLastChar=msg.slice(-1);
            if(spcialStopWords.indexOf(msgLastChar) >= 0 ){
                userMsg=msg.slice(0, -1);
            }else{
                userMsg=msg;
            }
            var stopWords=globalwpw.settings.obj.stop_words+spcialStopWords;
            var stopWordsArr=stopWords.split(',');
            var msgArr=userMsg.split(' ');
            var filtermsgArr = msgArr.filter(function myCallBack(el){
                return stopWordsArr.indexOf(el.toLowerCase()) < 0;
            });
            var filterMsg=filtermsgArr.join(' ');
            return filterMsg;
        },
		htmlTagsScape:function(userString) {
           var tagsToReplace = {
               '&': '&amp;',
               '<': '&lt;',
               '>': '&gt;'
           };
           return userString.replace(/[&<>]/g, function(tag) {
               return tagsToReplace[tag] || tag;
           });
       }
    }
    /*
     * wpwbot Trees are basically product,order and support
     * product tree : asking,showing & shopping part will be covered.
     * order tree : showing order list and email to admin option.
     * support tree : List of support query-answer including text & video and email to admin option.
     */
    wpwTree={

        greeting:function (msg) {
			
            /**
             * When Enable DialogFlow then  or else
             */

             
            if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
				
                //When intialize 1 and don't have cookies then keep  the name of shooper in in cookie
				if(globalwpw.initialize==1 && !localStorage.getItem('shopper')  && globalwpw.wildCard==0 && globalwpw.ai_step==0 ){
					

                        
						var main_text = msg;
						msg=wpwKits.toTitlecase(msg);
						
						var dfReturns=wpwKits.dailogAIOAction(msg);
						
						dfReturns.done(function( response ) {

                            if(globalwpw.settings.obj.df_api_version=='v2'){
                                response = $.parseJSON(response);
                            }
                            
                            
							if(wpwKits.responseIsOk(response)){
								var intent = wpwKits.getIntentName(response);
								
								if(intent=="get name"){
									
									var given_name = wpwKits.getParameters(response).given_name;
									var last_name = wpwKits.getParameters(response).last_name;
									var fullname = given_name+' '+last_name;
									if(fullname.length<2){
										fullname = msg
									}

									$.cookie("shopper", fullname, { expires : 365 });
									localStorage.setItem('shopper',fullname);
									globalwpw.hasNameCookie=fullname;
									//Greeting with name and suggesting the wildcard.
									var NameGreeting=wpwKits.randomMsg(globalwpw.settings.obj.i_am) +" <strong>"+globalwpw.settings.obj.agent+"</strong>! "+wpwKits.randomMsg(globalwpw.settings.obj.name_greeting);
									if(globalwpw.settings.obj.ask_email_wp_greetings==1){
										var emailsharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_emailaddress);
										if(globalwpw.settings.obj.enable_gdpr){
                                            wpwMsg.triple_nobg(NameGreeting, emailsharetext, globalwpw.settings.obj.gdpr_text);
                                        }else{
                                            wpwMsg.double(NameGreeting, emailsharetext);
                                        }
										
                                    }else if(globalwpw.settings.obj.ask_phone_wp_greetings==1){
                                        var phonesharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_phone_gt);
										if(globalwpw.settings.obj.enable_gdpr){
                                            wpwMsg.triple_nobg(NameGreeting, phonesharetext, globalwpw.settings.obj.gdpr_text);
                                        }else{
                                            wpwMsg.double(NameGreeting, phonesharetext);
                                        }
                                    }else{
										
										//this data should be conditional
										var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                                        //After completing two steps messaging showing wildcards.                                        
                                        if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                            wpwMsg.triple_nobg(NameGreeting,serviceOffer, globalwpw.wildcards);
                                        }else{
                                            wpwMsg.double(NameGreeting,serviceOffer);
                                        }										
										globalwpw.ai_step=1;
										globalwpw.wildCard=0;
										localStorage.setItem("wildCard",  globalwpw.wildCard);
										localStorage.setItem("aiStep", globalwpw.ai_step);
										
									}

								}else if(intent=='Default Fallback Intent'){
                                    
                                    
                                    var filterMsg=wpwKits.filterStopWords(msg);
                                    
                                    if(filterMsg!=''){

                                        $.cookie("shopper", filterMsg, { expires : 365 });
                                        localStorage.setItem('shopper',filterMsg);
                                        globalwpw.hasNameCookie=filterMsg;

                                        var NameGreeting=wpwKits.randomMsg(globalwpw.settings.obj.i_am) +" <strong>"+globalwpw.settings.obj.agent+"</strong>! "+wpwKits.randomMsg(globalwpw.settings.obj.name_greeting);
                                        if(globalwpw.settings.obj.ask_email_wp_greetings==1){
                                            var emailsharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_emailaddress);
                                            if(globalwpw.settings.obj.enable_gdpr){
                                                wpwMsg.triple(NameGreeting, emailsharetext, globalwpw.settings.obj.gdpr_text);
                                            }else{
                                                wpwMsg.double(NameGreeting, emailsharetext);
                                            }
                                            
                                        }else if(globalwpw.settings.obj.ask_phone_wp_greetings==1){
                                            var phonesharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_phone_gt);
                                            if(globalwpw.settings.obj.enable_gdpr){
                                                wpwMsg.triple_nobg(NameGreeting, phonesharetext, globalwpw.settings.obj.gdpr_text);
                                            }else{
                                                wpwMsg.double(NameGreeting, phonesharetext);
                                            }
                                        }else{
                                            
                                            //this data should be conditional
                                            var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                                            //After completing two steps messaging showing wildcards.
                                            if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                                wpwMsg.triple_nobg(NameGreeting,serviceOffer, globalwpw.wildcards);
                                            }else{
                                                wpwMsg.double(NameGreeting,serviceOffer);
                                            }
                                            
                                            
                                            globalwpw.ai_step=1;
                                            globalwpw.wildCard=0;
                                            localStorage.setItem("wildCard",  globalwpw.wildCard);
                                            localStorage.setItem("aiStep", globalwpw.ai_step);
                                            
                                        }

                                    }else{
                                        $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                                        localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                                        globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                                        globalwpw.ai_step=1;
                                        globalwpw.wildCard=0;
                                        localStorage.setItem("wildCard",  globalwpw.wildCard);
                                        localStorage.setItem("aiStep", globalwpw.ai_step);
                                        var NameGreeting=globalwpw.settings.obj.shopper_call_you+' '+globalwpw.settings.obj.shopper_demo_name;
                                        if(globalwpw.settings.obj.ask_email_wp_greetings==1){
                                            var emailsharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_emailaddress);
                                            if(globalwpw.settings.obj.enable_gdpr){
                                                wpwMsg.triple(NameGreeting, emailsharetext, globalwpw.settings.obj.gdpr_text);
                                            }else{
                                                wpwMsg.double(NameGreeting, emailsharetext);
                                            }
                                            
                                        }else if(globalwpw.settings.obj.ask_phone_wp_greetings==1){
                                            var phonesharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_phone_gt);
                                            if(globalwpw.settings.obj.enable_gdpr){
                                                wpwMsg.triple_nobg(NameGreeting, phonesharetext, globalwpw.settings.obj.gdpr_text);
                                            }else{
                                                wpwMsg.double(NameGreeting, phonesharetext);
                                            }
                                        }else{
                                            //this data should be conditional
                                            var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                                            //After completing two steps messaging showing wildcards.
                                            if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                                wpwMsg.triple_nobg(NameGreeting,serviceOffer, globalwpw.wildcards);
                                            }else{
                                                wpwMsg.double(NameGreeting,serviceOffer);
                                            }

                                            
                                            globalwpw.ai_step=1;
                                            globalwpw.wildCard=0;
                                            localStorage.setItem("wildCard",  globalwpw.wildCard);
                                            localStorage.setItem("aiStep", globalwpw.ai_step);
                                            
                                        }


                                    }
									
									
								}else{

                                    if(wpwKits.getFulfillmentSpeech(response)!=''){
                                        var secondMsg=wpwKits.randomMsg(globalwpw.settings.obj.asking_name);
										wpwMsg.double(wpwKits.getFulfillmentSpeech(response),secondMsg);
                                    }else{

                                        var filterMsg=wpwKits.filterStopWords(msg);
                                        if(filterMsg!=''){
                                            $.cookie("shopper", filterMsg, { expires : 365 });
                                            localStorage.setItem('shopper',filterMsg);
                                            globalwpw.hasNameCookie=filterMsg;
    
                                            var NameGreeting=wpwKits.randomMsg(globalwpw.settings.obj.i_am) +" <strong>"+globalwpw.settings.obj.agent+"</strong>! "+wpwKits.randomMsg(globalwpw.settings.obj.name_greeting);
                                            if(globalwpw.settings.obj.ask_email_wp_greetings==1){
                                                var emailsharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_emailaddress);
                                                if(globalwpw.settings.obj.enable_gdpr){
                                                    wpwMsg.triple(NameGreeting, emailsharetext, globalwpw.settings.obj.gdpr_text);
                                                }else{
                                                    wpwMsg.double(NameGreeting, emailsharetext);
                                                }
                                                
                                            }else if(globalwpw.settings.obj.ask_phone_wp_greetings==1){
                                                var phonesharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_phone_gt);
                                                if(globalwpw.settings.obj.enable_gdpr){
                                                    wpwMsg.triple_nobg(NameGreeting, phonesharetext, globalwpw.settings.obj.gdpr_text);
                                                }else{
                                                    wpwMsg.double(NameGreeting, phonesharetext);
                                                }
                                            }else{
                                                
                                                //this data should be conditional
                                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                                                //After completing two steps messaging showing wildcards.
                                                if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                                    wpwMsg.triple_nobg(NameGreeting,serviceOffer, globalwpw.wildcards);
                                                }else{
                                                    wpwMsg.double(NameGreeting,serviceOffer);
                                                }
                                                
                                                globalwpw.ai_step=1;
                                                globalwpw.wildCard=0;
                                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                                localStorage.setItem("aiStep", globalwpw.ai_step);
                                                
                                            }
                                        }else{
    
                                            $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                                            localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                                            globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                                            globalwpw.ai_step=1;
                                            globalwpw.wildCard=0;
                                            localStorage.setItem("wildCard",  globalwpw.wildCard);
                                            localStorage.setItem("aiStep", globalwpw.ai_step);
                                            var NameGreeting=globalwpw.settings.obj.shopper_call_you+' '+globalwpw.settings.obj.shopper_demo_name;
                                            if(globalwpw.settings.obj.ask_email_wp_greetings==1){
                                                var emailsharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_emailaddress);
                                                if(globalwpw.settings.obj.enable_gdpr){
                                                    wpwMsg.triple(NameGreeting, emailsharetext, globalwpw.settings.obj.gdpr_text);
                                                }else{
                                                    wpwMsg.double(NameGreeting, emailsharetext);
                                                }
                                                
                                            }else if(globalwpw.settings.obj.ask_phone_wp_greetings==1){
                                                var phonesharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_phone_gt);
                                                if(globalwpw.settings.obj.enable_gdpr){
                                                    wpwMsg.triple_nobg(NameGreeting, phonesharetext, globalwpw.settings.obj.gdpr_text);
                                                }else{
                                                    wpwMsg.double(NameGreeting, phonesharetext);
                                                }
                                            }else{
                                                //this data should be conditional
                                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                                                //After completing two steps messaging showing wildcards.
                                                if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                                    wpwMsg.triple_nobg(NameGreeting,serviceOffer, globalwpw.wildcards);
                                                }else{
                                                    wpwMsg.double(NameGreeting,serviceOffer);
                                                }
                                                
                                                globalwpw.ai_step=1;
                                                globalwpw.wildCard=0;
                                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                                localStorage.setItem("aiStep", globalwpw.ai_step);
                                                
                                            }
                                        }

                                    }
                                    
                                   
								}
							}else{
                                //if bad request or limit cross then
                                //globalwpw.df_status_lock=0;
                                var dfDefaultMsg=globalwpw.settings.obj.df_defualt_reply;
                                wpwMsg.double_nobg(dfDefaultMsg,globalwpw.wildcards);
                            }
						})

                }
                //When returning shopper then greeting with name and wildcards.
                else if(localStorage.getItem('shopper')  && globalwpw.wildCard==0 && globalwpw.ai_step==0){
					if(globalwpw.settings.obj.ask_email_wp_greetings==1 && !localStorage.getItem('shopperemail')){
						var dfReturns=wpwKits.dailogAIOAction(msg);
						dfReturns.done(function( response ) {
                            if(globalwpw.settings.obj.df_api_version=='v2'){
                                response = $.parseJSON(response);
                            }
							if(wpwKits.responseIsOk(response)){
								var intent = wpwKits.getIntentName(response);
								if(intent=="get email"){
									var email = wpwKits.getParameters(response).email;
									$.cookie("shopperemail", email, { expires : 365 });
									localStorage.setItem('shopperemail',email);
									if(email!=''){
										var data = {'action':'qcld_wb_chatbot_email_subscription','name':localStorage.getItem('shopper'),'email':email, 'url':window.location.href};

										wpwKits.ajax(data).done(function (response) {
											//response.
										})
									}
									var emailgreetings = wpwKits.randomMsg(globalwpw.settings.obj.got_email);
									var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                                    //After completing two steps messaging showing wildcards.
                                    

                                    if(globalwpw.settings.obj.ask_phone_wp_greetings==1){
                                        var phonesharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_phone_gt);
                                        if(globalwpw.settings.obj.enable_gdpr){
                                            wpwMsg.triple_nobg(emailgreetings, phonesharetext, globalwpw.settings.obj.gdpr_text);
                                        }else{
                                            wpwMsg.double(emailgreetings, phonesharetext);
                                        }
                                    }else{
                                        if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                            wpwMsg.triple_nobg(emailgreetings,serviceOffer, globalwpw.wildcards);
                                        }else{
                                            wpwMsg.double(emailgreetings,serviceOffer);
                                        }
                                        
                                        
                                        globalwpw.ai_step=1;
                                        globalwpw.wildCard=0;
                                        localStorage.setItem("wildCard",  globalwpw.wildCard);
                                        localStorage.setItem("aiStep", globalwpw.ai_step);
                                    }

                                    
									
                                }
                                else{

                                    
                                    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                                    if( re.test(msg)!=true){
                                        //After asking service show the wildcards.
                                        var noemailtext = wpwKits.randomMsg(globalwpw.settings.obj.email_ignore);
                                        var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);                                        
                                        localStorage.setItem('shopperemail','no');
                                        if(globalwpw.settings.obj.ask_phone_wp_greetings==1){
                                            var phonesharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_phone_gt);
                                            if(globalwpw.settings.obj.enable_gdpr){
                                                wpwMsg.triple_nobg(noemailtext, phonesharetext, globalwpw.settings.obj.gdpr_text);
                                            }else{
                                                wpwMsg.double(noemailtext, phonesharetext);
                                            }
                                        }else{
                                            globalwpw.ai_step=1;
                                            globalwpw.wildCard=0;
                                            localStorage.setItem("wildCard",  globalwpw.wildCard);
                                            localStorage.setItem("aiStep", globalwpw.ai_step);
                                            

                                            if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                                wpwMsg.triple_nobg(noemailtext, serviceOffer, globalwpw.wildcards);
                                            }else{
                                                wpwMsg.double(noemailtext, serviceOffer);
                                            }
                                        }

                                        

                                    }else{

                                        var email = msg;
                                        $.cookie("shopperemail", email, { expires : 365 });
                                        localStorage.setItem('shopperemail',email);
                                        if(email!=''){
                                            var data = {'action':'qcld_wb_chatbot_email_subscription','name':localStorage.getItem('shopper'),'email':email, 'url':window.location.href};
    
                                            wpwKits.ajax(data).done(function (response) {
                                                //response.
                                            })
                                        }
                                        var emailgreetings = wpwKits.randomMsg(globalwpw.settings.obj.got_email);
                                        var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                                        //After completing two steps messaging showing wildcards.


                                        if(globalwpw.settings.obj.ask_phone_wp_greetings==1){
                                            var phonesharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_phone_gt);
                                            if(globalwpw.settings.obj.enable_gdpr){
                                                wpwMsg.triple_nobg(emailgreetings, phonesharetext, globalwpw.settings.obj.gdpr_text);
                                            }else{
                                                wpwMsg.double(emailgreetings, phonesharetext);
                                            }
                                        }else{
                                            if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                                wpwMsg.triple_nobg(emailgreetings, serviceOffer, globalwpw.wildcards);
                                            }else{
                                                wpwMsg.double(emailgreetings,serviceOffer);
                                            }
                                            
                                            globalwpw.ai_step=1;
                                            globalwpw.wildCard=0;
                                            localStorage.setItem("wildCard",  globalwpw.wildCard);
                                            localStorage.setItem("aiStep", globalwpw.ai_step);
                                        }

                                        

                                    }

									
								}
							}else{
                                //if bad request or limit cross then
                                globalwpw.df_status_lock=0;
                                var dfDefaultMsg=globalwpw.settings.obj.df_defualt_reply;
                                wpwMsg.double_nobg(dfDefaultMsg,globalwpw.wildcards);
                            }
						})
					}else if(globalwpw.settings.obj.ask_phone_wp_greetings==1 && !localStorage.getItem('shopperphone')){

                        var phonegreetings = wpwKits.randomMsg(globalwpw.settings.obj.got_phone);
                        var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                        var nophonetext = wpwKits.randomMsg(globalwpw.settings.obj.phone_ignore);

                        var data = {'action':'qcld_wb_chatbot_phone_validate','name':globalwpw.hasNameCookie,'phone':msg};
                        wpwKits.ajax(data).done(function (response) {
                            var json = $.parseJSON(response);
                            if(json.status=='success'){
                                localStorage.setItem('shopperphone', msg);
                                if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                    wpwMsg.triple_nobg(phonegreetings,serviceOffer, globalwpw.wildcards);
                                }else{
                                    wpwMsg.double(phonegreetings,serviceOffer);
                                }
                                globalwpw.ai_step=1;
                                globalwpw.wildCard=0;
                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                localStorage.setItem("aiStep", globalwpw.ai_step);

                                if(localStorage.getItem('shopperemail')){
                                    var email = localStorage.getItem('shopperemail');
                                }else{
                                    var email = '';
                                }
                                

                                var data = {'action':'qcld_wb_chatbot_email_subscription','name':localStorage.getItem('shopper'),'email':email, 'phone':msg, 'url':window.location.href};

                                wpwKits.ajax(data).done(function (response) {
                                    //response.
                                })


                            }else if(json.status=='invalid'){

                                if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                    wpwMsg.triple_nobg(nophonetext,serviceOffer, globalwpw.wildcards);
                                }else{
                                    wpwMsg.double(nophonetext,serviceOffer);
                                }
                                globalwpw.ai_step=1;
                                globalwpw.wildCard=0;
                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                localStorage.setItem("aiStep", globalwpw.ai_step);

                            }
                        })

                    }else{
						//After asking service show the wildcards.
						var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
						globalwpw.ai_step=1;
						globalwpw.wildCard=0;
						localStorage.setItem("wildCard",  globalwpw.wildCard);
						localStorage.setItem("aiStep", globalwpw.ai_step);
						wpwMsg.single(serviceOffer);
					}

                }
                //When user asking needs then DialogFlow will given intent after NLP steps.
                else if(globalwpw.ai_step==1){
                    
                    //first do site search


                    var dfReturns=wpwKits.dailogAIOAction(msg);
                    dfReturns.done(function( response ) {

                        if(globalwpw.settings.obj.df_api_version=='v2'){
                            
                            response = $.parseJSON(response);

                        }

                        if(wpwKits.responseIsOk(response)){
                            var userIntent=wpwKits.getIntentName(response);


                            if(userIntent=='start'){
								
                                globalwpw.wildCard=0;
                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
								
                            }else if(userIntent=='welcome'){
								
                                var messages = wpwKits.getFulfillmentText(response);
                                
								wpwTree.df_reply(response);
								
							}else if(userIntent=='help'){
								
                                $(globalwpw.settings.messageWrapper).html(localStorage.getItem("wpwHitory"));
                                
								//Showing help message
                                setTimeout(function () {
                                    wpwKits.scrollTo();
                                    var helpWelcome = wpwKits.randomMsg(globalwpw.settings.obj.help_welcome);
                                    var helpMsg = wpwKits.randomMsg(globalwpw.settings.obj.help_msg);
                                    wpwMsg.double(helpWelcome,helpMsg);
                                    //dialogflow
                                    if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
                                        globalwpw.wildCard=0;
                                        globalwpw.ai_step=1;
                                        localStorage.setItem("wildCard",  globalwpw.wildCard);
                                        localStorage.setItem("aiStep", globalwpw.ai_step);
                                    }
                                },globalwpw.settings.preLoadingTime);
								
                            }else if(userIntent=='reset'){
                                var restWarning=globalwpw.settings.obj.reset;
                                var confirmBtn='<span class="qcld-chatbot-reset-btn" reset-data="yes" >'+globalwpw.settings.obj.yes+'</span> <span> '+globalwpw.settings.obj.or+' </span><span class="qcld-chatbot-reset-btn"  reset-data="no">'+globalwpw.settings.obj.no+'</span>';
                                wpwMsg.double_nobg(restWarning,confirmBtn);
                            }else if(userIntent=='phone'){
								
                                if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
									var shopperName=  globalwpw.settings.obj.shopper_demo_name;
								}else{
									var shopperName=globalwpw.hasNameCookie;
								}
								var askEmail=globalwpw.settings.obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(globalwpw.settings.obj.asking_phone);
								wpwMsg.single(askEmail);
								//Now updating the support part as .
								globalwpw.supportStep='phone';
								globalwpw.wildCard=1;
								//keeping value in localstorage
								localStorage.setItem("wildCard",  globalwpw.wildCard);
								localStorage.setItem("supportStep",  globalwpw.supportStep);

                            }else if(userIntent=='email'){
								
                                if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
									var shopperName=  globalwpw.settings.obj.shopper_demo_name;
								}else{
									var shopperName=globalwpw.hasNameCookie;
								}
								var askEmail=globalwpw.settings.obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(globalwpw.settings.obj.asking_email);
								wpwMsg.single(askEmail);
								//Now updating the support part as .
								globalwpw.supportStep='email';
								globalwpw.wildCard=1;
								//keeping value in localstorage
								localStorage.setItem("wildCard",  globalwpw.wildCard);
								localStorage.setItem("supportStep",  globalwpw.supportStep);

                            }else if(userIntent=='site search'){
								
								var parameters = wpwKits.getParameters(response);
								
								
								if(typeof parameters.products !=='undefined' && parameters.products!=''){
									
									var searchQuery= parameters.products;
									globalwpw.wildCard=1;
									globalwpw.productStep='search';
									wpwAction.bot(searchQuery);
									//keeping value in localstorage
									localStorage.setItem("wildCard",  globalwpw.wildCard);
									localStorage.setItem("productStep", globalwpw.productStep);
									
								}else{
									
									if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
										var shopperName=  globalwpw.settings.obj.shopper_demo_name;
									}else{
										var shopperName=globalwpw.hasNameCookie;
									}
									var askEmail=globalwpw.settings.obj.hello+' '+shopperName+'! '+ 'Pleae enter your keyword for searching';
									wpwMsg.single(askEmail);
									//Now updating the support part as .
									globalwpw.supportStep='search';
									globalwpw.wildCard=1;
									//keeping value in localstorage
									localStorage.setItem("wildCard",  globalwpw.wildCard);
									localStorage.setItem("supportStep",  globalwpw.supportStep);
									
								}
								

                            }else if(userIntent=='get name'){
								
								var given_name = wpwKits.getParameters(response).given_name;
								var last_name = wpwKits.getParameters(response).last_name;
								var fullname = given_name+' '+last_name;
								
								$.cookie("shopper", fullname, { expires : 365 });
								localStorage.setItem('shopper',fullname);
								globalwpw.hasNameCookie=fullname;
								//Greeting with name and suggesting the wildcard.
								var NameGreeting=wpwKits.randomMsg(globalwpw.settings.obj.i_am) +" <strong>"+globalwpw.settings.obj.agent+"</strong>! "+wpwKits.randomMsg(globalwpw.settings.obj.name_greeting);
								var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
								//After completing two steps messaging showing wildcards.
								wpwMsg.double(NameGreeting,serviceOffer);
								globalwpw.ai_step=1;
								globalwpw.wildCard=0;
								localStorage.setItem("wildCard",  globalwpw.wildCard);
								localStorage.setItem("aiStep", globalwpw.ai_step);
								
							}
							else if(userIntent=='faq'){
								
                                globalwpw.wildCard=1;
                                globalwpw.supportStep='welcome';
                                wpwAction.bot('from wildcard support');
                                //keeping value in localstorage

                            }else if(userIntent=='email subscription'){
								
                                globalwpw.wildCard=3;
								globalwpw.subscriptionStep='welcome';
								wpwTree.subscription(msg);

                            }else if(userIntent=='product' && globalwpw.settings.obj.disable_product_search!=1){
								var parameters = wpwKits.getParameters(response);
								
								if(typeof parameters.products !=='undefined' && parameters.products!=''){
									var searchQuery= parameters.products;
									globalwpw.wildCard=20;
									globalwpw.productStep='search';
									wpwAction.bot(searchQuery);
									//keeping value in localstorage
									localStorage.setItem("wildCard",  globalwpw.wildCard);
									localStorage.setItem("productStep", globalwpw.productStep);
								}else{
									var searchQuery= wpwKits.queryText(response);
									globalwpw.wildCard=20;
									globalwpw.productStep='asking'
									wpwAction.bot(searchQuery);
									//keeping value in localstorage
									localStorage.setItem("wildCard",  globalwpw.wildCard);
									localStorage.setItem("productStep", globalwpw.productStep);
								}
								
                                
                            }
                            else if(userIntent=='catalog' && globalwpw.settings.obj.disable_catalog!=1){
                                wpwAction.bot(globalwpw.settings.obj.sys_key_catalog.toLowerCase());
                            }else if(userIntent=='featured' && globalwpw.settings.obj.disable_featured_product!=1){
                                globalwpw.wildCard=20;
                                globalwpw.productStep='featured'
                                wpwAction.bot('from wildcard product');
                                //keeping value in localstorage
                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                localStorage.setItem("productStep", globalwpw.productStep);
                            }else  if(userIntent=='sale' && globalwpw.settings.obj.disable_sale_product!=1){
                                globalwpw.wildCard=20;
                                globalwpw.productStep='sale'
                                wpwAction.bot('from wildcard product');
                                //keeping value in localstorage
                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                localStorage.setItem("productStep", globalwpw.productStep);
                            }else if(userIntent=='order' && globalwpw.settings.obj.disable_order_status!=1){
                                globalwoow.wildCard=21;
                                globalwoow.orderStep='welcome';
                                woowAction.bot('from wildcard order');
                                //keeping value in localstorage
                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                localStorage.setItem("orderStep", globalwpw.orderStep);
                            }else if(userIntent=='Default Fallback Intent'){
								
								
								if(msg!='' && globalwpw.settings.obj.disable_sitesearch==''){
									var data = {'action':'wpbo_search_site','name':globalwpw.hasNameCookie,'keyword':msg};
									wpwKits.ajax(data).done(function (res) {
										var json=$.parseJSON(res);
										if(json.status=='success'){
                                            $('span[data-wildcart="back"]').remove();
                                            wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                                            
										}else{
                                            
                                            msg = wpwKits.filterStopWords(msg);
                                            var data = {'action':'wpbo_search_site','name':globalwpw.hasNameCookie,'keyword':msg};
									        wpwKits.ajax(data).done(function (res) {
                                                var json=$.parseJSON(res);
                                                if(json.status=='success'){
                                                    $('span[data-wildcart="back"]').remove();
                                                    wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                                                }else{
                                                    if(globalwpw.counter == globalwpw.settings.obj.no_result_attempt_count || globalwpw.settings.obj.no_result_attempt_count == 0 ){
												
                                                        wpwMsg.single(json.html);
                                                        if(globalwpw.settings.obj.disable_repeatative!=1){
                                                            setTimeout(function(){
                                                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                                                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                                                            },globalwpw.settings.preLoadingTime)
                                                        }
                                                        globalwpw.counter = 0;
                                                        
                                                    }else{
                                                        globalwpw.counter++;
                                                        wpwTree.df_reply(response);
                                                    }
                                                }
                                                

                                            })

										}
										globalwpw.wildCard=0;
									});
								}else{
									if(globalwpw.counter == globalwpw.settings.obj.no_result_attempt_count || globalwpw.settings.obj.no_result_attempt_count == 0 ){
										
                                        wpwTree.df_reply(response);
                                        if(globalwpw.settings.obj.disable_repeatative!=1){
                                            setTimeout(function(){
                                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                                            },globalwpw.settings.preLoadingTime)
                                        }
										globalwpw.counter = 0;
										
									}else{
										globalwpw.counter++;
										wpwTree.df_reply(response);
									}
								}
								
							}else if(wpwKits.getScore(response)!=0){ // checking is reponsing from dialogflow.
                                
                                
								var sTalkAction=wpwKits.getAction(response);
								
								if(sTalkAction!='' && sTalkAction.indexOf('smalltalk') != -1 ){
									var sMgs=wpwKits.getFulfillmentText(response);
									wpwMsg.single(sMgs);
								}else{
                                   
									var messages = wpwKits.getFulfillmentText(response);
									
									
									wpwTree.df_reply(response);

									var emailSent = false;
									var emailIntent = '';
									$.each(globalwpw.settings.obj.custom_intent, function( index, value ) {
									  
									  if(userIntent.indexOf(value) > -1 ){
										  emailIntent = value;
									  }
									  
									});
									
									if(emailIntent != '' && globalwpw.settings.obj.custom_intent_email[globalwpw.settings.obj.custom_intent.indexOf(emailIntent)]=='1'){
										emailSent = true;
									}
									
									if(emailSent==true){
										globalwpw.emailContent.push({
											user: wpwKits.queryText(response),
											bot: wpwTree.df_reply2(response)
										})
									}
									
									if(wpwKits.isActionComplete(response) && wpwKits.isConversationEnd(response) && emailSent==true){
                                        
                                        var email = '';
                                        if(localStorage.getItem('shopperemail')!==null){
                                            email = localStorage.getItem('shopperemail');
                                        }
										var data = {'action':'qcld_wb_chatbot_send_query','name':globalwpw.hasNameCookie, 'email': email,'data':globalwpw.emailContent};

										
										wpwKits.ajax(data).done(function (resdata) {
											
											var json=$.parseJSON(resdata);
											if(json.status=='success'){
												var sucMsg=json.message;
												
												setTimeout(function(){
													
													wpwMsg.single(sucMsg);
													globalwpw.wildCard=0;
													var orPhoneSuggest='';
													setTimeout(function(){
														if(globalwpw.settings.obj.call_sup!=1) {
															orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
														}
                                                        var orEmailSuggest='<span class="qcld-chatbot-suggest-email">'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                                                        if(globalwpw.settings.obj.disable_repeatative!=1){
                                                            wpwKits.suggestEmail(orPhoneSuggest+orEmailSuggest);
                                                        }
													},globalwpw.settings.wildcardsShowTime);
													
												},parseInt(globalwpw.settings.preLoadingTime));
												
											}else{
												
												var failMsg=json.message;
												setTimeout(function(){
													wpwMsg.single(failMsg);
													globalwpw.wildCard=0;
													var orPhoneSuggest='';
													setTimeout(function(){
														if(globalwpw.settings.obj.call_sup!=1) {
															orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
														}
                                                        var orEmailSuggest='<span class="qcld-chatbot-suggest-email">'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                                                        if(globalwpw.settings.obj.disable_repeatative!=1){
                                                            wpwKits.suggestEmail(orPhoneSuggest+orEmailSuggest);
                                                        }
													},globalwpw.settings.wildcardsShowTime);
													
												},parseInt(globalwpw.settings.preLoadingTime));
												
												
											}
											
										});	
										globalwpw.emailContent = [];
									}
									


									
								}
									
                                

                            }else{
								
                                var dfDefaultMsg=globalwpw.settings.obj.df_defualt_reply;
								wpwMsg.double_nobg(dfDefaultMsg,globalwpw.wildcards);
                            }
                        }else{
                            //if bad request or limit cross then
                            globalwpw.df_status_lock=0;
                            var dfDefaultMsg=globalwpw.settings.obj.df_defualt_reply;
                            wpwMsg.double_nobg(dfDefaultMsg,globalwpw.wildcards);
                        }
                    }).fail(function (error) {
						
                        var dfDefaultMsg=globalwpw.settings.obj.df_defualt_reply;
                        wpwMsg.double_nobg(dfDefaultMsg,globalwpw.wildcards);
                    });

                }
            }else{
				
                //When intialize 1 and don't have cookies then keep  the name of shooper in in cookie
                if(globalwpw.initialize==1 && !localStorage.getItem('shopper')  && globalwpw.wildCard==0){
                    msg=wpwKits.toTitlecase(wpwKits.filterStopWords(msg));
                    $.cookie("shopper", msg, { expires : 365 });
                    localStorage.setItem('shopper',msg);
                    globalwpw.hasNameCookie=msg;
                    //Greeting with name and suggesting the wildcard.
                    var NameGreeting=wpwKits.randomMsg(globalwpw.settings.obj.i_am) +" <strong>"+globalwpw.settings.obj.agent+"</strong>! "+wpwKits.randomMsg(globalwpw.settings.obj.name_greeting);
                    var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
					
                    //After completing two steps messaging showing wildcards.
                    if(globalwpw.settings.obj.ask_email_wp_greetings==1){
                        localStorage.setItem('default_asking_email',1);
                        var emailsharetext = wpwKits.randomMsg(globalwpw.settings.obj.asking_emailaddress);
                        if(globalwpw.settings.obj.enable_gdpr){
                            wpwMsg.triple_nobg(NameGreeting, emailsharetext, globalwpw.settings.obj.gdpr_text);
                        }else{
                            wpwMsg.double(NameGreeting, emailsharetext);
                        }
                        
                    }else{
                        
                        wpwMsg.double(NameGreeting,serviceOffer);
                        
                    }

					
                }
                //When returning shopper then greeting with name and wildcards.
                else if(localStorage.getItem('shopper')  && globalwpw.wildCard==0){

                    if(globalwpw.settings.obj.ask_email_wp_greetings==1){

                        var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                        if( re.test(msg)!=true){
                            //After asking service show the wildcards.
                            var noemailtext = wpwKits.randomMsg(globalwpw.settings.obj.email_ignore);;
                            var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);                            
                            globalwpw.wildCard=0;
                            localStorage.setItem("wildCard",  globalwpw.wildCard);
                            if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                wpwMsg.triple_nobg(noemailtext, serviceOffer, globalwpw.wildcards);
                            }else{
                                wpwMsg.double(noemailtext, serviceOffer);
                            }

                        }else{

                            var email = msg;
                            $.cookie("shopperemail", email, { expires : 365 });
                            localStorage.setItem('shopperemail',email);
                            if(email!=''){
                                var data = {'action':'qcld_wb_chatbot_email_subscription','name':localStorage.getItem('shopper'),'email':email, 'url':window.location.href};

                                wpwKits.ajax(data).done(function (response) {
                                    //response.
                                })
                            }
                            var emailgreetings = wpwKits.randomMsg(globalwpw.settings.obj.got_email);
                            var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                            //After completing two steps messaging showing wildcards.
                            if(globalwpw.settings.obj.show_menu_after_greetings==1){
                                wpwMsg.triple_nobg(emailgreetings, serviceOffer, globalwpw.wildcards);
                            }else{
                                wpwMsg.double(emailgreetings,serviceOffer);
                            }
                            
                            globalwpw.wildCard=0;
                            localStorage.setItem("wildCard",  globalwpw.wildCard);

                        }
                        localStorage.removeItem('default_asking_email');
                    }else{
                        //After asking service show the wildcards.
                        var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                        wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                    }
					
                   
                }
            }
        },
        df_multi_handle:function(array){
            if(array.length>0){
                setTimeout(function(){
                    wpwMsg.single(array[0]);
                    array.splice(0, 1);
                    setTimeout(function(){
                        wpwTree.df_multi_handle(array);
                    }, globalwpw.settings.preLoadingTime)
                    
                }, globalwpw.settings.preLoadingTime)
            }
        },
		df_reply:function(response){
			

			//checking for facebook platform
			var i = 0;
            var html = '';
            var responses = [];

            if(globalwpw.settings.obj.df_api_version=='v1'){
                var messages = response.result.fulfillment.messages;
                var action = response.result.actionIncomplete;
                jQuery.each( messages, function( key, message ) {
                    html = '';
                    i +=1;
                    if(message.type==2){
                        
                        html += "<p>" + message.title + "</p>";
                        var index = 0;
                        for (index; index<message.replies.length; index++) {
                            html += "<span class=\"wpb-quick-reply qcld-chat-common\">"+ message.replies[index] +"</span>";
                        }
                        
                        
                    }
                    //check for default reply
                    else if(message.type==0 && message.speech!=''){
                        
                        html += message.speech;
                        
                    }else if(message.type==1){
                        
                        html +='<div class="wpbot_card_wraper">';
                            html+='<div class="wpbot_card_image">';
                                if(message.imageUrl!=''){
                                    html+='<img src="'+message.imageUrl+'" />';								
                                }
                                html+='<div class="wpbot_card_caption">';
                                if(message.title!=''){
                                    html+='<h2>'+message.title+'</h2>';
                                }
                                if(message.subtitle!=''){
                                    html+='<p>'+message.subtitle+'</p>';
                                }
                                html+='</div>';
                            html+='</div>';
                            if(typeof message.buttons !== 'undefined'){
                                if(message.buttons.length>0){
                                    jQuery.each( message.buttons, function( k, btn ) {
                                        html+='<a href="'+btn.postback+'" target="_blank"><i class="fa fa-external-link"></i> '+btn.text+'</a>';
                                    })
                                }
                            }
                            
                        html +='</div>';
                        
                    }else if(message.type=='simple_response'){
                        html += message.textToSpeech;
                    }

                    if(html!=''){
                        responses.push(html);
                    }
                    /*
                    if(i==messages.length){
                        wpwMsg.single(html);    
                        //For back to start button              
                    if(action===false && !html.includes("?") && !html.includes("wpb-quick-reply")){
                            setTimeout(function(){
                                //wpwMsg.single('<span class="qcld-chatbot-wildcard"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                            }, globalwpw.settings.preLoadingTime*2)
                        }
                        
                    }
                    */
                })
            }else{
                var messages = response.queryResult.fulfillmentMessages;
                var actioncomplete = response.queryResult.allRequiredParamsPresent;

                jQuery.each( messages, function( key, message ) {
                    html = '';
                    i +=1;
                    //handeling quickreplies
                    if(typeof message.quickReplies !=="undefined"){
                        if(typeof message.quickReplies.title !=="undefined"){
                            html += "<p>" + message.quickReplies.title + "</p>";
                        }
                        if(typeof message.quickReplies.quickReplies !=="undefined" ){

                            var index = 0;
                            for (index; index<message.quickReplies.quickReplies.length; index++) {
                                html += "<span class=\"wpb-quick-reply qcld-chat-common\">"+ message.quickReplies.quickReplies[index] +"</span>";
                            }

                        }

                    }
                    //handleing default response
                    else if(typeof message.text !=="undefined"){
                        if(typeof message.text.text !=="undefined" && message.text.text.length>0){
                            html += message.text.text[0];
                        }
                    }
                    else if(typeof message.card !=="undefined"){

                        html +='<div class="wpbot_card_wraper">';
                            html+='<div class="wpbot_card_image">';
                                if(message.card.imageUri !=="undefined" && message.card.imageUri!=''){
                                    html+='<img src="'+message.card.imageUri+'" />';								
                                }
                                html+='<div class="wpbot_card_caption">';
                                if(message.card.title !=="undefined" && message.card.title !=""){
                                    html+='<h2>'+message.card.title+'</h2>';
                                }
                                if(message.card.subtitle !=="undefined" && message.card.subtitle !=""){
                                    html+='<p>'+message.card.subtitle+'</p>';
                                }
                                html+='</div>';
                            html+='</div>';

                            if(typeof message.card.buttons !== 'undefined'){
                                if(message.card.buttons.length>0){
                                    jQuery.each( message.card.buttons, function( k, btn ) {
                                        html+='<a href="'+btn.postback+'" target="_blank"><i class="fa fa-external-link"></i> '+btn.text+'</a>';
                                    })
                                }
                            }
                            
                        html +='</div>';

                    }

                    if(html!=''){
                        responses.push(html);
                    }

                })

            }

            wpwTree.df_multi_handle(responses);
			
		},
		df_reply2:function(response){
            
            if(globalwpw.settings.obj.df_api_version=='v1'){
                var messages = response.result.fulfillment.messages;
                switch (messages[0].type) {
                    case 0: // text response
                        return messages[0].speech;
                        break;
                    case 1: // TODO card response
                        
                        break;
                    case 2: // quick replies
                    
                        
                        return messages[0].title;
                        
                        break;
                    case 3: // image response
                        
                        break;
                    case 3: // custom payload

                        break;
                    default:
                }
            }else{

                var messages = response.queryResult.fulfillmentMessages;
                if(typeof messages[0].text !=="undefined"){
                    if(typeof messages[0].text.text !=="undefined" && messages[0].text.text.length>0){
                        return messages[0].text.text[0];
                    }
                }else if(typeof messages[0].quickReplies !=="undefined"){
                    if(typeof messages[0].quickReplies.title !=="undefined"){
                        return messages[0].quickReplies.title;
                    }

                }
            }
			
		},

        product:function (msg) {
            if(globalwpw.wildCard==20 && globalwpw.productStep=='asking'){
                var askingProduct=wpwKits.randomMsg(globalwpw.settings.obj.product_asking);
                wpwMsg.single(askingProduct);
                globalwpw.productStep='search';
            } else if(globalwpw.wildCard==20 && globalwpw.productStep=='search'){
				msg = wpwKits.filterStopWords(msg);
				if(msg!=''){
					var data = {'action':'qcld_wb_chatbot_keyword', 'keyword':msg};
					//Products by string search ajax handler.
					wpwKits.ajax(data).done(function( response ) {
						if(response.product_num==0){
							var productFail=wpwKits.randomMsg(globalwpw.settings.obj.product_fail)+" <strong>"+msg+"</strong>!";
							//var productSuggest=wpwKits.randomMsg(globalwpw.settings.obj.product_suggest);
							wpwMsg.single(productFail);
							if(globalwpw.settings.obj.is_extended_search){
								setTimeout(function(){
									var data = {'action':'qcld_wb_chatbot_keyword_extended', 'keyword':msg};
									wpwKits.ajax(data).done(function( response ) {
										var json=$.parseJSON(response);
										if(json.status=='success'){
											wpwMsg.single2(json.html);
										}else{
											if(json.html!='' && json.html!==null){
												wpwMsg.single(json.html);
											}
											setTimeout(function(){
												wpwKits.sugestCat();
											},parseInt(globalwpw.settings.preLoadingTime*2.1));
										}
									})
								},parseInt(globalwpw.settings.preLoadingTime*2.1));
								
							}else{
								//Suggesting category.
								setTimeout(function(){
									wpwKits.sugestCat();
								},parseInt(globalwpw.settings.preLoadingTime*2.1));
							}								
							

						}else {
							
							var productSucces= wpwKits.randomMsg(globalwpw.settings.obj.product_success)+" <strong>"+msg+"</strong>!";
							wpwMsg.double_nobg(productSucces,response.html);
							if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
								
								globalwpw.wildCard=0;
								globalwpw.ai_step=1;
								localStorage.setItem("wildCard",  globalwpw.wildCard);
								localStorage.setItem("aiStep", globalwpw.ai_step);
								
									if(globalwpw.settings.obj.is_extended_search){
										setTimeout(function(){
											var data = {'action':'qcld_wb_chatbot_keyword_extended', 'keyword':msg};
											wpwKits.ajax(data).done(function( response ) {
												var json=$.parseJSON(response);
												if(json.status=='success'){
													
													wpwMsg.single2(json.html);
													
												}
											})
										},parseInt(globalwpw.settings.preLoadingTime*2.1));
									}
								
								
							}else{
								
								//Infinite asking to break dead end.
								if(globalwpw.settings.obj.is_extended_search){
									setTimeout(function(){
										var data = {'action':'qcld_wb_chatbot_keyword_extended', 'keyword':msg};
										wpwKits.ajax(data).done(function( response ) {
											var json=$.parseJSON(response);
											if(json.status=='success'){
												
												wpwMsg.single2(json.html);
												
											}else{
												wpwMsg.single(json.html);
												setTimeout(function(){
													wpwKits.sugestCat();
												},parseInt(globalwpw.settings.preLoadingTime*2.1));
											}
										})
									},parseInt(globalwpw.settings.preLoadingTime*2.1));
								}else{
									if(response.per_page >= response.product_num){
										setTimeout(function () {
											var searchAgain = wpwKits.randomMsg(globalwpw.settings.obj.product_infinite);
											wpwMsg.single(searchAgain);
											//keeping value in localstorage
											globalwpw.productStep='search';
											localStorage.setItem("productStep",  globalwpw.productStep);
										},globalwpw.settings.wildcardsShowTime);
									}
								}
								
							}
						}
						

					});
				}else{
					var askingProduct=wpwKits.randomMsg(globalwpw.settings.obj.product_asking);
					wpwMsg.single(askingProduct);
				}

            }else if(globalwpw.wildCard==20 && globalwpw.productStep=='category'){
                var msg=msg.split("#");
                var categoryTitle=msg[0];
                var categoryId=msg[1];
                var data = { 'action':'qcld_wb_chatbot_category_products','category':categoryId};
                //Product by category ajax handler.
                wpwKits.ajax(data).done(function (response) {
                    if(response.product_num==0){
                        //Since product does not found then show message and suggesting infinity search
                        var productFail = wpwKits.randomMsg(globalwpw.settings.obj.product_fail)+" <strong>"+categoryTitle+"</strong>!";
                        var searchAgain = wpwKits.randomMsg(globalwpw.settings.obj.product_infinite);
                        wpwMsg.double(productFail,searchAgain);
                        globalwpw.productStep='search';
                        //keeping value in localstorage
                        localStorage.setItem("productStep",  globalwpw.productStep);

                    } else{
                        //Now show chat message to choose the product.
                        var productSuccess = wpwKits.randomMsg(globalwpw.settings.obj.product_success)+" <strong>"+categoryTitle+"</strong>!";
                        var products=response.html;
                        wpwMsg.double_nobg(productSuccess,products);
                        //Infinite asking to break dead end.
                        if(response.per_page >= response.product_num){
                            setTimeout(function () {
                                var searchAgain = wpwKits.randomMsg(globalwpw.settings.obj.product_infinite);
                                wpwMsg.single(searchAgain);
                                globalwpw.productStep='search';
                                //keeping value in localstorage
                                localStorage.setItem("productStep",  globalwpw.productStep);
                            },globalwpw.settings.wildcardsShowTime);
                        }
                    }
                })
            }else if(globalwpw.wildCard==20 && globalwpw.productStep=='featured'){
                var data = {'action':'qcld_wb_chatbot_featured_products'};
                //Products by string search ajax handler.
                wpwKits.ajax(data).done(function( response ) {
                    if(response.product_num==0){
                        var productFail=wpwKits.randomMsg(globalwpw.settings.obj.product_fail)+" <strong>Featured Products</strong>!";
                        //var productSuggest=wpwKits.randomMsg(globalwpw.settings.obj.product_suggest);
                        wpwMsg.single(productFail);

                        //Suggesting category.
                        setTimeout(function(){
                            wpwKits.sugestCat();
                        },parseInt(globalwpw.settings.preLoadingTime*2.1));

                    }else {
                        var productSucces= wpwKits.randomMsg(globalwpw.settings.obj.product_success)+" <strong>Featured Products</strong>!";
                        wpwMsg.double_nobg(productSucces,response.html);
                        //Infinite asking to break dead end.
                        if(response.per_page >= response.product_num){
                            setTimeout(function () {
                                var searchAgain = wpwKits.randomMsg(globalwpw.settings.obj.product_infinite);
                                wpwMsg.single(searchAgain);
                                //For Dialogflow or else
                                if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
                                    globalwpw.wildCard=0;
                                    globalwpw.ai_step=1;
                                    localStorage.setItem("wildCard",  globalwpw.wildCard);
                                    localStorage.setItem("aiStep", globalwpw.ai_step);
                                }else{
                                    //keeping value in localstorage
                                    globalwpw.productStep='search';
                                    localStorage.setItem("wildCard",  globalwpw.wildCard);
                                    localStorage.setItem("productStep",  globalwpw.productStep);
                                }
                            },globalwpw.settings.wildcardsShowTime);
                        }else{
                            //For Dialogflow or else
                            if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
                                globalwpw.wildCard=0;
                                globalwpw.ai_step=1;
                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                localStorage.setItem("aiStep", globalwpw.ai_step);
                            }
                        }

                    }
                });

            }else if(globalwpw.wildCard==20 && globalwpw.productStep=='sale'){
                var data = {'action':'qcld_wb_chatbot_sale_products'};
                //Products by string search ajax handler.
                wpwKits.ajax(data).done(function( response ) {
                    if(response.product_num==0){
                        var productFail=wpwKits.randomMsg(globalwpw.settings.obj.product_fail)+'<strong>'+wpwKits.randomMsg(globalwpw.settings.obj.sale_products)+'</strong>!';
                        //var productSuggest=wpwKits.randomMsg(globalwpw.settings.obj.product_suggest);
                        wpwMsg.single(productFail);

                        //Suggesting category.
                        setTimeout(function(){
                            wpwKits.sugestCat();
                        },parseInt(globalwpw.settings.preLoadingTime*2.1));

                    }else {
                        var productSucces= wpwKits.randomMsg(globalwpw.settings.obj.product_success)+' <strong>'+wpwKits.randomMsg(globalwpw.settings.obj.sale_products)+'</strong>!';
                        wpwMsg.double_nobg(productSucces,response.html);
                        //Infinite asking to break dead end.
                        if(response.per_page >= response.product_num){
                            setTimeout(function () {
                                var searchAgain = wpwKits.randomMsg(globalwpw.settings.obj.product_infinite);
                                wpwMsg.single(searchAgain);
                                //For Dialogflow or else
                                if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
                                    globalwpw.wildCard=0;
                                    globalwpw.ai_step=1;
                                    localStorage.setItem("wildCard",  globalwpw.wildCard);
                                    localStorage.setItem("aiStep", globalwpw.ai_step);
                                }else{
                                    //keeping value in localstorage
                                    globalwpw.productStep='search';
                                    localStorage.setItem("productStep",  globalwpw.productStep);
                                }
                            },globalwpw.settings.wildcardsShowTime);
                        }else{
                            //For Dialogflow or else
                            if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
                                globalwpw.wildCard=0;
                                globalwpw.ai_step=1;
                                localStorage.setItem("wildCard",  globalwpw.wildCard);
                                localStorage.setItem("aiStep", globalwpw.ai_step);
                            }
                        }

                    }
                });
            }
        },

        order:function (msg) {
            //If user already logged In then
            if(globalwpw.settings.obj.order_login==1){
                var orderWelcome=globalwpw.settings.obj.order_welcome;
                var data = {'action': 'qcld_wb_chatbot_loged_in_user_orders'};
                //Orders for logged in user ajax handler.
                wpwKits.ajax(data).done(function (response) {
                    if(response.order_num>0){
                        var orderSucMsg=response.message;
                        var orderSucHtml=response.html;
                        wpwMsg.double(orderSucMsg,orderSucHtml);
                        //Calling the email to admin part
                        setTimeout(function(){
                            var orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                            var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.order_email_support)+'</span>';
                            wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                        },globalwpw.settings.wildcardsShowTime*2);
                    }else{
                        var orderFailMsg=response.message;
                        var orderFailHtml=response.html;
                        wpwMsg.double(orderFailMsg,orderFailHtml);
                        //Calling the email to admin part
                        setTimeout(function(){
                            var orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                            var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.order_email_support)+'</span>';
                            wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                        },globalwpw.settings.wildcardsShowTime);
                    }
                });
            }
            //If user is not logged In then
            else{

                if(globalwpw.settings.obj.order_status_without_login==1){

                    if( globalwpw.wildCard==21 && globalwpw.orderStep=='welcome'){

                        var orderWelcome=wpwKits.randomMsg(globalwpw.settings.obj.order_welcome);
                        var userNameAsking=wpwKits.randomMsg(globalwpw.settings.obj.order_email_asking);
                        
                        wpwMsg.double(orderWelcome,userNameAsking);
                        //updating the order steps
                        globalwpw.orderStep='orderid';
                        //keeping value in localstorage
                        localStorage.setItem("orderStep",  globalwpw.orderStep);
                    }else if(globalwpw.wildCard==21 && globalwpw.orderStep=='orderid'){
                        globalwpw.orderemail=msg;
                        var orderidasking=wpwKits.randomMsg(globalwpw.settings.obj.order_id_asking);
                        
                        wpwMsg.single(orderidasking);
                        //updating the order steps
                        globalwpw.orderStep='orderstatus';
                        //keeping value in localstorage
                        localStorage.setItem("orderStep",  globalwpw.orderStep);
                    }else if(globalwpw.wildCard==21 && globalwpw.orderStep=='orderstatus'){

                        var data = {'action': 'qcld_wb_chatbot_order_status_check','order_email': globalwpw.orderemail,'order_id': msg,'security': globalwpw.settings.obj.order_nonce};
                        //user loginajax handler.
                        wpwKits.ajax(data).done(function (response) {
                            if(response.status=='success') {
                                if (response.order_num > 0) {
                                    var loginSucMsg=response.message;
                                    var orderHtml=response.html;
                                    wpwMsg.double_nobg(loginSucMsg,orderHtml);
                                    //Now keep the user as login in by updating obj
                                    globalwpw.settings.obj.order_login=1;
                                    //Calling the email to admin part
                                    setTimeout(function(){
                                        var orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                                        var orEmailSuggest='<span class="qcld-chatbot-suggest-email">'+wpwKits.randomMsg(globalwpw.settings.obj.order_email_support)+'</span>';
                                        wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                                    },globalwpw.settings.wildcardsShowTime*2);
    
                                } else {
                                    var loginFailcMsg=response.message;
                                    var orderNoHtml=response.html;
                                    wpwMsg.double(loginFailcMsg,orderNoHtml);
                                    //Now keep the user as login in by updating obj
                                    globalwpw.settings.obj.order_login=1;
                                    //Calling the email to admin part
                                    setTimeout(function(){
                                        var orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                                        var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.order_email_support)+'</span>';
                                        wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                                    },globalwpw.settings.wildcardsShowTime);
                                }
                            }
                        });

                    }

                }else{
                    if( globalwpw.wildCard==21 && globalwpw.orderStep=='welcome'){
                        var orderWelcome=wpwKits.randomMsg(globalwpw.settings.obj.order_welcome);
                        var userNameAsking=wpwKits.randomMsg(globalwpw.settings.obj.order_username_asking);
                        
                        wpwMsg.double(orderWelcome,userNameAsking);
                        //updating the order steps
                        globalwpw.orderStep='user';
                        //keeping value in localstorage
                        localStorage.setItem("orderStep",  globalwpw.orderStep);
    
                    } else if( globalwpw.wildCard==21 && globalwpw.orderStep=='user'){
                        globalwpw.shopperUserName=msg;
                        var data = {'action': 'qcld_wb_chatbot_check_user', 'user_name': globalwpw.shopperUserName };
                        //Username checking ajax handler.
                        wpwKits.ajax(data).done(function (response) {
                            if(response.status=='success'){
                                var successMgs=response.message;
                                var sucessHtml=response.html;
                                wpwMsg.double(successMgs,sucessHtml);
                                globalwpw.orderStep='password';
                                //keeping value in localstorage
                                localStorage.setItem("orderStep",  globalwpw.orderStep);
    
                            } else{
                                var failMsg=response.message;
                                wpwMsg.single(failMsg);
                                globalwpw.orderStep='user';
                                //keeping value in localstorage
                                localStorage.setItem("orderStep",  globalwpw.orderStep);
                            }
                        });
                    }else if( globalwpw.wildCard==21 && globalwpw.orderStep=='password'){
                        var data = {'action': 'qcld_wb_chatbot_login_user','user_name': globalwpw.shopperUserName,'user_pass': msg,'security': globalwpw.settings.obj.order_nonce};
                        //user loginajax handler.
                        wpwKits.ajax(data).done(function (response) {
                            if(response.status=='success') {
                                if (response.order_num > 0) {
                                    var loginSucMsg=response.message;
                                    var orderHtml=response.html;
                                    wpwMsg.double_nobg(loginSucMsg,orderHtml);
                                    //Now keep the user as login in by updating obj
                                    globalwpw.settings.obj.order_login=1;
                                    //Calling the email to admin part
                                    setTimeout(function(){
                                        var orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                                        var orEmailSuggest='<span class="qcld-chatbot-suggest-email">'+wpwKits.randomMsg(globalwpw.settings.obj.order_email_support)+'</span>';
                                        wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                                    },globalwpw.settings.wildcardsShowTime);
    
                                } else {
                                    var loginFailcMsg=response.message;
                                    var orderNoHtml=response.html;
                                    wpwMsg.double(loginFailcMsg,orderNoHtml);
                                    //Now keep the user as login in by updating obj
                                    globalwpw.settings.obj.order_login=1;
                                    //Calling the email to admin part
                                    setTimeout(function(){
                                        var orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                                        var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.order_email_support)+'</span>';
                                        wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                                    },globalwpw.settings.wildcardsShowTime);
                                }
                            }else{
                                var loginFail= response.message;
                                wpwMsg.single(loginFail);
                                globalwpw.orderStep=='password';
                                //keeping value in localstorage
                                localStorage.setItem("orderStep",  globalwpw.orderStep);
                            }
                        });
                    }
                }

                
            }
        },
        unsubscription:function(msg){
            if(globalwpw.wildCard==6 && globalwpw.unsubscriptionStep=='welcome'){

                var restWarning=wpwKits.randomMsg(globalwpw.settings.obj.do_you_want_to_unsubscribe);
                var confirmBtn='<span class="qcld-chat-common qcld_unsubscribe_confirm" unsubscription="yes" >'+globalwpw.settings.obj.yes+'</span> <span> '+globalwpw.settings.obj.or+' </span><span class="qcld-chat-common qcld_unsubscribe_confirm"  unsubscription="no">'+globalwpw.settings.obj.no+'</span>';
                wpwMsg.double_nobg(restWarning,confirmBtn);

            }else if(globalwpw.wildCard==6 && globalwpw.unsubscriptionStep=='getemail'){

                if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
					var shopperName=  globalwpw.settings.obj.shopper_demo_name;
				}else{
					var shopperName=globalwpw.hasNameCookie;
				}
				
				var askEmail=globalwpw.settings.obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(globalwpw.settings.obj.asking_email);
				wpwMsg.single(askEmail);
				globalwpw.unsubscriptionStep = 'collectemailunsubscribe';

            }else if(globalwpw.wildCard==6 && globalwpw.unsubscriptionStep=='collectemailunsubscribe'){

                var validate = "";
                var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                if( re.test(msg)!=true){
                    validate = validate+wpwKits.randomMsg(globalwpw.settings.obj.invalid_email) ;
                }

                if(validate == ""){

                    var data = {'action':'qcld_wb_chatbot_email_unsubscription','email':msg};
                    wpwKits.ajax(data).done(function (response) {
                        var json=$.parseJSON(response);
                        if(json.status=='success'){
                            wpwMsg.single(wpwKits.randomMsg(globalwpw.settings.obj.you_have_successfully_unsubscribe));
                            setTimeout(function(){
                                var orPhoneSuggest = '';
								if(globalwpw.settings.obj.call_sup=="") {
									orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
								}
                                var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                                if(globalwpw.settings.obj.disable_repeatative!=1){
                                    wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                                }
								globalwpw.wildCard=0;
							},globalwpw.settings.preLoadingTime);
                        }else{
                            var restWarning=wpwKits.randomMsg(globalwpw.settings.obj.we_do_not_have_your_email);
                            var confirmBtn='<span class="qcld-chat-common qcld_unsubscribe_again" >Try again?</span>';
                            wpwMsg.double_nobg(restWarning,confirmBtn);
                        }
                    })
                    //wpwMsg.single('Collected valid email and trying to unsubscribe');

                }else{
                    globalwpw.unsubscriptionStep = 'collectemailunsubscribe';
                    wpwMsg.single(validate);
                }


            }
        },

		subscription:function(msg){
			
			if(globalwpw.subscriptionStep=='welcome'){
				var restWarning=wpwKits.randomMsg(globalwpw.settings.obj.do_you_want_to_subscribe);
                var confirmBtn='<span class="qcld-chat-common qcld_subscribe_confirm" subscription="yes" >'+globalwpw.settings.obj.yes+'</span> <span> '+globalwpw.settings.obj.or+' </span><span class="qcld-chat-common qcld_subscribe_confirm"  subscription="no">'+globalwpw.settings.obj.no+'</span>';
                if(globalwpw.settings.obj.enable_gdpr){
                    wpwMsg.triple_nobg(restWarning, globalwpw.settings.obj.gdpr_text, confirmBtn);
                }else{
                    wpwMsg.double_nobg(restWarning,confirmBtn);
                }


				
			}
			else if(globalwpw.subscriptionStep=='getname'){

				if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
					var shopperName=  globalwpw.settings.obj.shopper_demo_name;
				}else{
					var shopperName=globalwpw.hasNameCookie;
				}
				
				var askEmail=globalwpw.settings.obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(globalwpw.settings.obj.asking_email);
				wpwMsg.single(askEmail);
				globalwpw.subscriptionStep = 'getemail';
				
			}
			else if(globalwpw.subscriptionStep=='getemail'){
				
				globalwpw.shopperEmail=msg;
                var validate = "";
                var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                if( re.test(globalwpw.shopperEmail)!=true){
                    validate = validate+wpwKits.randomMsg(globalwpw.settings.obj.invalid_email) ;
                }
                if(validate == ""){
                    if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
						var shopperName=  globalwpw.settings.obj.shopper_demo_name;
					}else{
						var shopperName=globalwpw.hasNameCookie;
					}
					
					var data = {'action':'qcld_wb_chatbot_email_subscription','name':shopperName,'email':globalwpw.shopperEmail, 'url':window.location.href};

					wpwKits.ajax(data).done(function (response) {
						var json=$.parseJSON(response);
						
						if(json.status=='success'){
							var sucMsg=json.msg;
							wpwMsg.single(sucMsg);

							setTimeout(function(){
                                var orPhoneSuggest = '';
								if(globalwpw.settings.obj.call_sup=="") {
									orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
								}
                                var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                                if(globalwpw.settings.obj.disable_repeatative!=1){
                                    wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                                }
								globalwpw.wildCard=0;
							},globalwpw.settings.preLoadingTime);
						}else{
							var failMsg=json.msg;
							wpwMsg.single(failMsg);
							setTimeout(function(){
								wpwAction.bot(globalwpw.settings.obj.sys_key_help.toLowerCase());
							},globalwpw.settings.preLoadingTime)
							
						}
					});
					

                }else{
					globalwpw.subscriptionStep = 'getemail';
                    wpwMsg.single(validate);
                    
                }
				
			}
		},
        support:function (msg) {
            if(globalwpw.wildCard==1 && globalwpw.supportStep=='welcome'){
                var welcomeMsg= wpwKits.randomMsg(globalwpw.settings.obj.support_welcome);

                
                var orPhoneSuggest = '';
                if(globalwpw.settings.obj.support_query.length>0){
                    var supportsItems = '';
                    var messenger = '';
                    if(globalwpw.settings.obj.enable_messenger==1) {
                        messenger += '<span class="qcld-chatbot-wildcard"  data-wildcart="messenger">'+wpwKits.randomMsg(globalwpw.settings.obj.messenger_label)+'</span>';
                    }
                    if(globalwpw.settings.obj.enable_whats==1) {
                        messenger += '<span class="qcld-chatbot-wildcard"  data-wildcart="whatsapp">'+wpwKits.randomMsg(globalwpw.settings.obj.whats_label)+'</span>';
                    }
                    if(globalwpw.settings.obj.disable_feedback=='') {
                        messenger+= '<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.feedback_label)+'</span>';
                    }

                    $.each(globalwpw.settings.obj.support_query, function (i, obj) {
                        supportsItems += '<span class="qcld-chatbot-support-items"  data-query-index="' + i + '">' + obj + '</span>';
                    });
                    var orEmailSuggest = '<span class="qcld-chatbot-suggest-email" >' + wpwKits.randomMsg(globalwpw.settings.obj.support_email) + '</span>';
					
                    if(globalwpw.settings.obj.call_sup=="") {
                        orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                    }
					
                     var queryOrEmail=supportsItems;
                }else {
                    if(globalwpw.settings.obj.call_sup=="") {
                        orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                    }
                    var queryOrEmail='<span class="qcld-chatbot-suggest-email" >' + wpwKits.randomMsg(globalwpw.settings.obj.support_email) + '</span>'+orPhoneSuggest;

                }

                wpwMsg.double_nobg(welcomeMsg,queryOrEmail);
                globalwpw.wildCard=0;
            } else if(globalwpw.wildCard==1 && globalwpw.supportStep=='email'){

                globalwpw.shopperEmail=msg;
                var validate = "";
                var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                if( re.test(globalwpw.shopperEmail)!=true){
                    validate = validate+wpwKits.randomMsg(globalwpw.settings.obj.invalid_email) ;
                }
                if(validate == ""){
                    var askingMsg=wpwKits.randomMsg(globalwpw.settings.obj.asking_msg);
                    wpwMsg.single(askingMsg);
                    globalwpw.supportStep='message';
                    //keeping value in localstorage
                    localStorage.setItem("supportStep",  globalwpw.supportStep);

                }else{
                    wpwMsg.single(validate);
                    globalwpw.supportStep='email';
                    //keeping value in localstorage
                    localStorage.setItem("supportStep",  globalwpw.supportStep);
                }
            }else if(globalwpw.wildCard==1 && globalwpw.supportStep=='message'){
                var data = {'action':'qcld_wb_chatbot_support_email','name':globalwpw.hasNameCookie,'email':globalwpw.shopperEmail,'message':msg};

                wpwKits.ajax(data).done(function (response) {
                    var json=$.parseJSON(response);
                    var orPhoneSuggest='';
                    if(json.status=='success'){
                        var sucMsg=json.message;
                        wpwMsg.single(sucMsg);
                        //Asking email after showing answer.
                        setTimeout(function(){
                            if(globalwpw.settings.obj.call_sup=="") {
                                orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                            }
                            var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                            if(globalwpw.settings.obj.disable_repeatative!=1){
                                wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                            }
                            globalwpw.wildCard=0;
                        },globalwpw.settings.preLoadingTime);
                    }else{
                        var failMsg=json.message;
                        wpwMsg.single(failMsg);
                        //Asking email after showing answer.
                        setTimeout(function(){
                            if(globalwpw.settings.obj.call_sup=="") {
                                orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                            }
                            var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                            if(globalwpw.settings.obj.disable_repeatative!=1){
                                wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                            }
                            globalwpw.wildCard=0;
                        },globalwpw.settings.preLoadingTime);
                    }
                });

            }else if(globalwpw.wildCard==1 && globalwpw.supportStep=='phone'){
                var data = {'action':'qcld_wb_chatbot_support_phone','name':globalwpw.hasNameCookie,'phone':msg};
                wpwKits.ajax(data).done(function (response) {
                    var json=$.parseJSON(response);
                    var orPhoneSuggest='';
                    if(json.status=='success'){
                        var sucMsg=json.message;
                        wpwMsg.single(sucMsg);
                        //Asking email after showing answer.
                        setTimeout(function(){
                            if(globalwpw.settings.obj.call_sup=="") {
                                orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                            }
                            var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                            if(globalwpw.settings.obj.disable_repeatative!=1){
                                wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                            }
                            globalwpw.wildCard=0;
                        },globalwpw.settings.preLoadingTime);
                    }else if(json.status=='invalid'){

                        var failMsg=json.message;
                        wpwMsg.single(failMsg);
                        globalwpw.supportStep='phone';
                        globalwpw.wildCard=1;
                        //keeping value in localstorage
                        localStorage.setItem("wildCard",  globalwpw.wildCard);
                        localStorage.setItem("supportStep",  globalwpw.supportStep);

                    }else{
                        var failMsg=json.message;
                        wpwMsg.single(failMsg);
                        //Asking email after showing answer.
                        setTimeout(function(){
                            if(globalwpw.settings.obj.call_sup=="") {
                                orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                            }
                            var orEmailSuggest='<span class="qcld-chatbot-suggest-email" >'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                            if(globalwpw.settings.obj.disable_repeatative!=1){
                                wpwKits.suggestEmail(orEmailSuggest+orPhoneSuggest);
                            }
                            globalwpw.wildCard=0;
                        },globalwpw.settings.preLoadingTime);
                    }
                });

            }else if(globalwpw.wildCard==1 && globalwpw.supportStep=='search'){
                
				if(msg!='' && globalwpw.settings.obj.disable_sitesearch==''){
					var data = {'action':'wpbo_search_site','name':globalwpw.hasNameCookie,'keyword':msg};
					wpwKits.ajax(data).done(function (response) {
						var json=$.parseJSON(response);
						if(json.status=='success'){
                            $('span[data-wildcart="back"]').remove();
                            wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                            
						}else{

                            msg = wpwKits.filterStopWords(msg);
                            var data = {'action':'wpbo_search_site','name':globalwpw.hasNameCookie,'keyword':msg};
                            wpwKits.ajax(data).done(function (response) {

                                var json=$.parseJSON(response);
                                if(json.status=='success'){
                                    $('span[data-wildcart="back"]').remove();
                                    wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                                }else{
                                    


                                    if(globalwpw.counter == globalwpw.settings.obj.no_result_attempt_count || globalwpw.settings.obj.no_result_attempt_count == 0 ){
												
                                        wpwMsg.single(json.html);
                                        
                                            setTimeout(function(){
                                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                                            },globalwpw.settings.preLoadingTime)
                                        
                                        globalwpw.counter = 0;
                                        
                                    }else{
                                        globalwpw.counter++;
                                        wpwMsg.single(json.html);
                                    }


                                }


                            })
							
						}
						globalwpw.wildCard=0;
					});
				}else{
					globalwpw.wildCard=0;
                    wpwMsg.single(wpwKits.randomMsg(globalwpw.settings.obj.empty_filter_msg));
                    if(globalwpw.settings.obj.disable_repeatative!=1){
                        setTimeout(function(){
                            var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                            wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                        },globalwpw.settings.preLoadingTime)
                    }
				}
            }

        },
        formbuilder:function(msg){

            console.log(msg);
            
            //destroy date picker
            jQuery('#wp-chatbot-editor').datetimepicker('destroy');
            jQuery('#wp-chatbot-editor').attr("type", "text");
            jQuery('#wp-chatbot-editor').prop("disabled", false);

            if(globalwpw.wildCard==7 && globalwpw.formStep=='welcome'){
                var data = {'action':'wpbot_get_form','formid':msg};
				wpwKits.ajax(data).done(function (response) {
                    var json=$.parseJSON(response);
                    
                    globalwpw.formfieldid = json.ID;
                    localStorage.setItem("formfieldid",  globalwpw.formfieldid);
                    globalwpw.formStep='field';
                    localStorage.setItem("formStep",  globalwpw.formStep);
                    globalwpw.formid=msg;
                    localStorage.setItem("formid",  globalwpw.formid);
                    localStorage.setItem("wildCard",  globalwpw.wildCard);

                    var label = json.label;

                    if(json.type=='dropdown'){
                        var html = '';
                        jQuery.each(json.config.option, function(key, value){
                            html += '<span class="qcld-chatbot-wildcard qcld-chatbot-formanswer" data-form-value="'+value.value+'" >'+value.label+'</span>';
                        })
                        wpwMsg.double(label, html);
                        setTimeout(function(){
                            jQuery('#wp-chatbot-editor').prop("disabled", true);
                        }, globalwpw.settings.preLoadingTime*2.2)
                    }else if(json.type=='checkbox'){
                        var html = '';
                        jQuery.each(json.config.option, function(key, value){                            
                            html += '<input type="checkbox" class="qcld-chatbot-checkbox" value="'+value.value+'">'+value.label+'<br>';
                        })
                        wpwMsg.double(label, html);
                    }else if(json.type=='number'){

                        wpwMsg.single(label);
                        jQuery('#wp-chatbot-editor').attr("type", "number");

                    }else if(json.type=='date_picker'){
                        
                        wpwMsg.single(label);
                        jQuery('#wp-chatbot-editor').blur();
                        jQuery('#wp-chatbot-editor').datetimepicker();
                    }else if(json.type=='email'){

                        wpwMsg.single(label);
                        jQuery('#wp-chatbot-editor').attr("type", "email");

                    }else if(json.type=='url'){

                        wpwMsg.single(label);
                        jQuery('#wp-chatbot-editor').attr("type", "url");

                    }else if(json.type=='html'){

                        wpwMsg.single(json.config.default);
                        globalwpw.formfieldid = json.ID;
                        localStorage.setItem("formfieldid",  globalwpw.formfieldid);
                        globalwpw.formentry = json.entry;
                        localStorage.setItem("formentry",  globalwpw.formentry);
                        setTimeout(function(){
                            wpwTree.formbuilder();
                        }, globalwpw.settings.preLoadingTime)
                        

                    }else{
                        wpwMsg.single(label);
                    }

                })

            }else if(globalwpw.wildCard==7 && globalwpw.formStep=='field'){
                var data = {'action':'wpbot_capture_form_value','formid':globalwpw.formid, 'fieldid': globalwpw.formfieldid, 'answer': msg, 'entry':globalwpw.formentry};
				wpwKits.ajax(data).done(function (response) {
                    var json=$.parseJSON(response);
                   

                    if(json.status=='incomplete'){

                        globalwpw.formStep='field';
                        localStorage.setItem("formStep",  globalwpw.formStep);
                        globalwpw.formfieldid = json.ID;
                        localStorage.setItem("formfieldid",  globalwpw.formfieldid);
                        globalwpw.formentry = json.entry;
                        localStorage.setItem("formentry",  globalwpw.formentry);

                        var label = json.label;

                        if(json.type=='dropdown'){
                            var html = '';
                            jQuery.each(json.config.option, function(key, value){
                                html += '<span class="qcld-chatbot-wildcard qcld-chatbot-formanswer" data-form-value="'+value.value+'" >'+value.label+'</span>';
                            })
                            wpwMsg.double(label, html);
                            setTimeout(function(){
                                jQuery('#wp-chatbot-editor').prop("disabled", true);
                            }, globalwpw.settings.preLoadingTime*2.2)
                            
                        }else if(json.type=='checkbox'){
                            var html = '';
                            jQuery.each(json.config.option, function(key, value){                            
                                html += '<input type="checkbox" class="qcld-chatbot-checkbox" value="'+value.value+'">'+value.label+'<br>';
                            })
                            wpwMsg.double(label, html);
                        }else if(json.type=='html'){

                            wpwMsg.single(json.config.default);
                            setTimeout(function(){
                                wpwTree.formbuilder();
                            }, globalwpw.settings.preLoadingTime)
                            

                        }else if(json.type=='date_picker'){
                            
                            wpwMsg.single(label);
                            jQuery('#wp-chatbot-editor').blur();
                            jQuery('#wp-chatbot-editor').datetimepicker();
                        }else if(json.type=='number'){

                            wpwMsg.single(label);
                            jQuery('#wp-chatbot-editor').attr("type", "number");
    
                        }else if(json.type=='email'){

                            wpwMsg.single(label);
                            jQuery('#wp-chatbot-editor').attr("type", "email");
    
                        }else if(json.type=='url'){

                            wpwMsg.single(label);
                            jQuery('#wp-chatbot-editor').attr("type", "url");
    
                        }else if(json.type=='calculation'){
                            wpwMsg.single(json.calresult);
                            setTimeout(function(){
                                wpwTree.formbuilder(json.calvalue);
                            }, globalwpw.settings.preLoadingTime)

                        }else if(json.type=='hidden'){
                            wpwTree.formbuilder(json.config.default);
                        }else{
                            wpwMsg.single(label);
                        }

                    }else{
                        globalwpw.formfieldid = '';
                        localStorage.setItem("formfieldid",  globalwpw.formfieldid);
                        globalwpw.formStep='welcome';
                        localStorage.setItem("formStep",  globalwpw.formStep);
                        globalwpw.formid='';
                        localStorage.setItem("formid",  globalwpw.formid);
                        globalwpw.wildCard = 0;
                        localStorage.setItem("wildCard",  globalwpw.wildCard);
                        globalwpw.formentry = 0;
                        localStorage.setItem("formentry",  globalwpw.formentry);
                        wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));

                        var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                        if(globalwpw.settings.obj.disable_repeatative!=1){
                            setTimeout(function(){
                                wpwMsg.double_nobg(serviceOffer, globalwpw.wildcards);
                            }, globalwpw.settings.preLoadingTime);
                        }

                    }

                })
            }

        },
        bargain:function(msg){

            if(globalwpw.wildCard==9 && globalwpw.bargainStep == 'welcome' && globalwpw.bargainId != ''){

                var data = {
                    'action':'qcld_woo_bargin_product',
                    'qcld_woo_map_product_id':globalwpw.bargainId,
                    'qcld_woo_map_variation_id':globalwpw.bargainVId,
                    'security': globalwpw.settings.obj.map_get_ajax_nonce

                };
                wpwKits.ajax(data).done(function (response) {

                    var restWarning = response.html;
                    var confirmBtn  = globalwpw.settings.obj.your_offer_price;
                    wpwMsg.double(restWarning,confirmBtn);

                    globalwpw.bargainStep = 'bargain';
                    globalwpw.bargainLoop  = 0;
                    globalwpw.bargainPrice = '';
                    globalwpw.bargainId = globalwpw.bargainId;
                    globalwpw.bargainVId = globalwpw.bargainVId;
                    localStorage.setItem("wildCard",  globalwpw.bargainStep);
                    localStorage.setItem("bargainLoop",  globalwpw.bargainLoop);
                    localStorage.setItem("bargainPrice",  globalwpw.bargainPrice);
                    localStorage.setItem("bargainId",  globalwpw.bargainId);
                    localStorage.setItem("bargainVId",  globalwpw.bargainVId);

                });


            }else if(globalwpw.wildCard==9 && globalwpw.bargainStep == 'bargain' && msg !== ""){
                
                    // setTimeout(function(){
                    var string = msg;
					
                    //var spliting = string.match(/\d+/g);
					var spliting = string.match(/\d+(?:\.\d+)?/g);
					
					if(spliting===null){
						wpwMsg.single(globalwpw.settings.obj.your_offer_price_again);

					}else{
						
					
						var msg = string.match(/\d+(?:\.\d+)?/g).map(Number);

						var data = {'action':'qcld_woo_bargin_product_price',
                                'qcld_woo_map_product_id':globalwpw.bargainId,
                                'qcld_woo_map_variation_id':globalwpw.bargainVId, 
                                'price': parseFloat(msg),
                                'security': globalwpw.settings.obj.map_get_ajax_nonce
                        };
						wpwKits.ajax(data).done(function (response) {
							
							globalwpw.bargainStep  = 'bargain';
							globalwpw.bargainPrice = response.sale_price;
							localStorage.setItem("bargainStep",  globalwpw.bargainStep);
							localStorage.setItem("bargainPrice",  globalwpw.bargainPrice);

							if(response.confirm == 'success'){
								// If user provide price below minimum price
								if( globalwpw.bargainLoop == 1){
									var your_low_price_alert  = globalwpw.settings.obj.your_low_price_alert;
									var confirmBtn1  = your_low_price_alert.replace("{offer price}", parseFloat(msg) + globalwpw.settings.obj.currency_symbol);
									var your_too_low_price_alert  = globalwpw.settings.obj.your_too_low_price_alert;
									var restWarning  = your_too_low_price_alert.replace("{minimum amount}", globalwpw.bargainPrice + globalwpw.settings.obj.currency_symbol);

									var confirmBtn='<span class="qcld-bargin-bot-confirm-add-to-cart" confirm-data="yes" >'+globalwpw.settings.obj.yes+'</span> <span> '+globalwpw.settings.obj.or+' </span><span class="qcld-chatbot-bargin-confirm-btn"  confirm-data="no">'+globalwpw.settings.obj.no+'</span>';
									wpwMsg.triple_nobg(confirmBtn1,restWarning,confirmBtn);

									globalwpw.bargainLoop  = 0;
									localStorage.setItem("wildCard",  globalwpw.bargainLoop);

								}else{
									var restWarning= response.html;
									wpwMsg.single(response.html);

									globalwpw.bargainLoop  = 1;
									localStorage.setItem("wildCard",  globalwpw.bargainLoop);
								}


							}else if(response.confirm == 'agree'){
								// if user provide resonable price.
								var restWarning= response.html;
								wpwMsg.single(restWarning);
								setTimeout(function(){
									var data = {'action':'qcld_woo_bargin_product_confirm',
                                    'qcld_woo_map_product_id':globalwpw.bargainId, 
                                    'price': globalwpw.bargainPrice,
                                    'security': globalwpw.settings.obj.map_get_ajax_nonce
                                };
									wpwKits.ajax(data).done(function (response) {


                                        var confirmBtn='<span class="qcld-bargin-bot-confirm-add-to-cart" confirm-data="yes" >'+globalwpw.settings.obj.yes+'</span> <span> '+globalwpw.settings.obj.or+' </span><span class="qcld-chatbot-bargin-confirm-btn"  confirm-data="no">'+globalwpw.settings.obj.no+'</span>';
                                    

                                            //wpwMsg.single(response.html);
											wpwMsg.double_nobg(response.html, confirmBtn);
											globalwpw.wildCard = 9;
											globalwpw.bargainStep  = 'bargain';
											globalwpw.bargainPrice =  globalwpw.bargainPrice;
											localStorage.setItem("wildCard",  globalwpw.wildCard);
											localStorage.setItem("wildCard",  globalwpw.bargainStep);
											localStorage.setItem("wildCard",  globalwpw.bargainPrice);
									});

								},globalwpw.settings.preLoadingTime);

							}else if(response.confirm == 'default'){

								wpwMsg.double_nobg(response.html, '');

							}else{
								wpwMsg.single(response.html);
							}
							
						});
					}
               // },globalwpw.settings.preLoadingTime);

            }else if(globalwpw.wildCard==9 && globalwpw.bargainStep == 'confirm'){

                setTimeout(function(){

                    var data = {'action':'qcld_woo_bargin_product_confirm',
                            'qcld_woo_map_product_id':globalwpw.bargainId, 
                            'price': globalwpw.bargainPrice,
                            'security': globalwpw.settings.obj.map_get_ajax_nonce
                        };
                    wpwKits.ajax(data).done(function (response) {

                        // map_acceptable_price
                        var restWarning = response.html;
                        var map_acceptable_price  = globalwpw.settings.obj.map_acceptable_price;
                        //var confirmBtn1  = map_acceptable_price.replace("{offer price}", globalwpw.bargainPrice + globalwpw.settings.obj.currency_symbol);
                        var confirmBtn1  = map_acceptable_price;
                        //var confirmBtn1  = '<p>Great! I am creating a one time discount coupon valid for you only.</p>';
                        wpwMsg.double(confirmBtn1,restWarning);

                        globalwpw.wildCard = 0;
                        globalwpw.bargainStep  = 'welcome';
                        globalwpw.bargainPrice = '';
                        localStorage.setItem("wildCard",  globalwpw.wildCard);
                        localStorage.setItem("bargainStep",  globalwpw.bargainStep);
                        localStorage.setItem("bargainPrice",  globalwpw.bargainPrice);
                        

                    });

                },globalwpw.settings.preLoadingTime);

            }else if(globalwpw.wildCard==9 && globalwpw.bargainStep == 'add_to_cart'){

                setTimeout(function(){

                    if(globalwpw.bargainVId != ''){

                        var data = {'action':'qcld_woo_bargin_product_variation_add_to_cart',
                                'product_id':globalwpw.bargainId,
                                'variation_id':globalwpw.bargainVId, 
                                'price': globalwpw.bargainPrice,
                                'security': globalwpw.settings.obj.map_get_ajax_nonce
                            };

                    }else{

                       var data = {
                        'action':'qcld_woo_bargin_product_add_to_cart',
                        'product_id':globalwpw.bargainId, 
                        'price': globalwpw.bargainPrice,
                        'security': globalwpw.settings.obj.map_get_ajax_nonce
                        };
                    }


                    wpwKits.ajax(data).done(function (response) {

                        // map_acceptable_price
                        var restWarning = response.html;

                        var confirmBtn='<div class="woo-chatbot-product-bargain-btn"><a href="'+globalwpw.settings.obj.map_get_checkout_url +'" class="qcld-modal-bargin-confirm-btn-checkout"> '+globalwpw.settings.obj.map_checkout_now_button_text+' </a></div>';

                        //wpwMsg.single(restWarning);

                        wpwMsg.double_nobg(restWarning, confirmBtn);


                        globalwpw.wildCard = 0;
                        globalwpw.bargainStep  = 'welcome';
                        globalwpw.bargainVId = '';
                        globalwpw.bargainPrice = '';
                        localStorage.setItem("wildCard",  globalwpw.wildCard);
                        localStorage.setItem("bargainStep",  globalwpw.bargainStep);
                        localStorage.setItem("bargainVId",  globalwpw.bargainVId);
                        localStorage.setItem("bargainPrice",  globalwpw.bargainPrice);
                        

                    });

                },globalwpw.settings.preLoadingTime);

            }else if(globalwpw.wildCard==9 && globalwpw.bargainStep == 'disagree' && globalwpw.bargainLoop == 0){

                    //  map_talk_to_boss msg
                    var map_talk_to_boss  = globalwpw.settings.obj.map_talk_to_boss;
                    var confirmBtn  = map_talk_to_boss;
                    wpwMsg.single(confirmBtn);
                    globalwpw.bargainLoop = 1;
                    localStorage.setItem("bargainLoop",  globalwpw.bargainLoop);
    

            }else if(globalwpw.wildCard==9 && globalwpw.bargainStep == 'disagree' && globalwpw.bargainLoop == 1){

				var string = msg;
				var spliting = string.match(/\d+(?:\.\d+)?/g);
					
				if(spliting===null){
					wpwMsg.single(globalwpw.settings.obj.your_offer_price_again);

				}else{
					// map_get_email_address
					var map_get_email_address  = globalwpw.settings.obj.map_get_email_address;
					var confirmBtn  = map_get_email_address;
					wpwMsg.single(confirmBtn);  

				   // var string = msg;
					globalwpw.bargainPrice = msg.match(/\d+(?:\.\d+)?/g).map(Number);
					//globalwpw.bargainPrice = msg;
					//localStorage.setItem("wildCard",  globalwpw.bargainPrice);
					localStorage.setItem("finalprice",  globalwpw.bargainPrice);

					

					globalwpw.bargainLoop = 2;
					localStorage.setItem("bargainLoop",  globalwpw.bargainLoop);
				}
            }else if(globalwpw.wildCard==9 && globalwpw.bargainStep == 'disagree' && globalwpw.bargainLoop == 2){

                // map_get_email_address
                var map_thanks_test  = globalwpw.settings.obj.map_thanks_test;
                var confirmBtn  = map_thanks_test;

                setTimeout(function(){
                    
                    wpwMsg.single(confirmBtn); 

                    var data = {'action':'qcld_woo_bargin_send_query',
                                'qcld_woo_map_product_id':globalwpw.bargainId, 
                                'price':  localStorage.getItem("finalprice"), 
                                'email': msg,
                                'security': globalwpw.settings.obj.map_get_ajax_nonce
                            };
                    
                    wpwKits.ajax(data).done(function (response) {
                        //console.log(response);
                       // wpwMsg.single(confirmBtn);  

                    });

                },globalwpw.settings.preLoadingTime);

                globalwpw.bargainLoop = 0;
                localStorage.setItem("bargainLoop",  globalwpw.bargainLoop);
                globalwpw.wildCard = 0;
                globalwpw.bargainStep  = 'welcome';
                globalwpw.bargainPrice = '';
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("bargainStep",  globalwpw.bargainStep);
                localStorage.setItem("bargainPrice",  globalwpw.bargainPrice);

            }


		}
    };
    /*
     * wpwbot Actions are divided into two part
     * shopper will response after initialize message,
     * then based on shopper activities shopper will act.
     */
    
    wpwAction={
        bot:function(msg){
            //Disable the Editor
            


            wpwKits.disableEditor(globalwpw.settings.obj.agent+' '+wpwKits.randomMsg(globalwpw.settings.obj.is_typing));
            

            var allformname = jQuery.map(globalwpw.settings.obj.forms, function(n,i){return n.toLowerCase();});
            var allformcommand = jQuery.map(globalwpw.settings.obj.form_commands, function(n,i){return n.toLowerCase();});
			
			
            if(globalwpw.wildcardsHelp.indexOf(msg.toLowerCase())>-1){
			
				
			
                if(msg.toLowerCase()==globalwpw.settings.obj.sys_key_help.toLowerCase()){
                    
                    globalwpw.wildCard=0;
                    var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                    wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                }
				
                if(msg.toLowerCase()==globalwpw.settings.obj.sys_key_support.toLowerCase()){
                    globalwpw.wildCard=1;
                    globalwpw.supportStep='welcome';
                    wpwTree.support(msg);
                }
                
                if(msg.toLowerCase()==globalwpw.settings.obj.sys_key_product.toLowerCase()){
                    globalwpw.wildCard=20;
                    globalwpw.productStep='asking';
                    wpwTree.product(msg);
                }
                if(globalwpw.settings.obj.woocommerce){
                    if(msg.toLowerCase()==globalwpw.settings.obj.sys_key_catalog.toLowerCase()){
                        globalwpw.wildCard=20;
                        globalwpw.productStep='search';
                        wpwKits.sugestCat();
                    }

                    if(msg.toLowerCase()==globalwpw.settings.obj.sys_key_order.toLowerCase()){
                        globalwpw.wildCard=21;
                        globalwpw.orderStep='welcome';
                        wpwTree.order(msg);
                    }
                }

				if(msg.toLowerCase()==globalwpw.settings.obj.email_subscription.toLowerCase()){
                    globalwpw.wildCard=3;
                    globalwpw.subscriptionStep='welcome';
                    wpwTree.subscription(msg);
                }

                if(msg.toLowerCase()==globalwpw.settings.obj.unsubscribe.toLowerCase()){
                    globalwpw.wildCard=6;
                    globalwpw.unsubscriptionStep='welcome';
                    wpwTree.unsubscription(msg);
                }
				
                if(msg.toLowerCase()==globalwpw.settings.obj.sys_key_reset.toLowerCase()){
                    var restWarning=globalwpw.settings.obj.reset;
                    var confirmBtn='<span class="qcld-chatbot-reset-btn" reset-data="yes" >'+globalwpw.settings.obj.yes+'</span> <span> '+globalwpw.settings.obj.or+' </span><span class="qcld-chatbot-reset-btn"  reset-data="no">'+globalwpw.settings.obj.no+'</span>';
                    wpwMsg.double_nobg(restWarning,confirmBtn);
                }
				if(msg.toLowerCase()==globalwpw.settings.obj.sys_key_livechat.toLowerCase()){
					wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
					if(globalwpw.settings.obj.is_livechat_active){
						if(globalwpw.settings.obj.disable_livechat_operator_offline==1){
							if(globalwpw.settings.obj.is_operator_online==1){
								if($('#wbca_signup_fullname').length>0){
									if(localStorage.getItem('shopper')!==null){
										$('#wbca_signup_fullname').val(localStorage.getItem('shopper'));
									}
									if(localStorage.getItem('shopperemail')!==null){
										$('#wbca_signup_email').val(localStorage.getItem('shopperemail'));
									}
								}
								$("#wp-chatbot-board-container").removeClass('active-chat-board');
								$('.wp-chatbot-container').hide();
								$('.wpbot-saas-live-chat').show();
							}
						}else{
							if($('#wbca_signup_fullname').length>0){
								if(localStorage.getItem('shopper')!==null){
									$('#wbca_signup_fullname').val(localStorage.getItem('shopper'));
								}
								if(localStorage.getItem('shopperemail')!==null){
									$('#wbca_signup_email').val(localStorage.getItem('shopperemail'));
								}
							}							
							$("#wp-chatbot-board-container").removeClass('active-chat-board');
							$('.wp-chatbot-container').hide();
							$('.wpbot-saas-live-chat').show();
						}
					}
					
                }

            }else if(allformname.indexOf(msg.toLowerCase()) > -1 || allformcommand.indexOf(msg.toLowerCase()) > -1){
                //Form builder commands form name
                
                var index = (allformname.indexOf(msg.toLowerCase()) > -1?allformname.indexOf(msg.toLowerCase()):allformcommand.indexOf(msg.toLowerCase()));
                var formid=globalwpw.settings.obj.form_ids[index];
                globalwpw.wildCard=7;
                globalwpw.formStep='welcome';
                wpwTree.formbuilder(formid);

            }else{

                /*
                 *   Greeting part
                 *   bot action
                 */
				
                if(globalwpw.wildCard==0){
					//When intialize 1 and don't have cookies then keep  the name of shooper in in cookie
					if(globalwpw.initialize==1 && !localStorage.getItem('shopper')  && globalwpw.wildCard==0){
						wpwTree.greeting(msg);
					}else if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
						wpwTree.greeting(msg);
					}else if(localStorage.getItem('default_asking_email')){
                        wpwTree.greeting(msg);
                    }else{
						//Default intents site search
						
						if(msg!='' && globalwpw.settings.obj.disable_sitesearch==''){
							var data = {'action':'wpbo_search_site','name':globalwpw.hasNameCookie,'keyword':msg};
							wpwKits.ajax(data).done(function (response) {
								var json=$.parseJSON(response);
								if(json.status=='success'){
                                    $('span[data-wildcart="back"]').remove();
                                    wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                                    
								}else{
                                    msg = wpwKits.filterStopWords(msg);
                                    var data = {'action':'wpbo_search_site','name':globalwpw.hasNameCookie,'keyword':msg};
                                    wpwKits.ajax(data).done(function (response) {
                                        var json=$.parseJSON(response);
                                        if(json.status=='success'){
                                            $('span[data-wildcart="back"]').remove();
                                            wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                                        }else{
                                            if(globalwpw.counter == globalwpw.settings.obj.no_result_attempt_count || globalwpw.settings.obj.no_result_attempt_count == 0 ){
												
                                                wpwMsg.single(json.html);
                                                
                                                    setTimeout(function(){
                                                        var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                                        wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                                                    },globalwpw.settings.preLoadingTime)
                                                
                                                globalwpw.counter = 0;
                                                
                                            }else{
                                                globalwpw.counter++;
                                                wpwMsg.single(json.html);
                                            }


                                        }

                                    })

								}
								globalwpw.wildCard=0;
							});
						}else{
							globalwpw.wildCard=0;
                            wpwMsg.single(wpwKits.randomMsg(globalwpw.settings.obj.empty_filter_msg));
                            
                            if(globalwpw.settings.obj.disable_repeatative!=1){
                                setTimeout(function(){
                                    var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                    wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                                },globalwpw.settings.preLoadingTime)
                            }

							
						}
					}
					
					
					
                    //
					
                }
                if(globalwpw.settings.obj.woocommerce){
                    //Product
                    if(globalwpw.wildCard==20){
                        
                        wpwTree.product(msg);
                    }

                    /*
                    *   order status part
                    *   bot action
                    */
                    if(globalwpw.wildCard==21){
                        wpwTree.order(msg);
                    }
                }
              
                if(globalwpw.wildCard==1){
                    wpwTree.support(msg);
                }
				if(globalwpw.wildCard==3){
                    wpwTree.subscription(msg);
                }
                if(globalwpw.wildCard==6){
                    wpwTree.unsubscription(msg);
                }

                if(globalwpw.wildCard==7){
                    wpwTree.formbuilder(msg);
                }
                if(globalwpw.wildCard==9){
                    wpwTree.bargain(msg);
                }

            }
        },
        shopper:function (msg) {
            wpwMsg.shopper(msg);
            if(globalwpw.wildCard==1) {
                this.bot(msg);
            }else if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.wildCard==0 && globalwpw.ai_step==1 && globalwpw.df_status_lock==0){
                this.bot(msg);
            } else{
				var filterMsg=msg;
                //Filtering the user given messages by stopwords
				if(!localStorage.getItem('shopper')){
					filterMsg = msg;
				}

                //handle empty filterMsg as repeat the message.
                if(filterMsg=="")  {
					//need to add condition for email collecting
					if(globalwpw.settings.obj.ask_email_wp_greetings==1){
						this.bot(msg);
					}else{
					
							globalwpw.repeatQueryEmpty=wpwKits.randomMsg(globalwpw.settings.obj.empty_filter_msg);
							globalwpw.emptymsghandler++;
						
                        wpwMsg.single(globalwpw.repeatQueryEmpty);
                        if(globalwpw.settings.obj.disable_repeatative!=1){
                            setTimeout(function(){
                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                            },globalwpw.settings.preLoadingTime)
                        }
					}

                }else {
                    globalwpw.emptymsghandler=0;
                    this.bot(filterMsg);
                }

            }

        }
    };



    //bargain initiate function
    $(document).on('click', '.woo_minimum_accept_price-bargin', function(e){

        console.log('hello world');

        var product_id = $(this).attr('product_id');
        var variation_id = '';

        var variable_check = $('.woo_minimum_accept_price-bargin').parent().parent().find('.variation_id');

        if($( variable_check ).hasClass( "variation_id" )){

            var variation_id = $('.variation_id').val();

            if( variation_id == '0' || variation_id == '' ) {
                alert('Please select some product options before adding this product to your cart.');
                return false;
            }

        }
        
        globalwpw.wildCard = 9;
        globalwpw.bargainStep = 'welcome';
        globalwpw.bargainId = product_id;
        globalwpw.bargainVId = variation_id;
        globalwpw.bargainPrice = '';
        localStorage.setItem("wildCard",  globalwpw.wildCard);
        localStorage.setItem("wildCard",  globalwpw.bargainStep);
        localStorage.setItem("wildCard",  globalwpw.bargainId);
        localStorage.setItem("wildCard",  globalwpw.bargainPrice);
        localStorage.setItem("bargainVId",  globalwpw.bargainVId);
        
        if(!localStorage.getItem('shopper')){
            $.cookie("shopper", "Guest", { expires : 365 });
            localStorage.setItem('shopper',"Guest");
        }
        globalwpw.ai_step==1;
        
        
        if($('.active-chat-board').length>0){
            wpwTree.bargain();
    
        }else{
            $('#wp-chatbot-ball').trigger('click');
            
            setTimeout(function(){
                wpwTree.bargain('');
            }, globalwpw.settings.preLoadingTime)
                
            
        }
        
    });

    // bargain confirm ...
    $(document).on('click','.qcld-chatbot-bargin-confirm-btn',function (e) {
        e.preventDefault();
        var shopperChoice=$(this).text();
        wpwMsg.shopper_choice(shopperChoice);
        var actionType=$(this).attr('confirm-data');
        if(actionType=='yes'){

            globalwpw.bargainStep = 'confirm';
            localStorage.setItem("wildCard",  globalwpw.bargainStep);
            wpwTree.bargain();
        } else if(actionType=='no'){
            globalwpw.bargainStep = 'disagree';
            localStorage.setItem("wildCard",  globalwpw.bargainStep);
            globalwpw.bargainLoop = 0;
            localStorage.setItem("wildCard",  globalwpw.bargainLoop);
            wpwTree.bargain();
        }
    });

    $(document).on('click','.qcld-bargin-bot-confirm-add-to-cart',function (e) {
        e.preventDefault();
        var shopperChoice=$(this).text();
        wpwMsg.shopper_choice(shopperChoice);

        globalwpw.bargainId = localStorage.getItem('bargainId');
        globalwpw.bargainVId = localStorage.getItem('bargainVId');
        globalwpw.bargainPrice = localStorage.getItem('bargainPrice');
        console.log(globalwpw.bargainId);
        console.log(globalwpw.bargainPrice);
        console.log(globalwpw.bargainVId);

        globalwpw.bargainStep = 'add_to_cart';
        localStorage.setItem("bargainStep",  globalwpw.bargainStep);
        wpwTree.bargain();

    });



    $(document).on('click','.qcld-modal-bargin-bot-confirm-exit-intent',function (e) {
        e.preventDefault();
        var shopperChoice=$(this).text();
        wpwMsg.shopper_choice(shopperChoice);
        var actionType=$(this).attr('confirm-data');
        if(actionType=='yes'){
            $('.woo_minimum_accept_price-bargin').trigger('click');
        }
    });

    

    /*
     * wpwBot Plugin Creation without selector and
     * wpwbot and shoppers all activities will be handled.
     */
    $.wpwbot = function(options) {
        
        //Using plugins defualts values or overwrite by options.
        var settings = $.extend({}, $.wpwbot.defaults, options);
        //Updating global settings
        globalwpw.settings=settings;
        //updating the helpkeywords

        if(globalwpw.settings.obj.woocommerce){
            globalwpw.wildcardsHelp=[globalwpw.settings.obj.sys_key_help.toLowerCase(),globalwpw.settings.obj.sys_key_support.toLowerCase(),globalwpw.settings.obj.sys_key_reset.toLowerCase(), globalwpw.settings.obj.email_subscription.toLowerCase(), globalwpw.settings.obj.unsubscribe.toLowerCase(), globalwpw.settings.obj.sys_key_livechat.toLowerCase(),globalwpw.settings.obj.sys_key_product.toLowerCase(),globalwpw.settings.obj.sys_key_catalog.toLowerCase(),globalwpw.settings.obj.sys_key_order.toLowerCase() ]
        }else{
            globalwpw.wildcardsHelp=[globalwpw.settings.obj.sys_key_help.toLowerCase(),globalwpw.settings.obj.sys_key_support.toLowerCase(),globalwpw.settings.obj.sys_key_reset.toLowerCase(), globalwpw.settings.obj.email_subscription.toLowerCase(), globalwpw.settings.obj.unsubscribe.toLowerCase(), globalwpw.settings.obj.sys_key_livechat.toLowerCase() ]
        }
        

        //updating wildcards
        globalwpw.wildcards='';
        
		
		
		//Adding custom Intents
        
        if(globalwpw.settings.obj.start_menu!=''){
            globalwpw.wildcards = globalwpw.settings.obj.start_menu;
        }else{

        

        if(globalwpw.settings.obj.disable_livechat=="" && globalwpw.settings.obj.is_livechat_active) {
			
			if(globalwpw.settings.obj.disable_livechat_operator_offline==1){
				if(globalwpw.settings.obj.is_operator_online==1){
					globalwpw.wildcards += '<span class="qcld-chatbot-custom-intent" data-text="'+globalwpw.settings.obj.sys_key_livechat+'" >'+(globalwpw.settings.obj.livechat_label)+'</span>';
				}
			}else{
				globalwpw.wildcards += '<span class="qcld-chatbot-custom-intent" data-text="'+globalwpw.settings.obj.sys_key_livechat+'" >'+(globalwpw.settings.obj.livechat_label)+'</span>';
			}
			
		}

		if(globalwpw.settings.obj.disable_email_subscription=="") {
			globalwpw.wildcards += '<span class="qcld-chatbot-default wpbd_subscription">' + globalwpw.settings.obj.email_subscription + '</span>';
		}
		
		if(globalwpw.settings.obj.custom_intent[0]!='' && globalwpw.settings.obj.ai_df_enable==1){
			
			for(var i=0;i<globalwpw.settings.obj.custom_intent.length;i++){
				
				if(globalwpw.settings.obj.custom_intent[i]!='' && globalwpw.settings.obj.custom_intent_label[i]!=''){
					globalwpw.wildcards += '<span class="qcld-chatbot-custom-intent" data-text="'+globalwpw.settings.obj.custom_intent_label[i]+'" >'+globalwpw.settings.obj.custom_intent_label[i]+'</span>';
				}
				
			}
			
        }
        
        if(globalwpw.settings.obj.custom_menu[0]!=''){
			
			for(var i=0;i<globalwpw.settings.obj.custom_menu.length;i++){
				
				if(globalwpw.settings.obj.custom_menu[i]!='' && globalwpw.settings.obj.custom_menu_link[i]!=''){
					globalwpw.wildcards += '<span class="qcld-chatbot-wildcard qcld-chatbot-buttonlink" data-link="'+globalwpw.settings.obj.custom_menu_link[i]+'" data-target="'+globalwpw.settings.obj.custom_menu_target[i]+'" >'+globalwpw.settings.obj.custom_menu[i]+'</span>';
				}
				
			}
			
		}
		
		
		
		if(globalwpw.settings.obj.livechat=='1' && !globalwpw.settings.obj.is_livechat_active) {
			globalwpw.wildcards += '<span class="qcld-chatbot-default wpbo_live_chat" >'+globalwpw.settings.obj.livechat_button_label+'</span>';
		}
        if(globalwpw.settings.obj.woocommerce){
            if(globalwpw.settings.obj.disable_product_search!=1) {
                globalwpw.wildcards += '<span class="qcld-chatbot-wildcard"  data-wildcart="product">' + wpwKits.randomMsg(globalwpw.settings.obj.wildcard_product) + '</span>';
            }
            if(globalwpw.settings.obj.disable_catalog!=1) {
                globalwpw.wildcards += '<span class="qcld-chatbot-wildcard"  data-wildcart="catalog">' + wpwKits.randomMsg(globalwpw.settings.obj.wildcard_catalog) + '</span>';
            }
            if(globalwpw.settings.obj.disable_featured_product!=1){
                globalwpw.wildcards+='<span class="qcld-chatbot-wildcard"  data-wildcart="featured">'+wpwKits.randomMsg(globalwpw.settings.obj.featured_products)+'</span>';
            }
    
            if(globalwpw.settings.obj.disable_sale_product!=1){
                globalwpw.wildcards+='<span class="qcld-chatbot-wildcard"  data-wildcart="sale">'+wpwKits.randomMsg(globalwpw.settings.obj.sale_products)+' </span>';
            }
    
            if(globalwpw.settings.obj.disable_order_status!=1){
                globalwpw.wildcards+='<span class="qcld-chatbot-wildcard"  data-wildcart="order">'+wpwKits.randomMsg(globalwpw.settings.obj.wildcard_order)+'</span>';
            }
        }
        

		if(globalwpw.settings.obj.disable_sitesearch=='') {
			globalwpw.wildcards += '<span class="qcld-chatbot-site-search" >'+globalwpw.settings.obj.site_search+'</span>';
		}
		
		if(globalwpw.settings.obj.disable_faq=='') {
			globalwpw.wildcards+='<span class="qcld-chatbot-wildcard"  data-wildcart="support">'+globalwpw.settings.obj.wildcard_support+'</span>';
		}
		
		
        if(globalwpw.settings.obj.enable_messenger==1) {
            globalwpw.wildcards += '<span class="qcld-chatbot-wildcard"  data-wildcart="messenger">'+wpwKits.randomMsg(globalwpw.settings.obj.messenger_label)+'</span>';
        }
        if(globalwpw.settings.obj.enable_whats==1) {
            globalwpw.wildcards += '<span class="qcld-chatbot-wildcard"  data-wildcart="whatsapp">'+wpwKits.randomMsg(globalwpw.settings.obj.whats_label)+'</span>';
        }
		
        if(globalwpw.settings.obj.disable_feedback=='') {
            globalwpw.wildcards += '<span class="qcld-chatbot-suggest-email">'+globalwpw.settings.obj.send_us_email+'</span>';
        }
		if(globalwpw.settings.obj.disable_leave_feedback=='') {
            globalwpw.wildcards += '<span class="qcld-chatbot-suggest-email wpbd_feedback">'+globalwpw.settings.obj.leave_feedback+'</span>';
        }
		
        if(globalwpw.settings.obj.call_gen=="") {
            globalwpw.wildcards += '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
        }

        if(globalwpw.settings.obj.form_ids[0]!=''){
				
            for(var i=0;i<globalwpw.settings.obj.form_ids.length;i++){
                
                if(globalwpw.settings.obj.form_ids[i]!='' && globalwpw.settings.obj.forms[i]!=''){
                    globalwpw.wildcards += '<span class="qcld-chatbot-wildcard qcld-chatbot-form" data-form="'+globalwpw.settings.obj.form_ids[i]+'" >'+globalwpw.settings.obj.forms[i]+'</span>';
                }
                
            }
            
        }

        
        
    }



        //Initialize the wpwBot with greeting and if already initialize and given name then return greeting..
        if(localStorage.getItem("wpwHitory") && globalwpw.initialize==0 ){
            var wpwHistory=localStorage.getItem("wpwHitory");
            
            $(globalwpw.settings.messageWrapper).html(wpwHistory);
            //Scroll to the last element.
            wpwKits.scrollTo();
            //Now mainting the current stages tokens
            globalwpw.initialize=1;
            if(localStorage.getItem("wildCard")){
                globalwpw.wildCard=localStorage.getItem("wildCard");
            }
            if(localStorage.getItem("productStep")){
                globalwpw.productStep=localStorage.getItem("productStep");
            }
            if(localStorage.getItem("orderStep")){
                globalwpw.orderStep=localStorage.getItem("orderStep");
            }
            if(localStorage.getItem("supportStep")){
                globalwpw.supportStep=localStorage.getItem("supportStep");
            }
            if(localStorage.getItem("aiStep")){
                globalwpw.ai_step=localStorage.getItem("aiStep");
            }
            if(localStorage.getItem("formfieldid")){
                globalwpw.formfieldid=localStorage.getItem("formfieldid");
            }

            if(localStorage.getItem("formentry")){
                globalwpw.formentry=localStorage.getItem("formentry");
            }

            if(localStorage.getItem("formStep")){
                globalwpw.formStep=localStorage.getItem("formStep");
            }
            if(localStorage.getItem("formid")){
                globalwpw.formid=localStorage.getItem("formid");
            }



            //update the value for initializing.
            globalwpw.initialize=1;

        } else {
            if(globalwpw.wildCard == 9){
				wpwTree.bargain();
			}else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Faq'){

                if(!localStorage.getItem('shopper')){
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }
               
                globalwpw.wildCard=1;
                globalwpw.supportStep='welcome';
                wpwAction.bot('from wildcard support');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("supportStep", globalwpw.supportStep);
                globalwpw.initialize=1;
                globalwpw.ai_step=1;

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Email Subscription'){

                if(!localStorage.getItem('shopper')){
                    console.log(globalwpw.settings.obj.shopper_demo_name);
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }

                globalwpw.wildCard=3;
                globalwpw.subscriptionStep='welcome';
                wpwTree.subscription();
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("supportStep", globalwpw.supportStep);
                globalwpw.initialize=1;
                globalwpw.ai_step=1;

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Product Search'){

                if(!localStorage.getItem('shopper')){
                    console.log(globalwpw.settings.obj.shopper_demo_name);
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }

                globalwpw.wildCard=20;
                globalwpw.productStep='asking'
                wpwAction.bot('from wildcard product');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("productStep", globalwpw.productStep);
                globalwpw.initialize=1;
                globalwpw.ai_step=1;

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Catalog'){

                if(!localStorage.getItem('shopper')){
                    console.log(globalwpw.settings.obj.shopper_demo_name);
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }
                wpwAction.bot(globalwpw.settings.obj.sys_key_catalog.toLowerCase());
                globalwpw.initialize=1;
                globalwpw.ai_step=1;

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Featured Products'){

                if(!localStorage.getItem('shopper')){
                    console.log(globalwpw.settings.obj.shopper_demo_name);
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }
                globalwpw.wildCard=20;
                globalwpw.productStep='featured'
                wpwAction.bot('from wildcard product');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("productStep", globalwpw.productStep);
                
                globalwpw.initialize=1;
                globalwpw.ai_step=1;

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Products on Sale'){

                if(!localStorage.getItem('shopper')){
                    console.log(globalwpw.settings.obj.shopper_demo_name);
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }
                globalwpw.wildCard=20;
                globalwpw.productStep='sale'
                wpwAction.bot('from wildcard product');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("productStep", globalwpw.productStep);
                
                globalwpw.initialize=1;
                globalwpw.ai_step=1;

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Order Status'){

                if(!localStorage.getItem('shopper')){
                    console.log(globalwpw.settings.obj.shopper_demo_name);
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }
                globalwpw.wildCard=21;
                globalwpw.orderStep='welcome';
                wpwAction.bot('from wildcard order');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("orderStep", globalwpw.orderStep);
                
                globalwpw.initialize=1;
                globalwpw.ai_step=1;

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Site Search'){

                if(!localStorage.getItem('shopper')){
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }

                if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
                    var shopperName=  globalwpw.settings.obj.shopper_demo_name;
                }else{
                    var shopperName=globalwpw.hasNameCookie;
                }
                var askEmail= wpwKits.randomMsg(wp_chatbot_obj.asking_search_keyword)
                
                wpwMsg.single(askEmail.replace("#name", shopperName));
                //Now updating the support part as .
                globalwpw.supportStep='search';
                globalwpw.wildCard=1;
                globalwpw.ai_step=1;
                globalwpw.initialize=1;
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("supportStep",  globalwpw.supportStep);

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Send Us Email'){

                if(!localStorage.getItem('shopper')){
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }

                if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
                    var shopperName=  globalwpw.settings.obj.shopper_demo_name;
                }else{
                    var shopperName=globalwpw.hasNameCookie;
                }
                var askEmail=wp_chatbot_obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(wp_chatbot_obj.asking_email);
                wpwMsg.single(askEmail);
                //Now updating the support part as .
                globalwpw.supportStep='email';
                globalwpw.wildCard=1;
                globalwpw.ai_step=1;
                globalwpw.initialize=1;
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("supportStep",  globalwpw.supportStep);

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Leave A Feedback'){

                if(!localStorage.getItem('shopper')){
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }

                if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
                    var shopperName=  globalwpw.settings.obj.shopper_demo_name;
                }else{
                    var shopperName=globalwpw.hasNameCookie;
                }
                var askEmail=wp_chatbot_obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(wp_chatbot_obj.asking_email);
                wpwMsg.single(askEmail);
                //Now updating the support part as .
                globalwpw.supportStep='email';
                globalwpw.wildCard=1;
                globalwpw.ai_step=1;
                globalwpw.initialize=1;
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("supportStep",  globalwpw.supportStep);

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent=='Request Callback'){

                if(!localStorage.getItem('shopper')){
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }

                if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
                    var shopperName=  globalwpw.settings.obj.shopper_demo_name;
                }else{
                    var shopperName=globalwpw.hasNameCookie;
                }
                var askEmail=wp_chatbot_obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(wp_chatbot_obj.asking_phone);
                setTimeout(function(){
                    wpwMsg.single(askEmail);
                    //Now updating the support part as .
                    globalwpw.supportStep='phone';
                    globalwpw.wildCard=1;
                    globalwpw.ai_step=1;
                    globalwpw.initialize=1;
                    //keeping value in localstorage
                    localStorage.setItem("wildCard",  globalwpw.wildCard);
                    localStorage.setItem("supportStep",  globalwpw.supportStep);
                },1000)

            }else if(typeof(globalwpw.settings.obj.clickintent) !=="undefined" && globalwpw.settings.obj.clickintent !='' ){

                if(!localStorage.getItem('shopper')){
                    $.cookie("shopper", globalwpw.settings.obj.shopper_demo_name, { expires : 365 });
                    localStorage.setItem('shopper',globalwpw.settings.obj.shopper_demo_name);
                    globalwpw.hasNameCookie=globalwpw.settings.obj.shopper_demo_name;
                }
                globalwpw.initialize=1;
                globalwpw.ai_step=1;
                globalwpw.wildCard=0;
                wpwAction.bot(globalwpw.settings.obj.clickintent);

            }else if(globalwpw.initialize==0 && globalwpw.wildCard==0 && globalwpw.settings.obj.re_target_handler==0){
                wpwWelcome.greeting();
                //update the value for initializing.
                globalwpw.initialize=1;
            }else{  // re targeting part .
                setTimeout(function (e) {
                    wpwWelcome.greeting();
                },8500);
                globalwpw.initialize=1;
            }
        }

        //When shopper click on send button
        $(document).on('click',settings.sendButton,function (e) {
            
            if(!$(settings.messageEditor)[0].checkValidity()){
                $(settings.messageEditor)[0].reportValidity();
            }else{
                var shopperMsg =$(settings.messageEditor).val();
                if(shopperMsg != ""){
                    wpwAction.shopper(wpwKits.htmlTagsScape(shopperMsg));
                    $(settings.messageEditor).val('');
                }
            }

            
        });

        /*
         * Or when shopper press the ENTER key
         * Then chatting functionality will be started.
         */
		
        $(document).on('keypress',settings.messageEditor,function (e) {
            if (e.which == 13||e.keyCode==13) {
                
                if(!$(settings.messageEditor)[0].checkValidity()){
                    $(settings.messageEditor)[0].reportValidity();
                }else{
                    var shopperMsg =$(settings.messageEditor).val();
                    if(shopperMsg != ""){
                        wpwAction.shopper(wpwKits.htmlTagsScape(shopperMsg));
                        $(settings.messageEditor).val('');
                    }
                }
                
                
                
            }
        });
        //Click on the wildcards to select a service
        $(document).on('click','.qcld-chatbot-wildcard',function(){
            var wildcardData=$(this).attr('data-wildcart');
            var shooperChoice=$(this).text();
            wpwMsg.shopper_choice(shooperChoice);
            //Wild cards handling for bot.
            if(wildcardData=='product'){
                
                globalwpw.wildCard=20;
                globalwpw.productStep='asking'
                wpwAction.bot('from wildcard product');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("productStep", globalwpw.productStep);
            }
            if(wildcardData=='catalog'){
                wpwAction.bot(globalwpw.settings.obj.sys_key_catalog.toLowerCase());
            }
            if(wildcardData=='featured'){
                globalwpw.wildCard=20;
                globalwpw.productStep='featured'
                wpwAction.bot('from wildcard product');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("productStep", globalwpw.productStep);
            }
            if(wildcardData=='sale'){
                globalwpw.wildCard=20;
                globalwpw.productStep='sale'
                wpwAction.bot('from wildcard product');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("productStep", globalwpw.productStep);
            }
            if(wildcardData=='order'){
                globalwpw.wildCard=21;
                globalwpw.orderStep='welcome';
                wpwAction.bot('from wildcard order');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("orderStep", globalwpw.orderStep);
            }
            if(wildcardData=='support'){
                globalwpw.wildCard=1;
                globalwpw.supportStep='welcome';
                wpwAction.bot('from wildcard support');
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("supportStep", globalwpw.supportStep);

            }
            if(wildcardData=='back'){
                globalwpw.wildCard=0;
                wpwAction.bot(globalwpw.settings.obj.sys_key_help.toLowerCase());
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
            }

            if(wildcardData=='messenger'){
                var url='https://www.messenger.com/t/'+globalwpw.settings.obj.fb_page_id;
                var win = window.open(url, '_blank');
                win.focus();
            }
            if(wildcardData=='whatsapp'){
                var url='https://api.whatsapp.com/send?phone='+globalwpw.settings.obj.whats_num;
                var win = window.open(url, '_blank');
                win.focus();
            }

        });

        $(document).on('click','.qcld-chatbot-form',function(e){
            e.preventDefault();
            var formid=$(this).attr('data-form');
            globalwpw.wildCard=7;
            globalwpw.formStep='welcome';
            wpwTree.formbuilder(formid);
        })

        $(document).on('click','.qcld-chatbot-formanswer',function(e){
            e.preventDefault();
            var answer=$(this).attr('data-form-value');
            wpwTree.formbuilder(answer);
        })


        //
        $(document).on('click','.qcld-chatbot-product-category',function(){
            var catType=$(this).attr('data-category-type');
            var shopperChoiceCatId=$(this).text()+'#'+$(this).attr('data-category-id');
            var shopperChoiceCategory=$(this).text();
            if(catType=='hasChilds'){
                //Now hide all categories but shopper choice.
                wpwMsg.shopper_choice(shopperChoiceCategory);
                //updating the product steps and bringing the product by category.
                wpwKits.subCats($(this).attr('data-category-id'));
                globalwpw.productStep='search';
                globalwpw.wildCard=20;
            }else{
                //Now hide all categories but shopper choice.
                wpwMsg.shopper_choice(shopperChoiceCategory);
                //updating the product steps and bringing the product by category.
                globalwpw.productStep='category';
                globalwpw.wildCard=20;
                //keeping value in localstorage
                localStorage.setItem("productStep",  globalwpw.productStep);
                wpwAction.bot(shopperChoiceCatId);
            }

        });
        //Product Load More features for product search or category products
        $(document).on('click','#wp-chatbot-loadmore',function (e) {
            $('#wp-chatbot-loadmore-loader').html('<img class="wp-chatbot-comment-loader" src="'+globalwpw.settings.obj.image_path+'loadmore.gif" alt="..." />');
            var loadMoreDom=$(this);
            var productOffest=loadMoreDom.attr('data-offset');
            var searchType=loadMoreDom.attr('data-search-type');
            var searchTerm=loadMoreDom.attr('data-search-term');
            var data = { 'action': 'qcld_wb_chatbot_load_more','offset': productOffest,'search_type': searchType,'search_term': searchTerm};
            //Load more ajax handler.
            wpwKits.ajax(data).done(function (response) {
                //Change button text
                $('#wp-chatbot-loadmore-loader').html('');
                $('.wp-chatbot-products').append(response.html);
                loadMoreDom.attr('data-search-term',response.search_term);
                wpwKits.wpwHistorySave();
                loadMoreDom.attr('data-offset',response.offset);
                if(response.product_num <= response.per_page){
                    loadMoreDom.hide();
                    //Now show the user infinite.
                    setTimeout(function () {
                        var searchAgain = wpwKits.randomMsg(globalwpw.settings.obj.product_infinite);
                        wpwMsg.single(searchAgain);
                        globalwpw.productStep='search';
                        //keeping value in localstorage
                        localStorage.setItem("productStep",  globalwpw.productStep);
                    },globalwpw.settings.wildcardsShowTime);

                }
                //scroll to the last message
                wpwKits.scrollTo();
            });
        });

        $(document).on('click','.wp-chatbot-loadmore-saas',function (e) {
            $('.wp-chatbot-loadmore-loader').html('<img class="wp-chatbot-comment-loader" src="'+globalwpw.settings.obj.image_path+'loadmore.gif" alt="..." />');
            var loadMoreDom=$(this);
            var page=loadMoreDom.attr('data-page');
            var keyword=loadMoreDom.attr('data-keyword');
            var data = { 'action': 'qcld_wb_chatbot_load_more_saas','page': page,'keyword': keyword};
            //Load more ajax handler.
            wpwKits.ajax(data).done(function (response) {

                var response=$.parseJSON(response);
                //Change button text
                $('.wp-chatbot-loadmore-loader').html('');
                $('.wpb-search-result').append(response.html);
                loadMoreDom.attr('data-keyword',response.keyword);
                wpwKits.wpwHistorySave();
                loadMoreDom.attr('data-page',response.page);
                if(response.product_num <= response.per_page){
                    loadMoreDom.hide();
                    //Now show the user infinite.
                    setTimeout(function () {
                        var searchAgain = wpwKits.randomMsg(globalwpw.settings.obj.product_infinite);
                        wpwMsg.single(searchAgain);
                        globalwpw.productStep='search';
                        //keeping value in localstorage
                        localStorage.setItem("productStep",  globalwpw.productStep);
                    },globalwpw.settings.wildcardsShowTime);

                }
                //scroll to the last message
                wpwKits.scrollTo();
            });
        });


        /*Products details part **/
        if(globalwpw.settings.obj.open_product_detail!=1 && globalwpw.settings.obj.woocommerce){
        $(document).on('click','.wp-chatbot-product a',function (e) {
             e.preventDefault();
            $('.wp-chatbot-product-container').addClass('active-chatbot-product-details');
            $('.wp-chatbot-product-reload').addClass('wp-chatbot-product-loading').html('<img class="wp-chatbot-product-loader" src="'+globalwpw.settings.obj.image_path+'comment.gif" alt="Loading..." />');
            var productId=$(this).attr('wp-chatbot-pid');
            var data = { 'action':'qcld_wb_chatbot_product_details', 'wp_chatbot_pid':productId};
            //product details ajax handler.
            wpwKits.ajax(data).done(function (response) {
                $('.wp-chatbot-product-reload').removeClass('wp-chatbot-product-loading').html('');
                $('#wp-chatbot-product-title').html(response.title);
                $('#wp-chatbot-product-description').html(response.description);
                $('#wp-chatbot-product-image').html(response.image);
                $('#wp-chatbot-product-price').html(response.price);
                $('#wp-chatbot-product-quantity').html(response.quantity);
                $('#wp-chatbot-product-variable').html(response.variation);
                $('#wp-chatbot-product-cart-button').html(response.buttton);
                //Load gallery magnify
                setTimeout(function () {
                    $('#wp-chatbot-product-image-large-path').magnificPopup({type:'image'});
                },1000);

                //For shortcode handle recenlty view product by ajax as
                if($('#wp-chatbot-shortcode-template-container').length > 0){
                    var data = {'action':'qcld_wb_chatbot_recently_viewed_products'};
                    wpwKits.ajax(data).done(function (response) {
                        $('.wp-chatbot-product-shortcode-container').html(response);
                        $('.chatbot-sidebar .wp-chatbot-products').slimScroll({height: '435px', start: 'top'});
                    });
                }
            });

        });
        }
		
		$(document).on('click', '.wpb-quick-reply', function(e){
			e.preventDefault();
			$('#wp-chatbot-editor').val($(this).html());
			$('#wp-chatbot-send-message').trigger( "click" );
		})
		
        //Image gallery.
        $(document).on('click','.wp-chatbot-product-image-thumbs-path',function (e) {
            e.preventDefault();
            var imagePath=$(this).attr('href');
            $('#wp-chatbot-product-image-large-path').attr('href',imagePath);
            $('#wp-chatbot-product-image-large-src').attr('src',imagePath);
            //handle thumb active one
            $('.wp-chatbot-product-image-thumbs-path').parent().removeClass('wp-chatbot-product-active-image-thumbs');
            $(this).parent().addClass('wp-chatbot-product-active-image-thumbs');
        });
        //Product details close
        $(document).on('click', '.wp-chatbot-product-close', function (e) {
            $('.wp-chatbot-product-container').removeClass('active-chatbot-product-details');
        });
        /*add to cart part **/
        $(document).on("click","#wp-chatbot-add-cart-button",function (e) {
            var pId=$(this).attr('wp-chatbot-product-id');
            var qnty=$("#vPQuantity").val();
            var data = {'action': 'qcld_wb_chatbot_add_to_cart','product_id': pId,'quantity': qnty };
            //add to cart ajax handler.
            wpwKits.ajax(data).done(function (response) {
                //Change button text
                if(response=="simple"){
                    //Showing cart.
                    wpwKits.showCart();
                    //handle the active tab on chat board.
                    $('.wp-chatbot-operation-option').each(function(){
                        if($(this).attr('data-option')=='cart'){
                            $(this).parent().addClass('wp-chatbot-operation-active');
                        }else{
                            $(this).parent().removeClass('wp-chatbot-operation-active');
                        }
                    });
                }
                //Hide the shortcode and chat ui product details.
                $('.wp-chatbot-product-container').removeClass('active-chatbot-product-details');
            });
        });
        //Add to cart operation for variable product.
        $(document).on('click','#wp-chatbot-variation-add-to-cart',function(event) {
            event.preventDefault();

            var pId=$(this).attr('wp-chatbot-product-id');
            var quanity=$('#vPQuantity').val();
            var variation_id=$(this).attr('variation_id');
            var attributes=new Array();
            $.each($("#wp-chatbot-variation-data select"), function(){
                var attribute = $(this).attr('name')+'#'+ $(this).find('option:selected').text();
                attributes.push(attribute);
            });
            var data = {
                'action': 'variable_add_to_cart',
                'p_id': pId,
                'quantity': quanity,
                'variations_id':variation_id,
                'attributes':attributes
            };
            //add to cart ajax handler.
            wpwKits.ajax(data).done(function (response) {
                //Change button text
                if(response=="variable"){
                    //Showing cart.
                    wpwKits.showCart();
                    //handle the active tab on chat board.
                    //handle the active tab on chat board.
                    $('.wp-chatbot-operation-option').each(function(){
                        if($(this).attr('data-option')=='cart'){
                            $(this).parent().addClass('wp-chatbot-operation-active');
                        }else{
                            $(this).parent().removeClass('wp-chatbot-operation-active');
                        }
                    });
                }
                //Hide the shortcode and chat ui product details.
                $('.wp-chatbot-product-container').removeClass('active-chatbot-product-details');
            });
        });

        //search load more
        $(document).on('click', '.wp-chatbot-loadmore', function(e){
            e.preventDefault();
            var obj = $(this);

            var keyword = obj.attr('data-keyword');
            var post_type = obj.attr('data-post_type');
            var page = obj.attr('data-page');
            obj.text('Loading...');
            var data = {'action':'wpbo_search_site_pagination','name':globalwpw.hasNameCookie,'keyword':keyword, 'type': post_type, 'page': page};
            wpwKits.ajax(data).done(function (res) {
                var json=$.parseJSON(res);
                if(json.status=='success'){
                    $('span[data-wildcart="back"]').remove();
                    
                    wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                    obj.remove();
                }else{
                    
                    if(globalwpw.counter == globalwpw.settings.obj.no_result_attempt_count || globalwpw.settings.obj.no_result_attempt_count == 0 ){
                        
                        wpwMsg.single(json.html);
                        if(globalwpw.settings.obj.disable_repeatative!=1){
                            setTimeout(function(){
                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                            },globalwpw.settings.preLoadingTime)
                        }
                        globalwpw.counter = 0;
                        
                    }else{
                        globalwpw.counter++;
                        wpwTree.df_reply(response);
                    }

                }
                globalwpw.wildCard=0;
            });


        })

        //search load more
        $(document).on('click', '.wp-chatbot-loadmore2', function(e){
            e.preventDefault();
            var obj = $(this);

            var keyword = obj.attr('data-keyword');
            
            var page = obj.attr('data-page');

            var search_type = obj.attr('data-search-type');
            obj.text('Loading...');

            if( search_type == 'default-wp-search' ){
                var data = {'action':'wpbo_default_search_pagination2','name':globalwpw.hasNameCookie,'keyword':keyword, 'page': page, search_type:'default-wp-search'};
            }else{
                var data = {'action':'wpbo_search_site_pagination2','name':globalwpw.hasNameCookie,'keyword':keyword, 'page': page};
            }
            wpwKits.ajax(data).done(function (res) {
                var json=$.parseJSON(res);
                if(json.status=='success'){
                    $('span[data-wildcart="back"]').remove();
                    
                    wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                    obj.remove();
                }else{
                    
                    if(globalwpw.counter == globalwpw.settings.obj.no_result_attempt_count || globalwpw.settings.obj.no_result_attempt_count == 0 ){
                        
                        wpwMsg.single(json.html);
                        if(globalwpw.settings.obj.disable_repeatative!=1){
                            setTimeout(function(){
                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                            },globalwpw.settings.preLoadingTime)
                        }
                        globalwpw.counter = 0;
                        
                    }else{
                        globalwpw.counter++;
                        wpwTree.df_reply(response);
                    }

                }
                globalwpw.wildCard=0;
            });


        });

        //fuzzy search load more
        $(document).on('click', '.wp-chatbot-fuse-loadmore', function(e){
            e.preventDefault();
            var obj = $(this);
            var keyword = obj.attr('data-keyword');
            var post_type = obj.attr('data-post_type');
            var page = obj.attr('data-page');
            obj.text('Loading...');
            var data = {'action':'wpbo_fuse_search_site_pagination','name':globalwpw.hasNameCookie,'keyword':keyword, 'type': post_type, 'page': page};
            wpwKits.ajax(data).done(function (res) {
                var json=$.parseJSON(res);
                if(json.status=='success'){
                    $('span[data-wildcart="back"]').remove();
                    
                    wpwMsg.single_nobg(json.html+'<span class="qcld-chatbot-wildcard qcld_back_to_start"  data-wildcart="back">' + wpwKits.randomMsg(globalwpw.settings.obj.back_to_start) + '</span>');
                    obj.remove();
                }else{
                    
                    if(globalwpw.counter == globalwpw.settings.obj.no_result_attempt_count || globalwpw.settings.obj.no_result_attempt_count == 0 ){
                        
                        wpwMsg.single(json.html);
                        if(globalwpw.settings.obj.disable_repeatative!=1){
                            setTimeout(function(){
                                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
                                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);
                            },globalwpw.settings.preLoadingTime)
                        }
                        globalwpw.counter = 0;
                        
                    }else{
                        globalwpw.counter++;
                        wpwTree.df_reply(response);
                    }
                }
                globalwpw.wildCard=0;
            });
        });


        //Update cart.
        $(document).on("change", ".qcld-wp-chatbot-cart-item-qnty", function () {
            //Update editor only for chat ui
            if($('#wp-chatbot-shortcode-template-container').length == 0) {
                wpwKits.disableEditor(wpwKits.randomMsg(globalwpw.settings.obj.cart_updating));
            }
            var currentItem=$(this);
            setTimeout(function () {
                var item_key=currentItem.attr('data-cart-item');
                var qnty=currentItem.val();
                var data = {'action': 'qcld_wb_chatbot_update_cart_item_number','cart_item_key':item_key,'qnty':qnty};
                wpwKits.ajax(data).done(function () {
                    //Showing cart.
                    wpwKits.showCart();
                });
            }, globalwpw.settings.preLoadingTime);
        });
        //remove the cart item from global cart.
        $(document).on("click", ".wp-chatbot-remove-cart-item", function () {
            //Update editor only for chat ui
            if($('#wp-chatbot-shortcode-template-container').length == 0) {
                wpwKits.disableEditor(wpwKits.randomMsg(globalwpw.settings.obj.cart_removing));
            }
            var item=$(this).attr('data-cart-item');
            var data = {'action': 'qcld_wb_chatbot_cart_item_remove', 'cart_item':item };
            wpwKits.ajax(data).done(function () {
                //Showing cart.
                wpwKits.showCart();
            })
        });

        /*Support query answering.. **/
        $(document).on('click','.qcld-chatbot-support-items',function (e) {
            var shopperChoose=$(this).text();
            var queryIndex=$(this).attr('data-query-index');
            wpwMsg.shopper_choice(shopperChoose);
            //Now answering the query.
            var queryAns=globalwpw.settings.obj.support_ans[queryIndex];
            wpwMsg.single(queryAns);
            //Asking email after showing answer.
            var orPhoneSuggest='';
            setTimeout(function(){
                if(globalwpw.settings.obj.call_sup!=1) {
                    orPhoneSuggest = '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
                }
                var orEmailSuggest='<span class="qcld-chatbot-suggest-email">'+wpwKits.randomMsg(globalwpw.settings.obj.support_email)+'</span>';
                if(globalwpw.settings.obj.disable_repeatative!=1){
                    wpwKits.suggestEmail(orPhoneSuggest+orEmailSuggest);
                }
            },globalwpw.settings.wildcardsShowTime);
        });
        /*Support Email **/
        $(document).on('click','.qcld-chatbot-suggest-email',function (e) {
            var shopperChoice=$(this).text();
            wpwMsg.shopper_choice(shopperChoice);
            //Then ask email address
            if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
                var shopperName=  globalwpw.settings.obj.shopper_demo_name;
            }else{
                var shopperName=globalwpw.hasNameCookie;
            }
            var askEmail=globalwpw.settings.obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(globalwpw.settings.obj.asking_email);
            wpwMsg.single(askEmail);
            //Now updating the support part as .
            globalwpw.supportStep='email';
            globalwpw.wildCard=1;
            //keeping value in localstorage
            localStorage.setItem("wildCard",  globalwpw.wildCard);
            localStorage.setItem("supportStep",  globalwpw.supportStep);

        });
		
		
        /*Support Phone **/
        $(document).on('click','.qcld-chatbot-suggest-phone',function (e) {
            var shopperChoice=$(this).text();
            wpwMsg.shopper_choice(shopperChoice);
            //Then ask email address
            if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
                var shopperName=  globalwpw.settings.obj.shopper_demo_name;
            }else{
                var shopperName=globalwpw.hasNameCookie;
            }
            var askEmail=globalwpw.settings.obj.hello+' '+shopperName+'! '+ wpwKits.randomMsg(globalwpw.settings.obj.asking_phone);
            setTimeout(function(){
                wpwMsg.single(askEmail);
                //Now updating the support part as .
                globalwpw.supportStep='phone';
                globalwpw.wildCard=1;
                //keeping value in localstorage
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("supportStep",  globalwpw.supportStep);
            },1000)
            

        });
		
		$(document).on('click','.wpbd_subscription',function (e) {
			 var shopperChoice=$(this).text();
			 wpwMsg.shopper_choice(shopperChoice);
			globalwpw.wildCard=3;
			globalwpw.subscriptionStep='welcome';
			wpwTree.subscription(shopperChoice);

        });
		/* support Search */
		
		$(document).on('click','.qcld-chatbot-site-search',function (e) {
            var shopperChoice=$(this).text();
            wpwMsg.shopper_choice(shopperChoice);
            //Then ask email address
            if(typeof(globalwpw.hasNameCookie)=='undefined'|| globalwpw.hasNameCookie==''){
                var shopperName=  globalwpw.settings.obj.shopper_demo_name;
            }else{
                var shopperName=globalwpw.hasNameCookie;
            }
			var askEmail= wpwKits.randomMsg(globalwpw.settings.obj.asking_search_keyword)
			
            wpwMsg.single(askEmail.replace("#name", shopperName));
            //Now updating the support part as .
            globalwpw.supportStep='search';
            globalwpw.wildCard=1;
            //keeping value in localstorage
            localStorage.setItem("wildCard",  globalwpw.wildCard);
            localStorage.setItem("supportStep",  globalwpw.supportStep);

        });
		$(document).on('click','.wpbo_live_chat',function (e) {
			e.preventDefault();
			wpwKits.wpwOpenWindow(globalwpw.settings.obj.livechatlink,'Testing', 400, 600);
        });

		$(document).on('click','#wpbot_live_chat_floating_btn',function (e) {
			e.preventDefault();
            if(globalwpw.settings.obj.is_livechat_active){
                $('#wp-chatbot-editor').val(globalwpw.settings.obj.sys_key_livechat);
			    $('#wp-chatbot-send-message').trigger( "click" );
            }else{
                wpwKits.wpwOpenWindow(globalwpw.settings.obj.livechatlink,'Testing', 400, 600);
            }
            

        });
        
        $(document).on('click', '.qcld-chatbot-checkbox', function(){
            var value = [];
            $('.qcld-chatbot-checkbox').each(function(){

                if($(this).prop("checked") == true){
                    value.push($(this).val());
                }

            })

           $('#wp-chatbot-editor').val(value.join());

        })

		$(document).on('click','.qcld-chatbot-custom-intent',function (e) {
			var shopperChoice=$(this).attr('data-text');
			$('#wp-chatbot-editor').val(shopperChoice);
			$('#wp-chatbot-send-message').trigger( "click" );
        });

        $(document).on('click','.qcld-chatbot-buttonlink',function (e) {
            e.stopPropagation();
            e.preventDefault();
            var btnlink=$(this).attr('data-link');
            var target = $(this).attr('data-target')
            if(btnlink!=''){
                if(target==1){
                    window.open(btnlink);
                }else{
                    window.location.href = btnlink;
                }
    
            }
            
            return false;
        });

        
		
        //Show chat,cart and recently view products by click event.
        $(document).on('click','.wp-chatbot-operation-option',function (e) {
            e.preventDefault();
            var oppt=$(this).attr('data-option');
            if(oppt=='recent'  && globalwpw.wpwIsWorking==0){
                wpwKits.disableEditor(globalwpw.settings.obj.sys_key_product);
                var data = {'action':'qcld_wb_chatbot_recently_viewed_products'};
                wpwKits.ajax(data).done(function (response) {
                    $(globalwpw.settings.messageWrapper).html(response);
                });
                //First remove wp-chatbot-operation-active class from all selector
                $('.wp-chatbot-operation-option').parent().removeClass('wp-chatbot-operation-active');
                //then add the active class to current element.
                $(this).parent().addClass('wp-chatbot-operation-active');
            }else if(oppt=='chat' && globalwpw.wpwIsWorking==0){
                $(globalwpw.settings.messageWrapper).html(localStorage.getItem("wpwHitory"));
                wpwKits.scrollTo();
                wpwKits.enableEditor(wpwKits.randomMsg(globalwpw.settings.obj.send_a_msg));
                //First remove wp-chatbot-operation-active class from all selector
                $('.wp-chatbot-operation-option').parent().removeClass('wp-chatbot-operation-active');
                //then add the active class to current element.
                $(this).parent().addClass('wp-chatbot-operation-active');
                $('#wp-chatbot-editor').removeAttr('type');
                $(globalwpw.settings.messageLastChild).fadeOut();
                globalwpw.wildCard=0;
                var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.wildcard_msg);
                wpwMsg.double_nobg(serviceOffer,globalwpw.wildcards);

            } else if(oppt=='cart' && globalwpw.wpwIsWorking==0){
                wpwKits.showCart();
                //First remove wp-chatbot-operation-active class from all selector
                $('.wp-chatbot-operation-option').parent().removeClass('wp-chatbot-operation-active');
                //then add the active class to current element.
                $(this).parent().addClass('wp-chatbot-operation-active');
            } else if(oppt=='help' && globalwpw.wpwIsWorking==0){
                if( $('.wp-chatbot-messages-container').length==0) {
                    //if from other nob then goo to the chat window
                    $(globalwpw.settings.messageWrapper).html(localStorage.getItem("wpwHitory"));
                    //Showing help message
                    setTimeout(function () {
                        wpwKits.scrollTo();
                        var helpWelcome = wpwKits.randomMsg(globalwpw.settings.obj.help_welcome);
                        var helpMsg = wpwKits.randomMsg(globalwpw.settings.obj.help_msg);
                        wpwMsg.double(helpWelcome,helpMsg);
                        //dialogflow
                        if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
                            globalwpw.wildCard=0;
                            globalwpw.ai_step=1;
                            localStorage.setItem("wildCard",  globalwpw.wildCard);
                            localStorage.setItem("aiStep", globalwpw.ai_step);
                        }
                    },globalwpw.settings.preLoadingTime);
                }else{
                    //Showing help message on chat self window.
                    var helpWelcome = wpwKits.randomMsg(globalwpw.settings.obj.help_welcome);
                    var helpMsg = wpwKits.randomMsg(globalwpw.settings.obj.help_msg);
                    wpwMsg.double(helpWelcome,helpMsg);
                    //dialogflow
                    if(globalwpw.settings.obj.ai_df_enable==1 && globalwpw.df_status_lock==0){
                        globalwpw.wildCard=0;
                        globalwpw.ai_step=1;
                        localStorage.setItem("wildCard",  globalwpw.wildCard);
                        localStorage.setItem("aiStep", globalwpw.ai_step);
                    }
                }
                //First remove wp-chatbot-operation-active class from all selector
                $('.wp-chatbot-operation-option').parent().removeClass('wp-chatbot-operation-active');
                //then add the active class to current element.
                $(this).parent().addClass('wp-chatbot-operation-active');

            } else if(oppt=='support' && globalwpw.wpwIsWorking==0){
				
				var support_wildcards = '';
				
			
			
				if(globalwpw.settings.obj.livechat=='1' && !globalwpw.settings.obj.is_livechat_active) {
					support_wildcards += '<span class="qcld-chatbot-default wpbo_live_chat" >'+globalwpw.settings.obj.livechat_button_label+'</span>';
				}

				if(globalwpw.settings.obj.disable_feedback=='') {
					support_wildcards += '<span class="qcld-chatbot-suggest-email">'+globalwpw.settings.obj.send_us_email+'</span>';
				}
				if(globalwpw.settings.obj.disable_leave_feedback=='') {
					support_wildcards += '<span class="qcld-chatbot-suggest-email wpbd_feedback">'+globalwpw.settings.obj.leave_feedback+'</span>';
				}
				
				if(globalwpw.settings.obj.call_gen=="") {
					support_wildcards += '<span class="qcld-chatbot-suggest-phone" >' + globalwpw.settings.obj.support_phone + '</span>';
				}
				
				
				var serviceOffer=wpwKits.randomMsg(globalwpw.settings.obj.support_option_again);
				wpwMsg.double_nobg(serviceOffer,support_wildcards);
            }else if(oppt=='live-chat' && globalwpw.wpwIsWorking==0){
				if($('#wbca_signup_fullname').length>0){
					if(localStorage.getItem('shopper')!==null){
						$('#wbca_signup_fullname').val(localStorage.getItem('shopper'));
					}
					if(localStorage.getItem('shopperemail')!==null){
						$('#wbca_signup_email').val(localStorage.getItem('shopperemail'));
					}
				}
				$("#wp-chatbot-board-container").removeClass('active-chat-board');
				$('.wp-chatbot-container').hide();
				$('.wpbot-saas-live-chat').show();
			}
            //show chat wrapper and hide cart-checkout wrapper
            $(globalwpw.settings.messageWrapper).show();
            $('#wp-chatbot-checkout-short-code').hide();
            $('#wp-chatbot-cart-short-code').hide();


        });
		
        $(document).on('click','.qcld-chatbot-reset-btn',function (e) {
            e.preventDefault();
            var actionType=$(this).attr('reset-data');
            if(actionType=='yes'){
                $('#wp-chatbot-messages-container').html('');
                localStorage.removeItem('shopper');
                globalwpw.wildCard=0;
                globalwpw.ai_step=0;
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("aiStep", globalwpw.ai_step);

                globalwpw.formfieldid = '';
                localStorage.setItem("formfieldid",  globalwpw.formfieldid);
                globalwpw.formStep='welcome';
                localStorage.setItem("formStep",  globalwpw.formStep);
                globalwpw.formid='';
                localStorage.setItem("formid",  globalwpw.formid);
                globalwpw.formentry = 0;
                localStorage.setItem("formentry",  globalwpw.formentry);

                wpwWelcome.greeting();
            } else if(actionType=='no'){
                wpwAction.bot(globalwpw.settings.obj.sys_key_help.toLowerCase());
            }
        });

        $(document).on('click','#wp-chatbot-desktop-reload',function (e) {
            e.preventDefault();
                $('#wp-chatbot-editor').removeAttr('type');
                $('#wp-chatbot-messages-container').html('');
                localStorage.removeItem('shopper');
                globalwpw.wildCard=0;
                globalwpw.ai_step=0;
                localStorage.setItem("wildCard",  globalwpw.wildCard);
                localStorage.setItem("aiStep", globalwpw.ai_step);

                globalwpw.formfieldid = '';
                localStorage.setItem("formfieldid",  globalwpw.formfieldid);
                globalwpw.formStep='welcome';
                localStorage.setItem("formStep",  globalwpw.formStep);
                globalwpw.formid='';
                localStorage.setItem("formid",  globalwpw.formid);
                globalwpw.formentry = 0;
                localStorage.setItem("formentry",  globalwpw.formentry);

                wpwWelcome.greeting();

        });

        
		
		if(globalwpw.settings.obj.clear_cache==1){
			$('#wp-chatbot-messages-container').html('');
			localStorage.removeItem('shopper');
			globalwpw.wildCard=0;
			globalwpw.ai_step=0;
			localStorage.setItem("wildCard",  globalwpw.wildCard);
			localStorage.setItem("aiStep", globalwpw.ai_step);
			wpwWelcome.greeting();
		}
		
		$(document).on('click','.qcld_subscribe_confirm',function (e) {
            e.preventDefault();
            var actionType=$(this).attr('subscription');
            if(actionType=='yes'){
				globalwpw.wildCard=3;
				globalwpw.subscriptionStep = 'getname';
				wpwTree.subscription();
            } else if(actionType=='no'){
                wpwAction.bot(globalwpw.settings.obj.sys_key_help.toLowerCase());
            }
        });

        $(document).on('click','.qcld_unsubscribe_confirm',function (e) {
            e.preventDefault();
            var actionType=$(this).attr('unsubscription');
            if(actionType=='yes'){
				globalwpw.wildCard=6;
				globalwpw.unsubscriptionStep = 'getemail';
				wpwTree.unsubscription();
            } else if(actionType=='no'){
                wpwAction.bot(globalwpw.settings.obj.sys_key_help.toLowerCase());
            }
        });

        $(document).on('click','.qcld_unsubscribe_again',function (e) {
            e.preventDefault();
            
            globalwpw.wildCard=6;
            globalwpw.unsubscriptionStep = 'getemail';
            wpwTree.unsubscription();
            
        });
		
		
        return this;
    };
    //Deafault value for wpwbot.If nothing passes from the work station
    //Then defaults value will be used.
    $.wpwbot.defaults={
        obj:{},
        editor_handler:0,
        sendButton:'#wp-chatbot-send-message',
        messageEditor:'#wp-chatbot-editor',
        messageContainer:'#wp-chatbot-messages-container',
        messageWrapper:'.wp-chatbot-messages-wrapper',
        botContainer:'.wp-chatbot-ball-inner',
        messageLastChild:'#wp-chatbot-messages-container li:last',
        messageLastBot:'#wp-chatbot-messages-container .wp-chatbot-msg:last .wp-chatbot-paragraph',
        preLoadingTime:2000,
        wildcardsShowTime:5000,
    }

})(jQuery);



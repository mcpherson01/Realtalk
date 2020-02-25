var  njt_fb_pr_class = function()
{
    var self = this, $ = jQuery;
    self.current_spin_target = '';
    self.init = function()
    {
        /*
         * Enable emojioneArea
         */
        //self.setEmoji();

        self.getNewPostsClicked();

        self.addNewRuleGroupClicked();

        self.addNewAndRuleClicked();

        self.addRemoveAndRuleClicked();

        self.replyWhenChanged();

        self.normalReplyWhenChanged();

        self.sub_unsubscribePage();

        self.findPostBtnClick();

        self.switchContentTypeClicked();

        //page action
        self.removePageAction();
        //self.toggleReplyWhen($('input[name="_njt_fb_pr_reply_when"]').val());
        
        //spin thickbox
        self.spinThickboxAction();

    }
    self.spinThickboxAction = function()
    {
        //add new w
        $(document).on('click', '.njt_fb_pr_spin_add_w', function(event) {
            event.preventDefault();
            var $this = $(this);
            var w_template = $('#njt_fb_pr_spin_w_html').html();
            $this.closest('.njt_fb_pr_spin_w_row').find('.njt_fb_pr_spin_w_wrap').append(w_template);
        });
        //add new word
        $(document).on('click', '.njt_fb_pr_spin_add_word', function(event) {
            event.preventDefault();
            var word_template = $('#njt_fb_pr_spin_word_html').html();
            $('.njt_fb_pr_spin_word_wrap').append(word_template);
        });
        $('.njt_fb_pr_spin_insert_now').on('click', function(event) {
            event.preventDefault();
            var words = [];
            $('.njt_fb_pr_spin_word_wrap').find('.njt_fb_pr_spin_w_row').each(function(index, el) {
                var w = [];
                $(el).find('input.njt_fb_pr_spin_w').each(function(index2, el2) {
                    var _val = $(el2).val();
                    if (_val != '') {
                        w.push(_val);
                    }                    
                });
                words.push('{' + self.implode('|', w) + '}');
            });
            var str = '[spin]' + self.implode(' ', words) + '[/spin]';
            njt_fb_pr_shortcut_click(str, '#' + self.current_spin_target);
            $('.njt_fb_pr_spin_word_wrap').html($('#njt_fb_pr_spin_word_html').html());
            tb_remove();
        });
        $('.njt_fb_pr_spin_open_thickbox').click(function(event) {
            var $this = $(this);
            var ta = $this.data('target');
            self.current_spin_target = ta;
        });
    }
    self.removePageAction = function()
    {
        $('.njt-page-aciton-remove').click(function(event) {
            if (confirm(njt_fb_pr.are_you_sure)) {
                var $this = $(this);
                var s_page_id = $this.data('s_page_id');

                var data = {
                    'nonce' : njt_fb_pr.nonce,
                    'action': 'njt_fb_pr_remove_page',
                    's_page_id' : s_page_id
                };
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                })
                .done(function(json) {
                    if (json.success) {
                        $this.closest('.njt-page').remove();
                    } else {
                        alert(json.data.mess);
                    }
                })
                .fail(function() {
                    alert(njt_fb_pr.nonce_error);
                });
                return false;
            } else {
                return false;
            }
        });
    }
    self.switchContentTypeClicked = function()
    {
        $('._njt_fb_normal_pr_switch_reply_type').click(function(event) {
            var $this = $(this);
            var textarea = $this.data('textarea');
            var hidden_field = $this.data('hidden_field');
            var img_el = $this.data('img');

            if ($(hidden_field).val() == 'text') {
                $this.text($this.data('use_text'));
                $(textarea).closest('div').hide();
                $(img_el).show();
                $(hidden_field).val('photo');
            } else if ($(hidden_field).val() == 'photo') {
                $this.text($this.data('use_photo'));
                $(textarea).closest('div').show();
                $(img_el).hide();
                $(hidden_field).val('text');
            }

            return false;
        });

        $('._njt_fb_normal_pr_reply_content_img').click(function(event) {
            var $this = $(this);
            self.renderMediaUploader(function(img){
                $($this.data('textarea')).text(img);
                $this.attr('src', img);
            });
        });
    }
    self.renderMediaUploader = function(on_success)
    {
        'use strict';
        var file_frame;
            
        // If the media frame already exists, reopen it.
        if ( undefined !== file_frame ) {
            file_frame.open();
            return;
        }

        // Create a new media frame
        file_frame = wp.media({
            title: njt_fb_pr.add_media_text_title,
            button: {
                text: njt_fb_pr.add_media_text_button,
            },
            multiple: false
        });
        // When an image is selected in the media frame...
        file_frame.on('select', function() {
     
            var selection = file_frame.state().get('selection');                
            selection.map( function( attachment ) {                                    
                attachment = attachment.toJSON();
                //console.log(attachment);
                if ( attachment.id ) {
                    var file_choosed = attachment.url;
                    on_success(file_choosed);                
                }                
            });
        });
        file_frame.open();
    }
    self.setEmoji = function()
    {
        if ($('#_njt_fb_pr_reply_content').length) {
            $('#_njt_fb_pr_reply_content').emojioneArea({
                pickerPosition: 'bottom',
                hidePickerOnBlur: true
            });
        }
    }
    self.getNewPostsClicked = function()
    {
        $('.njt_fb_pr_get_posts').click(function(event) {
            var $this = $(this);
            $this.addClass('updating-message');
            var s_page_id = $this.data('s_page_id');
            var data = {
                'nonce' : njt_fb_pr.nonce,
                'action': 'njt_fb_pr_get_posts',
                's_page_id' : s_page_id
            };
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: data,
            })
            .done(function(json) {
                if (json.success) {
                    if (typeof json.data.next != 'undefined') {
                        self.getPostByFullUrl(json.data.next, json.data.fb_page_id, s_page_id);
                    } else {
                        location.reload();
                    }
                }
            })
            .fail(function() {
                console.log("error");
            });
            return false;
        });
    }
    self.getPostByFullUrl = function(url, fb_page_id, s_page_id)
    {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                'action': 'njt_fb_pr_get_posts_by_url',
                'url' : url,
                'fb_page_id' : fb_page_id,
                's_page_id' : s_page_id,
                'nonce' : njt_fb_pr.nonce
            },
        })
        .done(function(json) {
            if (json.success) {
                if (typeof json.data.next != 'undefined') {
                    self.getPostByFullUrl(json.data.next, fb_page_id, s_page_id);
                } else {
                    location.reload();
                }
            }
        })
        .fail(function() {
            alert(njt_fb_pr.nonce_error);
        });
        
    }
    self.addNewRuleGroupClicked = function()
    {
        $(document).on('click', '.njt-fb-pr-add-new-group', function(event) {
            event.preventDefault();
            var $this = $(this);
            var group_id = self.uniqid();
            var rule_id = self.uniqid();
            var input_name = $this.closest('.njt-fb-pr-row').find('.njt-fb-pr-list-groups').data('input_name');
            var this_group = $this.closest('.njt-fb-pr-row').find('.njt-fb-pr-list-groups');

            var group_template = njt_fb_pr.new_rule_group_template;
            group_template = self.str_replace('{group_id}', 'group_' + group_id, group_template);
            group_template = self.str_replace('{rule_id}', 'rule_' + rule_id, group_template);
            group_template = self.str_replace('{input_name}', input_name, group_template);
            this_group.append(group_template);

            return false;
        });
        
        
    }
    self.addNewAndRuleClicked = function()
    {
        $(document).on('click', '.njt_fb_pr_add_and_rule', function(event) {
            event.preventDefault();
            var $this = $(this);
            var current_rule_el = $this.closest('tr');

            var group_id = $this.closest('table').data('id');
            var rule_id = self.uniqid();
            var input_name = $this.closest('.njt-fb-pr-list-groups').data('input_name');

            var rule_template = njt_fb_pr.new_and_rule;
            rule_template = self.str_replace('{rule_id}', rule_id, rule_template);
            rule_template = self.str_replace('{group_id}', group_id, rule_template);
            rule_template = self.str_replace('{input_name}', input_name, rule_template);

            current_rule_el.after(rule_template);

            return false;
        });
    }
    self.addRemoveAndRuleClicked = function()
    {
        $(document).on('click', '.njt_fb_pr_remove_and_rule', function(event) {
            event.preventDefault();
            var $this = $(this);
            
            var this_group = $this.closest('.njt-fb-pr-list-groups');
            if (this_group.find('.njt_fb_pr_row_rule').length == 1) {
                alert(njt_fb_pr.at_least_one_condition_error);
                return false;
            }
            var $this = $(this);
            var current_rule_el = $this.closest('tr');

            var group = $this.closest('table');
            var group_id = group.data('id');

            current_rule_el.remove();
            if (group.find('.njt_fb_pr_row_rule').length == 0) {
                group.remove();
                $('.njt_fb_pr_group_or_title[data-for_group="'+group_id+'"]').remove();
            }
        });
    }
    self.replyWhenChanged = function()
    {
        $('input[name="_njt_fb_pr_reply_when"]').on('change', function(event) {
            event.preventDefault();
            var $this = $(this);
            var val = $this.val();
            if (val == 'if') {
                $this.closest('.njt-fb-pr-has-border').addClass('right');
            } else {
                $.each($('input[name="_njt_fb_pr_reply_when"]'), function(index, el) {
                    $(el).closest('.njt-fb-pr-has-border').removeClass('right');
                });
            }
            self.toggleReplyWhen(val);
        });
    }

    self.toggleReplyWhen = function(val)
    {
        if (val == 'anytime') {
            $('.njt-fb-pr-depends-on-replywhen').stop().hide();
        } else if(val == 'if') {
            $('.njt-fb-pr-depends-on-replywhen').stop().show();
        }
    }

    self.normalReplyWhenChanged = function()
    {
        $('input[name="_njt_fb_normal_reply_when"]').on('change', function(event) {
            event.preventDefault();
            var $this = $(this);
            var val = $this.val();
            if (val == 'anytime') {
                $.each($('input[name="_njt_fb_normal_reply_when"]'), function(index, el) {
                    $(el).closest('.njt-fb-pr-has-border').removeClass('right');
                });

                $('.njt-fb-normal-depends-on-replywhen').stop().hide();
            } else if(val == 'if') {
                $this.closest('.njt-fb-pr-has-border').addClass('right');
                $('.njt-fb-normal-depends-on-replywhen').stop().show();
            }
        });
    }

    self.sub_unsubscribePage = function()
    {
        $('.njt-fb-pr-subscribe-btn').click(function(event) {
            var $this = $(this);
            var s_page_id = $this.data('s_page_id');

            $this.addClass('updating-message');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {'action': 'njt_fb_pr_subscribe_page', 's_page_id' : s_page_id, 'nonce' : njt_fb_pr.nonce},
            })
            .done(function(json) {
                $this.removeClass('updating-message');
                if (json.success) {
                    $this.closest('.njt-page').find('.njt-fb-pr-subscribe-wrap').hide();
                    $this.closest('.njt-page').find('.njt-fb-pr-unsubscribe-wrap').show();
                } else {
                    alert(json.data.mess);
                }
            })
            .fail(function() {
                $this.removeClass('updating-message');
                console.log("error");
            });
            
        });

        $('.njt-fb-pr-unsubscribe-btn').click(function(event) {
            var $this = $(this);
            var s_page_id = $this.data('s_page_id');

            $this.addClass('updating-message');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {'action': 'njt_fb_pr_unsubscribe_page', 's_page_id' : s_page_id, 'nonce' : njt_fb_pr.nonce},
            })
            .done(function(json) {
                $this.removeClass('updating-message');
                if (json.success) {
                    $this.closest('.njt-page').find('.njt-fb-pr-subscribe-wrap').show();
                    $this.closest('.njt-page').find('.njt-fb-pr-unsubscribe-wrap').hide();
                } else {
                    alert(json.data.mess);
                }
            })
            .fail(function() {
                $this.removeClass('updating-message');
                console.log("error");
            });
            
        });
    }
    self.findPostBtnClick = function()
    {
        $('.njt_fb_pre_find_now').click(function(event) {
            var $this = $(this);
            var s_page_id = $this.data('s_page_id');
            var fb_post_url = $('#njt_fb_pr_findpost_tb_url').val().trim();

            //$('.njt_fb_pr_findpost_thickbox_inner').find('._result').remove();
            $this.addClass('updating-message');
            var data = {
                'action': 'njt_fb_pr_find_fb_post',
                's_page_id' : s_page_id,
                'url' : fb_post_url,
                'nonce' : njt_fb_pr.nonce
            };
            if (fb_post_url != '') {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                })
                .done(function(json) {
                    $this.removeClass('updating-message');
                    $('#njt_fb_pr_findpost_tb_url').val('');
                    if (json.success) {
                        //$('.njt_fb_pr_findpost_thickbox_inner').append(json.data.html)
                        if (confirm(njt_fb_pr.found_post_confirm)) {
                            location.replace(json.data.url);
                        }
                    } else {
                        alert(json.data.mess);
                    }
                })
                .fail(function() {
                    $this.removeClass('updating-message');
                    $('#njt_fb_pr_findpost_tb_url').val('');
                    console.log("error");
                });
                
            }           
        });
    }
    self.uniqid = function(prefix, more_entropy) {
      //  discuss at: http://phpjs.org/functions/uniqid/
      // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      //  revised by: Kankrelune (http://www.webfaktory.info/)
      //        note: Uses an internal counter (in php_js global) to avoid collision
      //        test: skip
      //   example 1: uniqid();
      //   returns 1: 'a30285b160c14'
      //   example 2: uniqid('foo');
      //   returns 2: 'fooa30285b1cd361'
      //   example 3: uniqid('bar', true);
      //   returns 3: 'bara20285b23dfd1.31879087'

      if (typeof prefix === 'undefined') {
        prefix = '';
      }

      var retId;
      var formatSeed = function(seed, reqWidth) {
        seed = parseInt(seed, 10)
          .toString(16); // to hex str
        if (reqWidth < seed.length) { // so long we split
          return seed.slice(seed.length - reqWidth);
        }
        if (reqWidth > seed.length) { // so short we pad
          return Array(1 + (reqWidth - seed.length))
            .join('0') + seed;
        }
        return seed;
      };

      // BEGIN REDUNDANT
      if (!this.php_js) {
        this.php_js = {};
      }
      // END REDUNDANT
      if (!this.php_js.uniqidSeed) { // init seed with big random int
        this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);
      }
      this.php_js.uniqidSeed++;

      retId = prefix; // start with prefix, add current milliseconds hex string
      retId += formatSeed(parseInt(new Date()
        .getTime() / 1000, 10), 8);
      retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string
      if (more_entropy) {
        // for more entropy we add a float lower to 10
        retId += (Math.random() * 10)
          .toFixed(8)
          .toString();
      }

      return retId;
    }
    self.implode = function(glue, pieces) {
      //  discuss at: http://phpjs.org/functions/implode/
      // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // improved by: Waldo Malqui Silva
      // improved by: Itsacon (http://www.itsacon.net/)
      // bugfixed by: Brett Zamir (http://brett-zamir.me)
      //   example 1: implode(' ', ['Kevin', 'van', 'Zonneveld']);
      //   returns 1: 'Kevin van Zonneveld'
      //   example 2: implode(' ', {first:'Kevin', last: 'van Zonneveld'});
      //   returns 2: 'Kevin van Zonneveld'

      var i = '',
        retVal = '',
        tGlue = '';
      if (arguments.length === 1) {
        pieces = glue;
        glue = '';
      }
      if (typeof pieces === 'object') {
        if (Object.prototype.toString.call(pieces) === '[object Array]') {
          return pieces.join(glue);
        }
        for (i in pieces) {
          retVal += tGlue + pieces[i];
          tGlue = glue;
        }
        return retVal;
      }
      return pieces;
    }
    self.str_replace = function(search, replace, subject, count) {
      //  discuss at: http://phpjs.org/functions/str_replace/
      // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // improved by: Gabriel Paderni
      // improved by: Philip Peterson
      // improved by: Simon Willison (http://simonwillison.net)
      // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // improved by: Onno Marsman
      // improved by: Brett Zamir (http://brett-zamir.me)
      //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
      // bugfixed by: Anton Ongson
      // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
      // bugfixed by: Oleg Eremeev
      //    input by: Onno Marsman
      //    input by: Brett Zamir (http://brett-zamir.me)
      //    input by: Oleg Eremeev
      //        note: The count parameter must be passed as a string in order
      //        note: to find a global variable in which the result will be given
      //   example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
      //   returns 1: 'Kevin.van.Zonneveld'
      //   example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
      //   returns 2: 'hemmo, mars'

      var i = 0,
        j = 0,
        temp = '',
        repl = '',
        sl = 0,
        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',
        sa = Object.prototype.toString.call(s) === '[object Array]';
      s = [].concat(s);
      if (count) {
        this.window[count] = 0;
      }

      for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
          continue;
        }
        for (j = 0, fl = f.length; j < fl; j++) {
          temp = s[i] + '';
          repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
          s[i] = (temp)
            .split(f[j])
            .join(repl);
          if (count && s[i] !== temp) {
            this.window[count] += (temp.length - s[i].length) / f[j].length;
          }
        }
      }
      return sa ? s : s[0];
    }
}
jQuery(document).ready(function($) {
    var njt_fb_pr_app = new njt_fb_pr_class()
    njt_fb_pr_app.init();
});
function njt_fb_pr_shortcut_click(shortcut, target)
{
    var cursorPos = jQuery(target).prop('selectionStart');
    var v = jQuery(target).val();
    var textBefore = v.substring(0,  cursorPos);
    var textAfter  = v.substring(cursorPos, v.length);

    jQuery(target).val(textBefore + shortcut + textAfter);

}
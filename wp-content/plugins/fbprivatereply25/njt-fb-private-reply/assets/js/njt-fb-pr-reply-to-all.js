var njt_fb_pr_reply_all = function()
{
    var self = this, $ = jQuery;

    /*
     * Global
     */
    var alias = 'njt_fbpr_reply_allcomments';
    var send_now_btn = '.'+alias+'_send_now';
    var send_again_btn = '.'+alias+'_send_again';
    var root_tb = '#' + alias;

    self.fb_post_id = '';
    self.page_token = '';

    self.public_mess = '';
    self.private_mess = '';

    self.comments = [];
    self.results = [];

    self.selected_posts = [];

    self.init = function(){
        /*
         * Reply again
         */
        $(document).on('click', send_again_btn, function(event) {
            event.preventDefault();
            if (confirm(njt_fb_pr.are_you_sure)) {
                self.afterSend(true);
                $('.'+alias+'_form_send').show();
                $('.'+alias+'_form_results').hide();
                $(send_again_btn).hide();
            }
        });
        /*
         * Gets posts
         */
        $('#njt-fbpr-reply-comment-get-posts').click(function(event) {
            var $this = $(this);
            var frm = $this.closest('form');
            //var m = frm.find('select[name="m"]').val();
            var from = frm.find('input[name="from"]').val();
            var to = frm.find('input[name="to"]').val();
            var s = frm.find('input[name="s"]').val();
            var s_page_id = frm.find('input[name="s_page_id"]').val();
            $this.addClass('updating-message');
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {'action': 'njt_fbpr_replycomments_getposts', 'nonce': njt_fb_pr.nonce, 'from': from, 'to': to, 's': s, 's_page_id' : s_page_id},
            })
            .done(function(json) {
                $this.removeClass('updating-message');
                if (json.success) {
                    frm.find('.njt-fbpr-reply-comment-results-step1').html(json.data.html);
                    if (typeof json.data.html_form != 'undefined') {
                        frm.find('.njt-fbpr-reply-comment-results-step2').html(json.data.html_form);
                    }
                } else {
                    alert(json.mess);
                }
            })
            .fail(function() {
                $this.removeClass('updating-message');
                alert(njt_fb_pr.nonce_error);
            });
            return false;
        });
        /*
         * Choose Posts To Send
         */
        /*$(document).on('click', '.njt-fb-pr-reply-comment-btn-choose-posts', function(event) {
            event.preventDefault();
            $(this).closest('form').find('.njt-fb-pr-reply-comment-posts').show();
        });*/

        /*
         * Select posts to send
         */
        $(document).on('change', '.njt-fbpr-reply-comments-frm input[name="posts[]"]', function(event) {
            event.preventDefault();
            self.onCheckboxChanged();
        });
        /*
         * Send now :D
         */
        $(document).on('click', '.njt-fb-pr-reply-comment-btn-send-now', function(event) {
            event.preventDefault();
            var $this = $(this);

            self.public_mess = $('.njt-fbpr-reply-comments-frm #njt-fb-pr-reply-comment-public-content').val();
            self.private_mess = $('.njt-fbpr-reply-comments-frm #njt-fb-pr-reply-comment-private-content').val();
            if ((self.public_mess == '') && (self.private_mess == '')) {
                return false;
            } else {
                $this.addClass('updating-message');
                //reset first
                self.selected_posts = [];
                $.each($('.njt-fbpr-reply-comments-frm input[name="posts[]"]'), function(index, el) {
                    if ($(el).prop('checked') === true) {
                        self.selected_posts.push({
                            's_id': $(el).val(),
                            'fb_post_id': $(el).data('fb_post_id')
                        });
                    }
                });
                
                self.getCommentsAndReply(0, function(){
                    $this.removeClass('updating-message');
                });
            }
        });
        /*
         * Check all
         */
        $(document).on('change', '#checkall', function(event) {
            event.preventDefault();
            var $this = $(this);
            if ($this.prop('checked') === true) {
                $('.njt-fbpr-reply-comments-frm').find('input[name="posts[]"]').prop('checked', true);
            } else {
                $('.njt-fbpr-reply-comments-frm').find('input[name="posts[]"]').prop('checked', false);
            }
            self.onCheckboxChanged();
        });

        /*
         * Show / hide error logs
         */
        $(document).on('click', '.njt-fbpr-reply-comments-frm .post-result ul li strong a', function(event) {
            event.preventDefault();
            var $this = $(this);
            var log_el = $this.closest('li').find('.njt-fbpr-logs').stop().toggle();
            
        });
    }
    self.onCheckboxChanged = function()
    {
        var c = 0;
        $.each($('.njt-fbpr-reply-comments-frm input[name="posts[]"]'), function(index, el) {
            if ($(el).prop('checked') === true) {
                c++;
            }
        });
        var send_now_btn = $('.njt-fbpr-reply-comments-frm').find('.njt-fb-pr-reply-comment-btn-send-now');
        send_now_btn.text(self.str_replace('%s', c, send_now_btn.data('btn_title')));
    }
    self.getCommentsAndReply = function(post_index, on_totaly_finish)
    {
        if (typeof self.selected_posts[post_index] != 'undefined') {
            self.fb_post_id = self.selected_posts[post_index]['fb_post_id'];
            self.page_token = $('.njt-fbpr-reply-comments-frm input[name="page_token"]').val();

            self.comments = [];
            self.getComments('', function(){

            }, function(){
                self.getCommentsAndReply(post_index + 1, on_totaly_finish);
            });
        } else {
            on_totaly_finish();
        }
    }
    self.getComments = function(url, on_fail, on_finish)
    {
        $.ajax({
            url: ajaxurl,
            type: 'POST',                
            data: {
                'action': 'njt_fbpr_get_comments',
                'fb_post_id': self.fb_post_id,
                'page_token': self.page_token,
                'nonce': njt_fb_pr.nonce,
                'url': url
            },
        })
        .done(function(json) {
            if (json.success) {
                if (typeof json.data.comments != 'undefined') {
                    $.each(json.data.comments, function(k, v) {
                        self.comments.push(v);
                    });                    
                }
                if (typeof json.data.url != 'undefined') {
                    self.getComments(json.data.url, on_fail, on_finish);
                } else {
                    //begin sending
                    self.beforeSend();
                    self.replyComments(0, on_finish);
                }
            } else {
                alert(json.data.mess);
                on_fail();
            }
        })
        .fail(function() {
            console.log("error while getting conversations.");
        });
    }
    self.replyComments = function(index, on_finish)
    {
        if (self.comments.length > 0) {
            if (typeof self.comments[index] != 'undefined') {
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        'action': 'njt_fbpr_reply_comment',
                        'page_token': self.page_token,
                        'public_mess': self.public_mess,
                        'private_mess': self.private_mess,
                        'object_id': self.comments[index]['id'],
                        'nonce': njt_fb_pr.nonce
                    }
                })
                .done(function(json) {
                    if (typeof self.results[self.fb_post_id] == 'undefined') {
                        self.results[self.fb_post_id] = {
                            'public': {
                                'sent': 0,
                                'fail': 0,
                                'logs': []
                            },
                            'private': {
                                'sent': 0,
                                'fail': 0,
                                'logs': []
                            },
                        };
                    }
                    if (typeof json.public != 'undefined') {
                        if (json.public['success']) {
                            self.results[self.fb_post_id]['public']['sent'] += 1;
                            self.results[self.fb_post_id]['public']['logs'].push({'status' : 'success', 'name' : self.comments[index]['sender'], 'mess' : json.public['mess']});
                        } else {
                            self.results[self.fb_post_id]['public']['fail'] += 1;
                            self.results[self.fb_post_id]['public']['logs'].push({'status' : 'error', 'name' : self.comments[index]['sender'], 'mess' : json.public['mess']});
                        }
                    }
                    if (typeof json.private != 'undefined') {
                        if (json.private['success']) {
                            self.results[self.fb_post_id]['private']['sent'] += 1;
                            self.results[self.fb_post_id]['private']['logs'].push({'status' : 'success', 'name' : self.comments[index]['sender'], 'mess' : json.private['mess']});
                        } else {
                            self.results[self.fb_post_id]['private']['fail'] += 1;
                            self.results[self.fb_post_id]['private']['logs'].push({'status' : 'error', 'name' : self.comments[index]['sender'], 'mess' : json.private['mess']});
                        }
                    }
                    self.updateResults({
                        'fb_post_id': self.fb_post_id,
                    });
                    self.replyComments(index + 1, on_finish);
                })
                .fail(function() {
                    self.updateResults({
                        'fb_post_id': self.fb_post_id,
                    });
                    self.replyComments(index + 1, on_finish);
                });
                
            } else {
                //sending finish
                on_finish();
                self.afterSend(false);
            }
        } else {
            self.updateResults({
                'fb_post_id': self.fb_post_id,
            });
            on_finish();
            self.afterSend(false);
        }
    }
    self.updateResults = function(args)
    {
        //update info comment to post-row
        var row = $('.njt-fb-pr-reply-comment-posts').find('li.post-' + args['fb_post_id']);
        if (!row.find('.post-result').length) {
            row.append('<div class="post-result"></div>');
        }
        var result_template = row.closest('form').find('#njt-fb-pr-reply-comment-result-template').html();

        var comment_count = 0;
        var public_sent = 0;
        var public_fail = 0;
        var private_sent = 0;
        var private_fail = 0;
        if (typeof self.results[self.fb_post_id] != 'undefined') {
            comment_count = self.comments.length;

            var result = self.results[self.fb_post_id];
            console.log(result);
            public_sent = result['public']['sent'];
            public_fail = result['public']['fail'];
            private_sent = result['private']['sent'];
            private_fail = result['private']['fail'];
        }
        
        result_template = self.str_replace('%1', comment_count, result_template);//total comments
        result_template = self.str_replace('%2', public_sent, result_template);//public sent
        result_template = self.str_replace('%3', public_fail, result_template);//public fail
        result_template = self.str_replace('%4', private_sent, result_template);//private sent
        result_template = self.str_replace('%5', private_fail, result_template);//private fail
        row.find('.post-result').html(result_template);

        if (comment_count == 0) {
            row.find('.post-result').find('li.count').remove();
        } else {
            if ((public_sent == 0) && (public_fail == 0)) {
                row.find('.post-result').find('li.count-public-sent').remove();
                row.find('.post-result').find('li.count-public-fail').remove();
            }
            if ((private_sent == 0) && (private_fail == 0)) {
                row.find('.post-result').find('li.count-private-sent').remove();
                row.find('.post-result').find('li.count-private-fail').remove();
            }
            if (public_fail > 0) {
                row.find('.post-result').find('li.count-public-fail strong').html('<a href="#">'+public_fail+'</a>');
                var _log = '<div class="njt-fbpr-logs">';
                $.each(result['public']['logs'], function(index, el) {
                    if (el['status'] == 'error') {
                        _log += '<div>'+el.name+' : '+el.mess+'</div>';
                    }
                    
                });
                _log += '</div>';
                row.find('.post-result').find('li.count-public-fail').append(_log);
            }
            if (private_fail > 0) {
                row.find('.post-result').find('li.count-private-fail strong').html('<a href="#">'+private_fail+'</a>');
                var _log = '<div class="njt-fbpr-logs">';
                $.each(result['private']['logs'], function(index, el) {
                    if (el['status'] == 'error') {
                        _log += '<div>'+el.name+' : '+el.mess+'</div>';
                    }
                    
                });
                _log += '</div>';
                row.find('.post-result').find('li.count-private-fail').append(_log);
            }
        }

        /*$(root_tb + ' .dh-send-tb-result-sent strong').text(self.total_sent);
        $(root_tb + ' .dh-send-tb-result-fail strong').text(self.total_fail);

        var total_c = self.comments.length;
        var percent = ((self.total_sent + self.total_fail) * 100) / total_c;
        percent = Math.ceil(percent);
        $(root_tb + ' .dh-send-tb-meter').find('span').attr('style', 'width:' + percent + '%');
        $(root_tb + ' .dh-send-tb-meter').find('strong').text(percent + '%');

        $(root_tb + ' .dh-send-tb-details').html('');
        $.each(self.results, function(i, e) {
            $(root_tb + ' .dh-send-tb-details').append('<li data-status="'+e.status+'">'+e.name+' : '+ e.mess +'</li>');
        });*/

    }
    self.beforeSend = function()
    {
        
    }
    self.afterSend = function(reset_html)
    {
        self.resetVar();
        /*$('.njt_fb_mess_rc_send_again').show();
        $('#njt_fb_mess_reply_conversations_send_now').removeClass('updating-message');*/
        if (reset_html) {
            /*$(root_tb + ' .dh-send-tb-result-sent strong').text('0');
            $(root_tb + ' .dh-send-tb-result-fail strong').text('0');

            $(root_tb + ' .dh-send-tb-meter').find('span').attr('style', 'width:0%');
            $(root_tb + ' .dh-send-tb-meter').find('strong').text('0%');

            $(root_tb + ' .dh-send-tb-details').html('');*/
        }
    }
    self.resetVar = function()
    {
        self.comments = [];
        self.results = [];
        self.total_sent = 0;
        self.total_fail = 0;
    }
    self.openWindow = function(type, fb_post_id)
    {
        if (type == 'public') {

        } else if(type == 'private') {

        }
    }
    self.str_replace = function (search, replace, subject, count) {
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
    var njt_fb_pr_reply_all_app = new njt_fb_pr_reply_all();
    njt_fb_pr_reply_all_app.init();
});
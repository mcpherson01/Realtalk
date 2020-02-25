"use strict";
jQuery( document ).ready(function() {
    jQuery('#contentomatic_container').children().mouseover(function(e){
        jQuery(".contentomatic_hova").removeClass("contentomatic_hova");     
        jQuery(e.target).addClass("contentomatic_hova");
      return false;
    }).mouseout(function(e) {
        jQuery(this).removeClass("contentomatic_hova");
    });
});
var mastermind = document.getElementById('contentomatic_container');
if(mastermind != null)
{
    document.getElementById('contentomatic_container').onclick = function(event) {
        if (event===undefined) event = window.event;
        var target = 'target' in event? event.target : event.srcElement;
        var a = document.getElementById("contentomatic_crawl_type");
        var val = a.options[a.selectedIndex].value;
        if(val == 'class')
        {
            var path = getClassTo(target);
            var message = 'Element CLASS is: ' + path;
        }
        else 
        {
            if(val == 'id')
            {
                var path = getIdTo(target);
                var message = 'Element ID is: ' + path;
            }
            else
            {
                if(val == 'xpath')
                {
                    var path = getPathTo(target);
                    var message = 'Element XPATH is: ' + path;
                }
                else
                {
                    var path = getPathTo(target);
                    var message = '[?]Element XPATH is: ' + path;
                }
            }
        }
        alert(message);
        event.preventDefault();    
    }
}
function getPathTo(element) {
    if (element.id!=='')
    {
        if(element.id != 'contentomatic_container')
        {
            return "//*[@id='"+element.id+"']";
        }
        else
        {
            return '//body/*';
        }
    }
    var res = element.className;
    if (res !=='' && res != 'contentomatic_hova')
    {
        res = res.replace('contentomatic_hova ', "");
        res = res.replace(' contentomatic_hova ', " ");
        res = res.replace(' contentomatic_hova', "");
        if(res !== '' && res != ' ')
        {
            res = jQuery.trim(res);
            return "//*[@class='"+res+"']";
        }
    }
    var itempropz = element.getAttribute("itemprop");
    if (itempropz!=='' && itempropz!==null)
    {
        return "//*[@itemprop='"+itempropz+"']";
    }
    if (element===document.body)
    {
        return '//body/*';
    }
    return getPathTo(element.parentNode);
}
function getIdTo(element) {
    if (element.id!=='')
    {
        if(element.id != 'contentomatic_container')
        {
            return element.id;
        }
        else
        {
            return 'Id attribute not found for the clicked element. Please select another "Query Type" from the upper dropdown.';
        }
    }
    if (element===document.body)
    {
        return 'Id attribute not found for the clicked element. Please select another "Query Type" from the upper dropdown.';
    }
    return getIdTo(element.parentNode);
}
function getClassTo(element) {
    var res = element.className;
    if (res !=='' && res != 'contentomatic_hova')
    {
        res = res.replace('contentomatic_hova ', "");
        res = res.replace(' contentomatic_hova ', " ");
        res = res.replace(' contentomatic_hova', "");
        if(res !== '' && res != ' ')
        {
            res = jQuery.trim(res);
            return res;
        }
    }
    if (element===document.body)
    {
        return 'Class attribute not found for the clicked element. Please select another "Query Type" from the upper dropdown.';
    }
    return getClassTo(element.parentNode);
}
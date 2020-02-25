//set cookie
function setDCPACookie(name, value, maxAgeSeconds) {
	"use strict";
	
    var maxAgeSegment = "; max-age=" + maxAgeSeconds;
    document.cookie = encodeURI(name) + "=" + encodeURI(value) + maxAgeSegment + "; path=/";
}

// get cookie 
function getDCPACookie(name) {
	"use strict";
	
    var dc = document.cookie;
    var prefix = name + "=";
    var begin = dc.indexOf("; " + prefix);
    if (begin == -1) {
        begin = dc.indexOf(prefix);
        if (begin != 0) return null;
    }
    else
    {
        begin += 2;
        var end = document.cookie.indexOf(";", begin);
        if (end == -1) {
        end = dc.length;
        }
    }
    return decodeURI(dc.substring(begin + prefix.length, end));
} 

//progress
function updateDCPAProgress(top, bottom, col1, col2, range, time, skip, remaining, type, modal, adstime, afterads) {
	"use strict";
	
	if(getDCPACookie("padsTime") == null) {
	  var selectRange = range;
	  var selectRange2 = selectRange + 30;
	  
	  var percent = Math.ceil(top / bottom * 100) + '%';
	  var normal = Math.ceil(top / bottom * 100);
	  
	  document.getElementById('progressAd').style.width = percent;
	  if (modal == 1) {
		  
		  if (normal >= selectRange && normal <= selectRange2) { //if in range

				const element = document.querySelector("#progressModal");
				if(element.classList.contains("active") == false && element.classList.contains("clicked") == false){
					//if in ads
					element.classList.add('active');
					document.body.style.overflow = "hidden";
					document.querySelector("#progressAd").style.backgroundColor = col2;
				
				if (type == 2 ) {
					//if youtube style ad button
					var timeleft = time;
					var downloadTimer = setInterval(function(){
					  document.getElementById("progressSkipper").innerHTML = timeleft + " " + remaining;
					  timeleft--;
					  if(timeleft == -2){
						clearInterval(downloadTimer);
						document.getElementById("progressSkipper").innerHTML = skip;
							document.querySelector('.pClose').onclick = function() {
								if ( adstime > 0) {
									setDCPACookie("padsTime", "ads", adstime);
								}
								if ( afterads > 0 ) {
									document.querySelector("#progressContainer").style.display = "none";
								}
								element.classList.remove('active');
								element.classList.add('clicked');
								document.body.style.overflow = "visible";
								document.querySelector("#progressAd").style.backgroundColor = col1;
							}
					  }
					}, 1000);
				} else {
					//if normal close button
						document.querySelector('.pClose').onclick = function() {
						if ( adstime > 0) {
							setDCPACookie("padsTime", "ads", adstime);
						}
						if ( afterads > 0 ) {
							document.querySelector("#progressContainer").style.display = "none";
						}
						element.classList.remove('active');
						document.body.style.overflow = "visible";
						element.classList.add('clicked');
						document.querySelector("#progressAd").style.backgroundColor = col1;
					}
				}
			}
		}
	  }
	}
}
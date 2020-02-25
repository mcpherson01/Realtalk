(function() {
    function view(a) {
        if (typeof a.getBoundingClientRect !== 'function') {
            return false
        }
        var b = a.getBoundingClientRect();
        return (b.bottom + 50 >= 0 && b.right + 50 >= 0 && b.top - 50 <= (window.innerHeight || document.documentElement.clientHeight) && b.left - 50 <= (window.innerWidth || document.documentElement.clientWidth))
    }

    function show() {
        var el = document.querySelectorAll('[wpsol-iframe-lazyload]');
        for (var index in el) {
            if (view(el[index])) {
                el[index].onload = function() {
                    window.dispatchEvent(new Event('resize'));
                };
                el[index].setAttribute('src', (typeof el[index].dataset.wpsolsrc !== 'undefined' ? el[index].dataset.wpsolsrc : el[index].src));
                if (typeof el[index].dataset.wpsolsrcset !== 'undefined') {
                    el[index].setAttribute('srcset', el[index].dataset.wpsolsrcset);
                }
                if (typeof el[index].dataset.wpsolstyle !== 'undefined') {
                    el[index].setAttribute('style', el[index].dataset.wpsolstyle);
                }
                el[index].removeAttribute('wpsol-iframe-lazyload')
            }
        }
    }

    var fire = function() {
        window.removeEventListener("touchstart", fire);
        window.removeEventListener("scroll", fire);
        document.removeEventListener("mousemove", fire);
        window.requestAnimationFrame(show);
    };
    window.addEventListener("touchstart", fire, true);
    window.addEventListener("scroll", fire, true);
    document.addEventListener("mousemove", fire);
})();
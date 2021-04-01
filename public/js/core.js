var bread = {
    detectQueryString: function (url) {
        // regex pattern for detecting querystring
        var pattern = new RegExp(/\?.+=.*/g);
        return pattern.test(url);
    },
    removePerPage: function (url) {
        return url.replace(/[?&]perPage=.*[0-9]/g, '');
    },
    changePerPage: function (event) {
        event = event || window.event;
        var element = event.target;
        if (element) {
            var perPage = 'perPage=' + element.value;
            var prefix = '?';
            var base = window.location.href;
            base = bread.removePerPage(base);
            if (bread.detectQueryString(base)) {
                prefix = '&'
            }
            var redirect = `${base}${prefix}${perPage}`;
            window.location.href = redirect
        }
    },
    findParentByTagName: function (element, className) {
        var parent = element;
        while (parent !== null && parent.classList.value.indexOf(className) === -1) {
            parent = parent.parentElement;
        }
        return parent;
    },
    handleAnchorClick: function (event) {
        event = event || window.event;
        var element = bread.findParentByTagName(event.target, "js-delete");
        if (element) {
            event.preventDefault();
            if (window.confirm("Do you really want to delete this item?")) {
                window.location.href = element.getAttribute("href");
            }
        }
    }
};

window.bread = bread;

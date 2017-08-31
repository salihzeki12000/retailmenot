<html lang="en-US" dir="ltr" class="no-js  ">
<!--<![endif]-->

<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# retailmenot: http://ogp.me/ns/fb/retailmenot#">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript">
        "use strict";
        (function(factory) {
            if (typeof window !== "undefined") {
                factory(window)
            } else if (typeof module === "object" && module.exports) {
                module.exports = factory
            } else {
                throw new Error("Unsupported environment: no window or module.exports")
            }
        })(function(root) {
            var fnToStr = Function.prototype.toString;
            var constructorRegex = /^\s*class /;

            function isES6ClassFn(value) {
                try {
                    var fnStr = fnToStr.call(value);
                    var singleStripped = fnStr.replace(/\/\/.*\n/g, "");
                    var multiStripped = singleStripped.replace(/\/\*[.\s\S]*\*\//g, "");
                    var spaceStripped = multiStripped.replace(/\n/gm, " ").replace(/ {2}/g, " ");
                    return constructorRegex.test(spaceStripped)
                } catch (e) {
                    return false
                }
            }

            function tryFunctionObject(value) {
                try {
                    if (isES6ClassFn(value)) {
                        return false
                    }
                    fnToStr.call(value);
                    return true
                } catch (e) {
                    return false
                }
            }
            var toStr = Object.prototype.toString;
            var fnClass = "[object Function]";
            var genClass = "[object GeneratorFunction]";
            var hasToStringTag = typeof Symbol === "function" && typeof Symbol.toStringTag === "symbol";

            function isCallable(value) {
                if (!value) {
                    return false
                }
                if (typeof value !== "function" && typeof value !== "object") {
                    return false
                }
                if (hasToStringTag) {
                    return tryFunctionObject(value)
                }
                if (isES6ClassFn(value)) {
                    return false
                }
                var strClass = toStr.call(value);
                return strClass === fnClass || strClass === genClass
            }

            function isPrimitive(input) {
                var type = typeof input;
                return input === null || type !== "object" && type !== "function"
            }

            function toPrimitive(input) {
                var val, valueOf, toStr;
                if (isPrimitive(input)) {
                    return input
                }
                valueOf = input.valueOf;
                if (isCallable(valueOf)) {
                    val = valueOf.call(input);
                    if (isPrimitive(val)) {
                        return val
                    }
                }
                toStr = input.toString;
                if (isCallable(toStr)) {
                    val = toStr.call(input);
                    if (isPrimitive(val)) {
                        return val
                    }
                }
                throw new TypeError
            }
            var months = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334, 365];

            function dayFromMonth(year, month) {
                var t = month > 1 ? 1 : 0;
                return months[month] + Math.floor((year - 1969 + t) / 4) - Math.floor((year - 1901 + t) / 100) + Math.floor((year - 1601 + t) / 400) + 365 * (year - 1970)
            }
            var isoDateExpression = new RegExp("^" + "(\\d{4}|[+-]\\d{6})" + "(?:-(\\d{2})" + "(?:-(\\d{2})" + "(?:" + "T(\\d{2})" + ":(\\d{2})" + "(?:" + ":(\\d{2})" + "(?:(\\.\\d{1,}))?" + ")?" + "(" + "Z|" + "(?:" + "([-+])" + "(\\d{2})" + ":(\\d{2})" + ")" + ")?)?)?)?" + "$");

            function isDateParseES5Compliant() {
                var brokenOnFirefox = !isNaN(root.Date.parse("2012-04-04T24:00:00.500Z"));
                var brokenOnIE10 = !isNaN(root.Date.parse("2012-12-31T24:01:00.000Z"));
                var brokenOnChrome = !isNaN(root.Date.parse("2011-02-29T12:00:00.000Z"));
                return !brokenOnFirefox && !brokenOnIE10 && !brokenOnChrome
            }

            function isDateToJSONES5Compliant() {
                try {
                    return root.Date.prototype.toJSON.call(new root.Date(NaN)) === null
                } catch (e) {
                    return false
                }
            }

            function isArraySortES5Compliant() {
                try {
                    root.Array.prototype.sort.call([1, 2], null);
                    return false
                } catch (enull) {}
                try {
                    root.Array.prototype.sort.call([1, 2], true);
                    return false
                } catch (etrue) {}
                try {
                    root.Array.prototype.sort.call([1, 2], {});
                    return false
                } catch (eobj) {}
                try {
                    root.Array.prototype.sort.call([1, 2], []);
                    return false
                } catch (earr) {}
                try {
                    root.Array.prototype.sort.call([1, 2], /a/g);
                    return false
                } catch (eregex) {}
                return true
            }

            function polyfillDateParse() {
                var originalParse = root.Date.parse;
                root.Date.parse = function(string) {
                    var match = isoDateExpression.exec(string);
                    if (match) {
                        var year = Number(match[1]),
                            month = Number(match[2] || 1) - 1,
                            day = Number(match[3] || 1) - 1,
                            hour = Number(match[4] || 0),
                            minute = Number(match[5] || 0),
                            second = Number(match[6] || 0),
                            millisecond = Math.floor(Number(match[7] || 0) * 1e3),
                            isLocalTime = Boolean(match[4] && !match[8]),
                            signOffset = match[9] === "-" ? 1 : -1,
                            hourOffset = Number(match[10] || 0),
                            minuteOffset = Number(match[11] || 0),
                            result;
                        var hasMinutesOrSecondsOrMilliseconds = minute > 0 || second > 0 || millisecond > 0;
                        if (hour < (hasMinutesOrSecondsOrMilliseconds ? 24 : 25) && minute < 60 && second < 60 && millisecond < 1e3 && month > -1 && month < 12 && hourOffset < 24 && minuteOffset < 60 && day > -1 && day < dayFromMonth(year, month + 1) - dayFromMonth(year, month)) {
                            result = ((dayFromMonth(year, month) + day) * 24 + hour + hourOffset * signOffset) * 60;
                            result = ((result + minute + minuteOffset * signOffset) * 60 + second) * 1e3 + millisecond;
                            if (isLocalTime) {
                                result = toUTC(result)
                            }
                            if (result >= -864e13 && result <= 864e13) {
                                return result
                            }
                        }
                        return NaN
                    }
                    return originalParse.apply(this, arguments)
                }
            }

            function polyfillDateToJSON() {
                root.Date.prototype.toJSON = function toJSON() {
                    var O = Object(this);
                    var tv = toPrimitive(O);
                    if (typeof tv === "number" && !isFinite(tv)) {
                        return null
                    }
                    var toISO = this.toISOString;
                    if (!isCallable(toISO)) {
                        throw new TypeError("toISOString property is not callable")
                    }
                    return toISO.call(O)
                }
            }

            function polyfillArraySort() {
                var arraySort = root.Array.prototype.sort;
                root.Array.prototype.sort = function sort(compareFn) {
                    if (typeof compareFn === "undefined") {
                        return arraySort.apply(this, arguments)
                    }
                    if (!isCallable(compareFn)) {
                        throw new TypeError("Array.prototype.sort callback must be a function")
                    }
                    return arraySort.apply(this, arguments)
                }
            }
            if (!isDateParseES5Compliant()) {
                polyfillDateParse()
            }
            if (!isDateToJSONES5Compliant()) {
                polyfillDateToJSON()
            }
            if (!isArraySortES5Compliant()) {
                polyfillArraySort()
            }
        });
    </script>

    <script type="text/javascript">
        ! function(a) {
            "use strict";
            "undefined" == typeof a && (a = {}), "undefined" == typeof a.performance && (a.performance = {}), a._perfRefForUserTimingPolyfill = a.performance, a.performance.userTimingJsNow = !1, a.performance.userTimingJsNowPrefixed = !1, a.performance.userTimingJsUserTiming = !1, a.performance.userTimingJsUserTimingPrefixed = !1, a.performance.userTimingJsPerformanceTimeline = !1, a.performance.userTimingJsPerformanceTimelinePrefixed = !1;
            var b, c, d = [],
                e = [],
                f = null;
            if ("function" != typeof a.performance.now) {
                for (a.performance.userTimingJsNow = !0, e = ["webkitNow", "msNow", "mozNow"], b = 0; b < e.length; b++)
                    if ("function" == typeof a.performance[e[b]]) {
                        a.performance.now = a.performance[e[b]], a.performance.userTimingJsNowPrefixed = !0;
                        break
                    }
                var g = +new Date;
                a.performance.timing && a.performance.timing.navigationStart && (g = a.performance.timing.navigationStart), "function" != typeof a.performance.now && (Date.now ? a.performance.now = function() {
                    return Date.now() - g
                } : a.performance.now = function() {
                    return +new Date - g
                })
            }
            var h = function() {},
                i = function() {},
                j = [],
                k = !1,
                l = !1;
            if ("function" != typeof a.performance.getEntries || "function" != typeof a.performance.mark) {
                for ("function" == typeof a.performance.getEntries && "function" != typeof a.performance.mark && (l = !0), a.performance.userTimingJsPerformanceTimeline = !0, d = ["webkit", "moz"], e = ["getEntries", "getEntriesByName", "getEntriesByType"], b = 0; b < e.length; b++)
                    for (c = 0; c < d.length; c++) f = d[c] + e[b].substr(0, 1).toUpperCase() + e[b].substr(1), "function" == typeof a.performance[f] && (a.performance[e[b]] = a.performance[f], a.performance.userTimingJsPerformanceTimelinePrefixed = !0);
                h = function(a) {
                    j.push(a), "measure" === a.entryType && (k = !0)
                };
                var m = function() {
                    k && (j.sort(function(a, b) {
                        return a.startTime - b.startTime
                    }), k = !1)
                };
                if (i = function(a, c) {
                        for (b = 0; b < j.length;) j[b].entryType === a && ("undefined" == typeof c || j[b].name === c) ? j.splice(b, 1) : b++
                    }, "function" != typeof a.performance.getEntries || l) {
                    var n = a.performance.getEntries;
                    a.performance.getEntries = function() {
                        m();
                        var b = j.slice(0);
                        return l && n && (Array.prototype.push.apply(b, n.call(a.performance)), b.sort(function(a, b) {
                            return a.startTime - b.startTime
                        })), b
                    }
                }
                if ("function" != typeof a.performance.getEntriesByType || l) {
                    var o = a.performance.getEntriesByType;
                    a.performance.getEntriesByType = function(c) {
                        if ("undefined" == typeof c || "mark" !== c && "measure" !== c) return l && o ? o.call(a.performance, c) : [];
                        "measure" === c && m();
                        var d = [];
                        for (b = 0; b < j.length; b++) j[b].entryType === c && d.push(j[b]);
                        return d
                    }
                }
                if ("function" != typeof a.performance.getEntriesByName || l) {
                    var p = a.performance.getEntriesByName;
                    a.performance.getEntriesByName = function(c, d) {
                        if (d && "mark" !== d && "measure" !== d) return l && p ? p.call(a.performance, c, d) : [];
                        "undefined" != typeof d && "measure" === d && m();
                        var e = [];
                        for (b = 0; b < j.length; b++)("undefined" == typeof d || j[b].entryType === d) && j[b].name === c && e.push(j[b]);
                        return l && p && (Array.prototype.push.apply(e, p.call(a.performance, c, d)), e.sort(function(a, b) {
                            return a.startTime - b.startTime
                        })), e
                    }
                }
            }
            if ("function" != typeof a.performance.mark) {
                for (a.performance.userTimingJsUserTiming = !0, d = ["webkit", "moz", "ms"], e = ["mark", "measure", "clearMarks", "clearMeasures"], b = 0; b < e.length; b++)
                    for (c = 0; c < d.length; c++) f = d[c] + e[b].substr(0, 1).toUpperCase() + e[b].substr(1), "function" == typeof a.performance[f] && (a.performance[e[b]] = a.performance[f], a.performance.userTimingJsUserTimingPrefixed = !0);
                var q = {};
                "function" != typeof a.performance.mark && (a.performance.mark = function(b) {
                    var c = a.performance.now();
                    if ("undefined" == typeof b) throw new SyntaxError("Mark name must be specified");
                    if (a.performance.timing && b in a.performance.timing) throw new SyntaxError("Mark name is not allowed");
                    q[b] || (q[b] = []), q[b].push(c), h({
                        entryType: "mark",
                        name: b,
                        startTime: c,
                        duration: 0
                    })
                }), "function" != typeof a.performance.clearMarks && (a.performance.clearMarks = function(a) {
                    a ? q[a] = [] : q = {}, i("mark", a)
                }), "function" != typeof a.performance.measure && (a.performance.measure = function(b, c, d) {
                    var e = a.performance.now();
                    if ("undefined" == typeof b) throw new SyntaxError("Measure must be specified");
                    if (!c) return void h({
                        entryType: "measure",
                        name: b,
                        startTime: 0,
                        duration: e
                    });
                    var f = 0;
                    if (a.performance.timing && c in a.performance.timing) {
                        if ("navigationStart" !== c && 0 === a.performance.timing[c]) throw new Error(c + " has a timing of 0");
                        f = a.performance.timing[c] - a.performance.timing.navigationStart
                    } else {
                        if (!(c in q)) throw new Error(c + " mark not found");
                        f = q[c][q[c].length - 1]
                    }
                    var g = e;
                    if (d)
                        if (g = 0, a.performance.timing && d in a.performance.timing) {
                            if ("navigationStart" !== d && 0 === a.performance.timing[d]) throw new Error(d + " has a timing of 0");
                            g = a.performance.timing[d] - a.performance.timing.navigationStart
                        } else {
                            if (!(d in q)) throw new Error(d + " mark not found");
                            g = q[d][q[d].length - 1]
                        }
                    var i = g - f;
                    h({
                        entryType: "measure",
                        name: b,
                        startTime: f,
                        duration: i
                    })
                }), "function" != typeof a.performance.clearMeasures && (a.performance.clearMeasures = function(a) {
                    i("measure", a)
                })
            }
            "undefined" != typeof define && define.amd ? define([], function() {
                return a.performance
            }) : "undefined" != typeof module && "undefined" != typeof module.exports && (module.exports = a.performance)
        }("undefined" != typeof window ? window : void 0);
    </script>

    <link rel="stylesheet" type="text/css" href="{{ url('public/css/dashboard.css') }}">

    <!--[if gt IE 9]><!-->
    <script type="text/javascript" src="{{ url('public/js/d1.js') }}" defer></script>
    <script type="text/javascript" src="{{ url('public/js/d2.js') }}" defer></script>
    <!--<![endif]-->

</head>

<body class="">

<div id="app" class="">
    <div class="overflow-target js-overflow-target">
        <div class="offcanvas-menu-content js-offcanvas-menu-content">
            <nav class="offcanvas-menu js-offcanvas-menu">
                <ul class="site-nav-list">
                    <li class="site-nav-item js-mobile-user-bar-avatar ">
                        <a class="site-nav-link" href="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-256.png">
                            <img class="avatar avatar--medium js-avatar" src="" />
                            <span class="avatar-name js-username">{{ Auth::user()->email }}</span>
                        </a>
                    </li>
                    <li class="site-nav-sub-item">
                        <a href="/profile" class="site-nav-link">
                            My Profile
                        </a>
                    </li>
                    <li class="site-nav-sub-item">
                        <a href="/saved" class="site-nav-link">
                            Saved Offers
                            <span class="site-nav-link-count">1</span>
                        </a>
                    </li>
                    <li class="site-nav-sub-item">
                        <a href="/favorites" class="site-nav-link">
                            Favorite Stores
                            <span class="site-nav-link-count">2</span>
                        </a>
                    </li>
                    <li class="site-nav-sub-item">
                        <a href="/my-cashback" class="site-nav-link">
                            My Cash Back
                        </a>
                    </li>

                    <li class="site-nav-item js-has-popup-menu">
                        <div class="popup-menu js-popup-menu">
                            <div class="popup-trigger js-popup-toggle ">

                                <a class="popup-title js-popup-title" href="#" title="Browse Deals">
                                    Browse Deals
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </a>

                                <ul class="popup-menu-list">
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/ideas/backtoschool">Back to School</a>
                                    </li>
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/coupons/codes">Coupon Codes</a>
                                    </li>
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/coupons/printable">Printable Coupons</a>
                                    </li>
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/coupons/freeshipping">Free Shipping</a>
                                    </li>
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/ideas/hot-products">Product Deals</a>
                                    </li>
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/coupons/exclusives">Only at RetailMeNot</a>
                                    </li>
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/cashback">Cash Back Offers</a>
                                    </li>
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/coupons/">Browse by Category</a>
                                    </li>
                                    <li class="popup-menu-item">
                                        <a class="popup-menu-link" href="/blog/">Blog</a>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </li>

                    <li class="site-nav-item">
                        <a class="site-nav-link" href="/ideas/backtoschool">
                            Back to School
                        </a>
                    </li>

                    <li class="site-nav-item js-mobile-user-bar">
                        <ul>
                            <li class="site-nav-item">
                                <a href="https://www.retailmenot.com/community/logout" class="site-nav-link">
                                    Log out
                                </a>
                            </li>
                            </li>
                        </ul>
            </nav>
        </div>
        <div class="main-content">
            <header id="top" role="banner" class="site-header js-site-header">
                <div class="container container--full">

                    <a href="#site-nav" class="toggle toggle-menu js-toggle-menu js-mobile-toggle">
                        <svg class="icon icon-menu">
                            <use xlink:href="#icon-menu"></use>
                        </svg>
                    </a>
                    <a id="logo" href="/">
                        <div class="logo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 675.5 612 117.6">
                                <g>
                                    <path d="M102.9 783.8c-4.8-.5-8.5-1.4-12-4.2-3.2-2.6-5.7-6.9-7.7-12.4-4.3-11.9-8.6-26.5-10.7-33.9 27.9-9.7 40.8-22.4 40.8-36.4 0-12.9-10.6-21.4-34-18.4-10.3 1.3-17.9 2.6-25.9 4.2-30 5.8-41.3 18.8-41.3 32.1 0 9 7.9 15.3 17.1 15.3 6.3 0 6.9-3.5 5-4.9-3.9-3-6.3-5.8-6.3-10.8 0-7.8 5.9-17.9 27.5-22.7 1.4-.3 2.5-.5 3.7-.8-3.6 10.2-10 28.1-15.8 43.4C10.4 747.5 0 765.7 0 778.3c0 9.4 7.4 14.8 16.1 14.8 13.4 0 23.8-8.9 32.2-29 3.1-7.3 6.5-15.9 9.7-24.8 2.1 7.8 6 21.5 10.2 32.5 2.4 6.4 4.6 10.9 7.8 14.2 3.9 3.9 9.3 5.9 15.6 5.9 7.5 0 12-2.5 13.1-4.3 1.6-2.1.8-3.6-1.8-3.8zm-69.6-24.3c-7.3 15-11.8 21.3-17.5 22.3-2.5.4-4.6-.8-4.6-4.6 0-4.1 4.5-19.6 28.1-32-2.4 6.2-4.5 11.2-6 14.3zm29.3-32.4c5.7-15.7 11-30.7 14-39.4 12.5-1.4 18.9 2.4 18.9 11.8 0 9.1-7.7 18.1-24.3 24.5-3.1 1-5.9 2.1-8.6 3.1zM415.2 759.8c-2.5 0-6.3 4.1-12.9 4.1-4.5 0-6.9-2.9-6.9-8.9 0-1.5.2-3.1.5-4.8h1.7c21.4 0 34.2-12.4 34.2-24.5 0-8.7-6.7-13.1-13.2-13.1-16 0-35.3 19-38.6 38.4-4.6 7.8-8.4 10.8-10.7 10.7-2.6-.1-2.4-3.8 0-10.8 3.7-10.6 9-24.9 13.7-35.9 9.2-21.8 15-33.9 15.8-36.4.7-2.5-.6-3-3.2-2.5-9.3 1.4-14.5 1-18.4 7.5-6.3 10.4-33.1 52.1-33.1 52.1s7.9-51.6 9.2-56.9c.6-2.9-.8-3.7-3.4-3.1-3 .8-5.6 1.5-9.6 2.8-3.5 1.2-4.2 2.3-6.7 7.9-1.3 3-11.5 33.4-18.8 48.7-7.6 16.3-13.8 25.9-28.2 27-3.9.3-4.1 2.3-3.1 4.8 2.2 5.2 7.8 8.3 12.9 8.3 9 0 15.4-6.4 21.5-21.2 5.1-12.3 12.6-33.4 18.2-49.3-4.7 24.7-10.2 57.6-11 66.3-.4 5.1 6.4 5.2 9.1.2 7.2-13 22.8-39.7 36.8-63.9-5.7 13.7-12.4 29.9-15.5 39-2.1 6.7-4 11.5-4 17.7 0 7.1 4.9 11.3 10.3 11.3 5.5 0 11.9-2.8 18.6-11.3 2 7.1 7.3 11.5 16.3 11.5 11.8 0 20.4-8.1 20.4-13.1.5-1.6-.5-2.6-1.9-2.6zm-.2-36.5c6.7 0 1.5 17.5-15.9 18 4.4-9.3 11.5-18 15.9-18zm-34.8-30.9c-.1.1-.1.2-.2.3.1-.2.2-.2.2-.3zm-39.2-9.6c0-.1 0-.2.1-.3-.1.1-.1.2-.1.3z" />
                                    <path d="M514.4 694.6c6.3-4.5 11-4.8 12.5-6 2.2-1.9-.8-11.1-9.5-11.1-13.9 0-21.1 17.4-26.6 32.7-3.6 10-7.6 22.1-10.7 31.9 1.5-21.5 4.1-55.9 4.2-59.8.1-2 0-3.1-1-3.5.1-.1.1-.1.1-.2h-.7c-.3-.1-.7-.1-1.3-.1-1.9 0-3.6.1-5.4.1h-24.1c-35.4 0-32.7 33.2-10.8 33.2 4 0 4.1-3.9 2.2-5-7.9-4-9.5-18.5 17-18.5h7.2c-3.3 11.3-9.5 30.4-17.4 47.3-8.4 18-13.1 24.7-26.3 28.1-3.8 1-3.5 3.1-2.4 5.5 1.3 3 6 6.1 11.9 6.1 10.4 0 15.9-7.6 21.5-22.9 5.5-14.8 10.1-29.2 13.5-40.4-1 23.9-1.8 54.6-2 60.2-.1 4.2 1.6 4.2 4.9 2.8 6.7-2.9 9-3.9 10.8-9.3 5.6-17.2 11-31.5 17.4-47.6 3.8-10.3 9.8-19.8 15-23.5z" />
                                    <path d="M533.8 714c-27.9 0-41.5 32.3-41.5 46.2 0 9.9 6.3 16 16.8 16 23.3 0 36.7-31.8 36.7-46.4 0-10-4.6-15.8-12-15.8zm-20.2 49.3c-10.4 0 3.4-39 12.7-39 8.7 0-1.7 39-12.7 39z" />
                                    <path d="M607.3 697c-2.3 0-10.5.2-22.9.6 2-4.9 3.6-8.8 4.7-11.4.8-2 .4-3.2-1.7-3.2-1.9 0-5.2.6-9.1 1.7-5.3 1.4-5.9 2.3-8.8 8.5-.6 1.3-1.4 3-2.2 5.1-12.1.4-26.2 1.1-41.7 1.7-6 .3-14.6 7.8-7.2 7.8 14.6 0 30.4.5 44.8 1-2.2 5.9-5 13.2-8.4 21.8-4.2 10.8-10.2 23.7-10.2 32.6 0 6.6 4.5 12.3 12.5 12.3 10 0 14-5.8 12.9-9.2-.6-1.9-2.4-1.9-6.3-1.9-2.6 0-3.6-1.8-3.6-3.8 0-3.1 1.5-6.3 3.1-10.5 5.6-14.6 11.4-29 16.3-40.8 4 .1 7.8.1 11.3.1 8.6 0 11.9-.2 14.9-2.5 2.5-1.9 3.7-3 5.1-4.8 1.6-1.8 2.4-5.1-3.5-5.1zM254.5 711.2c4.6 0 9.2-4.2 10.3-9.4 1.1-5.2-1.7-9.4-6.3-9.4s-9.2 4.2-10.3 9.4c-1.1 5.2 1.7 9.4 6.3 9.4z" />
                                    <path d="M274 764.8c-2.2-.3-2.9-1.8-2.9-4.3 0-3.1.8-7.4 2.3-12.3 36.3-17.1 60.2-69.1 33.1-69.1-18 0-40.5 39.9-47.7 67.1-4 6.5-10.8 16.2-15.6 16.2-3.7 0-2.8-4.9 0-12.2 6.3-17 15.4-34.4 15.4-34.4s-4.6-1.9-10.8-.8c-4 .7-5.8 2.8-7.7 6.4-.2.3-.5.7-.7 1.4-11.8 25.3-19.2 39.6-25.9 39.6-4.7 0-2-5.2.6-12.4 6.3-17 15.4-34.4 15.4-34.4s-4.6-1.9-10.8-.8c-3.9.6-5.7 2.5-7.5 5.9-1.3-3.5-3.9-6.9-9.6-6.9-17.5 0-30.6 22.5-34.3 38.4-3.6 5.5-8.3 11.4-11.8 11.4s-3.5-3.1-.7-10.3c4.5-11.5 13-31.5 19.8-47.2 17.2.4 33.4.7 42.7.7 8.6 0 11.9-.2 14.9-2.5 2.5-1.9 3.7-3 5.1-4.8 1.5-1.8 2.1-5.1-3.7-5.1-3.2 0-26.7.7-54.7 1.8 2.1-4.8 3.8-8.6 4.8-10.8.6-1.4-.3-2.9-2.4-2.6-3.3.3-4.5.7-7.9 1.6-5.3 1.3-6.6 2.9-9.5 9-.4.8-1 2-1.6 3.5-11.1.4-22.5 1-33.1 1.4-6 .3-12.9 7-5.6 7 9.2 0 21.7.2 34.9.5-2.3 5.2-4.9 11.2-7 16.5-.2.4-.5 1-.7 1.6-8.9 20.2-22.5 41.5-37.4 41.5-5.8 0-8.3-3.8-8.3-8.8 0-1.9.3-3.9.7-6 .5 0 1.2.1 1.9.1 21.4 0 34-13.1 34-25.2 0-7.7-6.5-12.3-12.9-12.3-17.6 0-39.1 22.9-39.1 44.1 0 11.4 6.1 19 16.5 19 14 0 24.9-8.6 32.5-18-.4 2.1-.6 4.2-.6 6.3 0 6.6 3.8 11.4 10 11.4 7 0 13-4.2 18.6-11.7 1.2 7.4 5.4 11.7 11.7 11.7 7.4 0 13.8-5.6 18.9-12.4.3 6.1 2.4 12.4 10.6 12.4 5.7 0 11.7-3.1 18.6-12.8.2 6.4 2.9 13.1 10.5 13.1 7.4 0 14-5.3 19.9-13.4.5 8.1 4.9 12.8 11.1 12.8 6.4 0 11.8-4.1 11.4-8.7-.3-3.4-3.3-1.9-5.4-2.2zm31.2-74.4c3.9 0-6.8 28.1-26.5 43.7 8.4-20.6 21.8-43.7 26.5-43.7zM124 722.7c6.8 0 2.6 18.9-15.4 18.9h-.2c4.2-9.8 11.1-18.9 15.6-18.9zm60.4 40.3c-10.2 0 7-38.4 16.7-38.4 3.7 0 5 2.4 5.5 4.5-7.9 18.5-14.5 33.9-22.2 33.9z" />
                                </g>
                            </svg>
                        </div>
                    </a>

                    <nav class="site-nav" role="navigation">
                        <ul class="site-nav-list">

                            <li class="site-nav-item js-has-popup-menu">
                                <div class="popup-menu js-popup-menu">
                                    <div class="popup-trigger js-popup-toggle ">

                                        <a class="popup-title js-popup-title" href="#" title="Browse Deals">
                                            Browse Deals
                                            <svg class="icon icon-arrow-down">
                                                <use xlink:href="#icon-arrow-down"></use>
                                            </svg>
                                        </a>

                                        <ul class="popup-menu-list">
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/ideas/backtoschool">Back to School</a>
                                            </li>
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/coupons/codes">Coupon Codes</a>
                                            </li>
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/coupons/printable">Printable Coupons</a>
                                            </li>
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/coupons/freeshipping">Free Shipping</a>
                                            </li>
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/ideas/hot-products">Product Deals</a>
                                            </li>
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/coupons/exclusives">Only at RetailMeNot</a>
                                            </li>
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/cashback">Cash Back Offers</a>
                                            </li>
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/coupons/">Browse by Category</a>
                                            </li>
                                            <li class="popup-menu-item">
                                                <a class="popup-menu-link" href="/blog/">Blog</a>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </li>

                            <li class="site-nav-item">
                                <a class="site-nav-link" href="/ideas/backtoschool">
                                    Back to School
                                </a>
                            </li>

                            <ul class="user-bar js-user-bar">
                                <div class="site-nav-item js-has-popup-menu js-user-bar">
                                    <div class="popup-menu js-popup-menu">
                                        <div class="popup-trigger js-popup-toggle has-avatar">

                                            <a class="popup-title js-popup-title" href="">
                                                <img class="avatar avatar--tiny js-avatar" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-256.png" alt="avatar image" /> <span class="avatar-name js-username">{{ Auth::user()->email }}</span>
                                                <svg class="icon icon-arrow-down">
                                                    <use xlink:href="#icon-arrow-down"></use>
                                                </svg>
                                            </a>

                                            <ul class="popup-menu-list">
                                                <li class="popup-menu-item">
                                                    <a class="popup-menu-link" href="/profile">View Profile</a>
                                                </li>
                                                <li class="popup-menu-item">
                                                    <a class="popup-menu-link" href="/saved">Saved Offers</a>
                                                </li>
                                                <li class="popup-menu-item">
                                                    <a class="popup-menu-link" href="/favorites">Favorite Stores</a>
                                                </li>
                                                <li class="popup-menu-item">
                                                    <a class="popup-menu-link" href="/my-cashback">My Cash Back</a>
                                                </li>
                                                <li class="popup-menu-item">
                                                    <a class="popup-menu-link" href="https://www.retailmenot.com/community">Community</a>
                                                </li>
                                                <li class="popup-menu-item">
                                                    <a class="popup-menu-link" href="{{ url('logout') }}">Log out</a>
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </ul>
                    </nav>

                    <div id="search-form" class="search-form js-search-form">
                        <form class="form-search inline-form-elements" role="search" action="/search.php" method="get">
                            <input class="query" name="query" type="search" placeholder="Save on Stores, Brands & Categories" aria-label="Search" autocomplete="off" maxlength="100" value="" />
                            <button type="submit" class="button-search" data-track-category="Masthead" data-track-action="search">
                                <svg class="icon icon-search">
                                    <use xlink:href="#icon-search"></use>
                                </svg>
                                <span class="text">Search</span>
                            </button>
                        </form>
                        <div class="js-instant-results instant-results hide"></div>
                    </div>
                    <a href="#search-form" class="toggle toggle-search js-toggle-search js-mobile-toggle">
                        <svg class="icon icon-search">
                            <use xlink:href="#icon-search"></use>
                        </svg>
                    </a>

                </div>
            </header>
            <main role="main" id="site-main">
                <div class="container page-padding js-page-container ">
                    <div class="grid-fixed-fluid">
                        <div class="fixed sidebar-hide-for-devices">
                            <div class="sidebar js-sidebar">
                                <div class="sidebar-user-section">
                                    <img class="avatar avatar--large js-avatar" src="https://cdn1.iconfinder.com/data/icons/freeline/32/account_friend_human_man_member_person_profile_user_users-256.png" />
                                    <div class="user-fullname">{{ Auth::user()->email }}</div>
                                </div>
                                <div class="sidebar-nav js-sidebar-nav">
                                    <a href="/profile" class="sidebar-nav-link" data-navigo="/profile">
                                        <svg class="icon icon-create">
                                            <use xlink:href="#icon-create"></use>
                                        </svg>
                                        My Profile
                                    </a>
                                    <a href="{{ url('dashboard/store') }}" class="sidebar-nav-link " >
                                        Store
                                        <span class="sidebar-nav-link-count">1</span>
                                    </a>
                                    <a href="{{ url('dashboard/coupon') }}" class="sidebar-nav-link">
                                        Coupon
                                        <span class="sidebar-nav-link-count">1</span>
                                    </a>

                                </div>
                                <a class="button-secondary button-submit-coupon" href="{{ url('dashboard/store/addForm') }}">
                                    <svg class="icon icon-tag-add">
                                        <use xlink:href="#icon-tag-add"></use>
                                    </svg>
                                    Add Store
                                </a>

                                <a class="button-secondary button-submit-coupon" href="{{ url('dashboard/coupon/addForm') }}">
                                    <svg class="icon icon-tag-add">
                                        <use xlink:href="#icon-tag-add"></use>
                                    </svg>
                                    Add Coupon
                                </a>
                            </div>
                        </div>

                        @section('fluid')
                        <div class="fluid">
                            <div class="page-wrapper js-main-router">
                                <div class="js-saved-offers">
                                    <h1 class="h3">Store</h1>

                                    <section class="section">
                                        <h2 class="h5">
                                            List
                                        </h2>

                                        <ul id="saved-offer-list" class="offer-list js-offers js-saved-offers">
                                            <li class="offer-list-item">
                                                <div class="offer-item js-offer sale" data-analytics-click-group-label="Saved Offers" data-has-submitter="false" data-new-tab="/out/9031356" data-out-url="/out/9031356" data-merchant-url="/out/S143489" data-offer-type="sale" data-site-id="143489" data-type="sale" data-main-tab="/saved" data-offer-uuid="ADQIYCJ2XFA75NHV7UA3SUN7CU" data-analytics-click-location="offer body" data-couponrank="0.44" data-couponscore="63" data-offer-position="1" data-site-uuid="6HVWN4SEOZCO3IB72JD5HBKK5Q" data-site-title="Kate Spade" data-merchant-name="katespade.com" data-offer-id="9031356" data-comment-count="1" data-id="ADQIYCJ2XFA75NHV7UA3SUN7CU" id="offer-ADQIYCJ2XFA75NHV7UA3SUN7CU">
                                                    <div class="offer-item-content">
                                                        <div class="offer-anchor-merchant">
                                                            <a href="/view/katespade.com" class="offer-anchor-merchant-logo" target="">
                                                                <img src="https://www.retailmenot.com/thumbs/logos/l/katespade.com-coupons.jpg?versionId=ZUmweTZ5VlFaKEZYqzbdkJK3HOnYbE.u" alt="Kate Spade" data-analytics-click-group-label="Saved Offers" data-has-submitter="false" data-new-tab="/out/9031356" data-out-url="/out/9031356" data-merchant-url="/out/S143489" data-offer-type="sale" data-site-id="143489" data-type="sale" data-main-tab="/saved" data-offer-uuid="ADQIYCJ2XFA75NHV7UA3SUN7CU" data-analytics-click-location="offer body" data-couponrank="0.44" data-couponscore="63" data-offer-position="1" data-site-uuid="6HVWN4SEOZCO3IB72JD5HBKK5Q" data-site-title="Kate Spade" data-merchant-name="katespade.com" data-offer-id="9031356" data-comment-count="1" data-id="ADQIYCJ2XFA75NHV7UA3SUN7CU" />

                                                            </a>
                                                        </div>

                                                        <div class="offer-item-main">
                                                            <div class="offer-item-head">
                                                                <div class="offer-item-label has-separator-dot offer-type-sale">
                                                                    Sale
                                                                </div>

                                                                <div class="offer-merchant-name has-separator-dot">
                                                                    Kate Spade
                                                                </div>

                                                                <div class="js-save-offer save-offer  is-active">
                                                                    <svg class="icon icon-star-outline">
                                                                        <use xlink:href="#icon-star-outline"></use>
                                                                    </svg>
                                                                    <span class="save-offer-copy js-save-offer-copy">
																								Saved
																							</span>
                                                                </div>
                                                            </div>

                                                            <div class="offer-item-body">
                                                                <div class="offer-item-body-content">
                                                                    <div class="offer-item-title">
                                                                        <a href="/out/9031356" class="offer-item-title-link js-triggers-outclick" data-analytics-click-location="OfferTitle">
                                                                            Up to 75% Off Surprise Sale + Free Shipping on $99+
                                                                        </a>
                                                                    </div>

                                                                    <div class="offer-item-info">
                                                                        <div class="offer-meta offer-meta-usage has-separator-dot">
                                                                            9.4k uses today
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="offer-item-actions">
                                                                    <a href="" class="
																										button-primary
																								offer-button
																								js-triggers-outclick
																							" data-0="[object Object]" data-1="[object Object]" data-2="[object Object]">
                                                                        Edit
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="js-offer-item-details offer-item-details ">
                                                        <div class="offer-item-details-bar">
                                                            <a class="js-offer-item-details-link offer-item-details-link" data-event-target="details content">
                                                                See Details<svg class="icon icon-arrow-down">
                                                                    <use xlink:href="#icon-arrow-down"></use>
                                                                </svg>

                                                            </a>

                                                        </div>

                                                        <div class="js-offer-item-tabs offer-item-tabs hidden">
                                                            <div class="offer-item-tabs-header">
                                                                <ul class="offer-item-tabs-header-list">
                                                                    <li class="js-tabs-header-item offer-item-tabs-header-item  is-active" data-tab-key="0" data-tab-id="tab-9031356-exclusions">
                                                                        <a class="js-tabs-header-item-link offer-item-tabs-header-item-link " data-prompt-name="offer exclusions">
                                                                            Exclusions
                                                                        </a>
                                                                    </li>
                                                                    <li class="js-tabs-header-item offer-item-tabs-header-item " data-tab-key="1" data-tab-id="tab-9031356-details">
                                                                        <a class="js-tabs-header-item-link offer-item-tabs-header-item-link " data-prompt-name="offer details">
                                                                            Details
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                                <div class="js-offer-item-tabs-active-indicator offer-item-tabs-active-indicator" data-persist-css="transform"></div>
                                                            </div>

                                                            <div class="offer-item-tabs-content">
                                                                <div id="tab-9031356-exclusions" class="offer-item-tabs-content-item js-tabs-content-item offer-item-tabs-content-exclusions is-active" data-tab-key="0">
                                                                    <p>
                                                                        <strong>Ends:</strong>&nbsp;08/19/17
                                                                    </p>
                                                                    <p>
                                                                        <strong>Exclusions:</strong>&nbsp;Not valid at katespade.com, kate spade new york specialty shops or kate spade new york outlet shops. All sales final.
                                                                    </p>
                                                                </div>
                                                                <div id="tab-9031356-details" class="offer-item-tabs-content-item js-tabs-content-item offer-item-tabs-content-details" data-tab-key="1">
                                                                    <p>
                                                                        <strong>Ends:</strong>&nbsp;08/19/17
                                                                    </p>
                                                                    <p>
                                                                        <strong>Details:</strong>&nbsp;surprise sale starts now! Get up to 75% off + Free shipping when you spend $99 or more!
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </li>
                                        </ul>
                                    </section>

                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @show
            </main>
            <footer class="js-site-footer site-footer" role="content-info">

                <div class="site-footer-nav">
                    <div class="container">
                        <div class="site-footer-container">
                            <div class="app-download-wrapper">
                                <div class="footer-app-banner js-footer-app-banner">
                                    <a class="js-install app-install" data-campaign="mwebfooter" href="https://163424.measurementapi.com/serve?action&#x3D;click&amp;publisher_id&#x3D;163424&amp;site_id&#x3D;103086&amp;site_id_ios&#x3D;95000&amp;site_id_android&#x3D;95002&amp;site_id_web&#x3D;103086&amp;my_campaign&#x3D;rmnfooter&amp;my_adgroup&#x3D;">
                                        <svg class="icon icon-app-download">
                                            <use xlink:href="#icon-app-download"></use>
                                        </svg>

                                        <div class="app-download-text">
                                            Get savings on the&nbsp;go!
                                            <div class="app-download-title">
                                                Download the App
                                            </div>
                                        </div>

                                        <div class="app-download-arrow">
                                            <svg class="icon icon-arrow-right">
                                                <use xlink:href="#icon-arrow-right"></use>
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="link-group-wrapper">
                                <div class="link-group">
                                    <div class="link-group-label">Specialty Pages</div>
                                    <ul>
                                        <li>
                                            <a href="/deals/blackfriday">Black Friday Deals</a>
                                        </li>
                                        <li>
                                            <a href="/deals/cybermonday">Cyber Monday Deals</a>
                                        </li>
                                        <li>
                                            <a href="/ideas/backtoschool">Back to School</a>
                                        </li>
                                        <li>
                                            <a href="/coupons">Browse Categories</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="link-group">
                                    <div class="link-group-label">Connect</div>
                                    <ul>
                                        <li>
                                            <a href="http://help.retailmenot.com/">Help</a>
                                        </li>
                                        <li>
                                            <a href="http://www.facebook.com/RetailMeNot">Facebook</a>
                                        </li>
                                        <li>
                                            <a href="http://twitter.com/retailmenot">Twitter</a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/retailmenot/">Instagram</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="link-group">
                                    <div class="link-group-label">Account</div>
                                    <ul>
                                        <li>
                                            <a href="/profile">My Account</a>
                                        </li>
                                        <li>
                                            <a href="https://www.retailmenot.com/community/">Community</a>
                                        </li>
                                        <li>
                                            <a href="/submit">Submit a Coupon</a>
                                        </li>
                                        <li>
                                            <a href="http://www.retailmenot.ca">RetailMeNot.ca</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="link-group">
                                    <div class="link-group-label">General</div>
                                    <ul>
                                        <li>
                                            <a href="https://www.retailmenot.com/corp/">About</a>
                                        </li>
                                        <li>
                                            <a href="https://www.retailmenot.com/blog/">Blog</a>
                                        </li>
                                        <li>
                                            <a href="https://www.retailmenot.com/corp/careers/">Careers</a>
                                        </li>
                                        <li>
                                            <a href="http://help.retailmenot.com/">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="logo-wrapper">
                                <div class="logo">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 675.5 612 117.6">
                                        <g>
                                            <path d="M102.9 783.8c-4.8-.5-8.5-1.4-12-4.2-3.2-2.6-5.7-6.9-7.7-12.4-4.3-11.9-8.6-26.5-10.7-33.9 27.9-9.7 40.8-22.4 40.8-36.4 0-12.9-10.6-21.4-34-18.4-10.3 1.3-17.9 2.6-25.9 4.2-30 5.8-41.3 18.8-41.3 32.1 0 9 7.9 15.3 17.1 15.3 6.3 0 6.9-3.5 5-4.9-3.9-3-6.3-5.8-6.3-10.8 0-7.8 5.9-17.9 27.5-22.7 1.4-.3 2.5-.5 3.7-.8-3.6 10.2-10 28.1-15.8 43.4C10.4 747.5 0 765.7 0 778.3c0 9.4 7.4 14.8 16.1 14.8 13.4 0 23.8-8.9 32.2-29 3.1-7.3 6.5-15.9 9.7-24.8 2.1 7.8 6 21.5 10.2 32.5 2.4 6.4 4.6 10.9 7.8 14.2 3.9 3.9 9.3 5.9 15.6 5.9 7.5 0 12-2.5 13.1-4.3 1.6-2.1.8-3.6-1.8-3.8zm-69.6-24.3c-7.3 15-11.8 21.3-17.5 22.3-2.5.4-4.6-.8-4.6-4.6 0-4.1 4.5-19.6 28.1-32-2.4 6.2-4.5 11.2-6 14.3zm29.3-32.4c5.7-15.7 11-30.7 14-39.4 12.5-1.4 18.9 2.4 18.9 11.8 0 9.1-7.7 18.1-24.3 24.5-3.1 1-5.9 2.1-8.6 3.1zM415.2 759.8c-2.5 0-6.3 4.1-12.9 4.1-4.5 0-6.9-2.9-6.9-8.9 0-1.5.2-3.1.5-4.8h1.7c21.4 0 34.2-12.4 34.2-24.5 0-8.7-6.7-13.1-13.2-13.1-16 0-35.3 19-38.6 38.4-4.6 7.8-8.4 10.8-10.7 10.7-2.6-.1-2.4-3.8 0-10.8 3.7-10.6 9-24.9 13.7-35.9 9.2-21.8 15-33.9 15.8-36.4.7-2.5-.6-3-3.2-2.5-9.3 1.4-14.5 1-18.4 7.5-6.3 10.4-33.1 52.1-33.1 52.1s7.9-51.6 9.2-56.9c.6-2.9-.8-3.7-3.4-3.1-3 .8-5.6 1.5-9.6 2.8-3.5 1.2-4.2 2.3-6.7 7.9-1.3 3-11.5 33.4-18.8 48.7-7.6 16.3-13.8 25.9-28.2 27-3.9.3-4.1 2.3-3.1 4.8 2.2 5.2 7.8 8.3 12.9 8.3 9 0 15.4-6.4 21.5-21.2 5.1-12.3 12.6-33.4 18.2-49.3-4.7 24.7-10.2 57.6-11 66.3-.4 5.1 6.4 5.2 9.1.2 7.2-13 22.8-39.7 36.8-63.9-5.7 13.7-12.4 29.9-15.5 39-2.1 6.7-4 11.5-4 17.7 0 7.1 4.9 11.3 10.3 11.3 5.5 0 11.9-2.8 18.6-11.3 2 7.1 7.3 11.5 16.3 11.5 11.8 0 20.4-8.1 20.4-13.1.5-1.6-.5-2.6-1.9-2.6zm-.2-36.5c6.7 0 1.5 17.5-15.9 18 4.4-9.3 11.5-18 15.9-18zm-34.8-30.9c-.1.1-.1.2-.2.3.1-.2.2-.2.2-.3zm-39.2-9.6c0-.1 0-.2.1-.3-.1.1-.1.2-.1.3z" />
                                            <path d="M514.4 694.6c6.3-4.5 11-4.8 12.5-6 2.2-1.9-.8-11.1-9.5-11.1-13.9 0-21.1 17.4-26.6 32.7-3.6 10-7.6 22.1-10.7 31.9 1.5-21.5 4.1-55.9 4.2-59.8.1-2 0-3.1-1-3.5.1-.1.1-.1.1-.2h-.7c-.3-.1-.7-.1-1.3-.1-1.9 0-3.6.1-5.4.1h-24.1c-35.4 0-32.7 33.2-10.8 33.2 4 0 4.1-3.9 2.2-5-7.9-4-9.5-18.5 17-18.5h7.2c-3.3 11.3-9.5 30.4-17.4 47.3-8.4 18-13.1 24.7-26.3 28.1-3.8 1-3.5 3.1-2.4 5.5 1.3 3 6 6.1 11.9 6.1 10.4 0 15.9-7.6 21.5-22.9 5.5-14.8 10.1-29.2 13.5-40.4-1 23.9-1.8 54.6-2 60.2-.1 4.2 1.6 4.2 4.9 2.8 6.7-2.9 9-3.9 10.8-9.3 5.6-17.2 11-31.5 17.4-47.6 3.8-10.3 9.8-19.8 15-23.5z" />
                                            <path d="M533.8 714c-27.9 0-41.5 32.3-41.5 46.2 0 9.9 6.3 16 16.8 16 23.3 0 36.7-31.8 36.7-46.4 0-10-4.6-15.8-12-15.8zm-20.2 49.3c-10.4 0 3.4-39 12.7-39 8.7 0-1.7 39-12.7 39z" />
                                            <path d="M607.3 697c-2.3 0-10.5.2-22.9.6 2-4.9 3.6-8.8 4.7-11.4.8-2 .4-3.2-1.7-3.2-1.9 0-5.2.6-9.1 1.7-5.3 1.4-5.9 2.3-8.8 8.5-.6 1.3-1.4 3-2.2 5.1-12.1.4-26.2 1.1-41.7 1.7-6 .3-14.6 7.8-7.2 7.8 14.6 0 30.4.5 44.8 1-2.2 5.9-5 13.2-8.4 21.8-4.2 10.8-10.2 23.7-10.2 32.6 0 6.6 4.5 12.3 12.5 12.3 10 0 14-5.8 12.9-9.2-.6-1.9-2.4-1.9-6.3-1.9-2.6 0-3.6-1.8-3.6-3.8 0-3.1 1.5-6.3 3.1-10.5 5.6-14.6 11.4-29 16.3-40.8 4 .1 7.8.1 11.3.1 8.6 0 11.9-.2 14.9-2.5 2.5-1.9 3.7-3 5.1-4.8 1.6-1.8 2.4-5.1-3.5-5.1zM254.5 711.2c4.6 0 9.2-4.2 10.3-9.4 1.1-5.2-1.7-9.4-6.3-9.4s-9.2 4.2-10.3 9.4c-1.1 5.2 1.7 9.4 6.3 9.4z" />
                                            <path d="M274 764.8c-2.2-.3-2.9-1.8-2.9-4.3 0-3.1.8-7.4 2.3-12.3 36.3-17.1 60.2-69.1 33.1-69.1-18 0-40.5 39.9-47.7 67.1-4 6.5-10.8 16.2-15.6 16.2-3.7 0-2.8-4.9 0-12.2 6.3-17 15.4-34.4 15.4-34.4s-4.6-1.9-10.8-.8c-4 .7-5.8 2.8-7.7 6.4-.2.3-.5.7-.7 1.4-11.8 25.3-19.2 39.6-25.9 39.6-4.7 0-2-5.2.6-12.4 6.3-17 15.4-34.4 15.4-34.4s-4.6-1.9-10.8-.8c-3.9.6-5.7 2.5-7.5 5.9-1.3-3.5-3.9-6.9-9.6-6.9-17.5 0-30.6 22.5-34.3 38.4-3.6 5.5-8.3 11.4-11.8 11.4s-3.5-3.1-.7-10.3c4.5-11.5 13-31.5 19.8-47.2 17.2.4 33.4.7 42.7.7 8.6 0 11.9-.2 14.9-2.5 2.5-1.9 3.7-3 5.1-4.8 1.5-1.8 2.1-5.1-3.7-5.1-3.2 0-26.7.7-54.7 1.8 2.1-4.8 3.8-8.6 4.8-10.8.6-1.4-.3-2.9-2.4-2.6-3.3.3-4.5.7-7.9 1.6-5.3 1.3-6.6 2.9-9.5 9-.4.8-1 2-1.6 3.5-11.1.4-22.5 1-33.1 1.4-6 .3-12.9 7-5.6 7 9.2 0 21.7.2 34.9.5-2.3 5.2-4.9 11.2-7 16.5-.2.4-.5 1-.7 1.6-8.9 20.2-22.5 41.5-37.4 41.5-5.8 0-8.3-3.8-8.3-8.8 0-1.9.3-3.9.7-6 .5 0 1.2.1 1.9.1 21.4 0 34-13.1 34-25.2 0-7.7-6.5-12.3-12.9-12.3-17.6 0-39.1 22.9-39.1 44.1 0 11.4 6.1 19 16.5 19 14 0 24.9-8.6 32.5-18-.4 2.1-.6 4.2-.6 6.3 0 6.6 3.8 11.4 10 11.4 7 0 13-4.2 18.6-11.7 1.2 7.4 5.4 11.7 11.7 11.7 7.4 0 13.8-5.6 18.9-12.4.3 6.1 2.4 12.4 10.6 12.4 5.7 0 11.7-3.1 18.6-12.8.2 6.4 2.9 13.1 10.5 13.1 7.4 0 14-5.3 19.9-13.4.5 8.1 4.9 12.8 11.1 12.8 6.4 0 11.8-4.1 11.4-8.7-.3-3.4-3.3-1.9-5.4-2.2zm31.2-74.4c3.9 0-6.8 28.1-26.5 43.7 8.4-20.6 21.8-43.7 26.5-43.7zM124 722.7c6.8 0 2.6 18.9-15.4 18.9h-.2c4.2-9.8 11.1-18.9 15.6-18.9zm60.4 40.3c-10.2 0 7-38.4 16.7-38.4 3.7 0 5 2.4 5.5 4.5-7.9 18.5-14.5 33.9-22.2 33.9z" />
                                        </g>
                                    </svg>
                                </div>
                                <span class="tagline">YOURS FOR THE SAVING&trade;</span>
                            </div>
                        </div>
                        <div class="site-footer-secondary-links">
                            <ul>
                                <li>
                                    <a href="/static/terms/">Terms of Use</a>
                                </li>
                                <li>
                                    <a href="/static/privacy/">Privacy Policy</a>
                                </li>
                                <li>
                                    <a href="/sitemap/">Sitemap</a>
                                </li>
                                <li>
                                    <a href="/static/privacy/#ad-choices">Ad Choices</a>
                                </li>
                                <li>
                                        <span class="copyright">
				                            &copy;2017 RetailMeNot, Inc.
				                        </span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

            </footer>
        </div>
    </div>
</div>

<div class="svg-content">
    <svg xmlns="http://www.w3.org/2000/svg">
        <symbol viewBox="0 0 16 16" id="icon-airplane">
            <title>airplane</title>
            <path class="cls-1" d="M4.82 16h-.15a.67.67 0 0 1-.48-.43l-1-2.8-2.8-1a.67.67 0 0 1-.2-1.07L1.72 9c.13-.13.3-.36.47-.36H4L5.75 7.1.35 3.58a.6.6 0 0 1-.3-.45.63.63 0 0 1 .2-.52L1.85 1A1.76 1.76 0 0 1 3.77.68l5.47 3.08L12.42.6a2.14 2.14 0 0 1 3 0 2.1 2.1 0 0 1 0 3l-3.2 3.14 3.05 5.42a1.77 1.77 0 0 1-.33 2l-1.6 1.6a.67.67 0 0 1-1-.1L8.6 10.23 6.72 12v1.86c0 .18.07.35-.06.47L5.23 15.8a.52.52 0 0 1-.4.2zm4-7.48a.6.6 0 0 1 .55.3L13 14.24l1-1a.4.4 0 0 0 .08-.46L10.8 7a.67.67 0 0 1 .12-.8l3.53-3.53a.77.77 0 0 0-1.08-1.1l-3.53 3.5a.67.67 0 0 1-.8.1l-5.86-3.3h-.1a.4.4 0 0 0-.3.13l-1 1 5.4 3.6a.67.67 0 0 1 .1 1L4.85 9.9a.86.86 0 0 1-.55.1H2.47l-.57.73 2.07.8a.73.73 0 0 1 .4.45l.63 2.1.43-.54v-1.86c0-.18.2-.35.33-.47L8.3 8.73a.84.84 0 0 1 .53-.2z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-alert">
            <title>alert</title>
            <path d="M14.8 11.7l-5.6-9c-.5-.9-1.7-.9-2.3 0l-5.6 9.1c-.6 1 0 2.3 1.1 2.3h11.3c1-.1 1.7-1.4 1.1-2.4zm-2.3.9h-9c-.5 0-.9-.7-.6-1.1l4.5-7.2c.3-.4.9-.4 1.1 0l4.5 7.2c.4.5 0 1.1-.5 1.1z" />
            <path d="M8.3 9.3h-.6c-.2 0-.4-.1-.4-.3V6.3c0-.1.2-.3.4-.3h.7c.2 0 .3.1.3.3V9c0 .2-.2.3-.4.3zM8.3 11.3h-.6c-.2 0-.3-.2-.3-.3v-.7c0-.2.1-.3.3-.3h.7c.2 0 .3.2.3.3v.7c0 .2-.2.3-.4.3z" />
        </symbol>
        <symbol viewBox="0 0 110.2 110.2" id="icon-app-download">
            <title>app-download</title>
            <g>
                <path d="M110.2,55.1C110.2,24.7,85.5,0,55.1,0S0,24.7,0,55.1c0,22,13,41.1,31.7,49.9l0.1-1l-2.1-21.5l24.8,0
			l-1.8-6.1l23.4,0.2c0,0,1.6,8.2-0.3,12.4c-2,4.5-13.8,15.1-14.5,15.7l-0.2,3.5l0.3,1.6C88.8,106.8,110.2,83.4,110.2,55.1z" fill="#F1F1F1" />
                <path d="M61.3,104.8C62,104.1,73.8,93.5,75.8,89c1.9-4.2,0.3-12.4,0.3-12.4l-23.4-0.2l1.8,6.1l-24.8,0l2.1,21.5
			l-0.1,1c7.1,3.4,15.1,5.2,23.4,5.2c2.1,0,4.2-0.1,6.2-0.4l-0.3-1.6L61.3,104.8z" fill="#DDAE7C" /> </g>
            <path fill-rule="evenodd" clip-rule="evenodd" d="M79.7,25.5c3.7-2.2,6.6,0.6,6.6,0.6c1.5,1.6,1.5,3.9-0.4,6.2
		c-2,2.5-9.5,10.8-9.5,10.8c-1.6,1.5-4.1,1.5-5.6,0l-2.2-2.7c-1.5-1.6-1.5-4.1,0-5.6C68.6,34.6,76.6,27.3,79.7,25.5z" fill="#DDAE7C" />
            <path d="M73.2,88.8l-35.1,0c-2.1,0-3.9-1.7-3.9-3.9l0.1-60.6c0-2.1,1.7-3.9,3.9-3.9l35.1,0c2.1,0,3.9,1.7,3.9,3.9
		L77.1,85C77.1,87.1,75.4,88.8,73.2,88.8z" fill="#3F3F3F" />
            <path d="M72.8,82.5l-34.1,0c-2.4,0-4.4-2-4.4-4.4l0-59.7c0-2.4,2-4.4,4.4-4.4l34.1,0c2.4,0,4.4,2,4.4,4.4l0,59.7
		C77.1,80.5,75.1,82.5,72.8,82.5z" fill="#1C1C1C" />
            <rect x="38.1" y="20.4" width="35.2" height="54.3" fill="#602D6C" />
            <path fill-rule="evenodd" clip-rule="evenodd" d="M38.6,60.9L37.9,47c0-3.7-2-6.6-4.6-6.6l-1.1,0
		c-2.5,0-4.7,3.1-4.7,6.9l-0.9,12.6c-0.2,4,1.1,14.9,1.1,14.9l4.4,26.6c0,0,10.7-0.6,22-1.4l0.5-1.4C60,81.1,43.5,65.2,38.6,60.9z" fill="#DDAE7C" />
            <ellipse fill-rule="evenodd" clip-rule="evenodd" cx="77.4" cy="68" rx="4.9" ry="5.7" fill="#DDAE7C" />
            <ellipse fill-rule="evenodd" clip-rule="evenodd" cx="77.4" cy="56.9" rx="4.9" ry="5.7" fill="#DDAE7C" />
            <ellipse fill-rule="evenodd" clip-rule="evenodd" cx="77.4" cy="45.7" rx="4.9" ry="5.7" fill="#DDAE7C" />
            <path d="M65.8,50.1c-0.6,0.2-1.8,0.4-2.6,0c-0.8-0.3-1.3-1.2-1.9-2.8c-0.5-1.4-1.3-3.7-1.9-5.4
		c5.9-2.1,8.6-4.8,8.6-7.8c0-2.8-2.3-4.7-7.4-4c-2.3,0.3-3.9,0.6-5.6,0.9c-6.5,1.3-9,4.1-9,7c0,2,1.7,3.3,3.7,3.3
		c1.4,0,1.5-0.8,1.1-1.1c-0.8-0.6-1.4-1.3-1.4-2.4c0-1.7,1.3-3.9,6-4.9c0.3-0.1,0.6-0.1,0.8-0.2c-0.8,2.2-2.2,6.1-3.4,9.5
		c-7.2,2.9-9.4,6.8-9.4,9.6c0,2,1.6,3.2,3.5,3.2c2.9,0,5.2-1.9,7-6.3c0.7-1.7,1.5-3.7,2.2-5.7c0.5,1.8,1.3,4,1.8,5.4
		c0.5,1.4,1,2.4,1.7,3.1c0.9,0.9,1.9,1.3,3.3,1.3c1.8,0,3-0.9,3.5-1.8C66.8,50.3,66.4,49.9,65.8,50.1z M50.6,47.8
		c-1.6,3.3-2.6,4.6-3.8,4.8c-0.6,0.1-1-0.2-1-1c0-0.9,1-4.3,6.1-6.9C51.4,46,51,47.1,50.6,47.8z M57,40.7c1.2-3.4,2.4-6.7,3-8.6
		c2.7-0.3,4.1,0.5,4.1,2.6c0,2-1.7,3.9-5.3,5.3C58.2,40.3,57.6,40.5,57,40.7z" fill="#FFFFFF" /> </symbol>
        <symbol viewBox="0 0 16 16" id="icon-arrow-down">
            <title>arrow-down</title>
            <path class="cls-1" d="M15.7 4.3a1 1 0 0 0-1.4 0L8 9.6 1.75 4.3a1 1 0 0 0-1.42 0 .94.94 0 0 0 0 1.36l7 6a1 1 0 0 0 1.42 0l7-6a.94.94 0 0 0-.04-1.33z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-arrow-expand">
            <title>arrow-expand</title>
            <path d="M7.2 8.9c-.3-.3-.7-.3-.9 0l-2.9 2.9v-.6c0-.4-.3-.7-.7-.7s-.7.3-.7.7v2.2c0 .4.3.7.7.7h2.2c.4 0 .7-.3.7-.7 0-.4-.3-.7-.7-.7h-.6l2.9-2.9c.2-.2.2-.6 0-.9zM8.9 7.2c.3.3.7.3.9 0l2.9-2.9V5c0 .4.3.7.7.7s.6-.3.6-.7V2.7c0-.4-.3-.7-.7-.7h-2.2c-.4 0-.7.3-.7.7s.3.7.7.7h.6L8.9 6.3c-.3.2-.3.7 0 .9z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-arrow-left">
            <title>arrow-left</title>
            <path class="cls-1" d="M11.7 15.7a1 1 0 0 0 0-1.4L6.4 8l5.32-6.25a1 1 0 0 0 0-1.42.94.94 0 0 0-1.36 0l-6 7a1 1 0 0 0 0 1.42l6 7a.94.94 0 0 0 1.33-.04z" />
        </symbol>
        <symbol viewBox="0 0 24 24" id="icon-arrow-right-alternate">
            <title>arrow-right-alternate</title>
            <path d="m15.3 5.7l5.3 5.3h-19.6c-.6 0-1 .4-1 1 0 .6.4 1 1 1h19.6l-5.3 5.3c-.4.4-.4 1 0 1.4.4.4 1 .4 1.4 0l7-7c.2-.2.3-.5.3-.7 0-.3-.1-.5-.3-.7l-7-7c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-arrow-right">
            <title>arrow-right</title>
            <path class="cls-1" d="M4.3 15.7a1 1 0 0 1 0-1.4L9.6 8 4.3 1.75a1 1 0 0 1 0-1.42.94.94 0 0 1 1.36 0l6 7a1 1 0 0 1 0 1.42l-6 7a.94.94 0 0 1-1.33-.04z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-arrow-up">
            <title>arrow-up</title>
            <path class="cls-1" d="M15.7 11.7a1 1 0 0 1-1.4 0L8 6.4 1.75 11.7a1 1 0 0 1-1.42 0 .94.94 0 0 1 0-1.36l7-6a1 1 0 0 1 1.42 0l7 6a.94.94 0 0 1-.04 1.33z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-attraction">
            <title>attraction</title>
            <path d="M15.4 14.7h-1V9.6c.9-.4 1.6-1.5 1.6-2.5 0-.1 0-.3-.1-.3L8.7 2.3v-.4l1.4-.4c.4-.2.3-.6 0-.8L8.3 0c-.5-.1-1 .2-1 .7v1.5C7.2 2.2.1 6.7.1 6.7c-.1.1-.1.3-.1.4.1 1 .7 2.1 1.7 2.5v5h-1c-.4.1-.7.4-.7.7 0 .4.3.7.6.7h14.8c.4 0 .6-.3.6-.6 0-.4-.3-.7-.6-.7zM8.7 3.8l4 2.2h-4V3.8zm-1.4 0V6h-4l4-2.2zM1.4 7.3h13.3c-.1.5-.4.9-.8 1.1-.6.2-1-.5-1.6-.5-.5 0-.8.4-1.3.5-.7.1-1-.5-1.6-.5-.5 0-.9.5-1.4.5s-.8-.5-1.4-.5c-.5 0-.9.5-1.4.5s-.8-.5-1.4-.5-1 .5-1.6.5c-.4-.1-.8-.6-.8-1.1zm2.1 7.3c-.3 0-.5-.1-.5-.4V9.7c.3-.1.6-.2.9-.4.8.6 2 .7 2.8 0 .2.2.5.3.7.4v1.1c-.8.2-1.4.9-1.4 1.7v2.1H3.5zm3.8.1v-2.1c0-.3.2-.5.5-.5h.3c.3 0 .5.2.5.5v2.1H7.3zm2.7 0v-2.1c0-.8-.6-1.5-1.3-1.8V9.6c.3-.1.5-.2.7-.4.8.6 2 .8 2.8 0 .3.2.5.4.8.4v4.5c0 .3-.2.5-.5.5H10v.1z" />
        </symbol>
        <symbol viewBox="0 0 21 21" id="icon-badge">
            <title>badge</title>
            <path d="M15 17.9l2.5 0.5c0.3 0.1 0.5-0.1 0.8-0.3 0.2-0.2 0.1-0.5-0.1-0.9l-2-4.2c-0.2-0.5-0.7-0.7-1.2-0.5 -0.4 0.2-0.5 0.7-0.4 1.2l1.2 2.6 -1.3-0.4c-0.4-0.1-0.7 0.1-0.9 0.4l-0.8 1.4L11.5 15c-0.2-0.4-0.5-0.6-0.9-0.5 -0.4 0-0.7 0.2-0.9 0.6l-1 2.7L8 16.6c-0.2-0.3-0.5-0.4-0.9-0.3l-1.5 0.4 1-2.7c0.2-0.5 0-1-0.5-1.2S5.2 12.9 5 13.3l-1.6 4.4c-0.1 0.3-0.2 0.6 0 0.9 0.1 0.1 0.1 0.1 0.2 0.2 0.2 0.1 0.4 0.1 0.5 0l2.7-0.7 1.4 2.1c0.2 0.3 0.4 0.4 0.8 0.4s0.5-0.3 0.6-0.6l1-2.7 1.3 2.7c0.1 0.3 0.2 0.6 0.6 0.6 0.2 0 0.2 0.1 0.3 0 0.1-0.1 0.2-0.2 0.4-0.4L15 17.9z" />
            <path d="M5.2 10.2c0 0.6-0.1 1.3 0.5 2 0.6 0.6 1.4 0.5 2 0.5 0.2 0 0.5 0 0.5 0 0.1 0.1 0.3 0.2 0.4 0.4 0.4 0.4 1 1 1.8 1 0.7 0 1.2-0.4 1.6-0.8l0.4-0.4c0.2-0.2 0.2-0.2 0.3-0.2 0.1 0 0.4 0 0.5 0 0.6 0 1.4 0.1 2-0.5s0.5-1.4 0.5-2c0-0.2 0-0.5 0-0.5s0.1-0.1 0.2-0.3L16.3 9c0.4-0.4 0.8-0.9 0.8-1.6 0-0.8-0.5-1.3-1-1.7 -0.1-0.1-0.4-0.4-0.4-0.4 -0.1-0.1 0-0.4 0-0.5 0-0.6 0.1-1.3-0.5-2 -0.6-0.6-1.5-0.5-2.1-0.5 -0.2 0-0.5 0-0.5 0 -0.1-0.1-0.3-0.2-0.4-0.4C11.8 1.5 11.3 1 10.6 1S9.5 1.5 9.1 1.9L8.7 2.3C8.5 2.5 8.4 2.4 8.4 2.4c-0.1 0.1-0.4 0-0.6 0 -0.6 0-1.4-0.1-2 0.5s-0.5 1.3-0.5 2c0 0.2 0.1 0.5 0.1 0.6 0 0 0.1 0.2-0.2 0.4L4.8 6.2C4.4 6.6 3.9 7 3.9 7.7c0 0.8 0.5 1.3 1 1.7C5 9.5 5.3 9.7 5.3 9.8 5.3 9.7 5.2 10 5.2 10.2zM6.2 7.7C6.1 7.6 6 7.5 5.8 7.3c0 0.1 0 0 0.2-0.1l0.4-0.4c0.2-0.2 0.5-0.5 0.7-0.9S7.3 5 7.3 4.6c0-0.1 0-0.4 0-0.5 0.1 0 0.4 0 0.5 0 0.4 0 0.9 0 1.3-0.2S9.7 3.5 10 3.2l0.4-0.4c0.1-0.1 0.1-0.1 0.2-0.2C10.7 2.7 10.8 2.8 11 3c0.3 0.3 0.7 0.7 1.1 0.9 0.4 0.2 0.9 0.2 1.3 0.2 0.1 0 0.4 0 0.5 0 0 0.1 0 0.4 0 0.5 0 0.4 0 0.9 0.2 1.3C14.3 6.4 14.6 6.7 15 7c0.1 0 0.2 0.2 0.4 0.3 -0.1 0.1-0.1 0.1-0.2 0.2l-0.4 0.3c-0.2 0.2-0.5 0.5-0.7 0.9s-0.2 0.9-0.2 1.3c0 0.1 0 0.4 0 0.5 -0.1 0-0.4 0-0.5 0 -0.4 0-0.9 0-1.3 0.2s-0.7 0.4-0.9 0.7l-0.4 0.4c-0.1 0.1-0.1 0.1-0.2 0.2 -0.1-0.1-0.2-0.2-0.4-0.4 -0.3-0.3-0.7-0.7-1.1-0.9 -0.4-0.2-0.9-0.1-1.3-0.1 -0.1 0-0.4 0-0.5 0 0-0.1 0-0.4 0-0.5 0-0.4 0-0.9-0.2-1.3" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-balloons">
            <title>balloons</title>
            <path class="cls-1" d="M16 5.85a4 4 0 0 0-4-3.93h-.16a4.77 4.77 0 0 0-7.67 0H4a4 4 0 0 0-4 3.93c0 1.92 1.5 4.7 3.64 5a1.83 1.83 0 0 1 .36.88 1.4 1.4 0 0 1-.53 1.07 2.58 2.58 0 0 0-.86 1.92.67.67 0 0 0 1.34 0 1.4 1.4 0 0 1 .52-1.07 2.58 2.58 0 0 0 .86-1.92 2.48 2.48 0 0 0-.28-1.07 3.85 3.85 0 0 0 1.28-.9 3.5 3.5 0 0 0 1.26.44A3 3 0 0 1 8 11.52a2.3 2.3 0 0 1-.58 1.55 3.52 3.52 0 0 0-.8 2.3.67.67 0 0 0 1.32 0 2.3 2.3 0 0 1 .58-1.56 3.52 3.52 0 0 0 .8-2.27A3.76 3.76 0 0 0 9 10.08a3.7 3.7 0 0 0 .67-.3 3.47 3.47 0 0 0 2 1.08 1.83 1.83 0 0 1 .36.88 1.4 1.4 0 0 1-.53 1.07 2.58 2.58 0 0 0-.86 1.93.67.67 0 0 0 1.33 0 1.4 1.4 0 0 1 .52-1.07 2.58 2.58 0 0 0 .85-1.92 2.5 2.5 0 0 0-.28-1.07A5.65 5.65 0 0 0 16 5.85zM8 1.28a3.27 3.27 0 0 1 3.33 3.2C11.33 6.4 9.7 9 8 9S4.67 6.4 4.67 4.48A3.27 3.27 0 0 1 8 1.28zM4 9.6c-1.35 0-2.67-2.15-2.67-3.75a2.65 2.65 0 0 1 2.18-2.6 4.3 4.3 0 0 0-.17 1.23 6.93 6.93 0 0 0 2 4.5A1.94 1.94 0 0 1 4 9.6zm8 0a1.94 1.94 0 0 1-1.3-.6 6.93 6.93 0 0 0 2-4.5 4.3 4.3 0 0 0-.17-1.23 2.65 2.65 0 0 1 2.18 2.6C14.68 7.45 13.36 9.6 12 9.6z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-barcode">
            <title>barcode</title>
            <path class="cls-1" d="M14.7 2H1.3A1.3 1.3 0 0 0 0 3.3v9.4A1.3 1.3 0 0 0 1.3 14h13.4a1.3 1.3 0 0 0 1.3-1.3V3.3A1.3 1.3 0 0 0 14.7 2zm.2 10.7a.3.3 0 0 1-.3.2H1.3a.3.3 0 0 1-.2-.3V3.3a.3.3 0 0 1 .3-.2h13.4a.3.3 0 0 1 .2.3z" />
            <rect class="cls-1" x="2" y="4" width="1.7" height="8" rx=".8" ry=".8" />
            <rect class="cls-1" x="5" y="4" width=".8" height="8" rx=".4" ry=".4" />
            <rect class="cls-1" x="7.2" y="4" width="1.7" height="8" rx=".8" ry=".8" />
            <rect class="cls-1" x="10.2" y="4" width=".8" height="8" rx=".4" ry=".4" />
            <rect class="cls-1" x="12.3" y="4" width="1.7" height="8" rx=".8" ry=".8" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-bell">
            <title>bell</title>
            <path class="cls-1" d="M14 12.67H8.67v-1.34h6.67a.66.66 0 0 0 .66-.67c0-.36 0-.65-.66-.66a7.33 7.33 0 0 0-6.67-7.3V1.33h.67a.67.67 0 1 0 0-1.33H6.66a.67.67 0 1 0 0 1.33h.67V2.7A7.35 7.35 0 0 0 .67 10a.67.67 0 1 0 0 1.33h6.66v1.33H2a2 2 0 0 0-2 2v.67a.67.67 0 0 0 .67.67h14.66a.67.67 0 0 0 .67-.67v-.67a2 2 0 0 0-2-2zM8 4a6 6 0 0 1 6 6H2a6 6 0 0 1 6-6zM1.33 14.67A.67.67 0 0 1 2 14h12a.67.67 0 0 1 .67.67z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-book">
            <title>book</title>
            <path class="cls-1" d="M15.75 2.72a.67.67 0 0 0-.57-.12L14 2.88v-.62A1.23 1.23 0 0 0 12.77 1 8.36 8.36 0 0 0 8 2.3 9.5 9.5 0 0 0 3.16 1 1.17 1.17 0 0 0 2 2.26v.63L.82 2.6a.67.67 0 0 0-.82.65v9.28a.67.67 0 0 0 .57.66l5.48.8a1.65 1.65 0 0 0 1.5 1h.9a1.65 1.65 0 0 0 1.5-1l5.5-.84a.67.67 0 0 0 .56-.66V3.25a.67.67 0 0 0-.25-.53zm-7.08.75a8 8 0 0 1 4-1.1v7.36a9.8 9.8 0 0 0-4 .8zm-5.34-1.1c2.55.14 3.63.8 4 1.1v7a10.14 10.14 0 0 0-4-.85zM14.67 12l-5.36.82a.67.67 0 0 0-.56.66.3.3 0 0 1-.3.24h-.9a.3.3 0 0 1-.28-.24.67.67 0 0 0-.57-.66L1.32 12V4.1l.67.16v5.47A1.23 1.23 0 0 0 3.17 11a7.64 7.64 0 0 1 3.77.84l.07.05a1.7 1.7 0 0 0 1 .44h.15a2 2 0 0 0 .85-.46h.06c.6-.44 1.8-.7 3.75-.78A1.28 1.28 0 0 0 14 9.73V4.25l.67-.16z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-building">
            <title>building</title>
            <path class="cls-1" d="M6 4.67h1.33v2H6zm-2.67 0h1.33v2H3.33zM12 7.33h1.33v2H12zm0 3.34h1.33v2H12zM3.33 8h1.33v2H3.33zM6 8h1.33v2H6z" />
            <path class="cls-1" d="M15.33 2.67h-4.66v-2A.67.67 0 0 0 10 0H.67A.67.67 0 0 0 0 .67v14.66a.67.67 0 0 0 .67.67h14.66a.67.67 0 0 0 .67-.67v-12a.67.67 0 0 0-.67-.66zM14.67 4v.67h-4V4zM1.33 1.33h8V2h-8zm0 2h8v11.34h-2V12a.67.67 0 0 0-.67-.67H4a.67.67 0 0 0-.67.67v2.67h-2zm3.34 11.34v-2H6v2zm6 0V6h4v8.67z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-calendar">
            <title>calendar</title>
            <path d="M16 2.1c0-.4-.3-.7-.7-.7h-2.1V.7c0-.4-.3-.7-.7-.7-.4 0-.7.3-.7.7v.7H4.7V.7c0-.3-.3-.7-.6-.7-.4 0-.7.2-.8.6v.8H.7c-.4 0-.7.3-.7.7v13.3c0 .3.3.6.7.6h14.6c.4 0 .7-.2.7-.6V2.1zM5.9 6.7v1.8H4.3V6.7h1.6zm2.9 0v1.8H7.2V6.7h1.6zM5.9 9.8v1.7H4.3V9.8h1.6zm1.3 0h1.6v1.7H7.2V9.8zm2.9 0h1.6v1.7h-1.6V9.8zm0-1.3V6.7h1.6v1.8h-1.6zm3-1.8h1.6v1.8h-1.6V6.7zM1.3 3.4c0-.4.3-.7.7-.7h1.3v.7c0 .4.2.7.6.7.4 0 .7-.2.7-.6v-.8h7.2v.7c0 .4.3.7.7.7.4 0 .7-.3.7-.7v-.7h.8c.4 0 .7.3.7.7v2H1.3v-2zm0 3.3h1.6v1.8H1.3V6.7zm0 3.1h1.6v1.7H1.3V9.8zm.7 4.9c-.4 0-.7-.3-.7-.7v-1.1h1.6v1.8H2zm2.3 0v-1.8h1.6v1.8H4.3zm2.9 0v-1.8h1.6v1.8H7.2zm2.9 0v-1.8h1.6v1.8h-1.6zm4.6 0h-1.6v-1.8h1.6v1.8zm0-3.1h-1.6V9.8h1.6v1.8z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-camera">
            <title>camera</title>
            <path class="cls-1" d="M14.33 3.67h-2.18a.33.33 0 0 1-.33-.27l-.25-1.24a.7.7 0 0 0 0-.1A1.66 1.66 0 0 0 10 1H6a1.66 1.66 0 0 0-1.54 1 .7.7 0 0 0 0 .1l-.28 1.3a.33.33 0 0 1-.33.27H1.67A1.67 1.67 0 0 0 0 5.33v8A1.67 1.67 0 0 0 1.67 15h12.66A1.67 1.67 0 0 0 16 13.33v-8a1.67 1.67 0 0 0-1.67-1.66zm.33 9.67a.33.33 0 0 1-.33.33H1.67a.33.33 0 0 1-.33-.33v-8A.33.33 0 0 1 1.67 5h2.18a1.67 1.67 0 0 0 1.63-1.33l.24-1.17A.33.33 0 0 1 6 2.33h4a.33.33 0 0 1 .3.17l.23 1.16A1.67 1.67 0 0 0 12.15 5h2.18a.33.33 0 0 1 .33.33z" />
            <path class="cls-1" d="M11.33 9A3.33 3.33 0 1 0 8 12.33 3.34 3.34 0 0 0 11.33 9M8 11a2 2 0 1 1 2-2 2 2 0 0 1-2 2z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-car">
            <title>car</title>
            <path class="cls-1" d="M14.47 5.35L12.87 1a1.6 1.6 0 0 0-1.56-1H4.7a1.6 1.6 0 0 0-1.57 1l-1.6 4.35A1.66 1.66 0 0 0 0 7v4.67a1.67 1.67 0 0 0 1.33 1.63v1A1.67 1.67 0 0 0 3 16h.67a1.67 1.67 0 0 0 1.67-1.67v-1h5.33v1A1.67 1.67 0 0 0 12.33 16H13a1.67 1.67 0 0 0 1.67-1.67v-1A1.67 1.67 0 0 0 16 11.67V7a1.66 1.66 0 0 0-1.53-1.65zM4.37 1.48c0-.13.23-.15.32-.15h6.6c.1 0 .26 0 .3.15L13 5.33H3zM4 14.33a.33.33 0 0 1-.33.33H3a.33.33 0 0 1-.33-.33v-1H4zm9.33 0a.33.33 0 0 1-.33.33h-.67a.33.33 0 0 1-.33-.33v-1h1.33zm1.33-2.67a.33.33 0 0 1-.33.33H1.67a.33.33 0 0 1-.33-.34V7a.33.33 0 0 1 .33-.33h12.66a.33.33 0 0 1 .33.33z" />
            <circle class="cls-1" cx="4" cy="9.33" r="1.33" />
            <circle class="cls-1" cx="12" cy="9.33" r="1.33" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-cart">
            <title>cart</title>
            <circle class="cls-1" cx="5.33" cy="14.67" r="1.33" />
            <circle class="cls-1" cx="12.67" cy="14.67" r="1.33" />
            <path class="cls-1" d="M14 8.88l2-6a.67.67 0 0 0-.67-.88H3L2.65.5A.67.67 0 0 0 2 0H.67a.67.67 0 0 0 0 1.33h.8l2.36 9.4A1.66 1.66 0 0 0 5.45 12h7.9a.67.67 0 0 0 0-1.33h-7.9a.33.33 0 0 1-.32-.25l-.28-1.1h8.48A.67.67 0 0 0 14 8.9zM4.52 8L3.35 3.33H14.4L12.86 8z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-cash-back">
            <title>cash-back</title>
            <path class="cls-1" d="M8 4a.62.62 0 0 0-.64.6v.68c-1.1.2-1.9.9-1.9 1.77 0 .68.32 1.83 2.54 1.83.58 0 1.27.1 1.27.6 0 .26-.5.62-1.27.62a1.75 1.75 0 0 1-1.12-.3.65.65 0 0 0-.9 0 .6.6 0 0 0 0 .86 2.75 2.75 0 0 0 1.36.62V12a.64.64 0 0 0 1.27 0v-.67c1.12-.2 1.92-.9 1.92-1.77S9.88 7.7 8 7.7c-1.27 0-1.27-.4-1.27-.6s.5-.6 1.27-.6a1.75 1.75 0 0 1 1.12.34.65.65 0 0 0 .9 0 .6.6 0 0 0 0-.86 2.75 2.75 0 0 0-1.36-.62v-.7A.62.62 0 0 0 8 4z" />
            <path class="cls-1" d="M15.9 7.07A7.9 7.9 0 0 0 9.06.7a8.33 8.33 0 0 0-3.4.3A8.12 8.12 0 0 0 4 1.65l.2-.8A.67.67 0 0 0 4.1.3.73.73 0 0 0 3.64 0H3.3l-.14.1h-.1a.7.7 0 0 0-.12.1L2.9.33a.68.68 0 0 0-.12.24l-.54 2.52v.2a.7.7 0 0 0 .56.83l.32.07 2.53.5h.32a.74.74 0 0 0 .23-.1.7.7 0 0 0-.3-1.25L4.47 3a6.65 6.65 0 0 1 2.28-.88 6.5 6.5 0 0 1 4.1.54 6.37 6.37 0 0 1 3.67 5 6.44 6.44 0 0 1-7.36 6.86 6.46 6.46 0 0 1-5.6-5.1 6 6 0 0 1 .3-3.34.65.65 0 0 0-.4-.92.78.78 0 0 0-1 .56 7.38 7.38 0 0 0-.32 4 7.86 7.86 0 0 0 6.5 6.16 7.86 7.86 0 0 0 9.26-8.8z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-chair">
            <title>chair</title>
            <path class="cls-1" d="M15.16 4.65a2.43 2.43 0 0 0-1.94-.58 2.34 2.34 0 0 0-.92.32V3.13A2.15 2.15 0 0 0 10.15 1H5.88A2.16 2.16 0 0 0 3.7 3.14V4.4a2.35 2.35 0 0 0-.95-.34 2.42 2.42 0 0 0-1.9.58A2.57 2.57 0 0 0 0 6.58 2.45 2.45 0 0 0 1.86 9v2.3c0 .45 0 .83.6 1.06v1.1A1.48 1.48 0 0 0 3.97 15h.6a1.6 1.6 0 0 0 1.6-1.53v-.86h3.68v.87a1.6 1.6 0 0 0 1.6 1.53h.6a1.48 1.48 0 0 0 1.48-1.53v-1.1c.6-.23.58-.62.58-1.06V9.03a2.58 2.58 0 0 0 1-4.38zM4.93 3.15a.94.94 0 0 1 .95-.93h4.27a.92.92 0 0 1 .92.92v5.2a.6.6 0 0 1-.6.6H5.53a.6.6 0 0 1-.6-.6V6.54c0-.07 0 0 0 0zm0 10.32a.37.37 0 0 1-.37.3h-.6c-.18 0-.26-.13-.26-.3v-.86h1.23zm7.37 0c0 .17-.08.3-.25.3h-.6a.37.37 0 0 1-.38-.3v-.86h1.23zm1.52-5.62a1.23 1.23 0 0 0-.9 1.15v2.3a.07.07 0 0 1-.07.07h-9.7a.07.07 0 0 1-.07-.07V9a1.22 1.22 0 0 0-.92-1.16 1.3 1.3 0 0 1-.94-1.28 1.35 1.35 0 0 1 .43-1 1.2 1.2 0 0 1 1-.28A1.3 1.3 0 0 1 3.7 6.6v1.73a1.84 1.84 0 0 0 1.84 1.83h4.9a1.84 1.84 0 0 0 1.86-1.83V6.6a1.3 1.3 0 0 1 1.07-1.32 1.24 1.24 0 0 1 1 .3 1.34 1.34 0 0 1 .44 1 1.32 1.32 0 0 1-.98 1.27z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-chat-dots">
            <title>chat-dots</title>
            <circle class="cls-1" cx="4.51" cy="8" r="1.05" />
            <circle class="cls-1" cx="7.97" cy="8" r="1.05" />
            <circle class="cls-1" cx="11.49" cy="8" r="1.05" />
            <path class="cls-1" d="M8 1C3.58 1 0 4.13 0 8a6.3 6.3 0 0 0 1.05 3.46 4 4 0 0 1-.85 2.4.62.62 0 0 0 0 .9c.45.5 1.78.06 1.78.06A16.6 16.6 0 0 0 4 14a8.84 8.84 0 0 0 4 1c4.42 0 8-3.13 8-7s-3.58-7-8-7zm0 12.66a7 7 0 0 1-3.66-1 .73.73 0 0 0-.82 0 4.35 4.35 0 0 1-1.52.78 6.45 6.45 0 0 0 .4-2.18.64.64 0 0 0-.12-.37 5.07 5.07 0 0 1-.9-2.9c0-3.12 3-5.67 6.62-5.67s6.5 2.45 6.6 5.5c-.1 3.23-3.02 5.83-6.6 5.83z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-chat">
            <title>chat</title>
            <path class="cls-1" d="M15.24 13.26a4.87 4.87 0 0 0 .76-2.6 5.2 5.2 0 0 0-2.7-4.44v-.1a.68.68 0 0 0 0-.13V5.7a.67.67 0 0 0 0-.14A6.42 6.42 0 0 0 6.66 0C3 0 0 2.7 0 6a5.55 5.55 0 0 0 .85 2.94 3.28 3.28 0 0 1-.67 1.94.67.67 0 0 0 .5 1.12 5.56 5.56 0 0 0 2.7-.8 6.7 6.7 0 0 0 .7.3A5.92 5.92 0 0 0 10 16a6.37 6.37 0 0 0 2.92-.7 5.12 5.12 0 0 0 2.44.7.67.67 0 0 0 .48-1.13 2.72 2.72 0 0 1-.6-1.6zM3.34 9.73a.67.67 0 0 0-.4.15 3.32 3.32 0 0 1-1 .54 5.76 5.76 0 0 0 .26-1.67.66.66 0 0 0-.1-.37A4.24 4.24 0 0 1 1.33 6c0-2.57 2.4-4.67 5.32-4.67s5.24 2 5.32 4.53a5.16 5.16 0 0 1-5.32 4.8 5.53 5.53 0 0 1-3-.83.67.67 0 0 0-.3-.1zM14.1 14.4a2.8 2.8 0 0 1-.75-.4.67.67 0 0 0-.77 0 5 5 0 0 1-2.6.7 4.68 4.68 0 0 1-4.4-2.75 7.1 7.1 0 0 0 1.08.05A6.64 6.64 0 0 0 13 7.63a3.8 3.8 0 0 1 1.66 3 3.57 3.57 0 0 1-.65 2 .66.66 0 0 0-.1.38 5.1 5.1 0 0 0 .2 1.4z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-check-circle">
            <title>check-circle</title>
            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm4.2 6.3l-4.4 4.4c-.1.1-.3.2-.5.2s-.4-.1-.5-.2L4.6 8.5c-.3-.3-.3-.7 0-1 .3-.3.7-.3 1 0l1.7 1.7 3.8-3.8c.3-.3.7-.3 1 0 .3.2.3.6.1.9z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-checkbox">
            <title>checkbox</title>
            <path class="cls-1" d="M14.18 0H1.82A1.82 1.82 0 0 0 0 1.82v12.36A1.82 1.82 0 0 0 1.82 16h12.36A1.82 1.82 0 0 0 16 14.18V1.82A1.82 1.82 0 0 0 14.18 0zm.36 14.18a.36.36 0 0 1-.36.36H1.82a.36.36 0 0 1-.36-.36V1.82a.36.36 0 0 1 .36-.36h12.36a.36.36 0 0 1 .36.36z" />
            <path class="cls-1" d="M11.12 5.3L7.27 9.15 5.6 7.5a.73.73 0 0 0-1 1l2.16 2.2a.73.73 0 0 0 1 0l4.36-4.36a.73.73 0 0 0-1-1z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-close">
            <title>close</title>
            <path class="cls-1" d="M8 0a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm0 14.67A6.67 6.67 0 1 1 14.67 8 6.67 6.67 0 0 1 8 14.67z" />
            <path class="cls-1" d="M10.27 9.13L9.13 8l1.13-1.13a.8.8 0 0 0-1.13-1.14L8 6.87 6.87 5.73a.8.8 0 0 0-1.14 1.14L6.87 8 5.73 9.13a.8.8 0 0 0 1.13 1.13L8 9.13l1.13 1.13a.8.8 0 1 0 1.13-1.13z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-computer">
            <title>computer</title>
            <path class="cls-1" d="M14.67 9.67h-.12V2.33A1.34 1.34 0 0 0 13.2 1H2.56A1.34 1.34 0 0 0 1.2 2.33v7.34A1.33 1.33 0 0 0 0 11v2.67A1.34 1.34 0 0 0 1.33 15h13.34A1.34 1.34 0 0 0 16 13.67V11a1.34 1.34 0 0 0-1.33-1.33zm-12-6.46a.67.67 0 0 1 .67-.66h9.33a.67.67 0 0 1 .67.67v6a.68.68 0 0 1-.67.68H3.34a.68.68 0 0 1-.67-.67zm12 10a.67.67 0 0 1-.67.68H2a.67.67 0 0 1-.67-.67V11.9A.67.67 0 0 1 2 11.2h4.27v.68a.67.67 0 0 0 .67.67H9.6a.67.67 0 0 0 .67-.67v-.67H14a.67.67 0 0 1 .67.68z" />
            <path class="cls-1" d="M4 9.2h8a.67.67 0 0 0 .67-.66V3.88A.67.67 0 0 0 12 3.2H4a.67.67 0 0 0-.67.68v4.66A.67.67 0 0 0 4 9.2zm.66-4.65h6.67v3.33H4.67z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-create">
            <title>create</title>
            <path class="cls-1" d="M13.5 16H.7a.68.68 0 0 1-.7-.68V2.57a.67.67 0 0 1 .7-.66h6.4a.67.67 0 1 1 0 1.35H1.34v11.4H12.8v-5.7a.67.67 0 1 1 1.36 0v6.37a.67.67 0 0 1-.67.68" />
            <path class="cls-1" d="M15.8 3.17l-3-3a.67.67 0 0 0-1 0L4.2 7.82a.68.68 0 0 0-.2.48v3a.7.7 0 0 0 .67.72h3a.7.7 0 0 0 .5-.22l7.63-7.65a.7.7 0 0 0 0-.98zm-8.43 7.5h-2v-2.1l4.9-4.84 2 2zm5.85-5.87l-2-2 1.14-1.13 2 2z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-cruise">
            <title>cruise</title>
            <path d="M16 14.2c-.8.5-1.4.6-2.3.3l.5-1 1.7-3.5c.2-.3 0-.8-.3-.9L14 8.4V5.3c0-.7-.6-1.3-1.3-1.3H12V2.7c0-.7-.6-1.3-1.3-1.3h-2V.7C8.7.3 8.3 0 8 0c-.4 0-.7.3-.7.7v.7h-2C4.6 1.3 4 1.9 4 2.7V4h-.7C2.6 4 2 4.6 2 5.3v3.1L.4 9c-.4.2-.5.6-.3 1l2.2 4.5c-.9.3-1.5.1-2.3-.3-.1.6.1 1.2.5 1.5.9.7 1.8 0 2.8-.3 1.3-.4 2.3.1 3.5.4.8.2 1.6.3 2.4 0 1.1-.3 1.9-.8 3.1-.5.9.2 1.9 1 2.8.6.7-.3 1-1 .9-1.7zm-9.5.2c-1.2-.5-2.2-.6-2.9-.4l-1.1-2.2 4.9-2.1V12c0 .4.3.7.7.7s.7-.3.7-.7V9.7l5 2.1-1.1 2.2c-2.1-.8-4.2 1.6-6.2.4zm7.9-4.4l-.3.7-5.4-2.4v-.6l5.7 2.3zM5.3 3.3c0-.3.3-.6.7-.6h4c.3 0 .7.3.7.7V4H5.3v-.7zM3.3 6c0-.4.3-.7.7-.7h8c.4 0 .7.3.7.7v1.8L8.5 6.2c-.2-.1-.4-.1-.5-.1-.1 0-.3 0-.5.1L3.3 7.8V6zm-1.7 4l5.7-2.3v.7l-5.4 2.3-.3-.7z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-emptybadge">
            <title>emptybadge</title>
            <path d="M14.9 6.1c-.3-.3-.5-.5-.6-.7s-.1-.6-.1-1c0-.7 0-1.5-.5-2.1-.5-.5-1.1-.5-1.7-.5h-.6c-.3 0-.5 0-.7-.1-.2-.1-.5-.3-.7-.6C9.4.6 8.8 0 8 0S6.6.6 6.1 1.1c-.2.3-.5.6-.7.6-.2.1-.5.1-.7.1h-.6c-.6 0-1.3.1-1.7.5-.5.6-.5 1.4-.5 2.1 0 .4 0 .8-.1 1-.1.2-.4.5-.7.7C.6 6.6 0 7.2 0 8s.6 1.4 1.1 1.9c.3.3.5.5.6.7s.1.6.1 1c0 .7 0 1.5.5 2.1.5.5 1.1.5 1.7.5h.6c.3 0 .5 0 .7.1.2.1.5.3.7.6.6.5 1.2 1.1 2 1.1s1.4-.6 1.9-1.1c.3-.3.5-.5.7-.6s.5-.1.7-.1h.6c.6 0 1.3-.1 1.7-.5.5-.5.5-1.3.5-2.1 0-.4 0-.8.1-1s.3-.5.6-.7C15.3 9.4 16 8.8 16 8s-.6-1.4-1.1-1.9zM14 8.9c-.3.3-.7.7-.9 1.2-.2.5-.2 1-.2 1.5 0 .4 0 .9-.1 1.1s-.6.1-.8.1h-.6c-.4 0-.8 0-1.2.2-.5.2-.8.6-1.2.9-.3.3-.7.7-.9.7s-.7-.3-1-.6c-.3-.4-.7-.7-1.2-.9-.4-.1-.8-.2-1.2-.2h-.6c-.2 0-.7 0-.8-.1-.1-.1-.1-.7-.1-1.1 0-.5 0-1.1-.2-1.5-.3-.5-.7-.9-1-1.3-.3-.3-.7-.6-.7-.9s.4-.6.7-.9c.3-.3.7-.7.9-1.2.2-.5.2-1 .2-1.5 0-.4 0-.9.1-1.1s.6-.1.8-.1h.6c.4 0 .8 0 1.2-.2.5-.3.9-.7 1.3-1 .3-.3.6-.7.9-.7.3 0 .6.4.9.7.3.4.7.7 1.2.9.4.1.8.2 1.2.2h.6c.2 0 .7 0 .8.1.1.1.1.7.1 1.1 0 .5 0 1.1.2 1.5s.6.8.9 1.2c.3.3.7.7.7.9s-.3.7-.6 1z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-envelope-open-outline">
            <title>envelope-open-outline</title>
            <path class="cls-1" d="M15.23 4.3L8.9.26a1.7 1.7 0 0 0-1.8 0L.77 4.3A1.67 1.67 0 0 0 0 5.7v8.62A1.67 1.67 0 0 0 1.67 16h12.66A1.67 1.67 0 0 0 16 14.33V5.7a1.67 1.67 0 0 0-.77-1.4zm-7.4-2.9a.33.33 0 0 1 .35 0l6.24 4a.66.66 0 0 0-.2.13L9.72 10H6.28L1.8 5.5a.66.66 0 0 0-.22-.14zm6.5 13.27H1.67a.33.33 0 0 1-.33-.33v-7.4l4.2 4.2a.66.66 0 0 0 .47.18h4a.66.66 0 0 0 .48-.2l4.2-4.18v7.4a.33.33 0 0 1-.35.32z" />
        </symbol>
        <symbol viewBox="0 0 612 792" id="icon-envelope-open">
            <title>envelope-open</title>
            <path class="icon-envelope-open-outline" d="M582.5,257.1L340.2,103c-20.5-13-47.9-13-68.5,0L29.5,257.1C11.1,268.9,0,289,0,310.9v328.3
		C0,674.4,28.6,703,63.8,703h484.5c35.2,0,63.7-28.6,63.7-63.7V310.9C612,289,600.9,268.9,582.5,257.1z" />
            <path class="icon-envelope-open-fill " d="M299.1,146c2.1-1.3,4.4-2,6.9-2s4.8,0.7,6.8,2l238.5,151.8c-2.8,1.2-5.5,2.9-7.8,5.2L372,473.5H240L68.5,302.9
		c-2.3-2.3-5-3.9-7.8-5.2L299.1,146z" />
            <path class="icon-envelope-open-fill " d="M548.2,652H63.7c-7,0-12.8-5.7-12.8-12.8V357.5L211.5,517c4.8,4.8,11.2,7.4,18,7.4h153c6.7,0,13.2-2.7,18-7.4
		L561,357.5v281.7C561,646.3,555.3,652,548.2,652z" /> </symbol>
        <symbol viewBox="0 0 16 16" id="icon-envelope">
            <title>envelope</title>
            <path class="cls-1" d="M14.33 2H1.67A1.67 1.67 0 0 0 0 3.67v8.67A1.67 1.67 0 0 0 1.67 14h12.66A1.67 1.67 0 0 0 16 12.33V3.67A1.67 1.67 0 0 0 14.33 2zm0 1.33h.07L8 9.75l-6.4-6.4h12.73zm0 9.33H1.67a.33.33 0 0 1-.33-.33V5l6.2 6.2a.67.67 0 0 0 .94 0l6.2-6.2v7.36a.33.33 0 0 1-.35.3z" />
        </symbol>
        <symbol viewBox="-153.3 216.6 113.6 218.8" id="icon-facebook">
            <title>facebook</title>
            <path id="facebook-f" d="M-79.6,435.4v-99.8h33.5l5-38.9h-38.5v-24.8c0-11.3,3.1-18.9,19.3-18.9l20.6,0v-34.8
		c-3.6-0.5-15.8-1.5-30-1.5c-29.7,0-50,18.1-50,51.4v28.7h-33.6v38.9h33.6v99.8H-79.6z" /> </symbol>
        <symbol viewBox="0 0 21 21" id="icon-finger">
            <title>finger</title>
            <path d="M11.1 19.8c-3.7 0.3-6.8-2.7-6.8-6v-2.3c0-0.8 0.6-1.5 1.3-1.7v2.7c0 0.3 0.2 0.7 0.7 0.7C6.6 13.2 7 13 7 12.5v-8h1.7V11c0 0.3 0.2 0.7 0.7 0.7s0.7-0.2 0.7-0.7V7.4c0-0.4 0.3-0.8 0.8-0.8 0.4 0 0.8 0.3 0.8 0.8v3.7c0 0.3 0.2 0.7 0.7 0.7 0.3 0 0.7-0.2 0.7-0.7V8.5c0-0.4 0.3-0.8 0.8-0.8 0.4 0 0.8 0.3 0.8 0.8v2.6c0 0.3 0.2 0.7 0.7 0.7 0.3 0 0.7-0.2 0.7-0.7V9.4c0-0.4 0.3-0.8 0.8-0.8s0.8 0.3 0.8 0.8c0 0 0-1.1 0 4.5C16.6 19.7 13 19.8 11.1 19.8zM7.9 1.3c0.5 0 0.8 0.3 0.8 0.8v1.1H6.9c0 0 0-0.2 0-1.1S7.9 1.3 7.9 1.3zM4.1 2.4C4 2.3 4 2.3 3.9 2.2c-0.1-0.2 0-0.3 0-0.5C4 1.6 4 1.5 4.1 1.4c0.1-0.1 0.2 0 0.3 0 0.1 0 0.3 0 0.4 0.1C4.9 1.6 5 1.7 5.1 1.9 5.4 2.2 5.6 2.6 5.6 3c0 0 0 0 0 0.1C5.3 3.2 4.9 3 4.6 2.8 4.5 2.7 4.4 2.6 4.2 2.5 4.2 2.5 4.1 2.4 4.1 2.4zM4.8 5.9C4.8 5.9 4.8 5.9 4.8 5.9 4.6 6.1 4.4 6.1 4.2 6.1c-0.1 0-0.1 0-0.2 0C3.5 5.9 3.9 5.1 4.2 4.9c0.2-0.1 0.4-0.3 0.7-0.4C5 4.5 5.1 4.4 5.3 4.4c0 0 0.3-0.1 0.3-0.1C5.5 4.7 5.3 5.1 5.1 5.5 5 5.6 4.9 5.8 4.8 5.9zM16.5 7.2c-0.4 0-0.7 0.1-1 0.2 -0.3-0.7-1.1-1.1-1.8-1.1 -0.3 0-0.7 0.1-1 0.2 -0.3-0.7-1.1-1.3-1.9-1.3 -0.3 0-0.6 0.1-0.8 0.2V2c0-1.1-0.9-2-2.1-2C7.1 0 6.4 0.5 6 1.1 5.9 1 5.6 0.7 5.6 0.7S4.9 0.2 4.3 0.2c-0.8 0-1.5 0.6-1.6 1.4 0 0.3 0 0.7 0.1 1C2.9 2.8 3 3 3.2 3.2c0.1 0.1 0.3 0.3 0.4 0.4 0 0 0.3 0.2 0.4 0.2C3.8 3.9 3.4 4.1 3.2 4.3 2.6 5.1 2.5 6.1 3.1 6.8c0.3 0.3 0.8 0.5 1.2 0.5 0.5 0 1.1-0.2 1.5-0.7v1.9C4.3 8.7 3.2 10 3.2 11.4v2.3c0 4 3.6 7.3 8 7.3 4.1 0 7.4-3.3 7.4-7.3V9.1C18.4 8.1 17.5 7.2 16.5 7.2z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-flower">
            <title>flower</title>
            <path class="cls-1" d="M8 3.74A2.25 2.25 0 1 0 10.25 6 2.25 2.25 0 0 0 8 3.74zm0 3A.75.75 0 1 1 8.75 6a.75.75 0 0 1-.75.74z" />
            <path class="cls-1" d="M14 6a2.08 2.08 0 0 0-1.53-1.87 2.64 2.64 0 0 0 .24-1.06 1.8 1.8 0 0 0-.5-1.32 1.85 1.85 0 0 0-1.3-.5 2.24 2.24 0 0 0-1 .27 2.65 2.65 0 0 0-.6-1A1.8 1.8 0 0 0 8 0a2.08 2.08 0 0 0-1.86 1.5 2.15 2.15 0 0 0-2.38.26A1.8 1.8 0 0 0 3.26 3a2.65 2.65 0 0 0 .25 1.1A2.08 2.08 0 0 0 2 6a2.08 2.08 0 0 0 1.53 1.87 2.64 2.64 0 0 0-.24 1.06 1.8 1.8 0 0 0 .5 1.32 1.85 1.85 0 0 0 1.3.5 2.24 2.24 0 0 0 1-.27 2.66 2.66 0 0 0 .6 1A1.8 1.8 0 0 0 8 12a2.08 2.08 0 0 0 1.86-1.53 2.15 2.15 0 0 0 2.38-.26 1.85 1.85 0 0 0 .5-1.3 2.25 2.25 0 0 0-.26-1A2.08 2.08 0 0 0 14 6zm-2 .6l-.9.33a.5.5 0 0 0-.26.67l.42.84a.93.93 0 0 1 .13.45.56.56 0 0 1-.12.36.54.54 0 0 1-.37.1 1.27 1.27 0 0 1-.5-.12l-.82-.34a.5.5 0 0 0-.66.28l-.3.82c-.15.4-.4.65-.62.65a.5.5 0 0 1-.3-.17 1.35 1.35 0 0 1-.3-.48l-.34-.9a.5.5 0 0 0-.68-.26l-.85.43a.9.9 0 0 1-.44.12.55.55 0 0 1-.37-.12.5.5 0 0 1-.12-.37 1.32 1.32 0 0 1 .14-.52l.37-.83a.5.5 0 0 0-.27-.66L4 6.6c-.4-.14-.65-.4-.65-.62s.26-.47.64-.6l.84-.33a.5.5 0 0 0 .27-.66l-.37-.8A1.35 1.35 0 0 1 4.6 3a.5.5 0 0 1 .1-.3.55.55 0 0 1 .36-.1 1.3 1.3 0 0 1 .53.12l.82.38a.5.5 0 0 0 .66-.27l.3-.83c.15-.4.4-.64.62-.64a.5.5 0 0 1 .3.17 1.35 1.35 0 0 1 .3.47l.34.9a.5.5 0 0 0 .68.26l.85-.43a.9.9 0 0 1 .44-.12.55.55 0 0 1 .37.12.5.5 0 0 1 .12.37 1.32 1.32 0 0 1-.14.52l-.37.83a.5.5 0 0 0 .27.66l.85.32c.4.14.65.4.65.62s-.26.43-.67.58z" />
            <path class="cls-1" d="M11 12s-2-.25-2.73.85a3.27 3.27 0 0 0-.16.3C7.3 11.78 5.3 12 5.3 12c-.64 0-.64.5-.64.5a5.4 5.4 0 0 0 .75 2.64 2.6 2.6 0 0 0 2.07.86H8.8a2.8 2.8 0 0 0 2.2-1.18A3.1 3.1 0 0 0 11 12zm-3.6 3a1.6 1.6 0 0 1-1.2-.43A3.9 3.9 0 0 1 5.68 13a2 2 0 0 1 1.58.68A1.8 1.8 0 0 1 7.4 15zm2.74-.67a2 2 0 0 1-1.57.67 3.9 3.9 0 0 1 .53-1.6 1.6 1.6 0 0 1 1.2-.4 1.8 1.8 0 0 1-.15 1.3z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-food">
            <title>food</title>
            <path class="cls-1" d="M14 5.33C14 2.7 12.68.5 10.87.08a2.77 2.77 0 0 0-1.8.16L9 .3a.66.66 0 0 0-.15.1.65.65 0 0 0-.07.1.64.64 0 0 0-.07.1.66.66 0 0 0 0 .17.63.63 0 0 0 0 .1V14.3a1.7 1.7 0 0 0 1.67 1.7A1.64 1.64 0 0 0 12 14.3V10a5.88 5.88 0 0 0 2-4.67zm-3.44-4c1.2.28 2.1 2 2.1 4s-.9 3.68-2.12 4a1.38 1.38 0 0 1-.54 0v-8a1.38 1.38 0 0 1 .56.05zm-.2 13.3a.36.36 0 0 1-.35-.36v-3.63h.23a2.63 2.63 0 0 0 .44 0v3.7a.32.32 0 0 1-.32.33zM6.66 0A.67.67 0 0 0 6 .67v4.66a.67.67 0 0 1-.67.67V.67A.67.67 0 1 0 4 .67V6a.67.67 0 0 1-.67-.67V.67A.67.67 0 1 0 2 .67v4.66a2 2 0 0 0 .67 1.48V14a2 2 0 0 0 2.05 2 2 2 0 0 0 1.95-2V6.8a2 2 0 0 0 .67-1.47V.67A.67.67 0 0 0 6.67 0zM5.34 14a.64.64 0 0 1-.64.7.7.7 0 0 1-.7-.7V7.33h1.33z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-football">
            <title>football</title>
            <path class="cls-1" d="M15.2 1.17a.67.67 0 0 0-.37-.36 10.74 10.74 0 0 0-14 14 .67.67 0 0 0 .36.37 10.7 10.7 0 0 0 4.07.83 10.65 10.65 0 0 0 7.58-3.15A10.72 10.72 0 0 0 15.2 1.17zm-1.14.77a9.4 9.4 0 0 1 .6 3.77L10.3 1.36h.44a9.37 9.37 0 0 1 3.32.6zm-8.8 12.73a9.4 9.4 0 0 1-3.32-.6 9.4 9.4 0 0 1-.6-3.77l4.36 4.35h-.44zm6.65-2.75a9.32 9.32 0 0 1-4.53 2.5l-5.8-5.8A9.4 9.4 0 0 1 8.64 1.6l5.8 5.8a9.4 9.4 0 0 1-2.52 4.53z" />
            <path class="cls-1" d="M11.8 6.86L10.94 6l.2-.2a.67.67 0 1 0-.94-.94l-.2.2-.86-.86a.67.67 0 0 0-.94.94l.86.86L8 7.06l-.86-.86a.67.67 0 1 0-.94.94l.86.86L6 9.06l-.86-.86a.67.67 0 1 0-.94.94l.86.86-.2.2a.67.67 0 1 0 .94.94l.2-.2.86.86a.67.67 0 0 0 .94-.94L6.94 10 8 8.94l.86.86a.67.67 0 1 0 .94-.94L8.94 8 10 6.94l.86.86a.67.67 0 1 0 .94-.94z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-gear">
            <title>gear</title>
            <path class="cls-1" d="M14.42 9.45l-.8-.7a6.5 6.5 0 0 0 0-1.53l.8-.7a1.73 1.73 0 0 0 .36-2.1l-.46-.85a1.57 1.57 0 0 0-1.92-.73l-1 .38a5.56 5.56 0 0 0-1.26-.77L10 1.4A1.6 1.6 0 0 0 8.46 0h-.92A1.6 1.6 0 0 0 6 1.4l-.18 1.07a5.56 5.56 0 0 0-1.26.77l-1-.38a1.56 1.56 0 0 0-1.92.73l-.46.83a1.73 1.73 0 0 0 .36 2.12l.8.7a6.5 6.5 0 0 0 0 1.53l-.8.7a1.73 1.73 0 0 0-.36 2.1l.46.85a1.57 1.57 0 0 0 1.92.73l1-.38a5.56 5.56 0 0 0 1.26.77L6 14.6A1.6 1.6 0 0 0 7.54 16h.92A1.6 1.6 0 0 0 10 14.6l.17-1.06a5.7 5.7 0 0 0 1.33-.83l.9.38a1.57 1.57 0 0 0 1.92-.7l.44-.78a1.72 1.72 0 0 0-.34-2.15zm-.73 1.46l-.45.8a.3.3 0 0 1-.4.13l-1.23-.5a.6.6 0 0 0-.65.12 4.42 4.42 0 0 1-1.55 1 .66.66 0 0 0-.42.52l-.23 1.45a.32.32 0 0 1-.3.28h-.93a.32.32 0 0 1-.3-.28L7 12.94a.66.66 0 0 0-.42-.52 4.34 4.34 0 0 1-1.5-.9.6.6 0 0 0-.4-.17.6.6 0 0 0-.22 0l-1.3.52a.3.3 0 0 1-.4-.15l-.45-.84a.35.35 0 0 1 .08-.42l1.07-.93a.7.7 0 0 0 .22-.64 5.06 5.06 0 0 1 0-1.83.7.7 0 0 0-.22-.64L2.38 5.5a.35.35 0 0 1-.07-.4l.47-.85a.3.3 0 0 1 .38-.15l1.3.52a.6.6 0 0 0 .65-.12 4.34 4.34 0 0 1 1.5-.9.66.66 0 0 0 .4-.54l.23-1.45a.32.32 0 0 1 .3-.27h.93a.32.32 0 0 1 .3.28L9 3.07a.66.66 0 0 0 .42.52 4.34 4.34 0 0 1 1.5.9.6.6 0 0 0 .63.13l1.3-.5a.3.3 0 0 1 .4.14l.45.84a.35.35 0 0 1-.07.42l-1.07.93a.7.7 0 0 0-.22.64 5.06 5.06 0 0 1 0 1.82.7.7 0 0 0 .22.63l1.06.93a.34.34 0 0 1 .07.45z" />
            <path class="cls-1" d="M8 5.5A2.5 2.5 0 1 0 10.5 8 2.5 2.5 0 0 0 8 5.5zm0 3.75A1.25 1.25 0 1 1 9.25 8 1.25 1.25 0 0 1 8 9.25z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-gift-card">
            <title>gift-card</title>
            <path class="st0" d="M14.8 5h-2.1c.2-.4.3-.8.3-1.3C13 2.2 11.8 1 10.2 1c-.8 0-1.6.4-2.1 1-.6-.6-1.3-1-2.2-1-1.5 0-2.8 1.2-2.8 2.7 0 .5.1.9.4 1.3H1.3C.6 5 0 5.6 0 6.3v7.3c0 .8.6 1.4 1.3 1.4h13.4c.7 0 1.3-.6 1.3-1.3V6.3c.1-.7-.5-1.3-1.2-1.3zm-3.6 3.7c-.8 0-1.4-.1-1.8-.6-.5-.6-.7-1.1-.7-1.8 1.5 0 2.3.8 2.5 2.4zM7.4 6.3C7.3 7.8 6.5 8.6 5 8.7c.1-1.6 1-2.4 2.4-2.4zm1.3-2.6c0-.7.8-1.3 1.5-1.3s1.5.6 1.5 1.3S11.1 5 10.4 5H8.7V3.7zm-4.3 0c0-.7.8-1.3 1.5-1.3s1.5.6 1.5 1.3V5H5.7C5 5 4.4 4.4 4.4 3.7zM14.8 13c0 .4-.3.7-.7.7H2c-.4 0-.7-.3-.7-.7v-.7h13.5v.7zm0-2.7H1.3V7c0-.4.3-.7.7-.7h2.4c-.5.7-.7 1.4-.8 2.2 0 .8.6 1.5 1.4 1.5.9 0 1.9-.2 2.7-1l.4-.4c.1.2.2.3.3.4.8.8 1.8.9 2.7.9.8 0 1.4-.6 1.4-1.4-.1-.9-.3-1.6-.7-2.2h2.3c.4 0 .7.3.7.7v3.3z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-gift">
            <title>gift</title>
            <path class="cls-1" d="M14.33 4h-2a2.64 2.64 0 0 0 .37-1.33A2.66 2.66 0 0 0 8 .92 2.65 2.65 0 0 0 3.7 4h-2A1.67 1.67 0 0 0 0 5.67v.67A1.67 1.67 0 0 0 1.33 8v6.37A1.67 1.67 0 0 0 3 16h10a1.67 1.67 0 0 0 1.67-1.67V8A1.67 1.67 0 0 0 16 6.33v-.66A1.67 1.67 0 0 0 14.33 4zM10 1.33A1.33 1.33 0 0 1 10 4H8.67V2.67A1.33 1.33 0 0 1 10 1.33zM4.67 2.67a1.33 1.33 0 1 1 2.67 0V4H6a1.33 1.33 0 0 1-1.33-1.33zm-2 11.67V8h4.66v6.67H3a.33.33 0 0 1-.33-.34zm10.67 0a.33.33 0 0 1-.33.33H8.67V8h4.67zm1.33-8a.33.33 0 0 1-.33.33H1.67a.33.33 0 0 1-.33-.33v-.67a.33.33 0 0 1 .33-.33h12.66a.33.33 0 0 1 .33.33z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-grid">
            <title>grid</title>
            <path class="cls-1" d="M2.9 0H1.46A1.46 1.46 0 0 0 0 1.45V2.9a1.46 1.46 0 0 0 1.45 1.46H2.9A1.46 1.46 0 0 0 4.37 2.9V1.46A1.46 1.46 0 0 0 2.9 0zM1.46 2.9V1.46H2.9V2.9zM8.73 0H7.27a1.46 1.46 0 0 0-1.45 1.45V2.9a1.46 1.46 0 0 0 1.45 1.46h1.46a1.46 1.46 0 0 0 1.45-1.45V1.46A1.46 1.46 0 0 0 8.73 0zM7.27 2.9V1.46h1.46V2.9zM14.55 0H13.1a1.46 1.46 0 0 0-1.46 1.45V2.9a1.46 1.46 0 0 0 1.45 1.46h1.44A1.46 1.46 0 0 0 16 2.9V1.46A1.46 1.46 0 0 0 14.55 0zM13.1 2.9V1.46h1.44V2.9zM2.9 5.83H1.46A1.46 1.46 0 0 0 0 7.27v1.46a1.46 1.46 0 0 0 1.45 1.45H2.9a1.46 1.46 0 0 0 1.46-1.45V7.27A1.46 1.46 0 0 0 2.9 5.82zm-1.45 2.9V7.28H2.9v1.46zm7.28-2.9H7.27a1.46 1.46 0 0 0-1.45 1.45v1.46a1.46 1.46 0 0 0 1.45 1.45h1.46a1.46 1.46 0 0 0 1.45-1.45V7.27a1.46 1.46 0 0 0-1.45-1.45zm-1.46 2.9V7.28h1.46v1.46zm7.28-2.9H13.1a1.46 1.46 0 0 0-1.46 1.45v1.46a1.46 1.46 0 0 0 1.45 1.45h1.44A1.46 1.46 0 0 0 16 8.73V7.27a1.46 1.46 0 0 0-1.45-1.45zm-1.46 2.9V7.28h1.44v1.46zM2.9 11.65H1.46A1.46 1.46 0 0 0 0 13.1v1.44A1.46 1.46 0 0 0 1.45 16H2.9a1.46 1.46 0 0 0 1.46-1.45V13.1a1.46 1.46 0 0 0-1.45-1.46zm-1.45 2.9V13.1H2.9v1.44zm7.28-2.9H7.27a1.46 1.46 0 0 0-1.45 1.45v1.44A1.46 1.46 0 0 0 7.27 16h1.46a1.46 1.46 0 0 0 1.45-1.45V13.1a1.46 1.46 0 0 0-1.45-1.46zm-1.46 2.9V13.1h1.46v1.44zm7.28-2.9H13.1a1.46 1.46 0 0 0-1.46 1.45v1.44A1.46 1.46 0 0 0 13.1 16h1.44A1.46 1.46 0 0 0 16 14.55V13.1a1.46 1.46 0 0 0-1.45-1.46zm-1.45 2.9V13.1h1.45v1.44z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-guitar">
            <title>guitar</title>
            <circle class="cls-1" cx="7.35" cy="8.65" r="1.33" />
            <path class="cls-1" d="M15.87 1.3L14.7.12a.45.45 0 0 0-.63 0L12.4 1.8a.45.45 0 0 0 0 .64l.1.1-2.8 2.82a3.3 3.3 0 0 0-4.55.44 4.7 4.7 0 0 1-1.8.87A5.67 5.67 0 0 0 1 7.85c-1.68 1.68-1.34 3.7 1 6 1.36 1.36 2.62 2 3.77 2a3.18 3.18 0 0 0 2.28-1 5.67 5.67 0 0 0 1.2-2.3 4.7 4.7 0 0 1 .86-1.8 3.72 3.72 0 0 0 1.17-2.27 3.24 3.24 0 0 0-.72-2.27l2.8-2.8.12.1a.45.45 0 0 0 .64 0l1.68-1.66a.45.45 0 0 0 .1-.55zm-6.6 8.6a5.66 5.66 0 0 0-1.2 2.3 4.7 4.7 0 0 1-.86 1.8c-.5.52-1.57 1.6-4.2-1-2.6-2.63-1.53-3.7-1-4.2a4.7 4.7 0 0 1 1.8-.88 5.67 5.67 0 0 0 2.3-1.2 2 2 0 0 1 3.17 0A2.17 2.17 0 0 1 10 8.46a2.48 2.48 0 0 1-.73 1.45z" />
            <path class="cls-1" d="M4.5 9.5a.67.67 0 1 0-.94.95l2 2a.67.67 0 0 0 .94-.94z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-health">
            <title>health</title>
            <path class="cls-1" d="M14.68 2.34A4.55 4.55 0 0 0 11.44 1a4.62 4.62 0 0 0-3.32 1.42L8 2.57l-.2-.23a4.6 4.6 0 0 0-6.48 0 4.53 4.53 0 0 0 0 6.38l5.26 5.48A2.05 2.05 0 0 0 8 15a2.1 2.1 0 0 0 1.42-.8l5.26-5.46a4.54 4.54 0 0 0 0-6.4zM8.46 13.28a1.88 1.88 0 0 1-.46.4 1.93 1.93 0 0 1-.45-.4L3.1 8.68h2.23a.67.67 0 0 0 .6-.38l.7-1.38 1.42 3.35a.67.67 0 0 0 .55.4h.06a.67.67 0 0 0 .55-.3l1.15-1.7h2.55zm5.66-5.94H10a.67.67 0 0 0-.55.3l-.65 1-1.52-3.57a.67.67 0 0 0-.6-.4.7.7 0 0 0-.6.33L4.9 7.33h-3a3.2 3.2 0 0 1 .38-4 3.26 3.26 0 0 1 4.56 0L8 4.67l1.1-1.35a3.28 3.28 0 0 1 2.34-1 3.2 3.2 0 0 1 2.68 5z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-heart-outline">
            <title>heart-outline</title>
            <path class="icon-outline" fill="currentColor" d="M14.68 2.34A4.55 4.55 0 0 0 11.44 1a4.62 4.62 0 0 0-3.32 1.42L8 2.57l-.19-.23a4.59 4.59 0 0 0-6.49 0 4.53 4.53 0 0 0 0 6.38l5.26 5.48A2.05 2.05 0 0 0 8 15a2.09 2.09 0 0 0 1.42-.8l5.26-5.46a4.54 4.54 0 0 0 0-6.4z" />
            <path class="icon-fill" d="M13.74 7.8l-5.28 5.48a1.88 1.88 0 0 1-.46.39 2 2 0 0 1-.45-.39L2.27 7.8a3.21 3.21 0 0 1 2.3-5.47 3.22 3.22 0 0 1 2.26.91L8 4.66l1.11-1.34a3.28 3.28 0 0 1 2.33-1 3.21 3.21 0 0 1 2.3 5.46z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-heart">
            <title>heart</title>
            <path class="cls-1" d="M14.68 2.34A4.55 4.55 0 0 0 11.44 1a4.62 4.62 0 0 0-3.32 1.42L8 2.57l-.2-.23a4.6 4.6 0 0 0-6.48 0 4.53 4.53 0 0 0 0 6.38l5.26 5.48A2.05 2.05 0 0 0 8 15a2.1 2.1 0 0 0 1.42-.8l5.26-5.46a4.54 4.54 0 0 0 0-6.4z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-home-garden">
            <title>home-garden</title>
            <path class="cls-1" d="M15.78 6.8L8.45.17a.67.67 0 0 0-.9 0L.22 6.8a.67.67 0 0 0 0 .94.67.67 0 0 0 .95 0l.18-.16v7.7A.67.67 0 0 0 2 16h12a.67.67 0 0 0 .67-.67v-7.7l.18.15a.67.67 0 1 0 .9-1zm-2.42-.13v8h-4.7v-2.8a1.93 1.93 0 0 0 .66.13 2 2 0 0 0 1.43-.62A4.33 4.33 0 0 0 12 7.88a.67.67 0 0 0-.66-.55 5.15 5.15 0 0 0-2.8.67A2 2 0 0 0 8 7.26 4.35 4.35 0 0 0 4.54 6a.68.68 0 0 0-.54.7 4.33 4.33 0 0 0 1.13 3.4 2.12 2.12 0 0 0 1.46.57 2.17 2.17 0 0 0 .76-.14.64.64 0 0 0 0 .14v4H2.64v-8a.65.65 0 0 0 0-.2L8 1.56l5.4 4.9a.65.65 0 0 0-.04.2zM8.88 9.4a2.52 2.52 0 0 1 1.78-.7 3.23 3.23 0 0 1-.88 1.76.62.62 0 0 1-.9 0 .8.8 0 0 1 0-1.07zm-1.55-.72a.6.6 0 0 1-.2.45.83.83 0 0 1-1.08 0 2.5 2.5 0 0 1-.7-1.77 3.24 3.24 0 0 1 1.78.88.6.6 0 0 1 .2.44z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-info">
            <title>info</title>
            <rect class="cls-1" x="7.3" y="4" width="1.3" height="1.3" rx=".3" ry=".3" />
            <rect class="cls-1" x="7.3" y="6.7" width="1.3" height="5.3" rx=".3" ry=".3" />
            <path class="cls-1" d="M8 0a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm0 14.7A6.7 6.7 0 1 1 14.7 8 6.7 6.7 0 0 1 8 14.7z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-jewel">
            <title>jewel</title>
            <path class="cls-1" d="M15.5 4.33L12.67 1.7c-.8-.7-1.25-.7-1.4-.7H4.7a2.3 2.3 0 0 0-1.4.7L.52 4.24a1.62 1.62 0 0 0-.2 2.15L7 14.46A1.32 1.32 0 0 0 8 15a1.3 1.3 0 0 0 1-.53l6.65-8.05a1.54 1.54 0 0 0-.16-2.1zm-11.15 2l2.15 5.32L1.92 6.3zm4.32-4L10.15 5h-4.3l1.47-2.68zm1.55 4L8 11.9 5.77 6.3zm1.4 0h2.48l-4.6 5.34zm.15-3.6L14.23 5h-2.56L10.2 2.32h1a1.5 1.5 0 0 1 .58.36zm-7.6 0a2.54 2.54 0 0 1 .53-.38h1.1L4.32 5H1.68z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-lifetime-cashback">
            <title>lifetime-cashback</title>
            <path d="M14.7 6.3h-.3c-.2 0-.3-.1-.4-.3-.4-.8-1-1.6-1.7-2.1-.2-.2-.3-.4-.2-.7l.5-1.7c0-.1 0-.2-.1-.3-.1-.1-.2-.1-.3-.1l-1.3.5c-.3.1-.5.5-.4.9.2.5.4 1.1.4 1.7.1.2.3.5.5.7.6.5 1 1 1.3 1.7.3.5.8.9 1.4 1 .3 0 .5.3.5.7v.6c0 .4-.2.6-.5.7-.6.2-1.2.6-1.5 1.1-.3.5-.6.9-1 1.3l-.5.5c-.3.3-.3.7 0 1l.9.9s.1.1.1.2 0 .1-.1.2c0 0-.1.1-.2.1s-.1 0-.2-.1l-.8-.8c-.4-.4-.9-.6-1.4-.6H9c-.4.1-.8.1-1.3.1-.3 0-.7 0-1-.1-.3 0-.6 0-.9.1-.2.1-.5.2-.6.4l-.9.9s-.1.1-.2.1-.1 0-.2-.1c0 0-.1-.1-.1-.2s0-.1.1-.2l.7-.7c.3-.3.3-.7-.1-1l-.6-.5c-.4-.4-.8-.8-1.1-1.2l-.3-.3c-.5-.2-1-.5-1.5-.8.3 1.3 1 2.5 2.1 3.4l-.2.2c-.3.3-.5.7-.5 1.1s.2.8.5 1.1c.4.4.9.3 1.3.3s.8-.2 1.1-.5l.7-.7c.2-.2.4-.2.6-.2.9.1 1.9.1 2.7-.1.2 0 .4 0 .6.2l.8.8c.3.3.7.5 1.1.5.4 0 .8-.2 1.1-.5.3-.3.5-.7.5-1.1 0-.4-.2-.8-.5-1.1l-.3-.3c.5-.5 1-1.1 1.3-1.7.2-.3.5-.5.8-.5.7 0 1.3-.6 1.3-1.3V7.6c0-.7-.6-1.3-1.3-1.3z" />
            <path d="M5.8.1C2.4-.6-.6 2.4.1 5.8.5 7.7 2 9.2 3.9 9.6c3.4.6 6.3-2.3 5.7-5.7C9.2 2 7.7.5 5.8.1zm-.2 8.1C3.1 8.8.9 6.6 1.4 4 1.7 2.7 2.7 1.7 4 1.4 6.5.8 8.8 3.1 8.2 5.6 8 6.9 6.9 8 5.6 8.2z" />
            <path d="M4.9 4.5c-.8 0-.8-.3-.8-.4 0-.2.3-.4.8-.4.3 0 .5.1.7.2.2.1.4.2.5 0 .2-.2.2-.4 0-.5-.2-.2-.5-.3-.8-.4v-.4c0-.2-.2-.4-.4-.4s-.4.1-.4.4V3c-.7.1-1.2.5-1.2 1.1 0 .4.2 1.1 1.5 1.1.3 0 .8.1.8.4 0 .1-.3.4-.7.4-.3 0-.6-.1-.7-.3-.2-.1-.4-.1-.6 0-.2.2-.2.4 0 .5.2.2.5.3.8.4v.5c0 .2.2.4.4.4s.4-.2.4-.4v-.4c.6-.1 1.1-.6 1.1-1.1.1-.6-.3-1.1-1.4-1.1z" />
            <circle cx="11" cy="7.1" r=".7" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-lipstick">
            <title>lipstick</title>
            <path class="cls-1" d="M16 2.57C16 1.13 14.5 0 12.6 0a3.22 3.22 0 0 0-3.33 2.12L6.75 4.88l-.2-.22a.6.6 0 0 0-.88 0L.45 10.08a1.65 1.65 0 0 0 0 2.27l3.06 3.18a1.5 1.5 0 0 0 2.2 0l5.2-5.42a.66.66 0 0 0 0-.9l-.32-.33 4.15-4.27A2.37 2.37 0 0 0 16 2.57zm-3.4-1.3c1.27 0 2.16.7 2.16 1.3s-.9 1.27-2.16 1.27-2.16-.68-2.16-1.28.9-1.28 2.16-1.28zM4.82 14.63a.3.3 0 0 1-.22.1.3.3 0 0 1-.22-.1l-3.06-3.18a.33.33 0 0 1 0-.45l1.25-1.3 3.5 3.63zm2.12-2.2L3.44 8.8 6.07 6 9.6 9.8zm.7-6.63l1.9-2.12a3.5 3.5 0 0 0 2.92 1.44L9.7 8z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-location">
            <title>location</title>
            <path class="cls-1" d="M11.74 9.85a9.07 9.07 0 0 0 1.5-4.6 5.25 5.25 0 0 0-10.5 0 9.07 9.07 0 0 0 1.52 4.6C2.3 10.45 1 11.48 1 12.67 1 14.5 4.13 16 8 16s7-1.5 7-3.33c0-1.2-1.3-2.23-3.26-2.82zm-7.66-4.6a3.92 3.92 0 0 1 7.83 0 8.14 8.14 0 0 1-1.54 4.28c-.3.44-.6.85-.9 1.22A19.8 19.8 0 0 1 8 12.38a19.78 19.78 0 0 1-1.47-1.63c-.3-.37-.6-.78-.9-1.22A8.14 8.14 0 0 1 4.1 5.25zM8 14.67c-3.46 0-5.67-1.3-5.67-2 0-.46 1-1.2 2.72-1.65a19.6 19.6 0 0 0 2.56 2.84.58.58 0 0 0 .78 0A19.6 19.6 0 0 0 10.95 11c1.7.44 2.72 1.18 2.72 1.65 0 .7-2.2 2.02-5.67 2.02z" />
            <path class="cls-1" d="M10.33 5.25A2.33 2.33 0 1 0 8 7.58a2.34 2.34 0 0 0 2.33-2.33zM7 5.25a1 1 0 1 1 1 1 1 1 0 0 1-1-1z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-lock">
            <title>lock</title>
            <path class="cls-1" d="M8 9.33a1.33 1.33 0 0 0-.67 2.48v.86a.67.67 0 0 0 1.33 0v-.85A1.33 1.33 0 0 0 8 9.34z" />
            <path class="cls-1" d="M13.67 6.67h-.33V5.33a5.33 5.33 0 1 0-10.67 0v1.34h-.34A1.34 1.34 0 0 0 1 8v6.67A1.34 1.34 0 0 0 2.33 16h11.34A1.34 1.34 0 0 0 15 14.67V8a1.34 1.34 0 0 0-1.33-1.33zM4 5.33a4 4 0 0 1 8 0v1.34H4zm9.67 9.33H2.33V8h11.34z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-map">
            <title>map</title>
            <path class="cls-1" d="M15 2.5L11 .1h-.63l-5 2.5L1.63.33 1.53.3a1.24 1.24 0 0 0-.46-.1A1.08 1.08 0 0 0 0 1.33V12a1.74 1.74 0 0 0 1 1.5l4 2.4h.34a.67.67 0 0 0 .27-.05l5-2.5 3.74 2.23h.1a1.24 1.24 0 0 0 .45.1 1.08 1.08 0 0 0 1.1-1V4a1.74 1.74 0 0 0-1-1.5zM1.53 12.3a.4.4 0 0 1-.2-.3V1.72l3.33 2v10.44l-3-1.82zM6 3.75l4-2v10.5l-4 2zm8.67 10.54l-3.33-2V1.83l3 1.82h.1a.4.4 0 0 1 .2.3z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-medal">
            <title>medal</title>
            <path class="cls-1" d="M15.9 13.15l-2.53-2.55a6.66 6.66 0 1 0-10.73 0L.1 13.15a.32.32 0 0 0 .17.55l1.5.3a.32.32 0 0 1 .24.25l.3 1.5a.32.32 0 0 0 .56.16L5.8 13a6.55 6.55 0 0 0 4.4 0l2.95 3a.32.32 0 0 0 .55-.17l.3-1.5a.32.32 0 0 1 .25-.24l1.5-.3a.32.32 0 0 0 .15-.65zm-12.7.5a1.65 1.65 0 0 0-.86-.86l1.2-1.2a6.67 6.67 0 0 0 1 .75zm5.93-1.77a5.27 5.27 0 0 1-4.66-1.23 5.37 5.37 0 0 1-.88-1 5.33 5.33 0 1 1 8.82 0 5.53 5.53 0 0 1-1.9 1.72 5.28 5.28 0 0 1-1.4.5zm3.66 1.78l-1.32-1.3a6.67 6.67 0 0 0 1-.76l1.2 1.2a1.65 1.65 0 0 0-.9.86z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-menu">
            <title>menu</title>
            <path class="cls-1" d="M.9 4.4h14.2c.5 0 .9-.54.9-1.2S15.6 2 15.1 2H.9C.4 2 0 2.54 0 3.2s.4 1.2.9 1.2zm0 4.8h14.2c.5 0 .9-.54.9-1.2s-.4-1.2-.9-1.2H.9C.4 6.8 0 7.34 0 8s.4 1.2.9 1.2zm0 4.8h14.2c.5 0 .9-.54.9-1.2s-.4-1.2-.9-1.2H.9c-.5 0-.9.54-.9 1.2S.4 14 .9 14z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-minus-circle">
            <title>minus-circle</title>
            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 14.7c-3.7 0-6.7-3-6.7-6.7s3-6.7 6.7-6.7 6.7 3 6.7 6.7-3 6.7-6.7 6.7z" />
            <path d="M10.2 7.2H5.8c-.5 0-.8.4-.8.8s.3.8.8.8h4.5c.4 0 .7-.4.7-.8s-.3-.8-.8-.8z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-money">
            <title>money</title>
            <path class="cls-1" d="M14.87 6.13a2.63 2.63 0 0 1-.6-.73 4.12 4.12 0 0 1-.07-1 2.8 2.8 0 0 0-.53-2.07 2.35 2.35 0 0 0-1.73-.53h-.6a2.5 2.5 0 0 1-.73-.07 2.63 2.63 0 0 1-.72-.6A2.65 2.65 0 0 0 8 0a2.65 2.65 0 0 0-1.87 1.13 2.63 2.63 0 0 1-.73.6 2.27 2.27 0 0 1-.67.07h-.6a2.35 2.35 0 0 0-1.73.53 2.8 2.8 0 0 0-.53 2.07 4.12 4.12 0 0 1-.07 1 6 6 0 0 1-.67.73A2.65 2.65 0 0 0 0 8a2.65 2.65 0 0 0 1.13 1.87 2.63 2.63 0 0 1 .6.73 4.12 4.12 0 0 1 .07 1 2.8 2.8 0 0 0 .53 2.07 2.35 2.35 0 0 0 1.73.53h.6a2.5 2.5 0 0 1 .73.07 2.63 2.63 0 0 1 .72.6A2.65 2.65 0 0 0 8 16a2.65 2.65 0 0 0 1.87-1.13 2.63 2.63 0 0 1 .73-.6 2.5 2.5 0 0 1 .73-.07h.6a2.35 2.35 0 0 0 1.73-.53 2.8 2.8 0 0 0 .53-2.07 4.12 4.12 0 0 1 .06-1 2.63 2.63 0 0 1 .6-.73A2.9 2.9 0 0 0 16 8a2.65 2.65 0 0 0-1.13-1.87zM14 8.93a4.15 4.15 0 0 0-.93 1.2 3.9 3.9 0 0 0-.2 1.53 2.3 2.3 0 0 1-.13 1.07c-.13.13-.6.13-.8.13h-.6a2.54 2.54 0 0 0-1.2.2 5.3 5.3 0 0 0-1.2.93c-.33.32-.67.66-.93.66s-.6-.4-.92-.67a3.26 3.26 0 0 0-1.2-.94 3.78 3.78 0 0 0-1.2-.2h-.6c-.2 0-.67 0-.8-.13a2.3 2.3 0 0 1-.13-1.07 3.9 3.9 0 0 0-.2-1.53A5.3 5.3 0 0 0 2 8.93c-.33-.33-.67-.67-.67-.93s.4-.6.67-.93a4.15 4.15 0 0 0 .93-1.2 3.9 3.9 0 0 0 .2-1.53 2.3 2.3 0 0 1 .13-1.07c.13-.13.6-.13.8-.13h.6a2.54 2.54 0 0 0 1.2-.2A5.3 5.3 0 0 0 7.06 2c.34-.33.68-.67.94-.67s.6.4.93.67a3.26 3.26 0 0 0 1.2.93 3.78 3.78 0 0 0 1.2.2h.6c.2 0 .67 0 .8.13a2.3 2.3 0 0 1 .13 1.07 3.9 3.9 0 0 0 .2 1.53 5.3 5.3 0 0 0 .94 1.2c.33.34.67.68.67.94s-.4.6-.67.93z" />
            <path class="cls-1" d="M8 7.33c-1.33 0-1.33-.47-1.33-.67S7.2 6 8 6a1.74 1.74 0 0 1 1.2.4.66.66 0 0 0 .93-.93 2.5 2.5 0 0 0-1.4-.67V4A.67.67 0 1 0 7.4 4v.73a2.2 2.2 0 0 0-2.07 1.94c0 .73.33 2 2.67 2 .6 0 1.33.13 1.33.67 0 .26-.53.66-1.33.66a1.74 1.74 0 0 1-1.2-.4.66.66 0 0 0-.93.93 2.5 2.5 0 0 0 1.4.67v.8a.67.67 0 1 0 1.33 0v-.73a2.2 2.2 0 0 0 2-1.93c.07-1-.6-2-2.6-2z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-news">
            <title>news</title>
            <path class="cls-1" d="M14.67 4.33h-1.34v-2A1.34 1.34 0 0 0 12 1H1.33A1.34 1.34 0 0 0 0 2.33v11.34A1.34 1.34 0 0 0 1.33 15h13.34A1.34 1.34 0 0 0 16 13.67v-8a1.34 1.34 0 0 0-1.33-1.34zM9.5 13.67H2a.66.66 0 0 1-.67-.67V3A.66.66 0 0 1 2 2.33h9.34A.66.66 0 0 1 12 3v10a.66.66 0 0 1-.66.66zm5.17-.67a.66.66 0 0 1-.66.66h-.66v-8H14a.66.66 0 0 1 .66.66z" />
            <path class="cls-2" d="M5.33 12.33h-2a.67.67 0 0 1 0-1.33h2a.67.67 0 0 1 0 1.33zm0-2h-2a.67.67 0 0 1 0-1.33h2a.67.67 0 1 1 0 1.33zm4.67 2H8A.67.67 0 0 1 8 11h2a.67.67 0 1 1 0 1.33zm0-2H8A.67.67 0 0 1 8 9h2a.67.67 0 1 1 0 1.33zm0-2.67H8a.67.67 0 1 1 0-1.33h2a.67.67 0 1 1 0 1.33zM10 5H8a.67.67 0 1 1 0-1.34h2A.67.67 0 1 1 10 5z" />
            <path class="cls-1" d="M5.33 3.67h-2a.67.67 0 0 0-.67.67V7a.67.67 0 0 0 .67.67h2A.67.67 0 0 0 6 7V4.33a.67.67 0 0 0-.67-.66zm-.5 2.46a.2.2 0 0 1-.2.2H4a.2.2 0 0 1-.2-.2V5.2A.2.2 0 0 1 4 5h.6a.2.2 0 0 1 .2.2z" />
        </symbol>
        <symbol viewBox="0 0 60 28" id="icon-omnichannel">
            <title>omnichannel</title>
            <path d="M29 1c0-.6.4-1 1-1s1 .4 1 1v26c0 .6-.4 1-1 1s-1-.4-1-1V1zM7 10.3v5h10v-5H7zm-1 7c-.6 0-1-.4-1-1v-7c0-.6.4-1 1-1h12c.6 0 1 .4 1 1v7c0 .6-.4 1-1 1H6zm16 6v-2c0-.6-.5-1-1-1h-5.6v1c0 .5-.4 1-1 1h-4c-.6 0-1-.5-1-1v-1H3c-.6 0-1 .5-1 1v2c0 .6.5 1 1 1h18c.5 0 1-.4 1-1zM4 8.3v9c0 .3.1.5.3.7.2.2.4.3.7.3h14c.3 0 .5-.1.7-.3.2-.2.3-.4.3-.7v-9c0-.6-.4-1-1-1H5c-.6 0-1 .5-1 1zM21.8 18h.2c1.1 0 2 .9 2 2v4c0 1.1-.9 2-2 2H2c-1.1 0-2-.9-2-2v-4c0-1 .8-1.9 1.8-2V7c0-1.1.9-2 2-2h16c1.1 0 2 .9 2 2v11zM53 17c.6 0 1 .4 1 1v2c0 .6-.4 1-1 1h-2c-.6 0-1-.4-1-1v-2c0-.6.4-1 1-1h2zm-5 7h8V13.9c-.6-.1-1.1-.4-1.5-.8-.6.5-1.3.9-2.2.9-.8 0-1.6-.3-2.1-.8-.6.5-1.4.8-2.2.8-.8 0-1.6-.3-2.2-.9-.6.5-1.3.9-2.2.9-.9 0-1.6-.3-2.2-.9-.4.4-.9.7-1.5.8V24h2v-6c0-.6.4-1 1-1h4c.6 0 1 .4 1 1v6zm-4 0h2v-5h-2v5zm-6-13.8v.7c0 .6.6 1.1 1.3 1.1.6 0 1.2-.5 1.2-1.1 0-.6.4-1 1-1s1 .4 1 1S43 12 43.7 12c.6 0 1.2-.5 1.2-1.1 0-.6.4-1 1-1s1 .4 1 1 .5 1.1 1.2 1.1c.6 0 1.1-.5 1.1-1.1 0-.6.4-1 1-1s1 .4 1 1 .5 1.1 1.1 1.1 1.1-.5 1.1-1.1c0-.6.4-1 1-1s1 .4 1 1S56 12 56.7 12c.7 0 1.3-.5 1.3-1.1v-.7c0-.1-.1-.3-.4-.9l-2.9-5.2s-.2-.1-.3-.1H41.6l-.2.1-3 5.2c-.3.5-.4.8-.4.9zm22 .7c0 1.3-.8 2.4-2 2.9V24h1c.6 0 1 .4 1 1s-.4 1-1 1H37c-.6 0-1-.4-1-1s.4-1 1-1h1V13.7c-1.2-.5-2-1.6-2-2.9v-.7c0-.2 0-.7.6-1.8l3-5.2c.4-.6 1.2-1.1 2-1.1h12.9c.8 0 1.6.5 2 1.1l2.9 5.2c.6 1.1.6 1.7.6 1.8v.8z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-pacifier">
            <title>pacifier</title>
            <path class="cls-1" d="M14.83 1.17A4 4 0 0 0 11.37 0a4.08 4.08 0 0 0-3.25 3A3.67 3.67 0 0 0 8 4.35l-1 1-3.46-3.42a1.26 1.26 0 0 0-1.75 0 1.23 1.23 0 0 0-.3 1.3l1.7 5.12a3.85 3.85 0 1 0 4.45 4.44l5.1 1.7a1.24 1.24 0 0 0 1.3-2L10.62 9l1-1a3.73 3.73 0 0 0 1.32-.1 4.08 4.08 0 0 0 3-3.26 4 4 0 0 0-1.1-3.47zm-11 13.5a2.52 2.52 0 0 1-1.63-4.45 1.64 1.64 0 0 0 .25.7l.08.1L5 13.42l.1.1a1.63 1.63 0 0 0 .7.23 2.52 2.52 0 0 1-1.93.92zm3.74-3.3a.67.67 0 0 0-.7.2l-.78.87a.34.34 0 0 1-.28 0l-2.25-2.3a.33.33 0 0 1 0-.27l.88-.77a.67.67 0 0 0 .2-.7L2.87 3.15l10 10zm7-6.94a2.73 2.73 0 0 1-2 2.16 2.36 2.36 0 0 1-.85.06 1.3 1.3 0 0 0-1 .38l-1 1-1.8-1.72 1-1a1.3 1.3 0 0 0 .4-1 2.35 2.35 0 0 1 .06-.85 2.73 2.73 0 0 1 2.16-2 2.67 2.67 0 0 1 3.06 3.06z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-paperclip">
            <title>paperclip</title>
            <path d="M15.8 6.5c-.3-.3-.7-.3-.9 0l-6.9 7c-.7.7-3.1 2.4-5.5 0a3.95 3.95 0 0 1 0-5.6l5.6-5.7c.5-.5 2.5-1.4 3.9 0 1.1 1.1 1.1 2.9 0 4l-5.6 5.7c-.3.3-1.2 1.1-2.3 0-.6-.6-.6-1.7 0-2.3l5.6-5.8c.2-.1.4-.1.6 0 .2.2.2.5 0 .7L5.1 9.8c-.3.3-.2.7 0 .9.4.4.8.1.9 0l5.2-5.3c.7-.7.7-1.9 0-2.6-.7-.7-1.9-.7-2.6 0L3 8.6c-1 1.2-1 3.1.1 4.2 1.7 1.7 3.6.6 4.2 0l5.6-5.7a4.1 4.1 0 0 0 0-5.8c-2.3-2.3-5-.8-5.8 0L1.5 7c-2 2.1-2 5.4 0 7.5 2.9 2.9 6.4 1 7.4 0l6.9-7c.3-.4.3-.8 0-1z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-paw">
            <title>paw</title>
            <path class="cls-1" d="M9.8 5.32a1.94 1.94 0 0 0 .5.07 2.56 2.56 0 0 0 2.36-2.12A2.56 2.56 0 0 0 11.1.08a1.94 1.94 0 0 0-.5-.08 2.56 2.56 0 0 0-2.36 2.1A2.56 2.56 0 0 0 9.8 5.33zm-.25-2.9c.15-.6.6-1.08 1-1.08h.16c.5.14.8.87.6 1.6S10.64 4.18 10.16 4s-.78-.84-.6-1.57zM3.7 8.5a2.47 2.47 0 0 0 .44-3.38A2.58 2.58 0 0 0 2 3.85a2 2 0 0 0-1.1.35 2.47 2.47 0 0 0-.43 3.4 2.58 2.58 0 0 0 2.1 1.24 2 2 0 0 0 1.14-.36zm-2.1-1.6a1.2 1.2 0 0 1 .07-1.58.62.62 0 0 1 .33-.1 1.25 1.25 0 0 1 1 .62 1.2 1.2 0 0 1-.07 1.58.62.62 0 0 1-.36.1 1.25 1.25 0 0 1-.97-.63zm4.13-1.5a2 2 0 0 0 .52-.06 2.56 2.56 0 0 0 1.55-3.2A2.57 2.57 0 0 0 5.45 0a2 2 0 0 0-.52.07 2.56 2.56 0 0 0-1.54 3.2A2.57 2.57 0 0 0 5.72 5.4zm-.45-4h.16c.45 0 .9.48 1 1.1S6.4 3.9 5.9 4s-1.04-.34-1.2-1 .1-1.5.6-1.64zM15.1 4.2a2 2 0 0 0-1.1-.35 2.58 2.58 0 0 0-2.14 1.25 2.47 2.47 0 0 0 .43 3.4 2 2 0 0 0 1.12.34 2.58 2.58 0 0 0 2.1-1.24 2.47 2.47 0 0 0-.42-3.4zm-.7 2.67c-.34.53-1 .78-1.34.52A1.2 1.2 0 0 1 13 5.8a1.25 1.25 0 0 1 1-.62.6.6 0 0 1 .36.1 1.2 1.2 0 0 1 .04 1.6zM11.86 9a6.4 6.4 0 0 1-.42-.65A3.83 3.83 0 0 0 8.08 6H8a3.83 3.83 0 0 0-3.36 2.3 6.7 6.7 0 0 1-.42.63c-.23.3-.48.57-.74.85C2.38 11 1 12.52 2.13 14.58A2.5 2.5 0 0 0 4.43 16a7.3 7.3 0 0 0 1.82-.32A7.14 7.14 0 0 1 8 15.36h.07a7.5 7.5 0 0 1 1.73.3 7.64 7.64 0 0 0 1.78.3A2.54 2.54 0 0 0 14 14.48c1.12-2-.22-3.46-1.3-4.6-.3-.3-.6-.6-.84-.9zm.92 4.85a1.22 1.22 0 0 1-1.2.76 6.6 6.6 0 0 1-1.45-.25A8.52 8.52 0 0 0 8.08 14H8a8.26 8.26 0 0 0-2.1.36 6.3 6.3 0 0 1-1.47.28 1.16 1.16 0 0 1-1.13-.74c-.64-1.16 0-1.95 1.18-3.25.27-.3.55-.6.8-.92a7.7 7.7 0 0 0 .5-.73c.53-.85 1-1.65 2.23-1.65h.08c1.1 0 1.6.67 2.2 1.68a7.56 7.56 0 0 0 .53.8c.3.34.6.66.88 1 1.15 1.17 1.72 1.9 1.1 3z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-phone">
            <title>phone</title>
            <path class="cls-1" d="M11.33 0H4.67A1.67 1.67 0 0 0 3 1.67v12.66A1.67 1.67 0 0 0 4.67 16h6.67A1.67 1.67 0 0 0 13 14.33V1.67A1.67 1.67 0 0 0 11.33 0zm-7 4h7.33v6H4.33zm0-2.33a.33.33 0 0 1 .33-.33h6.67a.33.33 0 0 1 .33.33v1H4.33zm7 13H4.67a.33.33 0 0 1-.33-.33v-3h7.33v3a.33.33 0 0 1-.34.33z" />
            <circle class="cls-1" cx="7.67" cy="13" r="1" transform="rotate(-1.46 7.68 13.05)" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-play">
            <title>play</title>
            <path d="M15 9.3c1.4-.7 1.4-1.9 0-2.6L2.5.3C1.1-.4 0 .2 0 1.6v12.8c0 1.4 1.1 2 2.5 1.3L15 9.3z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-plug">
            <title>plug</title>
            <path class="cls-1" d="M14.33 4H13V2.67h1.33a.67.67 0 1 0 0-1.33H13V.67a.67.67 0 0 0-.67-.67h-2a3.3 3.3 0 0 0-3.26 2.67H4.64a3.67 3.67 0 0 0 0 7.33h4.72a2.33 2.33 0 0 1 0 4.67h-7.7a.67.67 0 1 0 0 1.33h7.7a3.67 3.67 0 0 0 0-7.33H4.65a2.33 2.33 0 0 1 0-4.67h2.42a3.3 3.3 0 0 0 3.24 2.67h2A.67.67 0 0 0 13 6v-.67h1.33a.67.67 0 1 0 0-1.33zm-2.66 1.33H10.3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h1.37z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-plus">
            <title>plus</title>
            <path class="cls-1" d="M8 0a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm0 14.67A6.67 6.67 0 1 1 14.67 8 6.67 6.67 0 0 1 8 14.67z" />
            <path class="cls-1" d="M10.25 7.25h-1.5v-1.5a.75.75 0 0 0-1.5 0v1.5h-1.5a.75.75 0 0 0 0 1.5h1.5v1.5a.75.75 0 0 0 1.5 0v-1.5h1.5a.75.75 0 0 0 0-1.5z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-print">
            <title>print</title>
            <circle class="cls-1" cx="3" cy="7" r="1" />
            <path class="cls-1" d="M14.33 4h-1.66V.67A.67.67 0 0 0 12 0H4a.67.67 0 0 0-.67.67V4H1.67A1.67 1.67 0 0 0 0 5.67v6a1.67 1.67 0 0 0 1.67 1.67h1.66v2A.67.67 0 0 0 4 16h8a.67.67 0 0 0 .67-.67v-2h1.67A1.67 1.67 0 0 0 16 11.67v-6A1.67 1.67 0 0 0 14.33 4zM4.67 1.33h6.67V4H4.67zm6.67 13.33H4.67V10h6.67zm3.33-3a.33.33 0 0 1-.33.33h-1.67v-2h.67a.67.67 0 1 0 0-1.33H2.67a.67.67 0 1 0 0 1.33h.67v2H1.67a.33.33 0 0 1-.33-.33v-6a.33.33 0 0 1 .33-.33h12.66a.33.33 0 0 1 .33.33z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-promoted">
            <title>promoted</title>
            <path d="M14.2 0H1.8C.8 0 0 .8 0 1.8v12.4c0 1 .8 1.8 1.8 1.8h12.4c1 0 1.8-.8 1.8-1.8V1.8c0-1-.8-1.8-1.8-1.8zM12 8.8V9c0 .4-.4.7-.8.6-.4 0-.7-.4-.6-.8V6.4l-5.4 5.4-.3.3c-.3.2-.8.1-1-.3s-.1-.8.3-1l5.5-5.5H7.2c-.3 0-.6-.3-.6-.6 0-.4.2-.8.6-.8h4.1c.4 0 .7.3.7.7v4.2z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-question-mark">
            <title>question-mark</title>
            <path class="cls-1" d="M10 4.54a2.67 2.67 0 0 0-1.87-.67 2.7 2.7 0 0 0-2 .8 2.87 2.87 0 0 0-.77 2h1.37v-.08a2.24 2.24 0 0 1 .2-1A1.16 1.16 0 0 1 8.1 5a1.2 1.2 0 0 1 1 .35 1.25 1.25 0 0 1 .28.83 1.2 1.2 0 0 1-.2.67 1.7 1.7 0 0 1-.3.36l-.45.44a3.22 3.22 0 0 0-.83 1.12A2.76 2.76 0 0 0 7.4 10H8.7a3.28 3.28 0 0 1 .1-.85 2.8 2.8 0 0 1 .67-.8 7.2 7.2 0 0 0 1-1.08 1.84 1.84 0 0 0 .25-1A2.23 2.23 0 0 0 10 4.54z" />
            <rect class="cls-1" x="7.39" y="11.06" width="1.34" height="1.34" rx=".33" ry=".33" />
            <path class="cls-1" d="M8 0a8 8 0 1 0 8 8 8 8 0 0 0-8-8zm0 14.67A6.67 6.67 0 1 1 14.67 8 6.67 6.67 0 0 1 8 14.67z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-rebate">
            <title>rebate</title>
            <path class="cls-1" d="M14.84 11.7a3.23 3.23 0 0 0-1.6-1.9 3.1 3.1 0 0 0-2.4-.18c2-2.33 3.1-5.17 2.86-7.17a2.6 2.6 0 0 0-2-2.43.63.63 0 0 0-.7.37L8 7.45 5 .4a.63.63 0 0 0-.72-.4 2.6 2.6 0 0 0-2 2.43c-.24 2 .87 4.84 2.86 7.17a3.12 3.12 0 0 0-2.36.16 3.34 3.34 0 0 0-1.66 3.95 3.18 3.18 0 0 0 3 2.28 3.07 3.07 0 0 0 1.4-.35A3.1 3.1 0 0 0 7 14.23l.1-.2.9-1.9.9 1.87.1.2a3.15 3.15 0 0 0 1.4 1.42 3.08 3.08 0 0 0 1.42.35 3.16 3.16 0 0 0 2.85-1.8 3.36 3.36 0 0 0 .17-2.47zM5 14.48a1.84 1.84 0 0 1-.85.2 1.88 1.88 0 0 1-1.67-1.08 2 2 0 0 1 .85-2.6 1.82 1.82 0 0 1 .85-.2 1.9 1.9 0 0 1 1.7 1.08 2 2 0 0 1-.88 2.6zm2-4.75C4.62 7.46 3.36 4.33 3.57 2.6a1.57 1.57 0 0 1 .52-1.1l3.2 7.6.58 1.36A10.23 10.23 0 0 1 7 9.73zm2 0l-.27-.64 3.2-7.6a1.57 1.57 0 0 1 .5 1.1c.2 1.74-1.04 4.85-3.43 7.13zm4.56 3.88a1.9 1.9 0 0 1-1.7 1.1 2 2 0 0 1-1.2-.43 1.77 1.77 0 0 1-.73-1.4 2 2 0 0 1 1.92-2.1 1.84 1.84 0 0 1 .85.22 1.94 1.94 0 0 1 1 1.12 2 2 0 0 1-.18 1.48z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-rmn-r">
            <title>rmn-r</title>
            <path class="cls-1" d="M14.6 12.8a2.7 2.7 0 0 1-1.7 0c-.6-.2-1-.7-1.4-1.7l-1.2-3.4c3.8-1.3 5.6-3 5.6-5s-1.5-3-4.8-2.5L7.5.8C3.3 1.5 1.7 3.3 1.7 5A2.3 2.3 0 0 0 4 7.4c1 0 1-.5.8-.7A1.7 1.7 0 0 1 4 5c0-1 .8-2.4 3.8-3l.6-.2c-.6 1.4-1.4 4-2.3 6-4.5 2-6 4.4-6 6A2 2 0 0 0 2.3 16c2 0 3.3-1.2 4.5-4l1.5-3.7 1 3.5a5.4 5.4 0 0 0 1.3 2 3 3 0 0 0 2 .8 2.5 2.5 0 0 0 2.4-1.2c.2-.4 0-.7-.4-.6m-10-1.5c-1 2-1.6 3-2.4 3-.4.2-.6 0-.6-.5s.6-2.7 4-4.4l-1 2M9 6.8l1.8-5.4c1.8-.2 2.7.3 2.7 1.6s-1 2.5-3.4 3.4l-1 .4" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-search">
            <title>search</title>
            <path d="M6.2 2.7c1.3 0 2.3 1 2.3 2.3 0 .4-.3.7-.7.7-.3 0-.6-.3-.6-.7 0-.6-.5-1-1-1-.3 0-.6-.3-.6-.6s.3-.7.6-.7z" />
            <path d="M0 5.7c0 3.1 2.5 5.6 5.6 5.6 1.3 0 2.4-.4 3.3-1.1l.9.9c-.3.8-.2 1.8.5 2.4l1.8 1.8c.4.4 1 .6 1.6.6s1.1-.2 1.6-.6c.9-.9.9-2.3 0-3.1l-1.8-1.8c-.4-.4-1-.6-1.6-.6-.3 0-.6.1-.8.2l-1-1c.7-.9 1.1-2.1 1.1-3.3C11.2 2.6 8.7.1 5.6.1S0 2.6 0 5.7zm11.3 5.7c.4-.4.8-.4 1.2 0l1.8 1.8c.9.9-.5 2.1-1.2 1.2l-1.8-1.8c-.4-.5-.4-.9 0-1.2zm-10-5.7c0-2.4 1.9-4.3 4.3-4.3s4.3 1.9 4.3 4.3S8 10 5.6 10 1.3 8.1 1.3 5.7z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-share">
            <title>share</title>
            <path class="cls-1" d="M12.33 5.33h-1.66a.67.67 0 1 0 0 1.33h1.67a.33.33 0 0 1 .33.33v7.33a.33.33 0 0 1-.33.33H3.67a.33.33 0 0 1-.33-.33V7a.33.33 0 0 1 .33-.33h1.66a.67.67 0 0 0 0-1.33H3.67A1.67 1.67 0 0 0 2 7v7.33A1.67 1.67 0 0 0 3.67 16h8.67A1.67 1.67 0 0 0 14 14.33V7a1.67 1.67 0 0 0-1.67-1.67z" />
            <path class="cls-1" d="M5.8 3.8l1.53-1.52v7.05a.67.67 0 1 0 1.33 0V2.28L10.2 3.8a.67.67 0 0 0 .94-.94L8.47.2a.67.67 0 0 0-.94 0L4.86 2.86a.67.67 0 0 0 .94.94z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-shirt">
            <title>shirt</title>
            <path class="cls-1" d="M11.43 14H4.57a.57.57 0 0 1-.57-.57v-5.2l-1.37 1a.57.57 0 0 1-.8-.1L.1 6.88a.56.56 0 0 1 .1-.77l4.57-4a.58.58 0 0 1 .37-.1h.94a.57.57 0 0 1 .4.23v.05a1.72 1.72 0 0 0 3 0A.57.57 0 0 1 10 2h.88a.58.58 0 0 1 .38.14l4.57 4a.56.56 0 0 1 .08.77l-1.73 2.25a.57.57 0 0 1-.8.1l-1.37-1v5.18a.57.57 0 0 1-.57.57zm-6.3-1.13h5.72V7.1a.57.57 0 0 1 .32-.5.57.57 0 0 1 .6.05L13.6 8l1.05-1.4-4-3.47h-.36a2.87 2.87 0 0 1-4.58 0h-.36l-4 3.48L2.4 8l1.83-1.35a.57.57 0 0 1 .6-.05.57.57 0 0 1 .32.5z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-shoe">
            <title>shoe</title>
            <path class="cls-1" d="M12.92 6.33h-2.56a.6.6 0 0 1-.44-.2L6.54 3.15A.58.58 0 0 0 6.08 3a.6.6 0 0 0-.42.26 2.42 2.42 0 0 1-2 1.07 2.42 2.42 0 0 1-2-1.07.6.6 0 0 0-.43-.26A1.3 1.3 0 0 0 0 4.33v7A1.6 1.6 0 0 0 1.54 13h12.92A1.6 1.6 0 0 0 16 11.33V9.67a3.22 3.22 0 0 0-3.08-3.34zM3.7 5.67a3.57 3.57 0 0 0 2.52-1.1l.38.34-.87.96a.7.7 0 0 0 0 .94.58.58 0 0 0 .87 0l1-1 .4.35-1 1.08a.7.7 0 0 0 0 .94.58.58 0 0 0 .87 0L8.9 7l.17.15a1.77 1.77 0 0 0 1.28.56h2.57a1.93 1.93 0 0 1 1.85 2H1.23v-5a3.56 3.56 0 0 0 2.46.97zm11.07 5.67a.32.32 0 0 1-.3.33H1.53a.32.32 0 0 1-.3-.33V11h13.53z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-sliders">
            <title>sliders</title>
            <path class="cls-1" d="M15.2 7.2h-1.6a2.58 2.58 0 0 0-4.93 0H.8a.8.8 0 0 0 0 1.6h7.86a2.58 2.58 0 0 0 4.92 0h1.62a.8.8 0 1 0 0-1.6zm-4.07 2a1.2 1.2 0 1 1 .87-.4 1.2 1.2 0 0 1-.87.4zM.8 3.4h2a2.58 2.58 0 0 0 4.92 0h7.48a.8.8 0 1 0 0-1.6H7.7a2.58 2.58 0 0 0-4.93 0H.8a.8.8 0 0 0 0 1.6zm4.43-2a1.2 1.2 0 1 1-.9.4 1.2 1.2 0 0 1 .9-.4zm9.97 11.2H7.7a2.58 2.58 0 0 0-4.93 0H.8a.8.8 0 0 0 0 1.6h2a2.58 2.58 0 0 0 4.92 0h7.48a.8.8 0 0 0 0-1.6zm-10 2a1.2 1.2 0 1 1 .9-.4 1.2 1.2 0 0 1-.87.4z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-star-outline">
            <title>star-outline</title>
            <path class="icon-outline" fill="currentColor" d="M12.53 16a.67.67 0 0 1-.32-.08L8 13.59l-4.21 2.33a.67.67 0 0 1-1-.69l.81-5-3.41-3.5a.67.67 0 0 1 .38-1.12l4.72-.72L7.4.38a.67.67 0 0 1 1.2 0l2.12 4.51 4.72.72a.67.67 0 0 1 .38 1.12l-3.43 3.52.81 5a.67.67 0 0 1-.66.77z" />
            <path class="icon-fill" d="M8 12.16a.67.67 0 0 1 .32.08l3.33 1.84-.64-4a.67.67 0 0 1 .18-.57L14 6.73l-3.78-.58a.67.67 0 0 1-.5-.38L8 2.24 6.34 5.78a.67.67 0 0 1-.5.38L2 6.73l2.81 2.83a.67.67 0 0 1 .18.57l-.64 4 3.33-1.84a.67.67 0 0 1 .32-.13z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-star">
            <title>star</title>
            <path class="cls-1" d="M12.53 16a.67.67 0 0 1-.32-.08L8 13.6 3.8 15.9a.67.67 0 0 1-1-.7l.8-5-3.4-3.5a.67.67 0 0 1 .37-1.1l4.72-.73L7.4.37a.67.67 0 0 1 1.2 0l2.12 4.5 4.72.73a.67.67 0 0 1 .38 1.13l-3.43 3.52.8 5a.67.67 0 0 1-.66.77z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-stopwatch">
            <title>stopwatch</title>
            <path class="cls-1" d="M8 2a7 7 0 1 0 7 7 7 7 0 0 0-7-7zm0 12.67A5.67 5.67 0 1 1 13.67 9 5.67 5.67 0 0 1 8 14.67z" />
            <rect class="cls-1" x="4.67" width="6.67" height="1.33" rx=".67" ry=".67" />
            <path class="cls-1" d="M10.46 8.67h-2v-2a.67.67 0 1 0-1.33 0v2.66a.67.67 0 0 0 .67.67h2.67a.67.67 0 1 0 0-1.33z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-store">
            <title>store</title>
            <path class="cls-1" d="M16 5.9v-.47a2.43 2.43 0 0 0-.4-1.22l-2-3.44A1.63 1.63 0 0 0 12.3 0H3.7a1.56 1.56 0 0 0-1.27.75l-2 3.47A2.42 2.42 0 0 0 0 5.42v.48a2.13 2.13 0 0 0 1.33 1.92v6.84H.67a.67.67 0 1 0 0 1.34h14.66a.67.67 0 1 0 0-1.33h-.67V7.82A2.13 2.13 0 0 0 16 5.9zM1.33 5.43a1.88 1.88 0 0 1 .24-.56l2-3.46a.3.3 0 0 1 .13-.07h8.57a.46.46 0 0 1 .18.08l2 3.46a2 2 0 0 1 .24.57v.47a.86.86 0 0 1-1.7 0 .67.67 0 0 0-1.33 0 .76.76 0 0 1-1.53 0 .67.67 0 0 0-1.33 0 .77.77 0 0 1-1.52 0 .67.67 0 1 0-1.33 0 .77.77 0 0 1-.77.76.78.78 0 0 1-.8-.76.67.67 0 1 0-1.38 0 .8.8 0 0 1-.8.76.85.85 0 0 1-.87-.76zm4 9.23v-3.33h1.34v3.33zm2.67 0v-4a.67.67 0 0 0-.67-.66H4.67a.67.67 0 0 0-.67.67v4H2.67V7.94a2.18 2.18 0 0 0 1-.52 2.12 2.12 0 0 0 2.9 0 2.1 2.1 0 0 0 2.87 0 2.1 2.1 0 0 0 2.88 0 2.25 2.25 0 0 0 1 .53v6.72z" />
            <rect class="cls-1" x="9.33" y="10" width="2.67" height="2.67" rx=".67" ry=".67" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-tag-add">
            <title>tag-add</title>
            <path class="cls-1" d="M15.36 6.82v-5.2A1.63 1.63 0 0 0 13.73 0h-5.2A1.62 1.62 0 0 0 7.4.48L.47 7.38a1.63 1.63 0 0 0 0 2.3l5.2 5.2a1.63 1.63 0 0 0 2.3 0L14.87 8a1.62 1.62 0 0 0 .48-1.18zm-1.28 0a.35.35 0 0 1-.1.25L7.06 14a.36.36 0 0 1-.5 0L1.4 8.8a.35.35 0 0 1 0-.5L8.3 1.38a.35.35 0 0 1 .25-.1h5.2a.35.35 0 0 1 .34.35z" />
            <circle class="cls-1" cx="10.89" cy="4.5" r="1.28" />
            <path class="cls-1" d="M15.38 12.88h-1.25v-1.25a.63.63 0 0 0-1.25 0v1.25h-1.25a.63.63 0 0 0 0 1.25h1.25v1.25a.63.63 0 0 0 1.25 0v-1.25h1.25a.63.63 0 0 0 0-1.25z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-tag">
            <title>tag</title>
            <path class="cls-1" d="M14.3 0H8.9a1.7 1.7 0 0 0-1.2.5L.5 7.7a1.7 1.7 0 0 0 0 2.4l5.4 5.4a1.7 1.7 0 0 0 2.4 0l7.2-7.2a1.7 1.7 0 0 0 .5-1.2V1.7A1.7 1.7 0 0 0 14.3 0zm.36 7.1a.37.37 0 0 1-.1.26l-7.2 7.2a.37.37 0 0 1-.52 0l-5.4-5.4a.36.36 0 0 1 0-.5l7.2-7.2a.36.36 0 0 1 .26-.12h5.4a.36.36 0 0 1 .36.36z" />
            <circle class="cls-1" cx="11.33" cy="4.67" r="1.33" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-thumbs-down">
            <title>thumbs-down</title>
            <path class="cls-1" d="M13.7 0H7.62a5.9 5.9 0 0 0-3.4.92A1.16 1.16 0 0 0 3.5.67H1.17A1.17 1.17 0 0 0 0 1.84v7A1.17 1.17 0 0 0 1.17 10H3.5a1.16 1.16 0 0 0 .6-.17 3.3 3.3 0 0 0 1.12.44c.86.18 1.4 1.9 1.45 4.47A1.28 1.28 0 0 0 8 16h1a2.3 2.3 0 0 0 2.3-2.34v-3h2.4a2.5 2.5 0 0 0 2.3-2.5V2.3A2.3 2.3 0 0 0 13.7 0zM1.33 8.67V2h2v6.67zm13.33-.52a1.18 1.18 0 0 1-1 1.2h-2.53a1 1 0 0 0-1.13 1.1v3.2a1 1 0 0 1-1 1H8C8 12.3 7.5 9.4 5.5 9c-.6-.13-.8-.32-.83-.38V2.25a4.12 4.12 0 0 1 3-.92h6.03a1 1 0 0 1 1 1z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-thumbs-up">
            <title>thumbs-up</title>
            <path class="cls-1" d="M13.7 5.33h-2.37v-3A2.3 2.3 0 0 0 9 0H8a1.28 1.28 0 0 0-1.33 1.25c0 2.58-.6 4.3-1.45 4.47a3.3 3.3 0 0 0-1.13.44A1.16 1.16 0 0 0 3.5 6H1.17A1.17 1.17 0 0 0 0 7.17v7a1.17 1.17 0 0 0 1.17 1.17H3.5a1.16 1.16 0 0 0 .72-.25 5.9 5.9 0 0 0 3.4.9h6.08a2.3 2.3 0 0 0 2.3-2.3V7.85a2.5 2.5 0 0 0-2.3-2.52zm-12.37 2h2V14h-2zm13.34 6.37a1 1 0 0 1-1 1H7.62a4.12 4.12 0 0 1-3-.9V7.4c0-.05.2-.24.83-.37C7.5 6.6 8 3.7 8 1.33h1a1 1 0 0 1 1 1v3.2a1 1 0 0 0 1.13 1.13h2.57a1.18 1.18 0 0 1 1 1.2z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-toy">
            <title>toy</title>
            <path class="cls-1" d="M12.67 2h-1.34v-.33A1.67 1.67 0 0 0 9.67 0H6.33a1.67 1.67 0 0 0-1.66 1.67V2H3.33A3.34 3.34 0 0 0 0 5.33v5.33A3.34 3.34 0 0 0 3.33 14H4v1.33a.67.67 0 0 0 .67.67h6.67a.67.67 0 0 0 .67-.67V14h.67A3.34 3.34 0 0 0 16 10.67V5.33A3.34 3.34 0 0 0 12.67 2zM6 1.67a.33.33 0 0 1 .33-.33h3.34a.33.33 0 0 1 .33.33V2H6zm4.67 13H5.33V14h5.33zm4-4a2 2 0 0 1-2 2H3.33a2 2 0 0 1-2-2V5.33a2 2 0 0 1 2-2h9.33a2 2 0 0 1 2 2z" />
            <circle class="cls-1" cx="5.67" cy="6.33" r="1" />
            <circle class="cls-1" cx="10.33" cy="6.33" r="1" />
            <path class="cls-1" d="M10.64 8.76a.67.67 0 0 0-.91.24 2 2 0 0 1-3.46 0 .67.67 0 1 0-1.16.67 3.33 3.33 0 0 0 5.77 0 .67.67 0 0 0-.24-.91z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-trophy">
            <title>trophy</title>
            <path d="M14.8 3.8h-2.1V1.3c0-.7-.6-1.3-1.3-1.3H4.7c-.8 0-1.4.6-1.4 1.3v2.4H1.2C.5 3.8 0 4.3 0 4.9c0 2.2 1.6 4 3.5 4h.4c.7 1.2 1.9 2.1 3.4 2.4v3.4H4.7c-.4 0-.7.3-.7.6 0 .4.3.7.7.7h6.7c.4 0 .7-.3.7-.7 0-.4-.3-.7-.7-.7H8.7v-3.4c1.5-.2 2.7-1.1 3.4-2.4h.4c1.9 0 3.5-1.8 3.5-4 0-.5-.5-1-1.2-1zM1.3 5.1h2v1.5c0 .3 0 .6.1.9-1.1 0-2-1-2.1-2.4zm6.4 4.8c-1.7-.2-3-1.7-3-3.5V2c0-.4.3-.7.7-.7h5.3c.4 0 .7.3.7.7v4.6c-.1 2-1.7 3.5-3.7 3.3zm4.9-2.3c.1-.3.1-.6.1-.9V5.1h2c-.1 1.4-1 2.4-2.1 2.5z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-user">
            <title>user</title>
            <path class="cls-1" d="M12.26 8.22a5.1 5.1 0 1 0-8.12-.12 5.07 5.07 0 0 0-4.14 5v1.08A1.86 1.86 0 0 0 1.82 16h12.5A1.7 1.7 0 0 0 16 14.3v-1.24a5 5 0 0 0-3.74-4.84zm-4-6.76A3.63 3.63 0 1 1 4.6 5.1a3.64 3.64 0 0 1 3.64-3.65zm6.3 12.83c0 .1-.1.26-.22.26H1.82a.4.4 0 0 1-.36-.4v-1.1a3.64 3.64 0 0 1 3.68-3.6h.47a5.06 5.06 0 0 0 5.26 0 3.63 3.63 0 0 1 3.64 3.6z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-watch">
            <title>watch</title>
            <path class="cls-1" d="M7.7 9h2a.7.7 0 0 0 0-1.3H8.3V6.3a.7.7 0 0 0-1.3 0v2a.7.7 0 0 0 .7.7z" />
            <path class="cls-1" d="M11.7 4.6V1.3A1.3 1.3 0 0 0 10.3 0H5.7a1.3 1.3 0 0 0-1.4 1.3v3.3a5 5 0 0 0 0 6.8v3.3A1.3 1.3 0 0 0 5.7 16h4.6a1.3 1.3 0 0 0 1.4-1.3v-3.3a5 5 0 0 0 0-6.8zM5.7 2a.7.7 0 0 1 .6-.7h3.4a.7.7 0 0 1 .6.7v1.6a5 5 0 0 0-4.6 0zm4.6 12a.7.7 0 0 1-.6.7H6.3a.7.7 0 0 1-.6-.7v-1.6a5 5 0 0 0 4.6 0zm0-3.2A3.7 3.7 0 1 1 11.7 8a3.6 3.6 0 0 1-1.4 2.8z" />
        </symbol>
        <symbol viewBox="0 0 16 16" id="icon-x">
            <title>x</title>
            <path class="cls-1" d="M10.27 9.13L9.13 8l1.13-1.13a.8.8 0 0 0-1.13-1.14L8 6.87 6.87 5.73a.8.8 0 0 0-1.14 1.14L6.87 8 5.73 9.13a.8.8 0 0 0 1.13 1.13L8 9.13l1.13 1.13a.8.8 0 0 0 1.13-1.13z" />
        </symbol>
    </svg>
</div>
<meta id="initial-state" content="{&quot;analytics&quot;:{&quot;host&quot;:&quot;https://a.retailmenot.com&quot;},&quot;ui&quot;:{&quot;mainRouter&quot;:{&quot;router&quot;:{&quot;currentRoute&quot;:{&quot;path&quot;:&quot;/saved&quot;,&quot;template&quot;:&quot;@rmn/member-profile/saved-offers&quot;}},&quot;@rmn/member-profile/saved-offers&quot;:{&quot;savedOffers&quot;:{&quot;ADQIYCJ2XFA75NHV7UA3SUN7CU&quot;:{&quot;isSaved&quot;:true,&quot;descriptionExpanded&quot;:false,&quot;isDetailsExpanded&quot;:false,&quot;offerItemDetails&quot;:{&quot;activeTabIndex&quot;:0,&quot;tabData&quot;:[{&quot;isActive&quot;:true},{&quot;isActive&quot;:false}]}}},&quot;expiredOffers&quot;:{}},&quot;@rmn/member-profile/error&quot;:{}},&quot;deleteUserModal&quot;:{&quot;isOpen&quot;:false,&quot;rebateHelpUrl&quot;:&quot;http://help.retailmenot.com/customer/en/portal/topics/819298-cash-back-offers/articles&quot;},&quot;cashbackStateExplanationModal&quot;:{&quot;isOpen&quot;:false,&quot;rebateHelpUrl&quot;:&quot;http://help.retailmenot.com/customer/en/portal/topics/819298-cash-back-offers/articles&quot;},&quot;siteHeader&quot;:{&quot;initSearchOpen&quot;:false},&quot;mobileBrowseCouponsPopupMenu&quot;:{&quot;isOpen&quot;:false},&quot;app&quot;:{&quot;classList&quot;:[],&quot;overlayWidth&quot;:0,&quot;showOffCanvasMenu&quot;:false}},&quot;apollo&quot;:{&quot;data&quot;:{&quot;Member:UFLPJNZ4RJHLTJB75Y7ZOILTXE&quot;:{&quot;id&quot;:&quot;UFLPJNZ4RJHLTJB75Y7ZOILTXE&quot;,&quot;authScope&quot;:&quot;NONE&quot;,&quot;__typename&quot;:&quot;Member&quot;,&quot;profile&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Member:UFLPJNZ4RJHLTJB75Y7ZOILTXE.profile&quot;,&quot;generated&quot;:true},&quot;favoriteMerchants&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Merchant:43QESPYSIZEHNFHL3OUQNONBAE&quot;,&quot;generated&quot;:false},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Merchant:KEWTLR3TNZGTROSIDWHX7HI4AI&quot;,&quot;generated&quot;:false}],&quot;savedOffers&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU&quot;,&quot;generated&quot;:false}]},&quot;ROOT_QUERY&quot;:{&quot;member&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Member:UFLPJNZ4RJHLTJB75Y7ZOILTXE&quot;,&quot;generated&quot;:false},&quot;roux&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux&quot;,&quot;generated&quot;:true},&quot;__typename&quot;:&quot;Query&quot;},&quot;$ROOT_QUERY.roux.placements.0&quot;:{&quot;key&quot;:&quot;rmn_search_box_stores&quot;,&quot;value&quot;:&quot;Save on Stores, Brands &amp; Categories&quot;,&quot;__typename&quot;:&quot;Placement&quot;},&quot;$ROOT_QUERY.roux.placements.1&quot;:{&quot;key&quot;:&quot;rmn_seo_links&quot;,&quot;value&quot;:&quot;&lt;div class&#x3D;\&quot;column\&quot;&gt;\r\n  &lt;h4 class&#x3D;\&quot;col-header site-footer-title\&quot;&gt;Specialty Pages&lt;/h4&gt;\r\n  &lt;ul class&#x3D;\&quot;site-footer-list\&quot;&gt;\r\n    &lt;li&gt;&lt;a class&#x3D;\&quot;track site-footer-list-link js-track\&quot; data-track-category&#x3D;\&quot;Footer\&quot; data-track-action&#x3D;\&quot;textlink\&quot; href&#x3D;\&quot;/freeshipping\&quot;&gt;Free Shipping&lt;/a&gt;&lt;/li&gt;\r\n&lt;li&gt;&lt;a class&#x3D;\&quot;track site-footer-list-link js-track\&quot; data-track-category&#x3D;\&quot;Footer\&quot; data-track-action&#x3D;\&quot;textlink\&quot; href&#x3D;\&quot;https://giftcardzen.com/\&quot;&gt;Gift Card Zen&lt;/a&gt;&lt;/li&gt;\r\n&lt;li&gt;&lt;a class&#x3D;\&quot;track site-footer-list-link is-track\&quot; data-track-category&#x3D;\&quot;Footer\&quot; data-track-action&#x3D;\&quot;textlink\&quot; href&#x3D;\&quot;https://www.retailmenot.com/senior-citizen-discounts/\&quot;&gt;Senior Citizen Discounts&lt;/a&gt;&lt;/li&gt;\r\n&lt;li&gt;&lt;a class&#x3D;\&quot;track site-footer-list-link is-track\&quot; data-track-category&#x3D;\&quot;Footer\&quot; data-track-action&#x3D;\&quot;textlink\&quot; href&#x3D;\&quot;https://www.retailmenot.com/deals/christmas\&quot;&gt;Christmas Deals&lt;/a&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n&lt;/div&gt;&quot;,&quot;__typename&quot;:&quot;Placement&quot;},&quot;$ROOT_QUERY.roux&quot;:{&quot;placements&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.placements.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.placements.1&quot;,&quot;generated&quot;:true}],&quot;header&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header&quot;,&quot;generated&quot;:true},&quot;footer&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer&quot;,&quot;generated&quot;:true},&quot;__typename&quot;:&quot;Roux&quot;},&quot;$ROOT_QUERY.roux.header.logoLink&quot;:{&quot;href&quot;:&quot;/&quot;,&quot;display&quot;:null,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;hide-at-large&quot;]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header&quot;:{&quot;logoLink&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.logoLink&quot;,&quot;generated&quot;:true},&quot;ideasLink&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.ideasLink&quot;,&quot;generated&quot;:true},&quot;profileLink&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.profileLink&quot;,&quot;generated&quot;:true},&quot;joinLink&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.joinLink&quot;,&quot;generated&quot;:true},&quot;loginLink&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.loginLink&quot;,&quot;generated&quot;:true},&quot;popupMenu&quot;:{&quot;quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu&quot;,&quot;generated&quot;:true},&quot;userBarMenu&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.userBarMenu&quot;,&quot;generated&quot;:true},&quot;__typename&quot;:&quot;Header&quot;},&quot;$ROOT_QUERY.roux.header.ideasLink&quot;:{&quot;href&quot;:&quot;/ideas/backtoschool&quot;,&quot;display&quot;:&quot;Back to School&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.profileLink&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/profile&quot;,&quot;display&quot;:null,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.joinLink&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/signup&quot;,&quot;display&quot;:&quot;Sign up&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.loginLink&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/login&quot;,&quot;display&quot;:&quot;Log in&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu&quot;:{&quot;title&quot;:&quot;Browse Deals&quot;,&quot;links&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.3&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.4&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.5&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.6&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.7&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.popupMenu.links.8&quot;,&quot;generated&quot;:true}],&quot;__typename&quot;:&quot;Menu&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.0&quot;:{&quot;href&quot;:&quot;/ideas/backtoschool&quot;,&quot;display&quot;:&quot;Back to School&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.1&quot;:{&quot;href&quot;:&quot;/coupons/codes&quot;,&quot;display&quot;:&quot;Coupon Codes&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.2&quot;:{&quot;href&quot;:&quot;/coupons/printable&quot;,&quot;display&quot;:&quot;Printable Coupons&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.3&quot;:{&quot;href&quot;:&quot;/coupons/freeshipping&quot;,&quot;display&quot;:&quot;Free Shipping&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.4&quot;:{&quot;href&quot;:&quot;/ideas/hot-products&quot;,&quot;display&quot;:&quot;Product Deals&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.5&quot;:{&quot;href&quot;:&quot;/coupons/exclusives&quot;,&quot;display&quot;:&quot;Only at RetailMeNot&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.6&quot;:{&quot;href&quot;:&quot;/cashback&quot;,&quot;display&quot;:&quot;Cash Back Offers&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.7&quot;:{&quot;href&quot;:&quot;/coupons/&quot;,&quot;display&quot;:&quot;Browse by Category&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.popupMenu.links.8&quot;:{&quot;href&quot;:&quot;/blog/&quot;,&quot;display&quot;:&quot;Blog&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.userBarMenu&quot;:{&quot;title&quot;:null,&quot;links&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.userBarMenu.links.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.userBarMenu.links.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.userBarMenu.links.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.userBarMenu.links.3&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.userBarMenu.links.4&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.header.userBarMenu.links.5&quot;,&quot;generated&quot;:true}],&quot;__typename&quot;:&quot;Menu&quot;},&quot;$ROOT_QUERY.roux.header.userBarMenu.links.0&quot;:{&quot;href&quot;:&quot;/profile&quot;,&quot;display&quot;:&quot;View Profile&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:&quot;create&quot;,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.userBarMenu.links.1&quot;:{&quot;href&quot;:&quot;/saved&quot;,&quot;display&quot;:&quot;Saved Offers&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.userBarMenu.links.2&quot;:{&quot;href&quot;:&quot;/favorites&quot;,&quot;display&quot;:&quot;Favorite Stores&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.userBarMenu.links.3&quot;:{&quot;href&quot;:&quot;/my-cashback&quot;,&quot;display&quot;:&quot;My Cash Back&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.userBarMenu.links.4&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/community&quot;,&quot;display&quot;:&quot;Community&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.header.userBarMenu.links.5&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/community/logout&quot;,&quot;display&quot;:&quot;Log out&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;js-logout&quot;]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.0&quot;:{&quot;label&quot;:&quot;Specialty Pages&quot;,&quot;links&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.0.links.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.0.links.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.0.links.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.0.links.3&quot;,&quot;generated&quot;:true}],&quot;__typename&quot;:&quot;LinkGroup&quot;},&quot;$ROOT_QUERY.roux.footer.links.0.links.0&quot;:{&quot;href&quot;:&quot;/deals/blackfriday&quot;,&quot;display&quot;:&quot;Black Friday Deals&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.0.links.1&quot;:{&quot;href&quot;:&quot;/deals/cybermonday&quot;,&quot;display&quot;:&quot;Cyber Monday Deals&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.0.links.2&quot;:{&quot;href&quot;:&quot;/ideas/backtoschool&quot;,&quot;display&quot;:&quot;Back to School&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.0.links.3&quot;:{&quot;href&quot;:&quot;/coupons&quot;,&quot;display&quot;:&quot;Browse Categories&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.1&quot;:{&quot;label&quot;:&quot;Connect&quot;,&quot;links&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.1.links.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.1.links.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.1.links.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.1.links.3&quot;,&quot;generated&quot;:true}],&quot;__typename&quot;:&quot;LinkGroup&quot;},&quot;$ROOT_QUERY.roux.footer.links.1.links.0&quot;:{&quot;href&quot;:&quot;http://help.retailmenot.com/&quot;,&quot;display&quot;:&quot;Help&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.1.links.1&quot;:{&quot;href&quot;:&quot;http://www.facebook.com/RetailMeNot&quot;,&quot;display&quot;:&quot;Facebook&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.1.links.2&quot;:{&quot;href&quot;:&quot;http://twitter.com/retailmenot&quot;,&quot;display&quot;:&quot;Twitter&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.1.links.3&quot;:{&quot;href&quot;:&quot;https://www.instagram.com/retailmenot/&quot;,&quot;display&quot;:&quot;Instagram&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.2&quot;:{&quot;label&quot;:&quot;Account&quot;,&quot;links&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.2.links.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.2.links.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.2.links.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.2.links.3&quot;,&quot;generated&quot;:true}],&quot;__typename&quot;:&quot;LinkGroup&quot;},&quot;$ROOT_QUERY.roux.footer.links.2.links.0&quot;:{&quot;href&quot;:&quot;/profile&quot;,&quot;display&quot;:&quot;My Account&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.2.links.1&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/community/&quot;,&quot;display&quot;:&quot;Community&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.2.links.2&quot;:{&quot;href&quot;:&quot;/submit&quot;,&quot;display&quot;:&quot;Submit a Coupon&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.2.links.3&quot;:{&quot;href&quot;:&quot;http://www.retailmenot.ca&quot;,&quot;display&quot;:&quot;RetailMeNot.ca&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.3&quot;:{&quot;label&quot;:&quot;General&quot;,&quot;links&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.3.links.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.3.links.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.3.links.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.3.links.3&quot;,&quot;generated&quot;:true}],&quot;__typename&quot;:&quot;LinkGroup&quot;},&quot;$ROOT_QUERY.roux.footer.links.3.links.0&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/corp/&quot;,&quot;display&quot;:&quot;About&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.3.links.1&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/blog/&quot;,&quot;display&quot;:&quot;Blog&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.3.links.2&quot;:{&quot;href&quot;:&quot;https://www.retailmenot.com/corp/careers/&quot;,&quot;display&quot;:&quot;Careers&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.links.3.links.3&quot;:{&quot;href&quot;:&quot;http://help.retailmenot.com/&quot;,&quot;display&quot;:&quot;Contact&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer&quot;:{&quot;links&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.links.3&quot;,&quot;generated&quot;:true}],&quot;secondaryLinks&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.secondaryLinks.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.secondaryLinks.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.secondaryLinks.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.secondaryLinks.3&quot;,&quot;generated&quot;:true}],&quot;currentYear&quot;:&quot;2017&quot;,&quot;downloadAppData&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$ROOT_QUERY.roux.footer.downloadAppData&quot;,&quot;generated&quot;:true},&quot;__typename&quot;:&quot;Footer&quot;},&quot;$ROOT_QUERY.roux.footer.secondaryLinks.0&quot;:{&quot;href&quot;:&quot;/static/terms/&quot;,&quot;display&quot;:&quot;Terms of Use&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.secondaryLinks.1&quot;:{&quot;href&quot;:&quot;/static/privacy/&quot;,&quot;display&quot;:&quot;Privacy Policy&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.secondaryLinks.2&quot;:{&quot;href&quot;:&quot;/sitemap/&quot;,&quot;display&quot;:&quot;Sitemap&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.secondaryLinks.3&quot;:{&quot;href&quot;:&quot;/static/privacy/#ad-choices&quot;,&quot;display&quot;:&quot;Ad Choices&quot;,&quot;isActive&quot;:null,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;icon&quot;:null,&quot;__typename&quot;:&quot;Link&quot;},&quot;$ROOT_QUERY.roux.footer.downloadAppData&quot;:{&quot;appUrl&quot;:&quot;https://163424.measurementapi.com/serve?action&#x3D;click&amp;publisher_id&#x3D;163424&amp;site_id&#x3D;103086&amp;site_id_ios&#x3D;95000&amp;site_id_android&#x3D;95002&amp;site_id_web&#x3D;103086&amp;my_campaign&#x3D;rmnfooter&amp;my_adgroup&#x3D;&quot;,&quot;__typename&quot;:&quot;DownloadAppData&quot;},&quot;$Member:UFLPJNZ4RJHLTJB75Y7ZOILTXE.profile&quot;:{&quot;username&quot;:&quot;s400hacker&quot;,&quot;photo&quot;:&quot;https://graph.facebook.com/472300953168835/picture?type&#x3D;large&quot;,&quot;__typename&quot;:&quot;MemberProfile&quot;},&quot;Merchant:43QESPYSIZEHNFHL3OUQNONBAE&quot;:{&quot;id&quot;:&quot;43QESPYSIZEHNFHL3OUQNONBAE&quot;,&quot;__typename&quot;:&quot;Merchant&quot;},&quot;Merchant:KEWTLR3TNZGTROSIDWHX7HI4AI&quot;:{&quot;id&quot;:&quot;KEWTLR3TNZGTROSIDWHX7HI4AI&quot;,&quot;__typename&quot;:&quot;Merchant&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU&quot;:{&quot;id&quot;:&quot;ADQIYCJ2XFA75NHV7UA3SUN7CU&quot;,&quot;__typename&quot;:&quot;Offer&quot;,&quot;legacyId&quot;:9031356,&quot;title&quot;:&quot;Up to 75% off surprise sale + Free shipping on $99+&quot;,&quot;isExpired&quot;:false,&quot;source&quot;:null,&quot;status&quot;:&quot;APPROVED&quot;,&quot;offerType&quot;:&quot;tip&quot;,&quot;description&quot;:&quot;surprise sale starts now! Get up to 75% off + Free shipping when you spend $99 or more!&quot;,&quot;affiliateLink&quot;:&quot;https://click.linksynergy.com/fs-bin/click?id&#x3D;OOTtr9mlaCk&amp;offerid&#x3D;514462.23&amp;type&#x3D;3&quot;,&quot;redemptionLocations&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;online&quot;]},&quot;onlineRedemptionType&quot;:&quot;SALE&quot;,&quot;inStoreRedemptionType&quot;:null,&quot;score&quot;:&quot;63&quot;,&quot;logoUrl&quot;:&quot;https://www.retailmenot.com/thumbs/logos/l/katespade.com-coupons.jpg?versionId&#x3D;ZUmweTZ5VlFaKEZYqzbdkJK3HOnYbE.u&quot;,&quot;dataAttributes&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.2&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.3&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.4&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.5&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.6&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.7&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.8&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.9&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.10&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.11&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.12&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.13&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.14&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.15&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.16&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.17&quot;,&quot;generated&quot;:true}],&quot;offerClassList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;sale&quot;]},&quot;isOutOfContext&quot;:true,&quot;offerTypeLabel&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerTypeLabel&quot;,&quot;generated&quot;:true},&quot;siteTitle&quot;:&quot;Kate Spade&quot;,&quot;starsDisabled&quot;:false,&quot;outclickUrlPath&quot;:&quot;/out/9031356&quot;,&quot;titleClassList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;js-triggers-outclick&quot;]},&quot;parsedOfferTitle&quot;:&quot;Up to 75% Off Surprise Sale + Free Shipping on $99+&quot;,&quot;isSponsored&quot;:false,&quot;submittedByProfileUrl&quot;:null,&quot;username&quot;:null,&quot;numberOfUsesText&quot;:&quot;9.4k uses today&quot;,&quot;CTA&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.CTA&quot;,&quot;generated&quot;:true},&quot;OmniCTA&quot;:null,&quot;offerItemDetails&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails&quot;,&quot;generated&quot;:true},&quot;titleDataAttributes&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.titleDataAttributes.0&quot;,&quot;generated&quot;:true}],&quot;logoLinkPath&quot;:&quot;/view/katespade.com&quot;,&quot;offerLogoClassList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;merchant-logo&quot;,&quot;js-merchant-logo&quot;]},&quot;storeLogoLargeUrl&quot;:&quot;https://www.retailmenot.com/thumbs/logos/l/katespade.com-coupons.jpg?versionId&#x3D;ZUmweTZ5VlFaKEZYqzbdkJK3HOnYbE.u&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.0&quot;:{&quot;key&quot;:&quot;has-submitter&quot;,&quot;value&quot;:&quot;false&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.1&quot;:{&quot;key&quot;:&quot;new-tab&quot;,&quot;value&quot;:&quot;/out/9031356&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.2&quot;:{&quot;key&quot;:&quot;out-url&quot;,&quot;value&quot;:&quot;/out/9031356&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.3&quot;:{&quot;key&quot;:&quot;merchant-url&quot;,&quot;value&quot;:&quot;/out/S143489&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.4&quot;:{&quot;key&quot;:&quot;offer-type&quot;,&quot;value&quot;:&quot;sale&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.5&quot;:{&quot;key&quot;:&quot;site-id&quot;,&quot;value&quot;:&quot;143489&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.6&quot;:{&quot;key&quot;:&quot;type&quot;,&quot;value&quot;:&quot;sale&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.7&quot;:{&quot;key&quot;:&quot;main-tab&quot;,&quot;value&quot;:&quot;/saved&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.8&quot;:{&quot;key&quot;:&quot;offer-uuid&quot;,&quot;value&quot;:&quot;ADQIYCJ2XFA75NHV7UA3SUN7CU&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.9&quot;:{&quot;key&quot;:&quot;analytics-click-location&quot;,&quot;value&quot;:&quot;offer body&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.10&quot;:{&quot;key&quot;:&quot;couponrank&quot;,&quot;value&quot;:&quot;0.44&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.11&quot;:{&quot;key&quot;:&quot;couponscore&quot;,&quot;value&quot;:&quot;63&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.12&quot;:{&quot;key&quot;:&quot;offer-position&quot;,&quot;value&quot;:&quot;1&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.13&quot;:{&quot;key&quot;:&quot;site-uuid&quot;,&quot;value&quot;:&quot;6HVWN4SEOZCO3IB72JD5HBKK5Q&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.14&quot;:{&quot;key&quot;:&quot;site-title&quot;,&quot;value&quot;:&quot;Kate Spade&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.15&quot;:{&quot;key&quot;:&quot;merchant-name&quot;,&quot;value&quot;:&quot;katespade.com&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.16&quot;:{&quot;key&quot;:&quot;offer-id&quot;,&quot;value&quot;:&quot;9031356&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.dataAttributes.17&quot;:{&quot;key&quot;:&quot;comment-count&quot;,&quot;value&quot;:&quot;1&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerTypeLabel&quot;:{&quot;text&quot;:&quot;Sale&quot;,&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;offer-type-sale&quot;]},&quot;__typename&quot;:&quot;OfferTypeLabel&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.CTA&quot;:{&quot;CTAText&quot;:&quot;Get Deal&quot;,&quot;hasCodeRevealed&quot;:false,&quot;CodeButton&quot;:false,&quot;ctaButtonClassList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;js-triggers-outclick&quot;]},&quot;ctaButtonDataAttributes&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.CTA.ctaButtonDataAttributes.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.CTA.ctaButtonDataAttributes.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.CTA.ctaButtonDataAttributes.2&quot;,&quot;generated&quot;:true}],&quot;__typename&quot;:&quot;CTA&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.CTA.ctaButtonDataAttributes.0&quot;:{&quot;key&quot;:&quot;analytics-click-location&quot;,&quot;value&quot;:&quot;OfferCode&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.CTA.ctaButtonDataAttributes.1&quot;:{&quot;key&quot;:&quot;main-tab&quot;,&quot;value&quot;:&quot;/saved&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.CTA.ctaButtonDataAttributes.2&quot;:{&quot;key&quot;:&quot;new-tab&quot;,&quot;value&quot;:&quot;/out/9031356&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0&quot;:{&quot;comments&quot;:null,&quot;details&quot;:null,&quot;exclusions&quot;:true,&quot;tabId&quot;:&quot;tab-9031356-exclusions&quot;,&quot;tabHeader&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0.tabHeader&quot;,&quot;generated&quot;:true},&quot;tabContent&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0.tabContent&quot;,&quot;generated&quot;:true},&quot;__typename&quot;:&quot;TabData&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0.tabHeader&quot;:{&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;tabLinkClassList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;title&quot;:&quot;Exclusions&quot;,&quot;promptName&quot;:&quot;offer exclusions&quot;,&quot;__typename&quot;:&quot;TabHeader&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0.tabContent&quot;:{&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;offer-item-tabs-content-exclusions&quot;]},&quot;contentSections&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0.tabContent.contentSections.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0.tabContent.contentSections.1&quot;,&quot;generated&quot;:true}],&quot;exclusionsText&quot;:&quot;Not valid at katespade.com, kate spade new york specialty shops or kate spade new york outlet shops. All sales final.&quot;,&quot;__typename&quot;:&quot;TabContent&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0.tabContent.contentSections.0&quot;:{&quot;labelText&quot;:&quot;Ends:&quot;,&quot;text&quot;:&quot;08/19/17&quot;,&quot;__typename&quot;:&quot;ContentSection&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0.tabContent.contentSections.1&quot;:{&quot;labelText&quot;:&quot;Exclusions:&quot;,&quot;text&quot;:&quot;Not valid at katespade.com, kate spade new york specialty shops or kate spade new york outlet shops. All sales final.&quot;,&quot;__typename&quot;:&quot;ContentSection&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1&quot;:{&quot;comments&quot;:null,&quot;details&quot;:true,&quot;exclusions&quot;:null,&quot;tabId&quot;:&quot;tab-9031356-details&quot;,&quot;tabHeader&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1.tabHeader&quot;,&quot;generated&quot;:true},&quot;tabContent&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1.tabContent&quot;,&quot;generated&quot;:true},&quot;__typename&quot;:&quot;TabData&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1.tabHeader&quot;:{&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;tabLinkClassList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[]},&quot;title&quot;:&quot;Details&quot;,&quot;promptName&quot;:&quot;offer details&quot;,&quot;__typename&quot;:&quot;TabHeader&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1.tabContent&quot;:{&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;offer-item-tabs-content-details&quot;]},&quot;contentSections&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1.tabContent.contentSections.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1.tabContent.contentSections.1&quot;,&quot;generated&quot;:true}],&quot;exclusionsText&quot;:null,&quot;__typename&quot;:&quot;TabContent&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1.tabContent.contentSections.0&quot;:{&quot;labelText&quot;:&quot;Ends:&quot;,&quot;text&quot;:&quot;08/19/17&quot;,&quot;__typename&quot;:&quot;ContentSection&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1.tabContent.contentSections.1&quot;:{&quot;labelText&quot;:&quot;Details:&quot;,&quot;text&quot;:&quot;surprise sale starts now! Get up to 75% off + Free shipping when you spend $99 or more!&quot;,&quot;__typename&quot;:&quot;ContentSection&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.2&quot;:{&quot;comments&quot;:true,&quot;details&quot;:null,&quot;exclusions&quot;:null,&quot;tabId&quot;:&quot;tab-9031356-comments&quot;,&quot;tabHeader&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.2.tabHeader&quot;,&quot;generated&quot;:true},&quot;tabContent&quot;:{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.2.tabContent&quot;,&quot;generated&quot;:true},&quot;__typename&quot;:&quot;TabData&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.2.tabHeader&quot;:{&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;js-comments-tab&quot;]},&quot;tabLinkClassList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;js-comment-count&quot;]},&quot;title&quot;:&quot;1 Comment&quot;,&quot;promptName&quot;:&quot;add a comment&quot;,&quot;__typename&quot;:&quot;TabHeader&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.2.tabContent&quot;:{&quot;classList&quot;:{&quot;type&quot;:&quot;json&quot;,&quot;json&quot;:[&quot;offer-item-tabs-content-feedback&quot;]},&quot;contentSections&quot;:[],&quot;exclusionsText&quot;:null,&quot;__typename&quot;:&quot;TabContent&quot;},&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails&quot;:{&quot;tabData&quot;:[{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.0&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.1&quot;,&quot;generated&quot;:true},{&quot;type&quot;:&quot;id&quot;,&quot;id&quot;:&quot;$Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.offerItemDetails.tabData.2&quot;,&quot;generated&quot;:true}],&quot;__typename&quot;:&quot;OfferItemDetails&quot;},&quot;Offer:ADQIYCJ2XFA75NHV7UA3SUN7CU.titleDataAttributes.0&quot;:{&quot;key&quot;:&quot;analytics-click-location&quot;,&quot;value&quot;:&quot;OfferTitle&quot;,&quot;__typename&quot;:&quot;DataAttribute&quot;}}}}">
<!--[if IE 9]>
<script type="text/javascript" src="https://www.retailmenot.com/profile/build/vendor-7633f2a64798fdbc2b3b.js"></script>
<script type="text/javascript" src="https://www.retailmenot.com/profile/build/@rmn/member-profile/master-7c83e85759a4bc00be5d.js"></script>
<![endif]-->
</body>

</html>
<?php $__env->startSection('static'); ?>

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
    <!--[if gt IE 9]><!-->
    <script defer type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/common-002fefea931105f014c9.js"></script>
    <script defer type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/store-6984a0d13b7b66166af9.js"></script>
    <!--<![endif]-->
    <script>
        ! function(a) {
            function b(a) {
                var b = document.createEvent("CustomEvent");
                b.initCustomEvent("surl-ad-rendered", !1, !1, a), window.dispatchEvent(b)
            }
            window.addEventListener("message", function(c) {
                if ("https://pubads.g.doubleclick.net" !== c.origin || "RenderedAd" !== c.data.eventType) return !1;
                var d = c.data;
                a.push(d), b(d)
            });
            var c = function() {
                for (var d = 0; d < a.length; d++) b(a[d]);
                window.removeEventListener("drain-surl-ad-listener-queue", c, !1)
            };
            window.addEventListener("drain-surl-ad-listener-queue", c, !1)
        }([]);
    </script>
    <noscript id="deferred-styles">
        <link rel="stylesheet" type="text/css" href="https://www.retailmenot.com/www/gui/build/webpack/design-standards/store-17acb5dc5c22d6ec1cf2080e54f1ed5b.css" />
    </noscript>
    <script>
        var loadDeferredStyles = function() {
            var addStylesNode = document.getElementById("deferred-styles");
            var replacement = document.createElement("div");
            replacement.innerHTML = addStylesNode.textContent;
            document.body.appendChild(replacement)
            addStylesNode.parentElement.removeChild(addStylesNode);
        };
        var raf = requestAnimationFrame || mozRequestAnimationFrame ||
            webkitRequestAnimationFrame || msRequestAnimationFrame;
        if (raf) raf(function() {
            window.setTimeout(loadDeferredStyles, 0);
        });
        else window.addEventListener('load', loadDeferredStyles);
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('main'); ?>

    <main role="main" id="site-main" class="js-site-main">
        <div class="container js-page-container ">
            <div class="grid-fixed-fluid">
                <div class="fixed sidebar show-at-large">
                    <div class="js-merchant-card merchant-card">
                        <a href="/out/S148101" class="merchant-card-logo" target="_blank"><img src="https://www.retailmenot.com/thumbs/logos/l/charlotterusse.com-coupons.jpg?versionId=.pcGmwMw3FQbQ6hd1.bPlKHWTK.90p5E" alt="Charlotte Russe coupons and coupon codes" /></a>
                        <div class="merchant-card-favorite">
                            <button class="favorite-merchant js-favorite-merchant-button " aria-label="Add Favorite" data-siteid="148101" data-merchant-uuid="KEWTLR3TNZGTROSIDWHX7HI4AI" data-merchant-name="charlotterusse.com">
                                <svg class="icon icon-heart-outline">
                                    <use xlink:href="#icon-heart-outline"></use>
                                </svg> <span class="favorite-merchant-link js-favorite-merchant-link">Add Favorite</span></button>
                        </div>
                    </div>
                    <div class="js-filters">
                        <div class="facet-rail">
                            <div class="js-facet-section facet-section facet-section--counter">
                                <div class="facet-results-count"><span class="js-offer-count offer-count">39</span> Offers Available</div>
                                <div class="js-filter-applied filter-applied hidden">
                                    <div class="filter-applied-container"><span class="js-filter-applied-count">0 Filters</span> Applied</div><a class="reset-filter js-clear-filter">Reset All</a></div>
                            </div>
                            <div class="js-facet-section facet-section facet-section--toggles" data-type="exclusive">
                                <div class="facet-list-container">
                                    <ul class="js-list-overflow-scroll list-overflow-scroll js-facet-list facet-list">
                                        <li class="js-facet-filter facet " data-filter="exclusive" data-active="0" data-type="exclusive" data-title="Only at RetailMeNot">
                                            <input class="input-toggle " id="exclusiveexclusive" type="checkbox" name="exclusive[]" value="exclusive" data-filter-by="exclusive" />
                                            <label class="input-toggle-label js-facet-label" for="exclusiveexclusive">Only at RetailMeNot</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="js-facet-section-icon facet-section-icon hide-at-large">
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="js-facet-section facet-section facet-section--toggles" data-type="verified">
                                <div class="facet-list-container">
                                    <ul class="js-list-overflow-scroll list-overflow-scroll js-facet-list facet-list">
                                        <li class="js-facet-filter facet " data-filter="verified" data-active="0" data-type="verified" data-title="RetailMeNot Verified">
                                            <input class="input-toggle " id="verifiedverified" type="checkbox" name="verified[]" value="verified" data-filter-by="verified" />
                                            <label class="input-toggle-label js-facet-label" for="verifiedverified">RetailMeNot Verified</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="js-facet-section-icon facet-section-icon hide-at-large">
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="js-facet-section facet-section facet-section--checkboxes" data-type="couponType">
                                <div class="h6 js-facet-section-title facet-section-title">Coupon Type</div>
                                <div class="facet-list-container">
                                    <ul class="js-list-overflow-scroll list-overflow-scroll js-facet-list facet-list">
                                        <li class="js-facet-filter facet " data-filter="code" data-active="0" data-type="code" data-title="Coupon Codes">
                                            <input class="input-checkbox " id="codecode" type="checkbox" name="code[]" value="code" data-filter-by="code" />
                                            <label class="input-checkbox-label js-facet-label" for="codecode">Coupon Codes</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="sale" data-active="0" data-type="sale" data-title="Online Sales">
                                            <input class="input-checkbox " id="salesale" type="checkbox" name="sale[]" value="sale" data-filter-by="sale" />
                                            <label class="input-checkbox-label js-facet-label" for="salesale">Online Sales</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="printable" data-active="0" data-type="printable" data-title="In-Store Coupons">
                                            <input class="input-checkbox " id="printableprintable" type="checkbox" name="printable[]" value="printable" data-filter-by="printable" />
                                            <label class="input-checkbox-label js-facet-label" for="printableprintable">In-Store Coupons</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="js-facet-section-icon facet-section-icon hide-at-large">
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="js-facet-section facet-section facet-section--radios" data-type="channel">
                                <div class="h6 js-facet-section-title facet-section-title">Purchase Location</div>
                                <div class="facet-list-container">
                                    <ul class="js-list-overflow-scroll list-overflow-scroll js-facet-list facet-list">
                                        <li class="js-facet-filter facet " data-filter="All" data-active="1" data-type="All" data-title="All Offers">
                                            <input class="input-radio " id="AllAll" type="radio" name="channel" value="All" checked="checked" data-filter-by="All" data-is-default="1" />
                                            <label class="input-radio-label js-facet-label" for="AllAll">All Offers</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="In-Store" data-active="0" data-type="In-Store" data-title="In-Store">
                                            <input class="input-radio " id="In-StoreIn-Store" type="radio" name="channel" value="In-Store" data-filter-by="In-Store" />
                                            <label class="input-radio-label js-facet-label" for="In-StoreIn-Store">In-Store</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="Online" data-active="0" data-type="Online" data-title="Online">
                                            <input class="input-radio " id="OnlineOnline" type="radio" name="channel" value="Online" data-filter-by="Online" />
                                            <label class="input-radio-label js-facet-label" for="OnlineOnline">Online</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="js-facet-section-icon facet-section-icon hide-at-large">
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="js-facet-section facet-section facet-section--checkboxes" data-type="discountType">
                                <div class="h6 js-facet-section-title facet-section-title">Discount Type</div>
                                <div class="facet-list-container">
                                    <ul class="js-list-overflow-scroll list-overflow-scroll js-facet-list facet-list">
                                        <li class="js-facet-filter facet " data-filter="bogo" data-active="0" data-type="bogo" data-title="Buy One Get One">
                                            <input class="input-checkbox " id="bogobogo" type="checkbox" name="bogo[]" value="bogo" data-filter-by="bogo" />
                                            <label class="input-checkbox-label js-facet-label" for="bogobogo">Buy One Get One</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="freeShipping" data-active="0" data-type="freeShipping" data-title="Free Shipping">
                                            <input class="input-checkbox " id="freeShippingfreeShipping" type="checkbox" name="freeShipping[]" value="freeShipping" data-filter-by="freeShipping" />
                                            <label class="input-checkbox-label js-facet-label" for="freeShippingfreeShipping">Free Shipping</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="dollarOff" data-active="0" data-type="dollarOff" data-title="$ Off">
                                            <input class="input-checkbox " id="dollarOffdollarOff" type="checkbox" name="dollarOff[]" value="dollarOff" data-filter-by="dollarOff" />
                                            <label class="input-checkbox-label js-facet-label" for="dollarOffdollarOff">$ Off</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="percentOff" data-active="0" data-type="percentOff" data-title="% Off">
                                            <input class="input-checkbox " id="percentOffpercentOff" type="checkbox" name="percentOff[]" value="percentOff" data-filter-by="percentOff" />
                                            <label class="input-checkbox-label js-facet-label" for="percentOffpercentOff">% Off</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="other" data-active="0" data-type="other" data-title="Other">
                                            <input class="input-checkbox " id="otherother" type="checkbox" name="other[]" value="other" data-filter-by="other" />
                                            <label class="input-checkbox-label js-facet-label" for="otherother">Other</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="js-facet-section-icon facet-section-icon hide-at-large">
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="js-facet-section facet-section facet-section--checkboxes" data-type="category">
                                <div class="h6 js-facet-section-title facet-section-title">Category</div>
                                <div class="facet-list-container">
                                    <ul class="js-list-overflow-scroll list-overflow-scroll js-facet-list facet-list">
                                        <li class="js-facet-filter facet " data-filter="Clothing &amp; Accessories" data-active="0" data-type="Clothing &amp; Accessories" data-title="Clothing &amp; Accessories">
                                            <input class="input-checkbox " id="Clothing &amp; AccessoriesClothing &amp; Accessories" type="checkbox" name="Clothing &amp; Accessories[]" value="Clothing &amp; Accessories" data-filter-by="Clothing &amp; Accessories" />
                                            <label class="input-checkbox-label js-facet-label" for="Clothing &amp; AccessoriesClothing &amp; Accessories">Clothing &amp; Accessories</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="Shoes" data-active="0" data-type="Shoes" data-title="Shoes">
                                            <input class="input-checkbox " id="ShoesShoes" type="checkbox" name="Shoes[]" value="Shoes" data-filter-by="Shoes" />
                                            <label class="input-checkbox-label js-facet-label" for="ShoesShoes">Shoes</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="MultiCategory" data-active="0" data-type="MultiCategory" data-title="MultiCategory">
                                            <input class="input-checkbox " id="MultiCategoryMultiCategory" type="checkbox" name="MultiCategory[]" value="MultiCategory" data-filter-by="MultiCategory" />
                                            <label class="input-checkbox-label js-facet-label" for="MultiCategoryMultiCategory">MultiCategory</label>
                                        </li>
                                        <li class="js-facet-filter facet " data-filter="Health" data-active="0" data-type="Health" data-title="Health">
                                            <input class="input-checkbox " id="HealthHealth" type="checkbox" name="Health[]" value="Health" data-filter-by="Health" />
                                            <label class="input-checkbox-label js-facet-label" for="HealthHealth">Health</label>
                                        </li>
                                    </ul>
                                </div>
                                <div class="js-facet-section-icon facet-section-icon hide-at-large">
                                    <svg class="icon icon-arrow-down">
                                        <use xlink:href="#icon-arrow-down"></use>
                                    </svg>
                                </div>
                            </div>
                            <input type="hidden" name="page" value="" />
                        </div>
                    </div>
                    <div class="about-merchant" itemscope itemtype="http://schema.org/Product">
                        <meta itemprop="name" content="Charlotte Russe">
                        <div class="about-section">
                            <h3 class="h6 about-section-title merchant-name"> About Charlotte Russe </h3>
                            <div class="about-merchant-description"> A mall-based retailer of pumps, denim pants, swimwear and belts, Charlotte Russe runs more than 500 stores in the United States and Puerto Rico. Signature labels such as Blu Chic and Refuge give this company an edge over others. Charlotte Russe is known for the quality of its shoes with customer reviews saying the quality is great. </div>
                        </div>
                        <div class="about-section">
                            <div class="about-section-title"> Today's Charlotte Russe Top Offers:</div>
                            <ul class="about-merchant-extra list-basic">
                                <li class="">$20 Off Orders $90+</li>
                                <li class="">Today Only! 30% Off Sitewide </li>
                            </ul>
                            <table class="about-merchant-stats">
                                <tbody>
                                <tr>
                                    <td> Total Offers </td>
                                    <td class="about-merchant-data"> 39 </td>
                                </tr>
                                <tr>
                                    <td> Coupon Codes </td>
                                    <td class="about-merchant-data"> 3 </td>
                                </tr>
                                <tr>
                                    <td> Free Shipping Deals </td>
                                    <td class="about-merchant-data"> 6 </td>
                                </tr>
                                <tr>
                                    <td> Best Discount </td>
                                    <td class="about-merchant-data"> $20 off </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="about-merchant-extra"> <a href="/out/S148101" title="Shop charlotterusse.com" rel="nofollow" target="_blank"> Shop charlotterusse.com </a> </div>
                    </div>
                    <div class="js-dfp-banner-container dfp-banner-container">
                        <div id="dfp-banner-in-sidebar-id" class="dfp-banner-in-sidebar" style="display: none;" data-iframe-class="dfp-banner-in-sidebar-iframe"></div>
                    </div>
                </div>
                <div class="fluid js-all-offers">
                    <div class="page-header-padding">
                        <div class="merchant-header js-store-header">
                            <div class="merchant-logo-wrapper">
                                <a href="/out/S148101" target="_blank" class="merchant-logo js-merchant-logo"><img src="https://www.retailmenot.com/thumbs/logos/l/charlotterusse.com-coupons.jpg?versionId=.pcGmwMw3FQbQ6hd1.bPlKHWTK.90p5E" alt="Charlotte Russe coupons and coupon codes" /></a>
                            </div>
                            <div class="merchant-info">
                                <h1 class="h4 merchant-name"><?php echo e(\App\Store::findOrFail($id)->name); ?> Coupon Codes</h1>

                                <!-- <div class="merchant-actions">
                                    <div class="offer-sorting">
                                        <div class="sort-by-block sort-by-text">Sort By:</div>
                                        <div class="sort-button-text sort-by-block sort-toggle js-sort-button sort-toggle-active" data-sort-type="popular">Popularity</div>
                                        <div class="sort-button-text sort-by-block sort-toggle js-sort-button " data-sort-type="newest">Newest</div>
                                        <div class="sort-button-text sort-by-block sort-toggle js-sort-button " data-sort-type="expiration">Ending Soon</div>
                                    </div>
                                    <div class="favorite-merchant-wrapper">
                                        <button class="favorite-merchant js-favorite-merchant-button " aria-label="Add Favorite" data-siteid="148101" data-merchant-uuid="KEWTLR3TNZGTROSIDWHX7HI4AI" data-merchant-name="charlotterusse.com">
                                            <svg class="icon icon-heart-outline">
                                                <use xlink:href="#icon-heart-outline"></use>
                                            </svg> <span class="favorite-merchant-link js-favorite-merchant-link">Add Favorite</span></button>
                                    </div>
                                    <div class="submit-form-launcher-wrapper">
                                        <a class="submit-form-launcher" aria-label="Submit a Coupon" data-toggle-for="js-submit-coupon" data-toggle-class="hidden">
                                            <svg class="icon icon-tag-add">
                                                <use xlink:href="#icon-tag-add"></use>
                                            </svg>Submit a Coupon</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="js-store-submit-form store-submit-form hidden" data-toggle-class="hidden">
                        <h3 class="h5 store-submit-title">Submit a new coupon and help others save!</h3>
                        <button type="button" class="store-submit-close button-text" data-toggle-for="js-submit-coupon" data-toggle-class="hidden">
                            <svg class="icon icon-close">
                                <use xlink:href="#icon-close"></use>
                            </svg>
                        </button>
                        <div class="js-submit-coupon submit-coupon " data-analytics-origin="TopRight" data-sitekey="6LemcCQTAAAAABsVoXnN0PsSkfUEFRvTqMZGqCLm">
                            <form method="post" action="javascript:void(0);" id="couponSubmit" name="couponsubmit" class="submit-coupon-form js-submit-coupon-form" autocomplete="off" novalidate>
                                <input type="hidden" name="isStorePage" value="false" />
                                <fieldset>
                                    <div class="field-container">
                                        <label for="domain">Store Website</label>
                                        <input type="text" id="domain" class="ui-autocomplete-input domain" autocomplete="off" name="domain" value="charlotterusse.com" placeholder="e.g., storewebsite.com" /> </div>
                                </fieldset>
                                <fieldset>
                                    <div class="field-container submit-offer-type"> <span>Select an Offer Type</span>
                                        <ul class="submit-offer-type--wrapper grid-row col-4">
                                            <li class="submit-offer-type--option grid-unit">
                                                <input type="radio" id="offerTypeRadioCode" class="js-offer-type submit-offer-type--input hidden" name="offerType" value="code" disabled="disabled" />
                                                <label for="offerTypeRadioCode" class="code-button submit-offer-type--selector"> <span class="submit-offer-type--icon"><svg class="icon icon-computer"><use xlink:href="#icon-computer"></use></svg></span> Online Code <span class="submit-offer-type--check"><svg class="icon icon-check-circle"><use xlink:href="#icon-check-circle"></use></svg></span> </label>
                                            </li>
                                            <li class="submit-offer-type--option grid-unit">
                                                <input type="radio" id="offerTypeRadioPrintable" class="js-offer-type submit-offer-type--input hidden" name="offerType" value="printable" disabled="disabled" />
                                                <label for="offerTypeRadioPrintable" class="printable-button submit-offer-type--selector"> <span class="submit-offer-type--icon"><svg class="icon icon-tag"><use xlink:href="#icon-tag"></use></svg></span> In-Store Coupon <span class="submit-offer-type--check"><svg class="icon icon-check-circle"><use xlink:href="#icon-check-circle"></use></svg></span> </label>
                                            </li>
                                            <li class="submit-offer-type--option grid-unit">
                                                <input type="radio" id="offerTypeRadioTip" class="js-offer-type submit-offer-type--input hidden" name="offerType" value="tip" />
                                                <label for="offerTypeRadioTip" class="tip-button submit-offer-type--selector"> <span class="submit-offer-type--icon"><svg class="icon icon-finger"><use xlink:href="#icon-finger"></use></svg></span> Online Sale or Tip <span class="submit-offer-type--check"><svg class="icon icon-check-circle"><use xlink:href="#icon-check-circle"></use></svg></span> </label>
                                            </li>
                                        </ul>
                                    </div>
                                </fieldset>
                                <fieldset class="submit-code js-fieldset-hideable">
                                    <div class="field-container offer-code">
                                        <label for="f_code">Code</label>
                                        <input id="f_code" type="text" class="f_code" name="f_code" placeholder="Code" autocomplete="off" /> </div>
                                    <div class="field-container offer-description">
                                        <label for="f_description">Discount Description</label>
                                        <textarea id="f_description" class="f_description" name="f_description" placeholder="Tell us more about the offer"></textarea>
                                    </div>
                                </fieldset>
                                <fieldset class="submit-tip hidden js-fieldset-hideable">
                                    <div class="field-container offer-description">
                                        <label for="ft_tip">Discount Description</label>
                                        <textarea id="ft_tip" class="ft_tip" name="ft_tip" placeholder="Tell us more about the offer"></textarea>
                                    </div>
                                </fieldset>
                                <fieldset class="submit-printable hidden js-fieldset-hideable">
                                    <div class="field-container offer-link">
                                        <label for="fp_url">Offer Link</label>
                                        <input id="fp_url" type="text" name="fp_url" class="fp_url" maxlength="255" value="" placeholder="Enter link to coupon" /> </div>
                                    <div class="field-container offer-description">
                                        <label for="fp_description">Discount Description</label>
                                        <textarea id="fp_description" class="fp_description" name="fp_description" placeholder="Tell us more about the offer"></textarea>
                                    </div>
                                </fieldset>
                                <fieldset class="js-submit-instoresale hidden js-fieldset-hideable">
                                    <div class="location-expires-wrapper">
                                        <div class="field-container offer-location">
                                            <label for="fs_location">Sale Location</label>
                                            <input id="fs_location" class="js-location" type="text" name="fs_location" maxlength="255" value="" placeholder="Enter a mall, city or zip" /> </div>
                                        <div class="field-container expires-instoresale--container">
                                            <label for="fs_expires">Expiration Date</label>
                                            <div class="expires-input--wrapper">
                                                <input id="fs_expires" type="text" class="js-expires-instoresale" name="fs_expires" placeholder="MM/DD/YYYY" /> </div>
                                        </div>
                                    </div>
                                    <div class="field-container offer-description">
                                        <label for="fs_description">Discount Description</label>
                                        <textarea id="fs_description" class="js-description-instoresale" name="fs_description" placeholder="Tell us more about the offer"></textarea>
                                    </div>
                                    <div class="field-container hidden"> <span>Upload Sales Photo (optional)</span>
                                        <div class="inline-form-elements">
                                            <input type="text" class="js-input-file--text input" readonly="readonly" />
                                            <label for="upload" class="js-input-file--button button button-secondary">Browse</label>
                                            <input id="upload" type="file" class="hidden js-input-file" name="upload" /> </div>
                                    </div>
                                </fieldset>
                                <fieldset class="js-submit-expires-optional js-fieldset-hideable">
                                    <div class="field-container expires-field">
                                        <label for="expires">Expiration Date (optional)</label>
                                        <div class="expires-input--wrapper">
                                            <input id="expires" class="js-expires-optional" type="text" placeholder="MM/DD/YYYY" name="expires" /> <span class="expires-icon js-expires-optional--calendar"><svg class="icon icon-calendar"><use xlink:href="#icon-calendar"></use></svg></span> </div>
                                    </div>
                                </fieldset>
                                <div class="g-recaptcha hidden"></div>
                                <div class="field-container">
                                    <div class="js-form-message form-message submit-form-message panel hidden"> <span class="form-message-icon"><svg class="icon icon-tag-add"><use xlink:href="#icon-tag-add"></use></svg></span>
                                        <div class="js-form-message-content form-message-content"></div>
                                        <button type="button" class="js-form-message--closebutton form-message-close button-text">
                                            <svg class="icon icon-x">
                                                <use xlink:href="#icon-x"></use>
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="submit" value="Submit Offer" class="js-submit button-submit-offer button-primary" /> </div>
                                <p class="submit-notice">Please only submit publicly available coupon codes and not private or internal company codes. When in doubt, please obtain permission from the merchant first. See our <a href="/static/terms/">Terms and Conditions</a> for more information regarding user generated content. Thank you very much!</p>
                            </form>
                        </div>
                    </div>
                    <ul class="offer-list js-offers" data-bucket="top-rated">
                        <?php $__currentLoopData = \App\Coupon::where('store_id', $id)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <li class="js-offer-toggle offer-list-item" data-popular-sorting-position="0" data-newest-sorting-position="6" data-expiration-sorting-position="1">
                            <div class="offer-item js-offer " data-offer-position="1" data-offer-id="9012610" data-offer-uuid="3U6RXRIEEZDQHHCDCINSZB6564" data-merchant-url="/out/S148101" data-offer-type="code" data-type="code" data-out-url="/out/9012610" data-merchant-name="charlotterusse.com" data-site-title="Charlotte Russe" data-site-id="148101" data-site-uuid="KEWTLR3TNZGTROSIDWHX7HI4AI" data-couponscore="67" data-couponrank="1" data-comment-count="3" data-has-submitter="false" data-analytics-click-location="offer body" data-printable-image-path="" data-main-tab="/out/9012610" data-new-tab="/view/charlotterusse.com?c&#x3D;9012610" data-owen-parent-inventory-uuid="top rated" data-owen-inventory-type="code" data-sitekey="6LemcCQTAAAAABsVoXnN0PsSkfUEFRvTqMZGqCLm">
                                <div class="offer-item-content">
                                    <?php if($item->type == 'Off $'): ?>
                                    <div class="offer-anchor offer-type-code offer-anchor-dollar-off">
                                        <span class="offer-anchor-text offer-anchor-text-line0 ">$<?php echo e($item->value); ?></span>
                                        <span class="offer-anchor-text offer-anchor-text-line1 ">OFF</span>
                                    </div>
                                    <?php elseif($item->type == 'Off %'): ?>
                                        <div class="offer-anchor offer-type-code offer-anchor-dollar-off">
                                            <span class="offer-anchor-text offer-anchor-text-line0 ">%<?php echo e($item->value); ?></span>
                                            <span class="offer-anchor-text offer-anchor-text-line1 ">OFF</span>
                                        </div>
                                    <?php elseif($item->type == 'Freeship'): ?>
                                        <div class="offer-anchor offer-type-sale offer-anchor-free-shipping">
                                            <span class="offer-anchor-text offer-anchor-text-line0 ">FREE</span>
                                            <span class="offer-anchor-text offer-anchor-text-line1 ">SHIPPING</span>
                                        </div>
                                    <?php elseif($item->type == 'BOGO'): ?>
                                        <div class="offer-anchor offer-type-code offer-anchor-dollar-off">
                                            <span class="offer-anchor-text offer-anchor-text-line0 ">BO</span>
                                            <span class="offer-anchor-text offer-anchor-text-line1 ">GO</span>
                                        </div>
                                    <?php endif; ?>



                                    <div class="offer-item-main">
                                        <div class="offer-item-head">
                                            <div class="offer-item-label has-separator-dot offer-type-code">Code</div>
                                            <div class="js-save-offer save-offer ">
                                                <svg class="icon icon-star-outline">
                                                    <use xlink:href="#icon-star-outline"></use>
                                                </svg><span class="save-offer-copy js-save-offer-copy">Save</span></div>
                                        </div>
                                        <div class="offer-item-body">
                                            <div class="offer-item-body-content">
                                                <div class="offer-item-title"><a href="/out/9012610" class="offer-item-title-link js-triggers-outclick" data-analytics-click-location="OfferTitle"><?php echo e($item->description); ?></a></div>
                                                <div class="offer-item-info">
                                                    <div class="offer-meta offer-meta-verified has-separator-dot"><?php echo e($item->exp_date); ?></div>
                                                    <div class="offer-meta offer-meta-usage has-separator-dot">221 uses today</div>
                                                </div>
                                            </div>
                                            <div class="offer-item-actions"><a href="" class="	button-show-code	offer-button	js-triggers-outclick	" data-analytics-click-location="OfferCode" data-revealed-code="UG" data-main-tab="/out/9012610" data-new-tab="/view/charlotterusse.com?c&#x3D;9012610">Show Coupon Code</a></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="js-offer-item-details offer-item-details ">
                                    <div class="offer-item-details-bar"><a class="js-offer-item-details-link offer-item-details-link" data-event-target="details content">See Details<svg class="icon icon-arrow-down"><use xlink:href="#icon-arrow-down"></use></svg></a>
                                        <div class="offer-item-details-voting">
                                            <button class="button-vote-yes js-vote-up">
                                                <svg class="icon icon-thumbs-up">
                                                    <use xlink:href="#icon-thumbs-up"></use>
                                                </svg>
                                            </button>
                                            <button class="button-vote-no js-vote-down">
                                                <svg class="icon icon-thumbs-down">
                                                    <use xlink:href="#icon-thumbs-down"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="js-offer-item-tabs offer-item-tabs hidden">
                                        <div class="offer-item-tabs-header">
                                            <ul class="offer-item-tabs-header-list">
                                                <li class="js-tabs-header-item offer-item-tabs-header-item " data-tab-key="0" data-tab-id="tab-9012610-details"><a class="js-tabs-header-item-link offer-item-tabs-header-item-link " data-prompt-name="offer details">Details</a></li>
                                                <li class="js-tabs-header-item offer-item-tabs-header-item js-comments-tab" data-tab-key="1" data-tab-id="tab-9012610-comments"><a class="js-tabs-header-item-link offer-item-tabs-header-item-link js-comment-count" data-prompt-name="add a comment">3 Comments</a></li>
                                            </ul>
                                            <div class="js-offer-item-tabs-active-indicator offer-item-tabs-active-indicator" data-persist-css="transform"></div>
                                        </div>
                                        <div class="offer-item-tabs-content">
                                            <div id="tab-9012610-details" class="offer-item-tabs-content-item js-tabs-content-item offer-item-tabs-content-details" data-tab-key="0">
                                                <p><strong>Expires:</strong><?php echo e($item->exp_date); ?></p>
                                                <p><strong>Details:</strong><?php echo e($item->description); ?></p>
                                            </div>
                                            <div id="tab-9012610-comments" class="offer-item-tabs-content-item js-tabs-content-item offer-item-tabs-content-feedback" data-tab-key="1">
                                                <div class="comments js-comments">
                                                    <div class="comment-form js-comment-form-wrapper hidden">
                                                        <form class="js-comment-form" action="/ajax/comment.php" method="POST">
                                                            <fieldset>
                                                                <div class="field-container">
                                                                    <textarea name="f_description" required placeholder="Add a comment..." class="js-show-more-fields js-comment-form-field"></textarea>
                                                                </div>
                                                                <input type="hidden" name="couponId" value=9012610 />
                                                            </fieldset>
                                                            <fieldset>
                                                                <label class="comment-location">
                                                                    <input class="loc-cb" name="f_incl_location" type="checkbox" checked/> Include <span class="discovered-loc js-loc-dest">nearby city</span> with my comment to help other users.</label>
                                                                <input type="hidden" name="f_location" class="js-loc-dest" value="" />
                                                            </fieldset>
                                                            <fieldset class="user-dependent js-more-form" style="display:none;">
                                                                <div class="captchaBlock">
                                                                    <div class="g-recaptcha"></div>
                                                                </div>
                                                                <p class="comment-author">Post as <strong><span class="js-user-dest"></span></strong></p>
                                                                <button type="submit" class="button button-primary has-spinner js-submit-comment">Post Comment<span class="spinner js-spinner"></span></button>
                                                            </fieldset>
                                                        </form>
                                                        <div class="comment-posted js-sent-notification hidden">
                                                            <div class="comment-posted-success">
                                                                <svg class="icon icon-checkbox">
                                                                    <use xlink:href="#icon-checkbox"></use>
                                                                </svg><span>Comment Posted</span></div>
                                                            <button class="button-primary js-add-another-comment">Post Another Comment</button>
                                                        </div>
                                                    </div>
                                                    <div class="comment-list js-comment-list">
                                                        <div class="comment">
                                                            <p class="text">Saved $20.00 on various (08/09/2017)</p>
                                                            <div class="comment-details"> &nbsp;by Anonymous </div>
                                                        </div>
                                                        <div class="comment">
                                                            <p class="text">Saved $20.00 on clothes (08/07/2017)</p>
                                                            <div class="comment-details"> &nbsp;by Anonymous </div>
                                                        </div>
                                                        <div class="comment">
                                                            <p class="text">Saved $20.00 on clothing (08/05/2017)</p>
                                                            <div class="comment-details"> &nbsp;by Anonymous </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </ul>

                </div>
            </div>
            <div class="store-footer">
                <nav class="breadcrumbs js-taxonomy"> <a href="/">Home</a> &rsaquo; <a href="/coupons/clothing">Clothing</a> &rsaquo; Charlotte Russe</nav>
                <div class="merchant-links-container">
                    <div class="recommended-merchants-container">
                        <div class="h6 merchant-group-title">People also&nbsp;viewed</div>
                        <ul class="list list-links list-multicol">
                            <li class=""> <a href="/view/forever21.com" title="Forever 21" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="forever21.com">Forever 21</a> </li>
                            <li class=""> <a href="/view/wetseal.com" title="Wet Seal" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="wetseal.com">Wet Seal</a> </li>
                            <li class=""> <a href="/view/victoriassecret.com" title="Victoria&#x27;s Secret" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="victoriassecret.com">Victoria's Secret</a> </li>
                            <li class=""> <a href="/view/gojane.com" title="GoJane" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="gojane.com">GoJane</a> </li>
                            <li class=""> <a href="/view/ae.com" title="American Eagle Outfitters" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="ae.com">American Eagle Outfitters</a> </li>
                            <li class=""> <a href="/view/hollisterco.com" title="Hollister" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="hollisterco.com">Hollister</a> </li>
                            <li class=""> <a href="/view/aeropostale.com" title="Aeropostale" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="aeropostale.com">Aeropostale</a> </li>
                            <li class=""> <a href="/view/pacsun.com" title="PacSun" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="pacsun.com">PacSun</a> </li>
                            <li class=""> <a href="/view/papayaclothing.com" title="Papaya Clothing" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="papayaclothing.com">Papaya Clothing</a> </li>
                            <li class=""> <a href="/view/express.com" title="Express" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="express.com">Express</a> </li>
                        </ul>
                    </div>
                    <div class="list-overflow is-js-hidden js-list-overflow related-merchants-container">
                        <div class="h6">Coupons for similar stores</div>
                        <ul class="list list-multicol list-links list-overflow">
                            <li class=""> <a href="/view/karmaloop.com" title="Karmaloop Promo Codes" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="karmaloop.com">Karmaloop Promo Codes</a> </li>
                            <li class=""> <a href="/view/bonton.com" title="Bon Ton Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="bonton.com">Bon Ton Coupons</a> </li>
                            <li class=""> <a href="/view/younkers.com" title="Younkers Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="younkers.com">Younkers Coupons</a> </li>
                            <li class=""> <a href="/view/bergners.com" title="Bergners Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="bergners.com">Bergners Coupons</a> </li>
                            <li class=""> <a href="/view/carsons.com" title="Carson&#x27;s Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="carsons.com">Carson's Coupons</a> </li>
                            <li class=""> <a href="/view/herbergers.com" title="Herberger&#x27;s Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="herbergers.com">Herberger's Coupons</a> </li>
                            <li class=""> <a href="/view/bostonstore.com" title="Boston Store Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="bostonstore.com">Boston Store Coupons</a> </li>
                            <li class=""> <a href="/view/elder-beerman.com" title="Elder Beerman Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="elder-beerman.com">Elder Beerman Coupons</a> </li>
                            <li class=""> <a href="/view/express.com" title="Express Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="express.com">Express Coupons</a> </li>
                            <li class=""> <a href="/view/bluefly.com" title="Bluefly Coupon Codes" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="bluefly.com">Bluefly Coupon Codes</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/revolveclothing.com" title="REVOLVE Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="revolveclothing.com">REVOLVE Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/6pm.com" title="6PM Coupon Codes" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="6pm.com">6PM Coupon Codes</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/aeropostale.com" title="Aeropostale Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="aeropostale.com">Aeropostale Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/sammydress.com" title="SammyDress Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="sammydress.com">SammyDress Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/hottopic.com" title="Hot Topic Promo Codes" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="hottopic.com">Hot Topic Promo Codes</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/amazon.com" title="Amazon Promo Codes" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="amazon.com">Amazon Promo Codes</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/kohls.com" title="Kohl&#x27;s Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="kohls.com">Kohl's Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/macys.com" title="Macy&#x27;s Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="macys.com">Macy's Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/sierratradingpost.com" title="Sierra Trading Post Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="sierratradingpost.com">Sierra Trading Post Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/jcpenney.com" title="JCPenney Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="jcpenney.com">JCPenney Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/sears.com" title="Sears Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="sears.com">Sears Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/overstock.com" title="Overstock Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="overstock.com">Overstock Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/target.com" title="Target Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="target.com">Target Coupons</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/thebay.com" title="Hudson&#x27;s Bay Promo Codes" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="thebay.com">Hudson's Bay Promo Codes</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/kmart.com" title="Kmart Coupons" data-track-action="click" data-track-category="RecommendedMerchants" data-track-label="kmart.com">Kmart Coupons</a> </li>
                        </ul> <a class="show-all js-show-all" href="1">Show all 25</a></div>
                    <div class="list-overflow is-js-hidden js-list-overflow popular-merchants-container">
                        <div class="h6 merchant-group-title">Coupons for popular stores</div>
                        <ul class="list list-multicol list-links list-overflow">
                            <li class=""> <a href="/view/papajohns.com" title="Papa John&#x27;s">Papa John's</a> </li>
                            <li class=""> <a href="/view/bedbathandbeyond.com" title="Bed Bath And Beyond">Bed Bath And Beyond</a> </li>
                            <li class=""> <a href="/view/bathandbodyworks.com" title="Bath &amp;amp; Body Works">Bath &amp; Body Works</a> </li>
                            <li class=""> <a href="/view/oldnavy.com" title="Old Navy">Old Navy</a> </li>
                            <li class=""> <a href="/view/ubereats.com" title="UberEATS">UberEATS</a> </li>
                            <li class=""> <a href="/view/walgreens.com" title="Walgreens">Walgreens</a> </li>
                            <li class=""> <a href="/view/dickssportinggoods.com" title="Dicks Sporting Goods">Dicks Sporting Goods</a> </li>
                            <li class=""> <a href="/view/walmart.com" title="Walmart">Walmart</a> </li>
                            <li class=""> <a href="/view/footlocker.com" title="Foot Locker">Foot Locker</a> </li>
                            <li class=""> <a href="/view/michaels.com" title="Michaels">Michaels</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/dominos.com" title="Domino&#x27;s">Domino's</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/payless.com" title="Payless ShoeSource">Payless ShoeSource</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/bestbuy.com" title="Best Buy">Best Buy</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/pizzahut.com" title="Pizza Hut">Pizza Hut</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/joann.com" title="Jo-Ann">Jo-Ann</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/famousfootwear.com" title="Famous Footwear">Famous Footwear</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/grubhub.com" title="GrubHub">GrubHub</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/officedepot.com" title="Office Depot &amp;amp; OfficeMax">Office Depot &amp; OfficeMax</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/sephora.com" title="Sephora">Sephora</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/ulta.com" title="Ulta">Ulta</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/finishline.com" title="Finish Line">Finish Line</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/dunkindonuts.com" title="Dunkin Donuts">Dunkin Donuts</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/nike.com" title="Nike">Nike</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/doordash.com" title="DoorDash">DoorDash</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/rubytuesday.com" title="Ruby Tuesday">Ruby Tuesday</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/fashionnova.com" title="Fashion Nova">Fashion Nova</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/shoecarnival.com" title="Shoe Carnival">Shoe Carnival</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/budget.com" title="Budget Rent A Car">Budget Rent A Car</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/carters.com" title="Carter&#x27;s">Carter's</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/barnesandnoble.com" title="Barnes &amp;amp; Noble">Barnes &amp; Noble</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/buybuybaby.com" title="Buybuy BABY">Buybuy BABY</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/hobbylobby.com" title="Hobby Lobby">Hobby Lobby</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/advanceautoparts.com" title="Advance Auto Parts">Advance Auto Parts</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/shutterfly.com" title="Shutterfly">Shutterfly</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/homedepot.com" title="Home Depot">Home Depot</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/airbnb.com" title="Airbnb">Airbnb</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/vistaprint.com" title="Vistaprint">Vistaprint</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/uber.com" title="Uber">Uber</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/maurices.com" title="Maurices">Maurices</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/gapoutlet.com" title="Gap Factory Outlet">Gap Factory Outlet</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/dominos.com.au" title="Domino&#x27;s Australia">Domino's Australia</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/olivegarden.com" title="Olive Garden">Olive Garden</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/staples.com" title="Staples">Staples</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/babiesrus.com" title="Babies R Us">Babies R Us</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/redbox.com" title="Redbox">Redbox</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/hotels.com" title="Hotels.com">Hotels.com</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/avis.com" title="Avis">Avis</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/big5sportinggoods.com" title="Big 5 Sports">Big 5 Sports</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/academy.com" title="Academy Sports + Outdoors">Academy Sports + Outdoors</a> </li>
                            <li class="js-toggle-hidden hidden"> <a href="/view/longhornsteakhouse.com" title="Longhorn Steakhouse">Longhorn Steakhouse</a> </li>
                        </ul> <a class="show-all js-show-all" href="1">Show all 50</a></div>
                </div>
                <script type="application/ld+json">
                            [{"@context":"http:\/\/schema.org","@type":"SaleEvent","url":"https:\/\/www.retailmenot.com\/view\/charlotterusse.com","image":"https:\/\/www.retailmenot.com\/thumbs\/logos\/l\/charlotterusse.com-coupons.jpg?versionId=.pcGmwMw3FQbQ6hd1.bPlKHWTK.90p5E","location":{"@type":"Place","name":"Charlotte Russe","url":"charlotterusse.com","address":"Charlotte Russe"},"eventStatus":"EventScheduled","startDate":"2017-07-30","endDate":"2017-08-26","name":"$20 Off Orders $90+","description":"Get $20 off orders $90+ "},{"@context":"http:\/\/schema.org","@type":"SaleEvent","url":"https:\/\/www.retailmenot.com\/view\/charlotterusse.com","image":"https:\/\/www.retailmenot.com\/thumbs\/logos\/l\/charlotterusse.com-coupons.jpg?versionId=.pcGmwMw3FQbQ6hd1.bPlKHWTK.90p5E","location":{"@type":"Place","name":"Charlotte Russe","url":"charlotterusse.com","address":"Charlotte Russe"},"eventStatus":"EventScheduled","startDate":"2017-08-14","endDate":"2017-08-14","name":"Today Only! 30% Off Sitewide ","description":"Get 30% off sitewide"},{"@context":"http:\/\/schema.org","@type":"SaleEvent","url":"https:\/\/www.retailmenot.com\/view\/charlotterusse.com","image":"https:\/\/www.retailmenot.com\/thumbs\/logos\/l\/charlotterusse.com-coupons.jpg?versionId=.pcGmwMw3FQbQ6hd1.bPlKHWTK.90p5E","location":{"@type":"Place","name":"Charlotte Russe","url":"charlotterusse.com","address":"Charlotte Russe"},"eventStatus":"EventScheduled","startDate":"2016-02-09","endDate":"2017-12-31","name":"New Customers Only! 20% Off Online With E-mail Sign Up","description":"Take 20% Off your online order with email sign up. New subscribers only."}]
                        </script>
            </div>
        </div>


    </main>

    <!--[if lte IE 9]>
    <script type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/common-002fefea931105f014c9.js" ></script>
    <script type="text/javascript" src="https://www.retailmenot.com/www/gui/build/webpack/design-standards/homepage-ef6a4ddbe3a95e308930.js" ></script>
    <![endif]-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
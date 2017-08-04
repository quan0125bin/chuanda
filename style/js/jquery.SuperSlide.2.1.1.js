/*!
 * SuperSlide v2.1.1 
 * 轻松解决网站大部分特效展示问题
 * 详尽信息请看官网：http://www.SuperSlide2.com/
 *
 * Copyright 2011-2013, 大话主席
 *
 * 请尊重原创，保留头部版权
 * 在保留版权的前提下可应用于个人或商业用途

 * v2.1.1：修复当调用多个SuperSlide，并设置returnDefault:true 时返回defaultIndex索引错误

 */

!function (a) {
    a.fn.slide = function (b) {
        return a.fn.slide.defaults = {
            type: "slide",
            effect: "fade",
            autoPlay: !1,
            delayTime: 500,
            interTime: 2500,
            triggerTime: 150,
            defaultIndex: 0,
            titCell: ".hd li",
            mainCell: ".bd",
            targetCell: null,
            trigger: "mouseover",
            scroll: 1,
            vis: 1,
            titOnClassName: "on",
            autoPage: !1,
            prevCell: ".prev",
            nextCell: ".next",
            pageStateCell: ".pageState",
            opp: !1,
            pnLoop: !0,
            easing: "swing",
            startFun: null,
            endFun: null,
            switchLoad: null,
            playStateCell: ".playState",
            mouseOverStop: !0,
            defaultPlay: !0,
            returnDefault: !1
        }, this.each(function () {
            var c = a.extend({}, a.fn.slide.defaults, b), d = a(this), e = c.effect, f = a(c.prevCell, d), g = a(c.nextCell, d), h = a(c.pageStateCell, d), i = a(c.playStateCell, d), j = a(c.titCell, d), k = j.size(), l = a(c.mainCell, d), m = l.children().size(), n = c.switchLoad, o = a(c.targetCell, d), p = parseInt(c.defaultIndex), q = parseInt(c.delayTime), r = parseInt(c.interTime);
            parseInt(c.triggerTime);
            var Q, t = parseInt(c.scroll), u = parseInt(c.vis), v = "false" == c.autoPlay || 0 == c.autoPlay ? !1 : !0, w = "false" == c.opp || 0 == c.opp ? !1 : !0, x = "false" == c.autoPage || 0 == c.autoPage ? !1 : !0, y = "false" == c.pnLoop || 0 == c.pnLoop ? !1 : !0, z = "false" == c.mouseOverStop || 0 == c.mouseOverStop ? !1 : !0, A = "false" == c.defaultPlay || 0 == c.defaultPlay ? !1 : !0, B = "false" == c.returnDefault || 0 == c.returnDefault ? !1 : !0, C = 0, D = 0, E = 0, F = 0, G = c.easing, H = null, I = null, J = null, K = c.titOnClassName, L = j.index(d.find("." + K)), M = p = -1 == L ? p : L, N = p, O = p, P = m >= u ? 0 != m % t ? m % t : t : 0, R = "leftMarquee" == e || "topMarquee" == e ? !0 : !1, S = function () {
                a.isFunction(c.startFun) && c.startFun(p, k, d, a(c.titCell, d), l, o, f, g)
            }, T = function () {
                a.isFunction(c.endFun) && c.endFun(p, k, d, a(c.titCell, d), l, o, f, g)
            }, U = function () {
                j.removeClass(K), A && j.eq(N).addClass(K)
            };
            if ("menu" == c.type)return A && j.removeClass(K).eq(p).addClass(K), j.hover(function () {
                Q = a(this).find(c.targetCell);
                var b = j.index(a(this));
                I = setTimeout(function () {
                    switch (p = b, j.removeClass(K).eq(p).addClass(K), S(), e) {
                        case"fade":
                            Q.stop(!0, !0).animate({opacity: "show"}, q, G, T);
                            break;
                        case"slideDown":
                            Q.stop(!0, !0).animate({height: "show"}, q, G, T)
                    }
                }, c.triggerTime)
            }, function () {
                switch (clearTimeout(I), e) {
                    case"fade":
                        Q.animate({opacity: "hide"}, q, G);
                        break;
                    case"slideDown":
                        Q.animate({height: "hide"}, q, G)
                }
            }), B && d.hover(function () {
                clearTimeout(J)
            }, function () {
                J = setTimeout(U, q)
            }), void 0;
            if (0 == k && (k = m), R && (k = 2), x) {
                if (m >= u)if ("leftLoop" == e || "topLoop" == e)k = 0 != m % t ? (0 ^ m / t) + 1 : m / t; else {
                    var V = m - u;
                    k = 1 + parseInt(0 != V % t ? V / t + 1 : V / t), 0 >= k && (k = 1)
                } else k = 1;
                j.html("");
                var W = "";
                if (1 == c.autoPage || "true" == c.autoPage)for (var X = 0; k > X; X++)W += "<li>" + (X + 1) + "</li>"; else for (var X = 0; k > X; X++)W += c.autoPage.replace("$", X + 1);
                j.html(W);
                var j = j.children()
            }
            if (m >= u) {
                l.children().each(function () {
                    a(this).width() > E && (E = a(this).width(), D = a(this).outerWidth(!0)), a(this).height() > F && (F = a(this).height(), C = a(this).outerHeight(!0))
                });
                var Y = l.children(), Z = function () {
                    for (var a = 0; u > a; a++)Y.eq(a).clone().addClass("clone").appendTo(l);
                    for (var a = 0; P > a; a++)Y.eq(m - a - 1).clone().addClass("clone").prependTo(l)
                };
                switch (e) {
                    case"fold":
                        l.css({position: "relative", width: D, height: C}).children().css({
                            position: "absolute",
                            width: E,
                            left: 0,
                            top: 0,
                            display: "none"
                        });
                        break;
                    case"top":
                        l.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:' + u * C + 'px"></div>').css({
                            top: -(p * t) * C,
                            position: "relative",
                            padding: "0",
                            margin: "0"
                        }).children().css({height: F});
                        break;
                    case"left":
                        l.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:' + u * D + 'px"></div>').css({
                            width: m * D,
                            left: -(p * t) * D,
                            position: "relative",
                            overflow: "hidden",
                            padding: "0",
                            margin: "0"
                        }).children().css({"float": "left", width: E});
                        break;
                    case"leftLoop":
                    case"leftMarquee":
                        Z(), l.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; width:' + u * D + 'px"></div>').css({
                            width: (m + u + P) * D,
                            position: "relative",
                            overflow: "hidden",
                            padding: "0",
                            margin: "0",
                            left: -(P + p * t) * D
                        }).children().css({"float": "left", width: E});
                        break;
                    case"topLoop":
                    case"topMarquee":
                        Z(), l.wrap('<div class="tempWrap" style="overflow:hidden; position:relative; height:' + u * C + 'px"></div>').css({
                            height: (m + u + P) * C,
                            position: "relative",
                            padding: "0",
                            margin: "0",
                            top: -(P + p * t) * C
                        }).children().css({height: F})
                }
            }
            var $ = function (a) {
                var b = a * t;
                return a == k ? b = m : -1 == a && 0 != m % t && (b = -m % t), b
            }, _ = function (b) {
                var c = function (c) {
                    for (var d = c; u + c > d; d++)b.eq(d).find("img[" + n + "]").each(function () {
                        var b = a(this);
                        if (b.attr("src", b.attr(n)).removeAttr(n), l.find(".clone")[0])for (var c = l.children(), d = 0; d < c.size(); d++)c.eq(d).find("img[" + n + "]").each(function () {
                            a(this).attr(n) == b.attr("src") && a(this).attr("src", a(this).attr(n)).removeAttr(n)
                        })
                    })
                };
                switch (e) {
                    case"fade":
                    case"fold":
                    case"top":
                    case"left":
                    case"slideDown":
                        c(p * t);
                        break;
                    case"leftLoop":
                    case"topLoop":
                        c(P + $(O));
                        break;
                    case"leftMarquee":
                    case"topMarquee":
                        var d = "leftMarquee" == e ? l.css("left").replace("px", "") : l.css("top").replace("px", ""), f = "leftMarquee" == e ? D : C, g = P;
                        if (0 != d % f) {
                            var h = Math.abs(0 ^ d / f);
                            g = 1 == p ? P + h : P + h - 1
                        }
                        c(g)
                }
            }, ab = function (a) {
                if (!A || M != p || a || R) {
                    if (R ? p >= 1 ? p = 1 : 0 >= p && (p = 0) : (O = p, p >= k ? p = 0 : 0 > p && (p = k - 1)), S(), null != n && _(l.children()), o[0] && (Q = o.eq(p), null != n && _(o), "slideDown" == e ? (o.not(Q).stop(!0, !0).slideUp(q), Q.slideDown(q, G, function () {
                            l[0] || T()
                        })) : (o.not(Q).stop(!0, !0).hide(), Q.animate({opacity: "show"}, q, function () {
                            l[0] || T()
                        }))), m >= u)switch (e) {
                        case"fade":
                            l.children().stop(!0, !0).eq(p).animate({opacity: "show"}, q, G, function () {
                                T()
                            }).siblings().hide();
                            break;
                        case"fold":
                            l.children().stop(!0, !0).eq(p).animate({opacity: "show"}, q, G, function () {
                                T()
                            }).siblings().animate({opacity: "hide"}, q, G);
                            break;
                        case"top":
                            l.stop(!0, !1).animate({top: -p * t * C}, q, G, function () {
                                T()
                            });
                            break;
                        case"left":
                            l.stop(!0, !1).animate({left: -p * t * D}, q, G, function () {
                                T()
                            });
                            break;
                        case"leftLoop":
                            var b = O;
                            l.stop(!0, !0).animate({left: -($(O) + P) * D}, q, G, function () {
                                -1 >= b ? l.css("left", -(P + (k - 1) * t) * D) : b >= k && l.css("left", -P * D), T()
                            });
                            break;
                        case"topLoop":
                            var b = O;
                            l.stop(!0, !0).animate({top: -($(O) + P) * C}, q, G, function () {
                                -1 >= b ? l.css("top", -(P + (k - 1) * t) * C) : b >= k && l.css("top", -P * C), T()
                            });
                            break;
                        case"leftMarquee":
                            var c = l.css("left").replace("px", "");
                            0 == p ? l.animate({left: ++c}, 0, function () {
                                l.css("left").replace("px", "") >= 0 && l.css("left", -m * D)
                            }) : l.animate({left: --c}, 0, function () {
                                l.css("left").replace("px", "") <= -(m + P) * D && l.css("left", -P * D)
                            });
                            break;
                        case"topMarquee":
                            var d = l.css("top").replace("px", "");
                            0 == p ? l.animate({top: ++d}, 0, function () {
                                l.css("top").replace("px", "") >= 0 && l.css("top", -m * C)
                            }) : l.animate({top: --d}, 0, function () {
                                l.css("top").replace("px", "") <= -(m + P) * C && l.css("top", -P * C)
                            })
                    }
                    j.removeClass(K).eq(p).addClass(K), M = p, y || (g.removeClass("nextStop"), f.removeClass("prevStop"), 0 == p && f.addClass("prevStop"), p == k - 1 && g.addClass("nextStop")), h.html("<span>" + (p + 1) + "</span>/" + k)
                }
            };
            A && ab(!0), B && d.hover(function () {
                clearTimeout(J)
            }, function () {
                J = setTimeout(function () {
                    p = N, A ? ab() : "slideDown" == e ? Q.slideUp(q, U) : Q.animate({opacity: "hide"}, q, U), M = p
                }, 300)
            });
            var bb = function (a) {
                H = setInterval(function () {
                    w ? p-- : p++, ab()
                }, a ? a : r)
            }, cb = function (a) {
                H = setInterval(ab, a ? a : r)
            }, db = function () {
                z || (clearInterval(H), bb())
            }, eb = function () {
                (y || p != k - 1) && (p++, ab(), R || db())
            }, fb = function () {
                (y || 0 != p) && (p--, ab(), R || db())
            }, gb = function () {
                clearInterval(H), R ? cb() : bb(), i.removeClass("pauseState")
            }, hb = function () {
                clearInterval(H), i.addClass("pauseState")
            };
            if (v ? R ? (w ? p-- : p++, cb(), z && l.hover(hb, gb)) : (bb(), z && d.hover(hb, gb)) : (R && (w ? p-- : p++), i.addClass("pauseState")), i.click(function () {
                    i.hasClass("pauseState") ? gb() : hb()
                }), "mouseover" == c.trigger ? j.hover(function () {
                    var a = j.index(this);
                    I = setTimeout(function () {
                        p = a, ab(), db()
                    }, c.triggerTime)
                }, function () {
                    clearTimeout(I)
                }) : j.click(function () {
                    p = j.index(this), ab(), db()
                }), R) {
                if (g.mousedown(eb), f.mousedown(fb), y) {
                    var ib, jb = function () {
                        ib = setTimeout(function () {
                            clearInterval(H), cb(0 ^ r / 10)
                        }, 150)
                    }, kb = function () {
                        clearTimeout(ib), clearInterval(H), cb()
                    };
                    g.mousedown(jb), g.mouseup(kb), f.mousedown(jb), f.mouseup(kb)
                }
                "mouseover" == c.trigger && (g.hover(eb, function () {
                }), f.hover(fb, function () {
                }))
            } else g.click(eb), f.click(fb)
        })
    }
}(jQuery), jQuery.easing.jswing = jQuery.easing.swing, jQuery.extend(jQuery.easing, {
    def: "easeOutQuad",
    swing: function (a, b, c, d, e) {
        return jQuery.easing[jQuery.easing.def](a, b, c, d, e)
    },
    easeInQuad: function (a, b, c, d, e) {
        return d * (b /= e) * b + c
    },
    easeOutQuad: function (a, b, c, d, e) {
        return -d * (b /= e) * (b - 2) + c
    },
    easeInOutQuad: function (a, b, c, d, e) {
        return (b /= e / 2) < 1 ? d / 2 * b * b + c : -d / 2 * (--b * (b - 2) - 1) + c
    },
    easeInCubic: function (a, b, c, d, e) {
        return d * (b /= e) * b * b + c
    },
    easeOutCubic: function (a, b, c, d, e) {
        return d * ((b = b / e - 1) * b * b + 1) + c
    },
    easeInOutCubic: function (a, b, c, d, e) {
        return (b /= e / 2) < 1 ? d / 2 * b * b * b + c : d / 2 * ((b -= 2) * b * b + 2) + c
    },
    easeInQuart: function (a, b, c, d, e) {
        return d * (b /= e) * b * b * b + c
    },
    easeOutQuart: function (a, b, c, d, e) {
        return -d * ((b = b / e - 1) * b * b * b - 1) + c
    },
    easeInOutQuart: function (a, b, c, d, e) {
        return (b /= e / 2) < 1 ? d / 2 * b * b * b * b + c : -d / 2 * ((b -= 2) * b * b * b - 2) + c
    },
    easeInQuint: function (a, b, c, d, e) {
        return d * (b /= e) * b * b * b * b + c
    },
    easeOutQuint: function (a, b, c, d, e) {
        return d * ((b = b / e - 1) * b * b * b * b + 1) + c
    },
    easeInOutQuint: function (a, b, c, d, e) {
        return (b /= e / 2) < 1 ? d / 2 * b * b * b * b * b + c : d / 2 * ((b -= 2) * b * b * b * b + 2) + c
    },
    easeInSine: function (a, b, c, d, e) {
        return -d * Math.cos(b / e * (Math.PI / 2)) + d + c
    },
    easeOutSine: function (a, b, c, d, e) {
        return d * Math.sin(b / e * (Math.PI / 2)) + c
    },
    easeInOutSine: function (a, b, c, d, e) {
        return -d / 2 * (Math.cos(Math.PI * b / e) - 1) + c
    },
    easeInExpo: function (a, b, c, d, e) {
        return 0 == b ? c : d * Math.pow(2, 10 * (b / e - 1)) + c
    },
    easeOutExpo: function (a, b, c, d, e) {
        return b == e ? c + d : d * (-Math.pow(2, -10 * b / e) + 1) + c
    },
    easeInOutExpo: function (a, b, c, d, e) {
        return 0 == b ? c : b == e ? c + d : (b /= e / 2) < 1 ? d / 2 * Math.pow(2, 10 * (b - 1)) + c : d / 2 * (-Math.pow(2, -10 * --b) + 2) + c
    },
    easeInCirc: function (a, b, c, d, e) {
        return -d * (Math.sqrt(1 - (b /= e) * b) - 1) + c
    },
    easeOutCirc: function (a, b, c, d, e) {
        return d * Math.sqrt(1 - (b = b / e - 1) * b) + c
    },
    easeInOutCirc: function (a, b, c, d, e) {
        return (b /= e / 2) < 1 ? -d / 2 * (Math.sqrt(1 - b * b) - 1) + c : d / 2 * (Math.sqrt(1 - (b -= 2) * b) + 1) + c
    },
    easeInElastic: function (a, b, c, d, e) {
        var f = 1.70158, g = 0, h = d;
        if (0 == b)return c;
        if (1 == (b /= e))return c + d;
        if (g || (g = .3 * e), h < Math.abs(d)) {
            h = d;
            var f = g / 4
        } else var f = g / (2 * Math.PI) * Math.asin(d / h);
        return -(h * Math.pow(2, 10 * (b -= 1)) * Math.sin((b * e - f) * 2 * Math.PI / g)) + c
    },
    easeOutElastic: function (a, b, c, d, e) {
        var f = 1.70158, g = 0, h = d;
        if (0 == b)return c;
        if (1 == (b /= e))return c + d;
        if (g || (g = .3 * e), h < Math.abs(d)) {
            h = d;
            var f = g / 4
        } else var f = g / (2 * Math.PI) * Math.asin(d / h);
        return h * Math.pow(2, -10 * b) * Math.sin((b * e - f) * 2 * Math.PI / g) + d + c
    },
    easeInOutElastic: function (a, b, c, d, e) {
        var f = 1.70158, g = 0, h = d;
        if (0 == b)return c;
        if (2 == (b /= e / 2))return c + d;
        if (g || (g = e * .3 * 1.5), h < Math.abs(d)) {
            h = d;
            var f = g / 4
        } else var f = g / (2 * Math.PI) * Math.asin(d / h);
        return 1 > b ? -.5 * h * Math.pow(2, 10 * (b -= 1)) * Math.sin((b * e - f) * 2 * Math.PI / g) + c : .5 * h * Math.pow(2, -10 * (b -= 1)) * Math.sin((b * e - f) * 2 * Math.PI / g) + d + c
    },
    easeInBack: function (a, b, c, d, e, f) {
        return void 0 == f && (f = 1.70158), d * (b /= e) * b * ((f + 1) * b - f) + c
    },
    easeOutBack: function (a, b, c, d, e, f) {
        return void 0 == f && (f = 1.70158), d * ((b = b / e - 1) * b * ((f + 1) * b + f) + 1) + c
    },
    easeInOutBack: function (a, b, c, d, e, f) {
        return void 0 == f && (f = 1.70158), (b /= e / 2) < 1 ? d / 2 * b * b * (((f *= 1.525) + 1) * b - f) + c : d / 2 * ((b -= 2) * b * (((f *= 1.525) + 1) * b + f) + 2) + c
    },
    easeInBounce: function (a, b, c, d, e) {
        return d - jQuery.easing.easeOutBounce(a, e - b, 0, d, e) + c
    },
    easeOutBounce: function (a, b, c, d, e) {
        return (b /= e) < 1 / 2.75 ? d * 7.5625 * b * b + c : 2 / 2.75 > b ? d * (7.5625 * (b -= 1.5 / 2.75) * b + .75) + c : 2.5 / 2.75 > b ? d * (7.5625 * (b -= 2.25 / 2.75) * b + .9375) + c : d * (7.5625 * (b -= 2.625 / 2.75) * b + .984375) + c
    },
    easeInOutBounce: function (a, b, c, d, e) {
        return e / 2 > b ? .5 * jQuery.easing.easeInBounce(a, 2 * b, 0, d, e) + c : .5 * jQuery.easing.easeOutBounce(a, 2 * b - e, 0, d, e) + .5 * d + c
    }
});
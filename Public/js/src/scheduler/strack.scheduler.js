//momentjs
!function(a, b) {
    "object" == typeof exports && "undefined" != typeof module ? module.exports = b() :"function" == typeof define && define.amd ? define(b) :a.moment = b();
}(this, function() {
    "use strict";
    function a() {
        return fd.apply(null, arguments);
    }
    function b(a) {
        fd = a;
    }
    function c(a) {
        return a instanceof Array || "[object Array]" === Object.prototype.toString.call(a);
    }
    function d(a) {
        return a instanceof Date || "[object Date]" === Object.prototype.toString.call(a);
    }
    function e(a, b) {
        var c, d = [];
        for (c = 0; c < a.length; ++c) d.push(b(a[c], c));
        return d;
    }
    function f(a, b) {
        return Object.prototype.hasOwnProperty.call(a, b);
    }
    function g(a, b) {
        for (var c in b) f(b, c) && (a[c] = b[c]);
        return f(b, "toString") && (a.toString = b.toString), f(b, "valueOf") && (a.valueOf = b.valueOf),
            a;
    }
    function h(a, b, c, d) {
        return Ja(a, b, c, d, !0).utc();
    }
    function i() {
        return {
            empty:!1,
            unusedTokens:[],
            unusedInput:[],
            overflow:-2,
            charsLeftOver:0,
            nullInput:!1,
            invalidMonth:null,
            invalidFormat:!1,
            userInvalidated:!1,
            iso:!1,
            parsedDateParts:[],
            meridiem:null
        };
    }
    function j(a) {
        return null == a._pf && (a._pf = i()), a._pf;
    }
    function k(a) {
        if (null == a._isValid) {
            var b = j(a), c = gd.call(b.parsedDateParts, function(a) {
                return null != a;
            });
            a._isValid = !isNaN(a._d.getTime()) && b.overflow < 0 && !b.empty && !b.invalidMonth && !b.invalidWeekday && !b.nullInput && !b.invalidFormat && !b.userInvalidated && (!b.meridiem || b.meridiem && c),
            a._strict && (a._isValid = a._isValid && 0 === b.charsLeftOver && 0 === b.unusedTokens.length && void 0 === b.bigHour);
        }
        return a._isValid;
    }
    function l(a) {
        var b = h(NaN);
        return null != a ? g(j(b), a) :j(b).userInvalidated = !0, b;
    }
    function m(a) {
        return void 0 === a;
    }
    function n(a, b) {
        var c, d, e;
        if (m(b._isAMomentObject) || (a._isAMomentObject = b._isAMomentObject), m(b._i) || (a._i = b._i),
            m(b._f) || (a._f = b._f), m(b._l) || (a._l = b._l), m(b._strict) || (a._strict = b._strict),
            m(b._tzm) || (a._tzm = b._tzm), m(b._isUTC) || (a._isUTC = b._isUTC), m(b._offset) || (a._offset = b._offset),
            m(b._pf) || (a._pf = j(b)), m(b._locale) || (a._locale = b._locale), hd.length > 0) for (c in hd) d = hd[c],
            e = b[d], m(e) || (a[d] = e);
        return a;
    }
    function o(b) {
        n(this, b), this._d = new Date(null != b._d ? b._d.getTime() :NaN), id === !1 && (id = !0,
            a.updateOffset(this), id = !1);
    }
    function p(a) {
        return a instanceof o || null != a && null != a._isAMomentObject;
    }
    function q(a) {
        return 0 > a ? Math.ceil(a) :Math.floor(a);
    }
    function r(a) {
        var b = +a, c = 0;
        return 0 !== b && isFinite(b) && (c = q(b)), c;
    }
    function s(a, b, c) {
        var d, e = Math.min(a.length, b.length), f = Math.abs(a.length - b.length), g = 0;
        for (d = 0; e > d; d++) (c && a[d] !== b[d] || !c && r(a[d]) !== r(b[d])) && g++;
        return g + f;
    }
    function t(b) {
        a.suppressDeprecationWarnings === !1 && "undefined" != typeof console && console.warn && console.warn("Deprecation warning: " + b);
    }
    function u(b, c) {
        var d = !0;
        return g(function() {
            return null != a.deprecationHandler && a.deprecationHandler(null, b), d && (t(b + "\nArguments: " + Array.prototype.slice.call(arguments).join(", ") + "\n" + new Error().stack),
                d = !1), c.apply(this, arguments);
        }, c);
    }
    function v(b, c) {
        null != a.deprecationHandler && a.deprecationHandler(b, c), jd[b] || (t(c), jd[b] = !0);
    }
    function w(a) {
        return a instanceof Function || "[object Function]" === Object.prototype.toString.call(a);
    }
    function x(a) {
        return "[object Object]" === Object.prototype.toString.call(a);
    }
    function y(a) {
        var b, c;
        for (c in a) b = a[c], w(b) ? this[c] = b :this["_" + c] = b;
        this._config = a, this._ordinalParseLenient = new RegExp(this._ordinalParse.source + "|" + /\d{1,2}/.source);
    }
    function z(a, b) {
        var c, d = g({}, a);
        for (c in b) f(b, c) && (x(a[c]) && x(b[c]) ? (d[c] = {}, g(d[c], a[c]), g(d[c], b[c])) :null != b[c] ? d[c] = b[c] :delete d[c]);
        return d;
    }
    function A(a) {
        null != a && this.set(a);
    }
    function B(a) {
        return a ? a.toLowerCase().replace("_", "-") :a;
    }
    function C(a) {
        for (var b, c, d, e, f = 0; f < a.length; ) {
            for (e = B(a[f]).split("-"), b = e.length, c = B(a[f + 1]), c = c ? c.split("-") :null; b > 0; ) {
                if (d = D(e.slice(0, b).join("-"))) return d;
                if (c && c.length >= b && s(e, c, !0) >= b - 1) break;
                b--;
            }
            f++;
        }
        return null;
    }
    function D(a) {
        var b = null;
        if (!nd[a] && "undefined" != typeof module && module && module.exports) try {
            b = ld._abbr, require("./locale/" + a), E(b);
        } catch (c) {}
        return nd[a];
    }
    function E(a, b) {
        var c;
        return a && (c = m(b) ? H(a) :F(a, b), c && (ld = c)), ld._abbr;
    }
    function F(a, b) {
        return null !== b ? (b.abbr = a, null != nd[a] ? (v("defineLocaleOverride", "use moment.updateLocale(localeName, config) to change an existing locale. moment.defineLocale(localeName, config) should only be used for creating a new locale"),
            b = z(nd[a]._config, b)) :null != b.parentLocale && (null != nd[b.parentLocale] ? b = z(nd[b.parentLocale]._config, b) :v("parentLocaleUndefined", "specified parentLocale is not defined yet")),
            nd[a] = new A(b), E(a), nd[a]) :(delete nd[a], null);
    }
    function G(a, b) {
        if (null != b) {
            var c;
            null != nd[a] && (b = z(nd[a]._config, b)), c = new A(b), c.parentLocale = nd[a],
                nd[a] = c, E(a);
        } else null != nd[a] && (null != nd[a].parentLocale ? nd[a] = nd[a].parentLocale :null != nd[a] && delete nd[a]);
        return nd[a];
    }
    function H(a) {
        var b;
        if (a && a._locale && a._locale._abbr && (a = a._locale._abbr), !a) return ld;
        if (!c(a)) {
            if (b = D(a)) return b;
            a = [ a ];
        }
        return C(a);
    }
    function I() {
        return kd(nd);
    }
    function J(a, b) {
        var c = a.toLowerCase();
        od[c] = od[c + "s"] = od[b] = a;
    }
    function K(a) {
        return "string" == typeof a ? od[a] || od[a.toLowerCase()] :void 0;
    }
    function L(a) {
        var b, c, d = {};
        for (c in a) f(a, c) && (b = K(c), b && (d[b] = a[c]));
        return d;
    }
    function M(b, c) {
        return function(d) {
            return null != d ? (O(this, b, d), a.updateOffset(this, c), this) :N(this, b);
        };
    }
    function N(a, b) {
        return a.isValid() ? a._d["get" + (a._isUTC ? "UTC" :"") + b]() :NaN;
    }
    function O(a, b, c) {
        a.isValid() && a._d["set" + (a._isUTC ? "UTC" :"") + b](c);
    }
    function P(a, b) {
        var c;
        if ("object" == typeof a) for (c in a) this.set(c, a[c]); else if (a = K(a), w(this[a])) return this[a](b);
        return this;
    }
    function Q(a, b, c) {
        var d = "" + Math.abs(a), e = b - d.length, f = a >= 0;
        return (f ? c ? "+" :"" :"-") + Math.pow(10, Math.max(0, e)).toString().substr(1) + d;
    }
    function R(a, b, c, d) {
        var e = d;
        "string" == typeof d && (e = function() {
            return this[d]();
        }), a && (sd[a] = e), b && (sd[b[0]] = function() {
            return Q(e.apply(this, arguments), b[1], b[2]);
        }), c && (sd[c] = function() {
            return this.localeData().ordinal(e.apply(this, arguments), a);
        });
    }
    function S(a) {
        return a.match(/\[[\s\S]/) ? a.replace(/^\[|\]$/g, "") :a.replace(/\\/g, "");
    }
    function T(a) {
        var b, c, d = a.match(pd);
        for (b = 0, c = d.length; c > b; b++) sd[d[b]] ? d[b] = sd[d[b]] :d[b] = S(d[b]);
        return function(b) {
            var e, f = "";
            for (e = 0; c > e; e++) f += d[e] instanceof Function ? d[e].call(b, a) :d[e];
            return f;
        };
    }
    function U(a, b) {
        return a.isValid() ? (b = V(b, a.localeData()), rd[b] = rd[b] || T(b), rd[b](a)) :a.localeData().invalidDate();
    }
    function V(a, b) {
        function c(a) {
            return b.longDateFormat(a) || a;
        }
        var d = 5;
        for (qd.lastIndex = 0; d >= 0 && qd.test(a); ) a = a.replace(qd, c), qd.lastIndex = 0,
            d -= 1;
        return a;
    }
    function W(a, b, c) {
        Kd[a] = w(b) ? b :function(a, d) {
            return a && c ? c :b;
        };
    }
    function X(a, b) {
        return f(Kd, a) ? Kd[a](b._strict, b._locale) :new RegExp(Y(a));
    }
    function Y(a) {
        return Z(a.replace("\\", "").replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function(a, b, c, d, e) {
            return b || c || d || e;
        }));
    }
    function Z(a) {
        return a.replace(/[-\/\\^$*+?.()|[\]{}]/g, "\\$&");
    }
    function $(a, b) {
        var c, d = b;
        for ("string" == typeof a && (a = [ a ]), "number" == typeof b && (d = function(a, c) {
            c[b] = r(a);
        }), c = 0; c < a.length; c++) Ld[a[c]] = d;
    }
    function _(a, b) {
        $(a, function(a, c, d, e) {
            d._w = d._w || {}, b(a, d._w, d, e);
        });
    }
    function aa(a, b, c) {
        null != b && f(Ld, a) && Ld[a](b, c._a, c, a);
    }
    function ba(a, b) {
        return new Date(Date.UTC(a, b + 1, 0)).getUTCDate();
    }
    function ca(a, b) {
        return c(this._months) ? this._months[a.month()] :this._months[Vd.test(b) ? "format" :"standalone"][a.month()];
    }
    function da(a, b) {
        return c(this._monthsShort) ? this._monthsShort[a.month()] :this._monthsShort[Vd.test(b) ? "format" :"standalone"][a.month()];
    }
    function ea(a, b, c) {
        var d, e, f, g = a.toLocaleLowerCase();
        if (!this._monthsParse) for (this._monthsParse = [], this._longMonthsParse = [],
                                         this._shortMonthsParse = [], d = 0; 12 > d; ++d) f = h([ 2e3, d ]), this._shortMonthsParse[d] = this.monthsShort(f, "").toLocaleLowerCase(),
            this._longMonthsParse[d] = this.months(f, "").toLocaleLowerCase();
        return c ? "MMM" === b ? (e = md.call(this._shortMonthsParse, g), -1 !== e ? e :null) :(e = md.call(this._longMonthsParse, g),
            -1 !== e ? e :null) :"MMM" === b ? (e = md.call(this._shortMonthsParse, g), -1 !== e ? e :(e = md.call(this._longMonthsParse, g),
            -1 !== e ? e :null)) :(e = md.call(this._longMonthsParse, g), -1 !== e ? e :(e = md.call(this._shortMonthsParse, g),
            -1 !== e ? e :null));
    }
    function fa(a, b, c) {
        var d, e, f;
        if (this._monthsParseExact) return ea.call(this, a, b, c);
        for (this._monthsParse || (this._monthsParse = [], this._longMonthsParse = [], this._shortMonthsParse = []),
                 d = 0; 12 > d; d++) {
            if (e = h([ 2e3, d ]), c && !this._longMonthsParse[d] && (this._longMonthsParse[d] = new RegExp("^" + this.months(e, "").replace(".", "") + "$", "i"),
                    this._shortMonthsParse[d] = new RegExp("^" + this.monthsShort(e, "").replace(".", "") + "$", "i")),
                c || this._monthsParse[d] || (f = "^" + this.months(e, "") + "|^" + this.monthsShort(e, ""),
                    this._monthsParse[d] = new RegExp(f.replace(".", ""), "i")), c && "MMMM" === b && this._longMonthsParse[d].test(a)) return d;
            if (c && "MMM" === b && this._shortMonthsParse[d].test(a)) return d;
            if (!c && this._monthsParse[d].test(a)) return d;
        }
    }
    function ga(a, b) {
        var c;
        if (!a.isValid()) return a;
        if ("string" == typeof b) if (/^\d+$/.test(b)) b = r(b); else if (b = a.localeData().monthsParse(b),
            "number" != typeof b) return a;
        return c = Math.min(a.date(), ba(a.year(), b)), a._d["set" + (a._isUTC ? "UTC" :"") + "Month"](b, c),
            a;
    }
    function ha(b) {
        return null != b ? (ga(this, b), a.updateOffset(this, !0), this) :N(this, "Month");
    }
    function ia() {
        return ba(this.year(), this.month());
    }
    function ja(a) {
        return this._monthsParseExact ? (f(this, "_monthsRegex") || la.call(this), a ? this._monthsShortStrictRegex :this._monthsShortRegex) :this._monthsShortStrictRegex && a ? this._monthsShortStrictRegex :this._monthsShortRegex;
    }
    function ka(a) {
        return this._monthsParseExact ? (f(this, "_monthsRegex") || la.call(this), a ? this._monthsStrictRegex :this._monthsRegex) :this._monthsStrictRegex && a ? this._monthsStrictRegex :this._monthsRegex;
    }
    function la() {
        function a(a, b) {
            return b.length - a.length;
        }
        var b, c, d = [], e = [], f = [];
        for (b = 0; 12 > b; b++) c = h([ 2e3, b ]), d.push(this.monthsShort(c, "")), e.push(this.months(c, "")),
            f.push(this.months(c, "")), f.push(this.monthsShort(c, ""));
        for (d.sort(a), e.sort(a), f.sort(a), b = 0; 12 > b; b++) d[b] = Z(d[b]), e[b] = Z(e[b]),
            f[b] = Z(f[b]);
        this._monthsRegex = new RegExp("^(" + f.join("|") + ")", "i"), this._monthsShortRegex = this._monthsRegex,
            this._monthsStrictRegex = new RegExp("^(" + e.join("|") + ")", "i"), this._monthsShortStrictRegex = new RegExp("^(" + d.join("|") + ")", "i");
    }
    function ma(a) {
        var b, c = a._a;
        return c && -2 === j(a).overflow && (b = c[Nd] < 0 || c[Nd] > 11 ? Nd :c[Od] < 1 || c[Od] > ba(c[Md], c[Nd]) ? Od :c[Pd] < 0 || c[Pd] > 24 || 24 === c[Pd] && (0 !== c[Qd] || 0 !== c[Rd] || 0 !== c[Sd]) ? Pd :c[Qd] < 0 || c[Qd] > 59 ? Qd :c[Rd] < 0 || c[Rd] > 59 ? Rd :c[Sd] < 0 || c[Sd] > 999 ? Sd :-1,
        j(a)._overflowDayOfYear && (Md > b || b > Od) && (b = Od), j(a)._overflowWeeks && -1 === b && (b = Td),
        j(a)._overflowWeekday && -1 === b && (b = Ud), j(a).overflow = b), a;
    }
    function na(a) {
        var b, c, d, e, f, g, h = a._i, i = $d.exec(h) || _d.exec(h);
        if (i) {
            for (j(a).iso = !0, b = 0, c = be.length; c > b; b++) if (be[b][1].exec(i[1])) {
                e = be[b][0], d = be[b][2] !== !1;
                break;
            }
            if (null == e) return void (a._isValid = !1);
            if (i[3]) {
                for (b = 0, c = ce.length; c > b; b++) if (ce[b][1].exec(i[3])) {
                    f = (i[2] || " ") + ce[b][0];
                    break;
                }
                if (null == f) return void (a._isValid = !1);
            }
            if (!d && null != f) return void (a._isValid = !1);
            if (i[4]) {
                if (!ae.exec(i[4])) return void (a._isValid = !1);
                g = "Z";
            }
            a._f = e + (f || "") + (g || ""), Ca(a);
        } else a._isValid = !1;
    }
    function oa(b) {
        var c = de.exec(b._i);
        return null !== c ? void (b._d = new Date(+c[1])) :(na(b), void (b._isValid === !1 && (delete b._isValid,
            a.createFromInputFallback(b))));
    }
    function pa(a, b, c, d, e, f, g) {
        var h = new Date(a, b, c, d, e, f, g);
        return 100 > a && a >= 0 && isFinite(h.getFullYear()) && h.setFullYear(a), h;
    }
    function qa(a) {
        var b = new Date(Date.UTC.apply(null, arguments));
        return 100 > a && a >= 0 && isFinite(b.getUTCFullYear()) && b.setUTCFullYear(a),
            b;
    }
    function ra(a) {
        return sa(a) ? 366 :365;
    }
    function sa(a) {
        return a % 4 === 0 && a % 100 !== 0 || a % 400 === 0;
    }
    function ta() {
        return sa(this.year());
    }
    function ua(a, b, c) {
        var d = 7 + b - c, e = (7 + qa(a, 0, d).getUTCDay() - b) % 7;
        return -e + d - 1;
    }
    function va(a, b, c, d, e) {
        var f, g, h = (7 + c - d) % 7, i = ua(a, d, e), j = 1 + 7 * (b - 1) + h + i;
        return 0 >= j ? (f = a - 1, g = ra(f) + j) :j > ra(a) ? (f = a + 1, g = j - ra(a)) :(f = a,
            g = j), {
            year:f,
            dayOfYear:g
        };
    }
    function wa(a, b, c) {
        var d, e, f = ua(a.year(), b, c), g = Math.floor((a.dayOfYear() - f - 1) / 7) + 1;
        return 1 > g ? (e = a.year() - 1, d = g + xa(e, b, c)) :g > xa(a.year(), b, c) ? (d = g - xa(a.year(), b, c),
            e = a.year() + 1) :(e = a.year(), d = g), {
            week:d,
            year:e
        };
    }
    function xa(a, b, c) {
        var d = ua(a, b, c), e = ua(a + 1, b, c);
        return (ra(a) - d + e) / 7;
    }
    function ya(a, b, c) {
        return null != a ? a :null != b ? b :c;
    }
    function za(b) {
        var c = new Date(a.now());
        return b._useUTC ? [ c.getUTCFullYear(), c.getUTCMonth(), c.getUTCDate() ] :[ c.getFullYear(), c.getMonth(), c.getDate() ];
    }
    function Aa(a) {
        var b, c, d, e, f = [];
        if (!a._d) {
            for (d = za(a), a._w && null == a._a[Od] && null == a._a[Nd] && Ba(a), a._dayOfYear && (e = ya(a._a[Md], d[Md]),
            a._dayOfYear > ra(e) && (j(a)._overflowDayOfYear = !0), c = qa(e, 0, a._dayOfYear),
                a._a[Nd] = c.getUTCMonth(), a._a[Od] = c.getUTCDate()), b = 0; 3 > b && null == a._a[b]; ++b) a._a[b] = f[b] = d[b];
            for (;7 > b; b++) a._a[b] = f[b] = null == a._a[b] ? 2 === b ? 1 :0 :a._a[b];
            24 === a._a[Pd] && 0 === a._a[Qd] && 0 === a._a[Rd] && 0 === a._a[Sd] && (a._nextDay = !0,
                a._a[Pd] = 0), a._d = (a._useUTC ? qa :pa).apply(null, f), null != a._tzm && a._d.setUTCMinutes(a._d.getUTCMinutes() - a._tzm),
            a._nextDay && (a._a[Pd] = 24);
        }
    }
    function Ba(a) {
        var b, c, d, e, f, g, h, i;
        b = a._w, null != b.GG || null != b.W || null != b.E ? (f = 1, g = 4, c = ya(b.GG, a._a[Md], wa(Ka(), 1, 4).year),
            d = ya(b.W, 1), e = ya(b.E, 1), (1 > e || e > 7) && (i = !0)) :(f = a._locale._week.dow,
            g = a._locale._week.doy, c = ya(b.gg, a._a[Md], wa(Ka(), f, g).year), d = ya(b.w, 1),
            null != b.d ? (e = b.d, (0 > e || e > 6) && (i = !0)) :null != b.e ? (e = b.e + f,
            (b.e < 0 || b.e > 6) && (i = !0)) :e = f), 1 > d || d > xa(c, f, g) ? j(a)._overflowWeeks = !0 :null != i ? j(a)._overflowWeekday = !0 :(h = va(c, d, e, f, g),
            a._a[Md] = h.year, a._dayOfYear = h.dayOfYear);
    }
    function Ca(b) {
        if (b._f === a.ISO_8601) return void na(b);
        b._a = [], j(b).empty = !0;
        var c, d, e, f, g, h = "" + b._i, i = h.length, k = 0;
        for (e = V(b._f, b._locale).match(pd) || [], c = 0; c < e.length; c++) f = e[c],
            d = (h.match(X(f, b)) || [])[0], d && (g = h.substr(0, h.indexOf(d)), g.length > 0 && j(b).unusedInput.push(g),
            h = h.slice(h.indexOf(d) + d.length), k += d.length), sd[f] ? (d ? j(b).empty = !1 :j(b).unusedTokens.push(f),
            aa(f, d, b)) :b._strict && !d && j(b).unusedTokens.push(f);
        j(b).charsLeftOver = i - k, h.length > 0 && j(b).unusedInput.push(h), j(b).bigHour === !0 && b._a[Pd] <= 12 && b._a[Pd] > 0 && (j(b).bigHour = void 0),
            j(b).parsedDateParts = b._a.slice(0), j(b).meridiem = b._meridiem, b._a[Pd] = Da(b._locale, b._a[Pd], b._meridiem),
            Aa(b), ma(b);
    }
    function Da(a, b, c) {
        var d;
        return null == c ? b :null != a.meridiemHour ? a.meridiemHour(b, c) :null != a.isPM ? (d = a.isPM(c),
        d && 12 > b && (b += 12), d || 12 !== b || (b = 0), b) :b;
    }
    function Ea(a) {
        var b, c, d, e, f;
        if (0 === a._f.length) return j(a).invalidFormat = !0, void (a._d = new Date(NaN));
        for (e = 0; e < a._f.length; e++) f = 0, b = n({}, a), null != a._useUTC && (b._useUTC = a._useUTC),
            b._f = a._f[e], Ca(b), k(b) && (f += j(b).charsLeftOver, f += 10 * j(b).unusedTokens.length,
            j(b).score = f, (null == d || d > f) && (d = f, c = b));
        g(a, c || b);
    }
    function Fa(a) {
        if (!a._d) {
            var b = L(a._i);
            a._a = e([ b.year, b.month, b.day || b.date, b.hour, b.minute, b.second, b.millisecond ], function(a) {
                return a && parseInt(a, 10);
            }), Aa(a);
        }
    }
    function Ga(a) {
        var b = new o(ma(Ha(a)));
        return b._nextDay && (b.add(1, "d"), b._nextDay = void 0), b;
    }
    function Ha(a) {
        var b = a._i, e = a._f;
        return a._locale = a._locale || H(a._l), null === b || void 0 === e && "" === b ? l({
            nullInput:!0
        }) :("string" == typeof b && (a._i = b = a._locale.preparse(b)), p(b) ? new o(ma(b)) :(c(e) ? Ea(a) :e ? Ca(a) :d(b) ? a._d = b :Ia(a),
        k(a) || (a._d = null), a));
    }
    function Ia(b) {
        var f = b._i;
        void 0 === f ? b._d = new Date(a.now()) :d(f) ? b._d = new Date(f.valueOf()) :"string" == typeof f ? oa(b) :c(f) ? (b._a = e(f.slice(0), function(a) {
            return parseInt(a, 10);
        }), Aa(b)) :"object" == typeof f ? Fa(b) :"number" == typeof f ? b._d = new Date(f) :a.createFromInputFallback(b);
    }
    function Ja(a, b, c, d, e) {
        var f = {};
        return "boolean" == typeof c && (d = c, c = void 0), f._isAMomentObject = !0, f._useUTC = f._isUTC = e,
            f._l = c, f._i = a, f._f = b, f._strict = d, Ga(f);
    }
    function Ka(a, b, c, d) {
        return Ja(a, b, c, d, !1);
    }
    function La(a, b) {
        var d, e;
        if (1 === b.length && c(b[0]) && (b = b[0]), !b.length) return Ka();
        for (d = b[0], e = 1; e < b.length; ++e) (!b[e].isValid() || b[e][a](d)) && (d = b[e]);
        return d;
    }
    function Ma() {
        var a = [].slice.call(arguments, 0);
        return La("isBefore", a);
    }
    function Na() {
        var a = [].slice.call(arguments, 0);
        return La("isAfter", a);
    }
    function Oa(a) {
        var b = L(a), c = b.year || 0, d = b.quarter || 0, e = b.month || 0, f = b.week || 0, g = b.day || 0, h = b.hour || 0, i = b.minute || 0, j = b.second || 0, k = b.millisecond || 0;
        this._milliseconds = +k + 1e3 * j + 6e4 * i + 1e3 * h * 60 * 60, this._days = +g + 7 * f,
            this._months = +e + 3 * d + 12 * c, this._data = {}, this._locale = H(), this._bubble();
    }
    function Pa(a) {
        return a instanceof Oa;
    }
    function Qa(a, b) {
        R(a, 0, 0, function() {
            var a = this.utcOffset(), c = "+";
            return 0 > a && (a = -a, c = "-"), c + Q(~~(a / 60), 2) + b + Q(~~a % 60, 2);
        });
    }
    function Ra(a, b) {
        var c = (b || "").match(a) || [], d = c[c.length - 1] || [], e = (d + "").match(ie) || [ "-", 0, 0 ], f = +(60 * e[1]) + r(e[2]);
        return "+" === e[0] ? f :-f;
    }
    function Sa(b, c) {
        var e, f;
        return c._isUTC ? (e = c.clone(), f = (p(b) || d(b) ? b.valueOf() :Ka(b).valueOf()) - e.valueOf(),
            e._d.setTime(e._d.valueOf() + f), a.updateOffset(e, !1), e) :Ka(b).local();
    }
    function Ta(a) {
        return 15 * -Math.round(a._d.getTimezoneOffset() / 15);
    }
    function Ua(b, c) {
        var d, e = this._offset || 0;
        return this.isValid() ? null != b ? ("string" == typeof b ? b = Ra(Hd, b) :Math.abs(b) < 16 && (b = 60 * b),
        !this._isUTC && c && (d = Ta(this)), this._offset = b, this._isUTC = !0, null != d && this.add(d, "m"),
        e !== b && (!c || this._changeInProgress ? jb(this, db(b - e, "m"), 1, !1) :this._changeInProgress || (this._changeInProgress = !0,
            a.updateOffset(this, !0), this._changeInProgress = null)), this) :this._isUTC ? e :Ta(this) :null != b ? this :NaN;
    }
    function Va(a, b) {
        return null != a ? ("string" != typeof a && (a = -a), this.utcOffset(a, b), this) :-this.utcOffset();
    }
    function Wa(a) {
        return this.utcOffset(0, a);
    }
    function Xa(a) {
        return this._isUTC && (this.utcOffset(0, a), this._isUTC = !1, a && this.subtract(Ta(this), "m")),
            this;
    }
    function Ya() {
        return this._tzm ? this.utcOffset(this._tzm) :"string" == typeof this._i && this.utcOffset(Ra(Gd, this._i)),
            this;
    }
    function Za(a) {
        return this.isValid() ? (a = a ? Ka(a).utcOffset() :0, (this.utcOffset() - a) % 60 === 0) :!1;
    }
    function $a() {
        return this.utcOffset() > this.clone().month(0).utcOffset() || this.utcOffset() > this.clone().month(5).utcOffset();
    }
    function _a() {
        if (!m(this._isDSTShifted)) return this._isDSTShifted;
        var a = {};
        if (n(a, this), a = Ha(a), a._a) {
            var b = a._isUTC ? h(a._a) :Ka(a._a);
            this._isDSTShifted = this.isValid() && s(a._a, b.toArray()) > 0;
        } else this._isDSTShifted = !1;
        return this._isDSTShifted;
    }
    function ab() {
        return this.isValid() ? !this._isUTC :!1;
    }
    function bb() {
        return this.isValid() ? this._isUTC :!1;
    }
    function cb() {
        return this.isValid() ? this._isUTC && 0 === this._offset :!1;
    }
    function db(a, b) {
        var c, d, e, g = a, h = null;
        return Pa(a) ? g = {
            ms:a._milliseconds,
            d:a._days,
            M:a._months
        } :"number" == typeof a ? (g = {}, b ? g[b] = a :g.milliseconds = a) :(h = je.exec(a)) ? (c = "-" === h[1] ? -1 :1,
            g = {
                y:0,
                d:r(h[Od]) * c,
                h:r(h[Pd]) * c,
                m:r(h[Qd]) * c,
                s:r(h[Rd]) * c,
                ms:r(h[Sd]) * c
            }) :(h = ke.exec(a)) ? (c = "-" === h[1] ? -1 :1, g = {
            y:eb(h[2], c),
            M:eb(h[3], c),
            w:eb(h[4], c),
            d:eb(h[5], c),
            h:eb(h[6], c),
            m:eb(h[7], c),
            s:eb(h[8], c)
        }) :null == g ? g = {} :"object" == typeof g && ("from" in g || "to" in g) && (e = gb(Ka(g.from), Ka(g.to)),
            g = {}, g.ms = e.milliseconds, g.M = e.months), d = new Oa(g), Pa(a) && f(a, "_locale") && (d._locale = a._locale),
            d;
    }
    function eb(a, b) {
        var c = a && parseFloat(a.replace(",", "."));
        return (isNaN(c) ? 0 :c) * b;
    }
    function fb(a, b) {
        var c = {
            milliseconds:0,
            months:0
        };
        return c.months = b.month() - a.month() + 12 * (b.year() - a.year()), a.clone().add(c.months, "M").isAfter(b) && --c.months,
            c.milliseconds = +b - +a.clone().add(c.months, "M"), c;
    }
    function gb(a, b) {
        var c;
        return a.isValid() && b.isValid() ? (b = Sa(b, a), a.isBefore(b) ? c = fb(a, b) :(c = fb(b, a),
            c.milliseconds = -c.milliseconds, c.months = -c.months), c) :{
            milliseconds:0,
            months:0
        };
    }
    function hb(a) {
        return 0 > a ? -1 * Math.round(-1 * a) :Math.round(a);
    }
    function ib(a, b) {
        return function(c, d) {
            var e, f;
            return null === d || isNaN(+d) || (v(b, "moment()." + b + "(period, number) is deprecated. Please use moment()." + b + "(number, period)."),
                f = c, c = d, d = f), c = "string" == typeof c ? +c :c, e = db(c, d), jb(this, e, a),
                this;
        };
    }
    function jb(b, c, d, e) {
        var f = c._milliseconds, g = hb(c._days), h = hb(c._months);
        b.isValid() && (e = null == e ? !0 :e, f && b._d.setTime(b._d.valueOf() + f * d),
        g && O(b, "Date", N(b, "Date") + g * d), h && ga(b, N(b, "Month") + h * d), e && a.updateOffset(b, g || h));
    }
    function kb(a, b) {
        var c = a || Ka(), d = Sa(c, this).startOf("day"), e = this.diff(d, "days", !0), f = -6 > e ? "sameElse" :-1 > e ? "lastWeek" :0 > e ? "lastDay" :1 > e ? "sameDay" :2 > e ? "nextDay" :7 > e ? "nextWeek" :"sameElse", g = b && (w(b[f]) ? b[f]() :b[f]);
        return this.format(g || this.localeData().calendar(f, this, Ka(c)));
    }
    function lb() {
        return new o(this);
    }
    function mb(a, b) {
        var c = p(a) ? a :Ka(a);
        return this.isValid() && c.isValid() ? (b = K(m(b) ? "millisecond" :b), "millisecond" === b ? this.valueOf() > c.valueOf() :c.valueOf() < this.clone().startOf(b).valueOf()) :!1;
    }
    function nb(a, b) {
        var c = p(a) ? a :Ka(a);
        return this.isValid() && c.isValid() ? (b = K(m(b) ? "millisecond" :b), "millisecond" === b ? this.valueOf() < c.valueOf() :this.clone().endOf(b).valueOf() < c.valueOf()) :!1;
    }
    function ob(a, b, c, d) {
        return d = d || "()", ("(" === d[0] ? this.isAfter(a, c) :!this.isBefore(a, c)) && (")" === d[1] ? this.isBefore(b, c) :!this.isAfter(b, c));
    }
    function pb(a, b) {
        var c, d = p(a) ? a :Ka(a);
        return this.isValid() && d.isValid() ? (b = K(b || "millisecond"), "millisecond" === b ? this.valueOf() === d.valueOf() :(c = d.valueOf(),
        this.clone().startOf(b).valueOf() <= c && c <= this.clone().endOf(b).valueOf())) :!1;
    }
    function qb(a, b) {
        return this.isSame(a, b) || this.isAfter(a, b);
    }
    function rb(a, b) {
        return this.isSame(a, b) || this.isBefore(a, b);
    }
    function sb(a, b, c) {
        var d, e, f, g;
        return this.isValid() ? (d = Sa(a, this), d.isValid() ? (e = 6e4 * (d.utcOffset() - this.utcOffset()),
            b = K(b), "year" === b || "month" === b || "quarter" === b ? (g = tb(this, d), "quarter" === b ? g /= 3 :"year" === b && (g /= 12)) :(f = this - d,
            g = "second" === b ? f / 1e3 :"minute" === b ? f / 6e4 :"hour" === b ? f / 36e5 :"day" === b ? (f - e) / 864e5 :"week" === b ? (f - e) / 6048e5 :f),
            c ? g :q(g)) :NaN) :NaN;
    }
    function tb(a, b) {
        var c, d, e = 12 * (b.year() - a.year()) + (b.month() - a.month()), f = a.clone().add(e, "months");
        return 0 > b - f ? (c = a.clone().add(e - 1, "months"), d = (b - f) / (f - c)) :(c = a.clone().add(e + 1, "months"),
            d = (b - f) / (c - f)), -(e + d) || 0;
    }
    function ub() {
        return this.clone().locale("en").format("ddd MMM DD YYYY HH:mm:ss [GMT]ZZ");
    }
    function vb() {
        var a = this.clone().utc();
        return 0 < a.year() && a.year() <= 9999 ? w(Date.prototype.toISOString) ? this.toDate().toISOString() :U(a, "YYYY-MM-DD[T]HH:mm:ss.SSS[Z]") :U(a, "YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]");
    }
    function wb(b) {
        b || (b = this.isUtc() ? a.defaultFormatUtc :a.defaultFormat);
        var c = U(this, b);
        return this.localeData().postformat(c);
    }
    function xb(a, b) {
        return this.isValid() && (p(a) && a.isValid() || Ka(a).isValid()) ? db({
            to:this,
            from:a
        }).locale(this.locale()).humanize(!b) :this.localeData().invalidDate();
    }
    function yb(a) {
        return this.from(Ka(), a);
    }
    function zb(a, b) {
        return this.isValid() && (p(a) && a.isValid() || Ka(a).isValid()) ? db({
            from:this,
            to:a
        }).locale(this.locale()).humanize(!b) :this.localeData().invalidDate();
    }
    function Ab(a) {
        return this.to(Ka(), a);
    }
    function Bb(a) {
        var b;
        return void 0 === a ? this._locale._abbr :(b = H(a), null != b && (this._locale = b),
            this);
    }
    function Cb() {
        return this._locale;
    }
    function Db(a) {
        switch (a = K(a)) {
            case "year":
                this.month(0);

            case "quarter":
            case "month":
                this.date(1);

            case "week":
            case "isoWeek":
            case "day":
            case "date":
                this.hours(0);

            case "hour":
                this.minutes(0);

            case "minute":
                this.seconds(0);

            case "second":
                this.milliseconds(0);
        }
        return "week" === a && this.weekday(0), "isoWeek" === a && this.isoWeekday(1), "quarter" === a && this.month(3 * Math.floor(this.month() / 3)),
            this;
    }
    function Eb(a) {
        return a = K(a), void 0 === a || "millisecond" === a ? this :("date" === a && (a = "day"),
            this.startOf(a).add(1, "isoWeek" === a ? "week" :a).subtract(1, "ms"));
    }
    function Fb() {
        return this._d.valueOf() - 6e4 * (this._offset || 0);
    }
    function Gb() {
        return Math.floor(this.valueOf() / 1e3);
    }
    function Hb() {
        return this._offset ? new Date(this.valueOf()) :this._d;
    }
    function Ib() {
        var a = this;
        return [ a.year(), a.month(), a.date(), a.hour(), a.minute(), a.second(), a.millisecond() ];
    }
    function Jb() {
        var a = this;
        return {
            years:a.year(),
            months:a.month(),
            date:a.date(),
            hours:a.hours(),
            minutes:a.minutes(),
            seconds:a.seconds(),
            milliseconds:a.milliseconds()
        };
    }
    function Kb() {
        return this.isValid() ? this.toISOString() :null;
    }
    function Lb() {
        return k(this);
    }
    function Mb() {
        return g({}, j(this));
    }
    function Nb() {
        return j(this).overflow;
    }
    function Ob() {
        return {
            input:this._i,
            format:this._f,
            locale:this._locale,
            isUTC:this._isUTC,
            strict:this._strict
        };
    }
    function Pb(a, b) {
        R(0, [ a, a.length ], 0, b);
    }
    function Qb(a) {
        return Ub.call(this, a, this.week(), this.weekday(), this.localeData()._week.dow, this.localeData()._week.doy);
    }
    function Rb(a) {
        return Ub.call(this, a, this.isoWeek(), this.isoWeekday(), 1, 4);
    }
    function Sb() {
        return xa(this.year(), 1, 4);
    }
    function Tb() {
        var a = this.localeData()._week;
        return xa(this.year(), a.dow, a.doy);
    }
    function Ub(a, b, c, d, e) {
        var f;
        return null == a ? wa(this, d, e).year :(f = xa(a, d, e), b > f && (b = f), Vb.call(this, a, b, c, d, e));
    }
    function Vb(a, b, c, d, e) {
        var f = va(a, b, c, d, e), g = qa(f.year, 0, f.dayOfYear);
        return this.year(g.getUTCFullYear()), this.month(g.getUTCMonth()), this.date(g.getUTCDate()),
            this;
    }
    function Wb(a) {
        return null == a ? Math.ceil((this.month() + 1) / 3) :this.month(3 * (a - 1) + this.month() % 3);
    }
    function Xb(a) {
        return wa(a, this._week.dow, this._week.doy).week;
    }
    function Yb() {
        return this._week.dow;
    }
    function Zb() {
        return this._week.doy;
    }
    function $b(a) {
        var b = this.localeData().week(this);
        return null == a ? b :this.add(7 * (a - b), "d");
    }
    function _b(a) {
        var b = wa(this, 1, 4).week;
        return null == a ? b :this.add(7 * (a - b), "d");
    }
    function ac(a, b) {
        return "string" != typeof a ? a :isNaN(a) ? (a = b.weekdaysParse(a), "number" == typeof a ? a :null) :parseInt(a, 10);
    }
    function bc(a, b) {
        return c(this._weekdays) ? this._weekdays[a.day()] :this._weekdays[this._weekdays.isFormat.test(b) ? "format" :"standalone"][a.day()];
    }
    function cc(a) {
        return this._weekdaysShort[a.day()];
    }
    function dc(a) {
        return this._weekdaysMin[a.day()];
    }
    function ec(a, b, c) {
        var d, e, f, g = a.toLocaleLowerCase();
        if (!this._weekdaysParse) for (this._weekdaysParse = [], this._shortWeekdaysParse = [],
                                           this._minWeekdaysParse = [], d = 0; 7 > d; ++d) f = h([ 2e3, 1 ]).day(d), this._minWeekdaysParse[d] = this.weekdaysMin(f, "").toLocaleLowerCase(),
            this._shortWeekdaysParse[d] = this.weekdaysShort(f, "").toLocaleLowerCase(), this._weekdaysParse[d] = this.weekdays(f, "").toLocaleLowerCase();
        return c ? "dddd" === b ? (e = md.call(this._weekdaysParse, g), -1 !== e ? e :null) :"ddd" === b ? (e = md.call(this._shortWeekdaysParse, g),
            -1 !== e ? e :null) :(e = md.call(this._minWeekdaysParse, g), -1 !== e ? e :null) :"dddd" === b ? (e = md.call(this._weekdaysParse, g),
            -1 !== e ? e :(e = md.call(this._shortWeekdaysParse, g), -1 !== e ? e :(e = md.call(this._minWeekdaysParse, g),
                -1 !== e ? e :null))) :"ddd" === b ? (e = md.call(this._shortWeekdaysParse, g),
            -1 !== e ? e :(e = md.call(this._weekdaysParse, g), -1 !== e ? e :(e = md.call(this._minWeekdaysParse, g),
                -1 !== e ? e :null))) :(e = md.call(this._minWeekdaysParse, g), -1 !== e ? e :(e = md.call(this._weekdaysParse, g),
            -1 !== e ? e :(e = md.call(this._shortWeekdaysParse, g), -1 !== e ? e :null)));
    }
    function fc(a, b, c) {
        var d, e, f;
        if (this._weekdaysParseExact) return ec.call(this, a, b, c);
        for (this._weekdaysParse || (this._weekdaysParse = [], this._minWeekdaysParse = [],
            this._shortWeekdaysParse = [], this._fullWeekdaysParse = []), d = 0; 7 > d; d++) {
            if (e = h([ 2e3, 1 ]).day(d), c && !this._fullWeekdaysParse[d] && (this._fullWeekdaysParse[d] = new RegExp("^" + this.weekdays(e, "").replace(".", ".?") + "$", "i"),
                    this._shortWeekdaysParse[d] = new RegExp("^" + this.weekdaysShort(e, "").replace(".", ".?") + "$", "i"),
                    this._minWeekdaysParse[d] = new RegExp("^" + this.weekdaysMin(e, "").replace(".", ".?") + "$", "i")),
                this._weekdaysParse[d] || (f = "^" + this.weekdays(e, "") + "|^" + this.weekdaysShort(e, "") + "|^" + this.weekdaysMin(e, ""),
                    this._weekdaysParse[d] = new RegExp(f.replace(".", ""), "i")), c && "dddd" === b && this._fullWeekdaysParse[d].test(a)) return d;
            if (c && "ddd" === b && this._shortWeekdaysParse[d].test(a)) return d;
            if (c && "dd" === b && this._minWeekdaysParse[d].test(a)) return d;
            if (!c && this._weekdaysParse[d].test(a)) return d;
        }
    }
    function gc(a) {
        if (!this.isValid()) return null != a ? this :NaN;
        var b = this._isUTC ? this._d.getUTCDay() :this._d.getDay();
        return null != a ? (a = ac(a, this.localeData()), this.add(a - b, "d")) :b;
    }
    function hc(a) {
        if (!this.isValid()) return null != a ? this :NaN;
        var b = (this.day() + 7 - this.localeData()._week.dow) % 7;
        return null == a ? b :this.add(a - b, "d");
    }
    function ic(a) {
        return this.isValid() ? null == a ? this.day() || 7 :this.day(this.day() % 7 ? a :a - 7) :null != a ? this :NaN;
    }
    function jc(a) {
        return this._weekdaysParseExact ? (f(this, "_weekdaysRegex") || mc.call(this), a ? this._weekdaysStrictRegex :this._weekdaysRegex) :this._weekdaysStrictRegex && a ? this._weekdaysStrictRegex :this._weekdaysRegex;
    }
    function kc(a) {
        return this._weekdaysParseExact ? (f(this, "_weekdaysRegex") || mc.call(this), a ? this._weekdaysShortStrictRegex :this._weekdaysShortRegex) :this._weekdaysShortStrictRegex && a ? this._weekdaysShortStrictRegex :this._weekdaysShortRegex;
    }
    function lc(a) {
        return this._weekdaysParseExact ? (f(this, "_weekdaysRegex") || mc.call(this), a ? this._weekdaysMinStrictRegex :this._weekdaysMinRegex) :this._weekdaysMinStrictRegex && a ? this._weekdaysMinStrictRegex :this._weekdaysMinRegex;
    }
    function mc() {
        function a(a, b) {
            return b.length - a.length;
        }
        var b, c, d, e, f, g = [], i = [], j = [], k = [];
        for (b = 0; 7 > b; b++) c = h([ 2e3, 1 ]).day(b), d = this.weekdaysMin(c, ""), e = this.weekdaysShort(c, ""),
            f = this.weekdays(c, ""), g.push(d), i.push(e), j.push(f), k.push(d), k.push(e),
            k.push(f);
        for (g.sort(a), i.sort(a), j.sort(a), k.sort(a), b = 0; 7 > b; b++) i[b] = Z(i[b]),
            j[b] = Z(j[b]), k[b] = Z(k[b]);
        this._weekdaysRegex = new RegExp("^(" + k.join("|") + ")", "i"), this._weekdaysShortRegex = this._weekdaysRegex,
            this._weekdaysMinRegex = this._weekdaysRegex, this._weekdaysStrictRegex = new RegExp("^(" + j.join("|") + ")", "i"),
            this._weekdaysShortStrictRegex = new RegExp("^(" + i.join("|") + ")", "i"), this._weekdaysMinStrictRegex = new RegExp("^(" + g.join("|") + ")", "i");
    }
    function nc(a) {
        var b = Math.round((this.clone().startOf("day") - this.clone().startOf("year")) / 864e5) + 1;
        return null == a ? b :this.add(a - b, "d");
    }
    function oc() {
        return this.hours() % 12 || 12;
    }
    function pc() {
        return this.hours() || 24;
    }
    function qc(a, b) {
        R(a, 0, 0, function() {
            return this.localeData().meridiem(this.hours(), this.minutes(), b);
        });
    }
    function rc(a, b) {
        return b._meridiemParse;
    }
    function sc(a) {
        return "p" === (a + "").toLowerCase().charAt(0);
    }
    function tc(a, b, c) {
        return a > 11 ? c ? "pm" :"PM" :c ? "am" :"AM";
    }
    function uc(a, b) {
        b[Sd] = r(1e3 * ("0." + a));
    }
    function vc() {
        return this._isUTC ? "UTC" :"";
    }
    function wc() {
        return this._isUTC ? "Coordinated Universal Time" :"";
    }
    function xc(a) {
        return Ka(1e3 * a);
    }
    function yc() {
        return Ka.apply(null, arguments).parseZone();
    }
    function zc(a, b, c) {
        var d = this._calendar[a];
        return w(d) ? d.call(b, c) :d;
    }
    function Ac(a) {
        var b = this._longDateFormat[a], c = this._longDateFormat[a.toUpperCase()];
        return b || !c ? b :(this._longDateFormat[a] = c.replace(/MMMM|MM|DD|dddd/g, function(a) {
            return a.slice(1);
        }), this._longDateFormat[a]);
    }
    function Bc() {
        return this._invalidDate;
    }
    function Cc(a) {
        return this._ordinal.replace("%d", a);
    }
    function Dc(a) {
        return a;
    }
    function Ec(a, b, c, d) {
        var e = this._relativeTime[c];
        return w(e) ? e(a, b, c, d) :e.replace(/%d/i, a);
    }
    function Fc(a, b) {
        var c = this._relativeTime[a > 0 ? "future" :"past"];
        return w(c) ? c(b) :c.replace(/%s/i, b);
    }
    function Gc(a, b, c, d) {
        var e = H(), f = h().set(d, b);
        return e[c](f, a);
    }
    function Hc(a, b, c) {
        if ("number" == typeof a && (b = a, a = void 0), a = a || "", null != b) return Gc(a, b, c, "month");
        var d, e = [];
        for (d = 0; 12 > d; d++) e[d] = Gc(a, d, c, "month");
        return e;
    }
    function Ic(a, b, c, d) {
        "boolean" == typeof a ? ("number" == typeof b && (c = b, b = void 0), b = b || "") :(b = a,
            c = b, a = !1, "number" == typeof b && (c = b, b = void 0), b = b || "");
        var e = H(), f = a ? e._week.dow :0;
        if (null != c) return Gc(b, (c + f) % 7, d, "day");
        var g, h = [];
        for (g = 0; 7 > g; g++) h[g] = Gc(b, (g + f) % 7, d, "day");
        return h;
    }
    function Jc(a, b) {
        return Hc(a, b, "months");
    }
    function Kc(a, b) {
        return Hc(a, b, "monthsShort");
    }
    function Lc(a, b, c) {
        return Ic(a, b, c, "weekdays");
    }
    function Mc(a, b, c) {
        return Ic(a, b, c, "weekdaysShort");
    }
    function Nc(a, b, c) {
        return Ic(a, b, c, "weekdaysMin");
    }
    function Oc() {
        var a = this._data;
        return this._milliseconds = Le(this._milliseconds), this._days = Le(this._days),
            this._months = Le(this._months), a.milliseconds = Le(a.milliseconds), a.seconds = Le(a.seconds),
            a.minutes = Le(a.minutes), a.hours = Le(a.hours), a.months = Le(a.months), a.years = Le(a.years),
            this;
    }
    function Pc(a, b, c, d) {
        var e = db(b, c);
        return a._milliseconds += d * e._milliseconds, a._days += d * e._days, a._months += d * e._months,
            a._bubble();
    }
    function Qc(a, b) {
        return Pc(this, a, b, 1);
    }
    function Rc(a, b) {
        return Pc(this, a, b, -1);
    }
    function Sc(a) {
        return 0 > a ? Math.floor(a) :Math.ceil(a);
    }
    function Tc() {
        var a, b, c, d, e, f = this._milliseconds, g = this._days, h = this._months, i = this._data;
        return f >= 0 && g >= 0 && h >= 0 || 0 >= f && 0 >= g && 0 >= h || (f += 864e5 * Sc(Vc(h) + g),
            g = 0, h = 0), i.milliseconds = f % 1e3, a = q(f / 1e3), i.seconds = a % 60, b = q(a / 60),
            i.minutes = b % 60, c = q(b / 60), i.hours = c % 24, g += q(c / 24), e = q(Uc(g)),
            h += e, g -= Sc(Vc(e)), d = q(h / 12), h %= 12, i.days = g, i.months = h, i.years = d,
            this;
    }
    function Uc(a) {
        return 4800 * a / 146097;
    }
    function Vc(a) {
        return 146097 * a / 4800;
    }
    function Wc(a) {
        var b, c, d = this._milliseconds;
        if (a = K(a), "month" === a || "year" === a) return b = this._days + d / 864e5,
            c = this._months + Uc(b), "month" === a ? c :c / 12;
        switch (b = this._days + Math.round(Vc(this._months)), a) {
            case "week":
                return b / 7 + d / 6048e5;

            case "day":
                return b + d / 864e5;

            case "hour":
                return 24 * b + d / 36e5;

            case "minute":
                return 1440 * b + d / 6e4;

            case "second":
                return 86400 * b + d / 1e3;

            case "millisecond":
                return Math.floor(864e5 * b) + d;

            default:
                throw new Error("Unknown unit " + a);
        }
    }
    function Xc() {
        return this._milliseconds + 864e5 * this._days + this._months % 12 * 2592e6 + 31536e6 * r(this._months / 12);
    }
    function Yc(a) {
        return function() {
            return this.as(a);
        };
    }
    function Zc(a) {
        return a = K(a), this[a + "s"]();
    }
    function $c(a) {
        return function() {
            return this._data[a];
        };
    }
    function _c() {
        return q(this.days() / 7);
    }
    function ad(a, b, c, d, e) {
        return e.relativeTime(b || 1, !!c, a, d);
    }
    function bd(a, b, c) {
        var d = db(a).abs(), e = _e(d.as("s")), f = _e(d.as("m")), g = _e(d.as("h")), h = _e(d.as("d")), i = _e(d.as("M")), j = _e(d.as("y")), k = e < af.s && [ "s", e ] || 1 >= f && [ "m" ] || f < af.m && [ "mm", f ] || 1 >= g && [ "h" ] || g < af.h && [ "hh", g ] || 1 >= h && [ "d" ] || h < af.d && [ "dd", h ] || 1 >= i && [ "M" ] || i < af.M && [ "MM", i ] || 1 >= j && [ "y" ] || [ "yy", j ];
        return k[2] = b, k[3] = +a > 0, k[4] = c, ad.apply(null, k);
    }
    function cd(a, b) {
        return void 0 === af[a] ? !1 :void 0 === b ? af[a] :(af[a] = b, !0);
    }
    function dd(a) {
        var b = this.localeData(), c = bd(this, !a, b);
        return a && (c = b.pastFuture(+this, c)), b.postformat(c);
    }
    function ed() {
        var a, b, c, d = bf(this._milliseconds) / 1e3, e = bf(this._days), f = bf(this._months);
        a = q(d / 60), b = q(a / 60), d %= 60, a %= 60, c = q(f / 12), f %= 12;
        var g = c, h = f, i = e, j = b, k = a, l = d, m = this.asSeconds();
        return m ? (0 > m ? "-" :"") + "P" + (g ? g + "Y" :"") + (h ? h + "M" :"") + (i ? i + "D" :"") + (j || k || l ? "T" :"") + (j ? j + "H" :"") + (k ? k + "M" :"") + (l ? l + "S" :"") :"P0D";
    }
    var fd, gd;
    gd = Array.prototype.some ? Array.prototype.some :function(a) {
        for (var b = Object(this), c = b.length >>> 0, d = 0; c > d; d++) if (d in b && a.call(this, b[d], d, b)) return !0;
        return !1;
    };
    var hd = a.momentProperties = [], id = !1, jd = {};
    a.suppressDeprecationWarnings = !1, a.deprecationHandler = null;
    var kd;
    kd = Object.keys ? Object.keys :function(a) {
        var b, c = [];
        for (b in a) f(a, b) && c.push(b);
        return c;
    };
    var ld, md, nd = {}, od = {}, pd = /(\[[^\[]*\])|(\\)?([Hh]mm(ss)?|Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Qo?|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|kk?|mm?|ss?|S{1,9}|x|X|zz?|ZZ?|.)/g, qd = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g, rd = {}, sd = {}, td = /\d/, ud = /\d\d/, vd = /\d{3}/, wd = /\d{4}/, xd = /[+-]?\d{6}/, yd = /\d\d?/, zd = /\d\d\d\d?/, Ad = /\d\d\d\d\d\d?/, Bd = /\d{1,3}/, Cd = /\d{1,4}/, Dd = /[+-]?\d{1,6}/, Ed = /\d+/, Fd = /[+-]?\d+/, Gd = /Z|[+-]\d\d:?\d\d/gi, Hd = /Z|[+-]\d\d(?::?\d\d)?/gi, Id = /[+-]?\d+(\.\d{1,3})?/, Jd = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i, Kd = {}, Ld = {}, Md = 0, Nd = 1, Od = 2, Pd = 3, Qd = 4, Rd = 5, Sd = 6, Td = 7, Ud = 8;
    md = Array.prototype.indexOf ? Array.prototype.indexOf :function(a) {
        var b;
        for (b = 0; b < this.length; ++b) if (this[b] === a) return b;
        return -1;
    }, R("M", [ "MM", 2 ], "Mo", function() {
        return this.month() + 1;
    }), R("MMM", 0, 0, function(a) {
        return this.localeData().monthsShort(this, a);
    }), R("MMMM", 0, 0, function(a) {
        return this.localeData().months(this, a);
    }), J("month", "M"), W("M", yd), W("MM", yd, ud), W("MMM", function(a, b) {
        return b.monthsShortRegex(a);
    }), W("MMMM", function(a, b) {
        return b.monthsRegex(a);
    }), $([ "M", "MM" ], function(a, b) {
        b[Nd] = r(a) - 1;
    }), $([ "MMM", "MMMM" ], function(a, b, c, d) {
        var e = c._locale.monthsParse(a, d, c._strict);
        null != e ? b[Nd] = e :j(c).invalidMonth = a;
    });
    var Vd = /D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/,
        //Wd = "January_February_March_April_May_June_July_August_September_October_November_December".split("_"),
        Wd = [StrackPHP["January"],StrackPHP["February"],StrackPHP["March"],StrackPHP["April"],StrackPHP["May"],StrackPHP["June"],StrackPHP["July"],StrackPHP["August"],StrackPHP["September"],StrackPHP["October"],StrackPHP["November"],StrackPHP["December"]],
        //Xd = "Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec".split("_"),
        Xd = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
        Yd = Jd,
        Zd = Jd,
        $d = /^\s*((?:[+-]\d{6}|\d{4})-(?:\d\d-\d\d|W\d\d-\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?::\d\d(?::\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?/,
        _d = /^\s*((?:[+-]\d{6}|\d{4})(?:\d\d\d\d|W\d\d\d|W\d\d|\d\d\d|\d\d))(?:(T| )(\d\d(?:\d\d(?:\d\d(?:[.,]\d+)?)?)?)([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?/,
        ae = /Z|[+-]\d\d(?::?\d\d)?/,
        be = [ [ "YYYYYY-MM-DD", /[+-]\d{6}-\d\d-\d\d/ ], [ "YYYY-MM-DD", /\d{4}-\d\d-\d\d/ ], [ "GGGG-[W]WW-E", /\d{4}-W\d\d-\d/ ], [ "GGGG-[W]WW", /\d{4}-W\d\d/, !1 ], [ "YYYY-DDD", /\d{4}-\d{3}/ ], [ "YYYY-MM", /\d{4}-\d\d/, !1 ], [ "YYYYYYMMDD", /[+-]\d{10}/ ], [ "YYYYMMDD", /\d{8}/ ], [ "GGGG[W]WWE", /\d{4}W\d{3}/ ], [ "GGGG[W]WW", /\d{4}W\d{2}/, !1 ], [ "YYYYDDD", /\d{7}/ ] ], ce = [ [ "HH:mm:ss.SSSS", /\d\d:\d\d:\d\d\.\d+/ ], [ "HH:mm:ss,SSSS", /\d\d:\d\d:\d\d,\d+/ ], [ "HH:mm:ss", /\d\d:\d\d:\d\d/ ], [ "HH:mm", /\d\d:\d\d/ ], [ "HHmmss.SSSS", /\d\d\d\d\d\d\.\d+/ ], [ "HHmmss,SSSS", /\d\d\d\d\d\d,\d+/ ], [ "HHmmss", /\d\d\d\d\d\d/ ], [ "HHmm", /\d\d\d\d/ ], [ "HH", /\d\d/ ] ], de = /^\/?Date\((\-?\d+)/i;
    a.createFromInputFallback = u("moment construction falls back to js Date.", function(a) {
        a._d = new Date(a._i + (a._useUTC ? " UTC" :""));
    }), R("Y", 0, 0, function() {
        var a = this.year();
        return 9999 >= a ? "" + a :"+" + a;
    }), R(0, [ "YY", 2 ], 0, function() {
        return this.year() % 100;
    }), R(0, [ "YYYY", 4 ], 0, "year"), R(0, [ "YYYYY", 5 ], 0, "year"), R(0, [ "YYYYYY", 6, !0 ], 0, "year"),
        J("year", "y"), W("Y", Fd), W("YY", yd, ud), W("YYYY", Cd, wd), W("YYYYY", Dd, xd),
        W("YYYYYY", Dd, xd), $([ "YYYYY", "YYYYYY" ], Md), $("YYYY", function(b, c) {
        c[Md] = 2 === b.length ? a.parseTwoDigitYear(b) :r(b);
    }), $("YY", function(b, c) {
        c[Md] = a.parseTwoDigitYear(b);
    }), $("Y", function(a, b) {
        b[Md] = parseInt(a, 10);
    }), a.parseTwoDigitYear = function(a) {
        return r(a) + (r(a) > 68 ? 1900 :2e3);
    };
    var ee = M("FullYear", !0);
    a.ISO_8601 = function() {};
    var fe = u("moment().min is deprecated, use moment.max instead. https://github.com/moment/moment/issues/1548", function() {
        var a = Ka.apply(null, arguments);
        return this.isValid() && a.isValid() ? this > a ? this :a :l();
    }), ge = u("moment().max is deprecated, use moment.min instead. https://github.com/moment/moment/issues/1548", function() {
        var a = Ka.apply(null, arguments);
        return this.isValid() && a.isValid() ? a > this ? this :a :l();
    }), he = function() {
        return Date.now ? Date.now() :+new Date();
    };
    Qa("Z", ":"), Qa("ZZ", ""), W("Z", Hd), W("ZZ", Hd), $([ "Z", "ZZ" ], function(a, b, c) {
        c._useUTC = !0, c._tzm = Ra(Hd, a);
    });
    var ie = /([\+\-]|\d\d)/gi;
    a.updateOffset = function() {};
    var je = /^(\-)?(?:(\d*)[. ])?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?\d*)?$/, ke = /^(-)?P(?:(-?[0-9,.]*)Y)?(?:(-?[0-9,.]*)M)?(?:(-?[0-9,.]*)W)?(?:(-?[0-9,.]*)D)?(?:T(?:(-?[0-9,.]*)H)?(?:(-?[0-9,.]*)M)?(?:(-?[0-9,.]*)S)?)?$/;
    db.fn = Oa.prototype;
    var le = ib(1, "add"), me = ib(-1, "subtract");
    a.defaultFormat = "YYYY-MM-DDTHH:mm:ssZ", a.defaultFormatUtc = "YYYY-MM-DDTHH:mm:ss[Z]";
    var ne = u("moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.", function(a) {
        return void 0 === a ? this.localeData() :this.locale(a);
    });
    R(0, [ "gg", 2 ], 0, function() {
        return this.weekYear() % 100;
    }), R(0, [ "GG", 2 ], 0, function() {
        return this.isoWeekYear() % 100;
    }), Pb("gggg", "weekYear"), Pb("ggggg", "weekYear"), Pb("GGGG", "isoWeekYear"),
        Pb("GGGGG", "isoWeekYear"), J("weekYear", "gg"), J("isoWeekYear", "GG"), W("G", Fd),
        W("g", Fd), W("GG", yd, ud), W("gg", yd, ud), W("GGGG", Cd, wd), W("gggg", Cd, wd),
        W("GGGGG", Dd, xd), W("ggggg", Dd, xd), _([ "gggg", "ggggg", "GGGG", "GGGGG" ], function(a, b, c, d) {
        b[d.substr(0, 2)] = r(a);
    }), _([ "gg", "GG" ], function(b, c, d, e) {
        c[e] = a.parseTwoDigitYear(b);
    }), R("Q", 0, "Qo", "quarter"), J("quarter", "Q"), W("Q", td), $("Q", function(a, b) {
        b[Nd] = 3 * (r(a) - 1);
    }), R("w", [ "ww", 2 ], "wo", "week"), R("W", [ "WW", 2 ], "Wo", "isoWeek"), J("week", "w"),
        J("isoWeek", "W"), W("w", yd), W("ww", yd, ud), W("W", yd), W("WW", yd, ud), _([ "w", "ww", "W", "WW" ], function(a, b, c, d) {
        b[d.substr(0, 1)] = r(a);
    });
    var oe = {
        dow:0,
        doy:6
    };
    R("D", [ "DD", 2 ], "Do", "date"), J("date", "D"), W("D", yd), W("DD", yd, ud),
        W("Do", function(a, b) {
            return a ? b._ordinalParse :b._ordinalParseLenient;
        }), $([ "D", "DD" ], Od), $("Do", function(a, b) {
        b[Od] = r(a.match(yd)[0], 10);
    });
    var pe = M("Date", !0);
    R("d", 0, "do", "day"), R("dd", 0, 0, function(a) {
        return this.localeData().weekdaysMin(this, a);
    }), R("ddd", 0, 0, function(a) {
        return this.localeData().weekdaysShort(this, a);
    }), R("dddd", 0, 0, function(a) {
        return this.localeData().weekdays(this, a);
    }), R("e", 0, 0, "weekday"), R("E", 0, 0, "isoWeekday"), J("day", "d"), J("weekday", "e"),
        J("isoWeekday", "E"), W("d", yd), W("e", yd), W("E", yd), W("dd", function(a, b) {
        return b.weekdaysMinRegex(a);
    }), W("ddd", function(a, b) {
        return b.weekdaysShortRegex(a);
    }), W("dddd", function(a, b) {
        return b.weekdaysRegex(a);
    }), _([ "dd", "ddd", "dddd" ], function(a, b, c, d) {
        var e = c._locale.weekdaysParse(a, d, c._strict);
        null != e ? b.d = e :j(c).invalidWeekday = a;
    }), _([ "d", "e", "E" ], function(a, b, c, d) {
        b[d] = r(a);
    });
    var qe = "Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday".split("_"), re = "Sun_Mon_Tue_Wed_Thu_Fri_Sat".split("_"), se = "Su_Mo_Tu_We_Th_Fr_Sa".split("_"), te = Jd, ue = Jd, ve = Jd;
    R("DDD", [ "DDDD", 3 ], "DDDo", "dayOfYear"), J("dayOfYear", "DDD"), W("DDD", Bd),
        W("DDDD", vd), $([ "DDD", "DDDD" ], function(a, b, c) {
        c._dayOfYear = r(a);
    }), R("H", [ "HH", 2 ], 0, "hour"), R("h", [ "hh", 2 ], 0, oc), R("k", [ "kk", 2 ], 0, pc),
        R("hmm", 0, 0, function() {
            return "" + oc.apply(this) + Q(this.minutes(), 2);
        }), R("hmmss", 0, 0, function() {
        return "" + oc.apply(this) + Q(this.minutes(), 2) + Q(this.seconds(), 2);
    }), R("Hmm", 0, 0, function() {
        return "" + this.hours() + Q(this.minutes(), 2);
    }), R("Hmmss", 0, 0, function() {
        return "" + this.hours() + Q(this.minutes(), 2) + Q(this.seconds(), 2);
    }), qc("a", !0), qc("A", !1), J("hour", "h"), W("a", rc), W("A", rc), W("H", yd),
        W("h", yd), W("HH", yd, ud), W("hh", yd, ud), W("hmm", zd), W("hmmss", Ad), W("Hmm", zd),
        W("Hmmss", Ad), $([ "H", "HH" ], Pd), $([ "a", "A" ], function(a, b, c) {
        c._isPm = c._locale.isPM(a), c._meridiem = a;
    }), $([ "h", "hh" ], function(a, b, c) {
        b[Pd] = r(a), j(c).bigHour = !0;
    }), $("hmm", function(a, b, c) {
        var d = a.length - 2;
        b[Pd] = r(a.substr(0, d)), b[Qd] = r(a.substr(d)), j(c).bigHour = !0;
    }), $("hmmss", function(a, b, c) {
        var d = a.length - 4, e = a.length - 2;
        b[Pd] = r(a.substr(0, d)), b[Qd] = r(a.substr(d, 2)), b[Rd] = r(a.substr(e)), j(c).bigHour = !0;
    }), $("Hmm", function(a, b, c) {
        var d = a.length - 2;
        b[Pd] = r(a.substr(0, d)), b[Qd] = r(a.substr(d));
    }), $("Hmmss", function(a, b, c) {
        var d = a.length - 4, e = a.length - 2;
        b[Pd] = r(a.substr(0, d)), b[Qd] = r(a.substr(d, 2)), b[Rd] = r(a.substr(e));
    });
    var we = /[ap]\.?m?\.?/i, xe = M("Hours", !0);
    R("m", [ "mm", 2 ], 0, "minute"), J("minute", "m"), W("m", yd), W("mm", yd, ud),
        $([ "m", "mm" ], Qd);
    var ye = M("Minutes", !1);
    R("s", [ "ss", 2 ], 0, "second"), J("second", "s"), W("s", yd), W("ss", yd, ud),
        $([ "s", "ss" ], Rd);
    var ze = M("Seconds", !1);
    R("S", 0, 0, function() {
        return ~~(this.millisecond() / 100);
    }), R(0, [ "SS", 2 ], 0, function() {
        return ~~(this.millisecond() / 10);
    }), R(0, [ "SSS", 3 ], 0, "millisecond"), R(0, [ "SSSS", 4 ], 0, function() {
        return 10 * this.millisecond();
    }), R(0, [ "SSSSS", 5 ], 0, function() {
        return 100 * this.millisecond();
    }), R(0, [ "SSSSSS", 6 ], 0, function() {
        return 1e3 * this.millisecond();
    }), R(0, [ "SSSSSSS", 7 ], 0, function() {
        return 1e4 * this.millisecond();
    }), R(0, [ "SSSSSSSS", 8 ], 0, function() {
        return 1e5 * this.millisecond();
    }), R(0, [ "SSSSSSSSS", 9 ], 0, function() {
        return 1e6 * this.millisecond();
    }), J("millisecond", "ms"), W("S", Bd, td), W("SS", Bd, ud), W("SSS", Bd, vd);
    var Ae;
    for (Ae = "SSSS"; Ae.length <= 9; Ae += "S") W(Ae, Ed);
    for (Ae = "S"; Ae.length <= 9; Ae += "S") $(Ae, uc);
    var Be = M("Milliseconds", !1);
    R("z", 0, 0, "zoneAbbr"), R("zz", 0, 0, "zoneName");
    var Ce = o.prototype;
    Ce.add = le, Ce.calendar = kb, Ce.clone = lb, Ce.diff = sb, Ce.endOf = Eb, Ce.format = wb,
        Ce.from = xb, Ce.fromNow = yb, Ce.to = zb, Ce.toNow = Ab, Ce.get = P, Ce.invalidAt = Nb,
        Ce.isAfter = mb, Ce.isBefore = nb, Ce.isBetween = ob, Ce.isSame = pb, Ce.isSameOrAfter = qb,
        Ce.isSameOrBefore = rb, Ce.isValid = Lb, Ce.lang = ne, Ce.locale = Bb, Ce.localeData = Cb,
        Ce.max = ge, Ce.min = fe, Ce.parsingFlags = Mb, Ce.set = P, Ce.startOf = Db, Ce.subtract = me,
        Ce.toArray = Ib, Ce.toObject = Jb, Ce.toDate = Hb, Ce.toISOString = vb, Ce.toJSON = Kb,
        Ce.toString = ub, Ce.unix = Gb, Ce.valueOf = Fb, Ce.creationData = Ob, Ce.year = ee,
        Ce.isLeapYear = ta, Ce.weekYear = Qb, Ce.isoWeekYear = Rb, Ce.quarter = Ce.quarters = Wb,
        Ce.month = ha, Ce.daysInMonth = ia, Ce.week = Ce.weeks = $b, Ce.isoWeek = Ce.isoWeeks = _b,
        Ce.weeksInYear = Tb, Ce.isoWeeksInYear = Sb, Ce.date = pe, Ce.day = Ce.days = gc,
        Ce.weekday = hc, Ce.isoWeekday = ic, Ce.dayOfYear = nc, Ce.hour = Ce.hours = xe,
        Ce.minute = Ce.minutes = ye, Ce.second = Ce.seconds = ze, Ce.millisecond = Ce.milliseconds = Be,
        Ce.utcOffset = Ua, Ce.utc = Wa, Ce.local = Xa, Ce.parseZone = Ya, Ce.hasAlignedHourOffset = Za,
        Ce.isDST = $a, Ce.isDSTShifted = _a, Ce.isLocal = ab, Ce.isUtcOffset = bb, Ce.isUtc = cb,
        Ce.isUTC = cb, Ce.zoneAbbr = vc, Ce.zoneName = wc, Ce.dates = u("dates accessor is deprecated. Use date instead.", pe),
        Ce.months = u("months accessor is deprecated. Use month instead", ha), Ce.years = u("years accessor is deprecated. Use year instead", ee),
        Ce.zone = u("moment().zone is deprecated, use moment().utcOffset instead. https://github.com/moment/moment/issues/1779", Va);
    var De = Ce, Ee = {
        sameDay:"[Today at] LT",
        nextDay:"[Tomorrow at] LT",
        nextWeek:"dddd [at] LT",
        lastDay:"[Yesterday at] LT",
        lastWeek:"[Last] dddd [at] LT",
        sameElse:"L"
    }, Fe = {
        LTS:"h:mm:ss A",
        LT:"h:mm A",
        L:"MM/DD/YYYY",
        LL:"MMMM D, YYYY",
        LLL:"MMMM D, YYYY h:mm A",
        LLLL:"dddd, MMMM D, YYYY h:mm A"
    }, Ge = "Invalid date", He = "%d", Ie = /\d{1,2}/, Je = {
        future:"in %s",
        past:"%s ago",
        s:"a few seconds",
        m:"a minute",
        mm:"%d minutes",
        h:"an hour",
        hh:"%d hours",
        d:"a day",
        dd:"%d days",
        M:"a month",
        MM:"%d months",
        y:"a year",
        yy:"%d years"
    }, Ke = A.prototype;
    Ke._calendar = Ee, Ke.calendar = zc, Ke._longDateFormat = Fe, Ke.longDateFormat = Ac,
        Ke._invalidDate = Ge, Ke.invalidDate = Bc, Ke._ordinal = He, Ke.ordinal = Cc, Ke._ordinalParse = Ie,
        Ke.preparse = Dc, Ke.postformat = Dc, Ke._relativeTime = Je, Ke.relativeTime = Ec,
        Ke.pastFuture = Fc, Ke.set = y, Ke.months = ca, Ke._months = Wd, Ke.monthsShort = da,
        Ke._monthsShort = Xd, Ke.monthsParse = fa, Ke._monthsRegex = Zd, Ke.monthsRegex = ka,
        Ke._monthsShortRegex = Yd, Ke.monthsShortRegex = ja, Ke.week = Xb, Ke._week = oe,
        Ke.firstDayOfYear = Zb, Ke.firstDayOfWeek = Yb, Ke.weekdays = bc, Ke._weekdays = qe,
        Ke.weekdaysMin = dc, Ke._weekdaysMin = se, Ke.weekdaysShort = cc, Ke._weekdaysShort = re,
        Ke.weekdaysParse = fc, Ke._weekdaysRegex = te, Ke.weekdaysRegex = jc, Ke._weekdaysShortRegex = ue,
        Ke.weekdaysShortRegex = kc, Ke._weekdaysMinRegex = ve, Ke.weekdaysMinRegex = lc,
        Ke.isPM = sc, Ke._meridiemParse = we, Ke.meridiem = tc, E("en", {
        ordinalParse:/\d{1,2}(th|st|nd|rd)/,
        ordinal:function(a) {
            var b = a % 10, c = 1 === r(a % 100 / 10) ? "th" :1 === b ? "st" :2 === b ? "nd" :3 === b ? "rd" :"th";
            return a + c;
        }
    }), a.lang = u("moment.lang is deprecated. Use moment.locale instead.", E), a.langData = u("moment.langData is deprecated. Use moment.localeData instead.", H);
    var Le = Math.abs, Me = Yc("ms"), Ne = Yc("s"), Oe = Yc("m"), Pe = Yc("h"), Qe = Yc("d"), Re = Yc("w"), Se = Yc("M"), Te = Yc("y"), Ue = $c("milliseconds"), Ve = $c("seconds"), We = $c("minutes"), Xe = $c("hours"), Ye = $c("days"), Ze = $c("months"), $e = $c("years"), _e = Math.round, af = {
        s:45,
        m:45,
        h:22,
        d:26,
        M:11
    }, bf = Math.abs, cf = Oa.prototype;
    cf.abs = Oc, cf.add = Qc, cf.subtract = Rc, cf.as = Wc, cf.asMilliseconds = Me,
        cf.asSeconds = Ne, cf.asMinutes = Oe, cf.asHours = Pe, cf.asDays = Qe, cf.asWeeks = Re,
        cf.asMonths = Se, cf.asYears = Te, cf.valueOf = Xc, cf._bubble = Tc, cf.get = Zc,
        cf.milliseconds = Ue, cf.seconds = Ve, cf.minutes = We, cf.hours = Xe, cf.days = Ye,
        cf.weeks = _c, cf.months = Ze, cf.years = $e, cf.humanize = dd, cf.toISOString = ed,
        cf.toString = ed, cf.toJSON = ed, cf.locale = Bb, cf.localeData = Cb, cf.toIsoString = u("toIsoString() is deprecated. Please use toISOString() instead (notice the capitals)", ed),
        cf.lang = ne, R("X", 0, 0, "unix"), R("x", 0, 0, "valueOf"), W("x", Fd), W("X", Id),
        $("X", function(a, b, c) {
            c._d = new Date(1e3 * parseFloat(a, 10));
        }), $("x", function(a, b, c) {
        c._d = new Date(r(a));
    }), a.version = "2.13.0", b(Ka), a.fn = De, a.min = Ma, a.max = Na, a.now = he,
        a.utc = h, a.unix = xc, a.months = Jc, a.isDate = d, a.locale = E, a.invalid = l,
        a.duration = db, a.isMoment = p, a.weekdays = Lc, a.parseZone = yc, a.localeData = H,
        a.isDuration = Pa, a.monthsShort = Kc, a.weekdaysMin = Nc, a.defineLocale = F, a.updateLocale = G,
        a.locales = I, a.weekdaysShort = Mc, a.normalizeUnits = K, a.relativeTimeThreshold = cd,
        a.prototype = De;
    var df = a;
    return df;
});
//fullcalendar
!function(t) {
    "function" == typeof define && define.amd ? define([ "jquery", "moment" ], t) :"object" == typeof exports ? module.exports = t(require("jquery"), require("moment")) :t(jQuery, moment);
}(function(t, e) {
    function n(t) {
        return q(t, qt);
    }
    function i(t, e) {
        e.left && t.css({
            "border-left-width":1,
            "margin-left":e.left - 1
        }), e.right && t.css({
            "border-right-width":1,
            "margin-right":e.right - 1
        });
    }
    function r(t) {
        t.css({
            "margin-left":"",
            "margin-right":"",
            "border-left-width":"",
            "border-right-width":""
        });
    }
    function s() {
        t("body").addClass("fc-not-allowed");
    }
    function o() {
        t("body").removeClass("fc-not-allowed");
    }
    function l(e, n, i) {
        var r = Math.floor(n / e.length), s = Math.floor(n - r * (e.length - 1)), o = [], l = [], u = [], c = 0;
        a(e), e.each(function(n, i) {
            var a = n === e.length - 1 ? s :r, d = t(i).outerHeight(!0);
            d < a ? (o.push(i), l.push(d), u.push(t(i).height())) :c += d;
        }), i && (n -= c, r = Math.floor(n / o.length), s = Math.floor(n - r * (o.length - 1))),
            t(o).each(function(e, n) {
                var i = e === o.length - 1 ? s :r, a = l[e], c = u[e], d = i - (a - c);
                a < i && t(n).height(d);
            });
    }
    function a(t) {
        t.height("");
    }
    function u(e) {
        var n = 0;
        return e.find("> *").each(function(e, i) {
            var r = t(i).outerWidth();
            r > n && (n = r);
        }), n++, e.width(n), n;
    }
    function c(t, e) {
        var n, i = t.add(e);
        return i.css({
            position:"relative",
            left:-1
        }), n = t.outerHeight() - e.outerHeight(), i.css({
            position:"",
            left:""
        }), n;
    }
    function d(e) {
        var n = e.css("position"), i = e.parents().filter(function() {
            var e = t(this);
            return /(auto|scroll)/.test(e.css("overflow") + e.css("overflow-y") + e.css("overflow-x"));
        }).eq(0);
        return "fixed" !== n && i.length ? i :t(e[0].ownerDocument || document);
    }
    function h(t, e) {
        var n = t.offset(), i = n.left - (e ? e.left :0), r = n.top - (e ? e.top :0);
        return {
            left:i,
            right:i + t.outerWidth(),
            top:r,
            bottom:r + t.outerHeight()
        };
    }
    function f(t, e) {
        var n = t.offset(), i = p(t), r = n.left + y(t, "border-left-width") + i.left - (e ? e.left :0), s = n.top + y(t, "border-top-width") + i.top - (e ? e.top :0);
        return {
            left:r,
            right:r + t[0].clientWidth,
            top:s,
            bottom:s + t[0].clientHeight
        };
    }
    function g(t, e) {
        var n = t.offset(), i = n.left + y(t, "border-left-width") + y(t, "padding-left") - (e ? e.left :0), r = n.top + y(t, "border-top-width") + y(t, "padding-top") - (e ? e.top :0);
        return {
            left:i,
            right:i + t.width(),
            top:r,
            bottom:r + t.height()
        };
    }
    function p(t) {
        var e = t.innerWidth() - t[0].clientWidth, n = {
            left:0,
            right:0,
            top:0,
            bottom:t.innerHeight() - t[0].clientHeight
        };
        return v() && "rtl" == t.css("direction") ? n.left = e :n.right = e, n;
    }
    function v() {
        return null === Zt && (Zt = m()), Zt;
    }
    function m() {
        var e = t("<div><div/></div>").css({
            position:"absolute",
            top:-1e3,
            left:0,
            border:0,
            padding:0,
            overflow:"scroll",
            direction:"rtl"
        }).appendTo("body"), n = e.children(), i = n.offset().left > e.offset().left;
        return e.remove(), i;
    }
    function y(t, e) {
        return parseFloat(t.css(e)) || 0;
    }
    function S(t) {
        return 1 == t.which && !t.ctrlKey;
    }
    function w(t) {
        if (void 0 !== t.pageX) return t.pageX;
        var e = t.originalEvent.touches;
        return e ? e[0].pageX :void 0;
    }
    function E(t) {
        if (void 0 !== t.pageY) return t.pageY;
        var e = t.originalEvent.touches;
        return e ? e[0].pageY :void 0;
    }
    function b(t) {
        return /^touch/.test(t.type);
    }
    function D(t) {
        t.addClass("fc-unselectable").on("selectstart", C);
    }
    function C(t) {
        t.preventDefault();
    }
    function H(t) {
        return !!window.addEventListener && (window.addEventListener("scroll", t, !0), !0);
    }
    function T(t) {
        return !!window.removeEventListener && (window.removeEventListener("scroll", t, !0),
                !0);
    }
    function x(t, e) {
        var n = {
            left:Math.max(t.left, e.left),
            right:Math.min(t.right, e.right),
            top:Math.max(t.top, e.top),
            bottom:Math.min(t.bottom, e.bottom)
        };
        return n.left < n.right && n.top < n.bottom && n;
    }
    function R(t, e) {
        return {
            left:Math.min(Math.max(t.left, e.left), e.right),
            top:Math.min(Math.max(t.top, e.top), e.bottom)
        };
    }
    function I(t) {
        return {
            left:(t.left + t.right) / 2,
            top:(t.top + t.bottom) / 2
        };
    }
    function k(t, e) {
        return {
            left:t.left - e.left,
            top:t.top - e.top
        };
    }
    function L(e) {
        var n, i, r = [], s = [];
        for ("string" == typeof e ? s = e.split(/\s*,\s*/) :"function" == typeof e ? s = [ e ] :t.isArray(e) && (s = e),
                 n = 0; n < s.length; n++) i = s[n], "string" == typeof i ? r.push("-" == i.charAt(0) ? {
            field:i.substring(1),
            order:-1
        } :{
            field:i,
            order:1
        }) :"function" == typeof i && r.push({
            func:i
        });
        return r;
    }
    function M(t, e, n) {
        var i, r;
        for (i = 0; i < n.length; i++) if (r = z(t, e, n[i])) return r;
        return 0;
    }
    function z(t, e, n) {
        return n.func ? n.func(t, e) :B(t[n.field], e[n.field]) * (n.order || 1);
    }
    function B(e, n) {
        return e || n ? null == n ? -1 :null == e ? 1 :"string" === t.type(e) || "string" === t.type(n) ? String(e).localeCompare(String(n)) :e - n :0;
    }
    function F(t, e) {
        var n, i, r, s, o = t.start, l = t.end, a = e.start, u = e.end;
        if (l > a && o < u) return o >= a ? (n = o.clone(), r = !0) :(n = a.clone(), r = !1),
            l <= u ? (i = l.clone(), s = !0) :(i = u.clone(), s = !1), {
            start:n,
            end:i,
            isStart:r,
            isEnd:s
        };
    }
    function N(t, n) {
        return e.duration({
            days:t.clone().stripTime().diff(n.clone().stripTime(), "days"),
            ms:t.time() - n.time()
        });
    }
    function G(t, n) {
        return e.duration({
            days:t.clone().stripTime().diff(n.clone().stripTime(), "days")
        });
    }
    function O(t, n, i) {
        return e.duration(Math.round(t.diff(n, i, !0)), i);
    }
    function A(t, e) {
        var n, i, r;
        for (n = 0; n < Xt.length && (i = Xt[n], r = V(i, t, e), !(r >= 1 && ot(r))); n++) ;
        return i;
    }
    function V(t, n, i) {
        return null != i ? i.diff(n, t, !0) :e.isDuration(n) ? n.as(t) :n.end.diff(n.start, t, !0);
    }
    function P(t, e, n) {
        var i;
        return W(n) ? (e - t) / n :(i = n.asMonths(), Math.abs(i) >= 1 && ot(i) ? e.diff(t, "months", !0) / i :e.diff(t, "days", !0) / n.asDays());
    }
    function _(t, e) {
        var n, i;
        return W(t) || W(e) ? t / e :(n = t.asMonths(), i = e.asMonths(), Math.abs(n) >= 1 && ot(n) && Math.abs(i) >= 1 && ot(i) ? n / i :t.asDays() / e.asDays());
    }
    function Y(t, n) {
        var i;
        return W(t) ? e.duration(t * n) :(i = t.asMonths(), Math.abs(i) >= 1 && ot(i) ? e.duration({
            months:i * n
        }) :e.duration({
            days:t.asDays() * n
        }));
    }
    function W(t) {
        return Boolean(t.hours() || t.minutes() || t.seconds() || t.milliseconds());
    }
    function j(t) {
        return "[object Date]" === Object.prototype.toString.call(t) || t instanceof Date;
    }
    function U(t) {
        return /^\d+\:\d+(?:\:\d+\.?(?:\d{3})?)?$/.test(t);
    }
    function q(t, e) {
        var n, i, r, s, o, l, a = {};
        if (e) for (n = 0; n < e.length; n++) {
            for (i = e[n], r = [], s = t.length - 1; s >= 0; s--) if (o = t[s][i], "object" == typeof o) r.unshift(o); else if (void 0 !== o) {
                a[i] = o;
                break;
            }
            r.length && (a[i] = q(r));
        }
        for (n = t.length - 1; n >= 0; n--) {
            l = t[n];
            for (i in l) i in a || (a[i] = l[i]);
        }
        return a;
    }
    function Z(t) {
        var e = function() {};
        return e.prototype = t, new e();
    }
    function $(t, e) {
        for (var n in t) X(t, n) && (e[n] = t[n]);
    }
    function X(t, e) {
        return Kt.call(t, e);
    }
    function K(e) {
        return /undefined|null|boolean|number|string/.test(t.type(e));
    }
    function Q(e, n, i) {
        if (t.isFunction(e) && (e = [ e ]), e) {
            var r, s;
            for (r = 0; r < e.length; r++) s = e[r].apply(n, i) || s;
            return s;
        }
    }
    function J() {
        for (var t = 0; t < arguments.length; t++) if (void 0 !== arguments[t]) return arguments[t];
    }
    function tt(t) {
        return (t + "").replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/'/g, "&#039;").replace(/"/g, "&quot;").replace(/\n/g, "<br />");
    }
    function et(t) {
        return t.replace(/&.*?;/g, "");
    }
    function nt(e) {
        var n = [];
        return t.each(e, function(t, e) {
            null != e && n.push(t + ":" + e);
        }), n.join(";");
    }
    function it(e) {
        var n = [];
        return t.each(e, function(t, e) {
            null != e && n.push(t + '="' + tt(e) + '"');
        }), n.join(" ");
    }
    function rt(t) {
        return t.charAt(0).toUpperCase() + t.slice(1);
    }
    function st(t, e) {
        return t - e;
    }
    function ot(t) {
        return t % 1 === 0;
    }
    function lt(t, e) {
        var n = t[e];
        return function() {
            return n.apply(t, arguments);
        };
    }
    function at(t, e, n) {
        var i, r, s, o, l, a = function() {
            var u = +new Date() - o;
            u < e ? i = setTimeout(a, e - u) :(i = null, n || (l = t.apply(s, r), s = r = null));
        };
        return function() {
            s = this, r = arguments, o = +new Date();
            var u = n && !i;
            return i || (i = setTimeout(a, e)), u && (l = t.apply(s, r), s = r = null), l;
        };
    }
    function ut(e, n) {
        return e && e.then && "resolved" !== e.state() ? n ? e.then(n) :void 0 :t.when(n());
    }
    function ct(n, i, r) {
        var s, o, l, a, u = n[0], c = 1 == n.length && "string" == typeof u;
        return e.isMoment(u) || j(u) || void 0 === u ? a = e.apply(null, n) :(s = !1, o = !1,
            c ? Qt.test(u) ? (u += "-01", n = [ u ], s = !0, o = !0) :(l = Jt.exec(u)) && (s = !l[5],
                o = !0) :t.isArray(u) && (o = !0), a = i || s ? e.utc.apply(e, n) :e.apply(null, n),
            s ? (a._ambigTime = !0, a._ambigZone = !0) :r && (o ? a._ambigZone = !0 :c && a.utcOffset(u))),
            a._fullCalendar = !0, a;
    }
    function dt(t, e) {
        return ee.format.call(t, e);
    }
    function ht(t, e) {
        return ft(t, yt(e));
    }
    function ft(t, e) {
        var n, i = "";
        for (n = 0; n < e.length; n++) i += gt(t, e[n]);
        return i;
    }
    function gt(t, e) {
        var n, i;
        return "string" == typeof e ? e :(n = e.token) ? ie[n] ? ie[n](t) :dt(t, n) :e.maybe && (i = ft(t, e.maybe),
            i.match(/[1-9]/)) ? i :"";
    }
    function pt(t, e, n, i, r) {
        var s;
        return t = jt.moment.parseZone(t), e = jt.moment.parseZone(e), s = t.localeData(),
            n = s.longDateFormat(n) || n, i = i || " - ", vt(t, e, yt(n), i, r);
    }
    function vt(t, e, n, i, r) {
        var s, o, l, a, u = t.clone().stripZone(), c = e.clone().stripZone(), d = "", h = "", f = "", g = "", p = "";
        for (o = 0; o < n.length && (s = mt(t, e, u, c, n[o]), s !== !1); o++) d += s;
        for (l = n.length - 1; l > o && (s = mt(t, e, u, c, n[l]), s !== !1); l--) h = s + h;
        for (a = o; a <= l; a++) f += gt(t, n[a]), g += gt(e, n[a]);
        return (f || g) && (p = r ? g + i + f :f + i + g), d + p + h;
    }
    function mt(t, e, n, i, r) {
        var s, o;
        return "string" == typeof r ? r :!!((s = r.token) && (o = re[s.charAt(0)], o && n.isSame(i, o))) && dt(t, s);
    }
    function yt(t) {
        return t in se ? se[t] :se[t] = St(t);
    }
    function St(t) {
        for (var e, n = [], i = /\[([^\]]*)\]|\(([^\)]*)\)|(LTS|LT|(\w)\4*o?)|([^\w\[\(]+)/g; e = i.exec(t); ) e[1] ? n.push(e[1]) :e[2] ? n.push({
            maybe:St(e[2])
        }) :e[3] ? n.push({
            token:e[3]
        }) :e[5] && n.push(e[5]);
        return n;
    }
    function wt() {}
    function Et(t, e) {
        var n;
        return X(e, "constructor") && (n = e.constructor), "function" != typeof n && (n = e.constructor = function() {
            t.apply(this, arguments);
        }), n.prototype = Z(t.prototype), $(e, n.prototype), $(t, n), n;
    }
    function bt(t, e) {
        $(e, t.prototype);
    }
    function Dt(t, e) {
        return !t && !e || !(!t || !e) && t.component === e.component && Ct(t, e) && Ct(e, t);
    }
    function Ct(t, e) {
        for (var n in t) if (!/^(component|left|right|top|bottom)$/.test(n) && t[n] !== e[n]) return !1;
        return !0;
    }
    function Ht(t) {
        return {
            start:t.start.clone(),
            end:t.end ? t.end.clone() :null,
            allDay:t.allDay
        };
    }
    function Tt(t) {
        var e = Rt(t);
        return "background" === e || "inverse-background" === e;
    }
    function xt(t) {
        return "inverse-background" === Rt(t);
    }
    function Rt(t) {
        return J((t.source || {}).rendering, t.rendering);
    }
    function It(t) {
        var e, n, i = {};
        for (e = 0; e < t.length; e++) n = t[e], (i[n._id] || (i[n._id] = [])).push(n);
        return i;
    }
    function kt(t, e) {
        return t.start - e.start;
    }
    function Lt(n) {
        var i, r, s, o, l = jt.dataAttrPrefix;
        return l && (l += "-"), i = n.data(l + "event") || null, i && (i = "object" == typeof i ? t.extend({}, i) :{},
            r = i.start, null == r && (r = i.time), s = i.duration, o = i.stick, delete i.start,
            delete i.time, delete i.duration, delete i.stick), null == r && (r = n.data(l + "start")),
        null == r && (r = n.data(l + "time")), null == s && (s = n.data(l + "duration")),
        null == o && (o = n.data(l + "stick")), r = null != r ? e.duration(r) :null, s = null != s ? e.duration(s) :null,
            o = Boolean(o), {
            eventProps:i,
            startTime:r,
            duration:s,
            stick:o
        };
    }
    function Mt(t, e) {
        var n, i;
        for (n = 0; n < e.length; n++) if (i = e[n], i.leftCol <= t.rightCol && i.rightCol >= t.leftCol) return !0;
        return !1;
    }
    function zt(t, e) {
        return t.leftCol - e.leftCol;
    }
    function Bt(t) {
        var e, n, i, r = [];
        for (e = 0; e < t.length; e++) {
            for (n = t[e], i = 0; i < r.length && Gt(n, r[i]).length; i++) ;
            n.level = i, (r[i] || (r[i] = [])).push(n);
        }
        return r;
    }
    function Ft(t) {
        var e, n, i, r, s;
        for (e = 0; e < t.length; e++) for (n = t[e], i = 0; i < n.length; i++) for (r = n[i],
                                                                                         r.forwardSegs = [], s = e + 1; s < t.length; s++) Gt(r, t[s], r.forwardSegs);
    }
    function Nt(t) {
        var e, n, i = t.forwardSegs, r = 0;
        if (void 0 === t.forwardPressure) {
            for (e = 0; e < i.length; e++) n = i[e], Nt(n), r = Math.max(r, 1 + n.forwardPressure);
            t.forwardPressure = r;
        }
    }
    function Gt(t, e, n) {
        n = n || [];
        for (var i = 0; i < e.length; i++) Ot(t, e[i]) && n.push(e[i]);
        return n;
    }
    function Ot(t, e) {
        return t.bottom > e.top && t.top < e.bottom;
    }
    function At(n, i) {
        function r(t) {
            t._locale = U;
        }
        function s() {
            $ ? u() && (g(), c()) :o();
        }
        function o() {
            n.addClass("fc"), n.on("click.fc", "a[data-goto]", function(e) {
                var n = t(this), i = n.data("goto"), r = j.moment(i.date), s = i.type, o = K.opt("navLink" + rt(s) + "Click");
                "function" == typeof o ? o(r, e) :("string" == typeof o && (s = o), N(r, s));
            }), j.bindOption("theme", function(t) {
                X = t ? "ui" :"fc", n.toggleClass("ui-widget", t), n.toggleClass("fc-unthemed", !t);
            }), j.bindOptions([ "isRTL", "locale" ], function(t) {
                n.toggleClass("fc-ltr", !t), n.toggleClass("fc-rtl", t);
            }), $ = t("<div class='fc-view-container'/>").prependTo(n), q = j.header = new _t(j),
                l(), c(j.options.defaultView), j.options.handleWindowResize && (J = at(m, j.options.windowResizeDelay),
                t(window).resize(J));
        }
        function l() {
            q.render(), q.el && n.prepend(q.el);
        }
        function a() {
            K && K.removeElement(), q.removeElement(), $.remove(), n.removeClass("fc fc-ltr fc-rtl fc-unthemed ui-widget"),
                n.off(".fc"), J && t(window).unbind("resize", J);
        }
        function u() {
            return n.is(":visible");
        }
        function c(e, n) {
            lt++, K && e && K.type !== e && (O(), d()), !K && e && (K = j.view = ot[e] || (ot[e] = j.instantiateView(e)),
                K.setElement(t("<div class='fc-view fc-" + e + "-view' />").appendTo($)), q.activateButton(e)),
            K && (tt = K.massageCurrentDate(tt), K.displaying && tt >= K.intervalStart && tt < K.intervalEnd || u() && (K.display(tt, n),
                A(), H(), T(), E())), A(), lt--;
        }
        function d() {
            q.deactivateButton(K.type), K.removeElement(), K = j.view = null;
        }
        function h() {
            lt++, O();
            var t = K.type, e = K.queryScroll();
            d(), c(t, e), A(), lt--;
        }
        function f(t) {
            if (u()) return t && p(), lt++, K.updateSize(!0), lt--, !0;
        }
        function g() {
            u() && p();
        }
        function p() {
            var t = j.options.contentHeight, e = j.options.height;
            Q = "number" == typeof t ? t :"function" == typeof t ? t() :"number" == typeof e ? e - v() :"function" == typeof e ? e() - v() :"parent" === e ? n.parent().height() - v() :Math.round($.width() / Math.max(j.options.aspectRatio, .5));
        }
        function v() {
            return q.el ? q.el.outerHeight(!0) :0;
        }
        function m(t) {
            !lt && t.target === window && K.start && f(!0) && K.trigger("windowResize", st);
        }
        function y() {
            b();
        }
        function S(t) {
            it(j.getEventSourcesByMatchArray(t));
        }
        function w() {
            u() && (O(), K.displayEvents(ut), A());
        }
        function E() {
            !j.options.lazyFetching || et(K.start, K.end) ? b() :w();
        }
        function b() {
            nt(K.start, K.end);
        }
        function D(t) {
            ut = t, w();
        }
        function C() {
            w();
        }
        function H() {
            q.updateTitle(K.title);
        }
        function T() {
            var t = j.getNow();
            t >= K.intervalStart && t < K.intervalEnd ? q.disableButton("today") :q.enableButton("today");
        }
        function x(t, e) {
            K.select(j.buildSelectSpan.apply(j, arguments));
        }
        function R() {
            K && K.unselect();
        }
        function I() {
            tt = K.computePrevDate(tt), c();
        }
        function k() {
            tt = K.computeNextDate(tt), c();
        }
        function L() {
            tt.add(-1, "years"), c();
        }
        function M() {
            tt.add(1, "years"), c();
        }
        function z() {
            tt = j.getNow(), c();
        }
        function B(t) {
            tt = j.moment(t).stripZone(), c();
        }
        function F(t) {
            tt.add(e.duration(t)), c();
        }
        function N(t, e) {
            var n;
            e = e || "day", n = j.getViewSpec(e) || j.getUnitViewSpec(e), tt = t.clone(), c(n ? n.type :null);
        }
        function G() {
            return j.applyTimezone(tt);
        }
        function O() {
            $.css({
                width:"100%",
                height:$.height(),
                overflow:"hidden"
            });
        }
        function A() {
            $.css({
                width:"",
                height:"",
                overflow:""
            });
        }
        function V() {
            return j;
        }
        function P() {
            return K;
        }
        function _(t, e) {
            var n;
            if ("string" == typeof t) {
                if (void 0 === e) return j.options[t];
                n = {}, n[t] = e, Y(n);
            } else "object" == typeof t && Y(t);
        }
        function Y(t) {
            var e, n = 0;
            for (e in t) j.dynamicOverrides[e] = t[e];
            j.viewSpecCache = {}, j.populateOptionsHash();
            for (e in t) j.triggerOptionHandlers(e), n++;
            if (1 === n) {
                if ("height" === e || "contentHeight" === e || "aspectRatio" === e) return void f(!0);
                if ("defaultDate" === e) return;
                if ("businessHours" === e) return void (K && (K.unrenderBusinessHours(), K.renderBusinessHours()));
                if ("timezone" === e) return j.rezoneArrayEventSources(), void y();
            }
            l(), ot = {}, h();
        }
        function W(t, e) {
            var n = Array.prototype.slice.call(arguments, 2);
            if (e = e || st, this.triggerWith(t, e, n), j.options[t]) return j.options[t].apply(e, n);
        }
        var j = this;
        j.render = s, j.destroy = a, j.refetchEvents = y, j.refetchEventSources = S, j.reportEvents = D,
            j.reportEventChange = C, j.rerenderEvents = w, j.changeView = c, j.select = x, j.unselect = R,
            j.prev = I, j.next = k, j.prevYear = L, j.nextYear = M, j.today = z, j.gotoDate = B,
            j.incrementDate = F, j.zoomTo = N, j.getDate = G, j.getCalendar = V, j.getView = P,
            j.option = _, j.trigger = W, j.dynamicOverrides = {}, j.viewSpecCache = {}, j.optionHandlers = {},
            j.overrides = t.extend({}, i), j.populateOptionsHash();
        var U;
        j.bindOptions([ "locale", "monthNames", "monthNamesShort", "dayNames", "dayNamesShort", "firstDay", "weekNumberCalculation" ], function(t, e, n, i, s, o, l) {
            if ("iso" === l && (l = "ISO"), U = Z(Pt(t)), e && (U._months = e), n && (U._monthsShort = n),
                i && (U._weekdays = i), s && (U._weekdaysShort = s), null == o && "ISO" === l && (o = 1),
                null != o) {
                var a = Z(U._week);
                a.dow = o, U._week = a;
            }
            "ISO" !== l && "local" !== l && "function" != typeof l || (U._fullCalendar_weekCalc = l),
            tt && r(tt);
        }), j.defaultAllDayEventDuration = e.duration(j.options.defaultAllDayEventDuration),
            j.defaultTimedEventDuration = e.duration(j.options.defaultTimedEventDuration), j.moment = function() {
            var t;
            return "local" === j.options.timezone ? (t = jt.moment.apply(null, arguments), t.hasTime() && t.local()) :t = "UTC" === j.options.timezone ? jt.moment.utc.apply(null, arguments) :jt.moment.parseZone.apply(null, arguments),
                r(t), t;
        }, j.localizeMoment = r, j.getIsAmbigTimezone = function() {
            return "local" !== j.options.timezone && "UTC" !== j.options.timezone;
        }, j.applyTimezone = function(t) {
            if (!t.hasTime()) return t.clone();
            var e, n = j.moment(t.toArray()), i = t.time() - n.time();
            return i && (e = n.clone().add(i), t.time() - e.time() === 0 && (n = e)), n;
        }, j.getNow = function() {
            var t = j.options.now;
            return "function" == typeof t && (t = t()), j.moment(t).stripZone();
        }, j.getEventEnd = function(t) {
            return t.end ? t.end.clone() :j.getDefaultEventEnd(t.allDay, t.start);
        }, j.getDefaultEventEnd = function(t, e) {
            var n = e.clone();
            return t ? n.stripTime().add(j.defaultAllDayEventDuration) :n.add(j.defaultTimedEventDuration),
            j.getIsAmbigTimezone() && n.stripZone(), n;
        }, j.humanizeDuration = function(t) {
            return t.locale(j.options.locale).humanize();
        }, Yt.call(j);
        var q, $, X, K, Q, J, tt, et = j.isFetchNeeded, nt = j.fetchEvents, it = j.fetchEventSources, st = n[0], ot = {}, lt = 0, ut = [];
        tt = null != j.options.defaultDate ? j.moment(j.options.defaultDate).stripZone() :j.getNow(),
            j.getSuggestedViewHeight = function() {
                return void 0 === Q && g(), Q;
            }, j.isHeightAuto = function() {
            return "auto" === j.options.contentHeight || "auto" === j.options.height;
        }, j.freezeContentHeight = O, j.unfreezeContentHeight = A, j.initialize();
    }
    function Vt(e) {
        t.each(Ce, function(t, n) {
            null == e[t] && (e[t] = n(e));
        });
    }
    function Pt(t) {
        return e.localeData(t) || e.localeData("en");
    }
    function _t(e) {
        function n() {
            var n = e.options,
                s = n.header,
                dohide = "";
            if(n.hideHeader){
                dohide = "fc-hide-header"
            };
            f = n.theme ? "ui" :"fc", s ? (h ? h.empty() :h = this.el = t("<div class='fc-toolbar "+dohide+"'/>"),
                h.append(r("left")).append(r("right")).append(r("center")).append('<div class="fc-clear"/>')) :i();
        }
        function i() {
            h && (h.remove(), h = d.el = null);
        }
        function r(n) {
            var i = t('<div class="fc-' + n + '"/>'), r = e.options, s = r.header[n];
            return s && t.each(s.split(" "), function(n) {
                var s, o = t(), l = !0;
                t.each(this.split(","), function(n, i) {
                    var s, a, u, c, d, h, p, v, m, y;
                    "title" == i ? (o = o.add(t("")), l = !1) :((s = (r.customButtons || {})[i]) ? (u = function(t) {
                        s.click && s.click.call(y[0], t);
                    }, c = "", d = s.text) :(a = e.getViewSpec(i)) ? (u = function() {
                        e.changeView(i);
                    }, g.push(i), c = a.buttonTextOverride, d = a.buttonTextDefault) :e[i] && (u = function() {
                        e[i]();
                    }, c = (e.overrides.buttonText || {})[i], d = r.buttonText[i]), u && (h = s ? s.themeIcon :r.themeButtonIcons[i],
                        p = s ? s.icon :r.buttonIcons[i], v = c ? tt(c) :h && r.theme ? "<span class='ui-icon ui-icon-" + h + "'></span>" :p && !r.theme ? "<span class='fc-icon fc-icon-" + p + "'></span>" :tt(d),
                        m = [ "fc-" + i + "-button", f + "-button", f + "-state-default" ], y = t('<button type="button" class="' + m.join(" ") + '">' + v + "</button>").click(function(t) {
                        y.hasClass(f + "-state-disabled") || (u(t), (y.hasClass(f + "-state-active") || y.hasClass(f + "-state-disabled")) && y.removeClass(f + "-state-hover"));
                    }).mousedown(function() {
                        y.not("." + f + "-state-active").not("." + f + "-state-disabled").addClass(f + "-state-down");
                    }).mouseup(function() {
                        y.removeClass(f + "-state-down");
                    }).hover(function() {
                        y.not("." + f + "-state-active").not("." + f + "-state-disabled").addClass(f + "-state-hover");
                    }, function() {
                        y.removeClass(f + "-state-hover").removeClass(f + "-state-down");
                    }), o = o.add(y)));
                }), l && o.first().addClass(f + "-corner-left").end().last().addClass(f + "-corner-right").end(),
                    o.length > 1 ? (s = t("<div/>"), l && s.addClass("fc-button-group"), s.append(o),
                        i.append(s)) :i.append(o);
            }), i;
        }
        function s(t) {
            h && h.find(".fc-center").text(t);
        }
        function o(t) {
            h && h.find(".fc-" + t + "-button").addClass(f + "-state-active");
        }
        function l(t) {
            h && h.find(".fc-" + t + "-button").removeClass(f + "-state-active");
        }
        function a(t) {
            h && h.find(".fc-" + t + "-button").prop("disabled", !0).addClass(f + "-state-disabled");
        }
        function u(t) {
            h && h.find(".fc-" + t + "-button").prop("disabled", !1).removeClass(f + "-state-disabled");
        }
        function c() {
            return g;
        }
        var d = this;
        d.render = n, d.removeElement = i, d.updateTitle = s, d.activateButton = o, d.deactivateButton = l,
            d.disableButton = a, d.enableButton = u, d.getViewsWithButtons = c, d.el = null;
        var h, f, g = [];
    }
    function Yt() {
        function n(t, e) {
            return !A || t < A || e > V;
        }
        function i(t, e) {
            A = t, V = e, r(Y, "reset");
        }
        function r(t, e) {
            var n, i;
            for ("reset" === e ? j = [] :"add" !== e && (j = w(j, t)), n = 0; n < t.length; n++) i = t[n],
            "pending" !== i._status && W++, i._fetchId = (i._fetchId || 0) + 1, i._status = "pending";
            for (n = 0; n < t.length; n++) i = t[n], s(i, i._fetchId);
        }
        function s(e, n) {
            a(e, function(i) {
                var r, s, o, a = t.isArray(e.events);
                if (n === e._fetchId && "rejected" !== e._status) {
                    if (e._status = "resolved", i) for (r = 0; r < i.length; r++) s = i[r], o = a ? s :R(s, e),
                    o && j.push.apply(j, M(o));
                    l();
                }
            });
        }
        function o(t) {
            var e = "pending" === t._status;
            t._status = "rejected", e && l();
        }
        function l() {
            W--, W || P(j);
        }
        function a(e, n) {
            var i, r, s = jt.sourceFetchers;
            for (i = 0; i < s.length; i++) {
                if (r = s[i].call(F, e, A.clone(), V.clone(), F.options.timezone, n), r === !0) return;
                if ("object" == typeof r) return void a(r, n);
            }
            var o = e.events;
            if (o) t.isFunction(o) ? (F.pushLoading(), o.call(F, A.clone(), V.clone(), F.options.timezone, function(t) {
                n(t), F.popLoading();
            })) :t.isArray(o) ? n(o) :n(); else {
                var l = e.url;
                if (l) {
                    var u, c = e.success, d = e.error, h = e.complete;
                    u = t.isFunction(e.data) ? e.data() :e.data;
                    var f = t.extend({}, u || {}), g = J(e.startParam, F.options.startParam), p = J(e.endParam, F.options.endParam), v = J(e.timezoneParam, F.options.timezoneParam);
                    g && (f[g] = A.format()), p && (f[p] = V.format()), F.options.timezone && "local" != F.options.timezone && (f[v] = F.options.timezone),
                        F.pushLoading(), t.ajax(t.extend({}, He, e, {
                        data:f,
                        success:function(e) {
                            e = e || [];
                            var i = Q(c, this, arguments);
                            t.isArray(i) && (e = i), n(e);
                        },
                        error:function() {
                            Q(d, this, arguments), n();
                        },
                        complete:function() {
                            Q(h, this, arguments), F.popLoading();
                        }
                    }));
                } else n();
            }
        }
        function u(t) {
            var e = c(t);
            e && (Y.push(e), r([ e ], "add"));
        }
        function c(e) {
            var n, i, r = jt.sourceNormalizers;
            if (t.isFunction(e) || t.isArray(e) ? n = {
                    events:e
                } :"string" == typeof e ? n = {
                    url:e
                } :"object" == typeof e && (n = t.extend({}, e)), n) {
                for (n.className ? "string" == typeof n.className && (n.className = n.className.split(/\s+/)) :n.className = [],
                     t.isArray(n.events) && (n.origArray = n.events, n.events = t.map(n.events, function(t) {
                         return R(t, n);
                     })), i = 0; i < r.length; i++) r[i].call(F, n);
                return n;
            }
        }
        function d(t) {
            f(m(t));
        }
        function h(t) {
            null == t ? f(Y, !0) :f(v(t));
        }
        function f(e, n) {
            var i;
            for (i = 0; i < e.length; i++) o(e[i]);
            n ? (Y = [], j = []) :(Y = t.grep(Y, function(t) {
                for (i = 0; i < e.length; i++) if (t === e[i]) return !1;
                return !0;
            }), j = w(j, e)), P(j);
        }
        function g() {
            return Y.slice(1);
        }
        function p(e) {
            return t.grep(Y, function(t) {
                return t.id && t.id === e;
            })[0];
        }
        function v(e) {
            e ? t.isArray(e) || (e = [ e ]) :e = [];
            var n, i = [];
            for (n = 0; n < e.length; n++) i.push.apply(i, m(e[n]));
            return i;
        }
        function m(e) {
            var n, i;
            for (n = 0; n < Y.length; n++) if (i = Y[n], i === e) return [ i ];
            return i = p(e), i ? [ i ] :t.grep(Y, function(t) {
                return y(e, t);
            });
        }
        function y(t, e) {
            return t && e && S(t) == S(e);
        }
        function S(t) {
            return ("object" == typeof t ? t.origArray || t.googleCalendarId || t.url || t.events :null) || t;
        }
        function w(e, n) {
            return t.grep(e, function(t) {
                for (var e = 0; e < n.length; e++) if (t.source === n[e]) return !1;
                return !0;
            });
        }
        function E(t) {
            t.start = F.moment(t.start), t.end ? t.end = F.moment(t.end) :t.end = null, z(t, b(t)),
                P(j);
        }
        function b(e) {
            var n = {};
            return t.each(e, function(t, e) {
                D(t) && void 0 !== e && K(e) && (n[t] = e);
            }), n;
        }
        function D(t) {
            return !/^_|^(id|allDay|start|end)$/.test(t);
        }
        function C(t, e) {
            var n, i, r, s = R(t);
            if (s) {
                for (n = M(s), i = 0; i < n.length; i++) r = n[i], r.source || (e && (_.events.push(r),
                    r.source = _), j.push(r));
                return P(j), n;
            }
            return [];
        }
        function H(e) {
            var n, i;
            for (null == e ? e = function() {
                return !0;
            } :t.isFunction(e) || (n = e + "", e = function(t) {
                return t._id == n;
            }), j = t.grep(j, e, !0), i = 0; i < Y.length; i++) t.isArray(Y[i].events) && (Y[i].events = t.grep(Y[i].events, e, !0));
            P(j);
        }
        function T(e) {
            return t.isFunction(e) ? t.grep(j, e) :null != e ? (e += "", t.grep(j, function(t) {
                return t._id == e;
            })) :j;
        }
        function x(t) {
            t.start = F.moment(t.start), t.end && (t.end = F.moment(t.end)), Wt(t);
        }
        function R(n, i) {
            var r, s, o, l = {};
            if (F.options.eventDataTransform && (n = F.options.eventDataTransform(n)), i && i.eventDataTransform && (n = i.eventDataTransform(n)),
                    t.extend(l, n), i && (l.source = i), l._id = n._id || (void 0 === n.id ? "_fc" + Te++ :n.id + ""),
                    n.className ? "string" == typeof n.className ? l.className = n.className.split(/\s+/) :l.className = n.className :l.className = [],
                    r = n.start || n.date, s = n.end, U(r) && (r = e.duration(r)), U(s) && (s = e.duration(s)),
                n.dow || e.isDuration(r) || e.isDuration(s)) l.start = r ? e.duration(r) :null,
                l.end = s ? e.duration(s) :null, l._recurring = !0; else {
                if (r && (r = F.moment(r), !r.isValid())) return !1;
                s && (s = F.moment(s), s.isValid() || (s = null)), o = n.allDay, void 0 === o && (o = J(i ? i.allDayDefault :void 0, F.options.allDayDefault)),
                    I(r, s, o, l);
            }
            return F.normalizeEvent(l), l;
        }
        function I(t, e, n, i) {
            i.start = t, i.end = e, i.allDay = n, k(i), Wt(i);
        }
        function k(t) {
            L(t), t.end && !t.end.isAfter(t.start) && (t.end = null), t.end || (F.options.forceEventDuration ? t.end = F.getDefaultEventEnd(t.allDay, t.start) :t.end = null);
        }
        function L(t) {
            null == t.allDay && (t.allDay = !(t.start.hasTime() || t.end && t.end.hasTime())),
                t.allDay ? (t.start.stripTime(), t.end && t.end.stripTime()) :(t.start.hasTime() || (t.start = F.applyTimezone(t.start.time(0))),
                t.end && !t.end.hasTime() && (t.end = F.applyTimezone(t.end.time(0))));
        }
        function M(e, n, i) {
            var r, s, o, l, a, u, c, d, h, f = [];
            if (n = n || A, i = i || V, e) if (e._recurring) {
                if (s = e.dow) for (r = {}, o = 0; o < s.length; o++) r[s[o]] = !0;
                for (l = n.clone().stripTime(); l.isBefore(i); ) r && !r[l.day()] || (a = e.start,
                    u = e.end, c = l.clone(), d = null, a && (c = c.time(a)), u && (d = l.clone().time(u)),
                    h = t.extend({}, e), I(c, d, !a && !u, h), f.push(h)), l.add(1, "days");
            } else f.push(e);
            return f;
        }
        function z(e, n, i) {
            function r(t, e) {
                return i ? O(t, e, i) :n.allDay ? G(t, e) :N(t, e);
            }
            var s, o, l, a, u, c, d = {};
            return n = n || {}, n.start || (n.start = e.start.clone()), void 0 === n.end && (n.end = e.end ? e.end.clone() :null),
            null == n.allDay && (n.allDay = e.allDay), k(n), s = {
                start:e._start.clone(),
                end:e._end ? e._end.clone() :F.getDefaultEventEnd(e._allDay, e._start),
                allDay:n.allDay
            }, k(s), o = null !== e._end && null === n.end, l = r(n.start, s.start), n.end ? (a = r(n.end, s.end),
                u = a.subtract(l)) :u = null, t.each(n, function(t, e) {
                D(t) && void 0 !== e && (d[t] = e);
            }), c = B(T(e._id), o, n.allDay, l, u, d), {
                dateDelta:l,
                durationDelta:u,
                undo:c
            };
        }
        function B(e, n, i, r, s, o) {
            var l = F.getIsAmbigTimezone(), a = [];
            return r && !r.valueOf() && (r = null), s && !s.valueOf() && (s = null), t.each(e, function(e, u) {
                var c, d;
                c = {
                    start:u.start.clone(),
                    end:u.end ? u.end.clone() :null,
                    allDay:u.allDay
                }, t.each(o, function(t) {
                    c[t] = u[t];
                }), d = {
                    start:u._start,
                    end:u._end,
                    allDay:i
                }, k(d), n ? d.end = null :s && !d.end && (d.end = F.getDefaultEventEnd(d.allDay, d.start)),
                r && (d.start.add(r), d.end && d.end.add(r)), s && d.end.add(s), l && !d.allDay && (r || s) && (d.start.stripZone(),
                d.end && d.end.stripZone()), t.extend(u, o, d), Wt(u), a.push(function() {
                    t.extend(u, c), Wt(u);
                });
            }), function() {
                for (var t = 0; t < a.length; t++) a[t]();
            };
        }
        var F = this;
        F.isFetchNeeded = n, F.fetchEvents = i, F.fetchEventSources = r, F.getEventSources = g,
            F.getEventSourceById = p, F.getEventSourcesByMatchArray = v, F.getEventSourcesByMatch = m,
            F.addEventSource = u, F.removeEventSource = d, F.removeEventSources = h, F.updateEvent = E,
            F.renderEvent = C, F.removeEvents = H, F.clientEvents = T, F.mutateEvent = z, F.normalizeEventDates = k,
            F.normalizeEventTimes = L;
        var A, V, P = F.reportEvents, _ = {
            events:[]
        }, Y = [ _ ], W = 0, j = [];
        t.each((F.options.events ? [ F.options.events ] :[]).concat(F.options.eventSources || []), function(t, e) {
            var n = c(e);
            n && Y.push(n);
        }), F.rezoneArrayEventSources = function() {
            var e, n, i;
            for (e = 0; e < Y.length; e++) if (n = Y[e].events, t.isArray(n)) for (i = 0; i < n.length; i++) x(n[i]);
        }, F.buildEventFromInput = R, F.expandEvent = M, F.getEventCache = function() {
            return j;
        };
    }
    function Wt(t) {
        t._allDay = t.allDay, t._start = t.start.clone(), t._end = t.end ? t.end.clone() :null;
    }
    var jt = t.fullCalendar = {
        version:"3.0.0",
        internalApiVersion:6
    }, Ut = jt.views = {};
    t.fn.fullCalendar = function(e) {
        var n = Array.prototype.slice.call(arguments, 1), i = this;
        return this.each(function(r, s) {
            var o, l = t(s), a = l.data("fullCalendar");
            "string" == typeof e ? a && t.isFunction(a[e]) && (o = a[e].apply(a, n), r || (i = o),
            "destroy" === e && l.removeData("fullCalendar")) :a || (a = new we(l, e), l.data("fullCalendar", a),
                a.render());
        }), i;
    };
    var qt = [ "header", "buttonText", "buttonIcons", "themeButtonIcons" ];
    jt.intersectRanges = F, jt.applyAll = Q, jt.debounce = at, jt.isInt = ot, jt.htmlEscape = tt,
        jt.cssToStr = nt, jt.proxy = lt, jt.capitaliseFirstLetter = rt, jt.getOuterRect = h,
        jt.getClientRect = f, jt.getContentRect = g, jt.getScrollbarWidths = p;
    var Zt = null;
    jt.preventDefault = C, jt.intersectRects = x, jt.parseFieldSpecs = L, jt.compareByFieldSpecs = M,
        jt.compareByFieldSpec = z, jt.flexibleCompare = B, jt.computeIntervalUnit = A, jt.divideRangeByDuration = P,
        jt.divideDurationByDuration = _, jt.multiplyDuration = Y, jt.durationHasTime = W;
    var $t = [ "sun", "mon", "tue", "wed", "thu", "fri", "sat" ], Xt = [ "year", "month", "week", "day", "hour", "minute", "second", "millisecond" ];
    jt.log = function() {
        var t = window.console;
        if (t && t.log) return t.log.apply(t, arguments);
    }, jt.warn = function() {
        var t = window.console;
        return t && t.warn ? t.warn.apply(t, arguments) :jt.log.apply(jt, arguments);
    };
    var Kt = {}.hasOwnProperty, Qt = /^\s*\d{4}-\d\d$/, Jt = /^\s*\d{4}-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?)?$/, te = e.fn, ee = t.extend({}, te), ne = e.momentProperties;
    ne.push("_fullCalendar"), ne.push("_ambigTime"), ne.push("_ambigZone"), jt.moment = function() {
        return ct(arguments);
    }, jt.moment.utc = function() {
        var t = ct(arguments, !0);
        return t.hasTime() && t.utc(), t;
    }, jt.moment.parseZone = function() {
        return ct(arguments, !0, !0);
    }, te.week = te.weeks = function(t) {
        var e = this._locale._fullCalendar_weekCalc;
        return null == t && "function" == typeof e ? e(this) :"ISO" === e ? ee.isoWeek.apply(this, arguments) :ee.week.apply(this, arguments);
    }, te.time = function(t) {
        if (!this._fullCalendar) return ee.time.apply(this, arguments);
        if (null == t) return e.duration({
            hours:this.hours(),
            minutes:this.minutes(),
            seconds:this.seconds(),
            milliseconds:this.milliseconds()
        });
        this._ambigTime = !1, e.isDuration(t) || e.isMoment(t) || (t = e.duration(t));
        var n = 0;
        return e.isDuration(t) && (n = 24 * Math.floor(t.asDays())), this.hours(n + t.hours()).minutes(t.minutes()).seconds(t.seconds()).milliseconds(t.milliseconds());
    }, te.stripTime = function() {
        return this._ambigTime || (this.utc(!0), this.set({
            hours:0,
            minutes:0,
            seconds:0,
            ms:0
        }), this._ambigTime = !0, this._ambigZone = !0), this;
    }, te.hasTime = function() {
        return !this._ambigTime;
    }, te.stripZone = function() {
        var t;
        return this._ambigZone || (t = this._ambigTime, this.utc(!0), this._ambigTime = t || !1,
            this._ambigZone = !0), this;
    }, te.hasZone = function() {
        return !this._ambigZone;
    }, te.local = function(t) {
        return ee.local.call(this, this._ambigZone || t), this._ambigTime = !1, this._ambigZone = !1,
            this;
    }, te.utc = function(t) {
        return ee.utc.call(this, t), this._ambigTime = !1, this._ambigZone = !1, this;
    }, te.utcOffset = function(t) {
        return null != t && (this._ambigTime = !1, this._ambigZone = !1), ee.utcOffset.apply(this, arguments);
    }, te.format = function() {
        return this._fullCalendar && arguments[0] ? ht(this, arguments[0]) :this._ambigTime ? dt(this, "YYYY-MM-DD") :this._ambigZone ? dt(this, "YYYY-MM-DD[T]HH:mm:ss") :ee.format.apply(this, arguments);
    }, te.toISOString = function() {
        return this._ambigTime ? dt(this, "YYYY-MM-DD") :this._ambigZone ? dt(this, "YYYY-MM-DD[T]HH:mm:ss") :ee.toISOString.apply(this, arguments);
    };
    var ie = {
        t:function(t) {
            return dt(t, "a").charAt(0);
        },
        T:function(t) {
            return dt(t, "A").charAt(0);
        }
    };
    jt.formatRange = pt;
    var re = {
        Y:"year",
        M:"month",
        D:"day",
        d:"day",
        A:"second",
        a:"second",
        T:"second",
        t:"second",
        H:"second",
        h:"second",
        m:"second",
        s:"second"
    }, se = {};
    jt.Class = wt, wt.extend = function() {
        var t, e, n = arguments.length;
        for (t = 0; t < n; t++) e = arguments[t], t < n - 1 && bt(this, e);
        return Et(this, e || {});
    }, wt.mixin = function(t) {
        bt(this, t);
    };
    var oe = jt.EmitterMixin = {
        on:function(e, n) {
            var i = function(t, e) {
                return n.apply(e.context || this, e.args || []);
            };
            return n.guid || (n.guid = t.guid++), i.guid = n.guid, t(this).on(e, i), this;
        },
        off:function(e, n) {
            return t(this).off(e, n), this;
        },
        trigger:function(e) {
            var n = Array.prototype.slice.call(arguments, 1);
            return t(this).triggerHandler(e, {
                args:n
            }), this;
        },
        triggerWith:function(e, n, i) {
            return t(this).triggerHandler(e, {
                context:n,
                args:i
            }), this;
        }
    }, le = jt.ListenerMixin = function() {
        var e = 0, n = {
            listenerId:null,
            listenTo:function(e, n, i) {
                if ("object" == typeof n) for (var r in n) n.hasOwnProperty(r) && this.listenTo(e, r, n[r]); else "string" == typeof n && e.on(n + "." + this.getListenerNamespace(), t.proxy(i, this));
            },
            stopListeningTo:function(t, e) {
                t.off((e || "") + "." + this.getListenerNamespace());
            },
            getListenerNamespace:function() {
                return null == this.listenerId && (this.listenerId = e++), "_listener" + this.listenerId;
            }
        };
        return n;
    }(), ae = {
        isIgnoringMouse:!1,
        delayUnignoreMouse:null,
        initMouseIgnoring:function(t) {
            this.delayUnignoreMouse = at(lt(this, "unignoreMouse"), t || 1e3);
        },
        tempIgnoreMouse:function() {
            this.isIgnoringMouse = !0, this.delayUnignoreMouse();
        },
        unignoreMouse:function() {
            this.isIgnoringMouse = !1;
        }
    }, ue = wt.extend(le, {
        isHidden:!0,
        options:null,
        el:null,
        margin:10,
        constructor:function(t) {
            this.options = t || {};
        },
        show:function() {
            this.isHidden && (this.el || this.render(), this.el.show(), this.position(), this.isHidden = !1,
                this.trigger("show"));
        },
        hide:function() {
            this.isHidden || (this.el.hide(), this.isHidden = !0, this.trigger("hide"));
        },
        render:function() {
            var e = this, n = this.options;
            this.el = t('<div class="fc-popover"/>').addClass(n.className || "").css({
                top:0,
                left:0
            }).append(n.content).appendTo(n.parentEl), this.el.on("click", ".fc-close", function() {
                e.hide();
            }), n.autoHide && this.listenTo(t(document), "mousedown", this.documentMousedown);
        },
        documentMousedown:function(e) {
            this.el && !t(e.target).closest(this.el).length && this.hide();
        },
        removeElement:function() {
            this.hide(), this.el && (this.el.remove(), this.el = null), this.stopListeningTo(t(document), "mousedown");
        },
        position:function() {
            var e, n, i, r, s, o = this.options, l = this.el.offsetParent().offset(), a = this.el.outerWidth(), u = this.el.outerHeight(), c = t(window), h = d(this.el);
            r = o.top || 0, s = void 0 !== o.left ? o.left :void 0 !== o.right ? o.right - a :0,
                h.is(window) || h.is(document) ? (h = c, e = 0, n = 0) :(i = h.offset(), e = i.top,
                    n = i.left), e += c.scrollTop(), n += c.scrollLeft(), o.viewportConstrain !== !1 && (r = Math.min(r, e + h.outerHeight() - u - this.margin),
                r = Math.max(r, e + this.margin), s = Math.min(s, n + h.outerWidth() - a - this.margin),
                s = Math.max(s, n + this.margin)), this.el.css({
                top:r - l.top,
                left:s - l.left
            });
        },
        trigger:function(t) {
            this.options[t] && this.options[t].apply(this, Array.prototype.slice.call(arguments, 1));
        }
    }), ce = jt.CoordCache = wt.extend({
        els:null,
        forcedOffsetParentEl:null,
        origin:null,
        boundingRect:null,
        isHorizontal:!1,
        isVertical:!1,
        lefts:null,
        rights:null,
        tops:null,
        bottoms:null,
        constructor:function(e) {
            this.els = t(e.els), this.isHorizontal = e.isHorizontal, this.isVertical = e.isVertical,
                this.forcedOffsetParentEl = e.offsetParent ? t(e.offsetParent) :null;
        },
        build:function() {
            var t = this.forcedOffsetParentEl || this.els.eq(0).offsetParent();
            this.origin = t.offset(), this.boundingRect = this.queryBoundingRect(), this.isHorizontal && this.buildElHorizontals(),
            this.isVertical && this.buildElVerticals();
        },
        clear:function() {
            this.origin = null, this.boundingRect = null, this.lefts = null, this.rights = null,
                this.tops = null, this.bottoms = null;
        },
        ensureBuilt:function() {
            this.origin || this.build();
        },
        buildElHorizontals:function() {
            var e = [], n = [];
            this.els.each(function(i, r) {
                var s = t(r), o = s.offset().left, l = s.outerWidth();
                e.push(o), n.push(o + l);
            }), this.lefts = e, this.rights = n;
        },
        buildElVerticals:function() {
            var e = [], n = [];
            this.els.each(function(i, r) {
                var s = t(r), o = s.offset().top, l = s.outerHeight();
                e.push(o), n.push(o + l);
            }), this.tops = e, this.bottoms = n;
        },
        getHorizontalIndex:function(t) {
            this.ensureBuilt();
            var e, n = this.lefts, i = this.rights, r = n.length;
            for (e = 0; e < r; e++) if (t >= n[e] && t < i[e]) return e;
        },
        getVerticalIndex:function(t) {
            this.ensureBuilt();
            var e, n = this.tops, i = this.bottoms, r = n.length;
            for (e = 0; e < r; e++) if (t >= n[e] && t < i[e]) return e;
        },
        getLeftOffset:function(t) {
            return this.ensureBuilt(), this.lefts[t];
        },
        getLeftPosition:function(t) {
            return this.ensureBuilt(), this.lefts[t] - this.origin.left;
        },
        getRightOffset:function(t) {
            return this.ensureBuilt(), this.rights[t];
        },
        getRightPosition:function(t) {
            return this.ensureBuilt(), this.rights[t] - this.origin.left;
        },
        getWidth:function(t) {
            return this.ensureBuilt(), this.rights[t] - this.lefts[t];
        },
        getTopOffset:function(t) {
            return this.ensureBuilt(), this.tops[t];
        },
        getTopPosition:function(t) {
            return this.ensureBuilt(), this.tops[t] - this.origin.top;
        },
        getBottomOffset:function(t) {
            return this.ensureBuilt(), this.bottoms[t];
        },
        getBottomPosition:function(t) {
            return this.ensureBuilt(), this.bottoms[t] - this.origin.top;
        },
        getHeight:function(t) {
            return this.ensureBuilt(), this.bottoms[t] - this.tops[t];
        },
        queryBoundingRect:function() {
            var t = d(this.els.eq(0));
            if (!t.is(document)) return f(t);
        },
        isPointInBounds:function(t, e) {
            return this.isLeftInBounds(t) && this.isTopInBounds(e);
        },
        isLeftInBounds:function(t) {
            return !this.boundingRect || t >= this.boundingRect.left && t < this.boundingRect.right;
        },
        isTopInBounds:function(t) {
            return !this.boundingRect || t >= this.boundingRect.top && t < this.boundingRect.bottom;
        }
    }), de = jt.DragListener = wt.extend(le, ae, {
        options:null,
        subjectEl:null,
        originX:null,
        originY:null,
        scrollEl:null,
        isInteracting:!1,
        isDistanceSurpassed:!1,
        isDelayEnded:!1,
        isDragging:!1,
        isTouch:!1,
        delay:null,
        delayTimeoutId:null,
        minDistance:null,
        handleTouchScrollProxy:null,
        constructor:function(t) {
            this.options = t || {}, this.handleTouchScrollProxy = lt(this, "handleTouchScroll"),
                this.initMouseIgnoring(500);
        },
        startInteraction:function(e, n) {
            var i = b(e);
            if ("mousedown" === e.type) {
                if (this.isIgnoringMouse) return;
                if (!S(e)) return;
                e.preventDefault();
            }
            this.isInteracting || (n = n || {}, this.delay = J(n.delay, this.options.delay, 0),
                this.minDistance = J(n.distance, this.options.distance, 0), this.subjectEl = this.options.subjectEl,
                this.isInteracting = !0, this.isTouch = i, this.isDelayEnded = !1, this.isDistanceSurpassed = !1,
                this.originX = w(e), this.originY = E(e), this.scrollEl = d(t(e.target)), this.bindHandlers(),
                this.initAutoScroll(), this.handleInteractionStart(e), this.startDelay(e), this.minDistance || this.handleDistanceSurpassed(e));
        },
        handleInteractionStart:function(t) {
            this.trigger("interactionStart", t);
        },
        endInteraction:function(t, e) {
            this.isInteracting && (this.endDrag(t), this.delayTimeoutId && (clearTimeout(this.delayTimeoutId),
                this.delayTimeoutId = null), this.destroyAutoScroll(), this.unbindHandlers(), this.isInteracting = !1,
                this.handleInteractionEnd(t, e), this.isTouch && this.tempIgnoreMouse());
        },
        handleInteractionEnd:function(t, e) {
            this.trigger("interactionEnd", t, e || !1);
        },
        bindHandlers:function() {
            var e = this, n = 1;
            this.isTouch ? (this.listenTo(t(document), {
                touchmove:this.handleTouchMove,
                touchend:this.endInteraction,
                touchcancel:this.endInteraction,
                touchstart:function(t) {
                    n ? n-- :e.endInteraction(t, !0);
                }
            }), !H(this.handleTouchScrollProxy) && this.scrollEl && this.listenTo(this.scrollEl, "scroll", this.handleTouchScroll)) :this.listenTo(t(document), {
                mousemove:this.handleMouseMove,
                mouseup:this.endInteraction
            }), this.listenTo(t(document), {
                selectstart:C,
                contextmenu:C
            });
        },
        unbindHandlers:function() {
            this.stopListeningTo(t(document)), T(this.handleTouchScrollProxy), this.scrollEl && this.stopListeningTo(this.scrollEl, "scroll");
        },
        startDrag:function(t, e) {
            this.startInteraction(t, e),
            this.isDragging || (this.isDragging = !0, this.handleDragStart(t));
        },
        handleDragStart:function(t) {
            this.trigger("dragStart", t);
        },
        handleMove:function(t) {
            var e,
                n = w(t) - this.originX,
                i = E(t) - this.originY,
                r = this.minDistance;
            this.isDistanceSurpassed || (e = n * n + i * i, e >= r * r && this.handleDistanceSurpassed(t));
            this.isDragging && this.handleDrag(n, i, t);
        },
        handleDrag:function(t, e, n) {
            this.trigger("drag", t, e, n);
            this.updateAutoScroll(n);
        },
        endDrag:function(t) {
            this.isDragging && (this.isDragging = !1, this.handleDragEnd(t));
        },
        handleDragEnd:function(t) {
            this.trigger("dragEnd", t);
        },
        startDelay:function(t) {
            var e = this;
            this.delay ? this.delayTimeoutId = setTimeout(function() {
                e.handleDelayEnd(t);
            }, this.delay) :this.handleDelayEnd(t);
        },
        handleDelayEnd:function(t) {
            this.isDelayEnded = !0, this.isDistanceSurpassed && this.startDrag(t);
        },
        handleDistanceSurpassed:function(t) {
            this.isDistanceSurpassed = !0, this.isDelayEnded && this.startDrag(t);
        },
        handleTouchMove:function(t) {
            this.isDragging && t.preventDefault(), this.handleMove(t);
        },
        handleMouseMove:function(t) {
            this.handleMove(t);
        },
        handleTouchScroll:function(t) {
            this.isDragging || this.endInteraction(t, !0);
        },
        trigger:function(t) {
            this.options[t] && this.options[t].apply(this, Array.prototype.slice.call(arguments, 1)),
            this["_" + t] && this["_" + t].apply(this, Array.prototype.slice.call(arguments, 1));
        }
    });
    de.mixin({
        isAutoScroll:!1,
        scrollBounds:null,
        scrollTopVel:null,
        scrollLeftVel:null,
        scrollIntervalId:null,
        scrollSensitivity:30,
        scrollSpeed:200,
        scrollIntervalMs:50,
        initAutoScroll:function() {
            var t = this.scrollEl;
            this.isAutoScroll = this.options.scroll && t && !t.is(window) && !t.is(document),
            this.isAutoScroll && this.listenTo(t, "scroll", at(this.handleDebouncedScroll, 100));
        },
        destroyAutoScroll:function() {
            this.endAutoScroll(), this.isAutoScroll && this.stopListeningTo(this.scrollEl, "scroll");
        },
        computeScrollBounds:function() {
            this.isAutoScroll && (this.scrollBounds = h(this.scrollEl));
        },
        updateAutoScroll:function(t) {
            var e, n, i, r, s = this.scrollSensitivity, o = this.scrollBounds, l = 0, a = 0;
            o && (e = (s - (E(t) - o.top)) / s, n = (s - (o.bottom - E(t))) / s, i = (s - (w(t) - o.left)) / s,
                r = (s - (o.right - w(t))) / s, e >= 0 && e <= 1 ? l = e * this.scrollSpeed * -1 :n >= 0 && n <= 1 && (l = n * this.scrollSpeed),
                i >= 0 && i <= 1 ? a = i * this.scrollSpeed * -1 :r >= 0 && r <= 1 && (a = r * this.scrollSpeed)),
                this.setScrollVel(l, a);
        },
        setScrollVel:function(t, e) {
            this.scrollTopVel = t, this.scrollLeftVel = e, this.constrainScrollVel(), !this.scrollTopVel && !this.scrollLeftVel || this.scrollIntervalId || (this.scrollIntervalId = setInterval(lt(this, "scrollIntervalFunc"), this.scrollIntervalMs));
        },
        constrainScrollVel:function() {
            var t = this.scrollEl;
            this.scrollTopVel < 0 ? t.scrollTop() <= 0 && (this.scrollTopVel = 0) :this.scrollTopVel > 0 && t.scrollTop() + t[0].clientHeight >= t[0].scrollHeight && (this.scrollTopVel = 0),
                this.scrollLeftVel < 0 ? t.scrollLeft() <= 0 && (this.scrollLeftVel = 0) :this.scrollLeftVel > 0 && t.scrollLeft() + t[0].clientWidth >= t[0].scrollWidth && (this.scrollLeftVel = 0);
        },
        scrollIntervalFunc:function() {
            var t = this.scrollEl, e = this.scrollIntervalMs / 1e3;
            this.scrollTopVel && t.scrollTop(t.scrollTop() + this.scrollTopVel * e), this.scrollLeftVel && t.scrollLeft(t.scrollLeft() + this.scrollLeftVel * e),
                this.constrainScrollVel(), this.scrollTopVel || this.scrollLeftVel || this.endAutoScroll();
        },
        endAutoScroll:function() {
            this.scrollIntervalId && (clearInterval(this.scrollIntervalId), this.scrollIntervalId = null,
                this.handleScrollEnd());
        },
        handleDebouncedScroll:function() {
            this.scrollIntervalId || this.handleScrollEnd();
        },
        handleScrollEnd:function() {}
    });
    var he = de.extend({
        component:null,
        origHit:null,
        hit:null,
        coordAdjust:null,
        constructor:function(t, e) {
            de.call(this, e), this.component = t;
        },
        handleInteractionStart:function(t) {
            var e, n, i, r = this.subjectEl;
            this.computeCoords(), t ? (n = {
                left:w(t),
                top:E(t)
            }, i = n, r && (e = h(r), i = R(i, e)), this.origHit = this.queryHit(i.left, i.top),
            r && this.options.subjectCenter && (this.origHit && (e = x(this.origHit, e) || e),
                i = I(e)), this.coordAdjust = k(i, n)) :(this.origHit = null, this.coordAdjust = null),
                de.prototype.handleInteractionStart.apply(this, arguments);
        },
        computeCoords:function() {
            this.component.prepareHits(), this.computeScrollBounds();
        },
        handleDragStart:function(t) {
            var e;
            de.prototype.handleDragStart.apply(this, arguments), e = this.queryHit(w(t), E(t)),
            e && this.handleHitOver(e);
        },
        handleDrag:function(t, e, n) {
            var i;
            de.prototype.handleDrag.apply(this, arguments),
                i = this.queryHit(w(n), E(n)),
            Dt(i, this.hit) || (this.hit && this.handleHitOut(), i && this.handleHitOver(i));
        },
        handleDragEnd:function() {
            this.handleHitDone(), de.prototype.handleDragEnd.apply(this, arguments);
        },
        handleHitOver:function(t) {
            var e = Dt(t, this.origHit);
            this.hit = t, this.trigger("hitOver", this.hit, e, this.origHit);
        },
        handleHitOut:function() {
            this.hit && (this.trigger("hitOut", this.hit), this.handleHitDone(), this.hit = null);
        },
        handleHitDone:function() {
            this.hit && this.trigger("hitDone", this.hit);
        },
        handleInteractionEnd:function() {
            de.prototype.handleInteractionEnd.apply(this, arguments), this.origHit = null, this.hit = null,
                this.component.releaseHits();
        },
        handleScrollEnd:function() {
            de.prototype.handleScrollEnd.apply(this, arguments), this.computeCoords();
        },
        queryHit:function(t, e) {
            return this.coordAdjust && (t += this.coordAdjust.left, e += this.coordAdjust.top),
                this.component.queryHit(t, e);
        }
    }), fe = wt.extend(le, {
        options:null,
        sourceEl:null,
        el:null,
        parentEl:null,
        top0:null,
        left0:null,
        y0:null,
        x0:null,
        topDelta:null,
        leftDelta:null,
        isFollowing:!1,
        isHidden:!1,
        isAnimating:!1,
        constructor:function(e, n) {
            this.options = n = n || {}, this.sourceEl = e, this.parentEl = n.parentEl ? t(n.parentEl) :e.parent();
        },
        start:function(e) {
            this.isFollowing || (this.isFollowing = !0, this.y0 = E(e), this.x0 = w(e), this.topDelta = 0,
                this.leftDelta = 0, this.isHidden || this.updatePosition(), b(e) ? this.listenTo(t(document), "touchmove", this.handleMove) :this.listenTo(t(document), "mousemove", this.handleMove));
        },
        stop:function(e, n) {
            function i() {
                r.isAnimating = !1, r.removeElement(), r.top0 = r.left0 = null, n && n();
            }
            var r = this, s = this.options.revertDuration;
            this.isFollowing && !this.isAnimating && (this.isFollowing = !1, this.stopListeningTo(t(document)),
                e && s && !this.isHidden ? (this.isAnimating = !0, this.el.animate({
                    top:this.top0,
                    left:this.left0
                }, {
                    duration:s,
                    complete:i
                })) :i());
        },
        getEl:function() {
            var t = this.el;
            return t || (t = this.el = this.sourceEl.clone().addClass(this.options.additionalClass || "").css({
                position:"absolute",
                visibility:"",
                display:this.isHidden ? "none" :"",
                margin:0,
                right:"auto",
                bottom:"auto",
                width:this.sourceEl.width(),
                height:this.sourceEl.height(),
                opacity:this.options.opacity || "",
                zIndex:this.options.zIndex
            }), t.addClass("fc-unselectable"), t.appendTo(this.parentEl)), t;
        },
        removeElement:function() {
            this.el && (this.el.remove(), this.el = null);
        },
        updatePosition:function() {
            var t, e;
            this.getEl(), null === this.top0 && (t = this.sourceEl.offset(), e = this.el.offsetParent().offset(),
                this.top0 = t.top - e.top, this.left0 = t.left - e.left), this.el.css({
                top:this.top0 + this.topDelta,
                left:this.left0 + this.leftDelta
            });
        },
        handleMove:function(t) {
            this.topDelta = E(t) - this.y0, this.leftDelta = w(t) - this.x0, this.isHidden || this.updatePosition();
        },
        hide:function() {
            this.isHidden || (this.isHidden = !0, this.el && this.el.hide());
        },
        show:function() {
            this.isHidden && (this.isHidden = !1, this.updatePosition(), this.getEl().show());
        }
    }), ge = jt.Grid = wt.extend(le, ae, {
        hasDayInteractions:!0,
        view:null,
        isRTL:null,
        start:null,
        end:null,
        el:null,
        elsByFill:null,
        eventTimeFormat:null,
        displayEventTime:null,
        displayEventEnd:null,
        minResizeDuration:null,
        largeUnit:null,
        dayDragListener:null,
        segDragListener:null,
        segResizeListener:null,
        externalDragListener:null,
        constructor:function(t) {
            this.view = t, this.isRTL = t.opt("isRTL"), this.elsByFill = {}, this.dayDragListener = this.buildDayDragListener(),
                this.initMouseIgnoring();
        },
        computeEventTimeFormat:function() {
            return this.view.opt("smallTimeFormat");
        },
        computeDisplayEventTime:function() {
            return !0;
        },
        computeDisplayEventEnd:function() {
            return !0;
        },
        setRange:function(t) {
            this.start = t.start.clone(), this.end = t.end.clone(), this.rangeUpdated(), this.processRangeOptions();
        },
        rangeUpdated:function() {},
        processRangeOptions:function() {
            var t, e, n = this.view;
            this.eventTimeFormat = n.opt("eventTimeFormat") || n.opt("timeFormat") || this.computeEventTimeFormat(),
                t = n.opt("displayEventTime"), null == t && (t = this.computeDisplayEventTime()),
                e = n.opt("displayEventEnd"), null == e && (e = this.computeDisplayEventEnd()),
                this.displayEventTime = t, this.displayEventEnd = e;
        },
        spanToSegs:function(t) {},
        diffDates:function(t, e) {
            return this.largeUnit ? O(t, e, this.largeUnit) :N(t, e);
        },
        prepareHits:function() {},
        releaseHits:function() {},
        queryHit:function(t, e) {},
        getHitSpan:function(t) {},
        getHitEl:function(t) {},
        setElement:function(t) {
            this.el = t, this.hasDayInteractions && (D(t), this.bindDayHandler("touchstart", this.dayTouchStart),
                this.bindDayHandler("mousedown", this.dayMousedown)), this.bindSegHandlers(), this.bindGlobalHandlers();
        },
        bindDayHandler:function(e, n) {
            var i = this;
            this.el.on(e, function(e) {
                if (!t(e.target).is(i.segSelector + "," + i.segSelector + " *,.fc-more,a[data-goto]")) return n.call(i, e);
            });
        },
        removeElement:function() {
            this.unbindGlobalHandlers(), this.clearDragListeners(), this.el.remove();
        },
        renderSkeleton:function() {},
        renderDates:function() {},
        unrenderDates:function() {},
        bindGlobalHandlers:function() {
            this.listenTo(t(document), {
                dragstart:this.externalDragStart,
                sortstart:this.externalDragStart
            });
        },
        unbindGlobalHandlers:function() {
            this.stopListeningTo(t(document));
        },
        dayMousedown:function(t) {
            this.isIgnoringMouse || this.dayDragListener.startInteraction(t, {});
        },
        dayTouchStart:function(t) {
            var e = this.view;
            (e.isSelected || e.selectedEvent) && this.tempIgnoreMouse(), this.dayDragListener.startInteraction(t, {
                delay:this.view.opt("longPressDelay")
            });
        },
        buildDayDragListener:function() {
            var t, e, n = this, i = this.view, r = i.opt("selectable"), l = new he(this, {
                scroll:i.opt("dragScroll"),
                interactionStart:function() {
                    t = l.origHit, e = null;
                },
                dragStart:function() {
                    i.unselect();
                },
                hitOver:function(i, o, l) {
                    l && (o || (t = null), r && (e = n.computeSelection(n.getHitSpan(l), n.getHitSpan(i)),
                        e ? n.renderSelection(e) :e === !1 && s()));
                },
                hitOut:function() {
                    t = null, e = null, n.unrenderSelection();
                },
                hitDone:function() {
                    o();
                },
                interactionEnd:function(r, s) {
                    s || (t && !n.isIgnoringMouse && i.triggerDayClick(n.getHitSpan(t), n.getHitEl(t), r),
                    e && i.reportSelection(e, r));
                }
            });
            return l;
        },
        clearDragListeners:function() {
            this.dayDragListener.endInteraction(), this.segDragListener && this.segDragListener.endInteraction(),
            this.segResizeListener && this.segResizeListener.endInteraction(), this.externalDragListener && this.externalDragListener.endInteraction();
        },
        renderEventLocationHelper:function(t, e) {
            var n = this.fabricateHelperEvent(t, e);
            return this.renderHelper(n, e);
        },
        fabricateHelperEvent:function(t, e) {
            var n = e ? Z(e.event) :{};
            return n.start = t.start.clone(), n.end = t.end ? t.end.clone() :null, n.allDay = null,
                this.view.calendar.normalizeEventDates(n), n.className = (n.className || []).concat("fc-helper"),
            e || (n.editable = !1), n;
        },
        renderHelper:function(t, e) {},
        unrenderHelper:function() {},
        renderSelection:function(t) {
            this.renderHighlight(t);
        },
        unrenderSelection:function() {
            this.unrenderHighlight();
        },
        computeSelection:function(t, e) {
            var n = this.computeSelectionSpan(t, e);
            return !(n && !this.view.calendar.isSelectionSpanAllowed(n)) && n;
        },
        computeSelectionSpan:function(t, e) {
            var n = [ t.start, t.end, e.start, e.end ];
            return n.sort(st), {
                start:n[0].clone(),
                end:n[3].clone()
            };
        },
        renderHighlight:function(t) {
            this.renderFill("highlight", this.spanToSegs(t));
        },
        unrenderHighlight:function() {
            this.unrenderFill("highlight");
        },
        highlightSegClasses:function() {
            return [ "fc-highlight" ];
        },
        renderBusinessHours:function() {},
        unrenderBusinessHours:function() {},
        getNowIndicatorUnit:function() {},
        renderNowIndicator:function(t) {},
        unrenderNowIndicator:function() {},
        renderFill:function(t, e) {},
        unrenderFill:function(t) {
            var e = this.elsByFill[t];
            e && (e.remove(), delete this.elsByFill[t]);
        },
        renderFillSegEls:function(e, n) {
            var i, r = this, s = this[e + "SegEl"], o = "", l = [];
            if (n.length) {
                for (i = 0; i < n.length; i++) o += this.fillSegHtml(e, n[i]);
                t(o).each(function(e, i) {
                    var o = n[e], a = t(i);
                    s && (a = s.call(r, o, a)),
                    a && (a = t(a), a.is(r.fillSegTag) && (o.el = a, l.push(o))&& a.html(a.data("text")));
                });
            }
            return l;
        },
        fillSegTag:"div",
        fillSegHtml:function(t, e) {
            var n = this[t + "SegClasses"],
                i = this[t + "SegCss"],
                ct = this[t + "SegName"],
                r = n ? n.call(this, e) :[],
                s = nt(i ? i.call(this, e) :{}),
                ctext = ct ? ct.call(this, e) :"";
            return "<" + this.fillSegTag + (r.length ? ' class="' + r.join(" ") + '"' :"") + (s ? ' style="' + s + '"' :"") + (ctext ? ' data-text="' + ctext + '"' :"")+"/>";
        },
        getDayClasses:function(t) {
            var e = this.view, n = e.calendar.getNow(), i = [ "fc-" + $t[t.day()] ];
            return 1 == e.intervalDuration.as("months") && t.month() != e.intervalStart.month() && i.push("fc-other-month"),
                t.isSame(n, "day") ? i.push("fc-today", e.highlightStateClass) :t < n ? i.push("fc-past") :i.push("fc-future"),
                i;
        }
    });
    ge.mixin({
        segSelector:".fc-event-container > *",
        mousedOverSeg:null,
        isDraggingSeg:!1,
        isResizingSeg:!1,
        isDraggingExternal:!1,
        segs:null,
        renderEvents:function(t) {
            var e, n = [], i = [];
            for (e = 0; e < t.length; e++) (Tt(t[e]) ? n :i).push(t[e]);
            this.segs = [].concat(this.renderBgEvents(n), this.renderFgEvents(i));
        },
        renderBgEvents:function(t) {
            var e = this.eventsToSegs(t);
            return this.renderBgSegs(e) || e;
        },
        renderFgEvents:function(t) {
            var e = this.eventsToSegs(t);
            return this.renderFgSegs(e) || e;
        },
        unrenderEvents:function() {
            this.handleSegMouseout(), this.clearDragListeners(), this.unrenderFgSegs(), this.unrenderBgSegs(),
                this.segs = null;
        },
        getEventSegs:function() {
            return this.segs || [];
        },
        renderFgSegs:function(t) {},
        unrenderFgSegs:function() {},
        renderFgSegEls:function(e, n) {
            var i, r = this.view, s = "", o = [];
            if (e.length) {
                for (i = 0; i < e.length; i++) s += this.fgSegHtml(e[i], n);
                t(s).each(function(n, i) {
                    var s = e[n], l = r.resolveEventEl(s.event, t(i));
                    l && (l.data("fc-seg", s), s.el = l, o.push(s));
                });
            }
            return o;
        },
        fgSegHtml:function(t, e) {},
        renderBgSegs:function(t) {
            return this.renderFill("bgEvent", t);
        },
        unrenderBgSegs:function() {
            this.unrenderFill("bgEvent");
        },
        bgEventSegEl:function(t, e) {
            return this.view.resolveEventEl(t.event, e);
        },
        bgEventSegClasses:function(t) {
            var e = t.event, n = e.source || {};
            return [ "fc-bgevent" ].concat(e.className, n.className || []);
        },
        bgEventSegCss:function(t) {
            return {
                "background-color":this.getSegSkinCss(t)["background-color"]
            };
        },
        bgEventSegName:function(t) {
            var e = t.event;
            return e.title || "";
        },
        businessHoursSegClasses:function(t) {
            return [ "fc-nonbusiness", "fc-bgevent" ];
        },
        buildBusinessHourSegs:function(e) {
            var n = this.view.calendar.getCurrentBusinessHourEvents(e);
            return !n.length && this.view.calendar.options.businessHours && (n = [ t.extend({}, xe, {
                start:this.view.end,
                end:this.view.end,
                dow:null
            }) ]), this.eventsToSegs(n);
        },
        bindSegHandlers:function() {
            this.bindSegHandlersToEl(this.el);
        },
        bindSegHandlersToEl:function(t) {
            this.bindSegHandlerToEl(t, "touchstart", this.handleSegTouchStart),
                this.bindSegHandlerToEl(t, "touchend", this.handleSegTouchEnd),
                this.bindSegHandlerToEl(t, "mouseenter", this.handleSegMouseover),
                this.bindSegHandlerToEl(t, "mouseleave", this.handleSegMouseout),
                this.bindSegHandlerToEl(t, "mousedown", this.handleSegMousedown),
                this.bindSegHandlerToEl(t, "click", this.handleSegClick);
        },
        bindSegHandlerToEl:function(e, n, i) {
            //sequence 拖拽事件监听
            var r = this;
            e.on(n, this.segSelector, function(e) {
                var n = t(this).data("fc-seg");
                if (n && !r.isDraggingSeg && !r.isResizingSeg){
                    return i.call(r, n, e);
                }
            });
        },
        handleSegClick:function(t, e) {
            var n = this.view.trigger("eventClick", t.el[0], t.event, e);
            n === !1 && e.preventDefault();
        },
        handleSegMouseover:function(t, e) {
            this.isIgnoringMouse || this.mousedOverSeg || (this.mousedOverSeg = t, this.view.isEventResizable(t.event) && t.el.addClass("fc-allow-mouse-resize"),
                this.view.trigger("eventMouseover", t.el[0], t.event, e));
        },
        handleSegMouseout:function(t, e) {
            e = e || {}, this.mousedOverSeg && (t = t || this.mousedOverSeg, this.mousedOverSeg = null,
            this.view.isEventResizable(t.event) && t.el.removeClass("fc-allow-mouse-resize"),
                this.view.trigger("eventMouseout", t.el[0], t.event, e));
        },
        handleSegMousedown:function(t, e) {
            var n = this.startSegResize(t, e, {
                distance:5
            });
            !n && this.view.isEventDraggable(t.event) && this.buildSegDragListener(t).startInteraction(e, {
                distance:5
            });
        },
        handleSegTouchStart:function(t, e) {
            var n, i = this.view, r = t.event, s = i.isEventSelected(r), o = i.isEventDraggable(r), l = i.isEventResizable(r), a = !1;
            s && l && (a = this.startSegResize(t, e)), a || !o && !l || (n = o ? this.buildSegDragListener(t) :this.buildSegSelectListener(t),
                n.startInteraction(e, {
                    delay:s ? 0 :this.view.opt("longPressDelay")
                })), this.tempIgnoreMouse();
        },
        handleSegTouchEnd:function(t, e) {
            this.tempIgnoreMouse();
        },
        startSegResize:function(e, n, i) {
            return !!t(n.target).is(".fc-resizer") && (this.buildSegResizeListener(e, t(n.target).is(".fc-start-resizer")).startInteraction(n, i),
                    !0);
        },
        buildSegDragListener:function(t) {
            var e, n, i, r = this, l = this.view, a = l.calendar, u = t.el, c = t.event;
            if (this.segDragListener) return this.segDragListener;
            var d = this.segDragListener = new he(l, {
                scroll:l.opt("dragScroll"),
                subjectEl:u,
                subjectCenter:!0,
                interactionStart:function(i) {
                    t.component = r, e = !1, n = new fe(t.el, {
                        additionalClass:"fc-dragging",
                        parentEl:l.el,
                        opacity:d.isTouch ? null :l.opt("dragOpacity"),
                        revertDuration:l.opt("dragRevertDuration"),
                        zIndex:2
                    }), n.hide(), n.start(i);
                },
                dragStart:function(n) {
                    d.isTouch && !l.isEventSelected(c) && l.selectEvent(c),
                        e = !0, r.handleSegMouseout(t, n),
                        r.segDragStart(t, n),
                        l.hideEvent(c);
                },
                hitOver:function(e, o, u) {
                    var h;
                    t.hit && (u = t.hit),
                        i = r.computeEventDrop(u.component.getHitSpan(u), e.component.getHitSpan(e), c),
                    i && !a.isEventSpanAllowed(r.eventToSpan(i), c) && (s(), i = null), i && (h = l.renderDrag(i, t)) ? (h.addClass("fc-dragging"),
                    d.isTouch || r.applyDragOpacity(h), n.hide()) :n.show(), o && (i = null);
                },
                hitOut:function() {
                    l.unrenderDrag(), n.show(), i = null;
                },
                hitDone:function() {
                    o();
                },
                interactionEnd:function(s) {
                    delete t.component, n.stop(!i, function() {
                        e && (l.unrenderDrag(), l.showEvent(c), r.segDragStop(t, s)), i && l.reportEventDrop(c, i, this.largeUnit, u, s);
                    }), r.segDragListener = null;
                }
            });
            return d;
        },
        buildSegSelectListener:function(t) {
            var e = this, n = this.view, i = t.event;
            if (this.segDragListener) return this.segDragListener;
            var r = this.segDragListener = new de({
                dragStart:function(t) {
                    r.isTouch && !n.isEventSelected(i) && n.selectEvent(i);
                },
                interactionEnd:function(t) {
                    e.segDragListener = null;
                }
            });
            return r;
        },
        segDragStart:function(t, e) {
            this.isDraggingSeg = !0, this.view.trigger("eventDragStart", t.el[0], t.event, e, {});
        },
        segDragStop:function(t, e) {
            this.isDraggingSeg = !1, this.view.trigger("eventDragStop", t.el[0], t.event, e, {});
        },
        computeEventDrop:function(t, e, n) {
            var i, r, s = this.view.calendar, o = t.start, l = e.start;
            return o.hasTime() === l.hasTime() ? (i = this.diffDates(l, o), n.allDay && W(i) ? (r = {
                start:n.start.clone(),
                end:s.getEventEnd(n),
                allDay:!1
            }, s.normalizeEventTimes(r)) :r = Ht(n), r.start.add(i), r.end && r.end.add(i)) :r = {
                start:l.clone(),
                end:null,
                allDay:!l.hasTime(),
                resourceId:"25"
            }, r;
        },
        applyDragOpacity:function(t) {
            var e = this.view.opt("dragOpacity");
            null != e && t.css("opacity", e);
        },
        externalDragStart:function(e, n) {
            var i, r, s = this.view;
            s.opt("droppable") && (i = t((n ? n.item :null) || e.target), r = s.opt("dropAccept"),
            (t.isFunction(r) ? r.call(i[0], i) :i.is(r)) && (this.isDraggingExternal || this.listenToExternalDrag(i, e, n)));
        },
        listenToExternalDrag:function(t, e, n) {
            var i, r = this, l = this.view.calendar, a = Lt(t), u = r.externalDragListener = new he(this, {
                interactionStart:function() {
                    r.isDraggingExternal = !0;
                },
                hitOver:function(t) {
                    i = r.computeExternalDrop(t.component.getHitSpan(t), a), i && !l.isExternalSpanAllowed(r.eventToSpan(i), i, a.eventProps) && (s(),
                        i = null), i && r.renderDrag(i);
                },
                hitOut:function() {
                    i = null;
                },
                hitDone:function() {
                    o(), r.unrenderDrag();
                },
                interactionEnd:function(e) {
                    i && r.view.reportExternalDrop(a, i, t, e, n), r.isDraggingExternal = !1, r.externalDragListener = null;
                }
            });
            u.startDrag(e);
        },
        computeExternalDrop:function(t, e) {
            var n = this.view.calendar, i = {
                start:n.applyTimezone(t.start),
                end:null
            };
            return e.startTime && !i.start.hasTime() && i.start.time(e.startTime), e.duration && (i.end = i.start.clone().add(e.duration)),
                i;
        },
        renderDrag:function(t, e) {},
        unrenderDrag:function() {},
        buildSegResizeListener:function(t, e) {
            var n, i, r = this, l = this.view, a = l.calendar, u = t.el, c = t.event, d = a.getEventEnd(c), h = this.segResizeListener = new he(this, {
                scroll:l.opt("dragScroll"),
                subjectEl:u,
                interactionStart:function() {
                    n = !1;
                },
                dragStart:function(e) {
                    n = !0, r.handleSegMouseout(t, e), r.segResizeStart(t, e);
                },
                hitOver:function(n, o, u) {
                    var h = r.getHitSpan(u), f = r.getHitSpan(n);
                    i = e ? r.computeEventStartResize(h, f, c) :r.computeEventEndResize(h, f, c), i && (a.isEventSpanAllowed(r.eventToSpan(i), c) ? i.start.isSame(c.start.clone().stripZone()) && i.end.isSame(d.clone().stripZone()) && (i = null) :(s(),
                        i = null)), i && (l.hideEvent(c), r.renderEventResize(i, t));
                },
                hitOut:function() {
                    i = null;
                },
                hitDone:function() {
                    r.unrenderEventResize(), l.showEvent(c), o();
                },
                interactionEnd:function(e) {
                    n && r.segResizeStop(t, e), i && l.reportEventResize(c, i, this.largeUnit, u, e),
                        r.segResizeListener = null;
                }
            });
            return h;
        },
        segResizeStart:function(t, e) {
            this.isResizingSeg = !0, this.view.trigger("eventResizeStart", t.el[0], t.event, e, {});
        },
        segResizeStop:function(t, e) {
            this.isResizingSeg = !1, this.view.trigger("eventResizeStop", t.el[0], t.event, e, {});
        },
        computeEventStartResize:function(t, e, n) {
            return this.computeEventResize("start", t, e, n);
        },
        computeEventEndResize:function(t, e, n) {
            return this.computeEventResize("end", t, e, n);
        },
        computeEventResize:function(t, e, n, i) {
            var r, s, o = this.view.calendar, l = this.diffDates(n[t], e[t]);
            return r = {
                start:i.start.clone(),
                end:o.getEventEnd(i),
                allDay:i.allDay
            }, r.allDay && W(l) && (r.allDay = !1, o.normalizeEventTimes(r)), r[t].add(l), r.start.isBefore(r.end) || (s = this.minResizeDuration || (i.allDay ? o.defaultAllDayEventDuration :o.defaultTimedEventDuration),
                "start" == t ? r.start = r.end.clone().subtract(s) :r.end = r.start.clone().add(s)),
                r;
        },
        renderEventResize:function(t, e) {},
        unrenderEventResize:function() {},
        getEventTimeText:function(t, e, n) {
            return null == e && (e = this.eventTimeFormat), null == n && (n = this.displayEventEnd),
                this.displayEventTime && t.start.hasTime() ? n && t.end ? this.view.formatRange(t, e) :t.start.format(e) :"";
        },
        getSegClasses:function(t, e, n) {
            var i = this.view, r = [ "fc-event", t.isStart ? "fc-start" :"fc-not-start", t.isEnd ? "fc-end" :"fc-not-end" ].concat(this.getSegCustomClasses(t));
            return e && r.push("fc-draggable"), n && r.push("fc-resizable"), i.isEventSelected(t.event) && r.push("fc-selected"),
                r;
        },
        getSegCustomClasses:function(t) {
            var e = t.event;
            return [].concat(e.className, e.source ? e.source.className :[]);
        },
        getSegSkinCss:function(t) {
            return {
                "background-color":this.getSegBackgroundColor(t),
                "border-color":this.getSegBorderColor(t),
                color:this.getSegTextColor(t)
            };
        },
        getSegBackgroundColor:function(t) {
            return t.event.backgroundColor || t.event.color || this.getSegDefaultBackgroundColor(t);
        },
        getSegDefaultBackgroundColor:function(t) {
            var e = t.event.source || {};
            return e.backgroundColor || e.color || this.view.opt("eventBackgroundColor") || this.view.opt("eventColor");
        },
        getSegBorderColor:function(t) {
            return t.event.borderColor || t.event.color || this.getSegDefaultBorderColor(t);
        },
        getSegDefaultBorderColor:function(t) {
            var e = t.event.source || {};
            return e.borderColor || e.color || this.view.opt("eventBorderColor") || this.view.opt("eventColor");
        },
        getSegTextColor:function(t) {
            return t.event.textColor || this.getSegDefaultTextColor(t);
        },
        getSegDefaultTextColor:function(t) {
            var e = t.event.source || {};
            return e.textColor || this.view.opt("eventTextColor");
        },
        eventToSegs:function(t) {
            return this.eventsToSegs([ t ]);
        },
        eventToSpan:function(t) {
            return this.eventToSpans(t)[0];
        },
        eventToSpans:function(t) {
            var e = this.eventToRange(t);
            return this.eventRangeToSpans(e, t);
        },
        eventsToSegs:function(e, n) {
            var i = this, r = It(e), s = [];
            return t.each(r, function(t, e) {
                var r, o = [];
                for (r = 0; r < e.length; r++) o.push(i.eventToRange(e[r]));
                if (xt(e[0])) for (o = i.invertRanges(o), r = 0; r < o.length; r++) s.push.apply(s, i.eventRangeToSegs(o[r], e[0], n)); else for (r = 0; r < o.length; r++) s.push.apply(s, i.eventRangeToSegs(o[r], e[r], n));
            }), s;
        },
        eventToRange:function(t) {
            var e = this.view.calendar, n = t.start.clone().stripZone(), i = (t.end ? t.end.clone() :e.getDefaultEventEnd(null != t.allDay ? t.allDay :!t.start.hasTime(), t.start)).stripZone();
            return e.localizeMoment(n), e.localizeMoment(i), {
                start:n,
                end:i
            };
        },
        eventRangeToSegs:function(t, e, n) {
            var i, r = this.eventRangeToSpans(t, e), s = [];
            for (i = 0; i < r.length; i++) s.push.apply(s, this.eventSpanToSegs(r[i], e, n));
            return s;
        },
        eventRangeToSpans:function(e, n) {
            return [ t.extend({}, e) ];
        },
        eventSpanToSegs:function(t, e, n) {
            var i, r, s = n ? n(t) :this.spanToSegs(t);
            for (i = 0; i < s.length; i++) r = s[i], r.event = e, r.eventStartMS = +t.start,
                r.eventDurationMS = t.end - t.start;
            return s;
        },
        invertRanges:function(t) {
            var e, n, i = this.view, r = i.start.clone(), s = i.end.clone(), o = [], l = r;
            for (t.sort(kt), e = 0; e < t.length; e++) n = t[e], n.start > l && o.push({
                start:l,
                end:n.start
            }), l = n.end;
            return l < s && o.push({
                start:l,
                end:s
            }), o;
        },
        sortEventSegs:function(t) {
            t.sort(lt(this, "compareEventSegs"));
        },
        compareEventSegs:function(t, e) {
            return t.eventStartMS - e.eventStartMS || e.eventDurationMS - t.eventDurationMS || e.event.allDay - t.event.allDay || M(t.event, e.event, this.view.eventOrderSpecs);
        }
    }), jt.pluckEventDateProps = Ht, jt.isBgEvent = Tt, jt.dataAttrPrefix = "";
    var pe = jt.DayTableMixin = {
        breakOnWeeks:!1,
        dayDates:null,
        dayIndices:null,
        daysPerRow:null,
        rowCnt:null,
        colCnt:null,
        colHeadFormat:null,
        updateDayTable:function() {
            for (var t, e, n, i = this.view, r = this.start.clone(), s = -1, o = [], l = []; r.isBefore(this.end); ) i.isHiddenDay(r) ? o.push(s + .5) :(s++,
                o.push(s), l.push(r.clone())), r.add(1, "days");
            if (this.breakOnWeeks) {
                for (e = l[0].day(), t = 1; t < l.length && l[t].day() != e; t++) ;
                n = Math.ceil(l.length / t);
            } else n = 1, t = l.length;
            this.dayDates = l, this.dayIndices = o, this.daysPerRow = t, this.rowCnt = n, this.updateDayTableCols();
        },
        updateDayTableCols:function() {
            this.colCnt = this.computeColCnt(), this.colHeadFormat = this.view.opt("columnFormat") || this.computeColHeadFormat();
        },
        computeColCnt:function() {
            return this.daysPerRow;
        },
        getCellDate:function(t, e) {
            return this.dayDates[this.getCellDayIndex(t, e)].clone();
        },
        getCellRange:function(t, e) {
            var n = this.getCellDate(t, e), i = n.clone().add(1, "days");
            return {
                start:n,
                end:i
            };
        },
        getCellDayIndex:function(t, e) {
            return t * this.daysPerRow + this.getColDayIndex(e);
        },
        getColDayIndex:function(t) {
            return this.isRTL ? this.colCnt - 1 - t :t;
        },
        getDateDayIndex:function(t) {
            var e = this.dayIndices, n = t.diff(this.start, "days");
            return n < 0 ? e[0] - 1 :n >= e.length ? e[e.length - 1] + 1 :e[n];
        },
        computeColHeadFormat:function() {
            return this.rowCnt > 1 || this.colCnt > 10 ? "ddd" :this.colCnt > 1 ? this.view.opt("dayOfMonthFormat") :"dddd";
        },
        sliceRangeByRow:function(t) {
            var e, n, i, r, s, o = this.daysPerRow, l = this.view.computeDayRange(t), a = this.getDateDayIndex(l.start), u = this.getDateDayIndex(l.end.clone().subtract(1, "days")), c = [];
            for (e = 0; e < this.rowCnt; e++) n = e * o, i = n + o - 1, r = Math.max(a, n),
                s = Math.min(u, i), r = Math.ceil(r), s = Math.floor(s), r <= s && c.push({
                row:e,
                firstRowDayIndex:r - n,
                lastRowDayIndex:s - n,
                isStart:r === a,
                isEnd:s === u
            });
            return c;
        },
        sliceRangeByDay:function(t) {
            var e, n, i, r, s, o, l = this.daysPerRow, a = this.view.computeDayRange(t), u = this.getDateDayIndex(a.start), c = this.getDateDayIndex(a.end.clone().subtract(1, "days")), d = [];
            for (e = 0; e < this.rowCnt; e++) for (n = e * l, i = n + l - 1, r = n; r <= i; r++) s = Math.max(u, r),
                o = Math.min(c, r), s = Math.ceil(s), o = Math.floor(o), s <= o && d.push({
                row:e,
                firstRowDayIndex:s - n,
                lastRowDayIndex:o - n,
                isStart:s === u,
                isEnd:o === c
            });
            return d;
        },
        renderHeadHtml:function() {
            var t = this.view;
            return '<div class="fc-row ' + t.widgetHeaderClass + '"><table><thead>' + this.renderHeadTrHtml() + "</thead></table></div>";
        },
        renderHeadIntroHtml:function() {
            return this.renderIntroHtml();
        },
        renderHeadTrHtml:function() {
            return "<tr>" + (this.isRTL ? "" :this.renderHeadIntroHtml()) + this.renderHeadDateCellsHtml() + (this.isRTL ? this.renderHeadIntroHtml() :"") + "</tr>";
        },
        renderHeadDateCellsHtml:function() {
            var t, e, n = [];
            for (t = 0; t < this.colCnt; t++) e = this.getCellDate(0, t), n.push(this.renderHeadDateCellHtml(e));
            return n.join("");
        },
        renderHeadDateCellHtml:function(t, e, n) {
            var i = this.view;
            return '<th class="fc-day-header ' + i.widgetHeaderClass + " fc-" + $t[t.day()] + '"' + (1 === this.rowCnt ? ' data-date="' + t.format("YYYY-MM-DD") + '"' :"") + (e > 1 ? ' colspan="' + e + '"' :"") + (n ? " " + n :"") + ">" + i.buildGotoAnchorHtml({
                    date:t,
                    forceOff:this.rowCnt > 1 || 1 === this.colCnt
                }, tt(t.format(this.colHeadFormat))) + "</th>";
        },
        renderBgTrHtml:function(t) {
            return "<tr>" + (this.isRTL ? "" :this.renderBgIntroHtml(t)) + this.renderBgCellsHtml(t) + (this.isRTL ? this.renderBgIntroHtml(t) :"") + "</tr>";
        },
        renderBgIntroHtml:function(t) {
            return this.renderIntroHtml();
        },
        renderBgCellsHtml:function(t) {
            var e, n, i = [];
            for (e = 0; e < this.colCnt; e++) n = this.getCellDate(t, e), i.push(this.renderBgCellHtml(n));
            return i.join("");
        },
        renderBgCellHtml:function(t, e) {
            var n = this.view, i = this.getDayClasses(t);
            return i.unshift("fc-day", n.widgetContentClass), '<td class="' + i.join(" ") + '" data-date="' + t.format("YYYY-MM-DD") + '"' + (e ? " " + e :"") + "></td>";
        },
        renderIntroHtml:function() {},
        bookendCells:function(t) {
            var e = this.renderIntroHtml();
            e && (this.isRTL ? t.append(e) :t.prepend(e));
        }
    }, ve = jt.DayGrid = ge.extend(pe, {
        numbersVisible:!1,
        bottomCoordPadding:0,
        rowEls:null,
        cellEls:null,
        helperEls:null,
        rowCoordCache:null,
        colCoordCache:null,
        renderDates:function(t) {
            var e, n, i = this.view, r = this.rowCnt, s = this.colCnt, o = "";
            for (e = 0; e < r; e++) o += this.renderDayRowHtml(e, t);
            for (this.el.html(o), this.rowEls = this.el.find(".fc-row"), this.cellEls = this.el.find(".fc-day"),
                     this.rowCoordCache = new ce({
                         els:this.rowEls,
                         isVertical:!0
                     }), this.colCoordCache = new ce({
                els:this.cellEls.slice(0, this.colCnt),
                isHorizontal:!0
            }), e = 0; e < r; e++) for (n = 0; n < s; n++) i.trigger("dayRender", null, this.getCellDate(e, n), this.getCellEl(e, n));
        },
        unrenderDates:function() {
            this.removeSegPopover();
        },
        renderBusinessHours:function() {
            var t = this.buildBusinessHourSegs(!0);
            this.renderFill("businessHours", t, "bgevent");
        },
        unrenderBusinessHours:function() {
            this.unrenderFill("businessHours");
        },
        renderDayRowHtml:function(t, e) {
            var n = this.view, i = [ "fc-row", "fc-week", n.widgetContentClass ];
            return e && i.push("fc-rigid"), '<div class="' + i.join(" ") + '"><div class="fc-bg"><table>' + this.renderBgTrHtml(t) + '</table></div><div class="fc-content-skeleton"><table>' + (this.numbersVisible ? "<thead>" + this.renderNumberTrHtml(t) + "</thead>" :"") + "</table></div></div>";
        },
        renderNumberTrHtml:function(t) {
            return "<tr>" + (this.isRTL ? "" :this.renderNumberIntroHtml(t)) + this.renderNumberCellsHtml(t) + (this.isRTL ? this.renderNumberIntroHtml(t) :"") + "</tr>";
        },
        renderNumberIntroHtml:function(t) {
            return this.renderIntroHtml();
        },
        renderNumberCellsHtml:function(t) {
            var e, n, i = [];
            for (e = 0; e < this.colCnt; e++) n = this.getCellDate(t, e), i.push(this.renderNumberCellHtml(n));
            return i.join("");
        },
        renderNumberCellHtml:function(t) {
            var e, n, i = "";
            return this.view.dayNumbersVisible || this.view.cellWeekNumbersVisible ? (e = this.getDayClasses(t),
                e.unshift("fc-day-top"), this.view.cellWeekNumbersVisible && (n = "ISO" === t._locale._fullCalendar_weekCalc ? 1 :t._locale.firstDayOfWeek()),
                i += '<td class="' + e.join(" ") + '" data-date="' + t.format() + '">', this.view.cellWeekNumbersVisible && t.day() == n && (i += this.view.buildGotoAnchorHtml({
                date:t,
                type:"week"
            }, {
                "class":"fc-week-number"
            }, t.format("w"))), this.view.dayNumbersVisible && (i += this.view.buildGotoAnchorHtml(t, {
                "class":"fc-day-number"
            }, t.date())), i += "</td>") :"<td/>";
        },
        computeEventTimeFormat:function() {
            return this.view.opt("extraSmallTimeFormat");
        },
        computeDisplayEventEnd:function() {
            return 1 == this.colCnt;
        },
        rangeUpdated:function() {
            this.updateDayTable();
        },
        spanToSegs:function(t) {
            var e, n, i = this.sliceRangeByRow(t);
            for (e = 0; e < i.length; e++) n = i[e], this.isRTL ? (n.leftCol = this.daysPerRow - 1 - n.lastRowDayIndex,
                n.rightCol = this.daysPerRow - 1 - n.firstRowDayIndex) :(n.leftCol = n.firstRowDayIndex,
                n.rightCol = n.lastRowDayIndex);
            return i;
        },
        prepareHits:function() {
            this.colCoordCache.build(), this.rowCoordCache.build(), this.rowCoordCache.bottoms[this.rowCnt - 1] += this.bottomCoordPadding;
        },
        releaseHits:function() {
            this.colCoordCache.clear(), this.rowCoordCache.clear();
        },
        queryHit:function(t, e) {
            if (this.colCoordCache.isLeftInBounds(t) && this.rowCoordCache.isTopInBounds(e)) {
                var n = this.colCoordCache.getHorizontalIndex(t), i = this.rowCoordCache.getVerticalIndex(e);
                if (null != i && null != n) return this.getCellHit(i, n);
            }
        },
        getHitSpan:function(t) {
            return this.getCellRange(t.row, t.col);
        },
        getHitEl:function(t) {
            return this.getCellEl(t.row, t.col);
        },
        getCellHit:function(t, e) {
            return {
                row:t,
                col:e,
                component:this,
                left:this.colCoordCache.getLeftOffset(e),
                right:this.colCoordCache.getRightOffset(e),
                top:this.rowCoordCache.getTopOffset(t),
                bottom:this.rowCoordCache.getBottomOffset(t)
            };
        },
        getCellEl:function(t, e) {
            return this.cellEls.eq(t * this.colCnt + e);
        },
        renderDrag:function(t, e) {
            if (this.renderHighlight(this.eventToSpan(t)), e && e.component !== this) return this.renderEventLocationHelper(t, e);
        },
        unrenderDrag:function() {
            this.unrenderHighlight(), this.unrenderHelper();
        },
        renderEventResize:function(t, e) {
            return this.renderHighlight(this.eventToSpan(t)), this.renderEventLocationHelper(t, e);
        },
        unrenderEventResize:function() {
            this.unrenderHighlight(), this.unrenderHelper();
        },
        renderHelper:function(e, n) {
            var i, r = [], s = this.eventToSegs(e);
            return s = this.renderFgSegEls(s), i = this.renderSegRows(s), this.rowEls.each(function(e, s) {
                var o, l = t(s), a = t('<div class="fc-helper-skeleton"><table/></div>');
                o = n && n.row === e ? n.el.position().top :l.find(".fc-content-skeleton tbody").position().top,
                    a.css("top", o).find("table").append(i[e].tbodyEl), l.append(a), r.push(a[0]);
            }), this.helperEls = t(r);
        },
        unrenderHelper:function() {
            this.helperEls && (this.helperEls.remove(), this.helperEls = null);
        },
        fillSegTag:"td",
        renderFill:function(e, n, i) {
            var r, s, o, l = [];
            for (n = this.renderFillSegEls(e, n), r = 0; r < n.length; r++){
                s = n[r], o = this.renderFillRow(e, s, i);
            }
            this.rowEls.eq(s.row).append(o), l.push(o[0]);
            return this.elsByFill[e] = t(l), n;
        },
        renderFillRow:function(e, n, i) {
            var r, s, o = this.colCnt, l = n.leftCol, a = n.rightCol + 1;
            return i = i || e.toLowerCase(), r = t('<div class="fc-' + i + '-skeleton"><table><tr/></table></div>'),
                s = r.find("tr"), l > 0 && s.append('<td colspan="' + l + '"/>'), s.append(n.el.attr("colspan", a - l)),
            a < o && s.append('<td colspan="' + (o - a) + '"/>'), this.bookendCells(s), r;
        }
    });
    ve.mixin({
        rowStructs:null,
        unrenderEvents:function() {
            this.removeSegPopover(), ge.prototype.unrenderEvents.apply(this, arguments);
        },
        getEventSegs:function() {
            return ge.prototype.getEventSegs.call(this).concat(this.popoverSegs || []);
        },
        renderBgSegs:function(e) {
            var n = t.grep(e, function(t) {
                return t.event.allDay;
            });
            return ge.prototype.renderBgSegs.call(this, n);
        },
        renderFgSegs:function(e) {
            var n;
            return e = this.renderFgSegEls(e), n = this.rowStructs = this.renderSegRows(e),
                this.rowEls.each(function(e, i) {
                    t(i).find(".fc-content-skeleton > table").append(n[e].tbodyEl);
                }), e;
        },
        unrenderFgSegs:function() {
            for (var t, e = this.rowStructs || []; t = e.pop(); ) t.tbodyEl.remove();
            this.rowStructs = null;
        },
        renderSegRows:function(t) {
            var e, n, i = [];
            for (e = this.groupSegRows(t), n = 0; n < e.length; n++) i.push(this.renderSegRow(n, e[n]));
            return i;
        },
        fgSegHtml:function(t, e) {
            var n, i, r = this.view, s = t.event, o = r.isEventDraggable(s), l = !e && s.allDay && t.isStart && r.isEventResizableFromStart(s), a = !e && s.allDay && t.isEnd && r.isEventResizableFromEnd(s), u = this.getSegClasses(t, o, l || a), c = nt(this.getSegSkinCss(t)), d = "";
            return u.unshift("fc-day-grid-event", "fc-h-event"), t.isStart && (n = this.getEventTimeText(s),
            n && (d = '<span class="fc-time">' + tt(n) + "</span>")), i = '<span class="fc-title">' + (tt(s.title || "") || "&nbsp;") + "</span>",
            '<a class="' + u.join(" ") + '"' + (s.url ? ' href="' + tt(s.url) + '"' :"") + (c ? ' style="' + c + '"' :"") + '><div class="fc-content">' + (this.isRTL ? i + " " + d :d + " " + i) + "</div>" + (l ? '<div class="fc-resizer fc-start-resizer" />' :"") + (a ? '<div class="fc-resizer fc-end-resizer" />' :"") + "</a>";
        },
        renderSegRow:function(e, n) {
            function i(e) {
                for (;o < e; ) c = (m[r - 1] || [])[o], c ? c.attr("rowspan", parseInt(c.attr("rowspan") || 1, 10) + 1) :(c = t("<td/>"),
                    l.append(c)), v[r][o] = c, m[r][o] = c, o++;
            }
            var r, s, o, l, a, u, c, d = this.colCnt, h = this.buildSegLevels(n), f = Math.max(1, h.length), g = t("<tbody/>"), p = [], v = [], m = [];
            for (r = 0; r < f; r++) {
                if (s = h[r], o = 0, l = t("<tr/>"), p.push([]), v.push([]), m.push([]), s) for (a = 0; a < s.length; a++) {
                    for (u = s[a], i(u.leftCol), c = t('<td class="fc-event-container"/>').append(u.el),
                             u.leftCol != u.rightCol ? c.attr("colspan", u.rightCol - u.leftCol + 1) :m[r][o] = c; o <= u.rightCol; ) v[r][o] = c,
                        p[r][o] = u, o++;
                    l.append(c);
                }
                i(d), this.bookendCells(l), g.append(l);
            }
            return {
                row:e,
                tbodyEl:g,
                cellMatrix:v,
                segMatrix:p,
                segLevels:h,
                segs:n
            };
        },
        buildSegLevels:function(t) {
            var e, n, i, r = [];
            for (this.sortEventSegs(t), e = 0; e < t.length; e++) {
                for (n = t[e], i = 0; i < r.length && Mt(n, r[i]); i++) ;
                n.level = i, (r[i] || (r[i] = [])).push(n);
            }
            for (i = 0; i < r.length; i++) r[i].sort(zt);
            return r;
        },
        groupSegRows:function(t) {
            var e, n = [];
            for (e = 0; e < this.rowCnt; e++) n.push([]);
            for (e = 0; e < t.length; e++) n[t[e].row].push(t[e]);
            return n;
        }
    }), ve.mixin({
        segPopover:null,
        popoverSegs:null,
        removeSegPopover:function() {
            this.segPopover && this.segPopover.hide();
        },
        limitRows:function(t) {
            var e, n, i = this.rowStructs || [];
            for (e = 0; e < i.length; e++) this.unlimitRow(e), n = !!t && ("number" == typeof t ? t :this.computeRowLevelLimit(e)),
            n !== !1 && this.limitRow(e, n);
        },
        computeRowLevelLimit:function(e) {
            function n(e, n) {
                s = Math.max(s, t(n).outerHeight());
            }
            var i, r, s, o = this.rowEls.eq(e), l = o.height(), a = this.rowStructs[e].tbodyEl.children();
            for (i = 0; i < a.length; i++) if (r = a.eq(i).removeClass("fc-limited"), s = 0,
                    r.find("> td > :first-child").each(n), r.position().top + s > l) return i;
            return !1;
        },
        limitRow:function(e, n) {
            function i(i) {
                for (;b < i; ) u = S.getCellSegs(e, b, n), u.length && (h = s[n - 1][b], y = S.renderMoreLink(e, b, u),
                    m = t("<div/>").append(y), h.append(m), E.push(m[0])), b++;
            }
            var r, s, o, l, a, u, c, d, h, f, g, p, v, m, y, S = this, w = this.rowStructs[e], E = [], b = 0;
            if (n && n < w.segLevels.length) {
                for (r = w.segLevels[n - 1], s = w.cellMatrix, o = w.tbodyEl.children().slice(n).addClass("fc-limited").get(),
                         l = 0; l < r.length; l++) {
                    for (a = r[l], i(a.leftCol), d = [], c = 0; b <= a.rightCol; ) u = this.getCellSegs(e, b, n),
                        d.push(u), c += u.length, b++;
                    if (c) {
                        for (h = s[n - 1][a.leftCol], f = h.attr("rowspan") || 1, g = [], p = 0; p < d.length; p++) v = t('<td class="fc-more-cell"/>').attr("rowspan", f),
                            u = d[p], y = this.renderMoreLink(e, a.leftCol + p, [ a ].concat(u)), m = t("<div/>").append(y),
                            v.append(m), g.push(v[0]), E.push(v[0]);
                        h.addClass("fc-limited").after(t(g)), o.push(h[0]);
                    }
                }
                i(this.colCnt), w.moreEls = t(E), w.limitedEls = t(o);
            }
        },
        unlimitRow:function(t) {
            var e = this.rowStructs[t];
            e.moreEls && (e.moreEls.remove(), e.moreEls = null), e.limitedEls && (e.limitedEls.removeClass("fc-limited"),
                e.limitedEls = null);
        },
        renderMoreLink:function(e, n, i) {
            var r = this, s = this.view;
            return t('<a class="fc-more"/>').text(this.getMoreLinkText(i.length)).on("click", function(o) {
                var l = s.opt("eventLimitClick"), a = r.getCellDate(e, n), u = t(this), c = r.getCellEl(e, n), d = r.getCellSegs(e, n), h = r.resliceDaySegs(d, a), f = r.resliceDaySegs(i, a);
                "function" == typeof l && (l = s.trigger("eventLimitClick", null, {
                    date:a,
                    dayEl:c,
                    moreEl:u,
                    segs:h,
                    hiddenSegs:f
                }, o)), "popover" === l ? r.showSegPopover(e, n, u, h) :"string" == typeof l && s.calendar.zoomTo(a, l);
            });
        },
        showSegPopover:function(t, e, n, i) {
            var r, s, o = this, l = this.view, a = n.parent();
            r = 1 == this.rowCnt ? l.el :this.rowEls.eq(t), s = {
                className:"fc-more-popover",
                content:this.renderSegPopoverContent(t, e, i),
                parentEl:this.view.el,
                top:r.offset().top,
                autoHide:!0,
                viewportConstrain:l.opt("popoverViewportConstrain"),
                hide:function() {
                    o.segPopover.removeElement(), o.segPopover = null, o.popoverSegs = null;
                }
            }, this.isRTL ? s.right = a.offset().left + a.outerWidth() + 1 :s.left = a.offset().left - 1,
                this.segPopover = new ue(s), this.segPopover.show(), this.bindSegHandlersToEl(this.segPopover.el);
        },
        renderSegPopoverContent:function(e, n, i) {
            var r, s = this.view, o = s.opt("theme"), l = this.getCellDate(e, n).format(s.opt("dayPopoverFormat")), a = t('<div class="fc-header ' + s.widgetHeaderClass + '"><span class="fc-close ' + (o ? "ui-icon ui-icon-closethick" :"fc-icon fc-icon-x") + '"></span><span class="fc-title">' + tt(l) + '</span><div class="fc-clear"/></div><div class="fc-body ' + s.widgetContentClass + '"><div class="fc-event-container"></div></div>'), u = a.find(".fc-event-container");
            for (i = this.renderFgSegEls(i, !0), this.popoverSegs = i, r = 0; r < i.length; r++) this.prepareHits(),
                i[r].hit = this.getCellHit(e, n), this.releaseHits(), u.append(i[r].el);
            return a;
        },
        resliceDaySegs:function(e, n) {
            var i = t.map(e, function(t) {
                return t.event;
            }), r = n.clone(), s = r.clone().add(1, "days"), o = {
                start:r,
                end:s
            };
            return e = this.eventsToSegs(i, function(t) {
                var e = F(t, o);
                return e ? [ e ] :[];
            }), this.sortEventSegs(e), e;
        },
        getMoreLinkText:function(t) {
            var e = this.view.opt("eventLimitText");
            return "function" == typeof e ? e(t) :"+" + t + " " + e;
        },
        getCellSegs:function(t, e, n) {
            for (var i, r = this.rowStructs[t].segMatrix, s = n || 0, o = []; s < r.length; ) i = r[s][e],
            i && o.push(i), s++;
            return o;
        }
    });
    var me = jt.TimeGrid = ge.extend(pe, {
        slotDuration:null,
        snapDuration:null,
        snapsPerSlot:null,
        minTime:null,
        maxTime:null,
        labelFormat:null,
        labelInterval:null,
        colEls:null,
        slatContainerEl:null,
        slatEls:null,
        nowIndicatorEls:null,
        colCoordCache:null,
        slatCoordCache:null,
        constructor:function() {
            ge.apply(this, arguments), this.processOptions();
        },
        renderDates:function() {
            this.el.html(this.renderHtml()), this.colEls = this.el.find(".fc-day"), this.slatContainerEl = this.el.find(".fc-slats"),
                this.slatEls = this.slatContainerEl.find("tr"), this.colCoordCache = new ce({
                els:this.colEls,
                isHorizontal:!0
            }), this.slatCoordCache = new ce({
                els:this.slatEls,
                isVertical:!0
            }), this.renderContentSkeleton();
        },
        renderHtml:function() {
            return '<div class="fc-bg"><table>' + this.renderBgTrHtml(0) + '</table></div><div class="fc-slats"><table>' + this.renderSlatRowHtml() + "</table></div>";
        },
        renderSlatRowHtml:function() {
            for (var t, n, i, r = this.view, s = this.isRTL, o = "", l = e.duration(+this.minTime); l < this.maxTime; ) t = this.start.clone().time(l),
                n = ot(_(l, this.labelInterval)), i = '<td class="fc-axis fc-time ' + r.widgetContentClass + '" ' + r.axisStyleAttr() + ">" + (n ? "<span>" + tt(t.format(this.labelFormat)) + "</span>" :"") + "</td>",
                o += '<tr data-time="' + t.format("HH:mm:ss") + '"' + (n ? "" :' class="fc-minor"') + ">" + (s ? "" :i) + '<td class="' + r.widgetContentClass + '"/>' + (s ? i :"") + "</tr>",
                l.add(this.slotDuration);
            return o;
        },
        processOptions:function() {
            var n, i = this.view, r = i.opt("slotDuration"), s = i.opt("snapDuration");
            r = e.duration(r), s = s ? e.duration(s) :r, this.slotDuration = r, this.snapDuration = s,
                this.snapsPerSlot = r / s, this.minResizeDuration = s, this.minTime = e.duration(i.opt("minTime")),
                this.maxTime = e.duration(i.opt("maxTime")), n = i.opt("slotLabelFormat"), t.isArray(n) && (n = n[n.length - 1]),
                this.labelFormat = n || i.opt("smallTimeFormat"), n = i.opt("slotLabelInterval"),
                this.labelInterval = n ? e.duration(n) :this.computeLabelInterval(r);
        },
        computeLabelInterval:function(t) {
            var n, i, r;
            for (n = Fe.length - 1; n >= 0; n--) if (i = e.duration(Fe[n]), r = _(i, t), ot(r) && r > 1) return i;
            return e.duration(t);
        },
        computeEventTimeFormat:function() {
            return this.view.opt("noMeridiemTimeFormat");
        },
        computeDisplayEventEnd:function() {
            return !0;
        },
        prepareHits:function() {
            this.colCoordCache.build(), this.slatCoordCache.build();
        },
        releaseHits:function() {
            this.colCoordCache.clear();
        },
        queryHit:function(t, e) {
            var n = this.snapsPerSlot, i = this.colCoordCache, r = this.slatCoordCache;
            if (i.isLeftInBounds(t) && r.isTopInBounds(e)) {
                var s = i.getHorizontalIndex(t), o = r.getVerticalIndex(e);
                if (null != s && null != o) {
                    var l = r.getTopOffset(o), a = r.getHeight(o), u = (e - l) / a, c = Math.floor(u * n), d = o * n + c, h = l + c / n * a, f = l + (c + 1) / n * a;
                    return {
                        col:s,
                        snap:d,
                        component:this,
                        left:i.getLeftOffset(s),
                        right:i.getRightOffset(s),
                        top:h,
                        bottom:f
                    };
                }
            }
        },
        getHitSpan:function(t) {
            var e, n = this.getCellDate(0, t.col), i = this.computeSnapTime(t.snap);
            return n.time(i), e = n.clone().add(this.snapDuration), {
                start:n,
                end:e
            };
        },
        getHitEl:function(t) {
            return this.colEls.eq(t.col);
        },
        rangeUpdated:function() {
            this.updateDayTable();
        },
        computeSnapTime:function(t) {
            return e.duration(this.minTime + this.snapDuration * t);
        },
        spanToSegs:function(t) {
            var e, n = this.sliceRangeByTimes(t);
            for (e = 0; e < n.length; e++) this.isRTL ? n[e].col = this.daysPerRow - 1 - n[e].dayIndex :n[e].col = n[e].dayIndex;
            return n;
        },
        sliceRangeByTimes:function(t) {
            var e, n, i, r, s = [];
            for (n = 0; n < this.daysPerRow; n++) i = this.dayDates[n].clone(), r = {
                start:i.clone().time(this.minTime),
                end:i.clone().time(this.maxTime)
            }, e = F(t, r), e && (e.dayIndex = n, s.push(e));
            return s;
        },
        updateSize:function(t) {
            this.slatCoordCache.build(), t && this.updateSegVerticals([].concat(this.fgSegs || [], this.bgSegs || [], this.businessSegs || []));
        },
        getTotalSlatHeight:function() {
            return this.slatContainerEl.outerHeight();
        },
        computeDateTop:function(t, n) {
            return this.computeTimeTop(e.duration(t - n.clone().stripTime()));
        },
        computeTimeTop:function(t) {
            var e, n, i = this.slatEls.length, r = (t - this.minTime) / this.slotDuration;
            return r = Math.max(0, r), r = Math.min(i, r), e = Math.floor(r), e = Math.min(e, i - 1),
                n = r - e, this.slatCoordCache.getTopPosition(e) + this.slatCoordCache.getHeight(e) * n;
        },
        renderDrag:function(t, e) {
            return e ? this.renderEventLocationHelper(t, e) :void this.renderHighlight(this.eventToSpan(t));
        },
        unrenderDrag:function() {
            this.unrenderHelper(), this.unrenderHighlight();
        },
        renderEventResize:function(t, e) {
            return this.renderEventLocationHelper(t, e);
        },
        unrenderEventResize:function() {
            this.unrenderHelper();
        },
        renderHelper:function(t, e) {
            return this.renderHelperSegs(this.eventToSegs(t), e);
        },
        unrenderHelper:function() {
            this.unrenderHelperSegs();
        },
        renderBusinessHours:function() {
            this.renderBusinessSegs(this.buildBusinessHourSegs());
        },
        unrenderBusinessHours:function() {
            this.unrenderBusinessSegs();
        },
        getNowIndicatorUnit:function() {
            return "minute";
        },
        renderNowIndicator:function(e) {
            var n, i = this.spanToSegs({
                start:e,
                end:e
            }), r = this.computeDateTop(e, e), s = [];
            for (n = 0; n < i.length; n++) s.push(t('<div class="fc-now-indicator fc-now-indicator-line"></div>').css("top", r).appendTo(this.colContainerEls.eq(i[n].col))[0]);
            i.length > 0 && s.push(t('<div class="fc-now-indicator fc-now-indicator-arrow"></div>').css("top", r).appendTo(this.el.find(".fc-content-skeleton"))[0]),
                this.nowIndicatorEls = t(s);
        },
        unrenderNowIndicator:function() {
            this.nowIndicatorEls && (this.nowIndicatorEls.remove(), this.nowIndicatorEls = null);
        },
        renderSelection:function(t) {
            this.view.opt("selectHelper") ? this.renderEventLocationHelper(t) :this.renderHighlight(t);
        },
        unrenderSelection:function() {
            this.unrenderHelper(), this.unrenderHighlight();
        },
        renderHighlight:function(t) {
            this.renderHighlightSegs(this.spanToSegs(t));
        },
        unrenderHighlight:function() {
            this.unrenderHighlightSegs();
        }
    });
    me.mixin({
        colContainerEls:null,
        fgContainerEls:null,
        bgContainerEls:null,
        helperContainerEls:null,
        highlightContainerEls:null,
        businessContainerEls:null,
        fgSegs:null,
        bgSegs:null,
        helperSegs:null,
        highlightSegs:null,
        businessSegs:null,
        renderContentSkeleton:function() {
            var e, n, i = "";
            for (e = 0; e < this.colCnt; e++) i += '<td><div class="fc-content-col"><div class="fc-event-container fc-helper-container"></div><div class="fc-event-container"></div><div class="fc-highlight-container"></div><div class="fc-bgevent-container"></div><div class="fc-business-container"></div></div></td>';
            n = t('<div class="fc-content-skeleton"><table><tr>' + i + "</tr></table></div>"),
                this.colContainerEls = n.find(".fc-content-col"),
                this.helperContainerEls = n.find(".fc-helper-container"),
                this.fgContainerEls = n.find(".fc-event-container:not(.fc-helper-container)"),
                this.bgContainerEls = n.find(".fc-bgevent-container"),
                this.highlightContainerEls = n.find(".fc-highlight-container"),
                this.businessContainerEls = n.find(".fc-business-container"),
                this.bookendCells(n.find("tr")), this.el.append(n);
        },
        renderFgSegs:function(t) {
            return t = this.renderFgSegsIntoContainers(t, this.fgContainerEls), this.fgSegs = t,
                t;
        },
        unrenderFgSegs:function() {
            this.unrenderNamedSegs("fgSegs");
        },
        renderHelperSegs:function(e, n) {
            var i, r, s, o = [];
            for (e = this.renderFgSegsIntoContainers(e, this.helperContainerEls), i = 0; i < e.length; i++) r = e[i],
            n && n.col === r.col && (s = n.el, r.el.css({
                left:s.css("left"),
                right:s.css("right"),
                "margin-left":s.css("margin-left"),
                "margin-right":s.css("margin-right")
            })), o.push(r.el[0]);
            return this.helperSegs = e, t(o);
        },
        unrenderHelperSegs:function() {
            this.unrenderNamedSegs("helperSegs");
        },
        renderBgSegs:function(t) {
            return t = this.renderFillSegEls("bgEvent", t),
                this.updateSegVerticals(t),
                this.attachSegsByCol(this.groupSegsByCol(t), this.bgContainerEls),
                this.bgSegs = t, t;
        },
        unrenderBgSegs:function() {
            this.unrenderNamedSegs("bgSegs");
        },
        renderHighlightSegs:function(t) {
            t = this.renderFillSegEls("highlight", t), this.updateSegVerticals(t), this.attachSegsByCol(this.groupSegsByCol(t), this.highlightContainerEls),
                this.highlightSegs = t;
        },
        unrenderHighlightSegs:function() {
            this.unrenderNamedSegs("highlightSegs");
        },
        renderBusinessSegs:function(t) {
            t = this.renderFillSegEls("businessHours", t), this.updateSegVerticals(t), this.attachSegsByCol(this.groupSegsByCol(t), this.businessContainerEls),
                this.businessSegs = t;
        },
        unrenderBusinessSegs:function() {
            this.unrenderNamedSegs("businessSegs");
        },
        groupSegsByCol:function(t) {
            var e, n = [];
            for (e = 0; e < this.colCnt; e++) n.push([]);
            for (e = 0; e < t.length; e++) n[t[e].col].push(t[e]);
            return n;
        },
        attachSegsByCol:function(t, e) {
            var n, i, r;
            for (n = 0; n < this.colCnt; n++) for (i = t[n], r = 0; r < i.length; r++) e.eq(n).append(i[r].el);
        },
        unrenderNamedSegs:function(t) {
            var e, n = this[t];
            if (n) {
                for (e = 0; e < n.length; e++) n[e].el.remove();
                this[t] = null;
            }
        },
        renderFgSegsIntoContainers:function(t, e) {
            var n, i;
            for (t = this.renderFgSegEls(t), n = this.groupSegsByCol(t), i = 0; i < this.colCnt; i++) this.updateFgSegCoords(n[i]);
            return this.attachSegsByCol(n, e), t;
        },
        fgSegHtml:function(t, e) {
            var n, i, r, s = this.view, o = t.event, l = s.isEventDraggable(o), a = !e && t.isStart && s.isEventResizableFromStart(o), u = !e && t.isEnd && s.isEventResizableFromEnd(o), c = this.getSegClasses(t, l, a || u), d = nt(this.getSegSkinCss(t));
            return c.unshift("fc-time-grid-event", "fc-v-event"), s.isMultiDayEvent(o) ? (t.isStart || t.isEnd) && (n = this.getEventTimeText(t),
                i = this.getEventTimeText(t, "LT"), r = this.getEventTimeText(t, null, !1)) :(n = this.getEventTimeText(o),
                i = this.getEventTimeText(o, "LT"), r = this.getEventTimeText(o, null, !1)), '<a class="' + c.join(" ") + '"' + (o.url ? ' href="' + tt(o.url) + '"' :"") + (d ? ' style="' + d + '"' :"") + '><div class="fc-content">' + (n ? '<div class="fc-time" data-start="' + tt(r) + '" data-full="' + tt(i) + '"><span>' + tt(n) + "</span></div>" :"") + (o.title ? '<div class="fc-title">' + tt(o.title) + "</div>" :"") + '</div><div class="fc-bg"/>' + (u ? '<div class="fc-resizer fc-end-resizer" />' :"") + "</a>";
        },
        updateSegVerticals:function(t) {
            this.computeSegVerticals(t), this.assignSegVerticals(t);
        },
        computeSegVerticals:function(t) {
            var e, n;
            for (e = 0; e < t.length; e++) n = t[e], n.top = this.computeDateTop(n.start, n.start),
                n.bottom = this.computeDateTop(n.end, n.start);
        },
        assignSegVerticals:function(t) {
            var e, n;
            for (e = 0; e < t.length; e++) n = t[e], n.el.css(this.generateSegVerticalCss(n));
        },
        generateSegVerticalCss:function(t) {
            return {
                top:t.top,
                bottom:-t.bottom
            };
        },
        updateFgSegCoords:function(t) {
            this.computeSegVerticals(t), this.computeFgSegHorizontals(t), this.assignSegVerticals(t),
                this.assignFgSegHorizontals(t);
        },
        computeFgSegHorizontals:function(t) {
            var e, n, i;
            if (this.sortEventSegs(t), e = Bt(t), Ft(e), n = e[0]) {
                for (i = 0; i < n.length; i++) Nt(n[i]);
                for (i = 0; i < n.length; i++) this.computeFgSegForwardBack(n[i], 0, 0);
            }
        },
        computeFgSegForwardBack:function(t, e, n) {
            var i, r = t.forwardSegs;
            if (void 0 === t.forwardCoord) for (r.length ? (this.sortForwardSegs(r), this.computeFgSegForwardBack(r[0], e + 1, n),
                t.forwardCoord = r[0].backwardCoord) :t.forwardCoord = 1, t.backwardCoord = t.forwardCoord - (t.forwardCoord - n) / (e + 1),
                                                    i = 0; i < r.length; i++) this.computeFgSegForwardBack(r[i], 0, t.forwardCoord);
        },
        sortForwardSegs:function(t) {
            t.sort(lt(this, "compareForwardSegs"));
        },
        compareForwardSegs:function(t, e) {
            return e.forwardPressure - t.forwardPressure || (t.backwardCoord || 0) - (e.backwardCoord || 0) || this.compareEventSegs(t, e);
        },
        assignFgSegHorizontals:function(t) {
            var e, n;
            for (e = 0; e < t.length; e++) n = t[e], n.el.css(this.generateFgSegHorizontalCss(n)),
            n.bottom - n.top < 30 && n.el.addClass("fc-short");
        },
        generateFgSegHorizontalCss:function(t) {
            var e, n, i = this.view.opt("slotEventOverlap"), r = t.backwardCoord, s = t.forwardCoord, o = this.generateSegVerticalCss(t);
            return i && (s = Math.min(1, r + 2 * (s - r))), this.isRTL ? (e = 1 - s, n = r) :(e = r,
                n = 1 - s), o.zIndex = t.level + 1, o.left = 100 * e + "%", o.right = 100 * n + "%",
            i && t.forwardPressure && (o[this.isRTL ? "marginLeft" :"marginRight"] = 20), o;
        }
    });
    var ye = jt.View = wt.extend(oe, le, {
        type:null,
        name:null,
        title:null,
        calendar:null,
        options:null,
        el:null,
        displaying:null,
        isSkeletonRendered:!1,
        isEventsRendered:!1,
        start:null,
        end:null,
        intervalStart:null,
        intervalEnd:null,
        intervalDuration:null,
        intervalUnit:null,
        isRTL:!1,
        isSelected:!1,
        selectedEvent:null,
        eventOrderSpecs:null,
        widgetHeaderClass:null,
        widgetContentClass:null,
        highlightStateClass:null,
        nextDayThreshold:null,
        isHiddenDayHash:null,
        isNowIndicatorRendered:null,
        initialNowDate:null,
        initialNowQueriedMs:null,
        nowIndicatorTimeoutID:null,
        nowIndicatorIntervalID:null,
        constructor:function(t, n, i, r) {
            this.calendar = t, this.type = this.name = n, this.options = i, this.intervalDuration = r || e.duration(1, "day"),
                this.nextDayThreshold = e.duration(this.opt("nextDayThreshold")), this.initThemingProps(),
                this.initHiddenDays(), this.isRTL = this.opt("isRTL"), this.eventOrderSpecs = L(this.opt("eventOrder")),
                this.initialize();
        },
        initialize:function() {},
        opt:function(t) {
            return this.options[t];
        },
        trigger:function(t, e) {
            var n = this.calendar;
            return n.trigger.apply(n, [ t, e || this ].concat(Array.prototype.slice.call(arguments, 2), [ this ]));
        },
        setDate:function(t) {
            this.setRange(this.computeRange(t));
        },
        setRange:function(e) {
            t.extend(this, e), this.updateTitle();
        },
        computeRange:function(t) {
            var e, n, i = A(this.intervalDuration), r = t.clone().startOf(i), s = r.clone().add(this.intervalDuration);
            return /year|month|week|day/.test(i) ? (r.stripTime(), s.stripTime()) :(r.hasTime() || (r = this.calendar.time(0)),
            s.hasTime() || (s = this.calendar.time(0))), e = r.clone(), e = this.skipHiddenDays(e),
                n = s.clone(), n = this.skipHiddenDays(n, -1, !0), {
                intervalUnit:i,
                intervalStart:r,
                intervalEnd:s,
                start:e,
                end:n
            };
        },
        computePrevDate:function(t) {
            return this.massageCurrentDate(t.clone().startOf(this.intervalUnit).subtract(this.intervalDuration), -1);
        },
        computeNextDate:function(t) {
            return this.massageCurrentDate(t.clone().startOf(this.intervalUnit).add(this.intervalDuration));
        },
        massageCurrentDate:function(t, e) {
            return this.intervalDuration.as("days") <= 1 && this.isHiddenDay(t) && (t = this.skipHiddenDays(t, e),
                t.startOf("day")), t;
        },
        updateTitle:function() {
            this.title = this.computeTitle();
        },
        computeTitle:function() {
            return this.formatRange({
                start:this.calendar.applyTimezone(this.intervalStart),
                end:this.calendar.applyTimezone(this.intervalEnd)
            }, this.opt("titleFormat") || this.computeTitleFormat(), this.opt("titleRangeSeparator"));
        },
        computeTitleFormat:function() {
            return "year" == this.intervalUnit ? "YYYY" :"month" == this.intervalUnit ? this.opt("monthYearFormat") :this.intervalDuration.as("days") > 1 ? "ll" :"LL";
        },
        formatRange:function(t, e, n) {
            var i = t.end;
            return i.hasTime() || (i = i.clone().subtract(1)), pt(t.start, i, e, n, this.opt("isRTL"));
        },
        getAllDayHtml:function() {
            return this.opt("allDayHtml") || tt(this.opt("allDayText"));
        },
        buildGotoAnchorHtml:function(e, n, i) {
            var r, s, o, l;
            return t.isPlainObject(e) ? (r = e.date, s = e.type, o = e.forceOff) :r = e, r = jt.moment(r),
                l = {
                    date:r.format("YYYY-MM-DD"),
                    type:s || "day"
                }, "string" == typeof n && (i = n, n = null), n = n ? " " + it(n) :"", i = i || "",
                !o && this.opt("navLinks") ? "<a" + n + ' data-goto="' + tt(JSON.stringify(l)) + '">' + i + "</a>" :"<span" + n + ">" + i + "</span>";
        },
        setElement:function(t) {
            this.el = t, this.bindGlobalHandlers();
        },
        removeElement:function() {
            this.clear(), this.isSkeletonRendered && (this.unrenderSkeleton(), this.isSkeletonRendered = !1),
                this.unbindGlobalHandlers(), this.el.remove();
        },
        display:function(t, e) {
            var n = this, i = null;
            return null != e && this.displaying && (i = this.queryScroll()), this.calendar.freezeContentHeight(),
                ut(this.clear(), function() {
                    return n.displaying = ut(n.displayView(t), function() {
                        null != e ? n.setScroll(e) :n.forceScroll(n.computeInitialScroll(i)), n.calendar.unfreezeContentHeight(),
                            n.triggerRender();
                    });
                });
        },
        clear:function() {
            var e = this, n = this.displaying;
            return n ? ut(n, function() {
                return e.displaying = null, e.clearEvents(), e.clearView();
            }) :t.when();
        },
        displayView:function(t) {
            this.isSkeletonRendered || (this.renderSkeleton(), this.isSkeletonRendered = !0),
            t && this.setDate(t), this.render && this.render(), this.renderDates(), this.updateSize(),
                this.renderBusinessHours(), this.startNowIndicator();
        },
        clearView:function() {
            this.unselect(), this.stopNowIndicator(), this.triggerUnrender(), this.unrenderBusinessHours(),
                this.unrenderDates(), this.destroy && this.destroy();
        },
        renderSkeleton:function() {},
        unrenderSkeleton:function() {},
        renderDates:function() {},
        unrenderDates:function() {},
        triggerRender:function() {
            this.trigger("viewRender", this, this, this.el);
        },
        triggerUnrender:function() {
            this.trigger("viewDestroy", this, this, this.el);
        },
        bindGlobalHandlers:function() {
            this.listenTo(t(document), "mousedown", this.handleDocumentMousedown), this.listenTo(t(document), "touchstart", this.processUnselect);
        },
        unbindGlobalHandlers:function() {
            this.stopListeningTo(t(document));
        },
        initThemingProps:function() {
            var t = this.opt("theme") ? "ui" :"fc";
            this.widgetHeaderClass = t + "-widget-header", this.widgetContentClass = t + "-widget-content",
                this.highlightStateClass = t + "-state-highlight";
        },
        renderBusinessHours:function() {},
        unrenderBusinessHours:function() {},
        startNowIndicator:function() {
            var t, n, i, r = this;
            this.opt("nowIndicator") && (t = this.getNowIndicatorUnit(), t && (n = lt(this, "updateNowIndicator"),
                this.initialNowDate = this.calendar.getNow(), this.initialNowQueriedMs = +new Date(),
                this.renderNowIndicator(this.initialNowDate), this.isNowIndicatorRendered = !0,
                i = this.initialNowDate.clone().startOf(t).add(1, t) - this.initialNowDate, this.nowIndicatorTimeoutID = setTimeout(function() {
                r.nowIndicatorTimeoutID = null, n(), i = +e.duration(1, t), i = Math.max(100, i),
                    r.nowIndicatorIntervalID = setInterval(n, i);
            }, i)));
        },
        updateNowIndicator:function() {
            this.isNowIndicatorRendered && (this.unrenderNowIndicator(), this.renderNowIndicator(this.initialNowDate.clone().add(new Date() - this.initialNowQueriedMs)));
        },
        stopNowIndicator:function() {
            this.isNowIndicatorRendered && (this.nowIndicatorTimeoutID && (clearTimeout(this.nowIndicatorTimeoutID),
                this.nowIndicatorTimeoutID = null), this.nowIndicatorIntervalID && (clearTimeout(this.nowIndicatorIntervalID),
                this.nowIndicatorIntervalID = null), this.unrenderNowIndicator(), this.isNowIndicatorRendered = !1);
        },
        getNowIndicatorUnit:function() {},
        renderNowIndicator:function(t) {},
        unrenderNowIndicator:function() {},
        updateSize:function(t) {
            var e;
            t && (e = this.queryScroll()), this.updateHeight(t), this.updateWidth(t), this.updateNowIndicator(),
            t && this.setScroll(e);
        },
        updateWidth:function(t) {},
        updateHeight:function(t) {
            var e = this.calendar;
            this.setHeight(e.getSuggestedViewHeight(), e.isHeightAuto());
        },
        setHeight:function(t, e) {},
        computeInitialScroll:function(t) {
            return 0;
        },
        queryScroll:function() {},
        setScroll:function(t) {},
        forceScroll:function(t) {
            var e = this;
            this.setScroll(t), setTimeout(function() {
                e.setScroll(t);
            }, 0);
        },
        displayEvents:function(t) {
            var e = this.queryScroll();
            this.clearEvents(), this.renderEvents(t), this.isEventsRendered = !0, this.setScroll(e),
                this.triggerEventRender();
        },
        clearEvents:function() {
            var t;
            this.isEventsRendered && (t = this.queryScroll(), this.triggerEventUnrender(), this.destroyEvents && this.destroyEvents(),
                this.unrenderEvents(), this.setScroll(t), this.isEventsRendered = !1);
        },
        renderEvents:function(t) {},
        unrenderEvents:function() {},
        triggerEventRender:function() {
            this.renderedEventSegEach(function(t) {
                this.trigger("eventAfterRender", t.event, t.event, t.el);
            }), this.trigger("eventAfterAllRender");
        },
        triggerEventUnrender:function() {
            this.renderedEventSegEach(function(t) {
                this.trigger("eventDestroy", t.event, t.event, t.el);
            });
        },
        resolveEventEl:function(e, n) {
            var i = this.trigger("eventRender", e, e, n);
            return i === !1 ? n = null :i && i !== !0 && (n = t(i)), n;
        },
        showEvent:function(t) {
            this.renderedEventSegEach(function(t) {
                t.el.css("visibility", "");
            }, t);
        },
        hideEvent:function(t) {
            this.renderedEventSegEach(function(t) {
                t.el.css("visibility", "hidden");
            }, t);
        },
        renderedEventSegEach:function(t, e) {
            var n, i = this.getEventSegs();
            for (n = 0; n < i.length; n++) e && i[n].event._id !== e._id || i[n].el && t.call(this, i[n]);
        },
        getEventSegs:function() {
            return [];
        },
        isEventDraggable:function(t) {
            return this.isEventStartEditable(t);
        },
        isEventStartEditable:function(t) {
            return J(t.startEditable, (t.source || {}).startEditable, this.opt("eventStartEditable"), this.isEventGenerallyEditable(t));
        },
        isEventGenerallyEditable:function(t) {
            return J(t.editable, (t.source || {}).editable, this.opt("editable"));
        },
        reportEventDrop:function(t, e, n, i, r) {
            var s = this.calendar, o = s.mutateEvent(t, e, n), l = function() {
                o.undo(), s.reportEventChange();
            };
            this.triggerEventDrop(t, o.dateDelta, l, i, r), s.reportEventChange();
        },
        triggerEventDrop:function(t, e, n, i, r) {
            this.trigger("eventDrop", i[0], t, e, n, r, {});
        },
        reportExternalDrop:function(e, n, i, r, s) {
            var o, l, a = e.eventProps;
            a && (o = t.extend({}, a, n), l = this.calendar.renderEvent(o, e.stick)[0]), this.triggerExternalDrop(l, n, i, r, s);
        },
        triggerExternalDrop:function(t, e, n, i, r) {
            this.trigger("drop", n[0], e.start, i, r), t && this.trigger("eventReceive", null, t);
        },
        renderDrag:function(t, e) {},
        unrenderDrag:function() {},
        isEventResizableFromStart:function(t) {
            return this.opt("eventResizableFromStart") && this.isEventResizable(t);
        },
        isEventResizableFromEnd:function(t) {
            return this.isEventResizable(t);
        },
        isEventResizable:function(t) {
            var e = t.source || {};
            return J(t.durationEditable, e.durationEditable, this.opt("eventDurationEditable"), t.editable, e.editable, this.opt("editable"));
        },
        reportEventResize:function(t, e, n, i, r) {
            var s = this.calendar, o = s.mutateEvent(t, e, n), l = function() {
                o.undo(), s.reportEventChange();
            };
            this.triggerEventResize(t, o.durationDelta, l, i, r), s.reportEventChange();
        },
        triggerEventResize:function(t, e, n, i, r) {
            this.trigger("eventResize", i[0], t, e, n, r, {});
        },
        select:function(t, e) {
            this.unselect(e), this.renderSelection(t), this.reportSelection(t, e);
        },
        renderSelection:function(t) {},
        reportSelection:function(t, e) {
            this.isSelected = !0, this.triggerSelect(t, e);
        },
        triggerSelect:function(t, e) {
            this.trigger("select", null, this.calendar.applyTimezone(t.start), this.calendar.applyTimezone(t.end), e);
        },
        unselect:function(t) {
            if(t&&(t.target.classList.contains("ste_mode")||jQuery(t.target).closest(".ste_mode").length>0||t.target.classList.contains("panel")||jQuery(t.target).closest(".panel").length>0)){}else {
                this.isSelected && (this.isSelected = !1, this.destroySelection && this.destroySelection(),
                    this.unrenderSelection(), this.trigger("unselect", null, t));
            }
        },
        unrenderSelection:function() {},
        selectEvent:function(t) {
            this.selectedEvent && this.selectedEvent === t || (this.unselectEvent(), this.renderedEventSegEach(function(t) {
                t.el.addClass("fc-selected");
            }, t), this.selectedEvent = t);
        },
        unselectEvent:function() {
            this.selectedEvent && (this.renderedEventSegEach(function(t) {
                t.el.removeClass("fc-selected");
            }, this.selectedEvent), this.selectedEvent = null);
        },
        isEventSelected:function(t) {
            return this.selectedEvent && this.selectedEvent._id === t._id;
        },
        handleDocumentMousedown:function(t) {
            S(t) && this.processUnselect(t);
        },
        processUnselect:function(t) {
            this.processRangeUnselect(t), this.processEventUnselect(t);
        },
        processRangeUnselect:function(e) {
            var n;
            this.isSelected && this.opt("unselectAuto") && (n = this.opt("unselectCancel"),
            n && t(e.target).closest(n).length || this.unselect(e));
        },
        processEventUnselect:function(e) {
            this.selectedEvent && (t(e.target).closest(".fc-selected").length || this.unselectEvent());
        },
        triggerDayClick:function(t, e, n) {
            this.trigger("dayClick", e, this.calendar.applyTimezone(t.start), n);
        },
        initHiddenDays:function() {
            var e, n = this.opt("hiddenDays") || [], i = [], r = 0;
            for (this.opt("weekends") === !1 && n.push(0, 6), e = 0; e < 7; e++) (i[e] = t.inArray(e, n) !== -1) || r++;
            if (!r) throw "invalid hiddenDays";
            this.isHiddenDayHash = i;
        },
        isHiddenDay:function(t) {
            return e.isMoment(t) && (t = t.day()), this.isHiddenDayHash[t];
        },
        skipHiddenDays:function(t, e, n) {
            var i = t.clone();
            for (e = e || 1; this.isHiddenDayHash[(i.day() + (n ? e :0) + 7) % 7]; ) i.add(e, "days");
            return i;
        },
        computeDayRange:function(t) {
            var e, n = t.start.clone().stripTime(), i = t.end, r = null;
            return i && (r = i.clone().stripTime(), e = +i.time(), e && e >= this.nextDayThreshold && r.add(1, "days")),
            (!i || r <= n) && (r = n.clone().add(1, "days")), {
                start:n,
                end:r
            };
        },
        isMultiDayEvent:function(t) {
            var e = this.computeDayRange(t);
            return e.end.diff(e.start, "days") > 1;
        }
    }), Se = jt.Scroller = wt.extend({
        el:null,
        scrollEl:null,
        overflowX:null,
        overflowY:null,
        constructor:function(t) {
            t = t || {}, this.overflowX = t.overflowX || t.overflow || "auto", this.overflowY = t.overflowY || t.overflow || "auto";
        },
        render:function() {
            this.el = this.renderEl(),
                this.applyOverflow();
        },
        renderEl:function() {
            return this.scrollEl = t('<div class="fc-scroller"></div>');
        },
        clear:function() {
            this.setHeight("auto"), this.applyOverflow();
        },
        destroy:function() {
            this.el.remove();
        },
        applyOverflow:function() {
            this.scrollEl.css({
                "overflow-x":this.overflowX,
                "overflow-y":this.overflowY
            });
        },
        lockOverflow:function(t) {
            var e = this.overflowX, n = this.overflowY;
            t = t || this.getScrollbarWidths(), "auto" === e && (e = t.top || t.bottom || this.scrollEl[0].scrollWidth - 1 > this.scrollEl[0].clientWidth ? "scroll" :"hidden"),
            "auto" === n && (n = t.left || t.right || this.scrollEl[0].scrollHeight - 1 > this.scrollEl[0].clientHeight ? "scroll" :"hidden"),
                this.scrollEl.css({
                    "overflow-x":e,
                    "overflow-y":n
                });
        },
        setHeight:function(t) {
            this.scrollEl.height(t);
        },
        getScrollTop:function() {
            return this.scrollEl.scrollTop();
        },
        setScrollTop:function(t) {
            this.scrollEl.scrollTop(t);
        },
        getClientWidth:function() {
            return this.scrollEl[0].clientWidth;
        },
        getClientHeight:function() {
            return this.scrollEl[0].clientHeight;
        },
        getScrollbarWidths:function() {
            return p(this.scrollEl);
        }
    }), we = jt.Calendar = wt.extend({
        dirDefaults:null,
        localeDefaults:null,
        overrides:null,
        dynamicOverrides:null,
        options:null,
        viewSpecCache:null,
        view:null,
        header:null,
        loadingLevel:0,
        constructor:At,
        initialize:function() {},
        populateOptionsHash:function() {
            var t, e, i, r;
            t = J(this.dynamicOverrides.locale, this.overrides.locale), e = Ee[t], e || (t = we.defaults.locale,
                e = Ee[t] || {}), i = J(this.dynamicOverrides.isRTL, this.overrides.isRTL, e.isRTL, we.defaults.isRTL),
                r = i ? we.rtlDefaults :{}, this.dirDefaults = r, this.localeDefaults = e, this.options = n([ we.defaults, r, e, this.overrides, this.dynamicOverrides ]),
                Vt(this.options);
        },
        getViewSpec:function(t) {
            var e = this.viewSpecCache;
            return e[t] || (e[t] = this.buildViewSpec(t));
        },
        getUnitViewSpec:function(e) {
            var n, i, r;
            if (t.inArray(e, Xt) != -1) for (n = this.header.getViewsWithButtons(), t.each(jt.views, function(t) {
                n.push(t);
            }), i = 0; i < n.length; i++) if (r = this.getViewSpec(n[i]), r && r.singleUnit == e) return r;
        },
        buildViewSpec:function(t) {
            for (var i, r, s, o, l = this.overrides.views || {}, a = [], u = [], c = [], d = t; d; ) i = Ut[d],
                r = l[d], d = null, "function" == typeof i && (i = {
                "class":i
            }), i && (a.unshift(i), u.unshift(i.defaults || {}), s = s || i.duration, d = d || i.type),
            r && (c.unshift(r), s = s || r.duration, d = d || r.type);
            return i = q(a), i.type = t, !!i.class && (s && (s = e.duration(s), s.valueOf() && (i.duration = s,
                o = A(s), 1 === s.as(o) && (i.singleUnit = o, c.unshift(l[o] || {})))), i.defaults = n(u),
                i.overrides = n(c), this.buildViewSpecOptions(i), this.buildViewSpecButtonText(i, t),
                i);
        },
        buildViewSpecOptions:function(t) {
            t.options = n([ we.defaults, t.defaults, this.dirDefaults, this.localeDefaults, this.overrides, t.overrides, this.dynamicOverrides ]),
                Vt(t.options);
        },
        buildViewSpecButtonText:function(t, e) {
            function n(n) {
                var i = n.buttonText || {};
                return i[e] || (t.buttonTextKey ? i[t.buttonTextKey] :null) || (t.singleUnit ? i[t.singleUnit] :null);
            }
            t.buttonTextOverride = n(this.dynamicOverrides) || n(this.overrides) || t.overrides.buttonText,
                t.buttonTextDefault = n(this.localeDefaults) || n(this.dirDefaults) || t.defaults.buttonText || n(we.defaults) || (t.duration ? this.humanizeDuration(t.duration) :null) || e;
        },
        instantiateView:function(t) {
            var e = this.getViewSpec(t);
            return new e.class(this, t, e.options, e.duration);
        },
        isValidViewType:function(t) {
            return Boolean(this.getViewSpec(t));
        },
        pushLoading:function() {
            this.loadingLevel++ || this.trigger("loading", null, !0, this.view);
        },
        popLoading:function() {
            --this.loadingLevel || this.trigger("loading", null, !1, this.view);
        },
        buildSelectSpan:function(t, e) {
            var n, i = this.moment(t).stripZone();
            return n = e ? this.moment(e).stripZone() :i.hasTime() ? i.clone().add(this.defaultTimedEventDuration) :i.clone().add(this.defaultAllDayEventDuration),
            {
                start:i,
                end:n
            };
        }
    });
    we.mixin(oe), we.mixin({
        optionHandlers:null,
        bindOption:function(t, e) {
            this.bindOptions([ t ], e);
        },
        bindOptions:function(t, e) {
            var n, i = {
                func:e,
                names:t
            };
            for (n = 0; n < t.length; n++) this.registerOptionHandlerObj(t[n], i);
            this.triggerOptionHandlerObj(i);
        },
        registerOptionHandlerObj:function(t, e) {
            (this.optionHandlers[t] || (this.optionHandlers[t] = [])).push(e);
        },
        triggerOptionHandlers:function(t) {
            var e, n = this.optionHandlers[t] || [];
            for (e = 0; e < n.length; e++) this.triggerOptionHandlerObj(n[e]);
        },
        triggerOptionHandlerObj:function(t) {
            var e, n = t.names, i = [];
            for (e = 0; e < n.length; e++) i.push(this.options[n[e]]);
            t.func.apply(this, i);
        }
    }), we.defaults = {
        titleRangeSeparator:" – ",
        monthYearFormat:"MMMM YYYY",
        defaultTimedEventDuration:"02:00:00",
        defaultAllDayEventDuration:{
            days:1
        },
        forceEventDuration:!1,
        nextDayThreshold:"09:00:00",
        defaultView:"month",
        aspectRatio:1.35,
        header:{
            left:"title",
            center:"",
            right:"today prev,next"
        },
        weekends:!0,
        weekNumbers:!1,
        weekNumberTitle:"W",
        weekNumberCalculation:"local",
        scrollTime:"06:00:00",
        lazyFetching:!0,
        startParam:"start",
        endParam:"end",
        timezoneParam:"timezone",
        timezone:!1,
        isRTL:!1,
        buttonText:{
            prev:"prev",
            next:"next",
            prevYear:"prev year",
            nextYear:"next year",
            year:"year",
            today:StrackPHP["Today"],
            month:"month",
            week:"week",
            day:"day"
        },
        buttonIcons:{
            prev:"left-single-arrow",
            next:"right-single-arrow",
            prevYear:"left-double-arrow",
            nextYear:"right-double-arrow"
        },
        allDayText:"all-day",
        theme:!1,
        themeButtonIcons:{
            prev:"circle-triangle-w",
            next:"circle-triangle-e",
            prevYear:"seek-prev",
            nextYear:"seek-next"
        },
        dragOpacity:.75,
        dragRevertDuration:500,
        dragScroll:!0,
        unselectAuto:!0,
        dropAccept:"*",
        eventOrder:"title",
        eventLimit:!1,
        eventLimitText:"more",
        eventLimitClick:"popover",
        dayPopoverFormat:"LL",
        handleWindowResize:!0,
        windowResizeDelay:100,
        longPressDelay:1e3
    }, we.englishDefaults = {
        dayPopoverFormat:"dddd, MMMM D"
    }, we.rtlDefaults = {
        header:{
            left:"next,prev today",
            center:"",
            right:"title"
        },
        buttonIcons:{
            prev:"right-single-arrow",
            next:"left-single-arrow",
            prevYear:"right-double-arrow",
            nextYear:"left-double-arrow"
        },
        themeButtonIcons:{
            prev:"circle-triangle-e",
            next:"circle-triangle-w",
            nextYear:"seek-prev",
            prevYear:"seek-next"
        }
    };
    var Ee = jt.locales = {};
    jt.datepickerLocale = function(e, n, i) {
        var r = Ee[e] || (Ee[e] = {});
        r.isRTL = i.isRTL, r.weekNumberTitle = i.weekHeader, t.each(be, function(t, e) {
            r[t] = e(i);
        }), t.datepicker && (t.datepicker.regional[n] = t.datepicker.regional[e] = i, t.datepicker.regional.en = t.datepicker.regional[""],
            t.datepicker.setDefaults(i));
    }, jt.locale = function(e, i) {
        var r, s;
        r = Ee[e] || (Ee[e] = {}), i && (r = Ee[e] = n([ r, i ])), s = Pt(e), t.each(De, function(t, e) {
            null == r[t] && (r[t] = e(s, r));
        }), we.defaults.locale = e;
    };
    var be = {
        buttonText:function(t) {
            return {
                prev:et(t.prevText),
                next:et(t.nextText),
                today:et(t.currentText)
            };
        },
        monthYearFormat:function(t) {
            return t.showMonthAfterYear ? "YYYY[" + t.yearSuffix + "] MMMM" :"MMMM YYYY[" + t.yearSuffix + "]";
        }
    }, De = {
        dayOfMonthFormat:function(t, e) {
            //var n = t.longDateFormat("l");
            var n = "YYYY-M-D";
            return n;
            //return n = n.replace(/^Y+[^\w\s]*|[^\w\s]*Y+$/g, ""), e.isRTL ? n += " ddd" :n = "ddd " + n, n;
        },
        mediumTimeFormat:function(t) {
            return t.longDateFormat("LT").replace(/\s*a$/i, "a");
        },
        smallTimeFormat:function(t) {
            return t.longDateFormat("LT").replace(":mm", "(:mm)").replace(/(\Wmm)$/, "($1)").replace(/\s*a$/i, "a");
        },
        extraSmallTimeFormat:function(t) {
            return t.longDateFormat("LT").replace(":mm", "(:mm)").replace(/(\Wmm)$/, "($1)").replace(/\s*a$/i, "t");
        },
        hourFormat:function(t) {
            return t.longDateFormat("LT").replace(":mm", "").replace(/(\Wmm)$/, "").replace(/\s*a$/i, "a");
        },
        noMeridiemTimeFormat:function(t) {
            return t.longDateFormat("LT").replace(/\s*a$/i, "");
        }
    }, Ce = {
        smallDayDateFormat:function(t) {
            return t.isRTL ? "D dd" :"dd D";
        },
        weekFormat:function(t) {
            return t.isRTL ? "w[ " + t.weekNumberTitle + "]" :"[" + t.weekNumberTitle + " ]w";
        },
        smallWeekFormat:function(t) {
            return t.isRTL ? "w[" + t.weekNumberTitle + "]" :"[" + t.weekNumberTitle + "]w";
        }
    };
    jt.locale("en", we.englishDefaults), jt.sourceNormalizers = [], jt.sourceFetchers = [];
    var He = {
        dataType:"json",
        cache:!1
    }, Te = 1;
    we.prototype.normalizeEvent = function(t) {}, we.prototype.spanContainsSpan = function(t, e) {
        var n = t.start.clone().stripZone(), i = this.getEventEnd(t).stripZone();
        return e.start >= n && e.end <= i;
    }, we.prototype.getPeerEvents = function(t, e) {
        var n, i, r = this.getEventCache(), s = [];
        for (n = 0; n < r.length; n++) i = r[n], e && e._id === i._id || s.push(i);
        return s;
    }, we.prototype.isEventSpanAllowed = function(t, e) {
        var n = e.source || {}, i = J(e.constraint, n.constraint, this.options.eventConstraint), r = J(e.overlap, n.overlap, this.options.eventOverlap);
        return this.isSpanAllowed(t, i, r, e) && (!this.options.eventAllow || this.options.eventAllow(t, e) !== !1);
    }, we.prototype.isExternalSpanAllowed = function(e, n, i) {
        var r, s;
        return i && (r = t.extend({}, i, n), s = this.expandEvent(this.buildEventFromInput(r))[0]),
            s ? this.isEventSpanAllowed(e, s) :this.isSelectionSpanAllowed(e);
    }, we.prototype.isSelectionSpanAllowed = function(t) {
        return this.isSpanAllowed(t, this.options.selectConstraint, this.options.selectOverlap) && (!this.options.selectAllow || this.options.selectAllow(t) !== !1);
    }, we.prototype.isSpanAllowed = function(t, e, n, i) {
        var r, s, o, l, a, u;
        if (null != e && (r = this.constraintToEvents(e))) {
            for (s = !1, l = 0; l < r.length; l++) if (this.spanContainsSpan(r[l], t)) {
                s = !0;
                break;
            }
            if (!s) return !1;
        }
        for (o = this.getPeerEvents(t, i), l = 0; l < o.length; l++) if (a = o[l], this.eventIntersectsRange(a, t)) {
            if (n === !1) return !1;
            if ("function" == typeof n && !n(a, i)) return !1;
            if (i) {
                if (u = J(a.overlap, (a.source || {}).overlap), u === !1) return !1;
                if ("function" == typeof u && !u(i, a)) return !1;
            }
        }
        return !0;
    }, we.prototype.constraintToEvents = function(t) {
        return "businessHours" === t ? this.getCurrentBusinessHourEvents() :"object" == typeof t ? null != t.start ? this.expandEvent(this.buildEventFromInput(t)) :null :this.clientEvents(t);
    }, we.prototype.eventIntersectsRange = function(t, e) {
        var n = t.start.clone().stripZone(), i = this.getEventEnd(t).stripZone();
        return e.start < i && e.end > n;
    };
    var xe = {
        id:"_fcBusinessHours",
        start:"09:00",
        end:"17:00",
        dow:[ 1, 2, 3, 4, 5 ],
        rendering:"inverse-background"
    };
    we.prototype.getCurrentBusinessHourEvents = function(t) {
        return this.computeBusinessHourEvents(t, this.options.businessHours);
    }, we.prototype.computeBusinessHourEvents = function(e, n) {
        return n === !0 ? this.expandBusinessHourEvents(e, [ {} ]) :t.isPlainObject(n) ? this.expandBusinessHourEvents(e, [ n ]) :t.isArray(n) ? this.expandBusinessHourEvents(e, n, !0) :[];
    }, we.prototype.expandBusinessHourEvents = function(e, n, i) {
        var r, s, o = this.getView(), l = [];
        for (r = 0; r < n.length; r++) s = n[r], i && !s.dow || (s = t.extend({}, xe, s),
        e && (s.start = null, s.end = null), l.push.apply(l, this.expandEvent(this.buildEventFromInput(s), o.start, o.end)));
        return l;
    };
    var Re = jt.BasicView = ye.extend({
        scroller:null,
        dayGridClass:ve,
        dayGrid:null,
        dayNumbersVisible:!1,
        colWeekNumbersVisible:!1,
        cellWeekNumbersVisible:!1,
        weekNumberWidth:null,
        headContainerEl:null,
        headRowEl:null,
        initialize:function() {
            this.dayGrid = this.instantiateDayGrid(), this.scroller = new Se({
                overflowX:"hidden",
                overflowY:"auto"
            });
        },
        instantiateDayGrid:function() {
            var t = this.dayGridClass.extend(Ie);
            return new t(this);
        },
        setRange:function(t) {
            ye.prototype.setRange.call(this, t), this.dayGrid.breakOnWeeks = /year|month|week/.test(this.intervalUnit),
                this.dayGrid.setRange(t);
        },
        computeRange:function(t) {
            var e = ye.prototype.computeRange.call(this, t);
            return /year|month/.test(e.intervalUnit) && (e.start.startOf("week"), e.start = this.skipHiddenDays(e.start),
            e.end.weekday() && (e.end.add(1, "week").startOf("week"), e.end = this.skipHiddenDays(e.end, -1, !0))),
                e;
        },
        renderDates:function() {
            this.dayNumbersVisible = this.dayGrid.rowCnt > 1, this.opt("weekNumbers") && (this.opt("weekNumbersWithinDays") ? (this.cellWeekNumbersVisible = !0,
                this.colWeekNumbersVisible = !1) :(this.cellWeekNumbersVisible = !1, this.colWeekNumbersVisible = !0)),
                this.dayGrid.numbersVisible = this.dayNumbersVisible || this.cellWeekNumbersVisible || this.colWeekNumbersVisible,
                this.el.addClass("fc-basic-view").html(this.renderSkeletonHtml()), this.renderHead(),
                this.scroller.render();
            var e = this.scroller.el.addClass("fc-day-grid-container"), n = t('<div class="fc-day-grid" />').appendTo(e);
            this.el.find(".fc-body > tr > td").append(e), this.dayGrid.setElement(n), this.dayGrid.renderDates(this.hasRigidRows());
        },
        renderHead:function() {
            this.headContainerEl = this.el.find(".fc-head-container").html(this.dayGrid.renderHeadHtml()),
                this.headRowEl = this.headContainerEl.find(".fc-row");
        },
        unrenderDates:function() {
            this.dayGrid.unrenderDates(), this.dayGrid.removeElement(), this.scroller.destroy();
        },
        renderBusinessHours:function() {
            this.dayGrid.renderBusinessHours();
        },
        unrenderBusinessHours:function() {
            this.dayGrid.unrenderBusinessHours();
        },
        renderSkeletonHtml:function() {
            return '<table><thead class="fc-head"><tr><td class="fc-head-container ' + this.widgetHeaderClass + '"></td></tr></thead><tbody class="fc-body"><tr><td class="' + this.widgetContentClass + '"></td></tr></tbody></table>';
        },
        weekNumberStyleAttr:function() {
            return null !== this.weekNumberWidth ? 'style="width:' + this.weekNumberWidth + 'px"' :"";
        },
        hasRigidRows:function() {
            var t = this.opt("eventLimit");
            return t && "number" != typeof t;
        },
        updateWidth:function() {
            this.colWeekNumbersVisible && (this.weekNumberWidth = u(this.el.find(".fc-week-number")));
        },
        setHeight:function(t, e) {
            var n, s, o = this.opt("eventLimit");
            this.scroller.clear(), r(this.headRowEl), this.dayGrid.removeSegPopover(), o && "number" == typeof o && this.dayGrid.limitRows(o),
                n = this.computeScrollerHeight(t), this.setGridHeight(n, e), o && "number" != typeof o && this.dayGrid.limitRows(o),
            e || (this.scroller.setHeight(n), s = this.scroller.getScrollbarWidths(), (s.left || s.right) && (i(this.headRowEl, s),
                n = this.computeScrollerHeight(t), this.scroller.setHeight(n)), this.scroller.lockOverflow(s));
        },
        computeScrollerHeight:function(t) {
            return t - c(this.el, this.scroller.el);
        },
        setGridHeight:function(t, e) {
            e ? a(this.dayGrid.rowEls) :l(this.dayGrid.rowEls, t, !0);
        },
        queryScroll:function() {
            return this.scroller.getScrollTop();
        },
        setScroll:function(t) {
            this.scroller.setScrollTop(t);
        },
        prepareHits:function() {
            this.dayGrid.prepareHits();
        },
        releaseHits:function() {
            this.dayGrid.releaseHits();
        },
        queryHit:function(t, e) {
            return this.dayGrid.queryHit(t, e);
        },
        getHitSpan:function(t) {
            return this.dayGrid.getHitSpan(t);
        },
        getHitEl:function(t) {
            return this.dayGrid.getHitEl(t);
        },
        renderEvents:function(t) {
            this.dayGrid.renderEvents(t), this.updateHeight();
        },
        getEventSegs:function() {
            return this.dayGrid.getEventSegs();
        },
        unrenderEvents:function() {
            this.dayGrid.unrenderEvents();
        },
        renderDrag:function(t, e) {
            return this.dayGrid.renderDrag(t, e);
        },
        unrenderDrag:function() {
            this.dayGrid.unrenderDrag();
        },
        renderSelection:function(t) {
            this.dayGrid.renderSelection(t);
        },
        unrenderSelection:function() {
            this.dayGrid.unrenderSelection();
        }
    }), Ie = {
        renderHeadIntroHtml:function() {
            var t = this.view;
            return t.colWeekNumbersVisible ? '<th class="fc-week-number ' + t.widgetHeaderClass + '" ' + t.weekNumberStyleAttr() + "><span>" + tt(t.opt("weekNumberTitle")) + "</span></th>" :"";
        },
        renderNumberIntroHtml:function(t) {
            var e = this.view, n = this.getCellDate(t, 0);
            return e.colWeekNumbersVisible ? '<td class="fc-week-number" ' + e.weekNumberStyleAttr() + ">" + e.buildGotoAnchorHtml({
                date:n,
                type:"week",
                forceOff:1 === this.colCnt
            }, n.format("w")) + "</td>" :"";
        },
        renderBgIntroHtml:function() {
            var t = this.view;
            return t.colWeekNumbersVisible ? '<td class="fc-week-number ' + t.widgetContentClass + '" ' + t.weekNumberStyleAttr() + "></td>" :"";
        },
        renderIntroHtml:function() {
            var t = this.view;
            return t.colWeekNumbersVisible ? '<td class="fc-week-number" ' + t.weekNumberStyleAttr() + "></td>" :"";
        }
    }, ke = jt.MonthView = Re.extend({
        computeRange:function(t) {
            var e, n = Re.prototype.computeRange.call(this, t);
            return this.isFixedWeeks() && (e = Math.ceil(n.end.diff(n.start, "weeks", !0)),
                n.end.add(6 - e, "weeks")), n;
        },
        setGridHeight:function(t, e) {
            e && (t *= this.rowCnt / 6), l(this.dayGrid.rowEls, t, !e);
        },
        isFixedWeeks:function() {
            return this.opt("fixedWeekCount");
        }
    });
    Ut.basic = {
        "class":Re
    }, Ut.basicDay = {
        type:"basic",
        duration:{
            days:1
        }
    }, Ut.basicWeek = {
        type:"basic",
        duration:{
            weeks:1
        }
    }, Ut.month = {
        "class":ke,
        duration:{
            months:1
        },
        defaults:{
            fixedWeekCount:!0
        }
    };
    var Le = jt.AgendaView = ye.extend({
        scroller:null,
        timeGridClass:me,
        timeGrid:null,
        dayGridClass:ve,
        dayGrid:null,
        axisWidth:null,
        headContainerEl:null,
        noScrollRowEls:null,
        bottomRuleEl:null,
        initialize:function() {
            this.timeGrid = this.instantiateTimeGrid(), this.opt("allDaySlot") && (this.dayGrid = this.instantiateDayGrid()),
                this.scroller = new Se({
                    overflowX:"hidden",
                    overflowY:"auto"
                });
        },
        instantiateTimeGrid:function() {
            var t = this.timeGridClass.extend(Me);
            return new t(this);
        },
        instantiateDayGrid:function() {
            var t = this.dayGridClass.extend(ze);
            return new t(this);
        },
        setRange:function(t) {
            ye.prototype.setRange.call(this, t), this.timeGrid.setRange(t), this.dayGrid && this.dayGrid.setRange(t);
        },
        renderDates:function() {
            this.el.addClass("fc-agenda-view").html(this.renderSkeletonHtml()), this.renderHead(),
                this.scroller.render();
            var e = this.scroller.el.addClass("fc-time-grid-container"), n = t('<div class="fc-time-grid" />').appendTo(e);
            this.el.find(".fc-body > tr > td").append(e), this.timeGrid.setElement(n), this.timeGrid.renderDates(),
                this.bottomRuleEl = t('<hr class="fc-divider ' + this.widgetHeaderClass + '"/>').appendTo(this.timeGrid.el),
            this.dayGrid && (this.dayGrid.setElement(this.el.find(".fc-day-grid")), this.dayGrid.renderDates(),
                this.dayGrid.bottomCoordPadding = this.dayGrid.el.next("hr").outerHeight()), this.noScrollRowEls = this.el.find(".fc-row:not(.fc-scroller *)");
        },
        renderHead:function() {
            this.headContainerEl = this.el.find(".fc-head-container").html(this.timeGrid.renderHeadHtml());
        },
        unrenderDates:function() {
            this.timeGrid.unrenderDates(), this.timeGrid.removeElement(), this.dayGrid && (this.dayGrid.unrenderDates(),
                this.dayGrid.removeElement()), this.scroller.destroy();
        },
        renderSkeletonHtml:function() {
            return '<table><thead class="fc-head"><tr><td class="fc-head-container ' + this.widgetHeaderClass + '"></td></tr></thead><tbody class="fc-body"><tr><td class="' + this.widgetContentClass + '">' + (this.dayGrid ? '<div class="fc-day-grid"/><hr class="fc-divider ' + this.widgetHeaderClass + '"/>' :"") + "</td></tr></tbody></table>";
        },
        axisStyleAttr:function() {
            return null !== this.axisWidth ? 'style="width:' + this.axisWidth + 'px"' :"";
        },
        renderBusinessHours:function() {
            this.timeGrid.renderBusinessHours(), this.dayGrid && this.dayGrid.renderBusinessHours();
        },
        unrenderBusinessHours:function() {
            this.timeGrid.unrenderBusinessHours(), this.dayGrid && this.dayGrid.unrenderBusinessHours();
        },
        getNowIndicatorUnit:function() {
            return this.timeGrid.getNowIndicatorUnit();
        },
        renderNowIndicator:function(t) {
            this.timeGrid.renderNowIndicator(t);
        },
        unrenderNowIndicator:function() {
            this.timeGrid.unrenderNowIndicator();
        },
        updateSize:function(t) {
            this.timeGrid.updateSize(t), ye.prototype.updateSize.call(this, t);
        },
        updateWidth:function() {
            this.axisWidth = u(this.el.find(".fc-axis"));
        },
        setHeight:function(t, e) {
            var n, s, o;
            this.bottomRuleEl.hide(), this.scroller.clear(), r(this.noScrollRowEls), this.dayGrid && (this.dayGrid.removeSegPopover(),
                n = this.opt("eventLimit"), n && "number" != typeof n && (n = Be), n && this.dayGrid.limitRows(n)),
            e || (s = this.computeScrollerHeight(t), this.scroller.setHeight(s), o = this.scroller.getScrollbarWidths(),
            (o.left || o.right) && (i(this.noScrollRowEls, o), s = this.computeScrollerHeight(t),
                this.scroller.setHeight(s)), this.scroller.lockOverflow(o), this.timeGrid.getTotalSlatHeight() < s && this.bottomRuleEl.show());
        },
        computeScrollerHeight:function(t) {
            return t - c(this.el, this.scroller.el);
        },
        computeInitialScroll:function() {
            var t = e.duration(this.opt("scrollTime")), n = this.timeGrid.computeTimeTop(t);
            return n = Math.ceil(n), n && n++, n;
        },
        queryScroll:function() {
            return this.scroller.getScrollTop();
        },
        setScroll:function(t) {
            this.scroller.setScrollTop(t);
        },
        prepareHits:function() {
            this.timeGrid.prepareHits(), this.dayGrid && this.dayGrid.prepareHits();
        },
        releaseHits:function() {
            this.timeGrid.releaseHits(), this.dayGrid && this.dayGrid.releaseHits();
        },
        queryHit:function(t, e) {
            var n = this.timeGrid.queryHit(t, e);
            return !n && this.dayGrid && (n = this.dayGrid.queryHit(t, e)), n;
        },
        getHitSpan:function(t) {
            return t.component.getHitSpan(t);
        },
        getHitEl:function(t) {
            return t.component.getHitEl(t);
        },
        renderEvents:function(t) {
            var e, n, i = [], r = [], s = [];
            for (n = 0; n < t.length; n++) t[n].allDay ? i.push(t[n]) :r.push(t[n]);
            e = this.timeGrid.renderEvents(r), this.dayGrid && (s = this.dayGrid.renderEvents(i)),
                this.updateHeight();
        },
        getEventSegs:function() {
            return this.timeGrid.getEventSegs().concat(this.dayGrid ? this.dayGrid.getEventSegs() :[]);
        },
        unrenderEvents:function() {
            this.timeGrid.unrenderEvents(), this.dayGrid && this.dayGrid.unrenderEvents();
        },
        renderDrag:function(t, e) {
            return t.start.hasTime() ? this.timeGrid.renderDrag(t, e) :this.dayGrid ? this.dayGrid.renderDrag(t, e) :void 0;
        },
        unrenderDrag:function() {
            this.timeGrid.unrenderDrag(), this.dayGrid && this.dayGrid.unrenderDrag();
        },
        renderSelection:function(t) {
            t.start.hasTime() || t.end.hasTime() ? this.timeGrid.renderSelection(t) :this.dayGrid && this.dayGrid.renderSelection(t);
        },
        unrenderSelection:function() {
            this.timeGrid.unrenderSelection(),
            this.dayGrid && this.dayGrid.unrenderSelection();
        }
    }), Me = {
        renderHeadIntroHtml:function() {
            var t, e = this.view;
            return e.opt("weekNumbers") ? (t = this.start.format(e.opt("smallWeekFormat")),
            '<th class="fc-axis fc-week-number ' + e.widgetHeaderClass + '" ' + e.axisStyleAttr() + ">" + e.buildGotoAnchorHtml({
                date:this.start,
                type:"week",
                forceOff:this.colCnt > 1
            }, tt(t)) + "</th>") :'<th class="fc-axis ' + e.widgetHeaderClass + '" ' + e.axisStyleAttr() + "></th>";
        },
        renderBgIntroHtml:function() {
            var t = this.view;
            return '<td class="fc-axis ' + t.widgetContentClass + '" ' + t.axisStyleAttr() + "></td>";
        },
        renderIntroHtml:function() {
            var t = this.view;
            return '<td class="fc-axis" ' + t.axisStyleAttr() + "></td>";
        }
    }, ze = {
        renderBgIntroHtml:function() {
            var t = this.view;
            return '<td class="fc-axis ' + t.widgetContentClass + '" ' + t.axisStyleAttr() + "><span>" + t.getAllDayHtml() + "</span></td>";
        },
        renderIntroHtml:function() {
            var t = this.view;
            return '<td class="fc-axis" ' + t.axisStyleAttr() + "></td>";
        }
    }, Be = 5, Fe = [ {
        hours:1
    }, {
        minutes:30
    }, {
        minutes:15
    }, {
        seconds:30
    }, {
        seconds:15
    } ];
    Ut.agenda = {
        "class":Le,
        defaults:{
            allDaySlot:!0,
            slotDuration:"00:30:00",
            minTime:"00:00:00",
            maxTime:"24:00:00",
            slotEventOverlap:!0
        }
    }, Ut.agendaDay = {
        type:"agenda",
        duration:{
            days:1
        }
    }, Ut.agendaWeek = {
        type:"agenda",
        duration:{
            weeks:1
        }
    };
    var Ne = ye.extend({
        grid:null,
        scroller:null,
        initialize:function() {
            this.grid = new Ge(this), this.scroller = new Se({
                overflowX:"hidden",
                overflowY:"auto"
            });
        },
        setRange:function(t) {
            ye.prototype.setRange.call(this, t), this.grid.setRange(t);
        },
        renderSkeleton:function() {
            this.el.addClass("fc-list-view " + this.widgetContentClass), this.scroller.render(),
                this.scroller.el.appendTo(this.el), this.grid.setElement(this.scroller.scrollEl);
        },
        unrenderSkeleton:function() {
            this.scroller.destroy();
        },
        setHeight:function(t, e) {
            this.scroller.setHeight(this.computeScrollerHeight(t));
        },
        computeScrollerHeight:function(t) {
            return t - c(this.el, this.scroller.el);
        },
        renderEvents:function(t) {
            this.grid.renderEvents(t);
        },
        unrenderEvents:function() {
            this.grid.unrenderEvents();
        },
        isEventResizable:function(t) {
            return !1;
        },
        isEventDraggable:function(t) {
            return !1;
        }
    }), Ge = ge.extend({
        segSelector:".fc-list-item",
        hasDayInteractions:!1,
        spanToSegs:function(t) {
            for (var e, n, i = this.view, r = i.start.clone(), s = []; r < i.end; ) e = r.clone().add(1, "day"),
                n = F(t, {
                    start:r,
                    end:e
                }), n && s.push(n), r = e;
            return s;
        },
        computeEventTimeFormat:function() {
            return this.view.opt("mediumTimeFormat");
        },
        handleSegClick:function(e, n) {
            var i;
            ge.prototype.handleSegClick.apply(this, arguments), t(n.target).closest("a[href]").length || (i = e.event.url,
            i && !n.isDefaultPrevented() && (window.location.href = i));
        },
        renderFgSegs:function(t) {
            return t = this.renderFgSegEls(t), t.length ? this.renderSegList(t) :(this.renderEmptyMessage(),
                t);
        },
        renderEmptyMessage:function() {
            this.el.html('<div class="fc-list-empty-wrap2"><div class="fc-list-empty-wrap1"><div class="fc-list-empty">' + tt(this.view.opt("noEventsMessage")) + "</div></div></div>");
        },
        renderSegList:function(e) {
            var n, i, r, s = t('<table class="fc-list-table"><tbody/></table>'), o = s.find("tbody");
            for (this.sortEventSegs(e), n = 0; n < e.length; n++) i = e[n], r && i.start.isSame(r, "day") || (r = i.start.clone().stripTime(),
                o.append(this.dayHeaderHtml(r))), o.append(i.el);
            return this.el.empty().append(s), e;
        },
        dayHeaderHtml:function(t) {
            var e = this.view, n = e.opt("listDayFormat"), i = e.opt("listDayAltFormat");
            return '<tr class="fc-list-heading" data-date="' + t.format("YYYY-MM-DD") + '"><td class="' + e.widgetHeaderClass + '" colspan="3">' + (n ? e.buildGotoAnchorHtml(t, {
                    "class":"fc-list-heading-main"
                }, tt(t.format(n))) :"") + (i ? e.buildGotoAnchorHtml(t, {
                    "class":"fc-list-heading-alt"
                }, tt(t.format(i))) :"") + "</td></tr>";
        },
        fgSegHtml:function(t) {
            var e, n = this.view, i = [ "fc-list-item" ].concat(this.getSegCustomClasses(t)), r = this.getSegBackgroundColor(t), s = t.event, o = s.url;
            return t.start.hasTime() ? e = tt(this.getEventTimeText(s)) :this.displayEventTime && (e = n.getAllDayHtml()),
            o && i.push("fc-has-url"), '<tr class="' + i.join(" ") + '">' + (e ? '<td class="fc-list-item-time ' + n.widgetContentClass + '">' + e + "</td>" :"") + '<td class="fc-list-item-marker ' + n.widgetContentClass + '"><span class="fc-event-dot"' + (r ? ' style="background-color:' + r + '"' :"") + '></span></td><td class="fc-list-item-title ' + n.widgetContentClass + '"><a' + (o ? ' href="' + tt(o) + '"' :"") + ">" + tt(t.event.title) + "</a></td></tr>";
        }
    });
    return Ut.list = {
        "class":Ne,
        buttonTextKey:"list",
        defaults:{
            buttonText:"list",
            listTime:!0,
            listDayFormat:"LL",
            noEventsMessage:StrackPHP["No_Events_Need_Show"]
        }
    }, Ut.listDay = {
        type:"list",
        duration:{
            days:1
        },
        defaults:{
            listDayFormat:"dddd"
        }
    }, Ut.listWeek = {
        type:"list",
        duration:{
            weeks:1
        },
        defaults:{
            listDayFormat:"dddd",
            listDayAltFormat:"LL"
        }
    }, Ut.listMonth = {
        type:"list",
        duration:{
            month:1
        },
        defaults:{
            listDayAltFormat:"dddd"
        }
    }, Ut.listYear = {
        type:"list",
        duration:{
            year:1
        },
        defaults:{
            listDayAltFormat:"dddd"
        }
    }, jt;
});
//scheduler
(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define([ 'jquery', 'moment', 'fullcalendar' ], factory);
    }
    else if (typeof exports === 'object') { // Node/CommonJS
        module.exports = factory(
            require('jquery'),
            require('moment'),
            require('fullcalendar')
        );
    }
    else {
        factory(jQuery, moment);
    }
})(function($, moment) {;
    var COL_MIN_WIDTH, Calendar, CalendarExtension, Class, ClippedScroller, CoordCache, DEFAULT_GRID_DURATION, DragListener, EmitterMixin, EnhancedScroller, EventRow, FC, Grid, HRowGroup, LICENSE_INFO_URL, ListenerMixin, MAX_AUTO_CELLS, MAX_AUTO_SLOTS_PER_LABEL, MAX_CELLS, MIN_AUTO_LABELS, PRESET_LICENSE_KEYS, RELEASE_DATE, ResourceAgendaView, ResourceBasicView, ResourceDayGrid, ResourceDayTableMixin, ResourceGridMixin, ResourceManager, ResourceMonthView, ResourceRow, ResourceTimeGrid, ResourceTimelineGrid, ResourceTimelineView, ResourceViewMixin, RowGroup, RowParent, STOCK_SUB_DURATIONS, ScrollFollower, ScrollFollowerSprite, ScrollJoiner, ScrollerCanvas, Spreadsheet, TimelineGrid, TimelineView, UPGRADE_WINDOW, VRowGroup, View, applyAll, capitaliseFirstLetter, compareByFieldSpecs, computeIntervalUnit, computeOffsetForSeg, computeOffsetForSegs, copyRect, cssToStr, debounce, detectWarningInContainer, divideDurationByDuration, divideRangeByDuration, durationHasTime, flexibleCompare, getContentRect, getOuterRect, getOwnCells, getRectHeight, getRectWidth, getScrollbarWidths, hContainRect, htmlEscape, intersectRanges, intersectRects, isImmuneUrl, isInt, isValidKey, joinRects, multiplyDuration, origDisplayEvents, origDisplayView, origGetSegCustomClasses, origGetSegDefaultBackgroundColor, origGetSegDefaultBorderColor, origGetSegDefaultTextColor, origRenderSkeleton, origUnrenderSkeleton, parseFieldSpecs, processLicenseKey, proxy, renderingWarningInContainer, syncThen, testRectContains, testRectHContains, testRectVContains, timeRowSegsCollide, vContainRect,
        extend = function(child, parent) { for (var key in parent) { if (hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; },
        hasProp = {}.hasOwnProperty,
        indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
        slice = [].slice;

    FC = $.fullCalendar;

    FC.schedulerVersion = "1.4.0";

    if (FC.internalApiVersion !== 6) {
        FC.warn('v' + FC.schedulerVersion + ' of FullCalendar Scheduler ' + 'is incompatible with v' + FC.version + ' of the core.');
        return;
    }

    Calendar = FC.Calendar;

    Class = FC.Class;

    View = FC.View;

    Grid = FC.Grid;

    intersectRanges = FC.intersectRanges;

    debounce = FC.debounce;

    isInt = FC.isInt;

    getScrollbarWidths = FC.getScrollbarWidths;

    DragListener = FC.DragListener;

    htmlEscape = FC.htmlEscape;

    computeIntervalUnit = FC.computeIntervalUnit;

    proxy = FC.proxy;

    capitaliseFirstLetter = FC.capitaliseFirstLetter;

    applyAll = FC.applyAll;

    EmitterMixin = FC.EmitterMixin;

    ListenerMixin = FC.ListenerMixin;

    durationHasTime = FC.durationHasTime;

    divideRangeByDuration = FC.divideRangeByDuration;

    divideDurationByDuration = FC.divideDurationByDuration;

    multiplyDuration = FC.multiplyDuration;

    parseFieldSpecs = FC.parseFieldSpecs;

    compareByFieldSpecs = FC.compareByFieldSpecs;

    flexibleCompare = FC.flexibleCompare;

    intersectRects = FC.intersectRects;

    CoordCache = FC.CoordCache;

    getContentRect = FC.getContentRect;

    getOuterRect = FC.getOuterRect;


    /*
     Given a jQuery <tr> set, returns the <td>'s that do not have multi-line rowspans.
     Would use the [rowspan] selector, but never not defined in IE8.
     */

    getOwnCells = function(trs) {
        return trs.find('> td').filter(function(i, tdNode) {
            return tdNode.rowSpan <= 1;
        });
    };


    /*
     HACK to combat jQuery 3 promises now always executed done handlers asynchronously.
     if the promise is resolved, or not a promise at all, doneFunc executes immediately.
     if the promise has already been rejected, failFunc executes immediately.
     */

    syncThen = function(promise, doneFunc, failFunc) {
        if (!promise || !promise.then || promise.state() === 'resolved') {
            if (doneFunc) {
                return $.when(doneFunc());
            } else {
                return $.when();
            }
        } else if (promise.state() === 'rejected') {
            if (failFunc) {
                failFunc();
            }
            return $.Deferred().reject().promise();
        } else {
            return promise.then(doneFunc, failFunc);
        }
    };


    /*
     A Scroller with additional functionality:
     - optional ScrollerCanvas for content
     - fired events for scroll start/end
     - cross-browser normalization of horizontal scroll for RTL
     */

    EnhancedScroller = (function(superClass) {
        var detectRtlScrollSystem, rtlScrollSystem;

        extend(EnhancedScroller, superClass);

        EnhancedScroller.mixin(EmitterMixin);

        EnhancedScroller.mixin(ListenerMixin);

        EnhancedScroller.prototype.canvas = null;

        EnhancedScroller.prototype.isScrolling = false;

        EnhancedScroller.prototype.isTouching = false;

        EnhancedScroller.prototype.isMoving = false;

        EnhancedScroller.prototype.isTouchScrollEnabled = true;

        EnhancedScroller.prototype.preventTouchScrollHandler = null;

        function EnhancedScroller() {
            EnhancedScroller.__super__.constructor.apply(this, arguments);
            this.requestMovingEnd = debounce(this.reportMovingEnd, 500);
        }

        EnhancedScroller.prototype.render = function() {
            EnhancedScroller.__super__.render.apply(this, arguments);
            if (this.canvas) {
                this.canvas.render();
                this.canvas.el.appendTo(this.scrollEl);
            }
            return this.bindHandlers();
        };

        EnhancedScroller.prototype.destroy = function() {
            EnhancedScroller.__super__.destroy.apply(this, arguments);
            return this.unbindHandlers();
        };

        EnhancedScroller.prototype.disableTouchScroll = function() {
            this.isTouchScrollEnabled = false;
            return this.bindPreventTouchScroll();
        };

        EnhancedScroller.prototype.enableTouchScroll = function() {
            this.isTouchScrollEnabled = true;
            if (!this.isTouching) {
                return this.unbindPreventTouchScroll();
            }
        };

        EnhancedScroller.prototype.bindPreventTouchScroll = function() {
            if (!this.preventTouchScrollHandler) {
                return this.scrollEl.on('touchmove', this.preventTouchScrollHandler = FC.preventDefault);
            }
        };

        EnhancedScroller.prototype.unbindPreventTouchScroll = function() {
            if (this.preventTouchScrollHandler) {
                this.scrollEl.off('touchmove', this.preventTouchScrollHandler);
                return this.preventTouchScrollHandler = null;
            }
        };

        EnhancedScroller.prototype.bindHandlers = function() {
            return this.listenTo(this.scrollEl, {
                scroll: this.reportScroll,
                touchstart: this.reportTouchStart,
                touchend: this.reportTouchEnd
            });
        };

        EnhancedScroller.prototype.unbindHandlers = function() {
            return this.stopListeningTo(this.scrollEl);
        };

        EnhancedScroller.prototype.reportScroll = function() {
            if (!this.isScrolling) {
                this.reportScrollStart();
            }
            this.trigger('scroll');
            this.isMoving = true;
            return this.requestMovingEnd();
        };

        EnhancedScroller.prototype.reportScrollStart = function() {
            if (!this.isScrolling) {
                this.isScrolling = true;
                return this.trigger('scrollStart', this.isTouching);
            }
        };

        EnhancedScroller.prototype.requestMovingEnd = null;

        EnhancedScroller.prototype.reportMovingEnd = function() {
            this.isMoving = false;
            if (!this.isTouching) {
                return this.reportScrollEnd();
            }
        };

        EnhancedScroller.prototype.reportScrollEnd = function() {
            if (this.isScrolling) {
                this.trigger('scrollEnd');
                return this.isScrolling = false;
            }
        };

        EnhancedScroller.prototype.reportTouchStart = function() {
            return this.isTouching = true;
        };

        EnhancedScroller.prototype.reportTouchEnd = function() {
            if (this.isTouching) {
                this.isTouching = false;
                if (this.isTouchScrollEnabled) {
                    this.unbindPreventTouchScroll();
                }
                if (!this.isMoving) {
                    return this.reportScrollEnd();
                }
            }
        };


        /*
         If RTL, and scrolled to the left, returns NEGATIVE value (like Firefox)
         */

        EnhancedScroller.prototype.getScrollLeft = function() {
            var direction, node, val;
            direction = this.scrollEl.css('direction');
            node = this.scrollEl[0];
            val = node.scrollLeft;
            if (direction === 'rtl') {
                switch (rtlScrollSystem) {
                    case 'positive':
                        val = val + node.clientWidth - node.scrollWidth;
                        break;
                    case 'reverse':
                        val = -val;
                }
            }
            return val;
        };


        /*
         Accepts a NEGATIVE value for when scrolled in RTL
         */

        EnhancedScroller.prototype.setScrollLeft = function(val) {
            var direction, node;
            direction = this.scrollEl.css('direction');
            node = this.scrollEl[0];
            if (direction === 'rtl') {
                switch (rtlScrollSystem) {
                    case 'positive':
                        val = val - node.clientWidth + node.scrollWidth;
                        break;
                    case 'reverse':
                        val = -val;
                }
            }
            return node.scrollLeft = val;
        };


        /*
         Always returns the number of pixels scrolled from the leftmost position (even if RTL).
         Always positive.
         */

        EnhancedScroller.prototype.getScrollFromLeft = function() {
            var direction, node, val;
            direction = this.scrollEl.css('direction');
            node = this.scrollEl[0];
            val = node.scrollLeft;
            if (direction === 'rtl') {
                switch (rtlScrollSystem) {
                    case 'negative':
                        val = val - node.clientWidth + node.scrollWidth;
                        break;
                    case 'reverse':
                        val = -val - node.clientWidth + node.scrollWidth;
                }
            }
            return val;
        };

        EnhancedScroller.prototype.getNativeScrollLeft = function() {
            return this.scrollEl[0].scrollLeft;
        };

        EnhancedScroller.prototype.setNativeScrollLeft = function(val) {
            return this.scrollEl[0].scrollLeft = val;
        };

        rtlScrollSystem = null;

        detectRtlScrollSystem = function() {
            var el, node, system;
            el = $('<div style=" position: absolute top: -1000px; width: 1px; height: 1px; overflow: scroll; direction: rtl; font-size: 14px; ">A</div>').appendTo('body');
            node = el[0];
            system = node.scrollLeft > 0 ? 'positive' : (node.scrollLeft = 1, el.scrollLeft > 0 ? 'reverse' : 'negative');
            el.remove();
            return system;
        };

        $(function() {
            return rtlScrollSystem = detectRtlScrollSystem();
        });

        return EnhancedScroller;

    })(FC.Scroller);


    /*
     A Scroller, but with a wrapping div that allows "clipping" away of native scrollbars,
     giving the appearance that there are no scrollbars.
     */

    ClippedScroller = (function(superClass) {
        extend(ClippedScroller, superClass);

        ClippedScroller.prototype.isHScrollbarsClipped = false;

        ClippedScroller.prototype.isVScrollbarsClipped = false;


        /*
         Received overflows can be set to 'clipped', meaning scrollbars shouldn't be visible
         to the user, but the area should still scroll.
         */

        function ClippedScroller() {
            ClippedScroller.__super__.constructor.apply(this, arguments);
            if (this.overflowX === 'clipped-scroll') {
                this.overflowX = 'scroll';
                this.isHScrollbarsClipped = true;
            }
            if (this.overflowY === 'clipped-scroll') {
                this.overflowY = 'scroll';
                this.isVScrollbarsClipped = true;
            }
        }

        ClippedScroller.prototype.renderEl = function() {
            var scrollEl;
            scrollEl = ClippedScroller.__super__.renderEl.apply(this, arguments);
            return $('<div class="fc-scroller-clip" />').append(scrollEl);
        };

        ClippedScroller.prototype.updateSize = function() {
            var cssProps, scrollEl, scrollbarWidths;
            scrollEl = this.scrollEl;
            scrollbarWidths = getScrollbarWidths(scrollEl);
            cssProps = {
                marginLeft: 0,
                marginRight: 0,
                marginTop: 0,
                marginBottom: 0
            };
            if (this.isHScrollbarsClipped) {
                cssProps.marginTop = -scrollbarWidths.top;
                cssProps.marginBottom = -scrollbarWidths.bottom;
            }
            if (this.isVScrollbarsClipped) {
                cssProps.marginLeft = -scrollbarWidths.left;
                cssProps.marginRight = -scrollbarWidths.right;
            }
            scrollEl.css(cssProps);
            return scrollEl.toggleClass('fc-no-scrollbars', (this.isHScrollbarsClipped || this.overflowX === 'hidden') && (this.isVScrollbarsClipped || this.overflowY === 'hidden') && !(scrollbarWidths.top || scrollbarWidths.bottom || scrollbarWidths.left || scrollbarWidths.right));
        };


        /*
         Accounts for 'clipped' scrollbars
         */

        ClippedScroller.prototype.getScrollbarWidths = function() {
            var widths;
            widths = getScrollbarWidths(this.scrollEl);
            if (this.isHScrollbarsClipped) {
                widths.top = 0;
                widths.bottom = 0;
            }
            if (this.isVScrollbarsClipped) {
                widths.left = 0;
                widths.right = 0;
            }
            return widths;
        };

        return ClippedScroller;

    })(EnhancedScroller);


    /*
     A rectangular area of content that lives within a Scroller.
     Can have "gutters", areas of dead spacing around the perimeter.
     Also very useful for forcing a width, which a Scroller cannot do alone.
     Has a content area that lives above a background area.
     */

    ScrollerCanvas = (function() {
        ScrollerCanvas.prototype.el = null;

        ScrollerCanvas.prototype.contentEl = null;

        ScrollerCanvas.prototype.bgEl = null;

        ScrollerCanvas.prototype.gutters = null;

        ScrollerCanvas.prototype.width = null;

        ScrollerCanvas.prototype.minWidth = null;

        function ScrollerCanvas() {
            this.gutters = {};
        }

        ScrollerCanvas.prototype.render = function() {
            this.el = $('<div class="fc-scroller-canvas"> <div class="fc-content"></div> <div class="fc-bg"></div> </div>');
            this.contentEl = this.el.find('.fc-content');
            return this.bgEl = this.el.find('.fc-bg');
        };


        /*
         If falsy, resets all the gutters to 0
         */

        ScrollerCanvas.prototype.setGutters = function(gutters) {
            if (!gutters) {
                this.gutters = {};
            } else {
                $.extend(this.gutters, gutters);
            }
            return this.updateSize();
        };

        ScrollerCanvas.prototype.setWidth = function(width1) {
            this.width = width1;
            return this.updateSize();
        };

        ScrollerCanvas.prototype.setMinWidth = function(minWidth1) {
            this.minWidth = minWidth1;
            return this.updateSize();
        };

        ScrollerCanvas.prototype.clearWidth = function() {
            this.width = null;
            this.minWidth = null;
            return this.updateSize();
        };

        ScrollerCanvas.prototype.updateSize = function() {
            var gutters;
            gutters = this.gutters;
            this.el.toggleClass('fc-gutter-left', Boolean(gutters.left)).toggleClass('fc-gutter-right', Boolean(gutters.right)).toggleClass('fc-gutter-top', Boolean(gutters.top)).toggleClass('fc-gutter-bottom', Boolean(gutters.bottom)).css({
                paddingLeft: gutters.left || '',
                paddingRight: gutters.right || '',
                paddingTop: gutters.top || '',
                paddingBottom: gutters.bottom || '',
                width: this.width != null ? this.width + (gutters.left || 0) + (gutters.right || 0) : '',
                minWidth: this.minWidth != null ? this.minWidth + (gutters.left || 0) + (gutters.right || 0) : ''
            });
            return this.bgEl.css({
                left: gutters.left || '',
                right: gutters.right || '',
                top: gutters.top || '',
                bottom: gutters.bottom || ''
            });
        };

        return ScrollerCanvas;

    })();

    ScrollJoiner = (function() {
        ScrollJoiner.prototype.axis = null;

        ScrollJoiner.prototype.scrollers = null;

        ScrollJoiner.prototype.masterScroller = null;

        function ScrollJoiner(axis, scrollers) {
            var j, len, ref, scroller;
            this.axis = axis;
            this.scrollers = scrollers;
            ref = this.scrollers;
            for (j = 0, len = ref.length; j < len; j++) {
                scroller = ref[j];
                this.initScroller(scroller);
            }
            return;
        }

        ScrollJoiner.prototype.initScroller = function(scroller) {
            scroller.scrollEl.on('wheel mousewheel DomMouseScroll MozMousePixelScroll', (function(_this) {
                return function() {
                    _this.assignMasterScroller(scroller);
                };
            })(this));
            return scroller.on('scrollStart', (function(_this) {
                return function() {
                    if (!_this.masterScroller) {
                        return _this.assignMasterScroller(scroller);
                    }
                };
            })(this)).on('scroll', (function(_this) {
                return function() {
                    var j, len, otherScroller, ref, results;
                    if (scroller === _this.masterScroller) {
                        ref = _this.scrollers;
                        results = [];
                        for (j = 0, len = ref.length; j < len; j++) {
                            otherScroller = ref[j];
                            if (otherScroller !== scroller) {
                                switch (_this.axis) {
                                    case 'horizontal':
                                        results.push(otherScroller.setNativeScrollLeft(scroller.getNativeScrollLeft()));
                                        break;
                                    case 'vertical':
                                        results.push(otherScroller.setScrollTop(scroller.getScrollTop()));
                                        break;
                                    default:
                                        results.push(void 0);
                                }
                            } else {
                                results.push(void 0);
                            }
                        }
                        return results;
                    }
                };
            })(this)).on('scrollEnd', (function(_this) {
                return function() {
                    if (scroller === _this.masterScroller) {
                        return _this.unassignMasterScroller();
                    }
                };
            })(this));
        };

        ScrollJoiner.prototype.assignMasterScroller = function(scroller) {
            var j, len, otherScroller, ref;
            this.unassignMasterScroller();
            this.masterScroller = scroller;
            ref = this.scrollers;
            for (j = 0, len = ref.length; j < len; j++) {
                otherScroller = ref[j];
                if (otherScroller !== scroller) {
                    otherScroller.disableTouchScroll();
                }
            }
        };

        ScrollJoiner.prototype.unassignMasterScroller = function() {
            var j, len, otherScroller, ref;
            if (this.masterScroller) {
                ref = this.scrollers;
                for (j = 0, len = ref.length; j < len; j++) {
                    otherScroller = ref[j];
                    otherScroller.enableTouchScroll();
                }
                this.masterScroller = null;
            }
        };

        ScrollJoiner.prototype.update = function() {
            var allWidths, i, j, k, len, len1, maxBottom, maxLeft, maxRight, maxTop, ref, scroller, widths;
            allWidths = (function() {
                var j, len, ref, results;
                ref = this.scrollers;
                results = [];
                for (j = 0, len = ref.length; j < len; j++) {
                    scroller = ref[j];
                    results.push(scroller.getScrollbarWidths());
                }
                return results;
            }).call(this);
            maxLeft = maxRight = maxTop = maxBottom = 0;
            for (j = 0, len = allWidths.length; j < len; j++) {
                widths = allWidths[j];
                maxLeft = Math.max(maxLeft, widths.left);
                maxRight = Math.max(maxRight, widths.right);
                maxTop = Math.max(maxTop, widths.top);
                maxBottom = Math.max(maxBottom, widths.bottom);
            }
            ref = this.scrollers;
            for (i = k = 0, len1 = ref.length; k < len1; i = ++k) {
                scroller = ref[i];
                widths = allWidths[i];
                scroller.canvas.setGutters(this.axis === 'horizontal' ? {
                    left: maxLeft - widths.left,
                    right: maxRight - widths.right
                } : {
                    top: maxTop - widths.top,
                    bottom: maxBottom - widths.bottom
                });
            }
        };

        return ScrollJoiner;

    })();

    ScrollFollower = (function() {
        ScrollFollower.prototype.scroller = null;

        ScrollFollower.prototype.scrollbarWidths = null;

        ScrollFollower.prototype.sprites = null;

        ScrollFollower.prototype.viewportRect = null;

        ScrollFollower.prototype.contentOffset = null;

        ScrollFollower.prototype.isHFollowing = true;

        ScrollFollower.prototype.isVFollowing = false;

        ScrollFollower.prototype.containOnNaturalLeft = false;

        ScrollFollower.prototype.containOnNaturalRight = false;

        ScrollFollower.prototype.minTravel = 0;

        ScrollFollower.prototype.isTouch = false;

        ScrollFollower.prototype.isForcedRelative = false;

        function ScrollFollower(scroller, isTouch) {
            this.isTouch = isTouch;
            this.scroller = scroller;
            this.sprites = [];
            if (this.isTouch) {
                this.isForcedRelative = true;
            }
            scroller.on((this.isTouch ? 'scrollEnd' : 'scroll'), (function(_this) {
                return function() {
                    return _this.handleScroll();
                };
            })(this));
        }

        ScrollFollower.prototype.setSprites = function(sprites) {
            var j, len, sprite;
            this.clearSprites();
            if (sprites instanceof $) {
                return this.sprites = (function() {
                    var j, len, results;
                    results = [];
                    for (j = 0, len = sprites.length; j < len; j++) {
                        sprite = sprites[j];
                        results.push(new ScrollFollowerSprite($(sprite), this));
                    }
                    return results;
                }).call(this);
            } else {
                for (j = 0, len = sprites.length; j < len; j++) {
                    sprite = sprites[j];
                    sprite.follower = this;
                }
                return this.sprites = sprites;
            }
        };

        ScrollFollower.prototype.clearSprites = function() {
            var j, len, ref, sprite;
            ref = this.sprites;
            for (j = 0, len = ref.length; j < len; j++) {
                sprite = ref[j];
                sprite.clear();
            }
            return this.sprites = [];
        };

        ScrollFollower.prototype.handleScroll = function() {
            this.updateViewport();
            return this.updatePositions();
        };

        ScrollFollower.prototype.cacheDimensions = function() {
            var j, len, ref, sprite;
            this.updateViewport();
            this.scrollbarWidths = this.scroller.getScrollbarWidths();
            this.contentOffset = this.scroller.canvas.el.offset();
            ref = this.sprites;
            for (j = 0, len = ref.length; j < len; j++) {
                sprite = ref[j];
                sprite.cacheDimensions();
            }
        };

        ScrollFollower.prototype.updateViewport = function() {
            var left, scroller, top;
            scroller = this.scroller;
            left = scroller.getScrollFromLeft();
            top = scroller.getScrollTop();
            return this.viewportRect = {
                left: left,
                right: left + scroller.getClientWidth(),
                top: top,
                bottom: top + scroller.getClientHeight()
            };
        };

        ScrollFollower.prototype.forceRelative = function() {
            var j, len, ref, results, sprite;
            if (!this.isForcedRelative) {
                this.isForcedRelative = true;
                ref = this.sprites;
                results = [];
                for (j = 0, len = ref.length; j < len; j++) {
                    sprite = ref[j];
                    if (sprite.doAbsolute) {
                        results.push(sprite.assignPosition());
                    } else {
                        results.push(void 0);
                    }
                }
                return results;
            }
        };

        ScrollFollower.prototype.clearForce = function() {
            var j, len, ref, results, sprite;
            if (this.isForcedRelative && !this.isTouch) {
                this.isForcedRelative = false;
                ref = this.sprites;
                results = [];
                for (j = 0, len = ref.length; j < len; j++) {
                    sprite = ref[j];
                    results.push(sprite.assignPosition());
                }
                return results;
            }
        };

        ScrollFollower.prototype.update = function() {
            this.cacheDimensions();
            return this.updatePositions();
        };

        ScrollFollower.prototype.updatePositions = function() {
            var j, len, ref, sprite;
            ref = this.sprites;
            for (j = 0, len = ref.length; j < len; j++) {
                sprite = ref[j];
                sprite.updatePosition();
            }
        };

        ScrollFollower.prototype.getContentRect = function(el) {
            return getContentRect(el, this.contentOffset);
        };

        ScrollFollower.prototype.getBoundingRect = function(el) {
            return getOuterRect(el, this.contentOffset);
        };

        return ScrollFollower;

    })();

    ScrollFollowerSprite = (function() {
        ScrollFollowerSprite.prototype.follower = null;

        ScrollFollowerSprite.prototype.el = null;

        ScrollFollowerSprite.prototype.absoluteEl = null;

        ScrollFollowerSprite.prototype.naturalRect = null;

        ScrollFollowerSprite.prototype.parentRect = null;

        ScrollFollowerSprite.prototype.containerRect = null;

        ScrollFollowerSprite.prototype.isEnabled = true;

        ScrollFollowerSprite.prototype.isHFollowing = false;

        ScrollFollowerSprite.prototype.isVFollowing = false;

        ScrollFollowerSprite.prototype.doAbsolute = false;

        ScrollFollowerSprite.prototype.isAbsolute = false;

        ScrollFollowerSprite.prototype.isCentered = false;

        ScrollFollowerSprite.prototype.rect = null;

        ScrollFollowerSprite.prototype.isBlock = false;

        ScrollFollowerSprite.prototype.naturalWidth = null;

        function ScrollFollowerSprite(el1, follower1) {
            this.el = el1;
            this.follower = follower1 != null ? follower1 : null;
            this.isBlock = this.el.css('display') === 'block';
            this.el.css('position', 'relative');
        }

        ScrollFollowerSprite.prototype.disable = function() {
            if (this.isEnabled) {
                this.isEnabled = false;
                this.resetPosition();
                return this.unabsolutize();
            }
        };

        ScrollFollowerSprite.prototype.enable = function() {
            if (!this.isEnabled) {
                this.isEnabled = true;
                return this.assignPosition();
            }
        };

        ScrollFollowerSprite.prototype.clear = function() {
            this.disable();
            this.follower = null;
            return this.absoluteEl = null;
        };

        ScrollFollowerSprite.prototype.cacheDimensions = function() {
            var containerRect, follower, isCentered, isHFollowing, isVFollowing, minTravel, naturalRect, parentEl;
            isHFollowing = false;
            isVFollowing = false;
            isCentered = false;
            this.naturalWidth = this.el.width();
            this.resetPosition();
            follower = this.follower;
            naturalRect = this.naturalRect = follower.getBoundingRect(this.el);
            parentEl = this.el.parent();
            this.parentRect = follower.getBoundingRect(parentEl);
            containerRect = this.containerRect = joinRects(follower.getContentRect(parentEl), naturalRect);
            minTravel = follower.minTravel;
            if (follower.containOnNaturalLeft) {
                containerRect.left = naturalRect.left;
            }
            if (follower.containOnNaturalRight) {
                containerRect.right = naturalRect.right;
            }
            if (follower.isHFollowing) {
                if (getRectWidth(containerRect) - getRectWidth(naturalRect) >= minTravel) {
                    isCentered = this.el.css('text-align') === 'center';
                    isHFollowing = true;
                }
            }
            if (follower.isVFollowing) {
                if (getRectHeight(containerRect) - getRectHeight(naturalRect) >= minTravel) {
                    isVFollowing = true;
                }
            }
            this.isHFollowing = isHFollowing;
            this.isVFollowing = isVFollowing;
            return this.isCentered = isCentered;
        };

        ScrollFollowerSprite.prototype.updatePosition = function() {
            this.computePosition();
            return this.assignPosition();
        };

        ScrollFollowerSprite.prototype.resetPosition = function() {
            return this.el.css({
                top: '',
                left: ''
            });
        };

        ScrollFollowerSprite.prototype.computePosition = function() {
            var containerRect, doAbsolute, parentRect, rect, rectWidth, subjectRect, viewportRect, visibleParentRect;
            viewportRect = this.follower.viewportRect;
            parentRect = this.parentRect;
            containerRect = this.containerRect;
            visibleParentRect = intersectRects(viewportRect, parentRect);
            rect = null;
            doAbsolute = false;
            if (visibleParentRect) {
                rect = copyRect(this.naturalRect);
                subjectRect = intersectRects(rect, parentRect);
                if ((this.isCentered && !testRectContains(viewportRect, parentRect)) || (subjectRect && !testRectContains(viewportRect, subjectRect))) {
                    doAbsolute = true;
                    if (this.isHFollowing) {
                        if (this.isCentered) {
                            rectWidth = getRectWidth(rect);
                            rect.left = (visibleParentRect.left + visibleParentRect.right) / 2 - rectWidth / 2;
                            rect.right = rect.left + rectWidth;
                        } else {
                            if (!hContainRect(rect, viewportRect)) {
                                doAbsolute = false;
                            }
                        }
                        if (hContainRect(rect, containerRect)) {
                            doAbsolute = false;
                        }
                    }
                    if (this.isVFollowing) {
                        if (!vContainRect(rect, viewportRect)) {
                            doAbsolute = false;
                        }
                        if (vContainRect(rect, containerRect)) {
                            doAbsolute = false;
                        }
                    }
                    if (!testRectContains(viewportRect, rect)) {
                        doAbsolute = false;
                    }
                }
            }
            this.rect = rect;
            return this.doAbsolute = doAbsolute;
        };

        ScrollFollowerSprite.prototype.assignPosition = function() {
            var left, top;
            if (this.isEnabled) {
                if (!this.rect) {
                    return this.unabsolutize();
                } else if (this.doAbsolute && !this.follower.isForcedRelative) {
                    this.absolutize();
                    return this.absoluteEl.css({
                        top: this.rect.top - this.follower.viewportRect.top + this.follower.scrollbarWidths.top,
                        left: this.rect.left - this.follower.viewportRect.left + this.follower.scrollbarWidths.left,
                        width: this.isBlock ? this.naturalWidth : ''
                    });
                } else {
                    top = this.rect.top - this.naturalRect.top;
                    left = this.rect.left - this.naturalRect.left;
                    this.unabsolutize();
                    return this.el.toggleClass('fc-following', Boolean(top || left)).css({
                        top: top,
                        left: left
                    });
                }
            }
        };

        ScrollFollowerSprite.prototype.absolutize = function() {
            if (!this.isAbsolute) {
                if (!this.absoluteEl) {
                    this.absoluteEl = this.buildAbsoluteEl();
                }
                this.absoluteEl.appendTo(this.follower.scroller.el);
                this.el.css('visibility', 'hidden');
                return this.isAbsolute = true;
            }
        };

        ScrollFollowerSprite.prototype.unabsolutize = function() {
            if (this.isAbsolute) {
                this.absoluteEl.detach();
                this.el.css('visibility', '');
                return this.isAbsolute = false;
            }
        };

        ScrollFollowerSprite.prototype.buildAbsoluteEl = function() {
            return this.el.clone().addClass('fc-following').css({
                'position': 'absolute',
                'z-index': 1000,
                'font-weight': this.el.css('font-weight'),
                'font-size': this.el.css('font-size'),
                'font-family': this.el.css('font-family'),
                'color': this.el.css('color'),
                'padding-top': this.el.css('padding-top'),
                'padding-bottom': this.el.css('padding-bottom'),
                'padding-left': this.el.css('padding-left'),
                'padding-right': this.el.css('padding-right'),
                'pointer-events': 'none'
            });
        };

        return ScrollFollowerSprite;

    })();

    copyRect = function(rect) {
        return {
            left: rect.left,
            right: rect.right,
            top: rect.top,
            bottom: rect.bottom
        };
    };

    getRectWidth = function(rect) {
        return rect.right - rect.left;
    };

    getRectHeight = function(rect) {
        return rect.bottom - rect.top;
    };

    testRectContains = function(rect, innerRect) {
        return testRectHContains(rect, innerRect) && testRectVContains(rect, innerRect);
    };

    testRectHContains = function(rect, innerRect) {
        return innerRect.left >= rect.left && innerRect.right <= rect.right;
    };

    testRectVContains = function(rect, innerRect) {
        return innerRect.top >= rect.top && innerRect.bottom <= rect.bottom;
    };

    hContainRect = function(rect, outerRect) {
        if (rect.left < outerRect.left) {
            rect.right = outerRect.left + getRectWidth(rect);
            rect.left = outerRect.left;
            return true;
        } else if (rect.right > outerRect.right) {
            rect.left = outerRect.right - getRectWidth(rect);
            rect.right = outerRect.right;
            return true;
        } else {
            return false;
        }
    };

    vContainRect = function(rect, outerRect) {
        if (rect.top < outerRect.top) {
            rect.bottom = outerRect.top + getRectHeight(rect);
            rect.top = outerRect.top;
            return true;
        } else if (rect.bottom > outerRect.bottom) {
            rect.top = outerRect.bottom - getRectHeight(rect);
            rect.bottom = outerRect.bottom;
            return true;
        } else {
            return false;
        }
    };

    joinRects = function(rect1, rect2) {
        return {
            left: Math.min(rect1.left, rect2.left),
            right: Math.max(rect1.right, rect2.right),
            top: Math.min(rect1.top, rect2.top),
            bottom: Math.max(rect1.bottom, rect2.bottom)
        };
    };

    CalendarExtension = (function(superClass) {
        extend(CalendarExtension, superClass);

        function CalendarExtension() {
            return CalendarExtension.__super__.constructor.apply(this, arguments);
        }

        CalendarExtension.prototype.resourceManager = null;

        CalendarExtension.prototype.initialize = function() {
            return this.resourceManager = new ResourceManager(this);
        };

        CalendarExtension.prototype.instantiateView = function(viewType) {
            var spec, viewClass;
            spec = this.getViewSpec(viewType);
            viewClass = spec['class'];
            if (this.options.resources && spec.options.resources !== false) {
                if (spec.queryResourceClass) {
                    viewClass = spec.queryResourceClass(spec) || viewClass;
                } else if (spec.resourceClass) {
                    viewClass = spec.resourceClass;
                }
            }
            return new viewClass(this, viewType, spec.options, spec.duration);
        };

        CalendarExtension.prototype.getResources = function() {
            return Array.prototype.slice.call(this.resourceManager.topLevelResources);
        };

        CalendarExtension.prototype.addResource = function(resourceInput, scroll) {
            var promise;
            if (scroll == null) {
                scroll = false;
            }
            promise = this.resourceManager.addResource(resourceInput);
            if (scroll && this.view.scrollToResource) {
                promise.done((function(_this) {
                    return function(resource) {
                        return _this.view.scrollToResource(resource);
                    };
                })(this));
            }
        };

        CalendarExtension.prototype.removeResource = function(idOrResource) {
            return this.resourceManager.removeResource(idOrResource);
        };

        CalendarExtension.prototype.refetchResources = function() {
            this.resourceManager.fetchResources();
        };

        CalendarExtension.prototype.rerenderResources = function() {
            this.resourceManager.resetResources();
        };

        CalendarExtension.prototype.isSpanAllowed = function(span, constraint) {
            var constrainToResourceIds, ref;
            if (typeof constraint === 'object') {
                constrainToResourceIds = this.getEventResourceIds(constraint);
                if (constrainToResourceIds.length && (!span.resourceId || !(ref = span.resourceId, indexOf.call(constrainToResourceIds, ref) >= 0))) {
                    return false;
                }
            }
            return CalendarExtension.__super__.isSpanAllowed.apply(this, arguments);
        };

        CalendarExtension.prototype.getPeerEvents = function(span, event) {
            var filteredPeerEvents, isPeer, j, k, l, len, len1, len2, newResourceId, newResourceIds, peerEvent, peerEvents, peerResourceId, peerResourceIds;
            peerEvents = CalendarExtension.__super__.getPeerEvents.apply(this, arguments);
            newResourceIds = span.resourceId ? [span.resourceId] : event ? this.getEventResourceIds(event) : [];
            filteredPeerEvents = [];
            for (j = 0, len = peerEvents.length; j < len; j++) {
                peerEvent = peerEvents[j];
                isPeer = false;
                peerResourceIds = this.getEventResourceIds(peerEvent);
                if (!peerResourceIds.length || !newResourceIds.length) {
                    isPeer = true;
                } else {
                    for (k = 0, len1 = peerResourceIds.length; k < len1; k++) {
                        peerResourceId = peerResourceIds[k];
                        for (l = 0, len2 = newResourceIds.length; l < len2; l++) {
                            newResourceId = newResourceIds[l];
                            if (newResourceId === peerResourceId) {
                                isPeer = true;
                                break;
                            }
                        }
                    }
                }
                if (isPeer) {
                    filteredPeerEvents.push(peerEvent);
                }
            }
            return filteredPeerEvents;
        };

        CalendarExtension.prototype.spanContainsSpan = function(outerSpan, innerSpan) {
            if (outerSpan.resourceId && outerSpan.resourceId !== innerSpan.resourceId) {
                return false;
            } else {
                return CalendarExtension.__super__.spanContainsSpan.apply(this, arguments);
            }
        };

        CalendarExtension.prototype.getCurrentBusinessHourEvents = function(wholeDay) {
            var allEvents, anyCustomBusinessHours, event, events, flatResources, j, k, l, len, len1, len2, resource;
            flatResources = this.resourceManager.getFlatResources();
            anyCustomBusinessHours = false;
            for (j = 0, len = flatResources.length; j < len; j++) {
                resource = flatResources[j];
                if (resource.businessHours) {
                    anyCustomBusinessHours = true;
                }
            }
            if (anyCustomBusinessHours) {
                allEvents = [];
                for (k = 0, len1 = flatResources.length; k < len1; k++) {
                    resource = flatResources[k];
                    events = this.computeBusinessHourEvents(wholeDay, resource.businessHours || this.options.businessHours);
                    for (l = 0, len2 = events.length; l < len2; l++) {
                        event = events[l];
                        event.resourceId = resource.id;
                        allEvents.push(event);
                    }
                }
                return allEvents;
            } else {
                return CalendarExtension.__super__.getCurrentBusinessHourEvents.apply(this, arguments);
            }
        };

        CalendarExtension.prototype.buildSelectSpan = function(startInput, endInput, resourceId) {
            var span;
            span = CalendarExtension.__super__.buildSelectSpan.apply(this, arguments);
            if (resourceId) {
                span.resourceId = resourceId;
            }
            return span;
        };

        CalendarExtension.prototype.getResourceById = function(id) {
            return this.resourceManager.getResourceById(id);
        };

        CalendarExtension.prototype.normalizeEvent = function(event) {
            CalendarExtension.__super__.normalizeEvent.apply(this, arguments);
            if (event.resourceId == null) {
                event.resourceId = null;
            }
            return event.resourceIds != null ? event.resourceIds : event.resourceIds = null;
        };

        CalendarExtension.prototype.getEventResourceId = function(event) {
            return this.getEventResourceIds(event)[0];
        };

        CalendarExtension.prototype.getEventResourceIds = function(event) {
            var j, len, normalResourceId, normalResourceIds, ref, ref1, ref2, resourceId;
            resourceId = String((ref = (ref1 = event[this.getEventResourceField()]) != null ? ref1 : event.resourceId) != null ? ref : '');
            if (resourceId) {
                return [resourceId];
            } else if (event.resourceIds) {
                normalResourceIds = [];
                ref2 = event.resourceIds;
                for (j = 0, len = ref2.length; j < len; j++) {
                    resourceId = ref2[j];
                    normalResourceId = String(resourceId != null ? resourceId : '');
                    if (normalResourceId) {
                        normalResourceIds.push(normalResourceId);
                    }
                }
                return normalResourceIds;
            } else {
                return [];
            }
        };

        CalendarExtension.prototype.setEventResourceId = function(event, resourceId) {
            return event[this.getEventResourceField()] = String(resourceId != null ? resourceId : '');
        };

        CalendarExtension.prototype.getEventResourceField = function() {
            return this.options['eventResourceField'] || 'resourceId';
        };

        CalendarExtension.prototype.getResourceEvents = function(idOrResource) {
            var resource;
            resource = typeof idOrResource === 'object' ? idOrResource : this.getResourceById(idOrResource);
            if (resource) {
                return this.clientEvents((function(_this) {
                    return function(event) {
                        return $.inArray(resource.id, _this.getEventResourceIds(event)) !== -1;
                    };
                })(this));
            } else {
                return [];
            }
        };

        CalendarExtension.prototype.getEventResource = function(idOrEvent) {
            return this.getEventResources(idOrEvent)[0];
        };

        CalendarExtension.prototype.getEventResources = function(idOrEvent) {
            var event, j, len, ref, resource, resourceId, resources;
            event = typeof idOrEvent === 'object' ? idOrEvent : this.clientEvents(idOrEvent)[0];
            resources = [];
            if (event) {
                ref = this.getEventResourceIds(event);
                for (j = 0, len = ref.length; j < len; j++) {
                    resourceId = ref[j];
                    resource = this.getResourceById(resourceId);
                    if (resource) {
                        resources.push(resource);
                    }
                }
            }
            return resources;
        };

        return CalendarExtension;

    })(Calendar);

    Calendar.prototype = CalendarExtension.prototype;

    origDisplayView = View.prototype.displayView;

    origRenderSkeleton = View.prototype.renderSkeleton;

    origUnrenderSkeleton = View.prototype.unrenderSkeleton;

    origDisplayEvents = View.prototype.displayEvents;

    View.prototype.isResourcesBound = false;

    View.prototype.settingResources = null;

    View.prototype.displayView = function() {
        origDisplayView.apply(this, arguments);
        this.bindResources();
        return this.whenResources();
    };

    View.prototype.unrenderSkeleton = function() {
        origUnrenderSkeleton.apply(this, arguments);
        return this.unbindResources(true);
    };

    View.prototype.displayEvents = function(events) {
        return this.whenResources((function(_this) {
            return function() {
                return origDisplayEvents.call(_this, events);
            };
        })(this));
    };

    View.prototype.bindResources = function() {
        var setResources;
        if (!this.isResourcesBound) {
            this.isResourcesBound = true;
            this.settingResources = $.Deferred();
            setResources = (function(_this) {
                return function(resources) {
                    _this.setResources(resources);
                    return _this.settingResources.resolve();
                };
            })(this);
            this.listenTo(this.calendar.resourceManager, {
                set: setResources,
                unset: this.unsetResources,
                reset: this.resetResources,
                add: this.addResource,
                remove: this.removeResource
            });
            if (this.calendar.resourceManager.hasFetched()) {
                return setResources(this.calendar.resourceManager.topLevelResources);
            } else {
                return this.calendar.resourceManager.getResources();
            }
        }
    };

    View.prototype.unbindResources = function(isDestroying) {
        if (this.isResourcesBound) {
            this.stopListeningTo(this.calendar.resourceManager);
            if (this.settingResources.state() === 'resolved') {
                this.unsetResources(isDestroying);
            }
            this.settingResources = null;
            return this.isResourcesBound = false;
        }
    };

    View.prototype.whenResources = function(thenFunc) {
        return syncThen(this.settingResources, thenFunc);
    };

    View.prototype.setResources = function(resources) {};

    View.prototype.unsetResources = function() {};

    View.prototype.resetResources = function(resources) {
        return this.calendar.rerenderEvents();
    };

    View.prototype.addResource = function(resource) {
        return this.resetResources(this.calendar.resourceManager.topLevelResources);
    };

    View.prototype.removeResource = function(resource) {
        return this.resetResources(this.calendar.resourceManager.topLevelResources);
    };

    origGetSegCustomClasses = Grid.prototype.getSegCustomClasses;

    origGetSegDefaultBackgroundColor = Grid.prototype.getSegDefaultBackgroundColor;

    origGetSegDefaultBorderColor = Grid.prototype.getSegDefaultBorderColor;

    origGetSegDefaultTextColor = Grid.prototype.getSegDefaultTextColor;

    Grid.prototype.getSegCustomClasses = function(seg) {
        var classes, j, len, ref, resource;
        classes = origGetSegCustomClasses.apply(this, arguments);
        ref = this.getSegResources(seg);
        for (j = 0, len = ref.length; j < len; j++) {
            resource = ref[j];
            classes = classes.concat(resource.eventClassName || []);
        }
        return classes;
    };

    Grid.prototype.getSegDefaultBackgroundColor = function(seg) {
        var currentResource, j, len, resources, val;
        resources = this.getSegResources(seg);
        for (j = 0, len = resources.length; j < len; j++) {
            currentResource = resources[j];
            while (currentResource) {
                val = currentResource.eventBackgroundColor || currentResource.eventColor;
                if (val) {
                    return val;
                }
                currentResource = currentResource._parent;
            }
        }
        return origGetSegDefaultBackgroundColor.apply(this, arguments);
    };

    Grid.prototype.getSegDefaultBorderColor = function(seg) {
        var currentResource, j, len, resources, val;
        resources = this.getSegResources(seg);
        for (j = 0, len = resources.length; j < len; j++) {
            currentResource = resources[j];
            while (currentResource) {
                val = currentResource.eventBorderColor || currentResource.eventColor;
                if (val) {
                    return val;
                }
                currentResource = currentResource._parent;
            }
        }
        return origGetSegDefaultBorderColor.apply(this, arguments);
    };

    Grid.prototype.getSegDefaultTextColor = function(seg) {
        var currentResource, j, len, resources, val;
        resources = this.getSegResources(seg);
        for (j = 0, len = resources.length; j < len; j++) {
            currentResource = resources[j];
            while (currentResource) {
                val = currentResource.eventTextColor;
                if (val) {
                    return val;
                }
                currentResource = currentResource._parent;
            }
        }
        return origGetSegDefaultTextColor.apply(this, arguments);
    };

    Grid.prototype.getSegResources = function(seg) {
        if (seg.resource) {
            return [seg.resource];
        } else {
            return this.view.calendar.getEventResources(seg.event);
        }
    };

    ResourceManager = (function(superClass) {
        extend(ResourceManager, superClass);

        ResourceManager.mixin(EmitterMixin);

        ResourceManager.resourceGuid = 1;

        ResourceManager.ajaxDefaults = {
            dataType: 'json',
            cache: false
        };

        ResourceManager.prototype.calendar = null;

        ResourceManager.prototype.topLevelResources = null;

        ResourceManager.prototype.resourcesById = null;

        ResourceManager.prototype.fetching = null;

        function ResourceManager(calendar1) {
            this.calendar = calendar1;
            this.initializeCache();
        }

        ResourceManager.prototype.hasFetched = function() {
            return this.fetching && this.fetching.state() === 'resolved';
        };

        ResourceManager.prototype.getResources = function() {
            var getting;
            if (!this.fetching) {
                getting = $.Deferred();
                syncThen(this.fetchResources(), function() {
                    return getting.resolve(this.topLevelResources);
                }, function() {
                    return getting.resolve([]);
                });
                return getting.promise();
            } else {
                return $.Deferred().resolve(this.topLevelResources).promise();
            }
        };

        ResourceManager.prototype.fetchResources = function() {
            var prevFetching;
            prevFetching = this.fetching;
            return syncThen(prevFetching, (function(_this) {
                return function() {
                    _this.fetching = $.Deferred();
                    _this.fetchResourceInputs(function(resourceInputs) {
                        _this.setResources(resourceInputs, Boolean(prevFetching));
                        return _this.fetching.resolve(_this.topLevelResources);
                    });
                    return _this.fetching.promise();
                };
            })(this));
        };

        ResourceManager.prototype.fetchResourceInputs = function(callback) {
            var source;
            source = this.calendar.options['resources'];
            if ($.type(source) === 'string') {
                source = {
                    url: source
                };
            }
            switch ($.type(source)) {
                case 'function':
                    this.calendar.pushLoading();
                    //noinspection JSUnresolvedFunction
                    return source((function(_this) {
                        return function(resourceInputs) {
                            _this.calendar.popLoading();
                            return callback(resourceInputs);
                        };
                    })(this));
                case 'object':
                    this.calendar.pushLoading();
                    return $.ajax($.extend({}, ResourceManager.ajaxDefaults, source)).done((function(_this) {
                        return function(resourceInputs) {
                            _this.calendar.popLoading();
                            return callback(resourceInputs);
                        };
                    })(this));
                case 'array':
                    return callback(source);
                default:
                    return callback([]);
            }
        };

        ResourceManager.prototype.resetResources = function() {
            return syncThen(this.getResources(), (function(_this) {
                return function() {
                    return _this.trigger('reset', _this.topLevelResources);
                };
            })(this));
        };

        ResourceManager.prototype.getResourceById = function(id) {
            return this.resourcesById[id];
        };

        ResourceManager.prototype.getFlatResources = function() {
            var id, results;
            results = [];
            for (id in this.resourcesById) {
                results.push(this.resourcesById[id]);
            }
            return results;
        };

        ResourceManager.prototype.initializeCache = function() {
            this.topLevelResources = [];
            return this.resourcesById = {};
        };

        ResourceManager.prototype.setResources = function(resourceInputs, isReset) {
            var j, len, resource, resourceInput, resources, validResources;
            this.initializeCache();
            resources = (function() {
                var j, len, results;
                results = [];
                for (j = 0, len = resourceInputs.length; j < len; j++) {
                    resourceInput = resourceInputs[j];
                    results.push(this.buildResource(resourceInput));
                }
                return results;
            }).call(this);
            validResources = (function() {
                var j, len, results;
                results = [];
                for (j = 0, len = resources.length; j < len; j++) {
                    resource = resources[j];
                    if (this.addResourceToIndex(resource)) {
                        results.push(resource);
                    }
                }
                return results;
            }).call(this);
            for (j = 0, len = validResources.length; j < len; j++) {
                resource = validResources[j];
                this.addResourceToTree(resource);
            }
            if (isReset) {
                this.trigger('reset', this.topLevelResources);
            } else {
                this.trigger('set', this.topLevelResources);
            }
            return this.calendar.trigger('resourcesSet', null, this.topLevelResources);
        };

        ResourceManager.prototype.addResource = function(resourceInput) {
            return syncThen(this.fetching, (function(_this) {
                return function() {
                    var resource;
                    resource = _this.buildResource(resourceInput);
                    if (_this.addResourceToIndex(resource)) {
                        _this.addResourceToTree(resource);
                        _this.trigger('add', resource);
                        return resource;
                    } else {
                        return false;
                    }
                };
            })(this));
        };

        ResourceManager.prototype.addResourceToIndex = function(resource) {
            var child, j, len, ref;
            if (this.resourcesById[resource.id]) {
                return false;
            } else {
                this.resourcesById[resource.id] = resource;
                ref = resource.children;
                for (j = 0, len = ref.length; j < len; j++) {
                    child = ref[j];
                    this.addResourceToIndex(child);
                }
                return true;
            }
        };

        ResourceManager.prototype.addResourceToTree = function(resource) {
            var parent, parentId, ref, siblings;
            if (!resource.parent) {
                parentId = String((ref = resource['parentId']) != null ? ref : '');
                if (parentId) {
                    parent = this.resourcesById[parentId];
                    if (parent) {
                        resource.parent = parent;
                        siblings = parent.children;
                    } else {
                        return false;
                    }
                } else {
                    siblings = this.topLevelResources;
                }
                siblings.push(resource);
            }
            return true;
        };

        ResourceManager.prototype.removeResource = function(idOrResource) {
            var id;
            id = typeof idOrResource === 'object' ? idOrResource.id : idOrResource;
            return syncThen(this.fetching, (function(_this) {
                return function() {
                    var resource;
                    resource = _this.removeResourceFromIndex(id);
                    if (resource) {
                        _this.removeResourceFromTree(resource);
                        _this.trigger('remove', resource);
                    }
                    return resource;
                };
            })(this));
        };

        ResourceManager.prototype.removeResourceFromIndex = function(resourceId) {
            var child, j, len, ref, resource;
            resource = this.resourcesById[resourceId];
            if (resource) {
                delete this.resourcesById[resourceId];
                ref = resource.children;
                for (j = 0, len = ref.length; j < len; j++) {
                    child = ref[j];
                    this.removeResourceFromIndex(child.id);
                }
                return resource;
            } else {
                return false;
            }
        };

        ResourceManager.prototype.removeResourceFromTree = function(resource, siblings) {
            var i, j, len, sibling;
            if (siblings == null) {
                siblings = this.topLevelResources;
            }
            for (i = j = 0, len = siblings.length; j < len; i = ++j) {
                sibling = siblings[i];
                if (sibling === resource) {
                    resource.parent = null;
                    siblings.splice(i, 1);
                    return true;
                }
                if (this.removeResourceFromTree(resource, sibling.children)) {
                    return true;
                }
            }
            return false;
        };

        ResourceManager.prototype.buildResource = function(resourceInput) {
            var child, childInput, rawClassName, ref, resource;
            resource = $.extend({}, resourceInput);
            resource.id = String((ref = resourceInput.id) != null ? ref : '_fc' + ResourceManager.resourceGuid++);
            rawClassName = resourceInput.eventClassName;
            resource.eventClassName = (function() {
                switch ($.type(rawClassName)) {
                    case 'string':
                        return rawClassName.split(/\s+/);
                    case 'array':
                        return rawClassName;
                    default:
                        return [];
                }
            })();
            resource.children = (function() {
                var j, len, ref1, ref2, results;
                ref2 = (ref1 = resourceInput.children) != null ? ref1 : [];
                results = [];
                for (j = 0, len = ref2.length; j < len; j++) {
                    childInput = ref2[j];
                    child = this.buildResource(childInput);
                    child.parent = resource;
                    results.push(child);
                }
                return results;
            }).call(this);
            return resource;
        };

        return ResourceManager;

    })(Class);


    /*
     A view that structurally distinguishes events by resource
     */

    ResourceViewMixin = {
        resourceTextFunc: null,
        unsetResources: function() {
            return this.clearEvents();
        },
        resetResources: function(resources) {
            var scrollState;
            scrollState = this.queryScroll();
            this.unsetResources();
            this.setResources(resources);
            this.setScroll(scrollState);
            return this.calendar.rerenderEvents();
        },
        isEventDraggable: function(event) {
            return this.isEventResourceEditable(event) || View.prototype.isEventDraggable.call(this, event);
        },
        isEventResourceEditable: function(event) {
            var ref, ref1, ref2;
            return (ref = (ref1 = (ref2 = event.resourceEditable) != null ? ref2 : (event.source || {}).resourceEditable) != null ? ref1 : this.opt('eventResourceEditable')) != null ? ref : this.isEventGenerallyEditable(event);
        },
        getResourceText: function(resource) {
            return this.getResourceTextFunc()(resource);
        },
        getResourceTextFunc: function() {
            var func;
            if (this.resourceTextFunc) {
                return this.resourceTextFunc;
            } else {
                func = this.opt('resourceText');
                if (typeof func !== 'function') {
                    func = function(resource) {
                        return resource.title || resource.id;
                    };
                }
                return this.resourceTextFunc = func;
            }
        },
        triggerDayClick: function(span, dayEl, ev) {
            var resourceManager;
            resourceManager = this.calendar.resourceManager;
            return this.trigger('dayClick', dayEl, this.calendar.applyTimezone(span.start), ev, this, resourceManager.getResourceById(span.resourceId));
        },
        triggerSelect: function(span, ev) {
            var resourceManager;
            resourceManager = this.calendar.resourceManager;
            return this.trigger('select', null, this.calendar.applyTimezone(span.start), this.calendar.applyTimezone(span.end), ev, this, resourceManager.getResourceById(span.resourceId));
        },
        triggerExternalDrop: function(event, dropLocation, el, ev, ui) {
            this.trigger('drop', el[0], dropLocation.start, ev, ui, dropLocation.resourceId);
            if (event) {
                return this.trigger('eventReceive', null, event);
            }
        },

        /* Hacks
         * ------------------------------------------------------------------------------------------------------------------
         These triggers usually call mutateEvent with dropLocation, which causes an event modification and rerender.
         But mutateEvent isn't aware of eventResourceField, so it might be setting the wrong property. Workaround.
         TODO: normalize somewhere else. maybe make a hook in core.
         */
        reportEventDrop: function() {
            var dropLocation, event, otherArgs, ref;
            event = arguments[0], dropLocation = arguments[1], otherArgs = 3 <= arguments.length ? slice.call(arguments, 2) : [];
            dropLocation = this.normalizeDropLocation(dropLocation);
            if (dropLocation.resourceId && event.resourceIds) {
                dropLocation.resourceIds = null;
            }
            return (ref = View.prototype.reportEventDrop).call.apply(ref, [this, event, dropLocation].concat(slice.call(otherArgs)));
        },
        reportExternalDrop: function() {
            var dropLocation, meta, otherArgs, ref;
            meta = arguments[0], dropLocation = arguments[1], otherArgs = 3 <= arguments.length ? slice.call(arguments, 2) : [];
            dropLocation = this.normalizeDropLocation(dropLocation);
            return (ref = View.prototype.reportExternalDrop).call.apply(ref, [this, meta, dropLocation].concat(slice.call(otherArgs)));
        },
        normalizeDropLocation: function(dropLocation) {
            var out;
            out = $.extend({}, dropLocation);
            delete out.resourceId;
            this.calendar.setEventResourceId(out, dropLocation.resourceId);
            return out;
        }
    };

    ResourceGridMixin = {
        allowCrossResource: true,
        eventRangeToSpans: function(range, event) {
            var j, len, resourceId, resourceIds, results;
            resourceIds = this.view.calendar.getEventResourceIds(event);
            if (resourceIds.length) {
                results = [];
                for (j = 0, len = resourceIds.length; j < len; j++) {
                    resourceId = resourceIds[j];
                    results.push($.extend({}, range, {
                        resourceId: resourceId
                    }));
                }
                return results;
            } else if (FC.isBgEvent(event)) {
                return Grid.prototype.eventRangeToSpans.apply(this, arguments);
            } else {
                return [];
            }
        },
        fabricateHelperEvent: function(eventLocation, seg) {
            var event;
            event = Grid.prototype.fabricateHelperEvent.apply(this, arguments);
            this.view.calendar.setEventResourceId(event, eventLocation.resourceId);
            return event;
        },
        computeEventDrop: function(startSpan, endSpan, event) {
            var dropLocation;
            if (this.view.isEventStartEditable(event)) {
                dropLocation = Grid.prototype.computeEventDrop.apply(this, arguments);
            } else {
                dropLocation = FC.pluckEventDateProps(event);
            }
            if (dropLocation) {
                if (this.view.isEventResourceEditable(event)) {
                    //dropLocation.resourceId = endSpan.resourceId;
                    //不允许跨行拖拽
                    dropLocation.resourceId = startSpan.resourceId;
                } else {
                    dropLocation.resourceId = startSpan.resourceId;
                }
            }
            return dropLocation;
        },
        computeExternalDrop: function(span, meta) {
            var dropLocation;
            dropLocation = Grid.prototype.computeExternalDrop.apply(this, arguments);
            if (dropLocation) {
                dropLocation.resourceId = span.resourceId;
            }
            return dropLocation;
        },
        computeEventResize: function(type, startSpan, endSpan, event) {
            var resizeLocation;
            if (!this.allowCrossResource && startSpan.resourceId !== endSpan.resourceId) {
                return;
            }
            resizeLocation = Grid.prototype.computeEventResize.apply(this, arguments);
            if (resizeLocation) {
                resizeLocation.resourceId = startSpan.resourceId;
            }
            return resizeLocation;
        },
        computeSelectionSpan: function(startSpan, endSpan) {
            var selectionSpan;
            if (!this.allowCrossResource && startSpan.resourceId !== endSpan.resourceId) {
                return;
            }
            selectionSpan = Grid.prototype.computeSelectionSpan.apply(this, arguments);
            if (selectionSpan) {
                selectionSpan.resourceId = startSpan.resourceId;
            }
            return selectionSpan;
        }
    };


    /*
     Requirements:
     - must be a Grid
     - grid must have a view that's a ResourceView
     - DayTableMixin must already be mixed in
     */

    ResourceDayTableMixin = {
        flattenedResources: null,
        resourceCnt: 0,
        datesAboveResources: false,
        allowCrossResource: false,
        setResources: function(resources) {
            this.flattenedResources = this.flattenResources(resources);
            this.resourceCnt = this.flattenedResources.length;
            return this.updateDayTableCols();
        },
        unsetResources: function() {
            this.flattenedResources = null;
            this.resourceCnt = 0;
            return this.updateDayTableCols();
        },
        flattenResources: function(resources) {
            var orderSpecs, orderVal, res, sortFunc;
            orderVal = this.view.opt('resourceOrder');
            if (orderVal) {
                orderSpecs = parseFieldSpecs(orderVal);
                sortFunc = function(a, b) {
                    return compareByFieldSpecs(a, b, orderSpecs);
                };
            } else {
                sortFunc = null;
            }
            res = [];
            this.accumulateResources(resources, sortFunc, res);
            return res;
        },
        accumulateResources: function(resources, sortFunc, res) {
            var j, len, resource, results, sortedResources;
            if (sortFunc) {
                sortedResources = resources.slice(0);
                sortedResources.sort(sortFunc);
            } else {
                sortedResources = resources;
            }
            results = [];
            for (j = 0, len = sortedResources.length; j < len; j++) {
                resource = sortedResources[j];
                res.push(resource);
                results.push(this.accumulateResources(resource.children, sortFunc, res));
            }
            return results;
        },
        updateDayTableCols: function() {
            this.datesAboveResources = this.view.opt('groupByDateAndResource');
            return FC.DayTableMixin.updateDayTableCols.call(this);
        },
        computeColCnt: function() {
            return (this.resourceCnt || 1) * this.daysPerRow;
        },
        getColDayIndex: function(col) {
            if (this.isRTL) {
                col = this.colCnt - 1 - col;
            }
            if (this.datesAboveResources) {
                return Math.floor(col / (this.resourceCnt || 1));
            } else {
                return col % this.daysPerRow;
            }
        },
        getColResource: function(col) {
            return this.flattenedResources[this.getColResourceIndex(col)];
        },
        getColResourceIndex: function(col) {
            if (this.isRTL) {
                col = this.colCnt - 1 - col;
            }
            if (this.datesAboveResources) {
                return col % (this.resourceCnt || 1);
            } else {
                return Math.floor(col / this.daysPerRow);
            }
        },
        indicesToCol: function(resourceIndex, dayIndex) {
            var col;
            col = this.datesAboveResources ? dayIndex * (this.resourceCnt || 1) + resourceIndex : resourceIndex * this.daysPerRow + dayIndex;
            if (this.isRTL) {
                col = this.colCnt - 1 - col;
            }
            return col;
        },
        renderHeadTrHtml: function() {
            if (!this.resourceCnt) {
                return FC.DayTableMixin.renderHeadTrHtml.call(this);
            } else {
                if (this.daysPerRow > 1) {
                    if (this.datesAboveResources) {
                        return this.renderHeadDateAndResourceHtml();
                    } else {
                        return this.renderHeadResourceAndDateHtml();
                    }
                } else {
                    return this.renderHeadResourceHtml();
                }
            }
        },
        renderHeadResourceHtml: function() {
            var j, len, ref, resource, resourceHtmls;
            resourceHtmls = [];
            ref = this.flattenedResources;
            for (j = 0, len = ref.length; j < len; j++) {
                resource = ref[j];
                resourceHtmls.push(this.renderHeadResourceCellHtml(resource));
            }
            return this.wrapTr(resourceHtmls, 'renderHeadIntroHtml');
        },
        renderHeadResourceAndDateHtml: function() {
            var date, dateHtmls, dayIndex, j, k, len, ref, ref1, resource, resourceHtmls;
            resourceHtmls = [];
            dateHtmls = [];
            ref = this.flattenedResources;
            for (j = 0, len = ref.length; j < len; j++) {
                resource = ref[j];
                resourceHtmls.push(this.renderHeadResourceCellHtml(resource, null, this.daysPerRow));
                for (dayIndex = k = 0, ref1 = this.daysPerRow; k < ref1; dayIndex = k += 1) {
                    date = this.dayDates[dayIndex].clone();
                    dateHtmls.push(this.renderHeadResourceDateCellHtml(date, resource));
                }
            }
            return this.wrapTr(resourceHtmls, 'renderHeadIntroHtml') + this.wrapTr(dateHtmls, 'renderHeadIntroHtml');
        },
        renderHeadDateAndResourceHtml: function() {
            var date, dateHtmls, dayIndex, j, k, len, ref, ref1, resource, resourceHtmls;
            dateHtmls = [];
            resourceHtmls = [];
            for (dayIndex = j = 0, ref = this.daysPerRow; j < ref; dayIndex = j += 1) {
                date = this.dayDates[dayIndex].clone();
                dateHtmls.push(this.renderHeadDateCellHtml(date, this.resourceCnt));
                ref1 = this.flattenedResources;
                for (k = 0, len = ref1.length; k < len; k++) {
                    resource = ref1[k];
                    resourceHtmls.push(this.renderHeadResourceCellHtml(resource, date));
                }
            }
            return this.wrapTr(dateHtmls, 'renderHeadIntroHtml') + this.wrapTr(resourceHtmls, 'renderHeadIntroHtml');
        },
        renderHeadResourceCellHtml: function(resource, date, colspan) {
            return '<th class="fc-resource-cell"' + ' data-resource-id="' + resource.id + '"' + (date ? ' data-date="' + date.format('YYYY-MM-DD') + '"' : '') + (colspan > 1 ? ' colspan="' + colspan + '"' : '') + '>' + htmlEscape(this.view.getResourceText(resource)) + '</th>';
        },
        renderHeadResourceDateCellHtml: function(date, resource, colspan) {
            return this.renderHeadDateCellHtml(date, colspan, 'data-resource-id="' + resource.id + '"');
        },
        processHeadResourceEls: function(containerEl) {
            return containerEl.find('.fc-resource-cell').each((function(_this) {
                return function(col, node) {
                    var resource;
                    if (_this.datesAboveResources) {
                        resource = _this.getColResource(col);
                    } else {
                        resource = _this.flattenedResources[_this.isRTL ? _this.flattenedResources.length - 1 - col : col];
                    }
                    return _this.view.trigger('resourceRender', resource, resource, $(node), $());
                };
            })(this));
        },
        renderBgCellsHtml: function(row) {
            var col, date, htmls, j, ref, resource;
            if (!this.resourceCnt) {
                return FC.DayTableMixin.renderBgCellsHtml.call(this, row);
            } else {
                htmls = [];
                for (col = j = 0, ref = this.colCnt; j < ref; col = j += 1) {
                    date = this.getCellDate(row, col);
                    resource = this.getColResource(col);
                    htmls.push(this.renderResourceBgCellHtml(date, resource));
                }
                return htmls.join('');
            }
        },
        renderResourceBgCellHtml: function(date, resource) {
            return this.renderBgCellHtml(date, 'data-resource-id="' + resource.id + '"');
        },
        wrapTr: function(cellHtmls, introMethodName) {
            if (this.isRTL) {
                cellHtmls.reverse();
                return '<tr>' + cellHtmls.join('') + this[introMethodName]() + '</tr>';
            } else {
                return '<tr>' + this[introMethodName]() + cellHtmls.join('') + '</tr>';
            }
        },

        /*
         If there are no per-resource business hour definitions, returns null.
         Otherwise, returns a list of business hours segs for *every* resource.
         */
        computePerResourceBusinessHourSegs: function(wholeDay) {
            var allSegs, anyCustomBusinessHours, businessHours, event, events, j, k, l, len, len1, len2, ref, ref1, resource, segs;
            if (this.flattenedResources) {
                anyCustomBusinessHours = false;
                ref = this.flattenedResources;
                for (j = 0, len = ref.length; j < len; j++) {
                    resource = ref[j];
                    if (resource.businessHours) {
                        anyCustomBusinessHours = true;
                    }
                }
                if (anyCustomBusinessHours) {
                    allSegs = [];
                    ref1 = this.flattenedResources;
                    for (k = 0, len1 = ref1.length; k < len1; k++) {
                        resource = ref1[k];
                        businessHours = resource.businessHours || this.view.opt('businessHours');
                        events = this.view.calendar.computeBusinessHourEvents(wholeDay, businessHours);
                        for (l = 0, len2 = events.length; l < len2; l++) {
                            event = events[l];
                            event.resourceId = resource.id;
                        }
                        segs = this.eventsToSegs(events);
                        allSegs.push.apply(allSegs, segs);
                    }
                    return allSegs;
                }
            }
            return null;
        }
    };

    ResourceDayGrid = (function(superClass) {
        extend(ResourceDayGrid, superClass);

        function ResourceDayGrid() {
            return ResourceDayGrid.__super__.constructor.apply(this, arguments);
        }

        ResourceDayGrid.mixin(ResourceGridMixin);

        ResourceDayGrid.mixin(ResourceDayTableMixin);

        ResourceDayGrid.prototype.getHitSpan = function(hit) {
            var span;
            span = ResourceDayGrid.__super__.getHitSpan.apply(this, arguments);
            if (this.resourceCnt) {
                span.resourceId = this.getColResource(hit.col).id;
            }
            return span;
        };

        ResourceDayGrid.prototype.spanToSegs = function(span) {
            var copy, genericSegs, j, k, l, len, len1, ref, resourceCnt, resourceIndex, resourceObj, resourceSegs, seg;
            resourceCnt = this.resourceCnt;
            genericSegs = this.datesAboveResources ? this.sliceRangeByDay(span) : this.sliceRangeByRow(span);
            if (!resourceCnt) {
                for (j = 0, len = genericSegs.length; j < len; j++) {
                    seg = genericSegs[j];
                    if (this.isRTL) {
                        seg.leftCol = seg.lastRowDayIndex;
                        seg.rightCol = seg.firstRowDayIndex;
                    } else {
                        seg.leftCol = seg.firstRowDayIndex;
                        seg.rightCol = seg.lastRowDayIndex;
                    }
                }
                return genericSegs;
            } else {
                resourceSegs = [];
                for (k = 0, len1 = genericSegs.length; k < len1; k++) {
                    seg = genericSegs[k];
                    for (resourceIndex = l = 0, ref = resourceCnt; l < ref; resourceIndex = l += 1) {
                        resourceObj = this.flattenedResources[resourceIndex];
                        if (!span.resourceId || span.resourceId === resourceObj.id) {
                            copy = $.extend({}, seg);
                            copy.resource = resourceObj;
                            if (this.isRTL) {
                                copy.leftCol = this.indicesToCol(resourceIndex, seg.lastRowDayIndex);
                                copy.rightCol = this.indicesToCol(resourceIndex, seg.firstRowDayIndex);
                            } else {
                                copy.leftCol = this.indicesToCol(resourceIndex, seg.firstRowDayIndex);
                                copy.rightCol = this.indicesToCol(resourceIndex, seg.lastRowDayIndex);
                            }
                            resourceSegs.push(copy);
                        }
                    }
                }
                return resourceSegs;
            }
        };

        ResourceDayGrid.prototype.renderBusinessHours = function() {
            var segs;
            segs = this.computePerResourceBusinessHourSegs(true);
            if (segs) {
                return this.renderFill('businessHours', segs, 'bgevent');
            } else {
                return ResourceDayGrid.__super__.renderBusinessHours.apply(this, arguments);
            }
        };

        return ResourceDayGrid;

    })(FC.DayGrid);

    ResourceTimeGrid = (function(superClass) {
        extend(ResourceTimeGrid, superClass);

        function ResourceTimeGrid() {
            return ResourceTimeGrid.__super__.constructor.apply(this, arguments);
        }

        ResourceTimeGrid.mixin(ResourceGridMixin);

        ResourceTimeGrid.mixin(ResourceDayTableMixin);

        ResourceTimeGrid.prototype.getHitSpan = function(hit) {
            var span;
            span = ResourceTimeGrid.__super__.getHitSpan.apply(this, arguments);
            if (this.resourceCnt) {
                span.resourceId = this.getColResource(hit.col).id;
            }
            return span;
        };

        ResourceTimeGrid.prototype.spanToSegs = function(span) {
            var copy, genericSegs, j, k, l, len, len1, ref, resourceCnt, resourceIndex, resourceObj, resourceSegs, seg;
            resourceCnt = this.resourceCnt;
            genericSegs = this.sliceRangeByTimes(span);
            if (!resourceCnt) {
                for (j = 0, len = genericSegs.length; j < len; j++) {
                    seg = genericSegs[j];
                    seg.col = seg.dayIndex;
                }
                return genericSegs;
            } else {
                resourceSegs = [];
                for (k = 0, len1 = genericSegs.length; k < len1; k++) {
                    seg = genericSegs[k];
                    for (resourceIndex = l = 0, ref = resourceCnt; l < ref; resourceIndex = l += 1) {
                        resourceObj = this.flattenedResources[resourceIndex];
                        if (!span.resourceId || span.resourceId === resourceObj.id) {
                            copy = $.extend({}, seg);
                            copy.resource = resourceObj;
                            copy.col = this.indicesToCol(resourceIndex, seg.dayIndex);
                            resourceSegs.push(copy);
                        }
                    }
                }
                return resourceSegs;
            }
        };

        ResourceTimeGrid.prototype.renderBusinessHours = function() {
            var segs;
            segs = this.computePerResourceBusinessHourSegs(false);
            if (segs) {
                return this.renderBusinessSegs(segs);
            } else {
                return ResourceTimeGrid.__super__.renderBusinessHours.apply(this, arguments);
            }
        };

        return ResourceTimeGrid;

    })(FC.TimeGrid);

    TimelineView = (function(superClass) {
        extend(TimelineView, superClass);

        function TimelineView() {
            return TimelineView.__super__.constructor.apply(this, arguments);
        }

        TimelineView.prototype.timeGrid = null;

        TimelineView.prototype.isScrolled = false;

        TimelineView.prototype.initialize = function() {
            this.timeGrid = this.instantiateGrid();
            return this.intervalDuration = this.timeGrid.duration;
        };

        TimelineView.prototype.instantiateGrid = function() {
            return new TimelineGrid(this);
        };

        TimelineView.prototype.setRange = function(range) {
            TimelineView.__super__.setRange.apply(this, arguments);
            return this.timeGrid.setRange(range);
        };

        TimelineView.prototype.renderSkeleton = function() {
            this.el.addClass('fc-timeline');
            if (this.opt('eventOverlap') === false) {
                this.el.addClass('fc-no-overlap');
            }
            this.el.html(this.renderSkeletonHtml());
            return this.renderTimeGridSkeleton();
        };

        TimelineView.prototype.renderSkeletonHtml = function() {
            return '<table> <thead class="fc-head"> <tr> <td class="fc-time-area ' + this.widgetHeaderClass + '"></td> </tr> </thead> <tbody class="fc-body"> <tr> <td class="fc-time-area ' + this.widgetContentClass + '"></td> </tr> </tbody> </table>';
        };

        TimelineView.prototype.renderTimeGridSkeleton = function() {
            this.timeGrid.setElement(this.el.find('tbody .fc-time-area'));
            this.timeGrid.headEl = this.el.find('thead .fc-time-area');
            this.timeGrid.renderSkeleton();
            this.isScrolled = false;
            return this.timeGrid.bodyScroller.on('scroll', proxy(this, 'handleBodyScroll'));
        };

        TimelineView.prototype.handleBodyScroll = function(top, left) {
            if (top) {
                if (!this.isScrolled) {
                    this.isScrolled = true;
                    return this.el.addClass('fc-scrolled');
                }
            } else {
                if (this.isScrolled) {
                    this.isScrolled = false;
                    return this.el.removeClass('fc-scrolled');
                }
            }
        };

        TimelineView.prototype.unrenderSkeleton = function() {
            this.timeGrid.removeElement();
            this.handleBodyScroll(0);
            return TimelineView.__super__.unrenderSkeleton.apply(this, arguments);
        };

        TimelineView.prototype.renderDates = function() {
            return this.timeGrid.renderDates();
        };

        TimelineView.prototype.unrenderDates = function() {
            return this.timeGrid.unrenderDates();
        };

        TimelineView.prototype.renderBusinessHours = function() {
            return this.timeGrid.renderBusinessHours();
        };

        TimelineView.prototype.unrenderBusinessHours = function() {
            return this.timeGrid.unrenderBusinessHours();
        };

        TimelineView.prototype.getNowIndicatorUnit = function() {
            return this.timeGrid.getNowIndicatorUnit();
        };

        TimelineView.prototype.renderNowIndicator = function(date) {
            return this.timeGrid.renderNowIndicator(date);
        };

        TimelineView.prototype.unrenderNowIndicator = function() {
            return this.timeGrid.unrenderNowIndicator();
        };

        TimelineView.prototype.prepareHits = function() {
            return this.timeGrid.prepareHits();
        };

        TimelineView.prototype.releaseHits = function() {
            return this.timeGrid.releaseHits();
        };

        TimelineView.prototype.queryHit = function(leftOffset, topOffset) {
            return this.timeGrid.queryHit(leftOffset, topOffset);
        };

        TimelineView.prototype.getHitSpan = function(hit) {
            return this.timeGrid.getHitSpan(hit);
        };

        TimelineView.prototype.getHitEl = function(hit) {
            return this.timeGrid.getHitEl(hit);
        };

        TimelineView.prototype.updateWidth = function() {
            return this.timeGrid.updateWidth();
        };

        TimelineView.prototype.setHeight = function(totalHeight, isAuto) {
            var bodyHeight;
            if (isAuto) {
                bodyHeight = 'auto';
            } else {
                bodyHeight = totalHeight - this.timeGrid.headHeight() - this.queryMiscHeight();
            }
            return this.timeGrid.bodyScroller.setHeight(bodyHeight);
        };

        TimelineView.prototype.queryMiscHeight = function() {
            return this.el.outerHeight() - this.timeGrid.headScroller.el.outerHeight() - this.timeGrid.bodyScroller.el.outerHeight();
        };

        TimelineView.prototype.computeInitialScroll = function(prevScrollState) {
            return this.timeGrid.computeInitialScroll(prevScrollState);
        };

        TimelineView.prototype.queryScroll = function() {
            return this.timeGrid.queryScroll();
        };

        TimelineView.prototype.setScroll = function(state) {
            return this.timeGrid.setScroll(state);
        };

        TimelineView.prototype.renderEvents = function(events) {
            this.timeGrid.renderEvents(events);
            return this.updateWidth();
        };

        TimelineView.prototype.unrenderEvents = function() {
            this.timeGrid.unrenderEvents();
            return this.updateWidth();
        };

        TimelineView.prototype.renderDrag = function(dropLocation, seg) {
            return this.timeGrid.renderDrag(dropLocation, seg);
        };

        TimelineView.prototype.unrenderDrag = function() {
            return this.timeGrid.unrenderDrag();
        };

        TimelineView.prototype.getEventSegs = function() {
            return this.timeGrid.getEventSegs();
        };

        TimelineView.prototype.renderSelection = function(range) {
            return this.timeGrid.renderSelection(range);
        };

        TimelineView.prototype.unrenderSelection = function() {
            return this.timeGrid.unrenderSelection();
        };

        return TimelineView;

    })(View);

    cssToStr = FC.cssToStr;

    TimelineGrid = (function(superClass) {
        extend(TimelineGrid, superClass);

        TimelineGrid.prototype.slotDates = null;

        TimelineGrid.prototype.slotCnt = null;

        TimelineGrid.prototype.snapCnt = null;

        TimelineGrid.prototype.snapsPerSlot = null;

        TimelineGrid.prototype.snapDiffToIndex = null;

        TimelineGrid.prototype.snapIndexToDiff = null;

        TimelineGrid.prototype.headEl = null;

        TimelineGrid.prototype.slatContainerEl = null;

        TimelineGrid.prototype.slatEls = null;

        TimelineGrid.prototype.containerCoordCache = null;

        TimelineGrid.prototype.slatCoordCache = null;

        TimelineGrid.prototype.slatInnerCoordCache = null;

        TimelineGrid.prototype.headScroller = null;

        TimelineGrid.prototype.bodyScroller = null;

        TimelineGrid.prototype.joiner = null;

        TimelineGrid.prototype.follower = null;

        TimelineGrid.prototype.eventTitleFollower = null;

        TimelineGrid.prototype.minTime = null;

        TimelineGrid.prototype.maxTime = null;

        TimelineGrid.prototype.timeWindowMs = null;

        TimelineGrid.prototype.slotDuration = null;

        TimelineGrid.prototype.snapDuration = null;

        TimelineGrid.prototype.duration = null;

        TimelineGrid.prototype.labelInterval = null;

        TimelineGrid.prototype.headerFormats = null;

        TimelineGrid.prototype.isTimeScale = null;

        TimelineGrid.prototype.largeUnit = null;

        TimelineGrid.prototype.emphasizeWeeks = false;

        TimelineGrid.prototype.titleFollower = null;

        TimelineGrid.prototype.segContainerEl = null;

        TimelineGrid.prototype.segContainerHeight = null;

        TimelineGrid.prototype.bgSegContainerEl = null;

        TimelineGrid.prototype.helperEls = null;

        TimelineGrid.prototype.innerEl = null;

        function TimelineGrid() {
            var input;
            TimelineGrid.__super__.constructor.apply(this, arguments);
            this.initScaleProps();
            this.minTime = moment.duration(this.opt('minTime') || '00:00');
            this.maxTime = moment.duration(this.opt('maxTime') || '24:00');
            this.timeWindowMs = this.maxTime - this.minTime;
            this.snapDuration = (input = this.opt('snapDuration')) ? moment.duration(input) : this.slotDuration;
            this.minResizeDuration = this.snapDuration;
            this.snapsPerSlot = divideDurationByDuration(this.slotDuration, this.snapDuration);
            this.slotWidth = this.opt('slotWidth');
        }

        TimelineGrid.prototype.opt = function(name) {
            return this.view.opt(name);
        };

        TimelineGrid.prototype.isValidDate = function(date) {
            var ms;
            if (this.view.isHiddenDay(date)) {
                return false;
            } else if (this.isTimeScale) {
                ms = date.time() - this.minTime;
                ms = ((ms % 86400000) + 86400000) % 86400000;
                return ms < this.timeWindowMs;
            } else {
                return true;
            }
        };

        TimelineGrid.prototype.computeDisplayEventTime = function() {
            return !this.isTimeScale;
        };

        TimelineGrid.prototype.computeDisplayEventEnd = function() {
            return false;
        };

        TimelineGrid.prototype.computeEventTimeFormat = function() {
            return this.opt('extraSmallTimeFormat');
        };


        /*
         Makes the given date consistent with isTimeScale/largeUnit,
         so, either removes the times, ensures a time, or makes it the startOf largeUnit.
         Strips all timezones. Returns new copy.
         TODO: should maybe be called "normalizeRangeDate".
         */

        TimelineGrid.prototype.normalizeGridDate = function(date) {
            var normalDate;
            if (this.isTimeScale) {
                normalDate = date.clone();
                if (!normalDate.hasTime()) {
                    normalDate.time(0);
                }
            } else {
                normalDate = date.clone().stripTime();
                if (this.largeUnit) {
                    normalDate.startOf(this.largeUnit);
                }
            }
            return normalDate;
        };

        TimelineGrid.prototype.normalizeGridRange = function(range) {
            var adjustedEnd, normalRange;
            if (this.isTimeScale) {
                normalRange = {
                    start: this.normalizeGridDate(range.start),
                    end: this.normalizeGridDate(range.end)
                };
            } else {
                normalRange = this.view.computeDayRange(range);
                if (this.largeUnit) {
                    normalRange.start.startOf(this.largeUnit);
                    adjustedEnd = normalRange.end.clone().startOf(this.largeUnit);
                    if (!adjustedEnd.isSame(normalRange.end) || !adjustedEnd.isAfter(normalRange.start)) {
                        adjustedEnd.add(this.slotDuration);
                    }
                    normalRange.end = adjustedEnd;
                }
            }
            return normalRange;
        };

        TimelineGrid.prototype.rangeUpdated = function() {
            var date, slotDates;
            this.start = this.normalizeGridDate(this.start);
            this.end = this.normalizeGridDate(this.end);
            if (this.isTimeScale) {
                this.start.add(this.minTime);
                this.end.subtract(1, 'day').add(this.maxTime);
            }
            slotDates = [];
            date = this.start.clone();
            while (date < this.end) {
                if (this.isValidDate(date)) {
                    slotDates.push(date.clone());
                }
                date.add(this.slotDuration);
            }
            this.slotDates = slotDates;
            return this.updateGridDates();
        };

        TimelineGrid.prototype.updateGridDates = function() {
            var date, snapDiff, snapDiffToIndex, snapIndex, snapIndexToDiff;
            snapIndex = -1;
            snapDiff = 0;
            snapDiffToIndex = [];
            snapIndexToDiff = [];
            date = this.start.clone();
            while (date < this.end) {
                if (this.isValidDate(date)) {
                    snapIndex++;
                    snapDiffToIndex.push(snapIndex);
                    snapIndexToDiff.push(snapDiff);
                } else {
                    snapDiffToIndex.push(snapIndex + 0.5);
                }
                date.add(this.snapDuration);
                snapDiff++;
            }
            this.snapDiffToIndex = snapDiffToIndex;
            this.snapIndexToDiff = snapIndexToDiff;
            this.snapCnt = snapIndex + 1;
            return this.slotCnt = this.snapCnt / this.snapsPerSlot;
        };

        TimelineGrid.prototype.spanToSegs = function(span) {
            var normalRange, seg;
            normalRange = this.normalizeGridRange(span);
            if (this.computeDateSnapCoverage(span.start) < this.computeDateSnapCoverage(span.end)) {
                seg = intersectRanges(normalRange, this);
                if (seg) {
                    if (seg.isStart && !this.isValidDate(seg.start)) {
                        seg.isStart = false;
                    }
                    if (seg.isEnd && seg.end && !this.isValidDate(seg.end.clone().subtract(1))) {
                        seg.isEnd = false;
                    }
                    return [seg];
                }
            }
            return [];
        };

        TimelineGrid.prototype.prepareHits = function() {
            return this.buildCoords();
        };

        TimelineGrid.prototype.queryHit = function(leftOffset, topOffset) {
            var containerCoordCache, localSnapIndex, partial, slatCoordCache, slatIndex, slatLeft, slatRight, slatWidth, snapIndex, snapLeft, snapRight, snapsPerSlot;
            snapsPerSlot = this.snapsPerSlot;
            slatCoordCache = this.slatCoordCache;
            containerCoordCache = this.containerCoordCache;
            if (containerCoordCache.isTopInBounds(topOffset)) {
                slatIndex = slatCoordCache.getHorizontalIndex(leftOffset);
                if (slatIndex != null) {
                    slatWidth = slatCoordCache.getWidth(slatIndex);
                    if (this.isRTL) {
                        slatRight = slatCoordCache.getRightOffset(slatIndex);
                        partial = (slatRight - leftOffset) / slatWidth;
                        localSnapIndex = Math.floor(partial * snapsPerSlot);
                        snapIndex = slatIndex * snapsPerSlot + localSnapIndex;
                        snapRight = slatRight - (localSnapIndex / snapsPerSlot) * slatWidth;
                        snapLeft = snapRight - ((localSnapIndex + 1) / snapsPerSlot) * slatWidth;
                    } else {
                        slatLeft = slatCoordCache.getLeftOffset(slatIndex);
                        partial = (leftOffset - slatLeft) / slatWidth;
                        localSnapIndex = Math.floor(partial * snapsPerSlot);
                        snapIndex = slatIndex * snapsPerSlot + localSnapIndex;
                        snapLeft = slatLeft + (localSnapIndex / snapsPerSlot) * slatWidth;
                        snapRight = slatLeft + ((localSnapIndex + 1) / snapsPerSlot) * slatWidth;
                    }
                    return {
                        snap: snapIndex,
                        component: this,
                        left: snapLeft,
                        right: snapRight,
                        top: containerCoordCache.getTopOffset(0),
                        bottom: containerCoordCache.getBottomOffset(0)
                    };
                }
            }
        };

        TimelineGrid.prototype.getHitSpan = function(hit) {
            return this.getSnapRange(hit.snap);
        };

        TimelineGrid.prototype.getHitEl = function(hit) {
            return this.getSnapEl(hit.snap);
        };

        TimelineGrid.prototype.getSnapRange = function(snapIndex) {
            var end, start;
            start = this.start.clone();
            start.add(multiplyDuration(this.snapDuration, this.snapIndexToDiff[snapIndex]));
            end = start.clone().add(this.snapDuration);
            return {
                start: start,
                end: end
            };
        };

        TimelineGrid.prototype.getSnapEl = function(snapIndex) {
            return this.slatEls.eq(Math.floor(snapIndex / this.snapsPerSlot));
        };

        TimelineGrid.prototype.renderSkeleton = function() {
            this.headScroller = new ClippedScroller({
                overflowX: 'clipped-scroll',
                overflowY: 'hidden'
            });
            this.headScroller.canvas = new ScrollerCanvas();
            this.headScroller.render();
            this.headEl.append(this.headScroller.el);
            this.bodyScroller = new ClippedScroller();
            this.bodyScroller.canvas = new ScrollerCanvas();
            this.bodyScroller.render();
            this.el.append(this.bodyScroller.el);
            this.innerEl = this.bodyScroller.canvas.contentEl;
            this.slatContainerEl = $('<div class="fc-slats"/>').appendTo(this.bodyScroller.canvas.bgEl);
            this.segContainerEl = $('<div class="fc-event-container"/>').appendTo(this.bodyScroller.canvas.contentEl);
            this.bgSegContainerEl = this.bodyScroller.canvas.bgEl;
            this.containerCoordCache = new CoordCache({
                els: this.bodyScroller.canvas.el,
                isHorizontal: true,
                isVertical: true
            });
            this.joiner = new ScrollJoiner('horizontal', [this.headScroller, this.bodyScroller]);
            if (true) {
                this.follower = new ScrollFollower(this.headScroller, this.view.calendar.isTouch);
            }
            if (true) {
                this.eventTitleFollower = new ScrollFollower(this.bodyScroller, this.view.calendar.isTouch);
                this.eventTitleFollower.minTravel = 50;
                if (this.isRTL) {
                    this.eventTitleFollower.containOnNaturalRight = true;
                } else {
                    this.eventTitleFollower.containOnNaturalLeft = true;
                }
            }
            return TimelineGrid.__super__.renderSkeleton.apply(this, arguments);
        };

        TimelineGrid.prototype.headColEls = null;

        TimelineGrid.prototype.slatColEls = null;

        TimelineGrid.prototype.renderDates = function() {
            var date, i, j, len, ref;
            this.headScroller.canvas.contentEl.html(this.renderHeadHtml());
            this.headColEls = this.headScroller.canvas.contentEl.find('col');
            this.slatContainerEl.html(this.renderSlatHtml());
            this.slatColEls = this.slatContainerEl.find('col');
            this.slatEls = this.slatContainerEl.find('td');
            this.slatCoordCache = new CoordCache({
                els: this.slatEls,
                isHorizontal: true
            });
            this.slatInnerCoordCache = new CoordCache({
                els: this.slatEls.find('> div'),
                isHorizontal: true,
                offsetParent: this.bodyScroller.canvas.el
            });
            ref = this.slotDates;
            for (i = j = 0, len = ref.length; j < len; i = ++j) {
                date = ref[i];
                this.view.trigger('dayRender', null, date, this.slatEls.eq(i));
            }
            if (this.follower) {
                return this.follower.setSprites(this.headEl.find('tr:not(:last-child) span'));
            }
        };

        TimelineGrid.prototype.unrenderDates = function() {
            if (this.follower) {
                this.follower.clearSprites();
            }
            this.headScroller.canvas.contentEl.empty();
            this.slatContainerEl.empty();
            this.headScroller.canvas.clearWidth();
            return this.bodyScroller.canvas.clearWidth();
        };

        TimelineGrid.prototype.renderHeadHtml = function() {
            var cell, cellRows, date, dateData, format, formats, html, i, isChrono, isLast, isSuperRow, isWeekStart, j, k, l, labelInterval, leadingCell, len, len1, len2, len3, len4, len5, len6, m, n, newCell, p, prevWeekNumber, q, row, rowCells, slatHtml, slotCells, slotDates, text, weekNumber;
            labelInterval = this.labelInterval;
            formats = this.headerFormats;
            cellRows = (function() {
                var j, len, results;
                results = [];
                for (j = 0, len = formats.length; j < len; j++) {
                    format = formats[j];
                    results.push([]);
                }
                return results;
            })();
            leadingCell = null;
            prevWeekNumber = null;
            slotDates = this.slotDates;
            slotCells = [];
            var start_w = "",end_w = "",oToday,currentDay;
            for (j = 0, len = slotDates.length; j < len; j++) {
                date = slotDates[j];
                weekNumber = date.week();
                isWeekStart = this.emphasizeWeeks && prevWeekNumber !== null && prevWeekNumber !== weekNumber;
                for (row = k = 0, len1 = formats.length; k < len1; row = ++k) {
                    format = formats[row];
                    rowCells = cellRows[row];
                    leadingCell = rowCells[rowCells.length - 1];
                    isSuperRow = formats.length > 1 && row < formats.length - 1;
                    newCell = null;
                    if (isSuperRow) {
                        //格式化头部时间
                        text = date.format(format);
                        dateData = date.format();
                        //获取起始日期
                        if(format == "W"){
                            oToday=date._d;
                            currentDay=oToday.getDay();
                            if(currentDay==0){currentDay=7}
                            start_w=Strack.UnixToDate((oToday.getTime()-(currentDay-1)*24*60*60*1000)/1000);
                            end_w=Strack.UnixToDate((oToday.getTime()+(7-currentDay)*24*60*60*1000)/1000);
                            text = start_w+"/"+end_w+"  W"+text;
                        }
                        if (!leadingCell || leadingCell.text !== text) {
                            newCell = {
                                text: text,
                                dateData: dateData,
                                colspan: 1
                            };
                        } else {
                            leadingCell.colspan += 1;
                        }
                    } else {
                        if (!leadingCell || isInt(divideRangeByDuration(this.start, date, labelInterval))) {
                            text = date.format(format);
                            dateData = date.format();
                            newCell = {
                                text: text,
                                dateData: dateData,
                                colspan: 1
                            };
                        } else {
                            leadingCell.colspan += 1;
                        }
                    }
                    if (newCell) {
                        newCell.weekStart = isWeekStart;
                        rowCells.push(newCell);
                    }
                }
                slotCells.push({
                    weekStart: isWeekStart
                });
                prevWeekNumber = weekNumber;
            }
            isChrono = labelInterval > this.slotDuration;
            html = '<table>';
            html += '<colgroup>';
            for (l = 0, len2 = slotDates.length; l < len2; l++) {
                date = slotDates[l];
                html += '<col/>';
            }
            html += '</colgroup>';
            html += '<tbody>';
            for (i = m = 0, len3 = cellRows.length; m < len3; i = ++m) {
                rowCells = cellRows[i];
                isLast = i === cellRows.length - 1;
                html += '<tr' + (isChrono && isLast ? ' class="fc-chrono"' : '') + '>';
                for (n = 0, len4 = rowCells.length; n < len4; n++) {
                    cell = rowCells[n];
                    html += '<th class="' + this.view.widgetHeaderClass + ' ' + (cell.weekStart ? 'fc-em-cell' : '') + '"' + ' data-date="' + cell.dateData + '"' + (cell.colspan > 1 ? ' colspan="' + cell.colspan + '"' : '') + '>' + '<div class="fc-cell-content">' + '<span class="fc-cell-text">' + htmlEscape(cell.text) + '</span>' + '</div>' + '</th>';
                }
                html += '</tr>';
            }
            html += '</tbody></table>';
            slatHtml = '<table>';
            slatHtml += '<colgroup>';
            for (p = 0, len5 = slotCells.length; p < len5; p++) {
                cell = slotCells[p];
                slatHtml += '<col/>';
            }
            slatHtml += '</colgroup>';
            slatHtml += '<tbody><tr>';
            for (i = q = 0, len6 = slotCells.length; q < len6; i = ++q) {
                cell = slotCells[i];
                date = slotDates[i];
                slatHtml += this.slatCellHtml(date, cell.weekStart);
            }
            slatHtml += '</tr></tbody></table>';
            this._slatHtml = slatHtml;
            return html;
        };

        TimelineGrid.prototype.renderSlatHtml = function() {
            return this._slatHtml;
        };

        TimelineGrid.prototype.slatCellHtml = function(date, isEm) {
            var classes,dtoday;
            if (this.isTimeScale) {
                classes = [];
                classes.push(isInt(divideRangeByDuration(this.start, date, this.labelInterval)) ? 'fc-major' : 'fc-minor');
            } else {
                classes = this.getDayClasses(date);
                classes.push('fc-day');
            }
            classes.unshift(this.view.widgetContentClass);
            if (isEm) {
                classes.push('fc-em-cell');
            }
            return '<td class="' + classes.join(' ') + '"' + ' data-date="' + date.format() + '"' + '><div /></td>';
        };

        TimelineGrid.prototype.businessHourSegs = null;

        TimelineGrid.prototype.renderBusinessHours = function() {
            var segs;
            if (!this.largeUnit) {
                segs = this.businessHourSegs = this.buildBusinessHourSegs(!this.isTimeScale);
                return this.renderFill('businessHours', segs, 'bgevent');
            }
        };

        TimelineGrid.prototype.unrenderBusinessHours = function() {
            return this.unrenderFill('businessHours');
        };

        TimelineGrid.prototype.nowIndicatorEls = null;

        TimelineGrid.prototype.getNowIndicatorUnit = function() {
            if (this.isTimeScale) {
                return computeIntervalUnit(this.slotDuration);
            }
        };

        TimelineGrid.prototype.renderNowIndicator = function(date) {
            var coord, css, nodes;
            nodes = [];
            date = this.normalizeGridDate(date);
            if (date >= this.start && date < this.end) {
                coord = this.dateToCoord(date);
                css = this.isRTL ? {
                    right: -coord
                } : {
                    left: coord
                };
                nodes.push($("<div class='fc-now-indicator fc-now-indicator-arrow'></div>").css(css).appendTo(this.headScroller.canvas.el)[0]);
                nodes.push($("<div class='fc-now-indicator fc-now-indicator-line'></div>").css(css).appendTo(this.bodyScroller.canvas.el)[0]);
            }
            return this.nowIndicatorEls = $(nodes);
        };

        TimelineGrid.prototype.unrenderNowIndicator = function() {
            if (this.nowIndicatorEls) {
                this.nowIndicatorEls.remove();
                return this.nowIndicatorEls = null;
            }
        };

        TimelineGrid.prototype.explicitSlotWidth = null;

        TimelineGrid.prototype.defaultSlotWidth = null;

        TimelineGrid.prototype.updateWidth = function() {
            var availableWidth, containerMinWidth, containerWidth, nonLastSlotWidth, slotWidth;
            slotWidth = Math.round(this.slotWidth || (this.slotWidth = this.computeSlotWidth()));
            containerWidth = slotWidth * this.slotDates.length;
            containerMinWidth = '';
            nonLastSlotWidth = slotWidth;
            availableWidth = this.bodyScroller.getClientWidth();
            if (availableWidth > containerWidth) {
                containerMinWidth = availableWidth;
                containerWidth = '';
                nonLastSlotWidth = Math.floor(availableWidth / this.slotDates.length);
            }
            this.headScroller.canvas.setWidth(containerWidth);
            this.headScroller.canvas.setMinWidth(containerMinWidth);
            this.bodyScroller.canvas.setWidth(containerWidth);
            this.bodyScroller.canvas.setMinWidth(containerMinWidth);
            this.headColEls.slice(0, -1).add(this.slatColEls.slice(0, -1)).width(nonLastSlotWidth);
            this.headScroller.updateSize();
            this.bodyScroller.updateSize();
            this.joiner.update();
            this.buildCoords();
            this.updateSegPositions();
            this.view.updateNowIndicator();
            if (this.follower) {
                this.follower.update();
            }
            if (this.eventTitleFollower) {
                return this.eventTitleFollower.update();
            }
        };

        TimelineGrid.prototype.computeSlotWidth = function() {
            var headerWidth, innerEls, maxInnerWidth, minWidth, slotWidth, slotsPerLabel;
            maxInnerWidth = 0;
            innerEls = this.headEl.find('tr:last-child th span');
            innerEls.each(function(i, node) {
                var innerWidth;
                innerWidth = $(node).outerWidth();
                return maxInnerWidth = Math.max(maxInnerWidth, innerWidth);
            });
            headerWidth = maxInnerWidth + 1;
            slotsPerLabel = divideDurationByDuration(this.labelInterval, this.slotDuration);
            slotWidth = Math.ceil(headerWidth / slotsPerLabel);
            minWidth = this.headColEls.eq(0).css('min-width');
            if (minWidth) {
                minWidth = parseInt(minWidth, 10);
                if (minWidth) {
                    slotWidth = Math.max(slotWidth, minWidth);
                }
            }
            return slotWidth;
        };

        TimelineGrid.prototype.buildCoords = function() {
            this.containerCoordCache.build();
            this.slatCoordCache.build();
            return this.slatInnerCoordCache.build();
        };

        TimelineGrid.prototype.computeDateSnapCoverage = function(date) {
            var snapCoverage, snapDiff, snapDiffInt;
            snapDiff = divideRangeByDuration(this.start, date, this.snapDuration);
            if (snapDiff < 0) {
                return 0;
            } else if (snapDiff >= this.snapDiffToIndex.length) {
                return this.snapCnt;
            } else {
                snapDiffInt = Math.floor(snapDiff);
                snapCoverage = this.snapDiffToIndex[snapDiffInt];
                if (isInt(snapCoverage)) {
                    snapCoverage += snapDiff - snapDiffInt;
                } else {
                    snapCoverage = Math.ceil(snapCoverage);
                }
                return snapCoverage;
            }
        };

        TimelineGrid.prototype.dateToCoord = function(date) {
            var coordCache, partial, slotCoverage, slotIndex, snapCoverage;
            snapCoverage = this.computeDateSnapCoverage(date);
            slotCoverage = snapCoverage / this.snapsPerSlot;
            slotIndex = Math.floor(slotCoverage);
            slotIndex = Math.min(slotIndex, this.slotCnt - 1);
            partial = slotCoverage - slotIndex;
            coordCache = this.slatInnerCoordCache;
            if (this.isRTL) {
                return (coordCache.getRightPosition(slotIndex) - coordCache.getWidth(slotIndex) * partial) - this.containerCoordCache.getWidth(0);
            } else {
                return coordCache.getLeftPosition(slotIndex) + coordCache.getWidth(slotIndex) * partial;
            }
        };

        TimelineGrid.prototype.rangeToCoords = function(range) {
            if (this.isRTL) {
                return {
                    right: this.dateToCoord(range.start),
                    left: this.dateToCoord(range.end)
                };
            } else {
                return {
                    left: this.dateToCoord(range.start),
                    right: this.dateToCoord(range.end)
                };
            }
        };

        TimelineGrid.prototype.headHeight = function() {
            var table;
            table = this.headScroller.canvas.contentEl.find('table');
            return table.height.apply(table, arguments);
        };

        TimelineGrid.prototype.updateSegPositions = function() {
            var coords, j, len, seg, segs;
            segs = (this.segs || []).concat(this.businessHourSegs || []);
            for (j = 0, len = segs.length; j < len; j++) {
                seg = segs[j];
                coords = this.rangeToCoords(seg);
                seg.el.css({
                    left: (seg.left = coords.left),
                    right: -(seg.right = coords.right)
                });
            }
        };

        TimelineGrid.prototype.computeInitialScroll = function(prevState) {
            var left, scrollTime;
            left = 0;
            if (this.isTimeScale) {
                scrollTime = this.opt('scrollTime');
                if (scrollTime) {
                    scrollTime = moment.duration(scrollTime);
                    left = this.dateToCoord(this.start.clone().time(scrollTime));
                }
            }
            return {
                left: left,
                top: 0
            };
        };

        TimelineGrid.prototype.queryScroll = function() {
            return {
                left: this.bodyScroller.getScrollLeft(),
                top: this.bodyScroller.getScrollTop()
            };
        };

        TimelineGrid.prototype.setScroll = function(state) {
            this.headScroller.setScrollLeft(state.left);
            this.headScroller.setScrollLeft(state.left);
            return this.bodyScroller.setScrollTop(state.top);
        };

        TimelineGrid.prototype.renderFgSegs = function(segs) {
            segs = this.renderFgSegEls(segs);
            this.renderFgSegsInContainers([[this, segs]]);
            this.updateSegFollowers(segs);
            return segs;
        };

        TimelineGrid.prototype.unrenderFgSegs = function() {
            this.clearSegFollowers();
            return this.unrenderFgContainers([this]);
        };

        TimelineGrid.prototype.renderFgSegsInContainers = function(pairs) {
            var container, coords, j, k, l, len, len1, len2, len3, len4, len5, len6, len7, m, n, p, q, r, ref, ref1, ref2, ref3, results, seg, segs;
            for (j = 0, len = pairs.length; j < len; j++) {
                ref = pairs[j], container = ref[0], segs = ref[1];
                for (k = 0, len1 = segs.length; k < len1; k++) {
                    seg = segs[k];
                    coords = this.rangeToCoords(seg);
                    seg.el.css({
                        left: (seg.left = coords.left),
                        right: -(seg.right = coords.right)
                    });
                }
            }
            for (l = 0, len2 = pairs.length; l < len2; l++) {
                ref1 = pairs[l], container = ref1[0], segs = ref1[1];
                for (m = 0, len3 = segs.length; m < len3; m++) {
                    seg = segs[m];
                    seg.el.appendTo(container.segContainerEl);
                }
            }
            for (n = 0, len4 = pairs.length; n < len4; n++) {
                ref2 = pairs[n], container = ref2[0], segs = ref2[1];
                for (p = 0, len5 = segs.length; p < len5; p++) {
                    seg = segs[p];
                    seg.height = seg.el.outerHeight(true);
                }
                this.buildSegLevels(segs);
                container.segContainerHeight = computeOffsetForSegs(segs);
            }
            results = [];
            for (q = 0, len6 = pairs.length; q < len6; q++) {
                ref3 = pairs[q], container = ref3[0], segs = ref3[1];
                for (r = 0, len7 = segs.length; r < len7; r++) {
                    seg = segs[r];
                    seg.el.css('top', seg.top);
                }
                results.push(container.segContainerEl.height(container.segContainerHeight));
            }
            return results;
        };

        TimelineGrid.prototype.buildSegLevels = function(segs) {
            var belowSeg, isLevelCollision, j, k, l, len, len1, len2, level, placedSeg, ref, ref1, segLevels, unplacedSeg;
            segLevels = [];
            this.sortEventSegs(segs);
            for (j = 0, len = segs.length; j < len; j++) {
                unplacedSeg = segs[j];
                unplacedSeg.above = [];
                level = 0;
                while (level < segLevels.length) {
                    isLevelCollision = false;
                    ref = segLevels[level];
                    for (k = 0, len1 = ref.length; k < len1; k++) {
                        placedSeg = ref[k];
                        if (timeRowSegsCollide(unplacedSeg, placedSeg)) {
                            unplacedSeg.above.push(placedSeg);
                            isLevelCollision = true;
                        }
                    }
                    if (isLevelCollision) {
                        level += 1;
                    } else {
                        break;
                    }
                }
                (segLevels[level] || (segLevels[level] = [])).push(unplacedSeg);
                level += 1;
                while (level < segLevels.length) {
                    ref1 = segLevels[level];
                    for (l = 0, len2 = ref1.length; l < len2; l++) {
                        belowSeg = ref1[l];
                        if (timeRowSegsCollide(unplacedSeg, belowSeg)) {
                            belowSeg.above.push(unplacedSeg);
                        }
                    }
                    level += 1;
                }
            }
            return segLevels;
        };

        TimelineGrid.prototype.unrenderFgContainers = function(containers) {
            var container, j, len, results;
            results = [];
            for (j = 0, len = containers.length; j < len; j++) {
                container = containers[j];
                container.segContainerEl.empty();
                container.segContainerEl.height('');
                results.push(container.segContainerHeight = null);
            }
            return results;
        };

        TimelineGrid.prototype.fgSegHtml = function(seg, disableResizing) {
            var classes, event, isDraggable, isResizableFromEnd, isResizableFromStart, timeText;
            event = seg.event;
            isDraggable = this.view.isEventDraggable(event);
            isResizableFromStart = seg.isStart && this.view.isEventResizableFromStart(event);
            isResizableFromEnd = seg.isEnd && this.view.isEventResizableFromEnd(event);
            classes = this.getSegClasses(seg, isDraggable, isResizableFromStart || isResizableFromEnd);
            classes.unshift('fc-timeline-event', 'fc-h-event');
            timeText = this.getEventTimeText(event);
            return '<a class="' + classes.join(' ') + '" style="' + cssToStr(this.getSegSkinCss(seg)) + '"' + (event.url ? ' href="' + htmlEscape(event.url) + '"' : '') + '>' + '<div class="fc-content">' + (timeText ? '<span class="fc-time">' + htmlEscape(timeText) + '</span>' : '') + '<span class="fc-title">' + (event.title ? htmlEscape(event.title) : '&nbsp;') + '</span>' + '</div>' + '<div class="fc-bg" />' + (isResizableFromStart ? '<div class="fc-resizer fc-start-resizer"></div>' : '') + (isResizableFromEnd ? '<div class="fc-resizer fc-end-resizer"></div>' : '') + '</a>';
        };

        TimelineGrid.prototype.updateSegFollowers = function(segs) {
            var j, len, seg, sprites, titleEl;
            if (this.eventTitleFollower) {
                sprites = [];
                for (j = 0, len = segs.length; j < len; j++) {
                    seg = segs[j];
                    titleEl = seg.el.find('.fc-title');
                    if (titleEl.length) {
                        sprites.push(new ScrollFollowerSprite(titleEl));
                    }
                }
                return this.eventTitleFollower.setSprites(sprites);
            }
        };

        TimelineGrid.prototype.clearSegFollowers = function() {
            if (this.eventTitleFollower) {
                return this.eventTitleFollower.clearSprites();
            }
        };

        TimelineGrid.prototype.segDragStart = function() {
            TimelineGrid.__super__.segDragStart.apply(this, arguments);
            if (this.eventTitleFollower) {
                return this.eventTitleFollower.forceRelative();
            }
        };

        TimelineGrid.prototype.segDragEnd = function() {
            TimelineGrid.__super__.segDragEnd.apply(this, arguments);
            if (this.eventTitleFollower) {
                return this.eventTitleFollower.clearForce();
            }
        };

        TimelineGrid.prototype.segResizeStart = function() {
            TimelineGrid.__super__.segResizeStart.apply(this, arguments);
            if (this.eventTitleFollower) {
                return this.eventTitleFollower.forceRelative();
            }
        };

        TimelineGrid.prototype.segResizeEnd = function() {
            TimelineGrid.__super__.segResizeEnd.apply(this, arguments);
            if (this.eventTitleFollower) {
                return this.eventTitleFollower.clearForce();
            }
        };

        TimelineGrid.prototype.renderHelper = function(event, sourceSeg) {
            var segs;
            segs = this.eventToSegs(event);
            segs = this.renderFgSegEls(segs);
            return this.renderHelperSegsInContainers([[this, segs]], sourceSeg);
        };

        TimelineGrid.prototype.renderHelperSegsInContainers = function(pairs, sourceSeg) {
            var containerObj, coords, helperContainerEl, helperNodes, j, k, l, len, len1, len2, len3, m, ref, ref1, ref2, seg, segNodes, segs;
            helperNodes = [];
            segNodes = [];
            for (j = 0, len = pairs.length; j < len; j++) {
                ref = pairs[j], containerObj = ref[0], segs = ref[1];
                for (k = 0, len1 = segs.length; k < len1; k++) {
                    seg = segs[k];
                    coords = this.rangeToCoords(seg);
                    seg.el.css({
                        left: (seg.left = coords.left),
                        right: -(seg.right = coords.right)
                    });
                    if (sourceSeg && sourceSeg.resourceId === ((ref1 = containerObj.resource) != null ? ref1.id : void 0)) {
                        seg.el.css('top', sourceSeg.el.css('top'));
                    } else {
                        seg.el.css('top', 0);
                    }
                }
            }
            for (l = 0, len2 = pairs.length; l < len2; l++) {
                ref2 = pairs[l], containerObj = ref2[0], segs = ref2[1];
                helperContainerEl = $('<div class="fc-event-container fc-helper-container"/>').appendTo(containerObj.innerEl);
                helperNodes.push(helperContainerEl[0]);
                for (m = 0, len3 = segs.length; m < len3; m++) {
                    seg = segs[m];
                    helperContainerEl.append(seg.el);
                    segNodes.push(seg.el[0]);
                }
            }
            if (this.helperEls) {
                this.helperEls = this.helperEls.add($(helperNodes));
            } else {
                this.helperEls = $(helperNodes);
            }
            return $(segNodes);
        };

        TimelineGrid.prototype.unrenderHelper = function() {
            if (this.helperEls) {
                this.helperEls.remove();
                return this.helperEls = null;
            }
        };

        TimelineGrid.prototype.renderEventResize = function(resizeLocation, seg) {
            this.renderHighlight(this.eventToSpan(resizeLocation));
            return this.renderEventLocationHelper(resizeLocation, seg);
        };

        TimelineGrid.prototype.unrenderEventResize = function() {
            this.unrenderHighlight();
            return this.unrenderHelper();
        };

        TimelineGrid.prototype.renderFill = function(type, segs, className) {
            segs = this.renderFillSegEls(type, segs);
            this.renderFillInContainers(type, [[this, segs]], className);
            return segs;
        };

        TimelineGrid.prototype.renderFillInContainers = function(type, pairs, className) {
            var containerObj, j, len, ref, results, segs;
            results = [];
            for (j = 0, len = pairs.length; j < len; j++) {
                ref = pairs[j], containerObj = ref[0], segs = ref[1];
                results.push(this.renderFillInContainer(type, containerObj, segs, className));
            }
            return results;
        };

        TimelineGrid.prototype.renderFillInContainer = function(type, containerObj, segs, className) {
            var containerEl, coords, j, len, seg;
            if (segs.length) {
                className || (className = type.toLowerCase());
                containerEl = $('<div class="fc-' + className + '-container" />').appendTo(containerObj.bgSegContainerEl);
                for (j = 0, len = segs.length; j < len; j++) {
                    seg = segs[j];
                    coords = this.rangeToCoords(seg);
                    seg.el.css({
                        left: (seg.left = coords.left),
                        right: -(seg.right = coords.right)
                    });
                    seg.el.appendTo(containerEl);
                }
                if (this.elsByFill[type]) {
                    return this.elsByFill[type] = this.elsByFill[type].add(containerEl);
                } else {
                    return this.elsByFill[type] = containerEl;
                }
            }
        };

        TimelineGrid.prototype.renderDrag = function(dropLocation, seg) {
            if (seg) {
                return this.renderEventLocationHelper(dropLocation, seg);
            } else {
                this.renderHighlight(this.eventToSpan(dropLocation));
                return null;
            }
        };

        TimelineGrid.prototype.unrenderDrag = function() {
            this.unrenderHelper();
            return this.unrenderHighlight();
        };

        return TimelineGrid;

    })(Grid);

    computeOffsetForSegs = function(segs) {
        var j, len, max, seg;
        max = 0;
        for (j = 0, len = segs.length; j < len; j++) {
            seg = segs[j];
            max = Math.max(max, computeOffsetForSeg(seg));
        }
        return max;
    };

    computeOffsetForSeg = function(seg) {
        if (seg.top == null) {
            seg.top = computeOffsetForSegs(seg.above);
        }
        return seg.top + seg.height;
    };

    timeRowSegsCollide = function(seg0, seg1) {
        return seg0.left < seg1.right && seg0.right > seg1.left;
    };

    MIN_AUTO_LABELS = 18;

    MAX_AUTO_SLOTS_PER_LABEL = 6;

    MAX_AUTO_CELLS = 200;

    MAX_CELLS = 1000;

    DEFAULT_GRID_DURATION = {
        months: 1
    };

    STOCK_SUB_DURATIONS = [
        {
            years: 1
        }, {
            months: 1
        }, {
            days: 1
        }, {
            hours: 1
        }, {
            minutes: 30
        }, {
            minutes: 15
        }, {
            minutes: 10
        }, {
            minutes: 5
        }, {
            minutes: 1
        }, {
            seconds: 30
        }, {
            seconds: 15
        }, {
            seconds: 10
        }, {
            seconds: 5
        }, {
            seconds: 1
        }, {
            milliseconds: 500
        }, {
            milliseconds: 100
        }, {
            milliseconds: 10
        }, {
            milliseconds: 1
        }
    ];

    TimelineGrid.prototype.initScaleProps = function() {
        var input, slotUnit, type;
        this.labelInterval = this.queryDurationOption('slotLabelInterval');
        this.slotDuration = this.queryDurationOption('slotDuration');
        this.ensureGridDuration();
        this.validateLabelAndSlot();
        this.ensureLabelInterval();
        this.ensureSlotDuration();
        input = this.opt('slotLabelFormat');
        type = $.type(input);
        this.headerFormats = type === 'array' ? input : type === 'string' ? [input] : this.computeHeaderFormats();
        this.isTimeScale = durationHasTime(this.slotDuration);
        this.largeUnit = !this.isTimeScale ? (slotUnit = computeIntervalUnit(this.slotDuration), /year|month|week/.test(slotUnit) ? slotUnit : void 0) : void 0;
        return this.emphasizeWeeks = this.slotDuration.as('days') === 1 && this.duration.as('weeks') >= 2 && !this.opt('businessHours');

        /*
         console.log('view duration =', @duration.humanize())
         console.log('label interval =', @labelInterval.humanize())
         console.log('slot duration =', @slotDuration.humanize())
         console.log('header formats =', @headerFormats)
         console.log('isTimeScale', @isTimeScale)
         console.log('largeUnit', @largeUnit)
         */
    };

    TimelineGrid.prototype.queryDurationOption = function(name) {
        var dur, input;
        input = this.opt(name);
        if (input != null) {
            dur = moment.duration(input);
            if (+dur) {
                return dur;
            }
        }
    };

    TimelineGrid.prototype.validateLabelAndSlot = function() {
        var labelCnt, slotCnt, slotsPerLabel;
        if (this.labelInterval) {
            labelCnt = divideDurationByDuration(this.duration, this.labelInterval);
            if (labelCnt > MAX_CELLS) {
                FC.warn('slotLabelInterval results in too many cells');
                this.labelInterval = null;
            }
        }
        if (this.slotDuration) {
            slotCnt = divideDurationByDuration(this.duration, this.slotDuration);
            if (slotCnt > MAX_CELLS) {
                FC.warn('slotDuration results in too many cells');
                this.slotDuration = null;
            }
        }
        if (this.labelInterval && this.slotDuration) {
            slotsPerLabel = divideDurationByDuration(this.labelInterval, this.slotDuration);
            if (!isInt(slotsPerLabel) || slotsPerLabel < 1) {
                FC.warn('slotLabelInterval must be a multiple of slotDuration');
                return this.slotDuration = null;
            }
        }
    };

    TimelineGrid.prototype.ensureGridDuration = function() {
        var gridDuration, input, j, labelCnt, labelInterval;
        gridDuration = this.duration;
        if (!gridDuration) {
            gridDuration = this.view.intervalDuration;
            if (!gridDuration) {
                if (!this.labelInterval && !this.slotDuration) {
                    gridDuration = moment.duration(DEFAULT_GRID_DURATION);
                } else {
                    labelInterval = this.ensureLabelInterval();
                    for (j = STOCK_SUB_DURATIONS.length - 1; j >= 0; j += -1) {
                        input = STOCK_SUB_DURATIONS[j];
                        gridDuration = moment.duration(input);
                        labelCnt = divideDurationByDuration(gridDuration, labelInterval);
                        if (labelCnt >= MIN_AUTO_LABELS) {
                            break;
                        }
                    }
                }
            }
            this.duration = gridDuration;
        }
        return gridDuration;
    };

    TimelineGrid.prototype.ensureLabelInterval = function() {
        var input, j, k, labelCnt, labelInterval, len, len1, slotsPerLabel, tryLabelInterval;
        labelInterval = this.labelInterval;
        if (!labelInterval) {
            if (!this.duration && !this.slotDuration) {
                this.ensureGridDuration();
            }
            if (this.slotDuration) {
                for (j = 0, len = STOCK_SUB_DURATIONS.length; j < len; j++) {
                    input = STOCK_SUB_DURATIONS[j];
                    tryLabelInterval = moment.duration(input);
                    slotsPerLabel = divideDurationByDuration(tryLabelInterval, this.slotDuration);
                    if (isInt(slotsPerLabel) && slotsPerLabel <= MAX_AUTO_SLOTS_PER_LABEL) {
                        labelInterval = tryLabelInterval;
                        break;
                    }
                }
                if (!labelInterval) {
                    labelInterval = this.slotDuration;
                }
            } else {
                for (k = 0, len1 = STOCK_SUB_DURATIONS.length; k < len1; k++) {
                    input = STOCK_SUB_DURATIONS[k];
                    labelInterval = moment.duration(input);
                    labelCnt = divideDurationByDuration(this.duration, labelInterval);
                    if (labelCnt >= MIN_AUTO_LABELS) {
                        break;
                    }
                }
            }
            this.labelInterval = labelInterval;
        }
        return labelInterval;
    };

    TimelineGrid.prototype.ensureSlotDuration = function() {
        var input, j, labelInterval, len, slotCnt, slotDuration, slotsPerLabel, trySlotDuration;
        slotDuration = this.slotDuration;
        if (!slotDuration) {
            labelInterval = this.ensureLabelInterval();
            for (j = 0, len = STOCK_SUB_DURATIONS.length; j < len; j++) {
                input = STOCK_SUB_DURATIONS[j];
                trySlotDuration = moment.duration(input);
                slotsPerLabel = divideDurationByDuration(labelInterval, trySlotDuration);
                if (isInt(slotsPerLabel) && slotsPerLabel > 1 && slotsPerLabel <= MAX_AUTO_SLOTS_PER_LABEL) {
                    slotDuration = trySlotDuration;
                    break;
                }
            }
            if (slotDuration && this.duration) {
                slotCnt = divideDurationByDuration(this.duration, slotDuration);
                if (slotCnt > MAX_AUTO_CELLS) {
                    slotDuration = null;
                }
            }
            if (!slotDuration) {
                slotDuration = labelInterval;
            }
            this.slotDuration = slotDuration;
        }
        return slotDuration;
    };

    TimelineGrid.prototype.computeHeaderFormats = function() {
        var format0, format1, format2, gridDuration, labelInterval, unit, view, weekNumbersVisible;
        view = this.view;
        gridDuration = this.duration;
        labelInterval = this.labelInterval;
        unit = computeIntervalUnit(labelInterval);
        weekNumbersVisible = this.opt('weekNumbers');
        unit = this.opt('timesteps');
        format0 = format1 = format2 = null;
        // if (unit === 'week' && !weekNumbersVisible) {
        //     unit = 'day';
        // }
        switch (unit) {
            case 'year':
                format0 = 'YYYY';
                break;
            case 'month':
                if (gridDuration.asYears() > 1) {
                    format0 = 'YYYY';
                }
                format1 = 'MMM';
                break;
            case 'week':
                if (gridDuration.asYears() > 1) {
                    format0 = 'YYYY';
                }
                format0 = 'Y-M MMMM';
                format2 = 'dd D';
                break;
            case 'day':
                // if (gridDuration.asYears() > 1) {
                //     format0 = this.opt('monthYearFormat');
                // } else if (gridDuration.asMonths() > 1) {
                //     format0 = 'MMMM';
                // }
                //format1 = this.opt('weekFormat');
                format1 = "W";
                format2 = 'dd';
                break;
            case 'hour':
                format1 = this.opt('dayOfMonthFormat');
                format2 = this.opt('smallTimeFormat');
                break;
            case 'minute':
                if (labelInterval.asMinutes() / 60 >= MAX_AUTO_SLOTS_PER_LABEL) {
                    format0 = this.opt('hourFormat');
                    format1 = '[:]mm';
                } else {
                    format0 = this.opt('mediumTimeFormat');
                }
                break;
            case 'second':
                if (labelInterval.asSeconds() / 60 >= MAX_AUTO_SLOTS_PER_LABEL) {
                    format0 = 'LT';
                    format1 = '[:]ss';
                } else {
                    format0 = 'LTS';
                }
                break;
            case 'millisecond':
                format0 = 'LTS';
                format1 = '[.]SSS';
        }
        return [].concat(format0 || [], format1 || [], format2 || []);
    };

    FC.views.timeline = {
        "class": TimelineView,
        defaults: {
            eventResizableFromStart: true
        }
    };

    FC.views.timelineDay = {
        type: 'timeline',
        duration: {
            days: 1
        }
    };

    FC.views.timelineWeek = {
        type: 'timeline',
        duration: {
            weeks: 1
        }
    };

    FC.views.timelineMonth = {
        type: 'timeline',
        duration: {
            months: 1
        },
    };

    FC.views.timelineYear = {
        type: 'timeline',
        duration: {
            years: 1
        }
    };

    ResourceTimelineView = (function(superClass) {
        extend(ResourceTimelineView, superClass);

        function ResourceTimelineView() {
            return ResourceTimelineView.__super__.constructor.apply(this, arguments);
        }

        ResourceTimelineView.mixin(ResourceViewMixin);

        ResourceTimelineView.prototype.resourceGrid = null;

        ResourceTimelineView.prototype.tbodyHash = null;

        ResourceTimelineView.prototype.joiner = null;

        ResourceTimelineView.prototype.dividerEls = null;

        ResourceTimelineView.prototype.superHeaderText = null;

        ResourceTimelineView.prototype.isVGrouping = null;

        ResourceTimelineView.prototype.isHGrouping = null;

        ResourceTimelineView.prototype.groupSpecs = null;

        ResourceTimelineView.prototype.colSpecs = null;

        ResourceTimelineView.prototype.orderSpecs = null;

        ResourceTimelineView.prototype.rowHierarchy = null;

        ResourceTimelineView.prototype.resourceRowHash = null;

        ResourceTimelineView.prototype.nestingCnt = 0;

        ResourceTimelineView.prototype.isNesting = null;

        ResourceTimelineView.prototype.dividerWidth = null;

        ResourceTimelineView.prototype.initialize = function() {
            ResourceTimelineView.__super__.initialize.apply(this, arguments);
            this.processResourceOptions();
            this.resourceGrid = new Spreadsheet(this);
            this.rowHierarchy = new RowParent(this);
            return this.resourceRowHash = {};
        };

        ResourceTimelineView.prototype.instantiateGrid = function() {
            return new ResourceTimelineGrid(this);
        };

        ResourceTimelineView.prototype.processResourceOptions = function() {
            var allColSpecs, allOrderSpecs, colSpec, defaultLabelText, groupColSpecs, groupSpec, groupSpecs, hGroupField, isGroup, isHGrouping, isVGrouping, j, k, l, labelText, len, len1, len2, orderSpec, plainColSpecs, plainOrderSpecs, superHeaderText;
            allColSpecs = this.opt('resourceColumns') || [];
            labelText = this.opt('resourceLabelText');
            defaultLabelText = 'Resources';
            superHeaderText = null;
            if (!allColSpecs.length) {
                allColSpecs.push({
                    labelText: labelText || defaultLabelText,
                    text: this.getResourceTextFunc()
                });
            } else {
                superHeaderText = labelText;
            }
            plainColSpecs = [];
            groupColSpecs = [];
            groupSpecs = [];
            isVGrouping = false;
            isHGrouping = false;
            for (j = 0, len = allColSpecs.length; j < len; j++) {
                colSpec = allColSpecs[j];
                if (colSpec.group) {
                    groupColSpecs.push(colSpec);
                } else {
                    plainColSpecs.push(colSpec);
                }
            }
            plainColSpecs[0].isMain = true;
            if (groupColSpecs.length) {
                groupSpecs = groupColSpecs;
                isVGrouping = true;
            } else {
                hGroupField = this.opt('resourceGroupField');
                if (hGroupField) {
                    isHGrouping = true;
                    groupSpecs.push({
                        field: hGroupField,
                        text: this.opt('resourceGroupText'),
                        render: this.opt('resourceGroupRender')
                    });
                }
            }
            allOrderSpecs = parseFieldSpecs(this.opt('resourceOrder'));
            plainOrderSpecs = [];
            for (k = 0, len1 = allOrderSpecs.length; k < len1; k++) {
                orderSpec = allOrderSpecs[k];
                isGroup = false;
                for (l = 0, len2 = groupSpecs.length; l < len2; l++) {
                    groupSpec = groupSpecs[l];
                    if (groupSpec.field === orderSpec.field) {
                        groupSpec.order = orderSpec.order;
                        isGroup = true;
                        break;
                    }
                }
                if (!isGroup) {
                    plainOrderSpecs.push(orderSpec);
                }
            }
            this.superHeaderText = superHeaderText;
            this.isVGrouping = isVGrouping;
            this.isHGrouping = isHGrouping;
            this.groupSpecs = groupSpecs;
            this.colSpecs = groupColSpecs.concat(plainColSpecs);
            return this.orderSpecs = plainOrderSpecs;
        };

        ResourceTimelineView.prototype.renderSkeleton = function() {
            ResourceTimelineView.__super__.renderSkeleton.apply(this, arguments);
            this.renderResourceGridSkeleton();
            this.tbodyHash = {
                spreadsheet: this.resourceGrid.tbodyEl,
                event: this.timeGrid.tbodyEl
            };
            this.joiner = new ScrollJoiner('vertical', [this.resourceGrid.bodyScroller, this.timeGrid.bodyScroller]);
            return this.initDividerMoving();
        };

        ResourceTimelineView.prototype.renderSkeletonHtml = function() {
            return '<table> <thead class="fc-head"> <tr> <td class="fc-resource-area ' + this.widgetHeaderClass + '"></td> <td class="fc-divider fc-col-resizer ' + this.widgetHeaderClass + '"></td> <td class="fc-time-area ' + this.widgetHeaderClass + '"></td> </tr> </thead> <tbody class="fc-body"> <tr> <td class="fc-resource-area ' + this.widgetContentClass + '"></td> <td class="fc-divider fc-col-resizer ' + this.widgetHeaderClass + '"></td> <td class="fc-time-area ' + this.widgetContentClass + '"></td> </tr> </tbody> </table>';
        };

        ResourceTimelineView.prototype.renderResourceGridSkeleton = function() {
            this.resourceGrid.el = this.el.find('tbody .fc-resource-area');
            this.resourceGrid.headEl = this.el.find('thead .fc-resource-area');
            return this.resourceGrid.renderSkeleton();
        };

        ResourceTimelineView.prototype.initDividerMoving = function() {
            var ref;
            this.dividerEls = this.el.find('.fc-divider');
            this.dividerWidth = (ref = this.opt('resourceAreaWidth')) != null ? ref : this.resourceGrid.tableWidth;
            if (this.dividerWidth != null) {
                this.positionDivider(this.dividerWidth);
            }
            return this.dividerEls.on('mousedown', (function(_this) {
                return function(ev) {
                    return _this.dividerMousedown(ev);
                };
            })(this));
        };

        ResourceTimelineView.prototype.dividerMousedown = function(ev) {
            var dragListener, isRTL, maxWidth, minWidth, origWidth;
            isRTL = this.opt('isRTL');
            minWidth = 30;
            maxWidth = this.el.width() - 30;
            origWidth = this.getNaturalDividerWidth();
            dragListener = new DragListener({
                dragStart: (function(_this) {
                    return function() {
                        return _this.dividerEls.addClass('fc-active');
                    };
                })(this),
                drag: (function(_this) {
                    return function(dx, dy) {
                        var width;
                        if (isRTL) {
                            width = origWidth - dx;
                        } else {
                            width = origWidth + dx;
                        }
                        width = Math.max(width, minWidth);
                        width = Math.min(width, maxWidth);
                        _this.dividerWidth = width;
                        _this.positionDivider(width);
                        return _this.updateWidth();
                    };
                })(this),
                dragEnd: (function(_this) {
                    return function() {
                        var tid = $(ev.currentTarget).closest(".plan-scheduler-half").attr('id');
                        var rwidth = $(ev.currentTarget).prev().width();
                        switch (tid){
                            case "mult_project":
                                $("#mult_people .fc-resource-area").css("width",rwidth);
                                break;
                            case "mult_people":
                                $("#mult_project .fc-resource-area").css("width",rwidth);
                                break;
                        }
                        return _this.dividerEls.removeClass('fc-active');
                    };
                })(this)
            });
            return dragListener.startInteraction(ev);
        };

        ResourceTimelineView.prototype.getNaturalDividerWidth = function() {
            return this.el.find('.fc-resource-area').width();
        };

        ResourceTimelineView.prototype.positionDivider = function(w) {
            return this.el.find('.fc-resource-area').width(w);
        };

        ResourceTimelineView.prototype.renderEvents = function(events) {
            this.timeGrid.renderEvents(events);
            this.syncRowHeights();
            return this.updateWidth();
        };

        ResourceTimelineView.prototype.unrenderEvents = function() {
            this.timeGrid.unrenderEvents();
            this.syncRowHeights();
            return this.updateWidth();
        };

        ResourceTimelineView.prototype.updateWidth = function() {
            ResourceTimelineView.__super__.updateWidth.apply(this, arguments);
            this.resourceGrid.updateWidth();
            this.joiner.update();
            if (this.cellFollower) {
                return this.cellFollower.update();
            }
        };

        ResourceTimelineView.prototype.updateHeight = function(isResize) {
            ResourceTimelineView.__super__.updateHeight.apply(this, arguments);
            if (isResize) {
                return this.syncRowHeights();
            }
        };

        ResourceTimelineView.prototype.setHeight = function(totalHeight, isAuto) {
            var bodyHeight, headHeight;
            headHeight = this.syncHeadHeights();
            if (isAuto) {
                bodyHeight = 'auto';
            } else {
                bodyHeight = totalHeight - headHeight - this.queryMiscHeight();
            }
            this.timeGrid.bodyScroller.setHeight(bodyHeight);
            return this.resourceGrid.bodyScroller.setHeight(bodyHeight);
        };

        ResourceTimelineView.prototype.queryMiscHeight = function() {
            return this.el.outerHeight() - Math.max(this.resourceGrid.headScroller.el.outerHeight(), this.timeGrid.headScroller.el.outerHeight()) - Math.max(this.resourceGrid.bodyScroller.el.outerHeight(), this.timeGrid.bodyScroller.el.outerHeight());
        };

        ResourceTimelineView.prototype.syncHeadHeights = function() {
            var headHeight;
            this.resourceGrid.headHeight('auto');
            this.timeGrid.headHeight('auto');
            headHeight = Math.max(this.resourceGrid.headHeight(), this.timeGrid.headHeight());
            this.resourceGrid.headHeight(headHeight);
            this.timeGrid.headHeight(headHeight);
            return headHeight;
        };

        ResourceTimelineView.prototype.scrollToResource = function(resource) {
            return this.timeGrid.scrollToResource(resource);
        };

        ResourceTimelineView.prototype.setResources = function(resources) {
            var j, len, resource;
            this.batchRows();
            for (j = 0, len = resources.length; j < len; j++) {
                resource = resources[j];
                this.insertResource(resource);
            }
            this.rowHierarchy.show();
            this.unbatchRows();
            return this.reinitializeCellFollowers();
        };

        ResourceTimelineView.prototype.unsetResources = function() {
            this.clearEvents();
            this.batchRows();
            this.rowHierarchy.removeChildren();
            this.unbatchRows();
            return this.reinitializeCellFollowers();
        };


        /*
         TODO: the scenario where there were previously unassociated events that are now
         attached to this resource. should render those events immediately.

         Responsible for rendering the new resource
         */

        ResourceTimelineView.prototype.addResource = function(resource) {
            this.insertResource(resource);
            return this.reinitializeCellFollowers();
        };

        ResourceTimelineView.prototype.removeResource = function(resource) {
            var row;
            row = this.getResourceRow(resource.id);
            if (row) {
                this.batchRows();
                row.remove();
                this.unbatchRows();
                return this.reinitializeCellFollowers();
            }
        };

        ResourceTimelineView.prototype.cellFollower = null;

        ResourceTimelineView.prototype.reinitializeCellFollowers = function() {
            var cellContent, j, len, nodes, ref, row;
            if (this.cellFollower) {
                this.cellFollower.clearSprites();
            }
            this.cellFollower = new ScrollFollower(this.resourceGrid.bodyScroller, this.calendar.isTouch);
            this.cellFollower.isHFollowing = false;
            this.cellFollower.isVFollowing = true;
            nodes = [];
            ref = this.rowHierarchy.getNodes();
            for (j = 0, len = ref.length; j < len; j++) {
                row = ref[j];
                if (row instanceof VRowGroup) {
                    if (row.groupTd) {
                        cellContent = row.groupTd.find('.fc-cell-content');
                        if (cellContent.length) {
                            nodes.push(cellContent[0]);
                        }
                    }
                }
            }
            return this.cellFollower.setSprites($(nodes));
        };

        ResourceTimelineView.prototype.insertResource = function(resource, parentResourceRow) {
            var childResource, j, len, parentId, ref, results, row;
            row = new ResourceRow(this, resource);
            if (parentResourceRow == null) {
                parentId = resource.parentId;
                if (parentId) {
                    parentResourceRow = this.getResourceRow(parentId);
                }
            }
            if (parentResourceRow) {
                this.insertRowAsChild(row, parentResourceRow);
            } else {
                this.insertRow(row);
            }
            ref = resource.children;
            results = [];
            for (j = 0, len = ref.length; j < len; j++) {
                childResource = ref[j];
                results.push(this.insertResource(childResource, row));
            }
            return results;
        };

        ResourceTimelineView.prototype.insertRow = function(row, parent, groupSpecs) {
            var group;
            if (parent == null) {
                parent = this.rowHierarchy;
            }
            if (groupSpecs == null) {
                groupSpecs = this.groupSpecs;
            }
            if (groupSpecs.length) {
                group = this.ensureResourceGroup(row, parent, groupSpecs[0]);
                if (group instanceof HRowGroup) {
                    return this.insertRowAsChild(row, group);
                } else {
                    return this.insertRow(row, group, groupSpecs.slice(1));
                }
            } else {
                return this.insertRowAsChild(row, parent);
            }
        };

        ResourceTimelineView.prototype.insertRowAsChild = function(row, parent) {
            return parent.addChild(row, this.computeChildRowPosition(row, parent));
        };

        ResourceTimelineView.prototype.computeChildRowPosition = function(child, parent) {
            var cmp, i, j, len, ref, sibling;
            if (this.orderSpecs.length) {
                ref = parent.children;
                for (i = j = 0, len = ref.length; j < len; i = ++j) {
                    sibling = ref[i];
                    cmp = this.compareResources(sibling.resource || {}, child.resource || {});
                    if (cmp > 0) {
                        return i;
                    }
                }
            }
            return null;
        };

        ResourceTimelineView.prototype.compareResources = function(a, b) {
            return compareByFieldSpecs(a, b, this.orderSpecs);
        };

        ResourceTimelineView.prototype.ensureResourceGroup = function(row, parent, spec) {
            var cmp, group, groupValue, i, j, k, len, len1, ref, ref1, testGroup;
            groupValue = (row.resource || {})[spec.field];
            group = null;
            if (spec.order) {
                ref = parent.children;
                for (i = j = 0, len = ref.length; j < len; i = ++j) {
                    testGroup = ref[i];
                    cmp = flexibleCompare(testGroup.groupValue, groupValue) * spec.order;
                    if (cmp === 0) {
                        group = testGroup;
                        break;
                    } else if (cmp > 0) {
                        break;
                    }
                }
            } else {
                ref1 = parent.children;
                for (i = k = 0, len1 = ref1.length; k < len1; i = ++k) {
                    testGroup = ref1[i];
                    if (testGroup.groupValue === groupValue) {
                        group = testGroup;
                        break;
                    }
                }
            }
            if (!group) {
                if (this.isVGrouping) {
                    group = new VRowGroup(this, spec, groupValue);
                } else {
                    group = new HRowGroup(this, spec, groupValue);
                }
                parent.addChild(group, i);
            }
            return group;
        };

        ResourceTimelineView.prototype.pairSegsWithRows = function(segs) {
            var j, len, pair, pairs, pairsById, resourceId, rowObj, seg;
            pairs = [];
            pairsById = {};
            for (j = 0, len = segs.length; j < len; j++) {
                seg = segs[j];
                resourceId = seg.resourceId;
                if (resourceId) {
                    rowObj = this.getResourceRow(resourceId);
                    if (rowObj) {
                        pair = pairsById[resourceId];
                        if (!pair) {
                            pair = [rowObj, []];
                            pairs.push(pair);
                            pairsById[resourceId] = pair;
                        }
                        pair[1].push(seg);
                    }
                }
            }
            return pairs;
        };

        ResourceTimelineView.prototype.rowAdded = function(row) {
            var isNesting, wasNesting;
            if (row instanceof ResourceRow) {
                this.resourceRowHash[row.resource.id] = row;
                this.timeGrid.assignRowBusinessHourSegs(row);
            }
            wasNesting = this.isNesting;
            isNesting = Boolean(this.nestingCnt += row.depth ? 1 : 0);
            if (wasNesting !== isNesting) {
                this.el.toggleClass('fc-nested', isNesting);
                this.el.toggleClass('fc-flat', !isNesting);
            }
            return this.isNesting = isNesting;
        };

        ResourceTimelineView.prototype.rowRemoved = function(row) {
            var isNesting, wasNesting;
            if (row instanceof ResourceRow) {
                delete this.resourceRowHash[row.resource.id];
                this.timeGrid.destroyRowBusinessHourSegs(row);
            }
            wasNesting = this.isNesting;
            isNesting = Boolean(this.nestingCnt -= row.depth ? 1 : 0);
            if (wasNesting !== isNesting) {
                this.el.toggleClass('fc-nested', isNesting);
                this.el.toggleClass('fc-flat', !isNesting);
            }
            return this.isNesting = isNesting;
        };

        ResourceTimelineView.prototype.batchRowDepth = 0;

        ResourceTimelineView.prototype.shownRowBatch = null;

        ResourceTimelineView.prototype.hiddenRowBatch = null;

        ResourceTimelineView.prototype.batchRows = function() {
            if (!(this.batchRowDepth++)) {
                this.shownRowBatch = [];
                return this.hiddenRowBatch = [];
            }
        };

        ResourceTimelineView.prototype.unbatchRows = function() {
            if (!(--this.batchRowDepth)) {
                if (this.hiddenRowBatch.length) {
                    this.rowsHidden(this.hiddenRowBatch);
                }
                if (this.shownRowBatch.length) {
                    this.rowsShown(this.shownRowBatch);
                }
                this.hiddenRowBatch = null;
                return this.shownRowBatch = null;
            }
        };

        ResourceTimelineView.prototype.rowShown = function(row) {
            if (this.shownRowBatch) {
                return this.shownRowBatch.push(row);
            } else {
                return this.rowsShown([row]);
            }
        };

        ResourceTimelineView.prototype.rowHidden = function(row) {
            if (this.hiddenRowBatch) {
                return this.hiddenRowBatch.push(row);
            } else {
                return this.rowsHidden([row]);
            }
        };

        ResourceTimelineView.prototype.rowsShown = function(rows) {
            this.syncRowHeights(rows);
            return this.updateWidth();
        };

        ResourceTimelineView.prototype.rowsHidden = function(rows) {
            return this.updateWidth();
        };

        ResourceTimelineView.prototype.syncRowHeights = function(visibleRows, safe) {
            var h, h1, h2, i, innerHeights, j, k, len, len1, row;
            if (safe == null) {
                safe = false;
            }
            if (visibleRows == null) {
                visibleRows = this.getVisibleRows();
            }
            for (j = 0, len = visibleRows.length; j < len; j++) {
                row = visibleRows[j];
                row.setTrInnerHeight('');
            }
            innerHeights = (function() {
                var k, len1, results;
                results = [];
                for (k = 0, len1 = visibleRows.length; k < len1; k++) {
                    row = visibleRows[k];
                    h = row.getMaxTrInnerHeight();
                    if (safe) {
                        h += h % 2;
                    }
                    results.push(h);
                }
                return results;
            })();
            for (i = k = 0, len1 = visibleRows.length; k < len1; i = ++k) {
                row = visibleRows[i];
                row.setTrInnerHeight(innerHeights[i]);
            }
            if (!safe) {
                h1 = this.resourceGrid.tbodyEl.height();
                h2 = this.timeGrid.tbodyEl.height();
                if (Math.abs(h1 - h2) > 1) {
                    return this.syncRowHeights(visibleRows, true);
                }
            }
        };

        ResourceTimelineView.prototype.getVisibleRows = function() {
            var j, len, ref, results, row;
            ref = this.rowHierarchy.getRows();
            results = [];
            for (j = 0, len = ref.length; j < len; j++) {
                row = ref[j];
                if (row.isShown) {
                    results.push(row);
                }
            }
            return results;
        };

        ResourceTimelineView.prototype.getEventRows = function() {
            var j, len, ref, results, row;
            ref = this.rowHierarchy.getRows();
            results = [];
            for (j = 0, len = ref.length; j < len; j++) {
                row = ref[j];
                if (row instanceof EventRow) {
                    results.push(row);
                }
            }
            return results;
        };

        ResourceTimelineView.prototype.getResourceRow = function(resourceId) {
            return this.resourceRowHash[resourceId];
        };

        ResourceTimelineView.prototype.setScroll = function(state) {
            ResourceTimelineView.__super__.setScroll.apply(this, arguments);
            return this.resourceGrid.bodyScroller.setScrollTop(state.top);
        };

        return ResourceTimelineView;

    })(TimelineView);

    ResourceTimelineGrid = (function(superClass) {
        extend(ResourceTimelineGrid, superClass);

        function ResourceTimelineGrid() {
            return ResourceTimelineGrid.__super__.constructor.apply(this, arguments);
        }

        ResourceTimelineGrid.mixin(ResourceGridMixin);

        ResourceTimelineGrid.prototype.eventRows = null;

        ResourceTimelineGrid.prototype.shownEventRows = null;

        ResourceTimelineGrid.prototype.tbodyEl = null;

        ResourceTimelineGrid.prototype.rowCoordCache = null;

        ResourceTimelineGrid.prototype.spanToSegs = function(span) {
            var calendar, j, len, resourceId, seg, segs;
            segs = ResourceTimelineGrid.__super__.spanToSegs.apply(this, arguments);
            calendar = this.view.calendar;
            resourceId = span.resourceId;
            if (resourceId) {
                for (j = 0, len = segs.length; j < len; j++) {
                    seg = segs[j];
                    seg.resource = calendar.getResourceById(resourceId);
                    seg.resourceId = resourceId;
                }
            }
            return segs;
        };

        ResourceTimelineGrid.prototype.prepareHits = function() {
            var row, trArray;
            ResourceTimelineGrid.__super__.prepareHits.apply(this, arguments);
            this.eventRows = this.view.getEventRows();
            this.shownEventRows = (function() {
                var j, len, ref, results;
                ref = this.eventRows;
                results = [];
                for (j = 0, len = ref.length; j < len; j++) {
                    row = ref[j];
                    if (row.isShown) {
                        results.push(row);
                    }
                }
                return results;
            }).call(this);
            trArray = (function() {
                var j, len, ref, results;
                ref = this.shownEventRows;
                results = [];
                for (j = 0, len = ref.length; j < len; j++) {
                    row = ref[j];
                    results.push(row.getTr('event')[0]);
                }
                return results;
            }).call(this);
            this.rowCoordCache = new CoordCache({
                els: trArray,
                isVertical: true
            });
            return this.rowCoordCache.build();
        };

        ResourceTimelineGrid.prototype.releaseHits = function() {
            ResourceTimelineGrid.__super__.releaseHits.apply(this, arguments);
            this.eventRows = null;
            this.shownEventRows = null;
            return this.rowCoordCache.clear();
        };

        ResourceTimelineGrid.prototype.queryHit = function(leftOffset, topOffset) {
            var rowIndex, simpleHit;
            simpleHit = ResourceTimelineGrid.__super__.queryHit.apply(this, arguments);
            if (simpleHit) {
                rowIndex = this.rowCoordCache.getVerticalIndex(topOffset);
                if (rowIndex != null) {
                    return {
                        resourceId: this.shownEventRows[rowIndex].resource.id,
                        snap: simpleHit.snap,
                        component: this,
                        left: simpleHit.left,
                        right: simpleHit.right,
                        top: this.rowCoordCache.getTopOffset(rowIndex),
                        bottom: this.rowCoordCache.getBottomOffset(rowIndex)
                    };
                }
            }
        };

        ResourceTimelineGrid.prototype.getHitSpan = function(hit) {
            var span;
            span = this.getSnapRange(hit.snap);
            span.resourceId = hit.resourceId;
            return span;
        };

        ResourceTimelineGrid.prototype.getHitEl = function(hit) {
            return this.getSnapEl(hit.snap);
        };

        ResourceTimelineGrid.prototype.renderSkeleton = function() {
            var rowContainerEl;
            ResourceTimelineGrid.__super__.renderSkeleton.apply(this, arguments);
            this.segContainerEl.remove();
            this.segContainerEl = null;
            rowContainerEl = $('<div class="fc-rows"><table><tbody/></table></div>').appendTo(this.bodyScroller.canvas.contentEl);
            return this.tbodyEl = rowContainerEl.find('tbody');
        };

        ResourceTimelineGrid.prototype.renderFgSegs = function(segs) {
            var containerObj, containerSegs, j, len, pair, pairs, visiblePairs;
            segs = this.renderFgSegEls(segs);
            pairs = this.view.pairSegsWithRows(segs);
            visiblePairs = [];
            for (j = 0, len = pairs.length; j < len; j++) {
                pair = pairs[j];
                containerObj = pair[0], containerSegs = pair[1];
                containerObj.fgSegs = containerSegs;
                if (containerObj.isShown) {
                    containerObj.isSegsRendered = true;
                    visiblePairs.push(pair);
                }
            }
            this.renderFgSegsInContainers(visiblePairs);
            this.updateSegFollowers(segs);
            return segs;
        };

        ResourceTimelineGrid.prototype.unrenderFgSegs = function() {
            var eventRow, eventRows, j, len;
            this.clearSegFollowers();
            eventRows = this.view.getEventRows();
            for (j = 0, len = eventRows.length; j < len; j++) {
                eventRow = eventRows[j];
                eventRow.fgSegs = null;
                eventRow.isSegsRendered = false;
            }
            return this.unrenderFgContainers(eventRows);
        };

        ResourceTimelineGrid.prototype.rowCntWithCustomBusinessHours = 0;

        ResourceTimelineGrid.prototype.renderBusinessHours = function() {
            if (this.rowCntWithCustomBusinessHours) {
                return this.ensureIndividualBusinessHours();
            } else {
                return ResourceTimelineGrid.__super__.renderBusinessHours.apply(this, arguments);
            }
        };

        ResourceTimelineGrid.prototype.unrenderBusinessHours = function() {
            if (this.rowCntWithCustomBusinessHours) {
                return this.clearIndividualBusinessHours();
            } else {
                return ResourceTimelineGrid.__super__.unrenderBusinessHours.apply(this, arguments);
            }
        };


        /*
         Ensures that all rows have their individual business hours DISPLAYED.
         */

        ResourceTimelineGrid.prototype.ensureIndividualBusinessHours = function() {
            var j, len, ref, results, row;
            ref = this.view.getEventRows();
            results = [];
            for (j = 0, len = ref.length; j < len; j++) {
                row = ref[j];
                if (!row.businessHourSegs) {
                    this.populateRowBusinessHoursSegs(row);
                }
                if (row.isShown) {
                    results.push(row.ensureBusinessHourSegsRendered());
                } else {
                    results.push(void 0);
                }
            }
            return results;
        };


        /*
         Ensures that all rows have their individual business hours CLEARED.
         */

        ResourceTimelineGrid.prototype.clearIndividualBusinessHours = function() {
            var j, len, ref, results, row;
            ref = this.view.getEventRows();
            results = [];
            for (j = 0, len = ref.length; j < len; j++) {
                row = ref[j];
                results.push(row.clearBusinessHourSegs());
            }
            return results;
        };


        /*
         Called when a row has been added to the tree data structure, but before it's rendered.
         Computes and assigns business hour data *if necessary*. To be rendered soon after.
         */

        ResourceTimelineGrid.prototype.assignRowBusinessHourSegs = function(row) {
            if (row.resource.businessHours) {
                if (!this.rowCntWithCustomBusinessHours) {
                    TimelineGrid.prototype.unrenderBusinessHours.call(this);
                    this.ensureIndividualBusinessHours();
                }
                this.rowCntWithCustomBusinessHours += 1;
            }
            if (this.rowCntWithCustomBusinessHours) {
                return this.populateRowBusinessHoursSegs(row);
            }
        };


        /*
         Called when a row has been removed from the tree data structure.
         Unrenders the row's segs and, if necessary, forces businessHours back to generic rendering.
         */

        ResourceTimelineGrid.prototype.destroyRowBusinessHourSegs = function(row) {
            row.clearBusinessHourSegs();
            if (row.resource.businessHours) {
                this.rowCntWithCustomBusinessHours -= 1;
                if (!this.rowCntWithCustomBusinessHours) {
                    this.clearIndividualBusinessHours();
                    return TimelineGrid.prototype.renderBusinessHours.call(this);
                }
            }
        };


        /*
         Compute and assign to row.businessHourSegs unconditionally
         */

        ResourceTimelineGrid.prototype.populateRowBusinessHoursSegs = function(row) {
            var businessHourSegs, businessHours, businessHoursEvents;
            businessHours = row.resource.businessHours || this.view.opt('businessHours');
            businessHoursEvents = this.view.calendar.computeBusinessHourEvents(!this.isTimeScale, businessHours);
            businessHourSegs = this.eventsToSegs(businessHoursEvents);
            businessHourSegs = this.renderFillSegEls('businessHours', businessHourSegs);
            row.businessHourSegs = businessHourSegs;
        };

        ResourceTimelineGrid.prototype.renderFill = function(type, segs, className) {
            var j, k, len, len1, nonResourceSegs, pair, pairs, resourceSegs, rowObj, rowSegs, seg, visiblePairs;
            segs = this.renderFillSegEls(type, segs);
            resourceSegs = [];
            nonResourceSegs = [];
            for (j = 0, len = segs.length; j < len; j++) {
                seg = segs[j];
                if (seg.resourceId) {
                    resourceSegs.push(seg);
                } else {
                    nonResourceSegs.push(seg);
                }
            }
            pairs = this.view.pairSegsWithRows(resourceSegs);
            visiblePairs = [];
            for (k = 0, len1 = pairs.length; k < len1; k++) {
                pair = pairs[k];
                rowObj = pair[0];
                rowSegs = pair[1];
                if (type === 'bgEvent') {
                    rowObj.bgSegs = rowSegs;
                }
                if (rowObj.isShown) {
                    visiblePairs.push(pair);
                }
            }
            if (nonResourceSegs.length) {
                visiblePairs.unshift([this, nonResourceSegs]);
            }
            this.renderFillInContainers(type, visiblePairs, className);
            return segs;
        };

        ResourceTimelineGrid.prototype.renderHelper = function(event, sourceSeg) {
            var pairs, segs;
            segs = this.eventToSegs(event);
            segs = this.renderFgSegEls(segs);
            pairs = this.view.pairSegsWithRows(segs);
            return this.renderHelperSegsInContainers(pairs, sourceSeg);
        };

        ResourceTimelineGrid.prototype.computeInitialScroll = function(prevState) {
            var state;
            state = ResourceTimelineGrid.__super__.computeInitialScroll.apply(this, arguments);
            if (prevState) {
                state.resourceId = prevState.resourceId;
                state.bottom = prevState.bottom;
            }
            return state;
        };

        ResourceTimelineGrid.prototype.queryScroll = function() {
            var el, elBottom, j, len, ref, rowObj, scrollerTop, state;
            state = ResourceTimelineGrid.__super__.queryScroll.apply(this, arguments);
            scrollerTop = this.bodyScroller.scrollEl.offset().top;
            ref = this.view.getVisibleRows();
            for (j = 0, len = ref.length; j < len; j++) {
                rowObj = ref[j];
                if (rowObj.resource) {
                    el = rowObj.getTr('event');
                    elBottom = el.offset().top + el.outerHeight();
                    if (elBottom > scrollerTop) {
                        state.resourceId = rowObj.resource.id;
                        state.bottom = elBottom - scrollerTop;
                        break;
                    }
                }
            }
            return state;
        };

        ResourceTimelineGrid.prototype.setScroll = function(state) {
            var el, elBottom, innerTop, row;
            if (state.resourceId) {
                row = this.view.getResourceRow(state.resourceId);
                if (row) {
                    el = row.getTr('event');
                    if (el) {
                        innerTop = this.bodyScroller.canvas.el.offset().top;
                        elBottom = el.offset().top + el.outerHeight();
                        state.top = elBottom - state.bottom - innerTop;
                    }
                }
            }
            return ResourceTimelineGrid.__super__.setScroll.call(this, state);
        };

        ResourceTimelineGrid.prototype.scrollToResource = function(resource) {
            var el, innerTop, row, scrollTop;
            row = this.view.getResourceRow(resource.id);
            if (row) {
                el = row.getTr('event');
                if (el) {
                    innerTop = this.bodyScroller.canvas.el.offset().top;
                    scrollTop = el.offset().top - innerTop;
                    return this.bodyScroller.scrollEl.scrollTop(scrollTop);
                }
            }
        };

        return ResourceTimelineGrid;

    })(TimelineGrid);

    COL_MIN_WIDTH = 30;

    Spreadsheet = (function() {
        Spreadsheet.prototype.view = null;

        Spreadsheet.prototype.headEl = null;

        Spreadsheet.prototype.el = null;

        Spreadsheet.prototype.tbodyEl = null;

        Spreadsheet.prototype.headScroller = null;

        Spreadsheet.prototype.bodyScroller = null;

        Spreadsheet.prototype.joiner = null;

        function Spreadsheet(view1) {
            var colSpec;
            this.view = view1;
            this.isRTL = this.view.opt('isRTL');
            this.givenColWidths = this.colWidths = (function() {
                var j, len, ref, results;
                ref = this.view.colSpecs;
                results = [];
                for (j = 0, len = ref.length; j < len; j++) {
                    colSpec = ref[j];
                    results.push(colSpec.width);
                }
                return results;
            }).call(this);
        }

        Spreadsheet.prototype.colGroupHtml = '';

        Spreadsheet.prototype.headTable = null;

        Spreadsheet.prototype.headColEls = null;

        Spreadsheet.prototype.headCellEls = null;

        Spreadsheet.prototype.bodyColEls = null;

        Spreadsheet.prototype.bodyTable = null;

        Spreadsheet.prototype.renderSkeleton = function() {
            this.headScroller = new ClippedScroller({
                overflowX: 'clipped-scroll',
                overflowY: 'hidden'
            });
            this.headScroller.canvas = new ScrollerCanvas();
            this.headScroller.render();
            this.headScroller.canvas.contentEl.html(this.renderHeadHtml());
            this.headEl.append(this.headScroller.el);
            this.bodyScroller = new ClippedScroller({
                overflowY: 'clipped-scroll'
            });
            this.bodyScroller.canvas = new ScrollerCanvas();
            this.bodyScroller.render();
            this.bodyScroller.canvas.contentEl.html('<table>' + this.colGroupHtml + '<tbody/></table>');
            this.tbodyEl = this.bodyScroller.canvas.contentEl.find('tbody');
            this.el.append(this.bodyScroller.el);
            this.joiner = new ScrollJoiner('horizontal', [this.headScroller, this.bodyScroller]);
            this.headTable = this.headEl.find('table');
            this.headColEls = this.headEl.find('col');
            this.headCellEls = this.headScroller.canvas.contentEl.find('tr:last-child th');
            this.bodyColEls = this.el.find('col');
            this.bodyTable = this.el.find('table');
            this.colMinWidths = this.computeColMinWidths();
            this.applyColWidths();
            return this.initColResizing();
        };

        Spreadsheet.prototype.renderHeadHtml = function() {
            var colGroupHtml, colSpecs, html, i, isLast, isMainCol, j, k, len, len1, o;
            colSpecs = this.view.colSpecs;
            html = '<table>';
            colGroupHtml = '<colgroup>';
            for (j = 0, len = colSpecs.length; j < len; j++) {
                o = colSpecs[j];
                if (o.isMain) {
                    colGroupHtml += '<col class="fc-main-col"/>';
                } else {
                    colGroupHtml += '<col/>';
                }
            }
            colGroupHtml += '</colgroup>';
            this.colGroupHtml = colGroupHtml;
            html += colGroupHtml;
            html += '<tbody>';
            if (this.view.superHeaderText) {
                html += '<tr class="fc-super">' + '<th class="' + this.view.widgetHeaderClass + '" colspan="' + colSpecs.length + '">' + '<div class="fc-cell-content">' + '<span class="fc-cell-text">' + htmlEscape(this.view.superHeaderText) + '</span>' + '</div>' + '</th>' + '</tr>';
            }
            html += '<tr>';
            isMainCol = true;
            for (i = k = 0, len1 = colSpecs.length; k < len1; i = ++k) {
                o = colSpecs[i];
                isLast = i === colSpecs.length - 1;
                html += '<th class="' + this.view.widgetHeaderClass + '">' + '<div>' + '<div class="fc-cell-content">' + (o.isMain ? '<span class="fc-expander-space">' + '<span class="fc-icon"></span>' + '</span>' : '') + '<span class="fc-cell-text">' + htmlEscape(o.labelText || '') + '</span>' + '</div>' + (!isLast ? '<div class="fc-col-resizer"></div>' : '') + '</div>' + '</th>';
            }
            html += '</tr>';
            html += '</tbody></table>';
            return html;
        };

        Spreadsheet.prototype.givenColWidths = null;

        Spreadsheet.prototype.colWidths = null;

        Spreadsheet.prototype.colMinWidths = null;

        Spreadsheet.prototype.tableWidth = null;

        Spreadsheet.prototype.tableMinWidth = null;

        Spreadsheet.prototype.initColResizing = function() {
            return this.headEl.find('th .fc-col-resizer').each((function(_this) {
                return function(i, resizerEl) {
                    resizerEl = $(resizerEl);
                    return resizerEl.on('mousedown', function(ev) {
                        return _this.colResizeMousedown(i, ev, resizerEl);
                    });
                };
            })(this));
        };

        Spreadsheet.prototype.colResizeMousedown = function(i, ev, resizerEl) {
            var colWidths, dragListener, minWidth, origColWidth;
            colWidths = this.colWidths = this.queryColWidths();
            colWidths.pop();
            colWidths.push(null);
            origColWidth = colWidths[i];
            minWidth = Math.min(this.colMinWidths[i], COL_MIN_WIDTH);
            dragListener = new DragListener({
                dragStart: (function(_this) {
                    return function() {
                        return resizerEl.addClass('fc-active');
                    };
                })(this),
                drag: (function(_this) {
                    return function(dx, dy) {
                        var width;
                        width = origColWidth + (_this.isRTL ? -dx : dx);
                        width = Math.max(width, minWidth);
                        colWidths[i] = width;
                        return _this.applyColWidths();
                    };
                })(this),
                dragEnd: (function(_this) {
                    return function() {
                        return resizerEl.removeClass('fc-active');
                    };
                })(this)
            });
            return dragListener.startInteraction(ev);
        };

        Spreadsheet.prototype.applyColWidths = function() {
            var allNumbers, anyPercentages, colMinWidths, colWidth, colWidths, cssWidth, cssWidths, defaultCssWidth, i, j, k, l, len, len1, len2, tableMinWidth, total;
            colMinWidths = this.colMinWidths;
            colWidths = this.colWidths;
            allNumbers = true;
            anyPercentages = false;
            total = 0;
            for (j = 0, len = colWidths.length; j < len; j++) {
                colWidth = colWidths[j];
                if (typeof colWidth === 'number') {
                    total += colWidth;
                } else {
                    allNumbers = false;
                    if (colWidth) {
                        anyPercentages = true;
                    }
                }
            }
            defaultCssWidth = anyPercentages && !this.view.isHGrouping ? 'auto' : '';
            cssWidths = (function() {
                var k, len1, results;
                results = [];
                for (i = k = 0, len1 = colWidths.length; k < len1; i = ++k) {
                    colWidth = colWidths[i];
                    results.push(colWidth != null ? colWidth : defaultCssWidth);
                }
                return results;
            })();
            tableMinWidth = 0;
            for (i = k = 0, len1 = cssWidths.length; k < len1; i = ++k) {
                cssWidth = cssWidths[i];
                tableMinWidth += typeof cssWidth === 'number' ? cssWidth : colMinWidths[i];
            }
            for (i = l = 0, len2 = cssWidths.length; l < len2; i = ++l) {
                cssWidth = cssWidths[i];
                this.headColEls.eq(i).width(cssWidth);
                this.bodyColEls.eq(i).width(cssWidth);
            }
            this.headScroller.canvas.setMinWidth(tableMinWidth);
            this.bodyScroller.canvas.setMinWidth(tableMinWidth);
            this.tableMinWidth = tableMinWidth;
            return this.tableWidth = allNumbers ? total : void 0;
        };

        Spreadsheet.prototype.computeColMinWidths = function() {
            var i, j, len, ref, results, width;
            ref = this.givenColWidths;
            results = [];
            for (i = j = 0, len = ref.length; j < len; i = ++j) {
                width = ref[i];
                if (typeof width === 'number') {
                    results.push(width);
                } else {
                    results.push(parseInt(this.headColEls.eq(i).css('min-width')) || COL_MIN_WIDTH);
                }
            }
            return results;
        };

        Spreadsheet.prototype.queryColWidths = function() {
            var j, len, node, ref, results;
            ref = this.headCellEls;
            results = [];
            for (j = 0, len = ref.length; j < len; j++) {
                node = ref[j];
                results.push($(node).outerWidth());
            }
            return results;
        };

        Spreadsheet.prototype.updateWidth = function() {
            this.headScroller.updateSize();
            this.bodyScroller.updateSize();
            this.joiner.update();
            if (this.follower) {
                return this.follower.update();
            }
        };

        Spreadsheet.prototype.headHeight = function() {
            var table;
            table = this.headScroller.canvas.contentEl.find('table');
            return table.height.apply(table, arguments);
        };

        return Spreadsheet;

    })();


    /*
     An abstract node in a row-hierarchy tree.
     May be a self-contained single row, a row with subrows,
     OR a grouping of rows without its own distinct row.
     */

    RowParent = (function() {
        RowParent.prototype.view = null;

        RowParent.prototype.parent = null;

        RowParent.prototype.prevSibling = null;

        RowParent.prototype.children = null;

        RowParent.prototype.depth = 0;

        RowParent.prototype.hasOwnRow = false;

        RowParent.prototype.trHash = null;

        RowParent.prototype.trs = null;

        RowParent.prototype.isRendered = false;

        RowParent.prototype.isExpanded = true;

        RowParent.prototype.isShown = false;

        function RowParent(view1) {
            this.view = view1;
            this.children = [];
            this.trHash = {};
            this.trs = $();
        }


        /*
         Adds the given node as a child.
         Will be inserted at the `index`. If not given, will be appended to the end.
         */

        RowParent.prototype.addChild = function(child, index) {
            var children, j, len, node, ref;
            child.remove();
            children = this.children;
            if (index != null) {
                children.splice(index, 0, child);
            } else {
                index = children.length;
                children.push(child);
            }
            child.prevSibling = index > 0 ? children[index - 1] : null;
            if (index < children.length - 1) {
                children[index + 1].prevSibling = child;
            }
            child.parent = this;
            child.depth = this.depth + (this.hasOwnRow ? 1 : 0);
            ref = child.getNodes();
            for (j = 0, len = ref.length; j < len; j++) {
                node = ref[j];
                node.added();
            }
            if (this.isShown && this.isExpanded) {
                return child.show();
            }
        };


        /*
         Removes the given child from the node. Assumes it is a direct child.
         If not a direct child, returns false and nothing happens.
         Unrenders the child and triggers handlers.
         */

        RowParent.prototype.removeChild = function(child) {
            var children, i, isFound, j, k, len, len1, ref, row, testChild;
            children = this.children;
            isFound = false;
            for (i = j = 0, len = children.length; j < len; i = ++j) {
                testChild = children[i];
                if (testChild === child) {
                    isFound = true;
                    break;
                }
            }
            if (!isFound) {
                return false;
            } else {
                if (i < children.length - 1) {
                    children[i + 1].prevSibling = child.prevSibling;
                }
                children.splice(i, 1);
                child.recursivelyUnrender();
                ref = child.getNodes();
                for (k = 0, len1 = ref.length; k < len1; k++) {
                    row = ref[k];
                    row.removed();
                }
                child.parent = null;
                child.prevSibling = null;
                return child;
            }
        };


        /*
         Removes all of the node's children from the hierarchy. Unrenders them and triggers callbacks.
         NOTE: batchRows/unbatchRows should probably be called before this happens :(
         */

        RowParent.prototype.removeChildren = function() {
            var child, j, k, len, len1, ref, ref1;
            ref = this.children;
            for (j = 0, len = ref.length; j < len; j++) {
                child = ref[j];
                child.recursivelyUnrender();
            }
            ref1 = this.getDescendants();
            for (k = 0, len1 = ref1.length; k < len1; k++) {
                child = ref1[k];
                child.removed();
            }
            return this.children = [];
        };


        /*
         Removes this node from its parent
         */

        RowParent.prototype.remove = function() {
            if (this.parent) {
                return this.parent.removeChild(this);
            }
        };


        /*
         Gets the last direct child node
         */

        RowParent.prototype.getLastChild = function() {
            var children;
            children = this.children;
            return children[children.length - 1];
        };


        /*
         Walks backward in the hierarchy to find the previous row leaf node.
         When looking at the hierarchy in a flat linear fashion, this is the revealed row just before the current.
         */

        RowParent.prototype.getPrevRow = function() {
            var lastChild, node;
            node = this;
            while (node) {
                if (node.prevSibling) {
                    node = node.prevSibling;
                    while ((lastChild = node.getLastChild())) {
                        node = lastChild;
                    }
                } else {
                    node = node.parent;
                }
                if (node && node.hasOwnRow && node.isShown) {
                    return node;
                }
            }
            return null;
        };


        /*
         Returns the first node in the subtree that has a revealed row
         */

        RowParent.prototype.getLeadingRow = function() {
            if (this.hasOwnRow) {
                return this;
            } else if (this.isExpanded && this.children.length) {
                return this.children[0].getLeadingRow();
            }
        };


        /*
         Generates a flat array containing all the row-nodes of the subtree. Descendants + self
         */

        RowParent.prototype.getRows = function(batchArray) {
            var child, j, len, ref;
            if (batchArray == null) {
                batchArray = [];
            }
            if (this.hasOwnRow) {
                batchArray.push(this);
            }
            ref = this.children;
            for (j = 0, len = ref.length; j < len; j++) {
                child = ref[j];
                child.getRows(batchArray);
            }
            return batchArray;
        };


        /*
         Generates a flat array containing all the nodes (row/non-row) of the subtree. Descendants + self
         */

        RowParent.prototype.getNodes = function(batchArray) {
            var child, j, len, ref;
            if (batchArray == null) {
                batchArray = [];
            }
            batchArray.push(this);
            ref = this.children;
            for (j = 0, len = ref.length; j < len; j++) {
                child = ref[j];
                child.getNodes(batchArray);
            }
            return batchArray;
        };


        /*
         Generates a flat array containing all the descendant nodes the current node
         */

        RowParent.prototype.getDescendants = function() {
            var batchArray, child, j, len, ref;
            batchArray = [];
            ref = this.children;
            for (j = 0, len = ref.length; j < len; j++) {
                child = ref[j];
                child.getNodes(batchArray);
            }
            return batchArray;
        };


        /*
         Builds and populates the TRs for each row type. Inserts them into the DOM.
         Does this only for this single row. Not recursive. If not a row (hasOwnRow=false), does not render anything.
         PRECONDITION: assumes the parent has already been rendered.
         */

        RowParent.prototype.render = function() {
            var prevRow, ref, renderMethodName, tbody, tr, trNodes, type;
            this.trHash = {};
            trNodes = [];
            if (this.hasOwnRow) {
                prevRow = this.getPrevRow();
                ref = this.view.tbodyHash;
                for (type in ref) {
                    tbody = ref[type];
                    tr = $('<tr/>');
                    this.trHash[type] = tr;
                    trNodes.push(tr[0]);
                    renderMethodName = 'render' + capitaliseFirstLetter(type) + 'Content';
                    if (this[renderMethodName]) {
                        this[renderMethodName](tr);
                    }
                    if (prevRow) {
                        prevRow.trHash[type].after(tr);
                    } else {
                        tbody.prepend(tr);
                    }
                }
            }
            this.trs = $(trNodes).on('click', '.fc-expander', proxy(this, 'toggleExpanded'));
            return this.isRendered = true;
        };


        /*
         Unpopulates and removes all of this row's TRs from the DOM. Only for this single row. Not recursive.
         Will trigger "hidden".
         */

        RowParent.prototype.unrender = function() {
            var ref, tr, type, unrenderMethodName;
            if (this.isRendered) {
                ref = this.trHash;
                for (type in ref) {
                    tr = ref[type];
                    unrenderMethodName = 'unrender' + capitaliseFirstLetter(type) + 'Content';
                    if (this[unrenderMethodName]) {
                        this[unrenderMethodName](tr);
                    }
                }
                this.trHash = {};
                this.trs.remove();
                this.trs = $();
                this.isRendered = false;
                this.isShown = false;
                return this.hidden();
            }
        };


        /*
         Like unrender(), but does it for this row AND all descendants.
         NOTE: batchRows/unbatchRows should probably be called before this happens :(
         */

        RowParent.prototype.recursivelyUnrender = function() {
            var child, j, len, ref, results;
            this.unrender();
            ref = this.children;
            results = [];
            for (j = 0, len = ref.length; j < len; j++) {
                child = ref[j];
                results.push(child.recursivelyUnrender());
            }
            return results;
        };


        /*
         A simple getter for retrieving a TR jQuery object of a certain row type
         */

        RowParent.prototype.getTr = function(type) {
            return this.trHash[type];
        };


        /*
         Renders this row if not already rendered, making sure it is visible.
         Also renders descendants of this subtree, based on whether they are expanded or not.
         NOTE: If called externally, batchRows/unbatchRows should probably be called before this happens :(
         */

        RowParent.prototype.show = function() {
            var child, j, len, ref, results;
            if (!this.isShown) {
                if (!this.isRendered) {
                    this.render();
                } else {
                    this.trs.css('display', '');
                }
                if (this.ensureSegsRendered) {
                    this.ensureSegsRendered();
                }
                if (this.isExpanded) {
                    this.indicateExpanded();
                } else {
                    this.indicateCollapsed();
                }
                this.isShown = true;
                this.shown();
                if (this.isExpanded) {
                    ref = this.children;
                    results = [];
                    for (j = 0, len = ref.length; j < len; j++) {
                        child = ref[j];
                        results.push(child.show());
                    }
                    return results;
                }
            }
        };


        /*
         Temporarily hides this node's TRs (if applicable) as well as all nodes in the subtree
         */

        RowParent.prototype.hide = function() {
            var child, j, len, ref, results;
            if (this.isShown) {
                if (this.isRendered) {
                    this.trs.hide();
                }
                this.isShown = false;
                this.hidden();
                if (this.isExpanded) {
                    ref = this.children;
                    results = [];
                    for (j = 0, len = ref.length; j < len; j++) {
                        child = ref[j];
                        results.push(child.hide());
                    }
                    return results;
                }
            }
        };


        /*
         Reveals this node's children if they have not already been revealed. Changes any expander icon.
         */

        RowParent.prototype.expand = function() {
            var child, j, len, ref;
            if (!this.isExpanded) {
                this.isExpanded = true;
                this.indicateExpanded();
                this.view.batchRows();
                ref = this.children;
                for (j = 0, len = ref.length; j < len; j++) {
                    child = ref[j];
                    child.show();
                }
                this.view.unbatchRows();
                return this.animateExpand();
            }
        };


        /*
         Hides this node's children if they are not already hidden. Changes any expander icon.
         */

        RowParent.prototype.collapse = function() {
            var child, j, len, ref;
            if (this.isExpanded) {
                this.isExpanded = false;
                this.indicateCollapsed();
                this.view.batchRows();
                ref = this.children;
                for (j = 0, len = ref.length; j < len; j++) {
                    child = ref[j];
                    child.hide();
                }
                return this.view.unbatchRows();
            }
        };


        /*
         Switches between expanded/collapsed states
         */

        RowParent.prototype.toggleExpanded = function() {
            if (this.isExpanded) {
                return this.collapse();
            } else {
                return this.expand();
            }
        };


        /*
         Changes the expander icon to the "expanded" state
         */

        RowParent.prototype.indicateExpanded = function() {
            return this.trs.find('.fc-expander .fc-icon').removeClass(this.getCollapsedIcon()).addClass(this.getExpandedIcon());
        };


        /*
         Changes the expander icon to the "collapsed" state
         */

        RowParent.prototype.indicateCollapsed = function() {
            return this.trs.find('.fc-expander .fc-icon').removeClass(this.getExpandedIcon()).addClass(this.getCollapsedIcon());
        };


        /*
         */

        RowParent.prototype.enableExpanding = function() {
            return this.trs.find('.fc-expander-space').addClass('fc-expander');
        };


        /*
         */

        RowParent.prototype.disableExpanding = function() {
            return this.trs.find('.fc-expander-space').removeClass('fc-expander').find('.fc-icon').removeClass(this.getExpandedIcon()).removeClass(this.getCollapsedIcon());
        };

        RowParent.prototype.getExpandedIcon = function() {
            return 'icon-uniF077';
        };

        RowParent.prototype.getCollapsedIcon = function() {
            var dir;
            dir = this.view.isRTL ? 'left' : 'icon-uniF078';
            return dir;
        };


        /*
         Causes a slide-down CSS transition to demonstrate that the expand has happened
         */

        RowParent.prototype.animateExpand = function() {
            var ref, ref1, trs;
            trs = (ref = this.children[0]) != null ? (ref1 = ref.getLeadingRow()) != null ? ref1.trs : void 0 : void 0;
            if (trs) {
                trs.addClass('fc-collapsed');
                setTimeout(function() {
                    trs.addClass('fc-transitioning');
                    return trs.removeClass('fc-collapsed');
                });
                return trs.one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function() {
                    return trs.removeClass('fc-transitioning');
                });
            }
        };


        /*
         Find each TRs "inner div" (div within first cell). This div controls each TRs height.
         Returns the max pixel height.
         */

        RowParent.prototype.getMaxTrInnerHeight = function() {
            var max;
            max = 0;
            $.each(this.trHash, (function(_this) {
                return function(type, tr) {
                    var innerEl,rowh;
                    innerEl = getOwnCells(tr).find('> div:not(.fc-cell-content):first');
                    rowh = innerEl.height();
                    if(tr.find(".icon-uniF077").length>0){
                        rowh = 30;
                    }
                    return max = Math.max(rowh, max);
                };
            })(this));
            return max;
        };


        /*
         Find each TRs "inner div" and sets all of their heights to the same value.
         */

        RowParent.prototype.setTrInnerHeight = function(height) {
            return $.each(this.trHash, (function(_this) {
                return function(type, tr) {
                    return getOwnCells(tr).find('> div:not(.fc-cell-content):first').height(height);
                };
            })(this));
        };


        /*
         Triggered when the current node has been shown (either freshly rendered or re-shown)
         when it had previously been unrendered or hidden. `shown` does not bubble up the hierarchy.
         */

        RowParent.prototype.shown = function() {
            if (this.hasOwnRow) {
                return this.rowShown(this);
            }
        };


        /*
         Triggered when the current node has been hidden (either temporarily or permanently)
         when it had previously been shown. `hidden` does not bubble up the hierarchy.
         */

        RowParent.prototype.hidden = function() {
            if (this.hasOwnRow) {
                return this.rowHidden(this);
            }
        };


        /*
         Just like `shown`, but only triggered for nodes that are actual rows. Bubbles up the hierarchy.
         */

        RowParent.prototype.rowShown = function(row) {
            return (this.parent || this.view).rowShown(row);
        };


        /*
         Just like `hidden`, but only triggered for nodes that are actual rows. Bubbles up the hierarchy.
         */

        RowParent.prototype.rowHidden = function(row) {
            return (this.parent || this.view).rowHidden(row);
        };


        /*
         Triggered when the current node has been added to the hierarchy. `added` does not bubble up.
         */

        RowParent.prototype.added = function() {
            if (this.hasOwnRow) {
                return this.rowAdded(this);
            }
        };


        /*
         Triggered when the current node has been removed from the hierarchy. `removed` does not bubble up.
         */

        RowParent.prototype.removed = function() {
            if (this.hasOwnRow) {
                return this.rowRemoved(this);
            }
        };


        /*
         Just like `added`, but only triggered for nodes that are actual rows. Bubbles up the hierarchy.
         */

        RowParent.prototype.rowAdded = function(row) {
            return (this.parent || this.view).rowAdded(row);
        };


        /*
         Just like `removed`, but only triggered for nodes that are actual rows. Bubbles up the hierarchy.
         */

        RowParent.prototype.rowRemoved = function(row) {
            return (this.parent || this.view).rowRemoved(row);
        };

        return RowParent;

    })();


    /*
     An abstract node in a row-hierarchy tree that contains other nodes.
     Will have some sort of rendered label indicating the grouping,
     up to the subclass for determining what to do with it.
     */

    RowGroup = (function(superClass) {
        extend(RowGroup, superClass);

        RowGroup.prototype.groupSpec = null;

        RowGroup.prototype.groupValue = null;

        function RowGroup(view, groupSpec1, groupValue1) {
            this.groupSpec = groupSpec1;
            this.groupValue = groupValue1;
            RowGroup.__super__.constructor.apply(this, arguments);
        }


        /*
         Called when this row (if it renders a row) or a subrow is removed
         */

        RowGroup.prototype.rowRemoved = function(row) {
            RowGroup.__super__.rowRemoved.apply(this, arguments);
            if (row !== this && !this.children.length) {
                return this.remove();
            }
        };


        /*
         Renders the content wrapper element that will be inserted into this row's TD cell
         */

        RowGroup.prototype.renderGroupContentEl = function() {
            var contentEl, filter;
            contentEl = $('<div class="fc-cell-content" />').append(this.renderGroupTextEl());
            filter = this.groupSpec.render;
            if (typeof filter === 'function') {
                contentEl = filter(contentEl, this.groupValue) || contentEl;
            }
            return contentEl;
        };


        /*
         Renders the text span element that will be inserted into this row's TD cell.
         Goes within the content element.
         */

        RowGroup.prototype.renderGroupTextEl = function() {
            var filter, text;
            text = this.groupValue || '';
            filter = this.groupSpec.text;
            if (typeof filter === 'function') {
                text = filter(text) || text;
            }
            return $('<span class="fc-cell-text" style="line-height: 30px"/>').text(text);
        };

        return RowGroup;

    })(RowParent);


    /*
     A row grouping that renders as a single solid row that spans width-wise (like a horizontal rule)
     */

    HRowGroup = (function(superClass) {
        extend(HRowGroup, superClass);

        function HRowGroup() {
            return HRowGroup.__super__.constructor.apply(this, arguments);
        }

        HRowGroup.prototype.hasOwnRow = true;


        /*
         Renders this row's TR for the "spreadsheet" quadrant, the area with info about each resource
         */


        HRowGroup.prototype.renderSpreadsheetContent = function(tr) {
            var contentEl;
            contentEl = this.renderGroupContentEl();
            contentEl.prepend('<span class="fc-expander">' + '<span class="fc-icon"></span>' + '</span>');
            return $('<td class="fc-divider" />').attr('colspan', this.view.colSpecs.length).append($('<div/>').append(contentEl)).appendTo(tr);
        };


        /*
         Renders this row's TR for the quadrant that contains a resource's events
         */

        HRowGroup.prototype.renderEventContent = function(tr) {
            return tr.append('<td class="fc-divider"> <div/> </td>');
        };

        return HRowGroup;

    })(RowGroup);


    /*
     A row grouping that renders as a tall multi-cell vertical span in the "spreadsheet" area
     */

    VRowGroup = (function(superClass) {
        extend(VRowGroup, superClass);

        function VRowGroup() {
            return VRowGroup.__super__.constructor.apply(this, arguments);
        }

        VRowGroup.prototype.rowspan = 0;

        VRowGroup.prototype.leadingTr = null;

        VRowGroup.prototype.groupTd = null;


        /*
         Called when a row somewhere within the grouping is shown
         */

        VRowGroup.prototype.rowShown = function(row) {
            this.rowspan += 1;
            this.renderRowspan();
            return VRowGroup.__super__.rowShown.apply(this, arguments);
        };


        /*
         Called when a row somewhere within the grouping is hidden
         */

        VRowGroup.prototype.rowHidden = function(row) {
            this.rowspan -= 1;
            this.renderRowspan();
            return VRowGroup.__super__.rowHidden.apply(this, arguments);
        };


        /*
         Makes sure the groupTd has the correct rowspan / place in the DOM.
         PRECONDITION: in the case of multiple group nesting, a child's renderRowspan()
         will be called before the parent's renderRowspan().
         */

        VRowGroup.prototype.renderRowspan = function() {
            var leadingTr;
            if (this.rowspan) {
                if (!this.groupTd) {
                    this.groupTd = $('<td class="' + this.view.widgetContentClass + '"/>').append(this.renderGroupContentEl());
                }
                this.groupTd.attr('rowspan', this.rowspan);
                leadingTr = this.getLeadingRow().getTr('spreadsheet');
                if (leadingTr !== this.leadingTr) {
                    if (leadingTr) {
                        leadingTr.prepend(this.groupTd);
                    }
                    return this.leadingTr = leadingTr;
                }
            } else {
                if (this.groupTd) {
                    this.groupTd.remove();
                    this.groupTd = null;
                }
                return this.leadingTr = null;
            }
        };

        return VRowGroup;

    })(RowGroup);

    EventRow = (function(superClass) {
        extend(EventRow, superClass);

        function EventRow() {
            return EventRow.__super__.constructor.apply(this, arguments);
        }

        EventRow.prototype.hasOwnRow = true;

        EventRow.prototype.segContainerEl = null;

        EventRow.prototype.segContainerHeight = null;

        EventRow.prototype.innerEl = null;

        EventRow.prototype.bgSegContainerEl = null;

        EventRow.prototype.isSegsRendered = false;

        EventRow.prototype.isBusinessHourSegsRendered = false;

        EventRow.prototype.businessHourSegs = null;

        EventRow.prototype.bgSegs = null;

        EventRow.prototype.fgSegs = null;

        EventRow.prototype.renderEventContent = function(tr) {
            tr.html('<td class="' + this.view.widgetContentClass + '"> <div> <div class="fc-event-container" /> </div> </td>');
            this.segContainerEl = tr.find('.fc-event-container');
            this.innerEl = this.bgSegContainerEl = tr.find('td > div');
            return this.ensureSegsRendered();
        };

        EventRow.prototype.ensureSegsRendered = function() {
            if (!this.isSegsRendered) {
                this.ensureBusinessHourSegsRendered();
                if (this.bgSegs) {
                    this.view.timeGrid.renderFillInContainer('bgEvent', this, this.bgSegs);
                }
                if (this.fgSegs) {
                    this.view.timeGrid.renderFgSegsInContainers([[this, this.fgSegs]]);
                }
                return this.isSegsRendered = true;
            }
        };

        EventRow.prototype.ensureBusinessHourSegsRendered = function() {
            if (this.businessHourSegs && !this.isBusinessHourSegsRendered) {
                this.view.timeGrid.renderFillInContainer('businessHours', this, this.businessHourSegs, 'bgevent');
                return this.isBusinessHourSegsRendered = true;
            }
        };

        EventRow.prototype.unrenderEventContent = function() {
            this.clearBusinessHourSegs();
            this.bgSegs = null;
            this.fgSegs = null;
            return this.isSegsRendered = false;
        };

        EventRow.prototype.clearBusinessHourSegs = function() {
            var j, len, ref, seg;
            if (this.businessHourSegs) {
                ref = this.businessHourSegs;
                for (j = 0, len = ref.length; j < len; j++) {
                    seg = ref[j];
                    if (seg.el) {
                        seg.el.remove();
                    }
                }
                this.businessHourSegs = null;
            }
            return this.isBusinessHourSegsRendered = false;
        };

        return EventRow;

    })(RowParent);


    /*
     A row that renders information about a particular resource, as well as it events (handled by superclass)
     */

    ResourceRow = (function(superClass) {
        extend(ResourceRow, superClass);

        ResourceRow.prototype.resource = null;

        function ResourceRow(view, resource1) {
            this.resource = resource1;
            ResourceRow.__super__.constructor.apply(this, arguments);
        }


        /*
         Called when a row in the tree has been added
         */

        ResourceRow.prototype.rowAdded = function(row) {
            ResourceRow.__super__.rowAdded.apply(this, arguments);
            if (row !== this && this.isRendered) {
                if (this.children.length === 1) {
                    this.enableExpanding();
                    if (this.isExpanded) {
                        return this.indicateExpanded();
                    } else {
                        return this.indicateCollapsed();
                    }
                }
            }
        };


        /*
         Called when a row in the tree has been removed
         */

        ResourceRow.prototype.rowRemoved = function(row) {
            ResourceRow.__super__.rowRemoved.apply(this, arguments);
            if (row !== this && this.isRendered) {
                if (!this.children.length) {
                    return this.disableExpanding();
                }
            }
        };

        ResourceRow.prototype.render = function() {
            ResourceRow.__super__.render.apply(this, arguments);
            if (this.children.length > 0) {
                this.enableExpanding();
            } else {
                this.disableExpanding();
            }
            return this.view.trigger('resourceRender', this.resource, this.resource, this.getTr('spreadsheet').find('> td'), this.getTr('event').find('> td'));
        };

        ResourceRow.prototype.renderEventContent = function(tr) {
            ResourceRow.__super__.renderEventContent.apply(this, arguments);
            return tr.attr('data-resource-id', this.resource.id);
        };


        /*
         Populates the TR with cells containing data about the resource
         */

        ResourceRow.prototype.renderSpreadsheetContent = function(tr) {
            var colSpec, contentEl, input, j, len, ref, resource, td, text;
            resource = this.resource;
            ref = this.view.colSpecs;
            for (j = 0, len = ref.length; j < len; j++) {
                colSpec = ref[j];
                if (colSpec.group) {
                    continue;
                }
                input = colSpec.field ? resource[colSpec.field] || null : resource;
                text = typeof colSpec.text === 'function' ? colSpec.text(resource, input) : input;
                //console.log((text ? htmlEscape(text) : '&nbsp;'));
                contentEl = $('<div class="fc-cell-content">' + (colSpec.isMain ? this.renderGutterHtml() : '') + '<span class="fc-cell-text">' + (text ? text : '&nbsp;') + '</span>' + '</div>');
                if (typeof colSpec.render === 'function') {
                    contentEl = colSpec.render(resource, contentEl, input) || contentEl;
                }
                td = $('<td class="' + this.view.widgetContentClass + '"/>').append(contentEl);
                if (colSpec.isMain) {
                    td.wrapInner('<div/>');
                }
                tr.append(td);
            }
            return tr.attr('data-resource-id', resource.id);
        };


        /*
         Renders the HTML responsible for the subrow expander area,
         as well as the space before it (used to align expanders of similar depths)
         */

        ResourceRow.prototype.renderGutterHtml = function() {
            var html, i, j, ref;
            html = '';
            for (i = j = 0, ref = this.depth; j < ref; i = j += 1) {
                html += '<span class="fc-icon"/>';
            }
            html += '<span class="fc-expander-space">' + '<span class="fc-icon"></span>' + '</span>';
            return html;
        };

        return ResourceRow;

    })(EventRow);

    FC.views.timeline.resourceClass = ResourceTimelineView;

    ResourceAgendaView = (function(superClass) {
        extend(ResourceAgendaView, superClass);

        function ResourceAgendaView() {
            return ResourceAgendaView.__super__.constructor.apply(this, arguments);
        }

        ResourceAgendaView.mixin(ResourceViewMixin);

        ResourceAgendaView.prototype.timeGridClass = ResourceTimeGrid;

        ResourceAgendaView.prototype.dayGridClass = ResourceDayGrid;

        ResourceAgendaView.prototype.renderHead = function() {
            ResourceAgendaView.__super__.renderHead.apply(this, arguments);
            return this.timeGrid.processHeadResourceEls(this.headContainerEl);
        };

        ResourceAgendaView.prototype.setResources = function(resources) {
            this.timeGrid.setResources(resources);
            if (this.dayGrid) {
                this.dayGrid.setResources(resources);
            }
            this.clearView();
            return this.displayView();
        };

        ResourceAgendaView.prototype.unsetResources = function(isDestroying) {
            this.clearEvents();
            this.timeGrid.unsetResources();
            if (this.dayGrid) {
                this.dayGrid.unsetResources();
            }
            if (!isDestroying) {
                this.clearView();
                return this.displayView();
            }
        };

        return ResourceAgendaView;

    })(FC.AgendaView);

    FC.views.agenda.queryResourceClass = function(viewSpec) {
        var ref;
        if ((ref = viewSpec.options.groupByResource || viewSpec.options.groupByDateAndResource) != null ? ref : viewSpec.duration.as('days') === 1) {
            return ResourceAgendaView;
        }
    };

    ResourceBasicView = (function(superClass) {
        extend(ResourceBasicView, superClass);

        function ResourceBasicView() {
            return ResourceBasicView.__super__.constructor.apply(this, arguments);
        }

        ResourceBasicView.mixin(ResourceViewMixin);

        ResourceBasicView.prototype.dayGridClass = ResourceDayGrid;

        ResourceBasicView.prototype.renderHead = function() {
            ResourceBasicView.__super__.renderHead.apply(this, arguments);
            return this.dayGrid.processHeadResourceEls(this.headContainerEl);
        };

        ResourceBasicView.prototype.setResources = function(resources) {
            this.dayGrid.setResources(resources);
            this.clearView();
            return this.displayView();
        };

        ResourceBasicView.prototype.unsetResources = function(isDestroying) {
            this.clearEvents();
            this.dayGrid.unsetResources();
            if (!isDestroying) {
                this.clearView();
                return this.displayView();
            }
        };

        return ResourceBasicView;

    })(FC.BasicView);

    ResourceMonthView = (function(superClass) {
        extend(ResourceMonthView, superClass);

        function ResourceMonthView() {
            return ResourceMonthView.__super__.constructor.apply(this, arguments);
        }

        ResourceMonthView.mixin(ResourceViewMixin);

        ResourceMonthView.prototype.dayGridClass = ResourceDayGrid;

        ResourceMonthView.prototype.renderHead = function() {
            ResourceMonthView.__super__.renderHead.apply(this, arguments);
            return this.dayGrid.processHeadResourceEls(this.headContainerEl);
        };

        ResourceMonthView.prototype.setResources = function(resources) {
            this.dayGrid.setResources(resources);
            this.clearView();
            return this.displayView();
        };

        ResourceMonthView.prototype.unsetResources = function() {
            this.clearEvents();
            this.dayGrid.unsetResources();
            this.clearView();
            return this.displayView();
        };

        return ResourceMonthView;

    })(FC.MonthView);

    FC.views.basic.queryResourceClass = function(viewSpec) {
        var ref;
        if ((ref = viewSpec.options.groupByResource || viewSpec.options.groupByDateAndResource) != null ? ref : viewSpec.duration.as('days') === 1) {
            return ResourceBasicView;
        }
    };

    FC.views.month.queryResourceClass = function(viewSpec) {
        if (viewSpec.options.groupByResource || viewSpec.options.groupByDateAndResource) {
            return ResourceMonthView;
        }
    };

    RELEASE_DATE = '2016-09-04';

    UPGRADE_WINDOW = {
        years: 1,
        weeks: 1
    };
});

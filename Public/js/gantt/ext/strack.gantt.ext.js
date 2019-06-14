gantt.config.smart_rendering = !0, gantt._smart_render = {
    getViewPort:function() {
        var t = this.getScrollSizes(), e = gantt._restore_scroll_state();
        return e.y = Math.min(t.y_inner - t.y, e.y), {
            y:e.y,
            y_end:e.y + t.y
        };
    },
    getScrollSizes:function() {
        var t = gantt._scroll_sizes();
        return t.x = t.x || 0, t.y = t.y || gantt._order.length * gantt.config.row_height,
            t;
    },
    isInViewPort:function(t, e) {
        return !!(t.y < e.y_end && t.y_end > e.y);
    },
    isTaskDisplayed:function(t) {
        return this.isInViewPort(this.getTaskPosition(t), this.getViewPort());
    },
    isLinkDisplayed:function(t) {
        return this.isInViewPort(this.getLinkPosition(t), this.getViewPort());
    },
    getTaskPosition:function(t) {
        var e = gantt.getTaskTop(t);
        return {
            y:e,
            y_end:e + gantt.config.row_height
        };
    },
    getLinkPosition:function(t) {
        var e = gantt.getLink(t), n = gantt.getTaskTop(e.source), a = gantt.getTaskTop(e.target);
        return {
            y:Math.min(n, a),
            y_end:Math.max(n, a) + gantt.config.row_height
        };
    },
    getRange:function(t) {
        t = t || 0;
        var e = this.getViewPort(), n = Math.floor(Math.max(0, e.y) / gantt.config.row_height) - t, a = Math.ceil(Math.max(0, e.y_end) / gantt.config.row_height) + t, i = gantt._order.slice(n, a);
        return i;
    },
    _redrawItems:function(t, e) {
        for (var n in t) {
            var a = t[n];
            for (var n in a.rendered) a.hide(n);
            for (var i = 0; i < e.length; i++) a.restore(e[i]);
        }
    },
    _getVisibleTasks:function() {
        return gantt._get_tasks_data();
    },
    _getVisibleLinks:function() {
        for (var t = [], e = gantt._get_links_data(), n = 0; n < e.length; n++) this.isLinkDisplayed(e[n].id) && t.push(e[n]);
        return t;
    },
    _recalculateLinkedProjects:function(t) {
        for (var e = {}, n = 0; n < t.length; n++) e[t[n].source] = !0, e[t[n].target] = !0;
        for (var n in e) gantt.isTaskExists(n) && gantt.resetProjectDates(gantt.getTask(n));
    },
    updateRender:function() {
        gantt.callEvent("onBeforeSmartRender", []);
        var t = this._getVisibleLinks();
        this._recalculateLinkedProjects(t), this._redrawItems(gantt._get_task_renderers(), this._getVisibleTasks()),
            this._redrawItems(gantt._get_link_renderers(), t), gantt.callEvent("onSmartRender", []);
    },
    cached:{},
    _takeFromCache:function(t, e, n) {
        this.cached[n] || (this.cached[n] = null);
        var a = this.cached[n];
        return void 0 !== t ? (a || (a = this.cached[n] = {}), void 0 === a[t] && (a[t] = e(t)),
            a[t]) :(a || (a = e()), a);
    },
    initCache:function() {
        for (var t = [ "getLinkPosition", "getTaskPosition", "isTaskDisplayed", "isLinkDisplayed", "getViewPort", "getScrollSizes" ], e = 0; e < t.length; e++) {
            var n = t[e], a = gantt.bind(this[n], this);
            this[n] = function(t, e) {
                return function(n) {
                    return this._takeFromCache(n, t, e);
                };
            }(a, n);
        }
        this.invalidateCache(), this.initCache = function() {};
    },
    invalidateCache:function() {
        function t() {
            s.cached.getViewPort = null, s.cached.getScrollSizes = null, s.cached.isTaskDisplayed = null,
                s.cached.isLinkDisplayed = null;
        }
        function e() {
            s.cached.isTaskDisplayed = null, s.cached.isLinkDisplayed = null, s.cached.getLinkPosition = null,
                s.cached.getTaskPosition = null;
        }
        function n() {
            t(), e();
        }
        function a(t) {
            s.cached.isTaskDisplayed && (s.cached.isTaskDisplayed[t] = void 0), s.cached.getTaskPosition && (s.cached.getTaskPosition[t] = void 0);
        }
        function i(t) {
            s.cached.isLinkDisplayed && (s.cached.isLinkDisplayed[t] = void 0), s.cached.getLinkPosition && (s.cached.getLinkPosition[t] = void 0);
        }
        var s = this;
        gantt.attachEvent("onClear", function() {
            n();
        }), gantt.attachEvent("onParse", function() {
            n();
        }), gantt.attachEvent("onAfterLinkUpdate", i), gantt.attachEvent("onAfterTaskAdd", n),
            gantt.attachEvent("onAfterTaskDelete", n), gantt.attachEvent("onAfterTaskUpdate", a),
            gantt.attachEvent("onGanttScroll", t), gantt.attachEvent("onDataRender", n), this.invalidateCache = function() {};
    }
}, gantt._smart_render.initCache(), gantt.attachEvent("onGanttScroll", function(t, e, n, a) {
    if (gantt.config.smart_rendering) {
        e != a && gantt._smart_render.updateRender();
        var i = Math.floor(a / gantt.config.row_height) * gantt.config.row_height;
        gantt.$grid_data.scrollTop = a - i;
    }
}), gantt.attachEvent("onDataRender", function() {
    gantt.config.smart_rendering && gantt._smart_render.updateRender();
}), function() {
    function t(t, e) {
        return function() {
            return gantt.config.smart_rendering ? e.apply(this, arguments) :t.apply(this, arguments);
        };
    }
    var e = gantt._get_task_filters;
    gantt._get_task_filters = t(gantt._get_task_filters, function() {
        var t = e.call(gantt);
        return t.push(function(t) {
            return gantt.config.smart_rendering ? gantt._smart_render.isTaskDisplayed(t) :!0;
        }), t;
    });
    var n = gantt._get_link_filters;
    gantt._get_link_filters = t(gantt._get_link_filters, function() {
        var t = n.call(gantt);
        return t.push(function(t) {
            return gantt.config.smart_rendering ? gantt._smart_render.isLinkDisplayed(t) :!0;
        }), t;
    }), gantt._get_data_range = t(gantt._get_data_range, function() {
        return this._smart_render.getRange();
    });
}();
gantt._markers || (gantt._markers = {}), gantt.config.show_markers = !0, gantt.attachEvent("onClear", function() {
    gantt._markers = {};
}), gantt.attachEvent("onGanttReady", function() {
    function t(t) {
        if (!gantt.config.show_markers) return !1;
        if (!t.start_date) return !1;
        var e = gantt.getState();
        if (!(+t.start_date > +e.max_date || +t.end_date && +t.end_date < +e.min_date || +t.start_date < +e.min_date)) {
            var n = document.createElement("div");
            n.setAttribute("marker_id", t.id);
            var a = "gantt_marker";
            gantt.templates.marker_class && (a += " " + gantt.templates.marker_class(t)), t.css && (a += " " + t.css),
            t.title && (n.title = t.title), n.className = a;
            var i = gantt.posFromDate(t.start_date);
            if (n.style.left = i + "px", n.style.height = Math.max(gantt._y_from_ind(gantt._order.length), 0) + "px",
                    t.end_date) {
                var s = gantt.posFromDate(t.end_date);
                n.style.width = Math.max(s - i, 0) + "px";
            }
            return t.text && (n.innerHTML = "<div class='gantt_marker_content' >" + t.text + "</div>"),
                n;
        }
    }
    var e = document.createElement("div");
    e.className = "gantt_marker_area", gantt.$task_data.appendChild(e), gantt.$marker_area = e,
        gantt._markerRenderer = gantt._task_renderer("markers", t, gantt.$marker_area, null);
}), gantt.attachEvent("onDataRender", function() {
    gantt.renderMarkers();
}), gantt.getMarker = function(t) {
    return this._markers ? this._markers[t] :null;
}, gantt.addMarker = function(t) {
    return t.id = t.id || gantt.uid(), this._markers[t.id] = t, t.id;
}, gantt.deleteMarker = function(t) {
    return this._markers && this._markers[t] ? (delete this._markers[t], !0) :!1;
}, gantt.updateMarker = function(t) {
    this._markerRenderer && this._markerRenderer.render_item(this.getMarker(t));
}, gantt._getMarkers = function() {
    var t = [];
    for (var e in this._markers) t.push(this._markers[e]);
    return t;
}, gantt.renderMarkers = function() {
    if (!this._markers) return !1;
    if (!this._markerRenderer) return !1;
    var t = this._getMarkers();
    return this._markerRenderer.render_items(t), !0;
};
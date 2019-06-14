THREE.TrackballControls = function(a, b) {
    function p(a) {
        c.enabled && (window.removeEventListener("keydown", p), g = f, f === d.NONE && (a.keyCode !== c.keys[d.ROTATE] || c.noRotate ? a.keyCode !== c.keys[d.ZOOM] || c.noZoom ? a.keyCode !== c.keys[d.PAN] || c.noPan || (f = d.PAN) :f = d.ZOOM :f = d.ROTATE));
    }
    function q() {
        c.enabled && (f = g, window.addEventListener("keydown", p, !1));
    }
    function r(a) {
        c.enabled && (a.preventDefault(), a.stopPropagation(), f === d.NONE && (f = a.button),
            f !== d.ROTATE || c.noRotate ? f !== d.ZOOM || c.noZoom ? f !== d.PAN || c.noPan || (m = n = c.getMouseOnScreen(a.clientX, a.clientY)) :k = l = c.getMouseOnScreen(a.clientX, a.clientY) :i = j = c.getMouseProjectionOnBall(a.clientX, a.clientY),
            document.addEventListener("mousemove", s, !1), document.addEventListener("mouseup", t, !1));
    }
    function s(a) {
        c.enabled && (f !== d.ROTATE || c.noRotate ? f !== d.ZOOM || c.noZoom ? f !== d.PAN || c.noPan || (n = c.getMouseOnScreen(a.clientX, a.clientY)) :l = c.getMouseOnScreen(a.clientX, a.clientY) :j = c.getMouseProjectionOnBall(a.clientX, a.clientY));
    }
    function t(a) {
        c.enabled && (a.preventDefault(), a.stopPropagation(), f = d.NONE, document.removeEventListener("mousemove", s),
            document.removeEventListener("mouseup", t));
    }
    function u(a) {
        if (c.enabled) {
            a.preventDefault(), a.stopPropagation();
            var b = 0;
            a.wheelDelta ? b = a.wheelDelta / 40 :a.detail && (b = -a.detail / 3), k.y += .05 * (1 / b);
        }
    }
    function v(a) {
        if (c.enabled) switch (a.preventDefault(), a.touches.length) {
            case 1:
                i = j = c.getMouseProjectionOnBall(a.touches[0].pageX, a.touches[0].pageY);
                break;

            case 2:
                k = l = c.getMouseOnScreen(a.touches[0].pageX, a.touches[0].pageY);
                break;

            case 3:
                m = n = c.getMouseOnScreen(a.touches[0].pageX, a.touches[0].pageY);
        }
    }
    function w(a) {
        if (c.enabled) switch (a.preventDefault(), a.touches.length) {
            case 1:
                j = c.getMouseProjectionOnBall(a.touches[0].pageX, a.touches[0].pageY);
                break;

            case 2:
                l = c.getMouseOnScreen(a.touches[0].pageX, a.touches[0].pageY);
                break;

            case 3:
                n = c.getMouseOnScreen(a.touches[0].pageX, a.touches[0].pageY);
        }
    }
    var c, d, e, f, g, h, i, j, k, l, m, n, o;
    THREE.EventDispatcher.call(this), c = this, d = {
        NONE:-1,
        ROTATE:0,
        ZOOM:1,
        PAN:2
    }, this.object = a, this.domElement = void 0 !== b ? b :document, this.enabled = !0,
        this.screen = {
            width:0,
            height:0,
            offsetLeft:0,
            offsetTop:0
        }, this.radius = (this.screen.width + this.screen.height) / 4, this.rotateSpeed = 1,
        this.zoomSpeed = 1.2, this.panSpeed = .3, this.noRotate = !0, this.noZoom = !1,
        this.noPan = !1, this.staticMoving = !1, this.dynamicDampingFactor = .2, this.minDistance = 0,
        this.maxDistance = 1 / 0, this.keys = [ 65, 83, 68 ], this.target = new THREE.Vector3(),
        e = new THREE.Vector3(), f = d.NONE, g = d.NONE, h = new THREE.Vector3(), i = new THREE.Vector3(),
        j = new THREE.Vector3(), k = new THREE.Vector2(), l = new THREE.Vector2(), m = new THREE.Vector2(),
        n = new THREE.Vector2(), o = {
        type:"change"
    }, this.handleResize = function() {
        this.screen.width = window.innerWidth, this.screen.height = window.innerHeight,
            this.screen.offsetLeft = 0, this.screen.offsetTop = 0, this.radius = (this.screen.width + this.screen.height) / 4;
    }, this.handleEvent = function(a) {
        "function" == typeof this[a.type] && this[a.type](a);
    }, this.getMouseOnScreen = function(a, b) {
        return new THREE.Vector2(.5 * ((a - c.screen.offsetLeft) / c.radius), .5 * ((b - c.screen.offsetTop) / c.radius));
    }, this.getMouseProjectionOnBall = function(a, b) {
        var f, d = new THREE.Vector3((a - .5 * c.screen.width - c.screen.offsetLeft) / c.radius, (.5 * c.screen.height + c.screen.offsetTop - b) / c.radius, 0), e = d.length();
        return e > 1 ? d.normalize() :d.z = Math.sqrt(1 - e * e), h.copy(c.object.position).subSelf(c.target),
            f = c.object.up.clone().setLength(d.y), f.addSelf(c.object.up.clone().crossSelf(h).setLength(d.x)),
            f.addSelf(h.setLength(d.z)), f;
    }, this.rotateCamera = function() {
        var b, d, a = Math.acos(i.dot(j) / i.length() / j.length());
        a && (b = new THREE.Vector3().cross(i, j).normalize(), d = new THREE.Quaternion(),
            a *= c.rotateSpeed, d.setFromAxisAngle(b, -a), d.multiplyVector3(h), d.multiplyVector3(c.object.up),
            d.multiplyVector3(j), c.staticMoving ? i.copy(j) :(d.setFromAxisAngle(b, a * (c.dynamicDampingFactor - 1)),
            d.multiplyVector3(i)));
    }, this.zoomCamera = function() {
        var a = 1 + (l.y - k.y) * c.zoomSpeed;
        1 !== a && a > 0 && (h.multiplyScalar(a), c.staticMoving ? k.copy(l) :k.y += (l.y - k.y) * this.dynamicDampingFactor);
    }, this.panCamera = function() {
        var b, a = n.clone().subSelf(m);
        a.lengthSq() && (a.multiplyScalar(h.length() * c.panSpeed), b = h.clone().crossSelf(c.object.up).setLength(a.x),
            b.addSelf(c.object.up.clone().setLength(a.y)), c.object.position.addSelf(b), c.target.addSelf(b),
            c.staticMoving ? m = n :m.addSelf(a.sub(n, m).multiplyScalar(c.dynamicDampingFactor)));
    }, this.checkDistances = function() {
        c.noZoom && c.noPan || (c.object.position.lengthSq() > c.maxDistance * c.maxDistance && c.object.position.setLength(c.maxDistance),
        h.lengthSq() < c.minDistance * c.minDistance && c.object.position.add(c.target, h.setLength(c.minDistance)));
    }, this.update = function() {
        h.copy(c.object.position).subSelf(c.target), c.noRotate || c.rotateCamera(), c.noZoom || c.zoomCamera(),
        c.noPan || c.panCamera(), c.object.position.add(c.target, h), c.checkDistances(),
            c.object.lookAt(c.target), e.distanceToSquared(c.object.position) > 0 && (c.dispatchEvent(o),
            e.copy(c.object.position));
    }, this.domElement.addEventListener("contextmenu", function(a) {
        a.preventDefault();
    }, !1), this.domElement.addEventListener("mousedown", r, !1), this.domElement.addEventListener("mousewheel", u, !1),
        this.domElement.addEventListener("DOMMouseScroll", u, !1), this.domElement.addEventListener("touchstart", v, !1),
        this.domElement.addEventListener("touchend", v, !1), this.domElement.addEventListener("touchmove", w, !1),
        window.addEventListener("keydown", p, !1), window.addEventListener("keyup", q, !1),
        this.handleResize();
};
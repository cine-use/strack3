/******************************************
 * Resources for web entrepreneurs
 ******************************************/
(function($)
{
	$.fn.wPaint = function(option, settings)
	{
		if(typeof option === 'object')
		{
			settings = option;
		}
		else if(typeof option == 'string')
		{
			var values = [];

			var elements = this.each(function()
			{
				var data = $(this).data('_wPaint');

				if(data)
				{
					if(option == 'clear') { data.clearAll(); }
					if(option == 'clearUndo') { data.clearUndo(); }
					else if(option == 'image' && settings === undefined) { values.push(data.getImage()); }
					else if(option == 'image' && settings !== undefined) { data.setImage(settings, true); }
					else if(option == 'imageBg' && settings !== undefined) { data.setBgImage(settings); }
					else if($.fn.wPaint.defaultSettings[option] !== undefined)
					{
						if(settings !== undefined) { data.settings[option] = settings; }
						else { values.push(data.settings[option]); }
					}
				}
			});

			if(values.length === 1) { return values[0]; }
			if(values.length > 0) { return values; }
			else { return elements; }
		}

		//clean up some variables
		settings = $.extend({}, $.fn.wPaint.defaultSettings, settings || {});
		settings.lineWidthMin = parseInt(settings.lineWidthMin);
		settings.lineWidthMax = parseInt(settings.lineWidthMax);
		settings.lineWidth = parseInt(settings.lineWidth);
		settings.fontSizeMin = parseInt(settings.fontSizeMin);
		settings.fontSizeMax = parseInt(settings.fontSizeMax);
		settings.fontSize = parseInt(settings.fontSize);

		return this.each(function()
		{
			var $elem = $(this);
			var _settings = jQuery.extend(true, {}, settings);

			//test for HTML5 canvas
			var test = document.createElement('canvas');
			if(!test.getContext)
			{
				$elem.html("Browser does not support HTML5 canvas, please upgrade to a more modern browser.");
				return false;
			}

			if($elem.data('_wPaint')) return false;

			var canvas = new Canvas(_settings, $elem);
			canvas.mainMenu = new MainMenu(canvas);
			canvas.textMenu = new TextMenu(canvas);

			if(_settings.imageBg) $elem.append(canvas.generateBg($elem.width(), $elem.height(), _settings.imageBg));
			$elem.append(canvas.generate($elem.width(), $elem.height()));
			$elem.append(canvas.generateTemp());
			$elem.append(canvas.generateTextInput());

			//填充menu dom
			var $mainmenu;
			if(option.menuDom){
				$mainmenu = $(option.menuDom);
			}else {
				$mainmenu = $elem;
			}
			$mainmenu
				.append(canvas.mainMenu.generate(canvas, canvas.textMenu))
				.append(canvas.textMenu.generate(canvas, canvas.mainMenu));

			//init the snap on the text menu
			canvas.mainMenu.moveTextMenu(canvas.mainMenu, canvas.textMenu);

			//init mode
			canvas.mainMenu.set_mode(canvas.mainMenu, canvas, _settings.mode);

			//pull from css so that it is dynamic
			var buttonSize = $("._wPaint_icon").outerHeight(true) - (parseInt($("._wPaint_icon").css('paddingTop').split('px')[0]) + parseInt($("._wPaint_icon").css('paddingBottom').split('px')[0]));

			canvas.mainMenu.menu.find("._wPaint_fillColorPicker").wColorPicker({
				mode: "click",
				initColor: _settings.fillStyle,
				buttonSize: buttonSize,
				showSpeed: 300,
				hideSpeed: 300,
				onSelect: function(color){
					canvas.settings.fillStyle = color;
					canvas.textInput.css({color: color});
				}
			});

			canvas.mainMenu.menu.find("._wPaint_strokeColorPicker").wColorPicker({
				mode: "click",
				initColor: _settings.strokeStyle,
				buttonSize: buttonSize,
				showSpeed: 300,
				hideSpeed: 300,
				onSelect: function(color){
					canvas.settings.strokeStyle = color;
				}
			});

			//must set width after append to get proper dimensions
			canvas.mainMenu.setWidth(canvas, canvas.mainMenu.menu);
			canvas.mainMenu.setWidth(canvas, canvas.textMenu.menu);

			if(_settings.image)
			{
				canvas.setImage(_settings.image, true);
			}
			else
			{
				canvas.addUndo();
			}

			$elem.data('_wPaint', canvas);
		});
	};

	var shapes = ['Rectangle', 'Ellipse', 'Line', 'Text'];

	$.fn.wPaint.defaultSettings = {
		mode				 : 'Pencil',			// drawing mode - Rectangle, Ellipse, Line, Pencil, Eraser
		lineWidthMin		 : '0', 				// line width min for select drop down
		lineWidthMax		 : '10',				// line widh max for select drop down
		lineWidth			 : '2', 				// starting line width
		fillStyle			 : '#FFFFFF',			// starting fill style
		strokeStyle			 : '#FFFF00',			// start stroke style
		fontSizeMin			 : '1',					// min font size in px
		fontSizeMax			 : '11',				// max font size in px
		fontSize			 : '16',				// current font size for text input
		fontFamilyOptions	 : ['Arial', 'Courier', 'Times', 'Trebuchet', 'Verdana'], // available font families
		fontFamily			 : 'Arial',				// active font family for text input
		fontTypeBold		 : false,				// text input bold enable/disable
		fontTypeItalic		 : false,				// text input italic enable/disable
		fontTypeUnderline	 : false,				// text input italic enable/disable
		image				 : null,				// preload image - base64 encoded data
		imageBg				 : null,				// preload image bg, cannot be altered but saved with image
		drawDown			 : null,				// function to call when start a draw
		drawMove			 : null,				// function to call during a draw
		drawUp				 : null,				// function to call at end of draw
		menu 				 : ['undo', 'redo', 'clear','rectangle','ellipse','line','pencil','text','eraser','fillColor','lineWidth','strokeColor'], // menu items - appear in order they are set
		menuOrientation		 : 'horizontal',		// orinetation of menu (horizontal, vertical)
		menuOffsetX			 : 5,					// offset for menu (left)
		menuOffsetY			 : 5,					// offset for menu (top)
		menuTitles           : {                    // icon titles, replace any of the values to customize
			'undo': 'undo',
			'redo': 'redo',
			'clear': 'clear',
			'rectangle': 'rectangle',
			'ellipse': 'ellipse',
			'line': 'line',
			'pencil': 'pencil',
			'text': 'text',
			'eraser': 'eraser',
			'fillColor': 'fill color',
			'lineWidth': 'line width',
			'strokeColor': 'stroke color',
			'bold': 'bold',
			'italic': 'italic',
			'underline': 'underline',
			'fontSize': 'font size',
			'fontFamily': 'font family'
		},
		disableMobileDefaults: false            	// disable default touchmove events for mobile (will prevent flipping between tabs and scrolling)
	};

	/**
	 * Canvas class definition
	 */
	function Canvas(settings, elem)
	{
		this.settings = settings;
		this.$elem = elem;
		this.mainMenu = null;
		this.textMenu = null;

		this.undoArray = [];
		this.undoCurrent = -1;
		this.undoMax = 10;

		this.draw = false;

		this.canvas = null;
		this.ctx = null;

		this.canvasTemp = null;
		this.ctxTemp = null;

		this.canvasBg = null;
		this.ctxBg = null;

		this.canvasTempLeftOriginal = null;
		this.canvasTempTopOriginal = null;

		this.canvasTempLeftNew = null;
		this.canvasTempTopNew = null;

		this.textInput = null;

		return this;
	}

	Canvas.prototype =
	{
		/*******************************************************************************
		 * Generate canvases and events
		 *******************************************************************************/
		generate: function(width, height)
		{
			this.canvas = document.createElement('canvas');
			this.ctx = this.canvas.getContext('2d');

			//create local reference
			var _self = this;

			$(this.canvas)
				.attr('width', width + 'px')
				.attr('height', height + 'px')
				.css({position: 'absolute', left: 0, top: 0})
				.mousedown(function(e)
				{
					e.preventDefault();
					e.stopPropagation();
					_self.draw = true;
					_self.callFunc(e, _self, 'Down');
				});

			$(document)
				.mousemove(function(e)
				{
					if(_self.draw) _self.callFunc(e, _self, 'Move');
				})
				.mouseup(function(e)
				{
					//make sure we are in draw mode otherwise this will fire on any mouse up.
					if(_self.draw)
					{
						_self.draw = false;
						_self.callFunc(e, _self, 'Up');
					}
				});

			this.bindMobile();

			return $(this.canvas);
		},

		bindMobile: function()
		{
			$(this.canvas).bind('touchstart touchmove touchend touchcancel', function ()
			{
				var touches = event.changedTouches, first = touches[0], type = "";

				switch (event.type)
				{
					case "touchstart": type = "mousedown"; break;
					case "touchmove": type = "mousemove"; break;
					case "touchend": type = "mouseup"; break;
					default: return;
				}

				var simulatedEvent = document.createEvent("MouseEvent");

				simulatedEvent.initMouseEvent(type, true, true, window, 1, first.screenX, first.screenY, first.clientX, first.clientY, false, false, false, false, 0/*left*/, null);
				first.target.dispatchEvent(simulatedEvent);
				event.preventDefault();
			});

			//eliminate browser defaults for
			if(this.settings.disableMobileDefaults) $(document).bind('touchmove', function(e) { e.preventDefault(); });
		},

		generateTemp: function()
		{
			this.canvasTemp = document.createElement('canvas');
			this.ctxTemp = this.canvasTemp.getContext('2d');

			$(this.canvasTemp).css({position: 'absolute'}).hide();

			return $(this.canvasTemp);
		},

		generateBg: function(width, height, data)
		{
			var _self = this;

			if(!this.canvasBg)
			{
				this.canvasBg = document.createElement('canvas');
				this.ctxBg = this.canvasBg.getContext('2d');

				$(this.canvasBg).attr('id', 'mofo').css({position: 'absolute', left: 0, top: 0}).attr('width', width).attr('height', height);
			}

			this.setBgImage(data);

			return $(this.canvasBg);
		},

		generateTextInput: function()
		{
			var _self = this;

			_self.textCalc = $('<div></div>').css({display:'none', fontSize:this.settings.fontSize, lineHeight:this.settings.fontSize+'px', fontFamily:this.settings.fontFamily});

			_self.textInput =
				$('<textarea class="_wPaint_textInput" spellcheck="false"></textarea>')
					.css({display:'none', position:'absolute', color:this.settings.fillStyle, fontSize:this.settings.fontSize, lineHeight:this.settings.fontSize+'px', fontFamily:this.settings.fontFamily})

			if(_self.settings.fontTypeBold) { _self.textInput.css('fontWeight', 'bold'); _self.textCalc.css('fontWeight', 'bold'); }
			if(_self.settings.fontTypeItalic) { _self.textInput.css('fontStyle', 'italic'); _self.textCalc.css('fontStyle', 'italic'); }
			if(_self.settings.fontTypeUnderline) { _self.textInput.css('textDecoration', 'underline'); _self.textCalc.css('textDecoration', 'underline'); }

			$('body').append(_self.textCalc);

			return _self.textInput;
		},

		callFunc: function(e, _self, event)
		{
			$e = jQuery.extend(true, {}, e);

			var canvas_offset = $(_self.canvas).offset();

			$e.pageX = Math.floor($e.pageX - canvas_offset.left);
			$e.pageY = Math.floor($e.pageY - canvas_offset.top);

			var mode = $.inArray(_self.settings.mode, shapes) > -1 ? 'Shape' : _self.settings.mode;
			var func = _self['draw' + mode + '' + event];

			if(func) func($e, _self);

			if(_self.settings['draw' + event]) _self.settings['draw' + event].apply(_self, [e, mode]);

			if(_self.settings.mode !== 'Text' && event === 'Up') { this.addUndo(); }
		},

		/*******************************************************************************
		 * draw any shape
		 *******************************************************************************/
		drawShapeDown: function(e, _self)
		{
			if(_self.settings.mode == 'Text')
			{
				//draw current text before resizing next text box
				if(_self.textInput.val() != '') _self.drawTextUp(e, _self);

				_self.textInput.css({left: e.pageX-1, top: e.pageY-1, width:0, height:0});
			}

			$(_self.canvasTemp)
				.css({left: e.pageX, top: e.pageY})
				.attr('width', 0)
				.attr('height', 0)
				.show();

			_self.canvasTempLeftOriginal = e.pageX;
			_self.canvasTempTopOriginal = e.pageY;

			var func = _self['draw' + _self.settings.mode + 'Down'];

			if(func) func(e, _self);
		},

		drawShapeMove: function(e, _self)
		{
			var xo = _self.canvasTempLeftOriginal;
			var yo = _self.canvasTempTopOriginal;

			var half_line_width = _self.settings.lineWidth / 2;

			var left = (e.pageX < xo ? e.pageX : xo) - (_self.settings.mode == 'Line' ? Math.floor(half_line_width) : 0);
			var top = (e.pageY < yo ? e.pageY : yo) - (_self.settings.mode == 'Line' ? Math.floor(half_line_width) : 0);
			var width = Math.abs(e.pageX - xo) + (_self.settings.mode == 'Line' ? _self.settings.lineWidth : 0);
			var height = Math.abs(e.pageY - yo) + (_self.settings.mode == 'Line' ? _self.settings.lineWidth : 0);

			$(_self.canvasTemp)
				.css({left: left, top: top})
				.attr('width', width)
				.attr('height', height);

			if(_self.settings.mode == 'Text') _self.textInput.css({left: left-1, top: top-1, width:width, height:height});

			_self.canvasTempLeftNew = left;
			_self.canvasTempTopNew = top;

			var func = _self['draw' + _self.settings.mode + 'Move'];

			if(func)
			{
				var factor = _self.settings.mode == 'Line' ? 1 : 2;

				e.x = half_line_width*factor;
				e.y = half_line_width*factor;
				e.w = width - _self.settings.lineWidth*factor;
				e.h = height - _self.settings.lineWidth*factor;

				_self.ctxTemp.fillStyle = _self.settings.fillStyle;
				_self.ctxTemp.strokeStyle = _self.settings.strokeStyle;
				_self.ctxTemp.lineWidth = _self.settings.lineWidth*factor;

				func(e, _self);
			}
		},

		drawShapeUp: function(e, _self)
		{
			if(_self.settings.mode != 'Text')
			{
				_self.ctx.drawImage(_self.canvasTemp ,_self.canvasTempLeftNew, _self.canvasTempTopNew);

				$(_self.canvasTemp).hide();

				var func = _self['draw' + _self.settings.mode + 'Up'];
				if(func) func(e, _self);
			}
		},

		/*******************************************************************************
		 * draw rectangle
		 *******************************************************************************/
		drawRectangleMove: function(e, _self)
		{
			_self.ctxTemp.beginPath();
			_self.ctxTemp.rect(e.x, e.y, e.w, e.h);
			_self.ctxTemp.closePath();
			_self.ctxTemp.stroke();
			_self.ctxTemp.fill();
		},

		/*******************************************************************************
		 * draw ellipse
		 *******************************************************************************/
		drawEllipseMove: function(e, _self)
		{
			var kappa = .5522848;
			var ox = (e.w / 2) * kappa; 	// control point offset horizontal
			var  oy = (e.h / 2) * kappa; 	// control point offset vertical
			var  xe = e.x + e.w;           	// x-end
			var ye = e.y + e.h;           	// y-end
			var xm = e.x + e.w / 2;       	// x-middle
			var ym = e.y + e.h / 2;       	// y-middle

			_self.ctxTemp.beginPath();
			_self.ctxTemp.moveTo(e.x, ym);
			_self.ctxTemp.bezierCurveTo(e.x, ym - oy, xm - ox, e.y, xm, e.y);
			_self.ctxTemp.bezierCurveTo(xm + ox, e.y, xe, ym - oy, xe, ym);
			_self.ctxTemp.bezierCurveTo(xe, ym + oy, xm + ox, ye, xm, ye);
			_self.ctxTemp.bezierCurveTo(xm - ox, ye, e.x, ym + oy, e.x, ym);
			_self.ctxTemp.closePath();
			if(_self.settings.lineWidth > 0)_self.ctxTemp.stroke();
			_self.ctxTemp.fill();
		},

		/*******************************************************************************
		 * draw line
		 *******************************************************************************/
		drawLineMove: function(e, _self)
		{
			var xo = _self.canvasTempLeftOriginal;
			var yo = _self.canvasTempTopOriginal;

			if(e.pageX < xo) { e.x = e.x + e.w; e.w = e.w * -1}
			if(e.pageY < yo) { e.y = e.y + e.h; e.h = e.h * -1}

			_self.ctxTemp.lineJoin = "round";
			_self.ctxTemp.beginPath();
			_self.ctxTemp.moveTo(e.x, e.y);
			_self.ctxTemp.lineTo(e.x + e.w, e.y + e.h);
			_self.ctxTemp.closePath();
			_self.ctxTemp.stroke();
		},

		/*******************************************************************************
		 * draw pencil
		 *******************************************************************************/
		drawPencilDown: function(e, _self)
		{
			_self.ctx.lineJoin = "round";
			_self.ctx.lineCap = "round";
			_self.ctx.strokeStyle = _self.settings.strokeStyle;
			_self.ctx.fillStyle = _self.settings.strokeStyle;
			_self.ctx.lineWidth = _self.settings.lineWidth;

			//draw single dot in case of a click without a move
			_self.ctx.beginPath();
			_self.ctx.arc(e.pageX, e.pageY, _self.settings.lineWidth/2, 0, Math.PI*2, true);
			_self.ctx.closePath();
			_self.ctx.fill();

			//start the path for a drag
			_self.ctx.beginPath();
			_self.ctx.moveTo(e.pageX, e.pageY);
		},

		drawPencilMove: function(e, _self)
		{
			_self.ctx.lineTo(e.pageX, e.pageY);
			_self.ctx.stroke();
		},

		drawPencilUp: function(e, _self)
		{
			_self.ctx.closePath();
		},

		/*******************************************************************************
		 * draw text
		 *******************************************************************************/

		drawTextDown: function(e, _self)
		{
			_self.textInput.val('').show().focus();
		},

		drawTextUp: function(e, _self)
		{
			if(e) { this.addUndo(); }

			var fontString = '';
			if(_self.settings.fontTypeItalic) fontString += 'italic ';
			//if(_self.settings.fontTypeUnderline) fontString += 'underline ';
			if(_self.settings.fontTypeBold) fontString += 'bold ';

			fontString += _self.settings.fontSize + 'px ' + _self.settings.fontFamily;

			//setup lines
			var lines = _self.textInput.val().split('\n');
			var linesNew = [];
			var textInputWidth = _self.textInput.width() - 2;

			var width = 0;
			var lastj = 0;

			for(var i=0, ii=lines.length; i<ii; i++)
			{
				_self.textCalc.html('');
				lastj = 0;

				for(var j=0, jj=lines[0].length; j<jj; j++)
				{
					width = _self.textCalc.append(lines[i][j]).width();

					if(width > textInputWidth)
					{
						linesNew.push(lines[i].substring(lastj,j));
						lastj = j;
						_self.textCalc.html(lines[i][j]);
					}
				}

				if(lastj != j) linesNew.push(lines[i].substring(lastj,j));
			}

			lines = _self.textInput.val(linesNew.join('\n')).val().split('\n');

			var offset = _self.textInput.position();
			var left = offset.left;
			var top = offset.top;
			var underlineOffset = 0;

			for(var i=0, ii=lines.length; i<ii; i++)
			{
				_self.ctx.fillStyle = _self.settings.fillStyle;

				_self.ctx.textBaseline = 'top';
				_self.ctx.font = fontString;
				_self.ctx.fillText(lines[i], left, top);

				top += _self.settings.fontSize;

				if(lines[i] != '' && _self.settings.fontTypeUnderline)
				{
					width = _self.textCalc.html(lines[i]).width();

					//manually set pixels for underline since to avoid antialiasing 1px issue, and lack of support for underline in canvas
					var imgData = _self.ctx.getImageData(0, top+underlineOffset, width, 1);

					for (j=0; j<imgData.width*imgData.height*4; j+=4)
					{
						imgData.data[j] = parseInt(_self.settings.fillStyle.substring(1,3), 16);
						imgData.data[j+1] = parseInt(_self.settings.fillStyle.substring(3,5), 16);
						imgData.data[j+2] = parseInt(_self.settings.fillStyle.substring(5,7), 16);
						imgData.data[j+3] = 255;
					}

					_self.ctx.putImageData(imgData, left, top+underlineOffset);
				}
			}
		},

		/*******************************************************************************
		 * eraser
		 *******************************************************************************/
		drawEraserDown: function(e, _self)
		{
			_self.ctx.save();
			_self.ctx.globalCompositeOperation = 'destination-out';
			_self.drawPencilDown(e, _self);
		},

		drawEraserMove: function(e, _self)
		{
			_self.drawPencilMove(e, _self);
		},

		drawEraserUp: function(e, _self)
		{
			_self.drawPencilUp(e, _self);
			_self.ctx.restore();
		},

		/*******************************************************************************
		 * save / load data
		 *******************************************************************************/
		getImage: function()
		{
			this.canvasSave = document.createElement('canvas');
			this.ctxSave = this.canvasSave.getContext('2d');

			$(this.canvasSave).css({display:'none', position: 'absolute', left: 0, top: 0}).attr('width', $(this.canvas).attr('width')).attr('height', $(this.canvas).attr('height'));

			//if a bg image is set, it will automatically save with the image
			if(this.canvasBg) this.ctxSave.drawImage(this.canvasBg, 0, 0);

			this.ctxSave.drawImage(this.canvas, 0, 0);

			return this.canvasSave.toDataURL();
		},

		setImage: function(data, addUndo)
		{
			var _self = this;

			var myImage = new Image();
			myImage.src = data.toString();

			_self.ctx.clearRect(0, 0, _self.canvas.width, _self.canvas.height);

			$(myImage).load(function(){
				_self.ctx.drawImage(myImage, 0, 0);
				if(addUndo) { _self.addUndo(); }
			});
		},

		setBgImage: function(data, addUndo)
		{
			var _self = this;

			var myImage = new Image();
			myImage.src = data.toString();

			_self.ctxBg.clearRect(0, 0, _self.canvasBg.width, _self.canvasBg.height);

			$(myImage).load(function()
			{
				_self.ctxBg.drawImage(myImage, 0, 0);
			});
		},

		/*******************************************************************************
		 * undo / redo
		 *******************************************************************************/

		addUndo: function()
		{
			//if it's not at the end of the array we need to repalce the current array position
			if(this.undoCurrent < this.undoArray.length-1)
			{
				this.undoArray[++this.undoCurrent] = this.getImage();
			}
			else // owtherwise we push normally here
			{
				this.undoArray.push(this.getImage());

				//if we're at the end of the array we need to slice off the front - in increment required
				if(this.undoArray.length > this.undoMax){ this.undoArray = this.undoArray.slice(1, this.undoArray.length); }
				//if we're NOT at the end of the array, we just increment
				else{ this.undoCurrent++; }
			}

			//for undo's then a new draw we want to remove everything afterwards - in most cases nothing will happen here
			while(this.undoCurrent != this.undoArray.length-1) { this.undoArray.pop(); }

			this.undoToggleIcons();
		},

		setUndoImage: function()
		{
			this.setImage(this.undoArray[this.undoCurrent]);
		},

		undoNext: function()
		{
			if(this.undoArray[this.undoCurrent+1]) { this.undoCurrent++; this.setUndoImage(); }

			this.undoToggleIcons();
		},

		undoPrev: function()
		{
			if(this.undoArray[this.undoCurrent-1]) { this.undoCurrent--; this.setUndoImage(); }

			this.undoToggleIcons();
		},

		undoToggleIcons: function()
		{
			var iconUndo = this.mainMenu.menu.find("._wPaint_undo");
			var iconRedo = this.mainMenu.menu.find("._wPaint_redo");

			if(this.undoCurrent > 0 && this.undoArray.length > 1)
			{
				if(!iconUndo.hasClass('uactive')) { iconUndo.addClass('uactive'); }
			}
			else { iconUndo.removeClass('uactive'); }

			if(this.undoCurrent < this.undoArray.length-1)
			{
				if(!iconRedo.hasClass('uactive')) { iconRedo.addClass('uactive'); }
			}
			else { iconRedo.removeClass('uactive'); }
		},

		/*******************************************************************************
		 * Functions
		 *******************************************************************************/
		clearAll: function()
		{
			this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
			this.addUndo();
		},
		//清除Undo操作
		clearUndo : function () {
			this.undoArray = [];
			this.undoCurrent = -1;
			this.undoToggleIcons();
		}
	};

	/**
	 * Main Menu
	 */
	function MainMenu(canvas)
	{
		this.menu = null;

		return this;
	}

	MainMenu.prototype =
	{
		generate: function(canvas, textMenu)
		{
			var $canvas = canvas;
			this.textMenu = textMenu;
			var _self = this;

			//setup the line width select
			var options = '';
			for(var i=$canvas.settings.lineWidthMin; i<=$canvas.settings.lineWidthMax; i++) options += '<option value="' + Strack.number_add_zero(i,2) + '" ' + ($canvas.settings.lineWidth == i ? 'selected="selected"' : '') + '>' + Strack.number_add_zero(i,2) + '</option>';

			var lineWidth = $('<div class="_wPaint_lineWidth _wPaint_dropDown" title="' + $canvas.settings.menuTitles.lineWidth + '"></div>').append(
				$('<select>' + options + '</select>')
					.change(function(e){ $canvas.settings.lineWidth =parseInt($(this).val()); })
			);

			//content
			var menuContent = $('<div class="_wPaint_options"></div>');

			$.each($canvas.settings.menu, function(i, item)
			{
				switch(item)
				{
					case 'undo': menuContent.append($('<div class="_wPaint_icon _wPaint_undo" title="' + $canvas.settings.menuTitles.undo + '"><i class="icon-uniE98D"></i></div>').click(function(){ $canvas.undoPrev(); })); break;
					case 'redo': menuContent.append($('<div class="_wPaint_icon _wPaint_redo" title="' + $canvas.settings.menuTitles.redo + '"><i class="icon-uniE98E"></i></div></div>').click(function(){ $canvas.undoNext(); })); break;
					case 'clear': menuContent.append($('<div class="_wPaint_icon _wPaint_clear" title="' + $canvas.settings.menuTitles.clear + '"><i class="icon-uniE9D5"></i></div>').click(function(){ $canvas.clearAll(); })); break;
					case 'rectangle': menuContent.append($('<div class="_wPaint_icon _wPaint_rectangle" title="' + $canvas.settings.menuTitles.rectangle + '"><i class="icon-uniEA7C"></i></div>').click(function(){ _self.set_mode(_self, $canvas, 'Rectangle'); })); break;
					case 'ellipse': menuContent.append($('<div class="_wPaint_icon _wPaint_ellipse" title="' + $canvas.settings.menuTitles.ellipse + '"><i class="icon-uniEA7F"></i></div>').click(function(){ _self.set_mode(_self, $canvas, 'Ellipse'); })); break;
					case 'line': menuContent.append($('<div class="_wPaint_icon _wPaint_line" title="' + $canvas.settings.menuTitles.line + '"><i class="icon-uniEA34"></i></div>').click(function(){ _self.set_mode(_self, $canvas, 'Line'); })); break;
					case 'pencil': menuContent.append($('<div class="_wPaint_icon _wPaint_pencil" title="' + $canvas.settings.menuTitles.pencil + '"><i class="icon-uniF1FC"></i></div>').click(function(){ _self.set_mode(_self, $canvas, 'Pencil'); })); break;
					case 'text': menuContent.append($('<div class="_wPaint_icon _wPaint_text" title="' + $canvas.settings.menuTitles.text + '"><i class="icon-uniE6FA"></i></div>').click(function(){ _self.set_mode(_self, $canvas, 'Text'); })); break;
					case 'eraser': menuContent.append($('<div class="_wPaint_icon _wPaint_eraser" title="' + $canvas.settings.menuTitles.eraser + '"><i class="icon-uniF12D"></i></div>').click(function(e){ _self.set_mode(_self, $canvas, 'Eraser'); })); break;
					case 'fillColor': menuContent.append($('<div class="_wPaint_fillColorPicker _wPaint_colorPicker" title="' + $canvas.settings.menuTitles.fillColor + '"></div>')); break;
					case 'lineWidth': menuContent.append(lineWidth); break;
					case 'strokeColor': menuContent.append($('<div class="_wPaint_strokeColorPicker _wPaint_colorPicker" title="' + $canvas.settings.menuTitles.strokeColor + 'r"></div>')); break;
				}
			});


			//get position of canvas
			//var offset = $($canvas.canvas).offset();

			//menu
			return this.menu =
				$('<div class="_wPaint_menu _wPaint_menu_' + $canvas.settings.menuOrientation + '"></div>')
					.css({left: $canvas.settings.menuOffsetX + 4, top: 0})
					.append(menuContent);
		},

		moveTextMenu: function(mainMenu, textMenu)
		{
			if(textMenu.docked)
			{
				textMenu.menu.css({left: parseInt(mainMenu.menu.css('left')) + textMenu.dockOffsetLeft, top: parseInt(mainMenu.menu.css('top')) + textMenu.dockOffsetTop});
			}
		},

		set_mode: function(_self, $canvas, mode)
		{
			$canvas.settings.mode = mode;

			if(mode == 'Text')
			{
				_self.textMenu.menu.show();
				_self.setWidth($canvas, _self.textMenu.menu);
			}
			else
			{
				$canvas.drawTextUp(null, $canvas);
				_self.textMenu.menu.hide();
				$canvas.textInput.hide();
			}

			_self.menu.find("._wPaint_icon").removeClass('active');
			_self.menu.find("._wPaint_" + mode.toLowerCase()).addClass('active');
		},

		setWidth: function(canvas, menu)
		{
			var options = menu.find('._wPaint_options');

			if(canvas.settings.menuOrientation === 'vertical')
			{
				// set proper width
				var width = menu.find('._wPaint_options > div:first').outerWidth(true);
				width += (options.outerWidth(true) - options.width());

				//set proper height
			}
			else
			{
				var  width = menu.outerWidth(true) - menu.width();

				menu.find('._wPaint_options').children().each(function()
				{
					width += $(this).outerWidth(true);
				});
			}


			menu.width(width);
		}
	};

	/**
	 * Text Helper
	 */
	function TextMenu(canvas)
	{
		this.menu = null;

		this.docked = true;

		this.dockOffsetLeft = canvas.settings.menuOrientation === 'vertical' ? 36 : 0;
		this.dockOffsetTop = canvas.settings.menuOrientation === 'vertical' ? 0 : 36;

		return this;
	}

	TextMenu.prototype =
	{
		generate: function(canvas, mainMenu)
		{
			var $canvas = canvas;
			var _self = this;

			//setup font sizes
			var options = '';
			var start = 4;
			for(var i=$canvas.settings.fontSizeMin; i<=$canvas.settings.fontSizeMax; i++) {
                start = start+4;
                options += '<option value="' + Strack.number_add_zero(start,2) + '" ' + ($canvas.settings.fontSize == i ? 'selected="selected"' : '') + '>' + Strack.number_add_zero(start,2) + '</option>';
			}

			var fontSize = $('<div class="_wPaint_fontSize _wPaint_dropDown" title="' + $canvas.settings.menuTitles.fontSize + '"></div>').append(
				$('<select>' + options + '</select>')
					.change(function(e){
						var fontSize = parseInt($(this).val());
						$canvas.settings.fontSize = fontSize;
						$canvas.textInput.css({fontSize:fontSize, lineHeight:fontSize+'px'});
						$canvas.textCalc.css({fontSize:fontSize, lineHeight:fontSize+'px'});
					})
			);

			//setup font family
			var options = '';
			for(var i=0, ii=$canvas.settings.fontFamilyOptions.length; i<ii; i++) options += '<option value="' + $canvas.settings.fontFamilyOptions[i] + '" ' + ($canvas.settings.fontFamily == $canvas.settings.fontFamilyOptions[i] ? 'selected="selected"' : '') + '>' + $canvas.settings.fontFamilyOptions[i] + '</option>';

			var fontFamily = $('<div class="_wPaint_fontFamily _wPaint_dropDown" title="' + $canvas.settings.menuTitles.fontFamily + '"></div>').append(
				$('<select>' + options + '</select>')
					.change(function(e){
						var fontFamily = $(this).val();
						$canvas.settings.fontFamily = fontFamily;
						$canvas.textInput.css({fontFamily: fontFamily});
						$canvas.textCalc.css({fontFamily: fontFamily});
					})
			);

			//content
			var menuContent =
				$('<div class="_wPaint_options"></div>')
					.append($('<div class="_wPaint_icon _wPaint_bold ' + ($canvas.settings.fontTypeBold ? 'active' : '') + '" title="' + $canvas.settings.menuTitles.bold + '"><i class="icon-uniF032"></i></div>').click(function(){ _self.setType(_self, $canvas, 'Bold'); }))
					.append($('<div class="_wPaint_icon _wPaint_italic ' + ($canvas.settings.fontTypeItalic ? 'active' : '') + '" title="' + $canvas.settings.menuTitles.italic + '"><i class="icon-uniF033"></i></div>').click(function(){ _self.setType(_self, $canvas, 'Italic'); }))
					.append($('<div class="_wPaint_icon _wPaint_underline ' + ($canvas.settings.fontTypeUnderline ? 'active' : '') + '" title="' + $canvas.settings.menuTitles.underline + '"><i class="icon-uniEA8C"></i></div>').click(function(){ _self.setType(_self, $canvas, 'Underline'); }))
					.append(fontSize)
					.append(fontFamily);


			//get position of canvas
			var offset = $($canvas.canvas).offset();

			//menu
			return this.menu =
				$('<div class="_wPaint_menu _wPaint_menu_bgc  _wPaint_menu_' + $canvas.settings.menuOrientation + '""></div>')
					.css({display: 'none', position: 'absolute'})
					.append(menuContent);
		},

		setType: function(_self, $canvas, mode)
		{
			var element = _self.menu.find("._wPaint_" + mode.toLowerCase());
			var isActive = element.hasClass('active');

			$canvas.settings['fontType' + mode] = !isActive;

			isActive ? element.removeClass('active') : element.addClass('active');

			fontTypeBold = $canvas.settings.fontTypeBold ? 'bold' : 'normal';
			fontTypeItalic = $canvas.settings.fontTypeItalic ? 'italic' : 'normal';
			fontTypeUnderline = $canvas.settings.fontTypeUnderline ? 'underline' : 'none';

			$canvas.textInput.css({fontWeight: fontTypeBold}); $canvas.textCalc.css({fontWeight: fontTypeBold});
			$canvas.textInput.css({fontStyle: fontTypeItalic}); $canvas.textCalc.css({fontStyle: fontTypeItalic});
			$canvas.textInput.css({textDecoration: fontTypeUnderline}); $canvas.textCalc.css({textDecoration: fontTypeUnderline});
		}
	}
})(jQuery);

/******************************************
 * Websanova.com
 *
 * Resources for web entrepreneurs
 *
 * @author          Websanova
 * @copyright       Copyright (c) 2012 Websanova.
 * @license         This wChar jQuery plug-in is dual licensed under the MIT and GPL licenses.
 * @github			http://github.com/websanova/wColorPicker
 *
 ******************************************/
(function($)
{	
	$.fn.wColorPicker = function(option, settings)
	{
		if(typeof option === 'object')
		{
			settings = option;
		}
		else if(typeof option === 'string')
		{
			var values = [];

			var elements = this.each(function()
			{
				var data = $(this).data('_wColorPicker');

				if(data)
				{
					if($.fn.wColorPicker.defaultSettings[option] !== undefined)
					{
						if(settings !== undefined) { data.settings[option] = settings; }
						else { values.push(data.settings[option]); }
					}
				}
			});

			if(values.length === 1) { return values[0]; }
			if(values.length > 0) { return values; }
			else { return elements; }
		}

		settings = $.extend({}, $.fn.wColorPicker.defaultSettings, settings || {});
		
		return this.each(function()
		{
			var elem = $(this);	
			var $settings = jQuery.extend(true, {}, settings);
			
			var cp = new ColorPicker($settings, elem);

			cp.generate();

			cp.appendToElement(elem);			
		
			cp.colorSelect(cp, $settings.initColor);

			elem.data('_wColorPicker', cp);
		});
	};

	$.fn.wColorPicker.defaultSettings = {
		theme			: 'black', 		// colors - black, white, cream, red, green, blue, yellow, orange, plum
		opacity			: 0.8,			// opacity level
		initColor		: '#FF0000',	// initial colour to set palette to
		onMouseover		: null,			// function to run when palette color is moused over
		onMouseout		: null,			// function to run when palette color is moused out
		onSelect		: null,			// function to run when palette color is selected
		mode			: 'flat',		// flat mode inserts the palette to container, other modes insert button into container - hover, click
		buttonSize		: 20,			// size of button if mode is ohter than flat
		effect			: 'slide',		// none/slide/fade
		showSpeed		: 500,			// time to run the effects on show
		hideSpeed		: 500			// time to run the effects on hide
	};

	/**
	 * ColorPicker class definition
	 */
	function ColorPicker(settings, elem)
	{ 
		this.colorPicker = null;
		this.settings = settings;
		this.$elem = elem;
		this.currentColor = settings.initColor;
		
		this.height = null;					// init this, need to get height/width proper while element is still showing
		this.width = null;
		this.slideTopToBottom = null;		// used to assist with sliding in proper direction
		
		this.customTarget = null;			
		this.buttonColor = null;
		this.paletteHolder = null;
		
		return this;
	}
	
	ColorPicker.prototype =
	{
		generate: function ()
		{
			if(this.colorPicker) return this.colorPicker;

			var $this = this;

			var clearFloats = {clear: 'both', height: 0, lineHeight: 0, fontSize: 0}; 

			//custom colors
			this.customTarget = $('<div class="_wColorPicker_customTarget"></div>');
			this.customInput =
			$('<input type="text" class="_wColorPicker_customInput" value=""/>').keyup(function(e)
			{
				var code = (e.keyCode ? e.keyCode : e.which);
				
				var hex = $this.validHex($(this).val());
				
				$(this).val(hex);
				
				//auto set color in target if it's valid hex code
				if(hex.length == 7) $this.customTarget.css('backgroundColor', hex);
				
				if(code == 13)//set color if user hits enter while on input
				{
					$this.colorSelect($this, $(this).val());
					if($this.buttonColor) $this.hidePalette($this)
				}
			})
			.click(function(e){e.stopPropagation();});
			
			//setup custom area
			var custom = 
			$('<div class="_wColorPicker_custom"></div>')
			.append(this.appendColors($('<div class="_wColorPicker_noColor">'), [''], 1))
			.append(this.customTarget)
			.append(this.customInput)
			//clear floats
			.append($('<div></div>').css(clearFloats));

			//grays/simple palette
			var simpleColors = ['000000', '333333', '666666', '999999', 'CCCCCC', 'FFFFFF', 'FF0000', '00FF00', '0000FF', 'FFFF00', '00FFFF', 'FF00FF'];
			var simplePalette = this.appendColors($('<div class="_wColorPicker_palette_simple"></div>'), simpleColors, 1);
			
			//colors palette
			var mixedColors = [
				'000000', '003300', '006600', '009900', '00CC00', '00FF00', '330000', '333300', '336600', '339900', '33CC00', '33FF00', '660000', '663300', '666600', '669900', '66CC00', '66FF00',
				'000033', '003333', '006633', '009933', '00CC33', '00FF33', '330033', '333333', '336633', '339933', '33CC33', '33FF33', '660033', '663333', '666633', '669933', '66CC33', '66FF33',
				'000066', '003366', '006666', '009966', '00CC66', '00FF66', '330066', '333366', '336666', '339966', '33CC66', '33FF66', '660066', '663366', '666666', '669966', '66CC66', '66FF66',
				'000099', '003399', '006699', '009999', '00CC99', '00FF99', '330099', '333399', '336699', '339999', '33CC99', '33FF99', '660099', '663399', '666699', '669999', '66CC99', '66FF99',
				'0000CC', '0033CC', '0066CC', '0099CC', '00CCCC', '00FFCC', '3300CC', '3333CC', '3366CC', '3399CC', '33CCCC', '33FFCC', '6600CC', '6633CC', '6666CC', '6699CC', '66CCCC', '66FFCC',
				'0000FF', '0033FF', '0066FF', '0099FF', '00CCFF', '00FFFF', '3300FF', '3333FF', '3366FF', '3399FF', '33CCFF', '33FFFF', '6600FF', '6633FF', '6666FF', '6699FF', '66CCFF', '66FFFF',
				'990000', '993300', '996600', '999900', '99CC00', '99FF00', 'CC0000', 'CC3300', 'CC6600', 'CC9900', 'CCCC00', 'CCFF00', 'FF0000', 'FF3300', 'FF6600', 'FF9900', 'FFCC00', 'FFFF00',
				'990033', '993333', '996633', '999933', '99CC33', '99FF33', 'CC0033', 'CC3333', 'CC6633', 'CC9933', 'CCCC33', 'CCFF33', 'FF0033', 'FF3333', 'FF6633', 'FF9933', 'FFCC33', 'FFFF33',
				'990066', '993366', '996666', '999966', '99CC66', '99FF66', 'CC0066', 'CC3366', 'CC6666', 'CC9966', 'CCCC66', 'CCFF66', 'FF0066', 'FF3366', 'FF6666', 'FF9966', 'FFCC66', 'FFFF66',
				'990099', '993399', '996699', '999999', '99CC99', '99FF99', 'CC0099', 'CC3399', 'CC6699', 'CC9999', 'CCCC99', 'CCFF99', 'FF0099', 'FF3399', 'FF6699', 'FF9999', 'FFCC99', 'FFFF99',
				'9900CC', '9933CC', '9966CC', '9999CC', '99CCCC', '99FFCC', 'CC00CC', 'CC33CC', 'CC66CC', 'CC99CC', 'CCCCCC', 'CCFFCC', 'FF00CC', 'FF33CC', 'FF66CC', 'FF99CC', 'FFCCCC', 'FFFFCC',
				'9900FF', '9933FF', '9966FF', '9999FF', '99CCFF', '99FFFF', 'CC00FF', 'CC33FF', 'CC66FF', 'CC99FF', 'CCCCFF', 'CCFFFF', 'FF00FF', 'FF33FF', 'FF66FF', 'FF99FF', 'FFCCFF', 'FFFFFF',
			];
			var mixedPalette = this.appendColors($('<div class="_wColorPicker_palette_mixed"></div>'), mixedColors, 18);
			
			//palette container
			var bg = $('<div class="_wColorPicker_bg"></div>').css({opacity: this.settings.opacity});
			var content =
			$('<div class="_wColorPicker_content"></div>')			
			.append(custom)
			.append(simplePalette)
			.append(mixedPalette)
			.append($('<div></div>').css(clearFloats));
			
			//put it all together
			this.colorPicker =
			$('<div class="_wColorPicker_holder"></div>')
			.click(function(e){e.stopPropagation();})
			.append(
				$('<div class="_wColorPicker_outer"></div>')
				.append(
					$('<div class="_wColorPicker_inner"></div>')
					.append( bg )
					.append( content )
				)
			)
			.addClass('_wColorPicker_' + this.settings.theme);
			
			return this.colorPicker;
		},
		
		appendColors: function($palette, colors, lineCount)
		{
			var counter = 1;
			var $this = this;
			
			for(index in colors)
			{
				$palette.append(
					$('<div id="_wColorPicker_color_' + counter + '" class="_wColorPicker_color _wColorPicker_color_' + counter + '"></div>').css('backgroundColor', '#' + colors[index])
					.click(function(){$this.colorSelect($this, $(this).css('backgroundColor'));})
					.mouseout(function(e){$this.colorHoverOff($this, $(this));})
					.mouseover(function(){$this.colorHoverOn($this, $(this));})
				);
				
				if(counter == lineCount)
				{
					$palette.append($('<div></div>').css({clear:'both', height:0, fontSize:0, lineHeight:0, marginTop:-1}));
					counter = 0;
				}
				
				counter++;
			}
			
			return $palette;
		},
		
		colorSelect: function($this, color)
		{
			color = $this.toHex(color);
			
			$this.customTarget.css('backgroundColor', color);
			$this.currentColor = color;
			$this.customInput.val(color);
			
			if($this.settings.onSelect) $this.settings.onSelect.apply(this, [color]);
			
			if($this.buttonColor)
			{
				$this.buttonColor.css('backgroundColor', color);
				$this.hidePalette($this);
			} 
		},
		
		colorHoverOn: function($this, $element)
		{
			$element.parent().children('active').removeClass('active');
			$element.addClass('active').next().addClass('activeLeft');
			$element.nextAll('.' + $element.attr('id') + ':first').addClass('activeTop');
			
			var color = $this.toHex($element.css('backgroundColor'));
			
			$this.customTarget.css('backgroundColor', color);
			$this.customInput.val(color);
			
			if($this.settings.onMouseover) $this.settings.onMouseover.apply(this, [color]);
		},
		
		colorHoverOff: function($this, $element)
		{
			$element.removeClass('active').next().removeClass('activeLeft');
			$element.nextAll('.' + $element.attr('id') + ':first').removeClass('activeTop');
			
			$this.customTarget.css('backgroundColor', $this.currentColor);
			$this.customInput.val($this.currentColor);
			
			if($this.settings.onMouseout) $this.settings.onMouseout.apply(this, [$this.currentColor]);
		},
		
		appendToElement: function($element)
		{
			var $this = this;
			
			if($this.settings.mode == 'flat') $element.append($this.colorPicker);
			else
			{
				//setup button
				$this.paletteHolder = $('<div class="_wColorPicker_paletteHolder"></div>').css({position: 'absolute', overflow: 'hidden', width: 1000}).append($this.colorPicker);
				
				$this.buttonColor = $('<div class="_wColorPicker_buttonColor"></div>').css({width: $this.settings.buttonSize, height: $this.settings.buttonSize});
				
				var buttonHolder =
				$('<div class="_wColorPicker_buttonHolder"></div>')
				.css({position: 'relative'})
				.append($('<div class="_wColorPicker_buttonBorder"></div>').append($this.buttonColor))
				.append($this.paletteHolder);

				$element.append(buttonHolder);
				
				$this.width = $this.colorPicker.outerWidth(true);
				$this.height = $this.colorPicker.outerHeight(true);
				$this.paletteHolder.css({width: 280, height: 280}).hide();
				
				if($this.settings.effect == 'fade') $this.paletteHolder.css({opacity: 0});
				
				//setup events
				if($this.settings.mode == 'hover')
				{
					buttonHolder.hover(
						function(e){$this.showPalette(e, $this);},
						function(e){$this.hidePalette($this);}
					)
				}
				else if($this.settings.mode == 'click')
				{
					$(document).click(function(){if($this.paletteHolder.hasClass('active'))$this.hidePalette($this);});
					
					buttonHolder
					.click(function(e)
					{
						e.stopPropagation();
						$this.paletteHolder.hasClass('active') ? $this.hidePalette($this) : $this.showPalette(e, $this);
					});
				}
				
				$this.colorSelect($this, $this.settings.initColor);
			}
		},
		
		showPalette: function(e, $this)
		{
			var offset = $this.paletteHolder.parent().offset();
			
			//init some vars
			var left = 0;
			var top = $this.paletteHolder.parent().outerHeight(true);
			$this.slideTopToBottom = top;
			
			if(offset.left - $(window).scrollLeft() + $this.width > $(window).width()) left = -1 * ($this.width - $this.paletteHolder.parent().outerWidth(true));
			if(offset.top - $(window).scrollTop() + $this.height > $(window).height())
			{
				$this.slideTopToBottom = 0;
				top = -1 * ($this.height);
			}
			
			$this.paletteHolder.css({left: left, top: top});
			
			$this.paletteHolder.addClass('active');

			if($this.settings.effect == 'slide')
			{
				$this.paletteHolder.stop(true, false).css({height: 0, top: ($this.slideTopToBottom == 0 ? 0 : top)}).show().animate({height: 280, top: top}, $this.settings.showSpeed);
			}
			else if($this.settings.effect == 'fade')
			{
				$this.paletteHolder.stop(true, false).show().animate({opacity: 1}, $this.settings.showSpeed);
			}
			else
			{
				$this.paletteHolder.show();
			}
		},
		
		hidePalette: function($this)
		{
			//need this to avoid the double hide when you click on colour (once on click, once on mouse out) - this way it's only triggered once
			if($this.paletteHolder.hasClass('active'))
			{
				$this.paletteHolder.removeClass('active');
				
				if($this.settings.effect == 'slide')
				{
					$this.paletteHolder.stop(true, false).animate({height: 0, top: ($this.slideTopToBottom == 0 ? 0 : $this.slideTopToBottom)}, $this.settings.hideSpeed, function(){$this.paletteHolder.hide()});
				}
				else if($this.settings.effect == 'fade')
				{
					$this.paletteHolder.stop(true, false).animate({opacity: 0}, $this.settings.hideSpeed, function(){$this.paletteHolder.hide()});
				}
				else
				{
					$this.paletteHolder.hide();
				}
			}
		},
		
		toHex: function(color)
		{
			if(color.substring(0,4) === 'rgba')
			{
				hex = 'transparent';
			}
			else if(color.substring(0,3) === 'rgb')
			{
				var rgb = color.substring(4, color.length - 1).replace(/\s/g, '').split(',');
				
				for(i in rgb)
				{
					rgb[i] = parseInt(rgb[i]).toString(16);
					if(rgb[i] == '0') rgb[i] = '00';
				}
				
				var hex = '#' + rgb.join('').toUpperCase();
			}
			else
			{
				hex = color;
			}

			return  hex;
		},
		
		validHex: function(hex)
		{			
			return '#' + hex.replace(/[^0-9a-f]/ig, '').substring(0,6).toUpperCase();
		}
	}

})(jQuery);
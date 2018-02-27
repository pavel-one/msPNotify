if (typeof(modPNotify) == 'undefined') {
	modPNotify = {
		Init: false
	};
}

modPNotifyConfig = {
	assetsUrl: '/assets/components/mspnnotify/js/pn/',
	defaults: {
		message: {
			title: {
				success: 'Успешно',
				error: 'Ошибка',
				info: 'Внимание'
			}
		},
		yes: 'Да',
		no: 'Нет'
	}
};

modPNotify = {
	initialize: function () {
		if (!jQuery().pnotify) {
			document.write('<script src="' + modPNotifyConfig.assetsUrl + 'pnotify.custom.js"><\/script>');
			$('<link/>', {
				rel: 'stylesheet',
				type: 'text/css',
				href: modPNotifyConfig.assetsUrl + 'pnotify.custom.css'
			}).appendTo('head');
		}

		$(document).ready(function () {
			PNotify.prototype.options.styling = "brighttheme";

		});
		modPNotify.Init = true;
	}
};


modPNotify.Message = {
	defaults: {
		delay: 4000,
		addclass: 'modPNotify-message',
		styling: 'brighttheme',
		icons: 'brighttheme',
	},
	success: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'success';
		notify.text = message;
		notify.title = (!title) ? 'Успешно' : title;
		new PNotify($.extend({}, this.defaults, notify));
	},
	error: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'error';
		notify.text = message;
		notify.title = (!title) ? 'Ошибка' : title;
		new PNotify($.extend({}, this.defaults, notify));
	},
	info: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'info';
		notify.text = message;
		notify.title = (!title) ? 'Внимание' : title;
		new PNotify($.extend({}, this.defaults, notify));
	},
	remove: function () {
		PNotify.removeAll();
	}
};

modPNotify.Confirm = {
	defaults: {
		hide: false,
		addclass: 'modPNotify-сonfirm',
		icon: 'glyphicon glyphicon-question-sign',
		confirm: {
			confirm: true,
			buttons: [{
				text: modPNotifyConfig.defaults.yes,
				addClass: 'btn-primary'

			}, {
				text: modPNotifyConfig.defaults.no,
				addClass: 'btn-danger'

			}]
		},
		buttons: {
			closer: false,
			sticker: false
		},
		history: {
			history: false
		}
	},
	success: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'success';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.confirm.title.success : title;
		return new PNotify($.extend({}, this.defaults, notify));
	},
	error: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'error';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.confirm.title.error : title;
		return new PNotify($.extend({}, this.defaults, notify));
	},
	info: function (title, message) {
		if (!message) return false;
		var notify = {};
		notify.type = 'info';
		notify.text = message;
		notify.title = (!title) ? modPNotifyConfig.defaults.confirm.title.info : title;
		return new PNotify($.extend({}, this.defaults, notify));
	},
	form: function (form, type, title, message) {
		if (!type) return false;
		if (form) {
			$.extend(this.defaults, {
				before_init: function (opts) {
					$(form).find('input[type="button"], button, a').attr('disabled', true);
				},
				after_close: function (PNotify, timer_hide) {
					$(form).find('input[type="button"], button, a').attr('disabled', false);
				}
			});
		}

		switch (type) {
			case 'success':
				return this.success(title, message);
			default:
			case 'error':
				return this.error(title, message);
			case 'info':
				return this.info(title, message);
		}
	},
	remove: function () {
		return PNotify.removeAll();
	}
};

modPNotify.initialize();

if (typeof(miniShop2) != 'undefined') {
    miniShop2.Message = {
        initialize: function () {
            miniShop2.Message.close = function () {
            };
            miniShop2.Message.show = function (message) {
                if (message != '') {
                    alert(message);
                }
            };
        },
        success: function (message) {
            miniShop2.Message.show(message, {
                theme: 'ms2-message-success',
                sticky: false
            });
        },
        error: function (message) {
            miniShop2.Message.show(message, {
                theme: 'ms2-message-error',
                sticky: false
            });
        },
        info: function (message) {
            miniShop2.Message.show(message, {
                theme: 'ms2-message-info',
                sticky: false
            });
        }
    };
}
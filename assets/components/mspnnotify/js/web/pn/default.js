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

jQuery(document).ready(function($) {
	if (typeof(miniShop2) != 'undefined') {
        miniShop2.Message = {
            initialize: function() {
                miniShop2.Message.close = function() {};
                miniShop2.Message.show = function(message) {
                    if (message != '') {
                        alert(message);
                    }
                };
    
    
                miniShop2.Message.close = function() {
                    PNotify.removeAll()
                };
                miniShop2.Message.show = function(message, options) {
                    if (message != '') {
                        new PNotify(options);
                    }
                }
    
            },
            success: function(message) {
                miniShop2.Message.show(message, {
                    addclass: 'modPNotify-message',
            		styling: 'brighttheme',
            		icons: 'brighttheme',
                    delay: 2000,
                    text: message,
                    type: 'success',
                    title: 'Успешно',
                    hide: true,
                });
            },
            error: function(message) {
                miniShop2.Message.show(message, {
                    addclass: 'modPNotify-message',
            		styling: 'brighttheme',
            		icons: 'brighttheme',
                    delay: 2000,
                    text: message,
                    type: 'error',
                    title: 'Ошибка',
                    hide: true,
                });
            },
            info: function(message) {
                miniShop2.Message.show(message, {
                    addclass: 'modPNotify-message',
            		styling: 'brighttheme',
            		icons: 'brighttheme',
                    delay: 2000,
                    text: message,
                    type: 'info',
                    title: 'Внимание',
                    hide: true,
                });
            }
        };
	}
	if (typeof(Office) != 'undefined') {
		Office.Message = {
		    success: function (message, sticky) {
		        modPNotify.Message.success('',message);
		    },
		    error: function (message, sticky) {
		        modPNotify.Message.error('',message);
		    },
		    info: function (message, sticky) {
		        modPNotify.Message.info('',message);
		    },
		    close: function () {
		        PNotify.removeAll();
		    }
		};
	}
	if (typeof(AjaxForm) != 'undefined') {
		AjaxForm.Message = {
		    success: function (message, sticky) {
		        if (message) {
		            modPNotify.Message.success('',message);
		        }
		    },
		    error: function (message, sticky) {
		        if (message) {
		            modPNotify.Message.error('',message);
		        }
		    },
		    info: function (message, sticky) {
		        if (message) {
		            modPNotify.Message.info('',message);
		        }
		    },
		    close: function () {
		        PNotify.removeAll();
		    },
		};
	}
});